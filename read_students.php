<?php
require_once 'includes/Database.php';
require_once 'includes/Student.php';
require_once 'includes/User.php';

session_start();

$database = new Database();
$user = new User($database);
$student = new Student($database);
$result = $student->getAllStudents();

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
    <meta name="description" content="Sistem Manajemen Data Mahasiswa - Halaman daftar mahasiswa untuk mengelola data mahasiswa">
    <meta name="robot" content="index, follow">
    <title>Daftar Mahasiswa - Sistem Manajemen Data Mahasiwa</title>
</head>

<body>
    <header>
        <h1>Sistem Manajemen Data Mahasiswa</h1>
        <h2>Daftar Mahasiswa</h2>
    </header>

    <main>
        <section>
            <table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Prodi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($studentData = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($no++) . "</td>";
                            echo "<td>" . htmlspecialchars($studentData['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($studentData['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($studentData['major']) . "</td>";
                            echo "<td><a href='update_student.php?id=" . htmlspecialchars($studentData['id']) . "'>Edit</a> | <a href='delete_student.php?id=" . htmlspecialchars($studentData['id']) . "'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data mahasiswa</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <?php if (isset($_SESSION['success_student'])): ?>
                <p><?php echo htmlspecialchars($_SESSION['success_student'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php unset($_SESSION['success_student']); ?>
            <?php endif; ?>
        </section>

        <br>

        <footer>
            <nav>
                <table>
                    <tr>
                        <td><a href="index.php">Dashboard</a></td>
                        <td>|</td>
                        <td><a href="create_student.php">Tambah Mahasiswa</a></td>
                        <td>|</td>
                        <td><a href="logout.php">Logout</a></td>
                    </tr>
                </table>
            </nav>
        </footer>
    </main>
</body>

</html>