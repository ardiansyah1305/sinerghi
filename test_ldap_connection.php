<?php

// LDAP server settings
$ldapHost = 'ldap://192.168.10.18/phpldapadmin';
$ldapPort = 389;
$ldapBaseDn = 'dc=ldap,dc=kemenkopmk,dc=go,dc=id';
$ldapUserDn = 'ou=People,dc=ldap,dc=kemenkopmk,dc=go,dc=id';
$ldapAdminDn = 'cn=Manager,dc=ldap,dc=kemenkopmk,dc=go,dc=id';
$ldapAdminPassword = 'pmkldap';

echo "Testing LDAP Connection...\n";
echo "LDAP Host: " . $ldapHost . "\n";
echo "LDAP Port: " . $ldapPort . "\n";
echo "Base DN: " . $ldapBaseDn . "\n";
echo "User DN: " . $ldapUserDn . "\n";

// Check if LDAP extension is loaded
if (!function_exists('ldap_connect')) {
    die("PHP LDAP extension is not installed\n");
}

// Try to connect to LDAP server
$ldapConn = ldap_connect($ldapHost, $ldapPort);

if (!$ldapConn) {
    die("Could not connect to LDAP server\n");
}

echo "Successfully connected to LDAP server\n";

// Set LDAP options
ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

// Try to bind with admin credentials
try {
    $ldapBind = @ldap_bind($ldapConn, $ldapAdminDn, $ldapAdminPassword);
    if ($ldapBind) {
        echo "Successfully authenticated with admin credentials\n";
        
        // Try to search for users
        $searchFilter = "(objectClass=*)";
        $searchResult = ldap_search($ldapConn, $ldapUserDn, $searchFilter);
        
        if ($searchResult) {
            $entries = ldap_get_entries($ldapConn, $searchResult);
            echo "Found " . $entries["count"] . " entries\n";
            
            // Display first few entries
            $limit = min(5, $entries["count"]);
            for ($i = 0; $i < $limit; $i++) {
                echo "\nEntry " . ($i + 1) . ":\n";
                if (isset($entries[$i]["dn"])) {
                    echo "DN: " . $entries[$i]["dn"] . "\n";
                }
                if (isset($entries[$i]["cn"][0])) {
                    echo "CN: " . $entries[$i]["cn"][0] . "\n";
                }
            }
        } else {
            echo "Search failed\n";
            echo "LDAP Error: " . ldap_error($ldapConn) . "\n";
        }
    } else {
        echo "Authentication failed\n";
        echo "LDAP Error: " . ldap_error($ldapConn) . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    if ($ldapConn) {
        ldap_close($ldapConn);
        echo "\nLDAP connection closed\n";
    }
}
