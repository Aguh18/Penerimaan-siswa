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
    $id = $_GET["id"];
    $dataSiswa = siswaWhere($id);
} else {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST["ubah"])) {
    if (ubahData($_POST) > 0) {
        echo "<script>
        alert('UBAH DATA BERHASIL!');
        document.location.href = 'dashboard.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    <!--penambahan: css untuk semua body  --> 
    <link href="../css/app.css" rel="stylesheet"> 
    <title>Ubah Data Siswa - PENDAFTARAN SISWA</title>
</head>

<!-- <body class="bg-body-secondary"> -->
<body>
    <!-- hapus bg-primary class -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bolder" href="../index.php">PENDAFTARAN SISWA <small class="fw-normal">Administrator</small></a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="dashboard.php">DASHBOARD</a>
                </li>
            </ul>
            <a class="nav-link float-end text-white fw-semibold" href="../auth/logout.php">LOGOUT</a>
        </div>
    </nav>

    <div class="d-flex align-items-center justify-content-center mt-5" style="height: 45rem">
        <div class="card shadow p-3 mb-5 bg-body-tertiary rounded mt-5" style="width: 80rem">
            <div class="card-body text-center p-5">
                <h1 class="mb-5">Ubah Data Siswa</h1>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $dataSiswa['id']; ?>">
                    <input type="hidden" name="nik" value="<?= $dataSiswa['nik']; ?>">
                    <input type="hidden" name="pendaftar" value="<?= $dataSiswa['pendaftar']; ?>">

                    <input type="text" name="nama" class="form-control mb-4" required placeholder="Nama" value="<?= $dataSiswa['nama']; ?>">
                    <input type="text" name="alamat" class="form-control mb-4" required placeholder="Alamat" value="<?= $dataSiswa['alamat']; ?>">
                    <input type="text" name="telp" class="form-control mb-4" required placeholder="Telepon" value="<?= $dataSiswa['telp']; ?>">
                    <input type="text" name="asals" class="form-control mb-4" required placeholder="Asal sekolah" value="<?= $dataSiswa['asals']; ?>">
                    <select class="form-select" name="jurusan">
                        <option>Jurusan</option>
                        <option <?php if ($dataSiswa["jurusan"] == "IPA") { ?> selected <?php } ?> value="IPA">IPA (Ilmu Pengetahuan Alam)</option>
                        <option <?php if ($dataSiswa["jurusan"] == "IPS") { ?> selected <?php } ?> value="IPS">IPS (Ilmu Pengetahuan Sosial)</option>
                    </select>
                    <div class="align-item-center fw-medium mt-4">Status</div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ver" value="1" <?php if ($dataSiswa['ver'] == 1) { ?>checked<?php } ?>>
                        <label class="form-check-label" for="ver">
                            Belum Terverifikasi
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ver" value="2" <?php if ($dataSiswa['ver'] == 2) { ?>checked<?php } ?>>
                        <label class="form-check-label" for="ver">
                            Terverifikasi
                        </label>
                    </div>

                    <button type="submit" name="ubah" class="btn btn-primary mt-5">UBAH</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>