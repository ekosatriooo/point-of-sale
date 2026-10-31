<?php 
// panggil koneksi database
require_once '../database/koneksi.php';
$kode = $_GET['kode-supplier'];

if (isset($kode)) {
    $query_hapus_supplier = mysqli_query($db, "DELETE FROM tbl_supplier WHERE kode_supplier = '$kode'") or die (mysqli_error($db));
        echo '<script>alert ("data supplier berhasil dihapus")</script>';
        echo '<script>window.location.href="../supplier_superadmin"</script>';
}
?>