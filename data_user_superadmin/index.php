<?php
require_once '../database/koneksi.php';
$halaman = 'data_user_superadmin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS | Data User</title>

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

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link"><span class="brand-text font-weight-light">POS</span></a>
            <div class="sidebar"><?php include '../sidebar_superadmin.php'; ?></div>
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
                                <h3 class="card-title">Data User</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#modal-tambah">
                                    <i class="fas fa-plus"></i>Tambah Data
                                </button>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Peran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $query_ambil_data = mysqli_query($db, "SELECT * FROM tbl_user") or die (mysqli_error($db));
                                    $rv = mysqli_num_rows($query_ambil_data);
                                    if ($rv > 0) {
                                        $no = 1;
                                        while ($data = mysqli_fetch_array($query_ambil_data)) {
                                            $nama = $data['nama_panggilan'];
                                            $username = $data['username'];
                                            $peran = $data['peran'];
                                            ?>
                                        <tr>
                                            <td><?= $no++;?></td>
                                            <td><?= $nama;?></td>
                                            <td><?= $username;?></td>
                                            <td><?php 
                                        if ($peran == 'S') {
                                            echo 'Superadmin';    
                                        } else {
                                            echo 'Kasir';
                                        }
                                        ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#modal-edit" data-nama="<?= $nama;?>"
                                                    data-username="<?= $username;?>" data-peran="<?= $peran;?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="proses_hapus.php?username=<?= $username; ?>"
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
                    <h4 class="modal-title">Tambah Data User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_tambah.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama"
                                Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" name="username" class="form-control" id="username"
                                placeholder="Masukkan Username" Required>
                        </div>
                        <div class="form-group">
                            <label>Peran</label>
                            <select class="form-control" name="peran" Required>
                                <option value="">-- Pilih Peran --</option>
                                <option value="K">Kasir</option>
                                <option value="S">Superadmin</option>
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
                    <h4 class="modal-title">Edit Data User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="proses_edit.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" hidden>
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama"
                                Required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" name="username" class="form-control" id="username"
                                placeholder="Masukkan Username" Required>
                        </div>
                        <div class="form-group">
                            <label>Peran</label>
                            <select class="form-control" name="peran" Required>
                                <option value="">-- Pilih Peran --</option>
                                <option value="K">Kasir</option>
                                <option value="S">Superadmin</option>
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
        var nama = $(e.relatedTarget).data('nama');
        var username = $(e.relatedTarget).data('username');
        var peran = $(e.relatedTarget).data('peran');

        $(e.currentTarget).find('input[name="nama"]').val(nama);
        $(e.currentTarget).find('input[name="username"]').val(username);
        $(e.currentTarget).find('select[name="peran"]').val(peran);
    })
    </script>
</body>

</html>