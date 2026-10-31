<?php
require_once '../database/koneksi.php';
$halaman = 'nota_jual_kasir';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Data Nota Jual</title>

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
                include '../sidebar_kasir.php';
                ?>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Nota Jual</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modal-tambah">
                                    <i class="fas fa-plus"></i>Tambah Nota Jual
                                </button>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Nota</th>
                                            <th>Nama Supplier</th>
                                            <th>Tanggal Penjualan</th>
                                            <th>Total Penjualan</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_ambil_data = mysqli_query($db, "SELECT * FROM tbl_nota_penjualan") or die(mysqli_error($db));
                                        $rv = mysqli_num_rows($query_ambil_data);
                                        if ($rv > 0) {
                                            $no = 1;
                                            while ($data = mysqli_fetch_array($query_ambil_data)) {
                                                $kode_nota = $data['kode_nota'];
                                                $kode_supplier = $data['kode_supplier'];
                                                $query_supplier = mysqli_query($db, "SELECT nama_supplier FROM tbl_supplier WHERE kode_supplier = '$kode_supplier'") or die(mysqli_error($db));
                                                $data_supplier = mysqli_fetch_array($query_supplier);
                                                $tgl_penjualan = $data['tgl_penjualan'];
                                                $total_penjualan = $data['total_penjualan'];
                                                $status = $data['status'];
                                                $keterangan = $data['keterangan'];
                                                $jenis_pembayaran = $data['jenis_pembayaran'];
                                                ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kode_nota; ?></td>
                                            <td><?= isset($data_supplier['nama_supplier']) ? $data_supplier['nama_supplier'] : '-'; ?>
                                            </td>
                                            <td><?= $tgl_penjualan; ?></td>
                                            <td>Rp <?= number_format($total_penjualan, 0, ',', '.'); ?></td>

                                            <td>
                                                <?php
                                                        if ($status == 'L') {
                                                            $teks_status = "Lunas";
                                                            $warna_status = "badge badge-success"; // Hijau
                                                        } elseif ($status == '2') {
                                                            $teks_status = "Dibayar 25%";
                                                            $warna_status = "badge badge-danger"; // Merah
                                                        } elseif ($status == '3') {
                                                            $teks_status = "Dibayar 50%";
                                                            $warna_status = "badge badge-warning"; // Kuning
                                                        } elseif ($status == '4') {
                                                            $teks_status = "Dibayar 75%";
                                                            $warna_status = "badge badge-info"; // Biru
                                                        } else {
                                                            $teks_status = "-";
                                                            $warna_status = "badge badge-secondary"; // Abu-abu
                                                        }
                                                        ?>
                                                <span class="<?= $warna_status; ?>"><?= $teks_status; ?></span>
                                            </td>

                                            <td><?= $keterangan; ?></td>
                                            <td><?= $jenis_pembayaran; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#modal-edit" data-kode-nota="<?= $kode_nota; ?>"
                                                    data-kode-supplier="<?= $kode_supplier; ?>"
                                                    data-tgl-penjualan="<?= $tgl_penjualan; ?>"
                                                    data-total-penjualan="<?= $total_penjualan; ?>"
                                                    data-status="<?= $status; ?>" data-keterangan="<?= $keterangan; ?>"
                                                    data-jenis-pembayaran="<?= $jenis_pembayaran; ?>">
                                                    <i class=" fas fa-edit"></i>
                                                </button>
                                                <a href="../detail_notajual_kasir/index.php?kode-nota=<?= $kode_nota ?>"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="proses_hapus.php?kode-nota=<?= $kode_nota; ?>"
                                                    onclick="return confirm('Apakah Kamu Yakin Menghapus Data Ini?')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.container-header -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class=" control-sidebar control-sidebar-dark">
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

    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Nota</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_tambah.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Nota</label>
                            <input type="text" name="kode_nota" class="form-control" id="kode_nota"
                                placeholder="masukkan kode nota" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Supplier</label>
                            <select name="kode_supplier" id="kode_supplier" class="form-control" required>
                                <option value="">-- Pilih Supplier --</option>
                                <?php
                                $query_supplier = mysqli_query($db, "SELECT * FROM tbl_supplier");
                                while ($data_supplier = mysqli_fetch_array($query_supplier)) {
                                    echo '<option value="' . $data_supplier['kode_supplier'] . '">' . $data_supplier['nama_supplier'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Penjualan</label>
                            <input type="date" name="tgl_penjualan" class="form-control" id="tgl_penjualan"
                                placeholder="masukkan tanggal" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Total Penjualan</label>
                            <input type="number" name="total_penjualan" class="form-control" id="total_penjualan"
                                placeholder="masukkan total penjualan" Required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" Required>
                                <option value="">-- Pilih Status --</option>
                                <option value="L">Lunas</option>
                                <option value="2">dibayar 25%</option>
                                <option value="3">dibayar 50%</option>
                                <option value="4">dibayar 75%</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" id="keterangan"
                                placeholder="masukkan keterangan">
                        </div>
                        <div class="form-group">
                            <label>Jenis Pembayaran</label>
                            <select class="form-control" name="jenis_pembayaran" required>
                                <option value="">-- Pilih Jenis Pembayaran --</option>
                                <option value="Cash">Cash</option>
                                <option value="Qris">Qris</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="btn_tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Nota Jual</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_edit.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Nota</label>
                            <input type="text" name="kode_nota" class="form-control" id="kode_nota"
                                placeholder="masukkan kode nota" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kode Supplier</label>
                            <select name="kode_supplier" class="form-control" required>
                                <option value="">-- Pilih Supplier --</option>
                                <?php
                                $query_supplier = mysqli_query($db, "SELECT * FROM tbl_supplier");
                                while ($data_supplier = mysqli_fetch_array($query_supplier)) {
                                    echo '<option value="' . $data_supplier['kode_supplier'] . '">' . $data_supplier['nama_supplier'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Penjualan</label>
                            <input type="date" name="tgl_penjualan" class="form-control" id="tgl_penjualan"
                                placeholder="masukkan tanggal" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Total Penjualan</label>
                            <input type="number" name="total_penjualan" class="form-control" id="total_penjualan"
                                placeholder="masukkan total penjualan" Required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" Required>
                                <option value="">-- Pilih Status --</option>
                                <option value="L">Lunas</option>
                                <option value="2">dibayar 25%</option>
                                <option value="3">dibayar 50%</option>
                                <option value="4">dibayar 75%</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" id="keterangan"
                                placeholder="masukkan keterangan">
                        </div>
                        <div class="form-group">
                            <label>Jenis Pembayaran</label>
                            <select class="form-control" name="jenis_pembayaran" required>
                                <option value="">-- Pilih Jenis Pembayaran --</option>
                                <option value="Cash">Cash</option>
                                <option value="Qris">Qris</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="btn_edit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <?php
    include '../script.php';
    ?>

    <script>
    $('#modal-edit').on('show.bs.modal', function(e) {
        var kode_nota = $(e.relatedTarget).data('kode-nota');
        var kode_supplier = $(e.relatedTarget).data('kode-supplier');
        var tgl_penjualan = $(e.relatedTarget).data('tgl-penjualan');
        var total_penjualan = $(e.relatedTarget).data('total-penjualan');
        var status = $(e.relatedTarget).data('status');
        var keterangan = $(e.relatedTarget).data('keterangan');
        var jenis_pembayaran = $(e.relatedTarget).data('jenis-pembayaran');

        $(e.currentTarget).find('input[name="kode_nota"]').val(kode_nota);
        $(e.currentTarget).find('select[name="kode_supplier"]').val(kode_supplier);
        $(e.currentTarget).find('input[name="tgl_penjualan"]').val(tgl_penjualan);
        $(e.currentTarget).find('input[name="total_penjualan"]').val(total_penjualan);
        $(e.currentTarget).find('select[name="status"]').val(status);
        $(e.currentTarget).find('input[name="keterangan"]').val(keterangan);
        $(e.currentTarget).find('select[name="jenis_pembayaran"]').val(jenis_pembayaran);
    })
    </script>
</body>

</html>