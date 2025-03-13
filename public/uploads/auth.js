const jwt = require('jsonwebtoken');
const axios = require('axios');
require("dotenv").config();
const crypto = require('crypto');

const SSO_BASE_URL = process.env.SSO_URL;
const SSO_LOGIN_URL = process.env.SSO_LOGIN_URL;
const SSO_IP_LOCAL = process.env.SSO_IP_LOCAL;
const SSO_CLIENT_KEY = process.env.SSO_CLIENT_KEY;
const SSO_CLIENT_SECRET = process.env.SSO_CLIENT_SECRET;
const COOKIE_DOMAIN = process.env.COOKIE_DOMAIN;
const SERVER_HOST = process.env.SERVER_HOST;

function generateToken() {
    const timestamp = Date.now().toString();
    const data = `${SSO_CLIENT_KEY}:${timestamp}`;
    const hmac = crypto.createHmac('sha256', SSO_CLIENT_SECRET).update(data).digest('hex');

    return Buffer.from(`${SSO_CLIENT_KEY}:${timestamp}:${hmac}`).toString('base64');
}

async function generateRequestId(token) {
    console.log("server host: ", SERVER_HOST)
    try {
        const response = await axios.post(SSO_IP_LOCAL+'/api/generate', {
            client_id: SSO_CLIENT_KEY,
            origin: COOKIE_DOMAIN,
            redirect_uri: SERVER_HOST
        }, {
            headers: {
                'Authorization': 'Bearer '+token,
                'Content-Type': 'application/json'
            }
        });

        console.log(response)
        return response.data? response.data.request_id : null;
    } catch (error) {
        throw new Error(error.response ? error.response.data : error.message);
    }
}

const verifyToken = async (req, res, next) => {
    // Check token from cookie or URL query parameter
    const token = req.cookies.sso_session || req.query.token;
    
    if (!token) {
        const genToken = generateToken();
        const requestId = await generateRequestId(genToken);

        console.log(requestId)

        return res.redirect(SSO_BASE_URL+SSO_LOGIN_URL+requestId);
    }

    try {
        // Verify token with SSO server using POST
        const response = await axios.post(`${SSO_IP_LOCAL}/api/verify`, {
            token: token
        });
        if (response.data.valid) {
            // If token was from URL and valid, set it as a cookie
            if (req.query.token && !req.cookies.sso_session) {
                res.cookie('sso_session', token, {
                    httpOnly: true,
                    secure: process.env.NODE_ENV === 'production',
                    sameSite: 'lax'
                });
                // Redirect to remove token from URL
                return res.redirect('/');
            }

            req.user = response.data;
            next();
        } else {
            res.clearCookie('sso_session');
            const genToken = generateToken();
            const requestId = await generateRequestId(genToken);

            return res.redirect(SSO_BASE_URL+SSO_LOGIN_URL+requestId);
        }
    } catch (error) {
        console.error('Token verification error:', error);
        res.clearCookie('sso_session');
        const genToken = generateToken();
        const requestId = await generateRequestId(genToken);
        return res.redirect(SSO_BASE_URL+SSO_LOGIN_URL+requestId);
    }
};

module.exports = {
    verifyToken,
    generateToken,
    generateRequestId
};
