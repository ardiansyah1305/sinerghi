<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Ldap extends BaseConfig
{
    public $host = 'ldap://192.168.10.18';
    public $port = 389;
    public $baseDn = 'dc=ldap,dc=kemenkopmk,dc=go,dc=id';
    public $userDn = 'ou=People,dc=ldap,dc=kemenkopmk,dc=go,dc=id';
    public $adminDn = 'cn=Manager,dc=ldap,dc=kemenkopmk,dc=go,dc=id';
    public $adminPassword = 'pmkldap';
    public $attributes = ['uid', 'cn', 'mail', 'displayname', 'givenname', 'sn', 'sAMAccountName'];
    
    // Filter to search for users, supports both uid and sAMAccountName
    public $userFilter = '(|(uid=%s)(sAMAccountName=%s))';

    public function __construct()
    {
        parent::__construct();

        // Load from environment if available
        $this->host = getenv('LDAP_HOST') ?: $this->host;
        $this->port = getenv('LDAP_PORT') ?: $this->port;
        $this->baseDn = getenv('LDAP_BASE_DN') ?: $this->baseDn;
        $this->userDn = getenv('LDAP_USER_DN') ?: $this->userDn;
        $this->adminDn = getenv('LDAP_ADMIN_DN') ?: $this->adminDn;
        $this->adminPassword = getenv('LDAP_ADMIN_PASSWORD') ?: $this->adminPassword;
        $this->userFilter = getenv('LDAP_USER_FILTER') ?: $this->userFilter;
    }

    /**
     * Get the full LDAP URI including host and port
     */
    public function getUri(): string
    {
        $host = str_replace(['ldap://', 'ldaps://'], '', $this->host);
        return $this->host . ($this->port ? ':' . $this->port : '');
    }
}
