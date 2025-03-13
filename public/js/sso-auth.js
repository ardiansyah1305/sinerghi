/**
 * SSO Authentication Helper for CodeIgniter 4
 * This script provides client-side functionality for SSO integration
 */

class SSOAuth {
    constructor(config = {}) {
        this.config = {
            ssoBaseUrl: config.ssoBaseUrl || '',
            ssoLoginUrl: config.ssoLoginUrl || '',
            cookieName: config.cookieName || 'sso_session',
            redirectUrl: config.redirectUrl || window.location.origin,
            ...config
        };
    }

    /**
     * Check if user is authenticated via SSO
     * @returns {boolean}
     */
    isAuthenticated() {
        return this.getToken() !== null;
    }

    /**
     * Get SSO token from cookie
     * @returns {string|null}
     */
    getToken() {
        return this.getCookie(this.config.cookieName);
    }

    /**
     * Get a cookie value by name
     * @param {string} name - Cookie name
     * @returns {string|null}
     */
    getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    /**
     * Redirect to SSO login page
     * @param {string} requestId - Request ID from SSO server
     */
    redirectToSSOLogin(requestId) {
        if (!requestId) {
            console.error('SSO Request ID is required');
            return;
        }
        
        window.location.href = `${this.config.ssoBaseUrl}${this.config.ssoLoginUrl}${requestId}`;
    }

    /**
     * Handle SSO callback with token
     * @param {string} token - SSO token
     * @returns {Promise<Object>}
     */
    async handleCallback(token) {
        if (!token) {
            throw new Error('SSO token is required');
        }
        
        try {
            // Send token to backend for verification
            const response = await fetch('/sso/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ token })
            });
            
            return await response.json();
        } catch (error) {
            console.error('SSO callback error:', error);
            throw error;
        }
    }

    /**
     * Logout from SSO
     */
    logout() {
        // Clear SSO cookie
        document.cookie = `${this.config.cookieName}=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;`;
        
        // Redirect to logout page
        window.location.href = '/logout';
    }
}

// Initialize SSO Auth with configuration from the page
document.addEventListener('DOMContentLoaded', () => {
    // Get SSO config from data attributes or global variable
    const ssoConfig = window.ssoConfig || {};
    
    // Initialize SSO Auth
    window.ssoAuth = new SSOAuth(ssoConfig);
    
    // Check for token in URL (for callback handling)
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    
    if (token) {
        // Handle SSO callback
        window.ssoAuth.handleCallback(token)
            .then(result => {
                if (result.success) {
                    // Redirect to dashboard or intended page
                    window.location.href = result.redirect || '/';
                } else {
                    console.error('SSO authentication failed:', result.message);
                    // Show error message
                    if (document.getElementById('sso-error')) {
                        document.getElementById('sso-error').textContent = result.message;
                        document.getElementById('sso-error').style.display = 'block';
                    }
                }
            })
            .catch(error => {
                console.error('SSO callback error:', error);
            });
    }
    
    // Add event listener to logout button if exists
    const logoutBtn = document.getElementById('sso-logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.ssoAuth.logout();
        });
    }
});
