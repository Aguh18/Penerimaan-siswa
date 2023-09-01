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

if (isset($_GET['jurusan'])) {
    $jurusan = $_GET['jurusan'];
    $dataSiswa = siswaJurusan($jurusan);
} else {
    $dataSiswa = siswa();
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

    <title>Administrator - Pendaftaran Siswa</title>
</head>

<!-- hapus class di body -->
<!-- <body class="bg-body-secondary"> -->
<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: green">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bolder" href="../index.php">PENDAFTARAN SISWA <small class="fw-normal">Administrator</small></a>
            <a class="nav-link float-end text-white fw-semibold" href="../auth/logout.php">LOGOUT</a>
        </div>
    </nav>

    <div class="row mx-auto mt-5">
        <div class="col">
            <div class="card shadow p-3 mb-5 bg-body-tertiary rounded mt-4" style="width: 16rem; height: 30rem">
                <div class="card-body text-center ">
                    <h5>MENU</h5>
                    <br><br>
                    <a href="dashboard.php" class="text-decoration-none text-primary">DASHBOARD</a>
                    <hr>
                    <a href="dashboard.php?jurusan=IPA" class="text-decoration-none text-primary">SISWA IPA</a>
                    <hr>
                    <a href="dashboard.php?jurusan=IPS" class="text-decoration-none text-primary">SISWA IPS</a>
                    <hr>
                    <a href="../auth/logout.php" class="text-decoration-none text-danger ">LOGOUT</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class=" card shadow p-3 mb-5 bg-body-tertiary rounded mt-4" style="width: 65rem">
                <div class="card-body text-center ">
                    <h1 class="mb-5">Dashboard</h1>
                    <table class="table table-light table-responsive">
                        <tr>
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telp</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Kelulusan</th>
                            <th>Aksi</th>
                        </tr>
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
                                    if ($siswa["ver"] == 1) {
                                    ?>
                                        <a href="verifikasi.php?id=<?= $siswa['id'] ?>" class="text-decoration-none text-success">VERIFIKASI</a> |
                                        <a href="tidakLulus.php?id=<?= $siswa['id'] ?>" class="text-decoration-none text-success">TIDAK LULUS</a> |
                                    <?php
                                    } else {
                                    ?>
                                        Confirmed!
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
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>