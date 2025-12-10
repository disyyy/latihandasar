<?php
include "service/database.php"; // Memanggil koneksi database
session_start(); // Memulai session

// Cek apakah pengguna sudah login, jika ya, arahkan ke dashboard
if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit();
}

// Logika saat tombol 'login' di-submit
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Algoritma sha256 menghasilkan hash sepanjang 64 karakter heksadesimal
    $hash_password = hash("sha256", $password);

    // cek Username pada database
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$hash_password'";
    
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;
        
        header("location:dashboard.php");
        exit();
    } else {
        echo "<script>alert('Akun GAGAL, Silahkan Coba Lagi!');</script>";
    }
    
    $db->close();
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
        <h3>Masukan AKUN</h3>
        <form action="login.php" method="POST">
            <input type="text" placeholder="Username" name="username"/>
            <input type="password" placeholder="Password" name="password"/>
            <button type="submit" name="login">Login</button>
        </form>
    </main>
    <?php include "layout/footer.html" ?>
</body>
</html>