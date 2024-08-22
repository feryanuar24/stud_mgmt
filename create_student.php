<?php
require_once 'includes/Database.php';
require_once 'includes/Student.php';
require_once 'includes/User.php';

session_start();

$database = new Database();
$user = new User($database);
$student = new Student($database);
$error = "";

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $major = trim($_POST['major']);

    if (empty($name) || empty($email) || empty($major)) {
        $error = "Semua kolom harus diisi";
    } else {
        if ($student->addStudent($name, $email, $major)) {
            $_SESSION['success_student'] = "Berhasil menambahkan data mahasiswa";
            header("Location: read_students.php");
            exit();
        } else {
            $error = "Gagal menambahkan data mahasiswa";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Data Mahasiswa - Halaman tambah mahasiswa untuk mengelola data mahasiswa">
    <meta name="robot" content="index, follow">
    <title>Tambah Mahasiswa - Sistem Manajemen Data Mahasiwa</title>
</head>

<body>
    <header>
        <h1>Sistem Manajemen Data Mahasiswa</h1>
        <h2>Tambah Mahasiswa</h2>
    </header>

    <main>
        <section>
            <?php if (!empty($error)): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <form action="create_student.php" method="post">
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
                    <label for="major">Prodi</label>
                    <br>
                    <input type="text" name="major" id="major" required aria-required="true">
                </div>

                <br>

                <div>
                    <button type="submit">Simpan</button>
                </div>
            </form>
        </section>

        <br>

        <footer>
            <nav>
                <table>
                    <tr>
                        <td><a href="index.php">Dashboard</a></td>
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