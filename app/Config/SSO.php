<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class SSO extends BaseConfig
{
    /**
     * Base URL of the SSO server
     */
    public $baseUrl = 'http://localhost:8080';
    
    /**
     * Login URL path for SSO
     */
    public $loginUrl = '/auth/login';
    
    /**
     * Local IP or hostname of the SSO server
     */
    public $ipLocal = 'localhost:8080';
    
    /**
     * Client key for SSO authentication
     */
    public $clientKey = 'abc123xyz-client-id-456deg';
    
    /**
     * Client secret for SSO authentication
     */
    public $clientSecret = 's3cr3tK3y-789ghijklmnop-!@#';
    
    /**
     * Cookie domain for SSO session
     */
    public $cookieDomain = '';
    
    /**
     * Server host URL for redirect after SSO authentication
     */
    public $serverHost = '';
    
    /**
     * Cookie name for SSO session
     */
    public $cookieName = 'sso_session';
    
    /**
     * Cookie lifetime in seconds (default: 1 hour)
     */
    public $cookieLifetime = 3600;
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        // Load values from .env file
        $this->baseUrl = getenv('SSO_URL') ?: $this->baseUrl;
        $this->loginUrl = getenv('SSO_LOGIN_URL') ?: $this->loginUrl;
        $this->ipLocal = getenv('SSO_IP_LOCAL') ?: $this->ipLocal;
        $this->clientKey = getenv('SSO_CLIENT_KEY') ?: $this->clientKey;
        $this->clientSecret = getenv('SSO_CLIENT_SECRET') ?: $this->clientSecret;
        $this->cookieDomain = getenv('COOKIE_DOMAIN') ?: $this->cookieDomain;
        
        // Use helper function for server_host if available
        if (function_exists('get_server_host')) {
            $this->serverHost = get_server_host();
        } else {
            $this->serverHost = getenv('SERVER_HOST') ?: base_url();
        }
    }
}
