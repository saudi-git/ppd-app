<?php
/**
 * Centralized session security for PPD-PIMS.
 *
 * - Secure, HttpOnly, SameSite=Lax session cookie
 * - Strict session mode / cookie-only sessions
 * - Session ID regeneration after login is handled in index.php
 * - 30-minute inactivity timeout
 * - Safe session cleanup on timeout
 */

if (session_status() === PHP_SESSION_NONE) {
    // Reject uninitialized session IDs and avoid accepting IDs via URL parameters.
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');

    $isHttps = (
        (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
    );

    session_name('PPDSESSID');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

// 30 minutes of inactivity.
const SESSION_IDLE_TIMEOUT = 1800;

$now = time();

if (isset($_SESSION['LAST_ACTIVITY'])) {
    $idleTime = $now - (int) $_SESSION['LAST_ACTIVITY'];

    if ($idleTime > SESSION_IDLE_TIMEOUT) {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                [
                    'expires' => $now - 42000,
                    'path' => $params['path'],
                    'domain' => $params['domain'],
                    'secure' => $params['secure'],
                    'httponly' => $params['httponly'],
                    'samesite' => $params['samesite'] ?? 'Lax'
                ]
            );
        }

        session_destroy();

        header('Location: index.php?session=expired');
        exit;
    }
}

// Track activity only after the timeout check.
$_SESSION['LAST_ACTIVITY'] = $now;
