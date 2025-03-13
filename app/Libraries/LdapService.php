<?php

namespace App\Libraries;

use Config\Ldap as LdapConfig;

class LdapService
{
    protected $ldapConfig;
    protected $connection;
    protected $bound = false;

    public function __construct()
    {
        $this->ldapConfig = new LdapConfig();
        $this->connect();
    }

    protected function connect()
    {
        if (!function_exists('ldap_connect')) {
            throw new \RuntimeException('LDAP extension is not installed');
        }

        $this->connection = ldap_connect($this->ldapConfig->host, $this->ldapConfig->port);
        if (!$this->connection) {
            throw new \RuntimeException('Could not connect to LDAP server');
        }

        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
    }

    public function authenticate($username, $password)
    {
        try {
            // First bind with admin credentials
            $adminBind = @ldap_bind($this->connection, $this->ldapConfig->adminDn, $this->ldapConfig->adminPassword);
            if (!$adminBind) {
                log_message('error', 'LDAP admin bind failed: ' . ldap_error($this->connection));
                return false;
            }

            // Search for user
            $filter = sprintf($this->ldapConfig->userFilter, ldap_escape($username, "", LDAP_ESCAPE_FILTER));
            $search = ldap_search($this->connection, $this->ldapConfig->userDn, $filter, $this->ldapConfig->attributes);
            
            if (!$search) {
                log_message('error', 'LDAP search failed: ' . ldap_error($this->connection));
                return false;
            }

            $entries = ldap_get_entries($this->connection, $search);
            if ($entries['count'] !== 1) {
                log_message('error', 'User not found or multiple users found');
                return false;
            }

            // Try to bind with user credentials
            $userDn = $entries[0]['dn'];
            $userBind = @ldap_bind($this->connection, $userDn, $password);
            
            if (!$userBind) {
                log_message('error', 'User bind failed: ' . ldap_error($this->connection));
                return false;
            }

            // Return user data
            return [
                'username' => $entries[0]['uid'][0],
                'name' => $entries[0]['displayname'][0] ?? $entries[0]['cn'][0],
                'email' => $entries[0]['mail'][0] ?? null,
            ];

        } catch (\Exception $e) {
            log_message('error', 'LDAP authentication error: ' . $e->getMessage());
            return false;
        }
    }

    public function __destruct()
    {
        if ($this->connection) {
            ldap_close($this->connection);
        }
    }
}
