<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Ambil data komentar
$stmt = $conn->prepare("SELECT * FROM komentars WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['user']['id']);
$stmt->execute();
$result = $stmt->get_result();
$komentar = $result->fetch_assoc();

if (!$komentar) {
    echo "Komentar tidak ditemukan atau bukan milikmu.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isi = $_POST['isi'];

    $stmt = $conn->prepare("UPDATE komentars SET isi = ? WHERE id = ?");
    $stmt->bind_param("si", $isi, $id);
    $stmt->execute();

    header("Location: detail_debat.php?id=" . $komentar['debat_id']);
    exit;
}
?>

<h2>Edit Komentar</h2>
<form method="post">
    <textarea name="isi" rows="4" cols="50"><?= htmlspecialchars($komentar['isi']) ?></textarea><br>
    <button type="submit">Update</button>
</form>
