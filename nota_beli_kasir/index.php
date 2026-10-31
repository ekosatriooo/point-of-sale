<?php
require_once '../database/koneksi.php';
$halaman = 'nota_beli_kasir';

// MENANGKAP PARAMETER STATUS DARI URL (Default: semua)
$filter_status = isset($_GET['status']) ? $_GET['status'] : 'semua';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Data Nota Beli</title>

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
                <?php include '../sidebar_kasir.php'; ?>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header">
                                <h3 class="card-title">Data Nota Beli </h3>
                            </div>
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_status == 'semua' ? 'active' : '' ?>"
                                            href="index.php?status=semua">
                                            <i class="fas fa-list"></i> Semua Nota
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_status == 'L' ? 'active' : '' ?>"
                                            href="index.php?status=L">
                                            Lunas
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_status == '4' ? 'active' : '' ?>"
                                            href="index.php?status=4">
                                            Dibayar 75%
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_status == '3' ? 'active' : '' ?>"
                                            href="index.php?status=3">
                                            Dibayar 50%
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_status == '2' ? 'active' : '' ?>"
                                            href="index.php?status=2">
                                            Dibayar 25%
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modal-tambah">
                                    <i class="fas fa-plus"></i> Tambah Nota Beli
                                </button>

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Nota</th>
                                            <th>Nama Supplier</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Total Pembelian</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    if ($filter_status == 'semua') {
                                        $query_ambil_data = mysqli_query($db, "SELECT tbl_nota.*, tbl_supplier.nama_supplier 
                                                                               FROM tbl_nota 
                                                                               LEFT JOIN tbl_supplier ON tbl_nota.kode_supplier = tbl_supplier.kode_supplier 
                                                                               ORDER BY tbl_nota.tgl_pembelian DESC") or die(mysqli_error($db));
                                    } else {
                                        $query_ambil_data = mysqli_query($db, "SELECT tbl_nota.*, tbl_supplier.nama_supplier 
                                                                               FROM tbl_nota 
                                                                               LEFT JOIN tbl_supplier ON tbl_nota.kode_supplier = tbl_supplier.kode_supplier 
                                                                               WHERE tbl_nota.status = '$filter_status' 
                                                                               ORDER BY tbl_nota.tgl_pembelian DESC") or die(mysqli_error($db));
                                    }

                                    $rv = mysqli_num_rows($query_ambil_data);
                                    if ($rv > 0) {
                                        $no = 1;
                                        while ($data = mysqli_fetch_array($query_ambil_data)) {
                                            $kode_nota = $data['kode_nota'];
                                            $kode_supplier = $data['kode_supplier'];
                                            $nama_supplier = $data['nama_supplier'];
                                            $tgl_pembelian = $data['tgl_pembelian'];
                                            $total_pembelian = $data['total_pembelian'];
                                            $status = $data['status'];
                                            $keterangan = $data['keterangan'];
                                            
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
                                            $jenis_pembayaran = $data['jenis_pembayaran'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kode_nota; ?></td>
                                            <td><?= $nama_supplier; ?></td>
                                            <td><?= date('d-m-Y', strtotime($tgl_pembelian)); ?></td>
                                            <td>Rp <?= number_format($total_pembelian, 0, ',', '.'); ?></td>
                                            <td><span class="<?= $warna_status; ?>"><?= $teks_status; ?></span></td>
                                            <td><?= $keterangan; ?></td>
                                            <td><?= $jenis_pembayaran; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#modal-edit" data-kode-nota="<?= $kode_nota; ?>"
                                                    data-kode-supplier="<?= $kode_supplier; ?>"
                                                    data-tgl-pembelian="<?= $tgl_pembelian; ?>"
                                                    data-total-pembelian="<?= $total_pembelian; ?>"
                                                    data-status="<?= $status; ?>" data-keterangan="<?= $keterangan; ?>"
                                                    data-jenis-pembayaran="<?= $jenis_pembayaran;?>">
                                                    <i class=" fas fa-edit"></i>
                                                </button>
                                                <a href="../detail_notabeli_kasir/index.php?kode-nota=<?= $kode_nota ?>"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="proses_hapus.php?kode-nota=<?= $kode_nota; ?>"
                                                    onclick="return confirm('Apakah Kamu Yakin Menghapus Data Ini?')"
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
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="#">POS</a>.</strong> All rights reserved.
        </footer>
    </div>

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
                            <label>Kode Nota</label>
                            <input type="text" name="kode_nota" class="form-control" placeholder="masukkan kode nota"
                                required>
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
                            <label>Tanggal Pembelian</label>
                            <input type="date" name="tgl_pembelian" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Total Pembelian</label>
                            <input type="number" name="total_pembelian" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="L">Lunas</option>
                                <option value="2">dibayar 25%</option>
                                <option value="3">dibayar 50%</option>
                                <option value="4">dibayar 75%</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="masukkan keterangan">
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
        </div>
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Nota</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_edit.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Nota</label>
                            <input type="text" name="kode_nota" class="form-control" readonly>
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
                            <label>Tanggal Pembelian</label>
                            <input type="date" name="tgl_pembelian" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Total Pembelian</label>
                            <input type="number" name="total_pembelian" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="L">Lunas</option>
                                <option value="2">dibayar 25%</option>
                                <option value="3">dibayar 50%</option>
                                <option value="4">dibayar 75%</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control">
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
        </div>
    </div>

    <?php include '../script.php'; ?>

    <script>
    $('#modal-edit').on('show.bs.modal', function(e) {
        var kode_nota = $(e.relatedTarget).data('kode-nota');
        var kode_supplier = $(e.relatedTarget).data('kode-supplier');
        var tgl_pembelian = $(e.relatedTarget).data('tgl-pembelian');
        var total_pembelian = $(e.relatedTarget).data('total-pembelian');
        var status = $(e.relatedTarget).data('status');
        var keterangan = $(e.relatedTarget).data('keterangan');
        var jenis_pembayaran = $(e.relatedTarget).data('jenis-pembayaran');

        $(e.currentTarget).find('input[name="kode_nota"]').val(kode_nota);
        $(e.currentTarget).find('select[name="kode_supplier"]').val(kode_supplier);
        $(e.currentTarget).find('input[name="tgl_pembelian"]').val(tgl_pembelian);
        $(e.currentTarget).find('input[name="total_pembelian"]').val(total_pembelian);
        $(e.currentTarget).find('select[name="status"]').val(status);
        $(e.currentTarget).find('input[name="keterangan"]').val(keterangan);
        $(e.currentTarget).find('select[name="jenis_pembayaran"]').val(jenis_pembayaran);
    })
    </script>
</body>

</html>