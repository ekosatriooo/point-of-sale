<?php
require_once '../database/koneksi.php';
$halaman = 'laporan_labarugi_superadmin';

$default_awal = date('Y-m-01');
$default_akhir = date('Y-m-d');

$val_awal = isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : $default_awal;
$val_akhir = isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : $default_akhir;

if (isset($_POST['filter'])) {
    $tgl_awal = $_POST['tgl_awal'];
    $tgl_akhir = $_POST['tgl_akhir'];

    $q_jual = mysqli_query($db, "SELECT total_penjualan, status FROM tbl_nota_penjualan WHERE tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    $q_beli = mysqli_query($db, "SELECT total_pembelian, status FROM tbl_nota WHERE tgl_pembelian BETWEEN '$tgl_awal' AND '$tgl_akhir'");

    $periode_teks = date('d-m-Y', strtotime($tgl_awal)) . " s/d " . date('d-m-Y', strtotime($tgl_akhir));
    $link_pdf = "cetak_pdf.php?awal=$tgl_awal&akhir=$tgl_akhir";
} else {
    $q_jual = mysqli_query($db, "SELECT total_penjualan, status FROM tbl_nota_penjualan");
    $q_beli = mysqli_query($db, "SELECT total_pembelian, status FROM tbl_nota");

    $periode_teks = "Semua Waktu";
    $link_pdf = "cetak_pdf.php?awal=semua&akhir=semua";
}

$grand_total_pemasukan = 0;
while ($jual = mysqli_fetch_array($q_jual)) {
    $nominal = $jual['total_penjualan'];
    $status = $jual['status'];
    if ($status == 'L') {
        $grand_total_pemasukan += $nominal;
    } elseif ($status == '2') {
        $grand_total_pemasukan += $nominal * 0.25;
    } elseif ($status == '3') {
        $grand_total_pemasukan += $nominal * 0.50;
    } elseif ($status == '4') {
        $grand_total_pemasukan += $nominal * 0.75;
    }
}

$grand_total_pengeluaran = 0;
while ($beli = mysqli_fetch_array($q_beli)) {
    $nominal = $beli['total_pembelian'];
    $status = $beli['status'];
    if ($status == 'L') {
        $grand_total_pengeluaran += $nominal;
    } elseif ($status == '2') {
        $grand_total_pengeluaran += $nominal * 0.25;
    } elseif ($status == '3') {
        $grand_total_pengeluaran += $nominal * 0.50;
    } elseif ($status == '4') {
        $grand_total_pengeluaran += $nominal * 0.75;
    }
}

$hasil_keuangan = $grand_total_pemasukan - $grand_total_pengeluaran;

if ($hasil_keuangan > 0) {
    $teks_hasil = "Laba/Untung";
    $warna_bg = "badge-success";
    $nominal_tampil = $hasil_keuangan;
} elseif ($hasil_keuangan < 0) {
    $teks_hasil = "Rugi";
    $warna_bg = "badge-danger";
    $nominal_tampil = abs($hasil_keuangan);
} else {
    $teks_hasil = "Impas";
    $warna_bg = "badge-warning";
    $nominal_tampil = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Laporan Laba Rugi</title>
    <?php include '../library.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar & Sidebar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        Hallo, <?= $_SESSION['nama_panggilan'] ?> <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item"><i class="fas fa-book mr-2"></i> Profil</a>
                        <div class="dropdown-divider"></div>
                        <a href="../logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            Sistem</a>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link"><span class="brand-text font-weight-light">POS</span></a>
            <div class="sidebar"><?php include '../sidebar_superadmin.php'; ?></div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan Laba Rugi</h3>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Dari Tanggal</label>
                                                <input type="date" name="tgl_awal" class="form-control"
                                                    value="<?= $val_awal ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sampai Tanggal</label>
                                                <input type="date" name="tgl_akhir" class="form-control"
                                                    value="<?= $val_akhir ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="color: transparent;">Aksi</label><br>
                                                <button type="submit" name="filter" class="btn btn-primary mr-2">
                                                    <i class="fas fa-search"></i> Tampilkan Data
                                                </button>
                                                <a href="index.php" class="btn btn-default">
                                                    <i class="fas fa-sync-alt"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Ringkasan Laba Rugi</h3>
                                <?php $teks_tombol_pdf = ($periode_teks == "Semua Waktu") ? "Cetak Laporan PDF (Semua)" : "Cetak Laporan PDF"; ?>
                                <a href="<?= $link_pdf ?>" target="_blank" class="btn btn-danger btn-sm ml-auto"><i
                                        class="fas fa-file-pdf"></i> <?= $teks_tombol_pdf ?></a>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Total Kas Masuk (Penjualan)</th>
                                            <th>Total Kas Keluar (Pembelian)</th>
                                            <th>Hasil Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">Rp
                                                <?= number_format($grand_total_pemasukan, 0, ',', '.') ?></td>
                                            <td class="align-middle">Rp
                                                <?= number_format($grand_total_pengeluaran, 0, ',', '.') ?></td>
                                            <td class="align-middle font-weight-bold" style="font-size: 16px;">Rp
                                                <?= number_format($nominal_tampil, 0, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="#">POS</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>

    <?php include '../script.php'; ?>
</body>

</html>