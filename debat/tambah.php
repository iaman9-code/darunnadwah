<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("INSERT INTO debat (judul, deskripsi) VALUES (?, ?)");
    $stmt->bind_param("ss", $judul, $deskripsi);
    $stmt->execute();

    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Debat</title>
<link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
    <div style="text-align: center;">
    <img src="../assets/logo.png" alt="Logo Darunnadwah" style="max-height: 100px; margin-bottom: 10px;">
</div>
<div style="background-color: #4CAF50; padding: 15px; text-align: center;">
    <a href="../index.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">🏠 Beranda</a>
    <a href="tambah.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">➕ Tambah Debat</a>
</div>
    <h1>Tambah Debat</h1>
    <form method="POST">
        <label>Judul:</label><br>
        <input type="text" name="judul" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required></textarea><br><br>

        <button type="submit">Simpan</button>
    </form>
    <br>
    <a href="../index.php">Kembali</a>
</body>
</html>
