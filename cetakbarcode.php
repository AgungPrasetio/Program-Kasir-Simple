<?php
// require('fpdf181/ean13.php');

require_once "__class/BarangController.php";
$controller = new BarangController();

require('fpdf181/code_128.php');

$kode = $_GET['kode'];
$nama_barang = $controller->get_nama_barang($kode);

// $pdf=new PDF_EAN13();
$pdf = new PDF_Code128;
$pdf->AddPage('L','A5');
$pdf->SetFont('Arial','',10);

$X = 10;
$Y = 26;

// $pdf->EAN13($X,$Y,$kode);
$pdf->SetFont('Arial','B',30);
$pdf->Cell(50,20,$nama_barang,30);
$pdf->Ln();
$pdf->Code128($X, $Y, $kode, "170", "40");
$pdf->Cell(0,85,$kode,0);

$pdf->Output();
?>