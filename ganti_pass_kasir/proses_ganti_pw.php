<?php
require_once '../database/koneksi.php';

if (isset($_POST['btn_ganti'])) {
    $username = trim(mysqli_real_escape_string($db, $_POST['username']));
    $pw_baru = trim(mysqli_real_escape_string($db, $_POST['pw']));
    $konfirmasi = trim(mysqli_real_escape_string($db, $_POST['konfirmasi']));

    if ($pw_baru == $konfirmasi) {
        // pw baru dienkripsi
        $pw_enkripsi = sha1($pw_baru);
        // berhasil ketika pw baru dan konfirmasi pw baru sama
        $query_ganti_pw = mysqli_query($db, "UPDATE tbl_user SET sandi = '$pw_enkripsi' WHERE username = '$username'") or die (mysqli_error($db));
        echo '<script>alert ("ganti password telah berhasil")</script>';
        echo '<script>window.location.href="../logout.php"</script>';
    } else {
        echo '<script>alert ("password baru dan konfirmasi password tidak sama")</script>';
        echo '<script>window.location.href="../ganti_pass_kasir"</script>';
    }
}

?>