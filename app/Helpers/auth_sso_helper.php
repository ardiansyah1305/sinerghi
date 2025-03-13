<?php

/** SSO Authentication Helper Functions */
if (!function_exists('generateToken')) {
    /**
     * Generate a token for SSO authentication
     *
     * @return string
     */
    function generateToken()
    {
        $ssoClientKey = 'def456ppo-client-id-987uan';
        $ssoClientSecret = 'r4h4s!4K3y-987poiuytrewq%$#@!';

        $timestamp = round(microtime(true) * 1000);
        $data = "$ssoClientKey:$timestamp";
        $hmac = hash_hmac('sha256', $data, $ssoClientSecret);

        return base64_encode("$ssoClientKey:$timestamp:$hmac");
    }
}

if (!function_exists('generateRequestId')) {
    /**
     * Generate a request ID for SSO authentication
     *
     * @param string $token
     * @return string|false
     */
    function generateRequestId($token)
    {
        try {
            $ssoUrl = 'https://192.168.10.211';
            $clientKey = 'def456ppo-client-id-987uan';
            $clientSecret = 'r4h4s!4K3y-987poiuytrewq%$#@!';

            if (empty($ssoUrl) || empty($clientKey) || empty($clientSecret)) {
                log_message('error', 'SSO configuration missing. Check your .env file.');
                return false;
            }

            // Create options array for curl
            $options = [
                'timeout' => 10,
                'connect_timeout' => 10,
                'verify' => false
            ];

            // Create a new CurlRequest with options
            $client = \Config\Services::curlrequest($options);

            // Prepare request data
            $data = [
                'client_id' => $clientKey,
                'origin' => 'https://satu.kemenkopmk.go.id',
                'redirect_uri' => 'https://satu.kemenkopmk.go.id/sso/callback'
            ];

            // Make the request
            $response = $client
                ->setBody(json_encode($data))
                ->setHeader('Content-Type', 'application/json')
                ->setHeader('Authorization', 'Bearer ' . $token)
                ->post($ssoUrl . '/api/generate');

            // Check if request was successful
            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody(), true);
                if (isset($result['request_id'])) {
                    return $result['request_id'];
                }
                log_message('error', 'Invalid response from SSO server: ' . $response->getBody());
            } else {
                log_message('error', 'SSO server returned status code: ' . $response->getStatusCode());
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'SSO Request ID Generation Error: ' . $e->getCode() . ' : ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('verifyToken')) {
    /**
     * Verify a token with the SSO server
     *
     * @param string $token
     * @return bool
     */
    function verifyToken($token)
    {
        try {
            if (empty($token)) {
                return false;
            }

            $ssoUrl = rtrim(getenv('SSO_IP_LOCAL') ?: getenv('SSO_URL'), '/');

            if (empty($ssoUrl)) {
                log_message('error', 'SSO URL not configured. Check your .env file.');
                return false;
            }

            // Create options array for curl
            $options = [
                'timeout' => 10,
                'connect_timeout' => 10,
                'verify' => false
            ];

            // Create a new CurlRequest with options
            $client = \Config\Services::curlrequest($options);

            // Make the request
            $response = $client
                ->setBody(json_encode(['token' => $token]))
                ->setHeader('Content-Type', 'application/json')
                ->post($ssoUrl . '/api/verify');

            // Check if request was successful
            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody(), true);
                return isset($result['valid']) && $result['valid'];
            }

            log_message('error', 'SSO server returned status code: ' . $response->getStatusCode());
            return false;
        } catch (\Exception $e) {
            log_message('error', 'SSO Token Verification Error: ' . $e->getCode() . ' : ' . $e->getMessage());

            // For timeout errors, assume the token is still valid
            // This prevents users from being logged out when SSO server is temporarily unavailable
            if ($e->getCode() == 28 || strpos($e->getMessage(), 'timed out') !== false) {
                log_message('info', 'SSO server timeout. Assuming token is still valid.');
                return true;
            }

            return false;
        }
    }
}

if (!function_exists('getUserDataFromSSO')) {
    /**
     * Get user data from SSO token
     *
     * @param string $token
     * @return array|false
     */
    function getUserDataFromSSO($token)
    {
        try {
            if (empty($token)) {
                return false;
            }

            $ssoUrl = "https://192.168.10.211";

            if (empty($ssoUrl)) {
                log_message('error', 'SSO URL not configured. Check your .env file.');
                return false;
            }

            // Create options array for curl
            $options = [
                'timeout' => 10,
                'connect_timeout' => 10,
                'verify' => false
            ];

            // Create a new CurlRequest with options
            $client = \Config\Services::curlrequest($options);

            // Make the request
            $response = $client
                ->setBody(json_encode(['token' => $token]))
                ->setHeader('Content-Type', 'application/json')
                ->setHeader('Authorization', 'Bearer ' . $token)
                ->post($ssoUrl . '/api/verify');

            // Check if request was successful
            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody(), true);
                
                // If the API returns the data in a nested structure, extract it
                if (isset($result['data'])) {
                    $result = $result['data'];
                }
                
                // Map the response to a standard format if needed
                if (!isset($result['username']) && isset($result['username_ldap'])) {
                    $result['username'] = $result['username_ldap'];
                }
                
                log_message('debug', 'SSO User data received: ' . json_encode($result));
                return $result;
            }

            log_message('error', 'SSO server returned status code: ' . $response->getStatusCode() . ' with body: ' . $response->getBody());
            return false;
        } catch (\Exception $e) {
            log_message('error', 'SSO User Data Error: ' . $e->getCode() . ' : ' . $e->getMessage());
            return false;
        }
    }

    if (!function_exists('ssoLogout')) {
        /**
         * Logout from SSO and destroy session
         *
         * @return \CodeIgniter\HTTP\RedirectResponse
         */
        function ssoLogout()
        {
            $session = session();
            $ssoUrl = rtrim(getenv('SSO_URL'), '/');
            
            // Destroy session data
            $session->destroy();
            
            try {
                // Generate SSO token and request ID
                $token = generateToken();
                $requestId = generateRequestId($token);
                
                if (!$requestId) {
                    log_message('error', 'Failed to generate SSO request ID for logout');
                    // Redirect to base SSO logout URL if request ID generation fails
                    return redirect()->to($ssoUrl . '/logout');
                }
                
                // Redirect to SSO logout page with request ID
                return redirect()->to($ssoUrl . '/logout?requestId=' . $requestId);
            } catch (\Exception $e) {
                log_message('error', 'SSO Logout Error: ' . $e->getMessage());
                // Redirect to base SSO logout URL in case of error
                return redirect()->to($ssoUrl . '/logout');
            }
        }
    }
}
