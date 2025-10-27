<?php
session_start();
require_once '../config/config.php'; // load BASE_URL from .env

session_unset();
session_destroy();

header("Location: " . $BASE_URL . "/frontend/php/index.php");
exit;
