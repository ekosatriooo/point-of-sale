<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
    $kode_nota = trim(mysqli_real_escape_string($db, $_POST['kode_nota']));
    $kode_supplier = trim(mysqli_real_escape_string($db, $_POST['kode_supplier']));
    $tgl_pembelian = trim(mysqli_real_escape_string($db, $_POST['tgl_pembelian']));
    $total_pembelian = trim(mysqli_real_escape_string($db, $_POST['total_pembelian']));
    $status = trim(mysqli_real_escape_string($db, $_POST['status']));
    $keterangan = trim(mysqli_real_escape_string($db, $_POST['keterangan']));
    $jenis_pembayaran = trim(mysqli_real_escape_string($db, $_POST['jenis_pembayaran']));

    $query_cek = mysqli_query($db, "SELECT kode_nota FROM tbl_nota WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);
    if ($rv > 0) {
        echo '<script>alert ("data nota sudah terdaftar")</script>';
        echo '<script>window.location.href="../nota_beli_superadmin"</script>';
    } else {
        $query_simpan = mysqli_query($db, "INSERT INTO tbl_nota VALUES ('$kode_nota', '$kode_supplier', '$tgl_pembelian', '$total_pembelian', '$status', NULL, '$jenis_pembayaran')") or die(mysqli_error($db));
        echo '<script>alert ("data nota berhasil terdaftar")</script>';
        echo '<script>window.location.href="../nota_beli_superadmin"</script>';
    }
}