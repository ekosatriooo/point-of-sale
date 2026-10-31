<?php
require_once '../database/koneksi.php';

// Menangkap parameter dari URL
$urut = $_GET['urut'];
$kode_nota = $_GET['kode-nota'];

$query_get_detail = mysqli_query($db, "SELECT kode_brg, jumlah FROM tbl_detail_notabeli WHERE urut = '$urut'") or die(mysqli_error($db));
$data_detail = mysqli_fetch_array($query_get_detail);

$kode_brg = $data_detail['kode_brg'];
$jumlah_batal = $data_detail['jumlah'];

$query_hapus = mysqli_query($db, "DELETE FROM tbl_detail_notabeli WHERE urut = '$urut'") or die(mysqli_error($db));

if ($query_hapus) {
    mysqli_query($db, "UPDATE tbl_barang SET stok = stok - $jumlah_batal WHERE kode_brg = '$kode_brg'") or die(mysqli_error($db));
    
    $query_sum = mysqli_query($db, "SELECT SUM(total_harga_beli) AS grand_total FROM tbl_detail_notabeli WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
    $data_sum = mysqli_fetch_array($query_sum);
    
    $grand_total = $data_sum['grand_total'] != null ? $data_sum['grand_total'] : 0;

    mysqli_query($db, "UPDATE tbl_nota SET total_pembelian = '$grand_total' WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));

    echo "<script>
            alert('Barang berhasil dihapus dan total nota telah diperbarui!');
            window.location.href='index.php?kode-nota=$kode_nota';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus barang!');
            window.location.href='index.php?kode-nota=$kode_nota';
          </script>";
}
?>