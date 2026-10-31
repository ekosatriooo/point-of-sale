<?php
require_once '../database/koneksi.php';
$halaman = 'nota_beli_kasir';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Detail Nota Beli</title>

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
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link"><span class="brand-text font-weight-light">POS</span></a>
            <div class="sidebar"><?php include '../sidebar_kasir.php'; ?></div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Detail Nota Pembelian</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                $kode_nota = $_GET['kode-nota'];

                                // Mengambil data nota
                                $query_ambil_data = mysqli_query($db, "SELECT * FROM tbl_nota WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
                                $data = mysqli_fetch_array($query_ambil_data);

                                $kode_supplier = $data['kode_supplier'];
                                $tgl_pembelian = $data['tgl_pembelian'];
                                $total_pembelian = $data['total_pembelian'];
                                $status = $data['status'];
                                $keterangan = $data['keterangan'];
                                $jenis_pembayaran = $data['jenis_pembayaran'];
                                if ($status == 'L') {
                                    $teks_status = "Lunas";
                                    $warna_status = "badge badge-success";
                                } elseif ($status == '2') {
                                    $teks_status = "Dibayar 25%";
                                    $warna_status = "badge badge-danger";
                                } elseif ($status == '3') {
                                    $teks_status = "Dibayar 50%";
                                    $warna_status = "badge badge-warning";
                                } elseif ($status == '4') {
                                    $teks_status = "Dibayar 75%";
                                    $warna_status = "badge badge-info";
                                } else {
                                    $teks_status = "-";
                                    $warna_status = "badge badge-secondary";
                                }
                                $query_supplier = mysqli_query($db, "SELECT nama_supplier, kontak_pic FROM tbl_supplier WHERE kode_supplier = '$kode_supplier'") or die(mysqli_error($db));
                                $data_supplier = mysqli_fetch_array($query_supplier);
                                ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td width="35%">Kode Nota</td>
                                                    <td width="5%">:</td>
                                                    <td><strong><?= $kode_nota; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Supplier</td>
                                                    <td>:</td>
                                                    <td><?= $data_supplier['nama_supplier']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Kontak PIC</td>
                                                    <td>:</td>
                                                    <td><?= $data_supplier['kontak_pic']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Tanggal Pembelian</td>
                                                    <td width="5%">:</td>
                                                    <td><?= $tgl_pembelian; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>:</td>
                                                    <td><span class="<?= $warna_status; ?>"><?= $teks_status; ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total Pembelian</td>
                                                    <td>:</td>
                                                    <td>Rp <?= number_format($total_pembelian, 0, ',', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Keterangan</td>
                                                    <td>:</td>
                                                    <td><?= $keterangan; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Pembayaran</td>
                                                    <td>:</td>
                                                    <td><?= $jenis_pembayaran; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class=" card-body" style="border-top: 1px solid #dee2e6;">
                                <a href="../nota_beli_kasir/index.php" class="btn btn-sm btn-default"><i
                                        class="fas fa-arrow-circle-left"></i> Kembali</a>

                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modal-tambah">
                                    <i class="fas fa-plus"></i> Tambah Barang
                                </button>

                                <a href="cetak_nota.php?kode-nota=<?= $kode_nota ?>" class="btn btn-sm btn-primary"
                                    target="_blank"><i class="fas fa-print"></i> Cetak Nota</a>

                                <table id="example1" class="table table-bordered table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga Beli Unit</th>
                                            <th>Total Harga Beli</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_panggil_detail = mysqli_query($db, "SELECT * FROM tbl_detail_notabeli WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
                                        $rv = mysqli_num_rows($query_panggil_detail);

                                        if ($rv > 0) {
                                            $no = 1;
                                            while ($data_detail = mysqli_fetch_array($query_panggil_detail)) {
                                                $kode_brg = $data_detail['kode_brg'];
                                                $jumlah = $data_detail['jumlah'];
                                                $harga_beli = $data_detail['harga_beli'];
                                                $total_harga_beli = $data_detail['total_harga_beli'];

                                                $query_barang = mysqli_query($db, "SELECT nama_brg FROM tbl_barang WHERE kode_brg = '$kode_brg'") or die(mysqli_error($db));
                                                $data_barang = mysqli_fetch_array($query_barang);
                                                $nama_barang = $data_barang['nama_brg'];
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kode_brg; ?></td>
                                            <td><?= $nama_barang; ?></td>
                                            <td><?= $jumlah; ?></td>
                                            <td>Rp <?= number_format($harga_beli, 0, ',', '.'); ?></td>
                                            <td>Rp <?= number_format($total_harga_beli, 0, ',', '.'); ?></td>
                                            <td>
                                                <a href="proses_hapus_barang.php?urut=<?= $data_detail['urut'] ?>&kode-nota=<?= $kode_nota ?>"
                                                    onclick="return confirm('Apakah Kamu Yakin Menghapus Barang Ini dari Nota?')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">POS</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>

    <!-- Modal Tambah Barang ke Nota -->
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_tambah_barang.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="kode_nota" value="<?= $kode_nota ?>">
                            <label>Pilih Barang</label>
                            <select name="kode_brg" id="kode_brg" class="form-control" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php
                                $query_panggil_brg = mysqli_query($db, "SELECT kode_brg, nama_brg FROM tbl_barang WHERE kode_supplier = '$kode_supplier'") or die(mysqli_error($db));
                                if (mysqli_num_rows($query_panggil_brg) > 0) {
                                    while ($data_brg = mysqli_fetch_array($query_panggil_brg)) {
                                ?>
                                <option value="<?= $data_brg['kode_brg'] ?>"><?= $data_brg['kode_brg'] ?> -
                                    <?= $data_brg['nama_brg'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Beli (Satuan)</label>
                            <input type="number" name="harga_beli" class="form-control" min="1" required>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="btn_tambah_barang" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include '../script.php';
    ?>

</body>

</html>