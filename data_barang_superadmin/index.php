<?php
require_once '../database/koneksi.php';
$halaman = 'data_barang_superadmin';

// TANGKAP PARAMETER TAB JENIS BARANG (Default: semua)
$filter_jenis = isset($_GET['jenis']) ? $_GET['jenis'] : 'semua';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Data Barang</title>
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
            <div class="sidebar"><?php include '../sidebar_superadmin.php'; ?></div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header">
                                <h3 class="card-title">Data Barang</h3>
                            </div>
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_jenis == 'semua' ? 'active' : '' ?>"
                                            href="index.php?jenis=semua">
                                            <i class="fas fa-boxes"></i> Semua Barang
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_jenis == 'Reguler' ? 'active' : '' ?>"
                                            href="index.php?jenis=Reguler">
                                            <i class="fas fa-box"></i> Barang Reguler
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $filter_jenis == 'Konsinyasi' ? 'active text-purple' : '' ?>"
                                            href="index.php?jenis=Konsinyasi">
                                            <i class="fas fa-handshake"></i> Barang Konsinyasi
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modal-tambah">
                                    <i class="fas fa-plus"></i> Tambah Barang
                                </button>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Supplier</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis</th>
                                            <th>Stok</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    if ($filter_jenis == 'semua') {
                                        $query = mysqli_query($db, "SELECT tbl_barang.*, tbl_supplier.nama_supplier 
                                                                    FROM tbl_barang 
                                                                    LEFT JOIN tbl_supplier ON tbl_barang.kode_supplier = tbl_supplier.kode_supplier 
                                                                    ORDER BY tbl_barang.kode_brg DESC") or die(mysqli_error($db));
                                    } else {
                                        $query = mysqli_query($db, "SELECT tbl_barang.*, tbl_supplier.nama_supplier 
                                                                    FROM tbl_barang 
                                                                    LEFT JOIN tbl_supplier ON tbl_barang.kode_supplier = tbl_supplier.kode_supplier 
                                                                    WHERE tbl_barang.jenis_barang = '$filter_jenis' 
                                                                    ORDER BY tbl_barang.kode_brg DESC") or die(mysqli_error($db));
                                    }

                                    if (mysqli_num_rows($query) > 0) {
                                        $no = 1;
                                        while ($data = mysqli_fetch_array($query)) {
                                            $jenis = $data['jenis_barang'] ?? 'Reguler';
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $data['kode_brg']; ?></td>
                                            <td><?= $data['nama_supplier']; ?></td>
                                            <td><?= $data['nama_brg']; ?> <br><small class="text-muted">Merk:
                                                    <?= $data['merk']; ?></small></td>
                                            <td>
                                                <?php if($jenis == 'Konsinyasi'): ?>
                                                <span class="badge bg-purple">Konsinyasi</span>
                                                <?php else: ?>
                                                <span class="badge badge-primary">Reguler</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $data['stok']; ?></td>
                                            <td>Rp <?= number_format($data['rata_harga_beli'], 0, ',', '.'); ?></td>
                                            <td>Rp <?= number_format($data['harga_jual'], 0, ',', '.'); ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal"
                                                    data-target="#modal-foto"
                                                    data-kode-barang="<?= $data['kode_brg']; ?>">
                                                    <img src="<?= ($data['foto_brg'] != NULL) ? $data['foto_brg'] : '../asset_adminlte/img/kardus.jpg' ?>"
                                                        alt="foto barang" style="width:50px">
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#modal-edit"
                                                    data-kode-barang="<?= $data['kode_brg']; ?>"
                                                    data-kode-supplier="<?= $data['kode_supplier']; ?>"
                                                    data-nama-barang="<?= $data['nama_brg']; ?>"
                                                    data-merk="<?= $data['merk']; ?>" data-jenis-barang="<?= $jenis; ?>"
                                                    data-stok="<?= $data['stok']; ?>"
                                                    data-harga-beli="<?= $data['rata_harga_beli']; ?>"
                                                    data-harga-jual="<?= $data['harga_jual']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="proses_hapus.php?kode-barang=<?= $data['kode_brg']; ?>"
                                                    onclick="return confirm('Apakah Kamu Yakin Menghapus Data Ini?')"
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
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">POS</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>

    <!-- MODAL TAMBAH BARANG -->
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_tambah.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <select name="jenis_barang" class="form-control" required>
                                <option value="">-- Pilih Jenis Barang</option>
                                <option value="Reguler">Reguler</option>
                                <option value="Konsinyasi">Konsinyasi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode Supplier</label>
                            <select name="kode_supplier" class="form-control" required>
                                <option value="">-- Pilih Supplier --</option>
                                <?php 
                                    $q_sup = mysqli_query($db, "SELECT * FROM tbl_supplier");
                                    while ($d_sup = mysqli_fetch_array($q_sup)) {
                                        echo '<option value="'.$d_sup['kode_supplier'].'">'.$d_sup['nama_supplier'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Merk</label>
                            <input type="text" name="merk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Stok Awal</label>
                            <input type="number" name="stok" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="number" name="harga_beli" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Foto Barang</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika belum ada foto.</small>
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

    <!-- MODAL EDIT BARANG -->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_edit.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <select name="jenis_barang" class="form-control" required>
                                <option value="Reguler">Reguler</option>
                                <option value="Konsinyasi">Konsinyasi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode Supplier</label>
                            <select name="kode_supplier" class="form-control" required>
                                <?php 
                                    $q_sup = mysqli_query($db, "SELECT * FROM tbl_supplier");
                                    while ($d_sup = mysqli_fetch_array($q_sup)) {
                                        echo '<option value="'.$d_sup['kode_supplier'].'">'.$d_sup['nama_supplier'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Merk</label>
                            <input type="text" name="merk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stok" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="number" name="harga_beli" class="form-control" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" min="0" required>
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

    <!-- MODAL FOTO (Biarkan Sesuai Aslinya) -->
    <div class="modal fade" id="modal-foto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Foto Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_edit_foto_barang.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Upload Foto Baru</label>
                            <input type="hidden" name="kode_barang" id="kode_barang_foto">
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="btn_edit_foto_barang" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../script.php'; ?>

    <script>
    // Script Edit Barang
    $('#modal-edit').on('show.bs.modal', function(e) {
        var btn = $(e.relatedTarget);
        var modal = $(this);

        modal.find('input[name="kode_barang"]').val(btn.data('kode-barang'));
        modal.find('select[name="jenis_barang"]').val(btn.data('jenis-barang'));
        modal.find('select[name="kode_supplier"]').val(btn.data('kode-supplier'));
        modal.find('input[name="nama_barang"]').val(btn.data('nama-barang'));
        modal.find('input[name="merk"]').val(btn.data('merk'));
        modal.find('input[name="stok"]').val(btn.data('stok'));
        modal.find('input[name="harga_beli"]').val(btn.data('harga-beli'));
        modal.find('input[name="harga_jual"]').val(btn.data('harga-jual'));
    });

    // Script Edit Foto
    $('#modal-foto').on('show.bs.modal', function(e) {
        var btn = $(e.relatedTarget);
        $('#kode_barang_foto').val(btn.data('kode-barang'));
    });
    </script>
</body>

</html>