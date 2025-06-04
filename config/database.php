<?php
// Enable PHP error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbPath = __DIR__ . '/../database/ichiban.db';
$dbDir = dirname($dbPath);

// Create database directory if it doesn't exist
if (!file_exists($dbDir)) {
    mkdir($dbDir, 0777, true);
}

try {
    $db = new SQLite3($dbPath);
    $db->enableExceptions(true);
} catch(Exception $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
