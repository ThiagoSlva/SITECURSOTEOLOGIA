<?php
// includes/security.php

if (session_status() === PHP_SESSION_NONE) {
    // Configure secure sessions
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax'); // Protect against CSRF
    // ini_set('session.cookie_secure', 1); // Enable in production with HTTPS
    session_start();
}

/**
 * Generate a CSRF token for forms
 * @return string The token
 */
function generate_csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validates a CSRF token
 * @param string $token The token from the request
 * @return bool True if valid, false otherwise
 */
function validate_csrf_token($token)
{
    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
        return true;
    }
    return false;
}

/**
 * Sanitizes output to prevent XSS
 * @param string $data The raw data
 * @return string Sanitized string safe for HTML output
 */
function sanitize_output($data)
{
    if ($data === null)
        return '';
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Authenticate Admin User Middleware
 * Redirects to login if not logged in
 */
function require_login()
{
    if (!isset($_SESSION['admin_id'])) {
        header("Location: /admin/login.php");
        exit();
    }
}
