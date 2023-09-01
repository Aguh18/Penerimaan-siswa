<?php
session_start();
require "../functions.php";

if (isset($_SESSION["login"])) {
    if ($_SESSION["role"] == 1) {
        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        header("Location: ../user/daftar.php");
        exit;
    }
}

if (isset($_POST["LOGIN"])) {
    if (login($_POST) == true) {
        $username = $_POST["username"];
        $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
        $dataUser = mysqli_fetch_assoc($result);

        $_SESSION["id"] = $dataUser["id"];
        $_SESSION["role"] = $dataUser["role"];
        $_SESSION["login"] = true;
        echo "<script>alert('LOGIN BERHASIL!');
        document.location.href = 'login.php';</script>";
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

    <title>Login - PENDAFTARAN SISWA</title>
</head>

<!-- hapus class di body -->
<!-- <body class="bg-body-secondary"> -->
<body>
    <div class="d-flex align-items-center justify-content-center" style="height: 40rem">
        <div class="card shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 30rem">
            <div class="card-body text-center p-5">
                <h1 class="mb-5">LOGIN</h1>
                <form action="" method="post">
                    <input type="text" name="username" class="form-control mb-4" required placeholder="Username">
                    <input type="password" name="password" class="form-control mb-5" required placeholder="Password">
                    <label>Don't have an account? <a href="register.php">Register</a></label> <br>
                    <button type="submit" name="LOGIN" class="btn btn-primary mt-2">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>