<?php
include "includes/db.php";
include "includes/header.php";
include "includes/nav.php";

if (!isset($_GET['email']) && !isset($_GET['token'])) {
    redirect('../index.php');
}
/* 
$email = 'arcsalesltd@gmail.com';
$token = '6abc34d9b52c7701faf11d220f221358711bbb520253061fe47db797e8ce6d4529e834dc69b469c83127cbb0796c625231f2'; */
if ($stmt = mysqli_prepare($conn, "SELECT username, user_email, token FROM users WHERE token= ?")) {
    mysqli_stmt_bind_param($stmt, 's', $_GET['token']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    /*     if ($_GET['token'] != $token || $_GET['email'] != $email) {
        redirect('../index.php');
    } */
    if (isset($_POST['password']) && isset($_POST['passwordConfirm'])) {
        if ($_POST['password'] === $_POST['passwordConfirm']) {
            $password   = $_POST['password'];
            $hasshedPassord = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
            if ($stmt = mysqli_prepare($conn, "UPDATE users SET token='', user_password='{$hasshedPassord}' WHERE user_email = ?")) {
                mysqli_stmt_bind_param($stmt, 's', $_GET['email']);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_affected_rows($stmt) >= 1) {
                    redirect('../login.php');
                }
                mysqli_stmt_close($stmt);
                $veirfied = true;
            }
        }
    }
}

?>


<!-- Page Content -->
<div class="container">

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset Password</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                                <input id="password" name="password" placeholder="Enter password" class="form-control" type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-repeat color-blue"></i></span>
                                                <input id="passwordConfirm" name="passwordConfirm" placeholder="Confirm password" class="form-control" type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->