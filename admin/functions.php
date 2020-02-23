<?php
function redirect($location)
{
    header("Location: " . 'PHPLyrics/' . $location);
    exit;
}
function ifItIsMethod($method = null)
{
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}
function isLoggedIn()
{
    if (isset($_SESSION['role'])) {
        return true;
    } else {
        return false;
    }
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation = null)
{
    if (isLoggedIn()) {
        redirect($redirectLocation);
    }
}
function set_message($msg)
{

    if (!$msg) {
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}


function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

//escape any string and get safe from mysql injection 
function escape($string)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($string));
}
//confirm DB connection
function confirm($result)
{
    global $conn;
    if (!$result) {
        die('Something is wrong' . mysqli_error($conn));
    }
}
//count users online
function users_online()
{
    if (isset($_GET['onlineusers'])) {
        global $conn;
        if (!$conn) {
            session_start();

            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
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
            echo $count_users = mysqli_num_rows($users_online);
        }
    }
}
users_online();

function insert_categories()
{
    global $conn;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be enpty.";
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO categories (cat_title) VALUES(?) ");
            mysqli_stmt_bind_param($stmt, 's', $cat_title);
            mysqli_stmt_execute($stmt);
            if (!$stmt) {
                die("Category was not created!" . mysqli_error($stmt));
            }
        }
        mysqli_stmt_close($stmt);
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
//deleting category as per get request
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

//count num of rows in tables - returns a number
function recordCount($table)
{
    global $conn;
    $query = "SELECT * FROM " . $table;
    $select_all_posts = mysqli_query($conn, $query);
    $result = mysqli_num_rows($select_all_posts);
    confirm($result);
    return $result;
}

//count ALL rows from any table 
function countAllRowsInTable($table, $column, $status)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $result = mysqli_query($conn, $query);
    confirm($result);
    return mysqli_num_rows($result);
}
//count ALL users per role specified 
function countUserPerRole($role)
{
    global $conn;
    $query = "SELECT * FROM users WHERE user_role = '$role'";
    $result = mysqli_query($conn, $query);
    confirm($result);
    return mysqli_num_rows($result);
}
//check if user_role is admin
function isAdmin($username)
{
    global $conn;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    confirm($result);
    $row = mysqli_fetch_array($result);
    if (!isset($row['user_role'])) {
        return false;
    } else if ($row['user_role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

//check if username exists
function usernameExists($username)
{
    global $conn;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    confirm($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
} //check if email exists
function emailExists($email)
{
    global $conn;
    $query = "SELECT username FROM users WHERE user_email = '$email'";
    $result = mysqli_query($conn, $query);
    confirm($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
function registerUser($username, $email, $password)
{
    global $conn;

    $username =  mysqli_real_escape_string($conn, $_POST['username']);
    $email =  mysqli_real_escape_string($conn, $_POST['email']);
    $password =  mysqli_real_escape_string($conn, $_POST['password']);
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users (username, user_password, user_email, user_role) ";
    $query .= "VALUES ('{$username}','{$password}','{$email}','subscriber') ";
    $createUser = mysqli_query($conn, $query);
    confirm($conn);
}
function loginUser($username, $password)
{
    global $conn;
    $username = trim($username);
    $password = trim($password);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($conn, $query);
    confirm($select_user_query);

    while ($row = mysqli_fetch_assoc($select_user_query)) {
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

        if (password_verify($password, $db_user_password)) {
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['role'] = $db_user_role;
            redirect("../admin");
        } else {
            false;
        }
    }
    return true;
}
