<?php
// Panggil koneksi database
require_once '../database/koneksi.php';

require_once '../asset_adminlte/fpdf/fpdf.php';

$tgl_awal = $_GET['awal'];
$tgl_akhir = $_GET['akhir'];

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 7, 'TOKO POS', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 7, 'LAPORAN REKAPITULASI PENJUALAN (KAS MASUK)', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
if ($tgl_awal == 'semua') {
    $periode = "Semua Waktu";
} else {
    $periode = date('d-m-Y', strtotime($tgl_awal)) . " s/d " . date('d-m-Y', strtotime($tgl_akhir));
}
$pdf->Cell(190, 7, 'Periode: ' . $periode, 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(30, 8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(25, 8, 'Kode Nota', 1, 0, 'C');
$pdf->Cell(25, 8, 'Status', 1, 0, 'C');
$pdf->Cell(45, 8, 'Total Tagihan', 1, 0, 'C');
$pdf->Cell(55, 8, 'Kas Masuk', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);

if ($tgl_awal == 'semua') {
    $query = mysqli_query($db, "SELECT * FROM tbl_nota_penjualan ORDER BY tgl_penjualan ASC") or die(mysqli_error($db));
} else {
    $query = mysqli_query($db, "SELECT * FROM tbl_nota_penjualan WHERE tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tgl_penjualan ASC") or die(mysqli_error($db));
}

$grand_total_kas = 0;
$no = 1;

while ($data = mysqli_fetch_array($query)) {
    $total_tagihan = $data['total_penjualan'];
    $status = $data['status'];
    
    $kas_masuk = 0;
    if ($status == 'L') { 
        $teks_status = "Lunas"; 
        $kas_masuk = $total_tagihan; 
    } elseif ($status == '2') { 
        $teks_status = "25%"; 
        $kas_masuk = $total_tagihan * 0.25; 
    } elseif ($status == '3') { 
        $teks_status = "50%"; 
        $kas_masuk = $total_tagihan * 0.50; 
    } elseif ($status == '4') { 
        $teks_status = "75%";
        $kas_masuk = $total_tagihan * 0.75; 
    }

    $grand_total_kas += $kas_masuk;

    $pdf->Cell(10, 8, $no++, 1, 0, 'C');
    $pdf->Cell(30, 8, date('d-m-Y', strtotime($data['tgl_penjualan'])), 1, 0, 'C');
    $pdf->Cell(25, 8, $data['kode_nota'], 1, 0, 'C');
    $pdf->Cell(25, 8, $teks_status, 1, 0, 'C');
    $pdf->Cell(45, 8, 'Rp ' . number_format($total_tagihan, 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(55, 8, 'Rp ' . number_format($kas_masuk, 0, ',', '.'), 1, 1, 'R');
}

// FOOTER TABEL (GRAND TOTAL)
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(135, 8, 'TOTAL KAS MASUK', 1, 0, 'R');
$pdf->Cell(55, 8, 'Rp ' . number_format($grand_total_kas, 0, ',', '.'), 1, 1, 'R');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$pdf->SetX(130);
$pdf->Cell(60, 5, 'Purwokerto, ' . date('d-m-Y'), 0, 1, 'C'); 
$pdf->SetX(130);
$pdf->Cell(60, 5, 'Mengetahui,', 0, 1, 'C');
$pdf->Ln(15);
$pdf->SetX(130);
$pdf->SetFont('Arial', 'BU', 10);
$pdf->Cell(60, 5, 'Superadmin POS', 0, 1, 'C');

$pdf->Output('I', 'Laporan_Penjualan_'.$periode.'.pdf');
?>