<?php
require_once 'includes/Database.php';
require_once 'includes/User.php';
require_once 'includes/Student.php';

session_start();

$database = new Database();
$user = new User($database);
$student = new Student($database);
$error = "";

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    if ($student->deleteStudent($id)) {
        $_SESSION['success_student'] = "Berhasil menghapus data";
        header("Location: read_students.php");
        exit();
    } else {
        $error = "Gagal menghapus data";
    }
} else {
    $error = "ID tidak valid";
}
