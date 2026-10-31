<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $kode_barang = trim(mysqli_real_escape_string($db, $_POST['kode_barang']));
    $jenis_barang = trim(mysqli_real_escape_string($db, $_POST['jenis_barang']));     
    $kode_supplier = trim(mysqli_real_escape_string($db, $_POST['kode_supplier']));
    $nama_barang = trim(mysqli_real_escape_string($db, $_POST['nama_barang']));
    $merk = trim(mysqli_real_escape_string($db, $_POST['merk']));
    $stok = trim(mysqli_real_escape_string($db, $_POST['stok']));
    $harga_beli = trim(mysqli_real_escape_string($db, $_POST['harga_beli']));
    $harga_jual = trim(mysqli_real_escape_string($db, $_POST['harga_jual']));
    
    if (isset($_FILES['foto']['name']) && $_FILES['foto']['error'] == 0) {
        $nama_file_asli = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $ekstensi = pathinfo($nama_file_asli, PATHINFO_EXTENSION);
        $nama_file_baru = 'foto-barang' . time() . '.' . $ekstensi;
        $lokasi_simpan = '../asset_adminlte/img/' . $nama_file_baru;

        if (move_uploaded_file($tmp_file, $lokasi_simpan)) {
            $query_edit_barang = mysqli_query($db, "UPDATE tbl_barang SET jenis_barang = '$jenis_barang', kode_supplier = '$kode_supplier', nama_brg = '$nama_barang', merk = '$merk', stok = '$stok', rata_harga_beli = '$harga_beli', harga_jual = '$harga_jual', foto_brg = '$lokasi_simpan' WHERE kode_brg = '$kode_barang'") or die (mysqli_error($db));
        }
    } 
    else {
        $query_edit_barang = mysqli_query($db, "UPDATE tbl_barang SET jenis_barang = '$jenis_barang', kode_supplier = '$kode_supplier', nama_brg = '$nama_barang', merk = '$merk', stok = '$stok', rata_harga_beli = '$harga_beli', harga_jual = '$harga_jual' WHERE kode_brg = '$kode_barang'") or die (mysqli_error($db));
    }

    echo '<script>alert ("Data barang berhasil diperbarui")</script>';
    echo '<script>window.location.href="../data_barang_superadmin"</script>';
}
?>