<?php
session_start();

// --- BARIS PERBAIKAN START ---
// Cek apakah pengguna belum login
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header("location: login.php");
    exit(); // Penting untuk menghentikan eksekusi script setelah redirection
}
// --- BARIS PERBAIKAN END ---

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "layout/header.html" ?>
   <h1>SELAMAT DATANG <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'User' ?></h1>
    <form action="dashboard.php" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
    <?php include "layout/footer.html" ?>
</body>
</html>