<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah_barang'])) {
    $kode_nota  = $_POST['kode_nota'];
    $kode_brg   = $_POST['kode_brg'];
    $jumlah     = $_POST['jumlah'];
    $harga_beli = $_POST['harga_beli'];

    $total_harga_beli = $jumlah * $harga_beli;

    $query_simpan = mysqli_query($db, "INSERT INTO tbl_detail_notabeli (kode_nota, kode_brg, jumlah, harga_beli, total_harga_beli) 
                                       VALUES ('$kode_nota', '$kode_brg', '$jumlah', '$harga_beli', '$total_harga_beli')") or die(mysqli_error($db));

    if ($query_simpan) {
        $query_update_barang = mysqli_query($db, "UPDATE tbl_barang 
                                                  SET stok = stok + $jumlah, 
                                                      rata_harga_beli = '$harga_beli' 
                                                  WHERE kode_brg = '$kode_brg'") or die(mysqli_error($db));
        $query_update_nota = mysqli_query($db, "UPDATE tbl_nota 
                                                SET total_pembelian = total_pembelian + $total_harga_beli 
                                                WHERE kode_nota = '$kode_nota'") or die(mysqli_error($db));
        echo "<script>
                alert('Barang berhasil ditambahkan!');
                window.location.href='index.php?kode-nota=$kode_nota';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan barang!');
                window.location.href='index.php?kode-nota=$kode_nota';
              </script>";
    }
}