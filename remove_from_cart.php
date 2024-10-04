<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
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

// Get the cart item ID to be removed
$cart_id = $_GET['id'] ?? null;

if ($cart_id) {
    // Prepare the DELETE statement
    $delete_query = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();

    // Optionally check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        // Item successfully removed
        header('Location: cart.php?message=Item removed successfully');
        exit;
    } else {
        // Item not found or not deleted
        header('Location: cart.php?error=Item could not be removed');
        exit;
    }
} else {
    // Invalid cart ID
    header('Location: cart.php?error=Invalid item ID');
    exit;
}

// Close connections
$stmt->close();
$conn->close();
?>
