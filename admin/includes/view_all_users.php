<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Email</td>
            <td>Role</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM users";
        $getUsers = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($getUsers)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
            echo "<tr>
                    <td>{$user_id}</td>
                    <td>{$username}</td>
                    <td>{$user_firstname}</td>
                    <td>{$user_lastname}</td>
                    <td>{$user_email}</td>
                    <td>{$user_role}</td>";
            /*  $query = "SELECT * FROM posts WHERE id = $comment_post_id";
            $request_post_title = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($request_post_title)) {
                $post_id = $row['id'];
                $post_title = $row['title'];
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            } */
            echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>
            <td><a href='users.php?change_to_syb={$user_id}'>Subscriber</a></td>
            <td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>
                    <td><a href='users.php?delete={$user_id}'>Delete</a></td>
                    </tr>";
        }
        ?>
    </tbody>
</table>
<?php if (isset($_GET['change_to_admin'])) {
    $user_id = $_GET['change_to_admin'];
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $user_id";
    $makeAdmin = mysqli_query($conn, $query);
    header("Location: users.php");
}
if (isset($_GET['change_to_syb'])) {
    $user_id = $_GET['change_to_syb'];
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $user_id";
    $makeSubscriber = mysqli_query($conn, $query);
    header("Location: users.php");
}
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $query = "DELETE FROM users WHERE user_id = {$user_id}";
    $getDeleted = mysqli_query($conn, $query);
    header("Location: users.php");
} ?>