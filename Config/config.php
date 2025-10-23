<?php
// Read .env file
$env = parse_ini_file(__DIR__ . '/../.env');
$BASE_URL = $env['BASE_URL'];
