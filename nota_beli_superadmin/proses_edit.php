<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $kode_nota = trim(mysqli_real_escape_string($db, $_POST['kode_nota']));
    $kode_supplier = trim(mysqli_real_escape_string($db, $_POST['kode_supplier']));
    $tgl_pembelian = trim(mysqli_real_escape_string($db, $_POST['tgl_pembelian']));
    $total_pembelian = trim(mysqli_real_escape_string($db, $_POST['total-pembelian']));
    $status = trim(mysqli_real_escape_string($db, $_POST['status']));
    $keterangan = trim(mysqli_real_escape_string($db, $_POST['keterangan']));
    $jenis_pembayaran = trim(mysqli_real_escape_string($db, $_POST['jenis_pembayaran']));


    $query_edit_nota = mysqli_query($db, "UPDATE tbl_nota SET kode_supplier = '$kode_supplier', tgl_pembelian = '$tgl_pembelian', total_pembelian = '$total_pembelian', status = '$status', keterangan = '$keterangan', jenis_pembayaran = '$jenis_pembayaran' WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
    echo '<script>alert ("data nota berhasil diperbarui")</script>';
    echo '<script>window.location.href="../nota_beli_superadmin"</script>';
}