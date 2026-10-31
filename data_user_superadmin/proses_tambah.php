<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn_tambah'])) {
    $nama = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $username = trim(mysqli_real_escape_string($db, $_POST['username']));
    $peran = trim(mysqli_real_escape_string($db, $_POST['peran']));
    $pin2fa = "12345";
    $sandi = sha1($username);
    $query_cek = mysqli_query($db, "SELECT username FROM tbl_user WHERE username = '$username'") or die (mysqli_error($db));
    $rv = mysqli_num_rows($query_cek);
    if ($rv > 0) {
        echo '<script>alert ("data user sudah terdaftar")</script>';
        echo '<script>window.location.href="../data_user_superadmin"</script>';
        } else {
            $query_simpan = mysqli_query($db, "INSERT INTO tbl_user VALUES ('$username', '$sandi', '$peran', '$nama', '$pin2fa')") or die (mysqli_error($db));
            echo '<script>alert ("data user berhasil terdaftar")</script>';
            echo '<script>window.location.href="../data_user_superadmin"</script>';
            } 
}
?>