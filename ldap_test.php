<?php

require 'app/Config/Ldap.php';

// Create an instance of the LDAP config
$ldapConfig = new Config\Ldap();

echo "Testing LDAP Connection...\n";
echo "LDAP Host: " . $ldapConfig->host . "\n";
echo "LDAP Port: " . $ldapConfig->port . "\n";
echo "Base DN: " . $ldapConfig->baseDn . "\n";
echo "User DN: " . $ldapConfig->userDn . "\n";

// Try to connect to LDAP server
$ldapConn = ldap_connect($ldapConfig->host, $ldapConfig->port);

if (!$ldapConn) {
    die("Could not connect to LDAP server\n");
}

echo "Successfully connected to LDAP server\n";

// Set LDAP options
ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

// Try to bind with admin credentials
try {
    $ldapBind = ldap_bind($ldapConn, $ldapConfig->adminDn, $ldapConfig->adminPassword);
    if ($ldapBind) {
        echo "Successfully authenticated with admin credentials\n";
        
        // Try to search for users
        $searchFilter = "(objectClass=*)";
        $searchResult = ldap_search($ldapConn, $ldapConfig->userDn, $searchFilter);
        
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
        }
    } else {
        echo "Authentication failed\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    if ($ldapConn) {
        ldap_close($ldapConn);
        echo "\nLDAP connection closed\n";
    }
}
