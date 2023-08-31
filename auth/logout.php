<?php
session_start();
if (isset($_SESSION["login"])) {
    session_unset();
    session_destroy();
    echo "<script>alert('SAMPAI JUMPA!');
    document.location.href = 'login.php';</script>";
} else {
    header("Location: ../index.php");
    exit;
}
