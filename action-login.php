<?php
include_once __DIR__ . '/config/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_or_username = $_POST['email_or_username'];
    $password = $_POST['password'];
}
?>