<?php

if (isset($_GET['edit_user'])) {
    $user_id = $_GET['edit_user'];
    $query = "SELECT * FROM users WHERE user_id = $user_id ";
    $selectUsers = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($selectUsers)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        //$get_user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}

if (isset($_POST['edit_user'])) {

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_role = '{$user_role}', ";
    if (isset($_POST['user_password']) && $_POST['user_password'] != '') {
        $query .= "user_password = '{$user_password}', ";
    }
    $query .= "user_email = '{$user_email}' ";
    $query .= "WHERE user_id = '{$user_id}' ";
    $update_user = mysqli_query($conn, $query);
    confirm($update_user);
    $asd = $_POST['user_password'];
    echo "ff " . $_POST['user_password'] . "ff";
}
?>


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
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
            if ($user_role == 'admin') {
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>

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
        <input id="user_password" value="" class="form-control" type="password" name="user_password">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
    </div>
</form>