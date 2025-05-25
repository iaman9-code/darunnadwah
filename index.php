<?php
session_start();
include 'db.php';
include 'header.php';

// Ambil data debat dari database
$result = $conn->query("SELECT * FROM debat ORDER BY tanggal DESC");
?>

<h2 class="mb-4">Daftar Debat</h2>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></p>
                <a href="detail_debat.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Lihat Debat</a>
            </div>
            <div class="card-footer text-muted">
                Diposting pada <?= date('d M Y H:i', strtotime($row['tanggal'])) ?>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="alert alert-info">Belum ada topik debat yang tersedia.</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
