<?php
include "service/database.php"; // Memanggil koneksi database
session_start(); // Memulai session

// --- Perbaikan 2: Inisialisasi Variabel untuk menghindari Warning Undefined Variable ---
$_register_message = "";
// -------------------------------------------------------------------------------------

// Cek apakah pengguna sudah login, jika ya, arahkan ke dashboard
if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit();
}

// Logika saat tombol 'register' di-submit
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Algoritma sha256 menghasilkan hash sepanjang 64 karakter heksadesimal
    $hash_password = hash("sha256", $password);

    try {
        // Tambahkan user baru kedatabase
        $sql = "INSERT INTO user (username, password) VALUES ('$username', '$hash_password')";
        
        // Cek Konfirmasi Password
        if ($db->query($sql)) {
            // Jika berhasil
            echo "<script>alert('User Baru berhasil ditambahkan!');</script>";
            $_register_message = "User Baru Berhasil ditambahkan";
            
            // Redirect ke halaman login setelah registrasi berhasil (Opsional)
            // header("location: login.php");
            // exit();

        } else {
            // Jika gagal
            echo "<script>alert('User Baru GAGAL, Silahkan Coba Lagi!');</script>";
            $_register_message = "User Baru GAGAL, Silahkan Coba Lagi!";
        }
    } catch (mysqli_sql_exception $e) {
        // Menangani error jika username sudah ada (Unique Key Constraint)
        echo "<script>alert('User Sudah Ada, Silahkan Ganti yang lain!');</script>";
    }
    
    $db->close(); // Tutup koneksi database
}

// Perlu diingat: Penggunaan SHA256 dan interpolasi variabel di query ($sql) tidak aman.
// Sebaiknya gunakan password_hash/password_verify dan Prepared Statements.

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
    <main>
        <h3>DAFTAR AKUN</h3>
        <i><?= $_register_message ?></i>
        <form action="register.php" method="POST">
            <input type="text" placeholder="Username" name="username"/>
            <input type="password" placeholder="Password" name="password"/>
            <button type="submit" name="register">Register</button>
        </form>
    </main>
    <?php include "layout/footer.html" ?>
</body>
</html>