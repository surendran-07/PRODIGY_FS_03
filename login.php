<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION['user'] = $username;
    header('Location: home.php');
  } else {
    $error = "Invalid login credentials";
  }
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

/* Overlay for readability */
body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Dark overlay */
    z-index: 0;
}

.login-form {
    width: 320px;
    padding: 30px;
    background-color: rgba(51, 51, 51, 0.9); /* Dark, semi-transparent background */
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.7);
    z-index: 1;
    position: relative;
}

.login-form input[type="text"],
.login-form input[type="password"] {
    width: 100%;
    height: 45px;
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #666; /* Softer border */
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.1); /* Slightly transparent input background */
    color: #fff;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2); /* Inner shadow for depth */
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.login-form input[type="text"]::placeholder,
.login-form input[type="password"]::placeholder {
    color: #ddd; /* Lighter placeholder */
}

.login-form input[type="text"]:focus,
.login-form input[type="password"]:focus {
    border-color: #E50914; /* Netflix red border on focus */
    outline: none;
}

.login-form button[type="submit"] {
    width: 100%;
    height: 45px;
    background-color: #E50914; /* Netflix red button */
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.login-form button[type="submit"]:hover {
    background-color: #FF3737; /* Brighter Netflix red on hover */
    transform: scale(1.05); /* Slight button scaling effect */
}

.login-form a {
    text-align: center;
    display: block;
    margin-top: 20px;
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.login-form a:hover {
    color: #ccc; /* Light gray on hover */
}

.error {
    color: #FF3737; /* Netflix red for error messages */
    font-size: 14px;
    margin-bottom: 15px;
    text-align: center; /* Center the error message */
}

</style>
<div class="login-form">
  <form method="POST" action="login.php">
    <?php if (isset($error)) { ?>
      <p class="error"><?= $error ?></p>
    <?php } ?>
    <input type="text" name="username" placeholder="username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
  <a href="signup.php">Sign up</a>
</div>