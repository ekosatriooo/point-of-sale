<?php
// panggil koneksi database
require_once '../database/koneksi.php';
$kode_nota = $_GET['kode-nota'];

if (isset($kode_nota)) {
    $query_hapus_nota = mysqli_query($db, "DELETE FROM tbl_nota WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
    echo '<script>alert ("data nota berhasil dihapus")</script>';
    echo '<script>window.location.href="../nota_beli_kasir"</script>';
}