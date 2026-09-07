<?php
require_once __DIR__ . '/session.php';

function ppd_require_login(): void
{
    if (empty($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }
}

function ppd_require_roles(array $allowedRoles): void
{
    ppd_require_login();

    $currentRole = $_SESSION['role'] ?? '';
    if (in_array($currentRole, $allowedRoles, true)) {
        return;
    }

    http_response_code(403);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Forbidden</title></head><body>';
    echo '<h1>403 Forbidden</h1>';
    echo '<p>Wala kang access sa page na ito.</p>';
    echo '<p><a href="index.php">Back to dashboard</a></p>';
    echo '</body></html>';
    exit;
}
