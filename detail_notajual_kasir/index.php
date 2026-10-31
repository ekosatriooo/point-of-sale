<?php
require_once '../database/koneksi.php';
$halaman = 'nota_jual_kasir';

// TANGKAP KODE NOTA DAN FILTER JENIS BARANG
$kode_nota = $_GET['kode-nota'];
$filter_jenis = isset($_GET['jenis']) ? $_GET['jenis'] : 'semua';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Detail Nota Penjualan</title>
    <?php include '../library.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a></li>
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

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link"><span class="brand-text font-weight-light">POS</span></a>
            <div class="sidebar"><?php include '../sidebar_kasir.php'; ?></div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">

                        <!-- KOTAK INFORMASI HEADER NOTA -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Nota Penjualan</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                $query_ambil_data = mysqli_query($db, "SELECT * FROM tbl_nota_penjualan WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
                                $data = mysqli_fetch_array($query_ambil_data);

                                $kode_supplier = $data['kode_supplier']; // Jika form ini ada suppliernya (biasanya pelanggan)
                                $tgl_penjualan = $data['tgl_penjualan'];
                                $status = $data['status'];
                                $keterangan = $data['keterangan'];
                                $jenis_pembayaran = $data['jenis_pembayaran'];
                                
                                // AUTO UPDATE TOTAL PENJUALAN
                                $query_hitung_total = mysqli_query($db, "SELECT SUM(total_harga_jual) AS total_aktual FROM tbl_detail_notajual WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
                                $data_hitung = mysqli_fetch_array($query_hitung_total);
                                $total_penjualan = ($data_hitung['total_aktual'] == "") ? 0 : $data_hitung['total_aktual'];

                                mysqli_query($db, "UPDATE tbl_nota_penjualan SET total_penjualan = '$total_penjualan' WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));

                                // LABEL WARNA STATUS
                                if ($status == 'L') { $teks_status = "Lunas"; $warna_status = "badge badge-success"; } 
                                elseif ($status == '2') { $teks_status = "Dibayar 25%"; $warna_status = "badge badge-danger"; } 
                                elseif ($status == '3') { $teks_status = "Dibayar 50%"; $warna_status = "badge badge-warning"; } 
                                elseif ($status == '4') { $teks_status = "Dibayar 75%"; $warna_status = "badge badge-info"; } 
                                else { $teks_status = "-"; $warna_status = "badge badge-secondary"; }

                                // MENGAMBIL NAMA SUPPLIER/PELANGGAN
                                $query_supplier = mysqli_query($db, "SELECT nama_supplier FROM tbl_supplier WHERE kode_supplier = '$kode_supplier'") or die(mysqli_error($db));
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
                                                    <td>Pelanggan / Supplier</td>
                                                    <td>:</td>
                                                    <td><?= isset($data_supplier['nama_supplier']) ? $data_supplier['nama_supplier'] : '-'; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Penjualan</td>
                                                    <td>:</td>
                                                    <td><?= date('d-m-Y', strtotime($tgl_penjualan)); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td width="35%">Status Bayar</td>
                                                    <td width="5%">:</td>
                                                    <td><span
                                                            class="<?= $warna_status; ?> px-2 py-1"><?= $teks_status; ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total Tagihan</td>
                                                    <td>:</td>
                                                    <td><strong>Rp
                                                            <?= number_format($total_penjualan, 0, ',', '.'); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Pembayaran</td>
                                                    <td>:</td>
                                                    <td><?= $jenis_pembayaran; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Keterangan</td>
                                                    <td>:</td>
                                                    <td><?= $keterangan; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KOTAK TABULASI DATA BARANG DETAIL -->
                        <div class="card card-primary card-outline card-outline-tabs mt-3">
                            <div class="card-header p-0 border-bottom-0">
                                <!-- TAB NAVIGASI (Dengan parameter kode_nota dan jenis) -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_jenis == 'semua' ? 'active' : '' ?>"
                                            href="index.php?kode-nota=<?= $kode_nota ?>&jenis=semua">
                                            <i class="fas fa-list"></i> Semua Barang
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_jenis == 'Reguler' ? 'active text-primary' : '' ?>"
                                            href="index.php?kode-nota=<?= $kode_nota ?>&jenis=Reguler">
                                            <i class="fas fa-box"></i> Reguler
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_jenis == 'Konsinyasi' ? 'active text-purple' : '' ?>"
                                            href="index.php?kode-nota=<?= $kode_nota ?>&jenis=Konsinyasi">
                                            <i class="fas fa-handshake"></i> Konsinyasi
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div>
                                    <a href="../nota_jual_kasir/index.php" class="btn btn-sm btn-default"><i
                                            class="fas fa-arrow-circle-left"></i> Kembali</a>
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#modal-tambah">
                                        <i class="fas fa-plus"></i> Tambah Barang Terjual
                                    </button>
                                    <a href="cetak_nota.php?kode-nota=<?= $kode_nota ?>" class="btn btn-sm btn-primary"
                                        target="_blank"><i class="fas fa-print"></i> Cetak Nota</a>
                                </div>

                                <table id="example1" class="table table-bordered table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Harga Jual Unit</th>
                                            <th>Total Harga Jual</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // LOGIKA KUERI MENGGUNAKAN JOIN
                                        // Menggabungkan tbl_detail_notajual dengan tbl_barang
                                        if ($filter_jenis == 'semua') {
                                            $q_detail = "SELECT d.*, b.nama_brg, b.jenis_barang 
                                                         FROM tbl_detail_notajual d 
                                                         LEFT JOIN tbl_barang b ON d.kode_brg = b.kode_brg 
                                                         WHERE d.kode_nota = '$kode_nota'";
                                        } else {
                                            $q_detail = "SELECT d.*, b.nama_brg, b.jenis_barang 
                                                         FROM tbl_detail_notajual d 
                                                         LEFT JOIN tbl_barang b ON d.kode_brg = b.kode_brg 
                                                         WHERE d.kode_nota = '$kode_nota' AND b.jenis_barang = '$filter_jenis'";
                                        }

                                        $query_panggil_detail = mysqli_query($db, $q_detail) or die(mysqli_error($db));
                                        
                                        if (mysqli_num_rows($query_panggil_detail) > 0) {
                                            $no = 1;
                                            while ($data_detail = mysqli_fetch_array($query_panggil_detail)) {
                                                $urut = $data_detail['urut'];
                                                $kode_brg = $data_detail['kode_brg'];
                                                $jumlah = $data_detail['jumlah'];
                                                $harga_jual = $data_detail['harga_jual'];
                                                $total_harga_jual = $data_detail['total_harga_jual'];
                                                
                                                // Data hasil JOIN
                                                $nama_barang = isset($data_detail['nama_brg']) ? $data_detail['nama_brg'] : 'Barang Terhapus';
                                                $jenis_brg = isset($data_detail['jenis_barang']) ? $data_detail['jenis_barang'] : '-';
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kode_brg; ?></td>
                                            <td><?= $nama_barang; ?></td>
                                            <td>
                                                <?php if($jenis_brg == 'Konsinyasi'): ?>
                                                <span class="badge bg-purple">Konsinyasi</span>
                                                <?php elseif($jenis_brg == 'Reguler'): ?>
                                                <span class="badge badge-primary">Reguler</span>
                                                <?php else: ?>
                                                <span class="badge badge-secondary">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $jumlah; ?></td>
                                            <td>Rp <?= number_format($harga_jual, 0, ',', '.'); ?></td>
                                            <td>Rp <?= number_format($total_harga_jual, 0, ',', '.'); ?></td>
                                            <td>
                                                <a href="proses_hapus_barang.php?urut=<?= $urut ?>&kode-nota=<?= $kode_nota ?>"
                                                    onclick="return confirm('Apakah Kamu Yakin Menghapus Barang Ini?')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } } ?>
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
        </footer>
    </div>

    <!-- Modal Tambah Barang (Biarkan Aslinya) -->
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Barang yang Dijual</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_tambah_barang.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="kode_nota" value="<?= $kode_nota ?>">
                            <label>Pilih Barang</label>
                            <select name="kode_brg" id="kode_brg" class="form-control select2" required>
                                <option value="">-- Pilih Barang (Stok Tersedia) --</option>
                                <?php
                                $query_panggil_brg = mysqli_query($db, "SELECT kode_brg, nama_brg, stok, jenis_barang FROM tbl_barang WHERE stok > 0") or die(mysqli_error($db));
                                if (mysqli_num_rows($query_panggil_brg) > 0) {
                                    while ($data_brg = mysqli_fetch_array($query_panggil_brg)) {
                                ?>
                                <option value="<?= $data_brg['kode_brg'] ?>">
                                    [<?= $data_brg['jenis_barang'] ?>] <?= $data_brg['kode_brg'] ?> -
                                    <?= $data_brg['nama_brg'] ?> (Stok: <?= $data_brg['stok'] ?>)
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Beli / Jual</label>
                            <input type="number" name="jumlah" class="form-control" min="1" required>
                        </div>
                        <div class="modal-footer justify-content-between px-0 pb-0">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="btn_tambah_barang" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../script.php'; ?>
</body>

</html>