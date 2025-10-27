<?php
include '../config/db.php';
require_once '../config/config.php'; // load BASE_URL from .env
session_start();

// Array to store error messages
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['signup'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
        $_SESSION['errors'] = $errors;
        header('Location: ' . $BASE_URL . '/frontend/php/register.php');
        exit();
    }

    // Validate name
    if (empty($name)) {
        $errors['name'] = 'Name is required';
        $_SESSION['errors'] = $errors;
        header('Location: ' . $BASE_URL . '/frontend/php/register.php');
        exit();
    }

    // Validate password length
    if (strlen($_POST['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters long';
        $_SESSION['errors'] = $errors;
        header('Location: ' . $BASE_URL . '/frontend/php/register.php');
        exit();
    }

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $errors['user_exist'] = 'Email already exists';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ' . $BASE_URL . '/frontend/php/register.php');
        exit();
    }

    // Insert new user
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql)) {
        header("Location: " . $BASE_URL . "/frontend/php/index.php");
        exit();
    }
}
