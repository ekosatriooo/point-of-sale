<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
    $kode_nota = trim(mysqli_real_escape_string($db, $_POST['kode_nota']));
    $kode_supplier = trim(mysqli_real_escape_string($db, $_POST['kode_supplier']));
    $tgl_penjualan = trim(mysqli_real_escape_string($db, $_POST['tgl_penjualan']));
    $total_penjualan = trim(mysqli_real_escape_string($db, $_POST['total_penjualan']));
    $status = trim(mysqli_real_escape_string($db, $_POST['status']));
    $keterangan = trim(mysqli_real_escape_string($db, $_POST['keterangan']));
    $jenis_pembayaran = trim(mysqli_real_escape_string($db, $_POST['jenis_pembayaran']));

    
    $query_cek = mysqli_query($db, "SELECT kode_nota FROM tbl_nota_penjualan WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);
    if ($rv > 0) {
        echo '<script>alert ("data nota sudah terdaftar")</script>';
        echo '<script>window.location.href="../nota_jual_kasir"</script>';
    } else {
        $query_simpan = mysqli_query($db, "INSERT INTO tbl_nota_penjualan VALUES ('$kode_nota', '$kode_supplier', '$tgl_penjualan', '$total_penjualan', '$status', NULL, '$jenis_pembayaran')") or die(mysqli_error($db));
        echo '<script>alert ("data nota berhasil terdaftar")</script>';
        echo '<script>window.location.href="../nota_jual_kasir"</script>';
    }
}