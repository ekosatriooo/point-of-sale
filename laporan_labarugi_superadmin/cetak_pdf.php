<?php
// Panggil koneksi database
require_once '../database/koneksi.php';

// Panggil library FPDF
require_once '../asset_adminlte/fpdf/fpdf.php';

$tgl_awal = $_GET['awal'];
$tgl_akhir = $_GET['akhir'];

if ($tgl_awal == 'semua') {
    $periode = "Semua Waktu";
    $q_jual = mysqli_query($db, "SELECT total_penjualan, status FROM tbl_nota_penjualan");
    $q_beli = mysqli_query($db, "SELECT total_pembelian, status FROM tbl_nota");
} else {
    $periode = date('d-m-Y', strtotime($tgl_awal)) . " s/d " . date('d-m-Y', strtotime($tgl_akhir));
    $q_jual = mysqli_query($db, "SELECT total_penjualan, status FROM tbl_nota_penjualan WHERE tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    $q_beli = mysqli_query($db, "SELECT total_pembelian, status FROM tbl_nota WHERE tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir'");
}

$grand_total_pemasukan = 0;
while ($jual = mysqli_fetch_array($q_jual)) {
    $nominal = $jual['total_penjualan'];
    $status = $jual['status'];
    if ($status == 'L') { $grand_total_pemasukan += $nominal; } 
    elseif ($status == '2') { $grand_total_pemasukan += $nominal * 0.25; } 
    elseif ($status == '3') { $grand_total_pemasukan += $nominal * 0.50; } 
    elseif ($status == '4') { $grand_total_pemasukan += $nominal * 0.75; }
}

$grand_total_pengeluaran = 0;
while ($beli = mysqli_fetch_array($q_beli)) {
    $nominal = $beli['total_pembelian'];
    $status = $beli['status'];
    if ($status == 'L') { $grand_total_pengeluaran += $nominal; } 
    elseif ($status == '2') { $grand_total_pengeluaran += $nominal * 0.25; } 
    elseif ($status == '3') { $grand_total_pengeluaran += $nominal * 0.50; } 
    elseif ($status == '4') { $grand_total_pengeluaran += $nominal * 0.75; }
}

$hasil_keuangan = $grand_total_pemasukan - $grand_total_pengeluaran;

if ($hasil_keuangan > 0) {
    $nominal_tampil = $hasil_keuangan;
} elseif ($hasil_keuangan < 0) {
    $nominal_tampil = abs($hasil_keuangan);
} else {
    $nominal_tampil = 0;
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 7, 'TOKO POS', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 7, 'LAPORAN REKAPITULASI LABA RUGI', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(190, 7, 'Dicetak pada: ' . date('d-m-Y H:i'), 0, 1, 'C');

$pdf->SetLineWidth(0.5);
$pdf->Line(10, 35, 200, 35);
$pdf->SetLineWidth(0.2);
$pdf->Ln(10);

// HEADER TABEL
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 10, 'Kas Masuk (Penjualan)', 1, 0, 'C');
$pdf->Cell(60, 10, 'Kas Keluar (Pembelian)', 1, 0, 'C');
$pdf->Cell(70, 10, 'Hasil Bersih', 1, 1, 'C');

// ISI TABEL
$pdf->SetFont('Arial', '', 9);
// Pemasukan
$pdf->Cell(60, 10, 'Rp ' . number_format($grand_total_pemasukan, 0, ',', '.'), 1, 0, 'C');
// Pengeluaran
$pdf->Cell(60, 10, 'Rp ' . number_format($grand_total_pengeluaran, 0, ',', '.'), 1, 0, 'C');
// Hasil
$pdf->Cell(70, 10, 'Rp ' . number_format($nominal_tampil, 0, ',', '.'), 1, 1, 'C');

// =======================================================

$pdf->Ln(25);
$pdf->SetFont('Arial', '', 10);
$pdf->SetX(130);
$pdf->Cell(60, 5, 'Purwokerto, ' . date('d-m-Y'), 0, 1, 'C');
$pdf->SetX(130);
$pdf->Cell(60, 5, 'Mengetahui,', 0, 1, 'C');

$pdf->Ln(20);

$pdf->SetX(130);
$pdf->SetFont('Arial', 'BU', 10);
$pdf->Cell(60, 5, 'Superadmin POS', 0, 1, 'C');

// Tampilkan PDF
$pdf->Output('I', 'Laporan_LabaRugi_' . $periode . '.pdf');
?>