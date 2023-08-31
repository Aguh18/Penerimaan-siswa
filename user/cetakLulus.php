<?php
session_start();
require "../functions.php";
require('../FPDF/fpdf.php');

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
    $result = dataWhere($id);
    $dataSiswa = mysqli_fetch_assoc($result);
} else {
    header('Location: dataSiswa.php');
    exit;
}

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 30);
$pdf->SetX(23);
$pdf->Cell(40, 40, 'LAPORAN KETERANGAN LULUS');

$pdf->SetFont('Arial', 'U', 30);
$pdf->SetX(16);
$pdf->Cell(40, 50, '______________________________');

$pdf->SetFont('Arial', '', 12);
$pdf->SetX(140);
$pdf->Cell(40, 100, 'Lombok, ' . date('d M Y'));

$pdf->SetFont('Arial', '', 12);
$pdf->SetX(30);
$pdf->Cell(40, 160, 'Berdasarkan keputusan yang menerangkan bahwa status pendaftaran');
$pdf->SetX(20);
$pdf->Cell(40, 170, 'calon peserta didik:');

$pdf->SetFont('Arial', '', 12);
$pdf->SetX(40);
$pdf->Cell(40, 185, 'NIK         : ' . $dataSiswa['nik']);
$pdf->SetX(40);
$pdf->Cell(40, 200, 'Nama     : ' . $dataSiswa['nama']);
$pdf->SetX(40);
$pdf->Cell(40, 215, 'Alamat    : ' . $dataSiswa['alamat']);
$pdf->SetX(40);
$pdf->Cell(40, 230, 'Telp        : ' . $dataSiswa['telp']);
$pdf->SetX(40);
$pdf->Cell(40, 245, 'Jurusan  : ' . $dataSiswa['jurusan']);
$pdf->SetX(20);
$pdf->Cell(40, 260, 'Telah dinyatakan:');

$pdf->SetFont('Arial', 'B', 30);
$pdf->SetY(155);
$pdf->SetX(16);
$pdf->Cell(180, 20, 'L U L U S', 1, 0, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetX(30);
$pdf->Cell(40, 70, 'Demikian pernyataan penerimaan siswa yang kami sampaikan. Teruntuk siswa');
$pdf->SetX(20);
$pdf->Cell(40, 80, 'dengan keterangan LULUS, silahkan melakukkan daftar ulang dengan membawa syarat');
$pdf->SetX(20);
$pdf->Cell(40, 90, 'berupa LAPORAN KETERANGAN LULUS yang telah dicetak. Atas perhatiannya, kami');
$pdf->SetX(20);
$pdf->Cell(40, 100, 'ucapkan terima kasih.');


$pdf->Output();
