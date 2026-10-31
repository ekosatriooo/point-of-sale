<?php 
// panggil koneksi database
require_once '../database/koneksi.php';
$kode_barang = $_GET['kode-barang'];

if (isset($kode_barang)) {
    $query_hapus_barang = mysqli_query($db, "DELETE FROM tbl_barang WHERE kode_brg = '$kode_barang'") or die (mysqli_error($db));
        echo '<script>alert ("data barang berhasil dihapus")</script>';
        echo '<script>window.location.href="../data_barang_superadmin"</script>';
}
?>