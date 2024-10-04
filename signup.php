<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
  mysqli_query($conn, $query);

  header('Location: login.php');
}
?>
<style>
body {
    font-family: Arial, sans-serif;
    background-image: url('pexels-pixabay-33109.jpg');
    background-size: cover;
    background-position: center;
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

/* Adding an overlay to make the form more visible against the background */
body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Dark overlay for better text visibility */
    z-index: 0;
}

.signup-form {
    width: 400px;
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.1); /* Slightly lighter form background */
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.7);
    z-index: 1; /* Ensures form is on top of the overlay */
    position: relative;
}

.signup-form h2 {
    text-align: center;
    color: #fff;
    margin-bottom: 20px;
    font-size: 26px;
    font-weight: bold;
}

.signup-form input[type="text"],
.signup-form input[type="email"],
.signup-form input[type="password"] {
    width: 100%;
    height: 45px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #666; /* Slightly lighter border */
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.1); /* Lighter semi-transparent background */
    color: #fff;
    box-shadow: inset 0 1px 3px rgba(255, 255, 255, 0.1); /* Subtle inner shadow for depth */
    font-size: 16px;
}

.signup-form input[type="text"]::placeholder,
.signup-form input[type="email"]::placeholder,
.signup-form input[type="password"]::placeholder {
    color: #ddd; /* Lighter placeholder text */
}

.signup-form button[type="submit"] {
    width: 100%;
    height: 45px;
    background-color: rgba(0, 123, 255, 0.7); /* Softer blue */
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.signup-form button[type="submit"]:hover {
    background-color: rgba(0, 123, 255, 0.9); /* Slightly more opaque on hover */
    transform: translateY(-3px); /* Subtle lift effect on hover */
}

.signup-form a {
    text-align: center;
    display: block;
    margin-top: 20px;
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.signup-form a:hover {
    color: #ccc; /* Light gray on hover */
}


</style>

<div class="signup-form">
  <form method="POST" action="signup.php">
    <h2>Sign up for an account</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Sign up</button>
  </form>
  <a href="login.php">Already have an account? Log in</a>
</div>