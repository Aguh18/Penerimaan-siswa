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

$dataSiswa = pendaftaranKu($_SESSION['id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Data Pendaftaran - PENDAFTARAN SISWA</title>
</head>

<body class="bg-body-secondary">
    <nav class="navbar navbar-expand-lg bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bolder" href="../index.php">PENDAFTARAN SISWA</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="daftar.php">FORMULIR PENDAFTARAN</a>
                </li>
            </ul>
            <a class="nav-link float-end text-white fw-semibold" href="../auth/logout.php">LOGOUT</a>
        </div>
    </nav>

    <center><br>
        <div class="card shadow p-3 mb-5 bg-body-tertiary rounded mt-5" style="width: 80rem">
            <div class="card-body text-center ">
                <h1 class="mb-5">Data Pendaftaran</h1>

                <table class="table table-light">
                    <tr>
                        <th>No.</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Laporan</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    foreach ($dataSiswa as $siswa) {
                    ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $siswa["nik"]; ?></td>
                            <td><?= $siswa["nama"]; ?></td>
                            <td><?= $siswa["alamat"]; ?></td>
                            <td><?= $siswa["telp"]; ?></td>
                            <td><?= $siswa["jurusan"]; ?></td>
                            <td>
                                <?php if ($siswa["ver"] == 1) {  ?>
                                    BELUM TERVERIFIKASI
                                <?php } else if ($siswa["ver"] == 2) { ?>
                                    TERVERIFIKASI
                                <?php } else { ?>
                                    TIDAK LULUS
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                if ($siswa['ver'] == 2) {
                                ?>
                                    <a href="cetakLulus.php?id=<?= $siswa['id'] ?>" class="text-decoration-none text-success">Cetak</a>
                                <?php } else if ($siswa['ver'] == 3) { ?>
                                    <a href="cetakTidakLulus.php?id=<?= $siswa['id'] ?>" class="text-decoration-none text-success">Cetak</a>
                                <?php } else { ?>
                                    -
                                <?php } ?>
                            </td>
                            <td>
                                <a href="ubah.php?id=<?= $siswa['id'] ?>" class="text-decoration-none text-primary">UBAH</a> |
                                <a href="hapus.php?id=<?= $siswa['id'] ?>" class="text-decoration-none text-danger">HAPUS</a>
                            </td>
                        </tr>
                    <?php
                        $no++;
                    }
                    ?>
                </table>

            </div>
        </div>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>