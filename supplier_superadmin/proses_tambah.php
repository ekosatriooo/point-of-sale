<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
    $kode = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $nama = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $nama_pic = trim(mysqli_real_escape_string($db, $_POST['nama_pic']));
    $kontak_pic = trim(mysqli_real_escape_string($db, $_POST['kontak_pic']));
    $alamat = trim(mysqli_real_escape_string($db, $_POST['alamat']));
    $website = trim(mysqli_real_escape_string($db, $_POST['website']));
    $akun_ig = trim(mysqli_real_escape_string($db, $_POST['akun_ig']));
    $akun_tiktok = trim(mysqli_real_escape_string($db, $_POST['akun_tiktok']));
    
    $query_cek = mysqli_query($db, "SELECT kode_supplier FROM tbl_supplier WHERE kode_supplier = '$kode'") or die (mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);
    if ($rv > 0) {
        echo '<script>alert ("data supplier sudah terdaftar")</script>';
        echo '<script>window.location.href="../supplier_superadmin"</script>';
        } else {
            $query_simpan = mysqli_query($db, "INSERT INTO tbl_supplier VALUES ('$kode', '$nama', '$nama_pic', '$kontak_pic', '$alamat', '$website', '$akun_ig', '$akun_tiktok')") or die (mysqli_error($db));
            echo '<script>alert ("data supplier berhasil terdaftar")</script>';
            echo '<script>window.location.href="../supplier_superadmin"</script>';
            } 
}
?>