<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit_foto_barang'])) {
    $kode_barang = trim(mysqli_real_escape_string($db, $_POST['kode_barang']));
    $file = $_FILES['foto']['name'];
    $ekstensi = explode('.', $file);
    $nama_file = 'foto-barang'.round(microtime(true)).'.'.end($ekstensi);

    $alamat_sumber = $_FILES['foto']['tmp_name'];
    $alamat_tujuan = '../asset_adminlte/img/'.$nama_file;
    move_uploaded_file($alamat_sumber, $alamat_tujuan);

    $query_edit_foto_barang = mysqli_query($db, "UPDATE tbl_barang SET foto_brg = '$alamat_tujuan' WHERE kode_brg = '$kode_barang'")or die (mysqli_error($db));
        echo '<script>alert ("edit foto barang telah berhasil")</script>';
        echo '<script>window.location.href="../data_barang_superadmin"</script>';
}
?>