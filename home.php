<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

$search = $_POST['search'] ?? '';

$query = "SELECT * FROM products WHERE name LIKE '%$search%'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - My E-Commerce</title>
    <style>
        /* General Styles */
        body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #e0f7fa;
    color: #333;
}

.container {
    width: 85%;
    margin: 0 auto;
    padding: 20px;
    max-width: 1200px; /* Restrict max-width for better alignment */
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #00695c;
    font-size: 28px;
    letter-spacing: 2px;
}

/* Header Styles */
header {
    background: linear-gradient(90deg, #004d40, #00897b);
    color: #fff;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

header a {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
    font-weight: bold;
    transition: color 0.3s ease;
    display: inline-block; /* Align navigation links horizontally */
}

header a:hover {
    color: #b2dfdb;
}

/* Forms (Search Bar) */
form {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

form input[type="text"] {
    width: 320px;
    padding: 12px;
    border: 1px solid #80cbc4;
    border-radius: 5px;
    margin-right: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

form button {
    background-color: #004d40;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, transform 0.2s ease;
}

form button:hover {
    background-color: #00796b;
    transform: translateY(-3px);
}

/* Product List Styles */
.product-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    justify-items: center; /* Center grid items */
}

.product-item {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    width: 100%; /* Ensure the product takes full width */
    max-width: 300px; /* Maintain consistent width */
}

.product-item:hover {
    transform: scale(1.05);
    border-color: #00897b;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.product-item img {
    max-width: 100%;
    height: 250px;
    object-fit: cover;
    border-bottom: 3px solid #00897b;
    margin-bottom: 20px;
    border-radius: 10px;
}

.product-item h3 {
    color: #004d40;
    font-size: 22px;
    margin-bottom: 12px;
}

.product-item p {
    font-size: 15px;
    margin-bottom: 12px;
    color: #666;
}

.product-item p.price {
    color: #333;
    font-weight: bold;
    font-size: 18px;
    margin-bottom: 25px;
}

.product-item button {
    background-color: #00695c;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

.product-item button:hover {
    background-color: #004d40;
    transform: translateY(-3px);
}

/* Footer Links */
.cart-link {
    display: block;
    width: 100%;
    text-align: center;
    margin-top: 40px;
    text-decoration: none;
    background-color: #00695c;
    color: #fff;
    padding: 12px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.cart-link:hover {
    background-color: #004d40;
    transform: translateY(-3px);
}

/* Footer CSS */
footer {
    background-color: #004d40;
    padding: 30px 0;
    color: #fff;
}

footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

footer .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

footer .col-md-4 {
    flex-basis: 33%;
    text-align: center; /* Centered content in footer columns */
    margin-bottom: 20px;
    color: #fff;
}

footer h5 {
    font-weight: bold;
    margin-top: 0;
    color: #80cbc4;
}

footer ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

footer li {
    margin-bottom: 10px;
}

footer a {
    color: #80cbc4;
    text-decoration: none;
}

footer a:hover {
    color: #fff;
}

footer .copyright {
    font-size: 14px;
    color: #ccc;
    text-align: center;
    margin-top: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-list {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Adjust grid for tablets */
    }

    footer .col-md-4 {
        flex-basis: 50%;
    }
}

@media (max-width: 480px) {
    .product-list {
        grid-template-columns: 1fr; /* Single column for small screens */
    }

    footer .col-md-4 {
        flex-basis: 100%;
    }
}

       </style>
       </head>
<body>

<header>
    <h1>My E-Commerce Store</h1>
    <a href="home.php">Home</a>
    <a href="cart.php">Cart</a>
    <a href="logout.php">Logout</a>
</header>

<div class="container">
    <h2>Welcome to Our Store</h2>

    <form method="POST" action="home.php">
        <input type="text" name="search" placeholder="Search for products...">
        <button type="submit">Search</button>
    </form>

    <div class="product-list">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="product-item">
                <img src="<?php echo $row['image']; ?>" alt="Product Image">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p class="price">$<?php echo $row['price']; ?></p>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>

    <a href="cart.php" class="cart-link">Go to Cart</a>
</div>
<!-- Footer HTML -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5>About Us</h5>
        <p>Developed as a e-commerce website for online shopping by a beginner .</p>
      </div>
      <div class="col-md-4">
        <h5>Quick Links</h5>
        <ul>
          <li><a href="#">Terms of Use</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Follow Us</h5>
        <ul>
          <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
          <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
          <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
        </ul>
      </div>
    </div>
    <p class="copyright">Copyright 2023 Your Website Name. All rights reserved.</p>
  </div>
</footer>
</body>
</html>
