<?php

/**
 * Vercel PHP Runtime Entry Point for Laravel
 * All requests are routed through here to Laravel's public/index.php
 */

// Set APP_URL dynamically based on request
if (!getenv('APP_URL') && isset($_SERVER['HTTP_HOST'])) {
    $scheme = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'http';
    putenv('APP_URL=' . $scheme . '://' . $_SERVER['HTTP_HOST']);
}

// Fix SCRIPT_FILENAME for Laravel
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

require __DIR__ . '/../public/index.php';
