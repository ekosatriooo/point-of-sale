<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $kode = trim(mysqli_real_escape_string($db, $_POST['kode']));
    $nama = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $nama_pic = trim(mysqli_real_escape_string($db, $_POST['nama_pic']));
    $kontak_pic = trim(mysqli_real_escape_string($db, $_POST['kontak_pic']));
    $alamat = trim(mysqli_real_escape_string($db, $_POST['alamat']));
    $website = trim(mysqli_real_escape_string($db, $_POST['website']));
    $akun_ig = trim(mysqli_real_escape_string($db, $_POST['akun_ig']));
    $akun_tiktok = trim(mysqli_real_escape_string($db, $_POST['akun_tiktok']));
    
    $query_edit_supplier = mysqli_query($db, "UPDATE tbl_supplier SET nama_supplier = '$nama', nama_pic = '$nama_pic', kontak_pic = '$kontak_pic', alamat_supplier = '$alamat', website = '$website', akun_ig = '$akun_ig', akun_tiktok = '$akun_tiktok' WHERE kode_supplier = '$kode'") or die (mysqli_error($db));
        echo '<script>alert ("data supplier berhasil diperbarui")</script>';
        echo '<script>window.location.href="../supplier_superadmin"</script>';
}
?>