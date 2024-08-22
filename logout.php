<?php
include_once 'includes/Database.php';
include 'includes/User.php';

session_start();

$database = new Database();
$user = new User($database);
$user->logout();

header("Location: login.php");
exit();
