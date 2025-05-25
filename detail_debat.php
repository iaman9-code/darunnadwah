<?php
session_start();
include 'db.php';

// Pastikan parameter id ada
if (!isset($_GET['id'])) {
    echo "Debat tidak ditemukan.";
    exit;
}
$id = $_GET['id'];
$debat_id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM debat WHERE id = ?");$stmt->bind_param("i", $debat_id);
$stmt->execute();
$result = $stmt->get_result();
$debat = $result->fetch_assoc();

if (!$debat) {
    echo "Debat tidak ditemukan.";
    exit;
}

// Proses komentar jika user sudah login dan kirim komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $isi = trim($_POST['isi']);
    $user_id = $_SESSION['user']['id'];

    if (!empty($isi)) {
        $stmt = $conn->prepare("INSERT INTO komentars (debat_id, user_id, isi) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $debat_id, $user_id, $isi);
        $stmt->execute();
        header("Location: detail_debat.php?id=" . $debat_id);
        exit;
    }
}

// Ambil komentar
$stmt = $conn->prepare("SELECT komentars.*, users.nama FROM komentars JOIN users ON komentars.user_id = users.id WHERE debat_id = ? ORDER BY created_at ASC");
$stmt->bind_param("i", $debat_id);
$stmt->execute();
$komentar_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Debat</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
.komentar {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 8px;
    background-color: #f9f9f9;
    position: relative;
}

.komentar strong {
    font-size: 14px;
    color: #333;
}

.komentar small {
    font-size: 12px;
    color: #777;
}

.komentar .aksi {
    position: absolute;
    top: 10px;
    right: 10px;
}

.komentar .aksi a {
    font-size: 12px;
    color: #007BFF;
    margin-left: 10px;
    text-decoration: none;
}

.komentar .aksi a:hover {
    text-decoration: underline;
}
</style>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>


<h2><?= htmlspecialchars($debat['judul']) ?></h2>
<!-- <p><strong>Dibuat oleh:</strong> <?= htmlspecialchars($debat['nama']) ?></p> -->
<p><?= nl2br(htmlspecialchars($debat['deskripsi'])) ?></p>

<hr>
<h3>Komentar:</h3>

<?php while ($k = $komentar_result->fetch_assoc()): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title mb-1"><?= htmlspecialchars($k['nama']) ?></h6>
            <p class="card-text"><?= nl2br(htmlspecialchars($k['isi'])) ?></p>
            <p class="card-text">
                <small class="text-muted"><?= $k['created_at'] ?></small>
            </p>

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $k['user_id']): ?>
                <div class="d-flex justify-content-end">
                    <a href="edit_komentar.php?id=<?= $k['id'] ?>" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                    <a href="hapus_komentar.php?id=<?= $k['id'] ?>&debat_id=<?= $id ?>" class="btn btn-sm btn-outline-danger">Hapus</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>
<?php if (isset($_SESSION['user'])): ?>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="isi" class="form-label">Tulis Komentar</label>
            <textarea name="isi" id="isi" rows="4" class="form-control" placeholder="Tulis komentar..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
    </form>
<?php else: ?>
    <p><a href="login.php" class="btn btn-outline-secondary">Login</a> untuk ikut berkomentar.</p>
<?php endif; ?>

</body>
</html>
