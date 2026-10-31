<?php
require_once '../database/koneksi.php';
$peran = $_SESSION['peran'];
if ($peran != 'S') {
    echo '<script>window.location.href="../logout.php"</script>';
} else {
    $halaman = 'home_superadmin';

    $qNota = mysqli_query($db, "SELECT kode_nota FROM tbl_nota_penjualan WHERE tgl_penjualan >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)") or die(mysqli_error($db));

    $listNota = [];
    while ($rNota = mysqli_fetch_assoc($qNota)) {
        $listNota[] = "'" . mysqli_real_escape_string($db, $rNota['kode_nota']) . "'";
    }

    $dataBarangLaris = [];

    if (!empty($listNota)) {
        $strNota = implode(",", $listNota);
        $qDetail = mysqli_query($db, "SELECT kode_brg, SUM(jumlah) AS total_terjual FROM tbl_detail_notajual WHERE kode_nota IN ($strNota) GROUP BY kode_brg ORDER BY total_terjual DESC LIMIT 5") or die(mysqli_error($db));

        while ($rDetail = mysqli_fetch_assoc($qDetail)) {
            $kodeBrg = $rDetail['kode_brg'];
            $totalTerjual = $rDetail['total_terjual'];

            $qBrg = mysqli_query($db, "SELECT nama_brg FROM tbl_barang WHERE kode_brg = '$kodeBrg'") or die(mysqli_error($db));
            $rBrg = mysqli_fetch_assoc($qBrg);
            $namaBarang = $rBrg['nama_brg'] ?? $kodeBrg;

            $dataBarangLaris[] = [
                'kode_brg'     => $kodeBrg,
                'nama_brg'     => $namaBarang,
                'total_terjual' => $totalTerjual
            ];
        }
    }

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
    } else {
        $q_jual = mysqli_query($db, "SELECT total_penjualan, status FROM tbl_nota_penjualan");
        $q_beli = mysqli_query($db, "SELECT total_pembelian, status FROM tbl_nota");
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
        $nominal_tampil = $hasil_keuangan;
    } elseif ($hasil_keuangan < 0) {
        $teks_hasil = "Rugi";
        $nominal_tampil = abs($hasil_keuangan);
    } else {
        $teks_hasil = "Impas";
        $nominal_tampil = 0;
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>POS | Beranda</title>

        <?php
        include '../library.php';
        ?>
    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            Hallo,
                            <?= $_SESSION['nama_panggilan'] ?> <i class="far fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-book mr-2"></i> Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="../logout.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="#" class="brand-link">
                    <span class="brand-text font-weight-light">POS</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <?php
                    include '../sidebar_superadmin.php';
                    ?>
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Dashboard</h1>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-4 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>Rp
                                            <?= number_format($grand_total_pemasukan, 0, ',', '.') ?></h3>
                                        <p>Total Pembelian</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <a href="../laporan_pembelian_superadmin" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-4 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>Rp
                                            <?= number_format($grand_total_pengeluaran, 0, ',', '.') ?></h3>
                                        <p>Total Penjualan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <a href="../laporan_penjualan_superadmin" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-4 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>Rp
                                            <?= number_format($nominal_tampil, 0, ',', '.') ?></h3>
                                        <p>Hasil Akhir : <span style="font-size: 16px;"><?= $teks_hasil ?></span>
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-balance-scale"></i>
                                    </div>
                                    <a href="../laporan_labarugi_superadmin" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header border-transparent">
                                        <h3 class="card-title">Top 5 Barang Paling Laris</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table m-0 table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px;">No</th>
                                                        <th>Nama Barang</th>
                                                        <th class="text-center">Total Terjual</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($dataBarangLaris)) {
                                                        $no = 1;
                                                        foreach ($dataBarangLaris as $row) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $no++; ?></td>
                                                                <td><?php echo htmlspecialchars($row['nama_brg']); ?>
                                                                    (<?php echo htmlspecialchars($row['kode_brg']); ?>)</td>
                                                                <td class="text-center">
                                                                    <span><?php echo number_format($row['total_terjual']); ?>
                                                                        unit</span>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center text-muted">Belum ada transaksi
                                                                dalam 1 bulan terakhir.</td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">POS</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 3.2.0
                </div>
            </footer>
        </div>
        <!-- ./wrapper -->

        <?php
        include '../script.php';
        ?>
    </body>

    </html>
<?php } ?>