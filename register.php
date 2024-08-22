<?php
require_once 'includes/Database.php';
require_once 'includes/User.php';

session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Semua kolom harus diisi";
    } elseif ($password !== $confirm_password) {
        $error = "Kata sandi tidak cocok";
    } else {
        $database = new Database();
        $user = new User($database);

        if ($user->register($name, $email, $password)) {
            $_SESSION['success_register'] = "Berhasil mendaftar. Silakan login";
            header("Location: login.php");
            exit();
        } else {
            $error = "Gagal mendaftar";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Data Mahasiswa - Halaman pendaftaran untuk mengelola data mahasiswa">
    <meta name="robot" content="index, follow">
    <title>Daftar - Sistem Manajemen Data Mahasiwa</title>
</head>

<body>
    <header>
        <h1>Sistem Manajemen Data Mahasiswa</h1>
        <h2>Daftar Akun</h2>
    </header>

    <main>
        <section>
            <form action="register.php" method="post">
                <div>
                    <label for="name">Nama</label>
                    <br>
                    <input type="text" name="name" id="name" required aria-required="true">
                </div>

                <br>

                <div>
                    <label for="email">Email</label>
                    <br>
                    <input type="email" name="email" id="email" required aria-required="true">
                </div>

                <br>

                <div>
                    <label for="password">Kata Sandi</label>
                    <br>
                    <input type="password" name="password" id="password" required aria-required="true">
                </div>

                <br>

                <div>
                    <label for="confirm_password">Konfirmasi Kata Sandi</label>
                    <br>
                    <input type="password" name="confirm_password" id="confirm_password" required aria-required="true">
                </div>

                <br>

                <div>
                    <button type="submit">Daftar</button>
                </div>
            </form>

            <?php if (!empty($error)): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
        </section>

        <footer>
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </footer>
    </main>
</body>

</html>