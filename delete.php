<?php
    require './config/db.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // Hapus data dari database berdasarkan ID
        $query = "DELETE FROM products WHERE id=$id";
        mysqli_query($db_connect, $query);

        header("Location: show.php"); // Redirect kembali ke halaman show.php setelah hapus
    }
?>
