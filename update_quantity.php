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
$user_id_row = $user_result->fetch_assoc();
$user_id = $user_id_row['id'];

// Get the cart ID and action
$cart_id = $_POST['cart_id'] ?? null;
$action = $_POST['action'] ?? null;

if ($cart_id && $action) {
    // Fetch the current quantity
    $query = "SELECT quantity FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_quantity = $row['quantity'];

        // Update the quantity based on the action
        if ($action == 'increase') {
            $new_quantity = $current_quantity + 1;
        } elseif ($action == 'decrease' && $current_quantity > 1) {
            $new_quantity = $current_quantity - 1;
        } else {
            $new_quantity = $current_quantity; // Don't change if decreasing but already at 1
        }

        // Update the cart with the new quantity
        $update_query = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $new_quantity, $cart_id);
        $stmt->execute();
    }
}

// Redirect back to the cart page
header('Location: cart.php');
exit;
?>
