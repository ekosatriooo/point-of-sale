<?php
require_once '../database/koneksi.php';

require_once '../asset_adminlte/fpdf/fpdf.php';

$kode_nota = $_GET['kode-nota'];

// 1. Inisialisasi Kertas 58mm
$pdf = new FPDF('P', 'mm', array(58, 200));
$pdf->SetMargins(2, 5, 2); 
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

// 2. Header Toko
$pdf->SetFont('Courier', 'B', 12);
$pdf->Cell(54, 5, 'Toko POS', 0, 1, 'C');
$pdf->SetFont('Courier', '', 8);
$pdf->Cell(54, 4, '================================', 0, 1, 'C');

// 3. Info Nota
$pdf->Cell(15, 4, 'Nota', 0, 0, 'L');
$pdf->Cell(39, 4, ': ' . $kode_nota, 0, 1, 'L');
$pdf->Cell(15, 4, 'Tgl', 0, 0, 'L');
$pdf->Cell(39, 4, ': ' . date('d-m-Y'), 0, 1, 'L');
$pdf->Cell(54, 4, '--------------------------------', 0, 1, 'C');

// 4. Query Data Detail Penbelian
$stmt = mysqli_prepare($db, "
    SELECT d.jumlah, d.harga_beli, (d.jumlah * d.harga_beli) AS subtotal, b.nama_brg 
    FROM tbl_detail_notabeli d 
    JOIN tbl_barang b ON d.kode_brg = b.kode_brg 
    WHERE d.kode_nota = ?
");

mysqli_stmt_bind_param($stmt, "s", $kode_nota);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$total_belanja = 0;

// 5. Looping Daftar Barang
while ($row = mysqli_fetch_assoc($result)) {
    $nama_brg = substr($row['nama_brg'], 0, 24); 
    $pdf->Cell(54, 4, $nama_brg, 0, 1, 'L');
    
    $detail_item = $row['jumlah'] . ' x ' . number_format($row['harga_beli'], 0, ',', '.');
    $subtotal = $row['jumlah'] * $row['harga_beli'];
    $total_item = number_format($subtotal, 0, ',', '.');
    
    $pdf->Cell(34, 4, $detail_item, 0, 0, 'L');
    $pdf->Cell(20, 4, $total_item, 0, 1, 'R');
    
    $total_belanja += $subtotal;
}

// 6. Total dan Footer
$pdf->Cell(54, 4, '--------------------------------', 0, 1, 'C');
$pdf->SetFont('Courier', 'B', 9);
$pdf->Cell(34, 4, 'TOTAL:', 0, 0, 'L');
$pdf->Cell(20, 4, number_format($total_belanja, 0, ',', '.'), 0, 1, 'R');

// 7. Render PDF ke Browser
$pdf->Output('I', 'Nota_'.$kode_nota.'.pdf');
?>