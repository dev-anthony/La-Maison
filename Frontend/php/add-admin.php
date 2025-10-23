<?php
require_once '../../Config/config.php';
session_start();

$errors = $_SESSION['errors'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Admin</title>
  <link rel="stylesheet" href="<?= $BASE_URL ?>/Frontend/css/register.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<div class="container">
  <form action="<?= $BASE_URL ?>/backend/add-admin.php" method="POST" id="form">
    <h1 class="form-title">Add Admin</h1>

    <?php if(isset($errors['user_exist'])): ?>
      <div class="error-main"><p><?= $errors['user_exist'] ?></p></div>
    <?php endif; ?>

    <div class="input_group">
      <i class="fas fa-user"></i>
      <input type="text" name="name" id="name" placeholder="Username" required>
      <?php if(isset($errors['name'])): ?>
        <div class="error-main"><p><?= $errors['name'] ?></p></div>
      <?php endif; ?>
    </div>

    <div class="input_group">
      <i class="fas fa-envelope"></i>
      <input type="email" name="email" id="email" placeholder="Email" required>
      <?php if(isset($errors['email'])): ?>
        <div class="error-main"><p><?= $errors['email'] ?></p></div>
      <?php endif; ?>
    </div>

    <div class="input_group">
      <i class="fas fa-lock"></i>
      <input type="password" name="password" id="password" placeholder="Password" required>
      <i class="fa fa-eye" id="eye"></i>
      <?php if(isset($errors['password'])): ?>
        <div class="error-main"><p><?= $errors['password'] ?></p></div>
      <?php endif; ?>
    </div>

    <input type="submit" value="Add Admin" name="addadmin" class="btn">
  </form>
</div>

<script src="<?= $BASE_URL ?>/Frontend/js/script.js"></script>
</body>
</html>

<?php
unset($_SESSION['errors']);
?>
