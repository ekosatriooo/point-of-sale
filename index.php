<?php
require_once 'database/koneksi.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="asset_login/fonts/icomoon/style.css">

    <link rel="stylesheet" href="asset_login/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="asset_login/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="asset_login/css/style.css">

    <title>POS | Login</title>
</head>

<body>
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('asset_login/images/pos.webp');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <h3><strong>POS</strong></h3>
                        <form action="" method="post">
                            <div class="form-group first">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" placeholder="masukkan username" id="username"
                                    name="user" Required>
                            </div>
                            <div class="form-group last mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" placeholder="masukkan password"
                                    id="password" name="sandi" Required>
                            </div>
                            <input type="submit" value="Log In" class="btn btn-block btn-primary" name="btn_login">

                        </form>
                        <?php
                          if (isset($_POST['btn_login'])) {  // triger button login ketika ditekan
                            $user = trim(mysqli_real_escape_string($db, $_POST['user'])); 
                            $sandi = sha1(trim(mysqli_real_escape_string($db, $_POST['sandi'])));
                            
                            $query_cek_user = mysqli_query($db, "SELECT * FROM tbl_user WHERE username = '$user' AND sandi = '$sandi'") or die (mysqli_error($db));
                            $rv = mysqli_num_rows($query_cek_user);
                            if ($rv == 1) {
                              $data = mysqli_fetch_assoc($query_cek_user);
                              $user = $data['username'];
                              $peran = $data['peran'];
                              $nama = $data['nama_panggilan'];
                              $pin = $data['pin2fa'];
 
                              $_SESSION['username'] = $user;
                              $_SESSION['peran'] = $peran;
                              $_SESSION['nama_panggilan'] = $nama;
                              $_SESSION['pin2fa'] = $pin;
                              if ($peran == 'S') {
                                echo '<script>window.location.href="2fa"</script>';
                                  } else {
                                    echo '<script>window.location.href="2fa"</script>';         
                                  }
                            } else {
                                echo '<script>alert ("user tidak ditemukan")</script>';
                                echo '<script>window.location.href="../pos"</script>';
                              }
                          }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src=" asset_login/js/jquery-3.3.1.min.js"></script>
    <script src="asset_login/js/popper.min.js"></script>
    <script src="asset_login/js/bootstrap.min.js"></script>
    <script src="asset_login/js/main.js"></script>
</body>

</html>