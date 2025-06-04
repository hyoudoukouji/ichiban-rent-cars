<?php
require_once 'config/database.php';

try {
    // Create tables if they don't exist
    $db->exec("
        CREATE TABLE IF NOT EXISTS cars (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            price TEXT NOT NULL,
            rating REAL NOT NULL,
            category TEXT NOT NULL,
            engine TEXT NOT NULL,
            power TEXT NOT NULL,
            transmission TEXT NOT NULL,
            image TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS car_features (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            car_id INTEGER NOT NULL,
            feature TEXT NOT NULL,
            FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS saved_cars (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            car_id INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
        )
    ");

    // New rentals table for rental bookings
    $db->exec("
        CREATE TABLE IF NOT EXISTS rentals (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            car_id INTEGER NOT NULL,
            rental_start DATE NOT NULL,
            rental_end DATE NOT NULL,
            total_price REAL NOT NULL,
            status TEXT DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY(car_id) REFERENCES cars(id) ON DELETE CASCADE
        )
    ");

    // Clear existing data
    $db->exec("DELETE FROM saved_cars");
    $db->exec("DELETE FROM car_features");
    $db->exec("DELETE FROM cars");
    $db->exec("DELETE FROM rentals");

    // Reset autoincrement counters for SQLite
    $db->exec("DELETE FROM sqlite_sequence WHERE name='cars'");
    $db->exec("DELETE FROM sqlite_sequence WHERE name='car_features'");
    $db->exec("DELETE FROM sqlite_sequence WHERE name='saved_cars'");
    $db->exec("DELETE FROM sqlite_sequence WHERE name='rentals'");

    echo "Database tables created and cleared successfully.\n";

} catch (Exception $e) {
    echo "Setup failed: " . $e->getMessage();
}
?>
