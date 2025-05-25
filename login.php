<?php
session_start();
require 'db.php'; // Pastikan file ini menghubungkan ke database

// Jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOrPhone = $_POST['email'];
    $password = $_POST['password'];

    // Ambil user dari database berdasarkan email atau no. telepon
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $emailOrPhone);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Jika user ditemukan dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php"); // Redirect ke halaman utama
        exit;
    } else {
        $error = "Email/No. Telepon atau kata sandi salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Darunnadwah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <h3 class="card-title mb-4 text-center">Login Darunnadwah</h3>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="mb-3">
                                <label>Email atau No. Telepon</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Kata Sandi</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="mt-3 text-center">
                            Belum punya akun? <a href="register.php">Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
