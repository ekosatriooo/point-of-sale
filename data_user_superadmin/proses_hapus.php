<?php 
require_once '../database/koneksi.php';

$username = $_GET['username'];
if (isset($username)) {
    $query_hapus = mysqli_query($db, "DELETE FROM tbl_user WHERE username = '$username'") or die (mysqli_error($db));
        echo '<script>alert ("data user berhasil dihapus")</script>';
        echo '<script>window.location.href="../data_user_superadmin"</script>';
}
?>