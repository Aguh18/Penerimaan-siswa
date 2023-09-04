<?php
$conn = mysqli_connect("localhost", "root", "", "pendaftaran_siswa");

function register($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $data["confirmPassword"]);
    $role = 2;
    //Cek username duplikat atau tidak
    $usernameSama = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_fetch_assoc($usernameSama)) {
        echo "<script>
        alert('REGISTRASI GAGAL! Username sudah terdaftar.');
        document.location.href = 'register.php';
        </script>";
        return false;
    }

    //Cek password dan confirmPassword sama atau tidak
    if ($password != $confirmPassword) {
        echo "<script>
        alert('REGISTRASI GAGAL! Password dan konfirmasi Password tidak sama.');
        document.location.href = 'register.php';
        </script>";
        return false;
    }

    //Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //Kirim data ke database
    mysqli_query($conn, "INSERT INTO user
    VALUES
    ('', '$username', '$password', '$role')");

    return mysqli_affected_rows($conn);
}

function login($data)
{
    global $conn;

    $username = strtolower($data["username"]);
    $password = $data["password"];

    //Cek akun tersedia atau tidak
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($result) != 1) {
        echo "<script>
        alert('LOGIN GAGAL! Username dan Password tidak terdaftar.');
        document.location.href = 'login.php';
        </script>";
        return false;
    }

    //Cek password
    $dataUser = mysqli_fetch_assoc($result);
    if (!password_verify($password, $dataUser["password"])) {
        echo "<script>
        alert('LOGIN GAGAL! Username dan Password tidak terdaftar.');
        document.location.href = 'login.php';
        </script>";
        return false;
    }

    return true;
}

function daftar($data)
{
    global $conn;

    $nik = htmlspecialchars($data["nik"]);
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $asals = htmlspecialchars($data["asals"]);
    $telp = htmlspecialchars($data["telp"]);
    $jurusan = $data["jurusan"];
    $ver = 1;
    $pendaftar = $data["pendaftar"];

    //Cek nik
    $result = mysqli_query($conn, "SELECT * FROM siswa WHERE nik='$nik'");
    if (mysqli_num_rows($result) > 0) {
        echo "<script>
        alert('PENDAFTARAN SISWA GAGAL! Data siswa dengan NIK tersebut sudah terdaftar.');
        document.location.href = 'daftar.php';
        </script>";
        return false;
    }

    //Insert data ke database
    mysqli_query($conn, "INSERT INTO siswa
    VALUES
    ('', '$nik', '$nama', '$alamat', '$telp', '$jurusan', '$ver', '$pendaftar','$asals');");

    return mysqli_affected_rows($conn);
}

function pendaftaranKu($id)
{
    global $conn;

    return mysqli_query($conn, "SELECT * FROM siswa WHERE pendaftar='$id'");
}

function dataWhere($id)
{
    global $conn;

    return mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
}

function siswa()
{
    global $conn;

    return mysqli_query($conn, "SELECT * FROM siswa");
}

function siswaJurusan($jurusan)
{
    global $conn;

    return mysqli_query($conn, "SELECT * FROM siswa WHERE jurusan='$jurusan'");
}

function siswaWhere($id)
{
    global $conn;

    $id = $id;
    $result = mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
    if (mysqli_num_rows($result) == 0) {
        echo "<script>
        document.location.href = 'dataSiswa.php';
        </script>";
    }

    return mysqli_fetch_assoc($result);
}

function ubahData($data)
{
    global $conn;

    $id = htmlspecialchars($data["id"]);
    $nik = htmlspecialchars($data["nik"]);
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $asals = htmlspecialchars($data["asals"]);
    $telp = htmlspecialchars($data["telp"]);
    $jurusan = $data["jurusan"];
    $ver = htmlspecialchars($data["ver"]);
    $pendaftar = $data['pendaftar'];

    mysqli_query(
        $conn,
        "UPDATE siswa SET
        nik = '$nik',
        nama = '$nama',
        alamat = '$alamat',
        telp = '$telp',
        jurusan = '$jurusan',
        ver = '$ver',
        pendaftar = '$pendaftar',
        asals = '$asals'
        WHERE id='$id'"
    );

    return mysqli_affected_rows($conn);
}


function hapus($id)
{
    global $conn;

    $id = $id;
    $result = mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('GAGAL MENGHAPUS DATA SISWA! Siswa tidak tersedia');
        document.location.href='dataSiswa.php';
        </script>";
        return false;
    }

    mysqli_query($conn, "DELETE FROM siswa WHERE id=$id");
    echo "<script>alert('BERHASIL MENGHAPUS DATA SISWA!');
    document.location.href='dataSiswa.php';
    </script>";
    return false;
}

function hapusSiswa($id)
{
    global $conn;

    $id = $id;
    $result = mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('GAGAL MENGHAPUS DATA SISWA! Siswa tidak tersedia');
        document.location.href='dashboard.php';
        </script>";
        return false;
    }

    mysqli_query($conn, "DELETE FROM siswa WHERE id=$id");
    echo "<script>alert('BERHASIL MENGHAPUS DATA SISWA!');
    document.location.href='dashboard.php';
    </script>";
    return false;
}

function verifikasi($id)
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('GAGAL MEMVERIFIKASI SISWA! Siswa tidak tersedia.');
        document.location.href='dashboard.php';
        </script>";
        return false;
    }

    $siswa = mysqli_fetch_assoc($result);
    if ($siswa['ver'] != 1) {
        echo "<script>alert('SISWA SUDAH TERVERIFIKASI!');
        document.location.href='dataSiswa.php';
        </script>";
        return false;
    }

    $ver = 2;
    mysqli_query(
        $conn,
        "UPDATE siswa SET
        ver = '$ver'
        WHERE id='$id'"
    );

    return mysqli_affected_rows($conn);
}

function tidakLulus($id)
{
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'");
    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('GAGAL MEMVERIFIKASI SISWA! Siswa tidak tersedia.');
        document.location.href='dashboard.php';
        </script>";
        return false;
    }

    $siswa = mysqli_fetch_assoc($result);
    if ($siswa['ver'] != 1) {
        echo "<script>alert('SISWA SUDAH TERVERIFIKASI!');
        document.location.href='dataSiswa.php';
        </script>";
        return false;
    }

    $ver = 3;
    mysqli_query(
        $conn,
        "UPDATE siswa SET
        ver = '$ver'
        WHERE id='$id'"
    );

    return mysqli_affected_rows($conn);
}
