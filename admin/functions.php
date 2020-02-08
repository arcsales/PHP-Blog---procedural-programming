<?php
function confirm($result)
{
    global $conn;
    if (!$result) {
        die('Something is wrong' . mysqli_error($conn));
    }
}

function users_online()
{
    global $conn;

    $session = session_id();
    $time = time();
    $time_out_in_seconds = 30;
    $time_out = $time - $time_out_in_seconds;
    $query = "SELECT * FROM users_online WHERE session = '$session' ";
    $send_query = mysqli_query($conn, $query);
    $count = mysqli_num_rows($send_query);

    if ($count == NULL) {
        mysqli_query($conn, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
    } else {
        mysqli_query($conn, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    $users_online = mysqli_query($conn, "SELECT * FROM users_online WHERE time > '$time_out'");
    return $count_users = mysqli_num_rows($users_online);
}

function insert_categories()
{
    global $conn;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be enpty.";
        } else {
            $query = "INSERT INTO categories (cat_title) ";
            $query .= "VALUE('{$cat_title}')";
            $create_category = mysqli_query($conn, $query);

            if (!$create_category) {
                die("Category was not created!" . mysqli_error($create_category));
            }
        }
    }
}
function findAllCategories()
{
    global $conn;
    $query = "SELECT * FROM categories";
    $getCategories = mysqli_query($conn, $query);

    while ($category = mysqli_fetch_assoc($getCategories)) {
        $cat_id = $category["cat_id"];
        $cat_title = $category["cat_title"];
        echo "<tr>
                                    <td>{$cat_id}</td>
                                    <td>{$cat_title}</td>
                                    <td><a href='categories.php?edit={$cat_id}'>Edit</td>
                                    <td><a href='categories.php?delete={$cat_id}'>Delete</td>
                                    </tr>";
    }
}
function deleteCategory()
{
    global $conn;
    if (isset($_GET['delete'])) {
        $cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$cat_id}";
        $delete_request = mysqli_query($conn, $query);
        header("Location: categories.php");
    }
}
