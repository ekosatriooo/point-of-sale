<?php
require_once '../database/koneksi.php';
$halaman = 'laporan_penjualan_superadmin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Laporan Penjualan</title>

    <?php
    include '../library.php';
    ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">POS</span>
            </a>
            <div class="sidebar">
                <?php include '../sidebar_superadmin.php'; ?>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-filter"></i> Filter Laporan Penjualan</h3>
                            </div>
                            <div class="card-body">
                                <form action="index.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Dari Tanggal</label>
                                                <input type="date" name="tgl_awal" class="form-control" required
                                                    value="<?= isset($_POST['tgl_awal']) ? $_POST['tgl_awal'] : date('Y-m-01') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sampai Tanggal</label>
                                                <input type="date" name="tgl_akhir" class="form-control" required
                                                    value="<?= isset($_POST['tgl_akhir']) ? $_POST['tgl_akhir'] : date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>&nbsp;</label><br>
                                                <button type="submit" name="filter" class="btn btn-primary"><i
                                                        class="fas fa-search"></i> Tampilkan Data</button>
                                                <a href="index.php" class="btn btn-default"><i
                                                        class="fas fa-sync-alt"></i> Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Penjualan</h3>
                                <div class="card-tools">
                                    <?php
                                    if (isset($_POST['filter'])) {
                                        $tgl_awal = $_POST['tgl_awal'];
                                        $tgl_akhir = $_POST['tgl_akhir'];
                                    ?>
                                    <a href="cetak_pdf.php?awal=<?= $tgl_awal ?>&akhir=<?= $tgl_akhir ?>"
                                        target="_blank" class="btn btn-danger btn-sm">
                                        <i class="fas fa-file-pdf"></i> Cetak Laporan PDF
                                    </a>
                                    <?php } else { ?>
                                    <a href="cetak_pdf.php?awal=semua&akhir=semua" target="_blank"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-file-pdf"></i> Cetak Laporan PDF (Semua)
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Penjualan</th>
                                            <th>Kode Nota</th>
                                            <th>Status</th>
                                            <th>Total Tagihan</th>
                                            <th>Kas Masuk</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_POST['filter'])) {
                                            $tgl_awal = $_POST['tgl_awal'];
                                            $tgl_akhir = $_POST['tgl_akhir'];
                                            $query = mysqli_query($db, "SELECT tbl_nota_penjualan.*, tbl_supplier.nama_supplier 
                                        FROM tbl_nota_penjualan 
                                        LEFT JOIN tbl_supplier ON tbl_nota_penjualan.kode_supplier = tbl_supplier.kode_supplier 
                                        WHERE tbl_nota_penjualan.tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                        ORDER BY tbl_nota_penjualan.tgl_penjualan ASC") or die(mysqli_error($db));
                                        } else {
                                            $query = mysqli_query($db, "SELECT tbl_nota_penjualan.*, tbl_supplier.nama_supplier 
                                        FROM tbl_nota_penjualan 
                                        LEFT JOIN tbl_supplier ON tbl_nota_penjualan.kode_supplier = tbl_supplier.kode_supplier 
                                        ORDER BY tbl_nota_penjualan.tgl_penjualan DESC") or die(mysqli_error($db));
                                        }

                                        $rv = mysqli_num_rows($query);
                                        $grand_total_kas = 0;

                                        if ($rv > 0) {
                                            $no = 1;
                                            while ($data = mysqli_fetch_array($query)) {
                                                $tgl_penjualan = $data['tgl_penjualan'];
                                                $kode_nota = $data['kode_nota'];
                                                $status = $data['status'];
                                                $total_tagihan = $data['total_penjualan'];

                                                $kas_keluar = 0;
                                                $warna_status = "";

                                                if ($status == 'L') {
                                                    $teks_status = "Lunas";
                                                    $warna_status = "badge badge-success"; // Hijau
                                                    $kas_keluar = $total_tagihan;
                                                } elseif ($status == '2') {
                                                    $teks_status = "Dibayar 25%";
                                                    $warna_status = "badge badge-danger"; // Merah
                                                    $kas_keluar = $total_tagihan * 0.25;
                                                } elseif ($status == '3') {
                                                    $teks_status = "Dibayar 50%";
                                                    $warna_status = "badge badge-warning"; // Kuning
                                                    $kas_keluar = $total_tagihan * 0.50;
                                                } elseif ($status == '4') {
                                                    $teks_status = "Dibayar 75%";
                                                    $warna_status = "badge badge-info"; // Biru
                                                    $kas_keluar = $total_tagihan * 0.75;
                                                }

                                                $grand_total_kas += $kas_keluar;
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= date('d-m-Y', strtotime($tgl_penjualan)); ?></td>
                                            <td><?= $kode_nota; ?></td>
                                            <td><span class="<?= $warna_status; ?>"><?= $teks_status; ?></span></td>
                                            <td class="text-right">Rp <?= number_format($total_tagihan, 0, ',', '.'); ?>
                                            </td>
                                            <td>Rp<?= number_format($kas_keluar, 0, ',', '.'); ?></td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="6" class="text-center">Tidak ada data transaksi pada rentang waktu ini.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-right">TOTAL KAS MASUK :</th>
                                            <th>Rp<?= number_format($grand_total_kas, 0, ',', '.'); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">POS</a>.</strong> All rights reserved.
        </footer>
    </div>

    <?php include '../script.php'; ?>
</body>

</html>