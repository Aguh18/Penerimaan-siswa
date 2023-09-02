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

    <!-- penambahan: lokasi tempat -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>

    <!--penambahan: css untuk semua body  -->
    <link href="../css/app.css" rel="stylesheet"> 

    <title>Data Pendaftaran - PENDAFTARAN SISWA</title>
</head>

<!-- hapus class di body -->
<!-- <body class="bg-body-secondary"> -->
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
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

    <br>
    <!-- tambah class mx-auto -->
        <div class="card shadow p-3 mb-5 bg-body-tertiary rounded mt-5 mx-auto" style="width: 80%">
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
        <!-- penambahan untuk menampilkan map -->
        <div style="right:-80%; bottom:10px; position:relative; height: 250px; width: 250px;background-color:aliceblue; display: inline-block">
            <h3 class="text-center">Lokasi Sekolah</h3>
            <div id="map" style="width:250px; height:250px"></div>
        </div>
        <!-- end -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- script lokasi -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script>
        var map = L.map('map', {
            center: [-6.175398, 106.827157],
            zoom: 12
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Nama Sekolah'
        }).addTo(map);

        // Add marker
        var marker = L.marker([-6.175398, 106.827157]).addTo(map);
        marker.bindPopup('This is the location of the school');
    </script>
    <!-- end scriptlokasi -->
</body>

</html>