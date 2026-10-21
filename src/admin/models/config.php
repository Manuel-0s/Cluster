<?php
    require_once __DIR__ . '/../../vendor/autoload.php';
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 3));
    $dotenv->load();

    define('DB_DRIVER', $_ENV['DB_DRIVER']);
    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASS', $_ENV['DB_PASS']);
    define('DB_NAME', $_ENV['DB_NAME']);
    define('DB_PORT', $_ENV['DB_PORT']);

    define('SMTP_HOST', $_ENV['SMTP_HOST']);
    define('SMTP_PORT', $_ENV['SMTP_PORT']);
    define('SMTP_EMAIL', $_ENV['SMTP_EMAIL']);
    define('SMTP_PASSWORD', $_ENV['SMTP_PASSWORD']);
?>