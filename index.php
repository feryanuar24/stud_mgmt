<?php
require_once 'includes/Database.php';
require_once 'includes/User.php';

session_start();

$database = new Database();
$user = new User($database);
$user_name = $_SESSION['user_name'];

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Data Mahasiswa - Halaman dashboard untuk mengelola data mahasiswa">
    <meta name="robot" content="index, follow">
    <title>Dashboard - Sistem Manajement Data Mahasiswa</title>
</head>

<body>
    <header>
        <h1>Sistem Manajemen Data Mahasiswa</h1>
        <h2>Dashboard</h2>
    </header>

    <main>
        <section>
            <p>Selamat datang, <?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?></p>
        </section>

        <footer>
            <nav>
                <table>
                    <tr>
                        <td><a href="create_student.php">Tambah Mahasiswa</a></td>
                        <td>|</td>
                        <td><a href="read_students.php">Daftar Mahasiswa</a></td>
                        <td>|</td>
                        <td><a href="logout.php">Logout</a></td>
                    </tr>
                </table>
            </nav>
        </footer>
    </main>
</body>

</html>