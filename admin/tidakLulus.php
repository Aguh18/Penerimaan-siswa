<?php
session_start();
require "../functions.php";

if (isset($_SESSION["login"])) {
    if ($_SESSION["role"] == 2) {
        header("Location: ../user/daftar.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (tidakLulus($id) > 0) {
        echo "<script>alert('KONFIRMASI SISWA BERHASIL!');
        document.location.href = 'dashboard.php';</script>";
    }
} else {
    header("Location: ../index.php");
    exit;
}
