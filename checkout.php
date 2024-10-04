<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_id_query = "SELECT id FROM users WHERE username='" . $_SESSION['user'] . "'";
$user_id_result = mysqli_query($conn, $user_id_query);
$user_id_row = mysqli_fetch_assoc($user_id_result);
$user_id = $user_id_row['id'];

$query = "SELECT products.*, cart.quantity FROM cart 
JOIN products ON cart.product_id = products.id 
WHERE cart.user_id = '$user_id'";
$result = mysqli_query($conn, $query);

$total = 0;

$message = ''; // Initialize message variable
if (isset($_POST['place_order'])) {
    $message = "Order confirmed! Thank you for shopping with us!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Checkout</title>
    <style>
       body {
    font-family: Arial, sans-serif;
    background-image: url('check.jpeg'); /* Background image */
    background-size: cover;
    background-position: center;
    color: #333; /* Dark text */
    margin: 0;
    padding: 20px;
}

/* Checkout Container */
.checkout-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffffd9; /* Soft, semi-transparent white background */
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

/* Checkout Header */
.checkout-header {
    background-color: #1e88e5; /* Calming blue background */
    color: #fff; /* White text */
    padding: 20px;
    border-radius: 10px 10px 0 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.checkout-header h2 {
    margin: 0;
    font-size: 30px;
}

/* Checkout Table */
.checkout-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.checkout-table th, 
.checkout-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0; /* Soft border for separation */
}

.checkout-table th {
    background-color: #1976d2; /* Slightly darker blue for table header */
    color: #fff; /* White text */
}

.checkout-table td {
    background-color: #f9f9f9; /* Light gray background for table rows */
    color: #555; /* Darker text for better readability */
}

.checkout-table tr:nth-child(even) td {
    background-color: #f1f1f1; /* Alternate row background color for clarity */
}

.checkout-table img {
    width: 60px; /* Standard image size */
    height: 60px; /* Standard image size */
    border-radius: 8px; /* Rounded corners for images */
}

/* Checkout Total */
.checkout-total {
    font-size: 24px;
    font-weight: bold;
    color: #1976d2; /* Blue text to match the theme */
    text-align: right; /* Right-align total */
}

/* Checkout Button */
.checkout-button {
    width: 100%;
    height: 50px;
    background-color: #1976d2; /* Blue button background */
    color: #fff; /* White text */
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    margin-top: 20px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.checkout-button:hover {
    background-color: #1565c0; /* Darker blue on hover */
    transform: scale(1.02); /* Slight scaling effect */
}

/* Confirmation Message */
.confirmation-message {
    margin-top: 20px;
    font-size: 20px;
    color: #333; /* Dark text for readability */
    text-align: center;
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .checkout-container {
        width: 100%;
        padding: 15px;
    }
}
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="checkout-header">
            <h2>Checkout</h2>
        </div>
        <table class="checkout-table">
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="Product Image"></td>
                    <td><?= $row['quantity'] ?></td>
                    <td>$<?= number_format($row['price'], 2) ?></td>
                    <td>$<?= number_format($row['price'] * $row['quantity'], 2) ?></td>
                </tr>
                <?php $total += $row['price'] * $row['quantity']; ?>
            <?php } ?>
            <tr>
                <td colspan="4">Total:</td>
                <td class="checkout-total">$<?= number_format($total, 2) ?></td>
            </tr>
        </table>
        <form method="post">
            <button type="submit" name="place_order" class="checkout-button">Place Order</button>
        </form>
    </div>
    <?php if ($message): ?>
        <div class="confirmation-message">
            <?= $message ?>
        </div>
    <?php endif; ?>
</body>
</html>
