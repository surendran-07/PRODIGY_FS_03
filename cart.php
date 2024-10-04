<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Check for success or error messages
if (isset($_GET['message'])) {
    $message = '<p class="success">' . htmlspecialchars($_GET['message']) . '</p>';
} elseif (isset($_GET['error'])) {
    $message = '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>';
}

// Get user ID
$user_query = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$user_result = $stmt->get_result();
$user_id_row = $user_result->fetch_assoc();
$user_id = $user_id_row['id'];

// Fetch items in the cart
$cart_query = "SELECT cart.id, products.name, products.price, cart.quantity FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Your Shopping Cart</title>
    <style>
       body {
    font-family: 'Arial', sans-serif;
    background-image: url('cart.jpeg'); /* Background image */
    background-size: cover;
    background-position: center;
    color: #333; /* Darker text color */
    margin: 0;
    padding: 20px;
}

/* Heading Styles */
h1 {
    text-align: center;
    color: #1e88e5; /* Calming blue */
    font-weight: bold;
}

/* Table Styles */
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #ffffffd9; /* Light semi-transparent background */
    border-radius: 10px;
    overflow: hidden; /* Rounded corners */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Soft shadow */
}

th, td {
    padding: 15px;
    text-align: center;
    border: 1px solid #ddd; /* Light border */
}

th {
    background-color: #1e88e5; /* Blue header */
    color: white;
}

tr:nth-child(even) {
    background-color: #f1f1f1; /* Lighter row background */
}

tr:hover {
    background-color: #e0f7fa; /* Teal hover */
}

/* Button Styles */
button {
    background-color: #29b6f6; /* Light blue button color */
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0288d1; /* Darker blue on hover */
}

/* Link Styles */
a {
    color: #29b6f6; /* Light blue links */
    text-decoration: none;
    font-size: x-large;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
    color: #0288d1; /* Darker blue on hover */
}

/* Input Field Styles */
input[type="text"] {
    width: 50px;
    text-align: center;
    border: 1px solid #29b6f6; /* Light blue border */
    border-radius: 5px;
    background-color: #f1f1f1; /* Light background */
    color: #333; /* Dark text color */
}

/* Success Message */
.success {
    color: #2ecc71; /* Green success messages */
    text-align: center;
    margin-top: 20px;
    font-size: large;
}

/* Error Message */
.error {
    color: #e74c3c; /* Red error messages */
    text-align: center;
    margin-top: 20px;
    font-size: large;
}

    </style>
</head>
<body>
    <h1>Your Shopping Cart</h1>
    <?php if (isset($message)) echo $message; ?>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $cart_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>$<?php echo number_format($row['price'], 2); ?></td>
                <td>
                    <form method="POST" action="update_quantity.php">
                        <button type="submit" name="action" value="decrease">-</button>
                        <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="quantity" value="<?php echo $row['quantity']; ?>" readonly>
                        <button type="submit" name="action" value="increase">+</button>
                    </form>
                </td>
                <td>$<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                <td><a href="remove_from_cart.php?id=<?php echo $row['id']; ?>">Remove</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <center><a href="checkout.php">Proceed to Checkout</a></center>
</body>
</html>
