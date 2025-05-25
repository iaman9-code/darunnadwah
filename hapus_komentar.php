<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$debat_id = $_GET['debat_id'];

// Cek apakah komentar milik user yang login
$stmt = $conn->prepare("DELETE FROM komentars WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['user']['id']);
$stmt->execute();

header("Location: detail_debat.php?id=$debat_id");
exit;
