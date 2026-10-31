<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $kode_nota = trim(mysqli_real_escape_string($db, $_POST['kode_nota']));
    $kode_supplier = trim(mysqli_real_escape_string($db, $_POST['kode_supplier']));
    $tgl_penjualan = trim(mysqli_real_escape_string($db, $_POST['tgl_penjualan']));
    $total_penjualan = trim(mysqli_real_escape_string($db, $_POST['total_penjualan']));
    $status = trim(mysqli_real_escape_string($db, $_POST['status']));
    $keterangan = trim(mysqli_real_escape_string($db, $_POST['keterangan']));
    $jenis_pembayaran = trim(mysqli_real_escape_string($db, $_POST['jenis_pembayaran']));


    $query_edit_nota = mysqli_query($db, "UPDATE tbl_nota_penjualan SET kode_supplier = '$kode_supplier', tgl_penjualan = '$tgl_penjualan', total_penjualan = '$total_penjualan', status = '$status', keterangan = '$keterangan', jenis_pembayaran = '$jenis_pembayaran' WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
    echo '<script>alert ("data nota berhasil diperbarui")</script>';
    echo '<script>window.location.href="../nota_jual_superadmin"</script>';
}