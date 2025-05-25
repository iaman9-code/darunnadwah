<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['user'] = [
            'id' => $stmt->insert_id,
            'nama' => $nama,
            'email' => $email
        ];
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal mendaftar. Email mungkin sudah digunakan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Darunnadwah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <h3 class="card-title mb-4 text-center">Daftar Akun</h3>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Aktif</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </form>
                        <div class="mt-3 text-center">
                            Sudah punya akun? <a href="login.php">Login di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</body>
</html>
