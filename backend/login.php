<?php
session_start();
include '../Config/db.php';
require_once '../Config/config.php'; // load BASE_URL from .env

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    if (empty($password)) {
        $errors['password'] = 'Password cannot be empty';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ' . $BASE_URL . '/frontend/php/index.php');
        exit();
    }

    // Check admins table
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $admin_result = $stmt->get_result();

    if ($admin_result->num_rows === 1) {
        $admin = $admin_result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user_email'] = $admin['email'];
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['user_type'] = 'admin';
            $_SESSION['user_name'] = $admin['name'];

            header("Location: " . $BASE_URL . "/frontend/php/admin_dashboard.php");
            exit();
        } else {
            $errors['admin_login'] = 'Invalid email or password';
            $_SESSION['errors'] = $errors;
            header('Location: ' . $BASE_URL . '/frontend/php/index.php');
            exit();
        }
    }

    // Check users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows === 1) {
        $user = $user_result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = 'user';
            $_SESSION['user_name'] = $user['name'];

            header("Location: " . $BASE_URL . "/frontend/php/userdashboard.php");
            exit();
        } else {
            $errors['user_login'] = 'Invalid email or password';
            $_SESSION['errors'] = $errors;
            header('Location: ' . $BASE_URL . '/frontend/php/index.php');
            exit();
        }
    } else {
        $errors['login'] = 'User not found';
        $_SESSION['errors'] = $errors;
        header('Location: ' . $BASE_URL . '/frontend/php/index.php');
        exit();
    }
}
