<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit; // Ensure no further code is executed
}

// Get user ID
$user_query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$user_result = $stmt->get_result();

if ($user_result->num_rows === 0) {
    // User not found, redirect to login
    header('Location: login.php');
    exit;
}

$user_id_row = $user_result->fetch_assoc();
$user_id = $user_id_row['id'];

// Get product ID from POST request
$product_id = $_POST['product_id'] ?? null;

if ($product_id) {
    // Check if the product already exists in the cart
    $check_query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Product exists, do nothing as the quantity will be updated in the cart page
        header('Location: cart.php');
        exit;
    } else {
        // Product does not exist, insert a new row with quantity 1
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    // Redirect to the cart page after successful operation
    header('Location: cart.php');
    exit;
} else {
    // Invalid product ID
    echo "Invalid product ID!";
}

// Close connections
$stmt->close();
$conn->close();
?>
