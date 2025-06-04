<?php
session_start();
require_once 'config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

$carId = isset($_POST['car_id']) ? (int)$_POST['car_id'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;

if (!$carId || !$action) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
    exit();
}

try {
    if ($action === 'add') {
        // Initialize cart array in session if it doesn't exist
        if (!isset($_SESSION['cart_items'])) {
            $_SESSION['cart_items'] = [];
        }
        
        // Add car to cart if not already in it
        if (!in_array($carId, $_SESSION['cart_items'])) {
            $_SESSION['cart_items'][] = $carId;
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Car added to cart successfully'
        ]);
    } elseif ($action === 'remove') {
        // Remove car from cart
        if (isset($_SESSION['cart_items'])) {
            $_SESSION['cart_items'] = array_values(array_diff($_SESSION['cart_items'], [$carId]));
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Car removed from cart successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid action'
        ]);
    }
} catch(Exception $e) {
    error_log("Error in update_cart.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Server error occurred'
    ]);
}
