<?php
include 'includes/Database.php';
include 'includes/User.php';
include 'includes/Student.php';

session_start();

$database = new Database();
$user = new User($database);
$student = new Student($database);
$error = "";
$row = "";

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    $row = $student->getStudentById($id);

    if (!$row) {
        $error = "Data tidak ditemukan";
    }
} else {
    $error = "ID tidak valid";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $major = trim($_POST['major']);

    if (empty($name) || empty($email) || empty($major)) {
        $error = "Semua kolom harus diisi";
    } else {
        if ($student->updateStudent($id, $name, $email, $major)) {
            $_SESSION['success_student'] = "Berhasil mengubah data mahasiswa";
            header("Location: read_students.php");
            exit();
        } else {
            $error = "Gagal mengubah data mahasiswa";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Data Mahasiswa - Halaman perbaharui mahasiswa untuk mengelola data mahasiswa">
    <meta name="robot" content="index, follow">
    <title>Perbaharui Mahasiswa - Sistem Manajemen Data Mahasiwa</title>
</head>

<body>
    <header>
        <h1>Sistem Manajemen Data Mahasiswa</h1>
        <h2>Perbaharui Mahasiswa</h2>
    </header>

    <main>
        <section>
            <?php if (!empty($error)): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <?php if ($row): ?>
                <form action="update_student.php?id=<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                    <div>
                        <label for="name">Nama</label>
                        <br>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" required aria-required="true">
                    </div>

                    <br>

                    <div>
                        <label for="email">Email</label>
                        <br>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>" required required aria-required="true">
                    </div>

                    <br>

                    <div>
                        <label for="major">Prodi</label>
                        <br>
                        <input type="text" id="major" name="major" value="<?php echo htmlspecialchars($row['major'], ENT_QUOTES, 'UTF-8'); ?>" required required aria-required="true">
                    </div>

                    <br>

                    <div>
                        <button type="submit">Perbaharui</button>
                    </div>
                </form>
            <?php endif; ?>
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