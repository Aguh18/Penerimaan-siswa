<?php
session_start();
require "../functions.php";

if (isset($_SESSION["login"])) {
    if ($_SESSION["role"] == 1) {
        header("Location: ../admin/dashboard.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET["id"];
    $dataSiswa = siswaWhere($id);
    if ($dataSiswa['pendaftar'] != $_SESSION['id']) {
        header('Location: dataSiswa.php');
        exit;
    }
    hapus($id);
} else {
    header('Location: dataSiswa.php');
}
