<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah_barang'])) {
    $kode_nota = mysqli_real_escape_string($db, $_POST['kode_nota']);
    $kode_brg  = mysqli_real_escape_string($db, $_POST['kode_brg']);
    $jumlah    = (int) $_POST['jumlah'];

    $query_brg = mysqli_query($db, "SELECT harga_jual, stok FROM tbl_barang WHERE kode_brg = '$kode_brg'") or die(mysqli_error($db));
    $data_brg  = mysqli_fetch_array($query_brg);
    
    $harga_jual    = $data_brg['harga_jual'];
    $stok_sekarang = $data_brg['stok'];

    if ($stok_sekarang < $jumlah) {
        echo "<script>
                alert('Gagal! Stok barang tidak mencukupi. Sisa stok saat ini: $stok_sekarang');
                window.location.href='index.php?kode-nota=$kode_nota';
              </script>";
        exit;
    }

    $total_harga_jual = $jumlah * $harga_jual;
    $query_insert = mysqli_query($db, "INSERT INTO tbl_detail_notajual (kode_nota, kode_brg, jumlah, harga_jual, total_harga_jual) 
                                       VALUES ('$kode_nota', '$kode_brg', '$jumlah', '$harga_jual', '$total_harga_jual')") or die(mysqli_error($db));

    if ($query_insert) {
        mysqli_query($db, "UPDATE tbl_barang SET stok = stok - $jumlah WHERE kode_brg = '$kode_brg'") or die(mysqli_error($db));

        echo "<script>
                alert('Barang berhasil ditambahkan ke nota penjualan! Stok telah diperbarui.');
                window.location.href='index.php?kode-nota=$kode_nota';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan barang ke nota!');
                window.location.href='index.php?kode-nota=$kode_nota';
              </script>";
    }
}
?>