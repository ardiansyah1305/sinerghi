<?php

/**
 * SSO Helper Functions
 * 
 * This file contains helper functions for SSO integration
 */

if (!function_exists('get_server_host')) {
    /**
     * Get the server host URL
     * 
     * @return string
     */
    function get_server_host()
    {
        // Try to get from environment variable
        $serverHost = getenv('SERVER_HOST');
        
        // If not set, use base_url()
        if (!$serverHost) {
            $serverHost = base_url();
        }
        
        return $serverHost;
    }
}

if (!function_exists('get_sso_config')) {
    /**
     * Get SSO configuration
     * 
     * @return array
     */
    function get_sso_config()
    {
        return [
            'sso_url' => getenv('SSO_URL') ?: '',
            'sso_login_url' => getenv('SSO_LOGIN_URL') ?: '',
            'sso_ip_local' => getenv('SSO_IP_LOCAL') ?: '',
            'client_key' => getenv('SSO_CLIENT_KEY') ?: '',
            'client_secret' => getenv('SSO_CLIENT_SECRET') ?: '',
            'cookie_domain' => getenv('COOKIE_DOMAIN') ?: '',
            'server_host' => get_server_host()
        ];
    }
}
