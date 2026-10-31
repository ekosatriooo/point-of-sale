<?php
require_once '../database/koneksi.php';
$halaman = 'data_supplier_superadmin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Data Supplier</title>

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

            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Supplier</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modal-tambah">
                                    <i class="fas fa-plus"></i>Tambah Supplier
                                </button>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama Supplier</th>
                                            <th>Nama PIC</th>
                                            <th>Kontak PIC</th>
                                            <th>Alamat Supplier</th>
                                            <th>Website</th>
                                            <th>Akun IG</th>
                                            <th>Akun Tiktok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_ambil_data = mysqli_query($db, "SELECT * FROM tbl_supplier") or die(mysqli_error($db));
                                        $rv = mysqli_num_rows($query_ambil_data);
                                        if ($rv > 0) {
                                            $no = 1;
                                            while ($data = mysqli_fetch_array($query_ambil_data)) {
                                                $kode = $data['kode_supplier'];
                                                $nama = $data['nama_supplier'];
                                                $nama_pic = $data['nama_pic'];
                                                $kontak_pic = $data['kontak_pic'];
                                                $alamat = $data['alamat_supplier'];
                                                $website = $data['website'];
                                                $akun_ig = $data['akun_ig'];
                                                $akun_tiktok = $data['akun_tiktok'];
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $kode; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td><?= $nama_pic; ?></td>
                                            <td><?= $kontak_pic; ?></td>
                                            <td><?= $alamat; ?></td>
                                            <td><?= $website; ?></td>
                                            <td><?= $akun_ig ?></td>
                                            <td><?= $akun_tiktok; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#modal-edit" data-kode="<?= $kode; ?>"
                                                    data-nama="<?= $nama; ?>" data-nama-pic="<?= $nama_pic; ?>"
                                                    data-kontak-pic="<?= $kontak_pic; ?>" data-alamat="<?= $alamat; ?>"
                                                    data-website="<?= $website; ?>" data-akun-ig="<?= $akun_ig; ?>"
                                                    data-akun-tiktok="<?= $akun_tiktok; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="proses_hapus.php?kode-supplier=<?= $kode; ?>"
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
                    <h4 class="modal-title">Tambah Data Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_tambah.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Supplier</label>
                            <input type="text" name="kode" class="form-control" id="kode" placeholder="masukkan kode"
                                Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Supplier</label>
                            <input type="text" name="nama" class="form-control" id="nama"
                                placeholder="masukkan nama supplier" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama PIC</label>
                            <input type="text" name="nama_pic" class="form-control" id="nama_pic"
                                placeholder="masukkan nama pic" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kontak PIC</label>
                            <input type="text" name="kontak_pic" class="form-control" id="kontak_pic"
                                placeholder="masukkan kontak pic" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat Supplier</label>
                            <input type="text" name="alamat" class="form-control" id="alamat"
                                placeholder="masukkan alamat" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Website</label>
                            <input type="text" name="website" class="form-control" id="website"
                                placeholder="masukkan website">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Akun IG</label>
                            <input type="text" name="akun_ig" class="form-control" id="akun_ig"
                                placeholder="masukkan ig">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Akun Tiktok</label>
                            <input type="text" name="akun_tiktok" class="form-control" id="akun_tiktok"
                                placeholder="masukkan tiktok">
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
                    <h4 class="modal-title">Edit Data Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_edit.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Supplier</label>
                            <input type="text" name="kode" class="form-control" id="kode" placeholder="masukkan kode"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Supplier</label>
                            <input type="text" name="nama" class="form-control" id="nama"
                                placeholder="masukkan nama supplier" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama PIC</label>
                            <input type="text" name="nama_pic" class="form-control" id="nama_pic"
                                placeholder="masukkan nama pic" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kontak PIC</label>
                            <input type="text" name="kontak_pic" class="form-control" id="kontak_pic"
                                placeholder="masukkan kontak pic" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat Supplier</label>
                            <input type="text" name="alamat" class="form-control" id="alamat"
                                placeholder="masukkan alamat" Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Website</label>
                            <input type="text" name="website" class="form-control" id="website"
                                placeholder="masukkan website">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Akun IG</label>
                            <input type="text" name="akun_ig" class="form-control" id="akun_ig"
                                placeholder="masukkan ig">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Akun Tiktok</label>
                            <input type="text" name="akun_tiktok" class="form-control" id="akun_tiktok"
                                placeholder="masukkan tiktok">
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
        var kode = $(e.relatedTarget).data('kode');
        var nama = $(e.relatedTarget).data('nama');
        var nama_pic = $(e.relatedTarget).data('nama-pic');
        var kontak_pic = $(e.relatedTarget).data('kontak-pic');
        var alamat = $(e.relatedTarget).data('alamat');
        var website = $(e.relatedTarget).data('website');
        var akun_ig = $(e.relatedTarget).data('akun-ig');
        var akun_tiktok = $(e.relatedTarget).data('akun-tiktok');

        $(e.currentTarget).find('input[name="kode"]').val(kode);
        $(e.currentTarget).find('input[name="nama"]').val(nama);
        $(e.currentTarget).find('input[name="nama_pic"]').val(nama_pic);
        $(e.currentTarget).find('input[name="kontak_pic"]').val(kontak_pic);
        $(e.currentTarget).find('input[name="alamat"]').val(alamat);
        $(e.currentTarget).find('input[name="website"]').val(website);
        $(e.currentTarget).find('input[name="akun_ig"]').val(akun_ig);
        $(e.currentTarget).find('input[name="akun_tiktok"]').val(akun_tiktok);
    })
    </script>
</body>

</html>