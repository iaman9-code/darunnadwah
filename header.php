<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Darunnadwah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Darunnadwah</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="tambah_debat.php">Tambah Debat</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Daftar</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
