<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
    $kode_barang = trim(mysqli_real_escape_string($db, $_POST['kode_barang']));
    $jenis_barang = trim(mysqli_real_escape_string($db, $_POST['jenis_barang'])); 
    $kode_supplier = trim(mysqli_real_escape_string($db, $_POST['kode_supplier']));
    $nama_barang = trim(mysqli_real_escape_string($db, $_POST['nama_barang']));
    $merk = trim(mysqli_real_escape_string($db, $_POST['merk']));
    $stok = trim(mysqli_real_escape_string($db, $_POST['stok']));
    $harga_beli = trim(mysqli_real_escape_string($db, $_POST['harga_beli']));
    $harga_jual = trim(mysqli_real_escape_string($db, $_POST['harga_jual']));
    
    $query_cek = mysqli_query($db, "SELECT kode_brg FROM tbl_barang WHERE kode_brg = '$kode_barang'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);
    
    if ($rv > 0) {
        echo '<script>alert ("Data barang sudah terdaftar!")</script>';
        echo '<script>window.location.href="../data_barang_superadmin"</script>';
        exit;
    }

    $path_database = 'NULL'; 

    if (isset($_FILES['foto']['name']) && $_FILES['foto']['error'] == 0) {
        $nama_file_asli = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        
        $ekstensi = pathinfo($nama_file_asli, PATHINFO_EXTENSION);
        $nama_file_baru = 'foto-barang' . time() . '.' . $ekstensi;
        $lokasi_simpan = '../asset_adminlte/img/' . $nama_file_baru;
        if (move_uploaded_file($tmp_file, $lokasi_simpan)) {
            $path_database = "'$lokasi_simpan'";
        }
    }
    
    $query_simpan = mysqli_query($db, "INSERT INTO tbl_barang (kode_brg, jenis_barang, kode_supplier, nama_brg, merk, stok, rata_harga_beli, harga_jual, foto_brg) 
                                       VALUES ('$kode_barang', '$jenis_barang', '$kode_supplier', '$nama_barang', '$merk', '$stok', '$harga_beli', '$harga_jual', $path_database)") or die(mysqli_error($db));
    
    if ($query_simpan) {
        echo '<script>alert ("Data barang berhasil terdaftar")</script>';
        echo '<script>window.location.href="../data_barang_superadmin"</script>';
    } else {
        echo '<script>alert ("Data barang gagal terdaftar")</script>';
        echo '<script>window.location.href="../data_barang_superadmin"</script>';
    }
}
?>