<?php include("includes/header.php"); ?>
<?php if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_profile = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($select_user_profile)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
} ?>

<?php
if (isset($_GET['edit_user'])) {
    $user_id = $_GET['edit_user'];
    $query = "SELECT * FROM users WHERE user_id = $user_id ";
    $selectUsers = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($selectUsers)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}

if (isset($_POST['update_user'])) {

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];

    /* $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name']; */

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    /*  $post_date = date('d-m-y');
    $post_comment_count = 4;

    move_uploaded_file($post_image_temp, "../images/$post_image");
 */
    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "user_password = '{$user_password}', ";
    $query .= "user_email = '{$user_email}' ";
    $query .= "WHERE username = '{$username}' ";
    $update_user = mysqli_query($conn, $query);
    confirm($update_user);
}

?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include("includes/nav.php") ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Blank Page
                        <small>Author</small>
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data">


                        <div class="form-group">
                            <label for="user_firstname">First Name</label>
                            <input id="user_firstname" value="<?php echo $user_firstname; ?>" class="form-control" type="text" name="user_firstname">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Last Name</label>
                            <input id="user_lastname" value="<?php echo $user_lastname; ?>" class="form-control" type="text" name="user_lastname">
                        </div>
                        <div class="form-group">
                            <select name="user_role" id="">
                                <option value="subscriber"><?php echo $user_role; ?></option>
                                <?php
                                if ($user_role == 'admin') {
                                    echo "<option value='subscriber'>subscriber</option>";
                                } else {
                                    echo "<option value='admin'>admin</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!--     <div class="form-group">
        <label for="post_image">Last Name</label>
        <input id="post_image" class="form-control" type="file" name="image">
    </div> -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" value="<?php echo $username; ?>" class="form-control" type="text" name="username">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input id="user_email" value="<?php echo $user_email; ?>" class="form-control" type="email" name="user_email">
                        </div>
                        <div class="form-group">
                            <label for="user_password">User Password</label>
                            <input id="user_password" value="<?php echo $user_password; ?>" class="form-control" type="password" name="user_password">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="update_user" value="Update Profile">
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include("includes/footer.php"); ?>