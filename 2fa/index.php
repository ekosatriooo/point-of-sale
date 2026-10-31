<?php
require_once '../database/koneksi.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../asset_login/fonts/icomoon/style.css">

    <link rel="stylesheet" href="../asset_login/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../asset_login/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../asset_login/css/style.css">

    <title>Login #2</title>
</head>

<body>
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('../asset_login/images/pos.webp');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <h3><strong>POS</strong></h3>
                        <form action="" method="post">
                            <div class="form-group first">
                                <label for="username">PIN</label>
                                <input type="text" class="form-control" placeholder="masukkan pin" id="pin" name="pin"
                                    Required>
                            </div>
                            <input type="submit" value="Log In" class="btn btn-block btn-primary" name="btn_2fa">
                        </form>
                        <?php
                          if (isset($_POST['btn_2fa'])) {  // triger button login ketiak ditekan
                            $pin = trim(mysqli_real_escape_string($db, $_POST['pin']));
                            $peran = @$_SESSION['peran'];
                            $pin2fa = @$_SESSION['pin2fa'];
                            if ($pin == $pin2fa) { 
                            if ($peran == 'S') {
                                echo '<script>window.location.href="../home_superadmin"</script>';
                                    } elseif ($peran == 'K') {
                                        echo '<script>window.location.href="../home_kasir"</script>';       
                                        } else {
                                            
                                        } 
                                } else {
                                    echo '<script>alert ("PIN yang anda masukkan salah")</script>'; 
                                    echo '<script>window.location.href="../../pos"</script>';
                                    } 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../asset_login/js/jquery-3.3.1.min.js"></script>
    <script src="../asset_login/js/popper.min.js"></script>
    <script src="../asset_login/js/bootstrap.min.js"></script>
    <script src="../asset_login/js/main.js"></script>
</body>

</html>