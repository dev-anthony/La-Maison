<?php
// include '../config/db.php';
// session_start();
// if(!isset($_SESSION['reset_email']) || !isset(($_SESSION['reset_type']))){
//     echo 'Unauthorized access';
//     exit();
// }

// $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
// $email = $_SESSION['reset_email'];
// $type = $_SESSION['reset_type'];

// if($type === 'admin') {
//     $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE email = ?");
// }else{
//     $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
// }
// $stmt->bind_param("ss", $newPassword, $email);
// if($stmt->execute()){
//     session_unset();
//     session_destroy();
//     header("location: /Authentication/frontend/php/index.php");
// }else{
//     echo ' failed to update password';
// }
include '../config/db.php';
require_once '../config/config.php'; // load BASE_URL from .env
session_start();

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_type'])) {
    echo 'Unauthorized access';
    exit();
}

$newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$email = $_SESSION['reset_email'];
$type = $_SESSION['reset_type'];

// Choose table based on type
if ($type === 'admin') {
    $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE email = ?");
} else {
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
}

$stmt->bind_param("ss", $newPassword, $email);

if ($stmt->execute()) {
    session_unset();
    session_destroy();
    header("Location: " . $BASE_URL . "/frontend/php/index.php");
    exit();
} else {
    echo 'Failed to update password';
}

?>