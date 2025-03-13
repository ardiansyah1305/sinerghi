<?php

// Test user credentials - using the support user we found in LDAP
$testUsername = 'ardi.sipd';
$testPassword = 'kemenkopmk'; // Using the same password as admin for testing

// LDAP settings
$ldapHost = 'ldap://192.168.10.18/phpldapadmin';
$ldapPort = 389;
$baseDn = 'dc=ldap,dc=kemenkopmk,dc=go,dc=id';
$userDn = 'ou=People,dc=ldap,dc=kemenkopmk,dc=go,dc=id';
$adminDn = 'cn=Manager,dc=ldap,dc=kemenkopmk,dc=go,dc=id';
$adminPassword = 'pmkldap';

echo "Testing LDAP Login...\n";
echo "Username: " . $testUsername . "\n";

try {
    // Connect to LDAP
    $ldapConn = ldap_connect($ldapHost, $ldapPort);
    if (!$ldapConn) {
        throw new Exception('Could not connect to LDAP server');
    }

    echo "Connected to LDAP server\n";

    // Set LDAP options
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);

    // First bind with admin credentials
    $adminBind = @ldap_bind($ldapConn, $adminDn, $adminPassword);
    if (!$adminBind) {
        throw new Exception('Admin bind failed: ' . ldap_error($ldapConn));
    }

    echo "Admin bind successful\n";

    // Search for the user
    $filter = "(|(uid=$testUsername)(sAMAccountName=$testUsername))";
    $result = ldap_search($ldapConn, $userDn, $filter);
    
    if (!$result) {
        throw new Exception('Search failed: ' . ldap_error($ldapConn));
    }

    $entries = ldap_get_entries($ldapConn, $result);
    if ($entries['count'] === 0) {
        throw new Exception('User not found');
    }

    echo "User found in LDAP\n";
    echo "DN: " . $entries[0]['dn'] . "\n";

    // Try to bind with user credentials
    $userBind = @ldap_bind($ldapConn, $entries[0]['dn'], $testPassword);
    if (!$userBind) {
        throw new Exception('User authentication failed: ' . ldap_error($ldapConn));
    }

    echo "User authentication successful!\n";
    
    // Display user attributes
    echo "\nUser attributes:\n";
    foreach ($entries[0] as $key => $value) {
        if (is_array($value) && isset($value[0]) && $key !== 'count') {
            echo "$key: " . $value[0] . "\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} finally {
    if (isset($ldapConn)) {
        ldap_close($ldapConn);
        echo "\nLDAP connection closed\n";
    }
}
