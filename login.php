<?php
require_once 'includes/Database.php';
require_once 'includes/User.php';

session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Semua kolom harus diisi";
    } else {
        $database = new Database();
        $user = new User($database);
        $loggedInUser = $user->login($email, $password);

        if ($loggedInUser) {
            $_SESSION['user_id'] = $loggedInUser['id'];
            $_SESSION['user_name'] = $loggedInUser['name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Email atau kata sandi salah";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Data Mahasiswa - Halaman masuk untuk mengelola data mahasiswa">
    <meta name="robot" content="index, follow">
    <title>Masuk - Sistem Manajement Data Mahasiswa</title>
</head>

<body>
    <header>
        <h1>Sistem Manajemen Data Mahasiswa</h1>
        <h2>Masuk Akun</h2>
    </header>

    <main>
        <section>
            <form action="login.php" method="post">
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
                    <button type="submit">Masuk</button>
                </div>
            </form>

            <?php if (isset($_SESSION['success_register'])) : ?>
                <p><?php echo htmlspecialchars($_SESSION['success_register'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php unset($_SESSION['success_register']); ?>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
        </section>

        <footer>
            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </footer>
    </main>
</body>

</html>