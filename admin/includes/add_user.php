<?php
if (isset($_POST['create_user'])) {

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];

    /* $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name']; */

    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
    /*  $post_date = date('d-m-y');
    $post_comment_count = 4;

    move_uploaded_file($post_image_temp, "../images/$post_image");
 */
    $query = "INSERT INTO users (user_firstname, user_lastname, user_role,username,user_email,user_password) ";
    $query .= "VALUES ('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}' )";
    $add_user = mysqli_query($conn, $query);
    confirm($add_user);
    echo "User created: " . " " . "<a href='users.php'>View Users</a>";
}
?>


<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input id="user_firstname" class="form-control" type="text" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input id="user_lastname" class="form-control" type="text" name="user_lastname">
    </div>
    <div class="form-group">
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>

    <!--     <div class="form-group">
        <label for="post_image">Last Name</label>
        <input id="post_image" class="form-control" type="file" name="image">
    </div> -->
    <div class="form-group">
        <label for="username">Username</label>
        <input id="username" class="form-control" type="text" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input id="user_email" class="form-control" type="email" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">User Password</label>
        <input id="user_password" class="form-control" type="password" name="user_password">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>