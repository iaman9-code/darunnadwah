<?php
$host = 'localhost';
$port = 3306; // default
$user = 'root'; // atau sesuai MySQL Workbench
$pass = 'Seventen7$'; // ganti dengan password MySQL kamu
$db   = 'darunnadwah';

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
