<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn_edit'])) {
    $nama = trim(mysqli_real_escape_string($db, $_POST['nama']));
    $username = trim(mysqli_real_escape_string($db, $_POST['username']));
    $peran = trim(mysqli_real_escape_string($db, $_POST['peran']));
    
    $query_edit_user = mysqli_query($db, "UPDATE tbl_user SET nama_panggilan = '$nama', peran = '$peran' WHERE username = '$username'") or die (mysqli_error($db));
        echo '<script>alert ("data user berhasil diperbarui")</script>';
        echo '<script>window.location.href="../data_user_superadmin"</script>';
}
?>