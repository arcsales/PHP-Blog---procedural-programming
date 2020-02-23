<?php
if (isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE id = $the_post_id";
$getPosts_by_id = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($getPosts_by_id)) {
    $post_id = $row['id'];
    $author = $row['author'];
    $title = $row['title'];
    $content = $row['content'];
    $category = $row['category_id'];
    $status = $row['status'];
    $image = $row['image'];
    $tags = $row['tags'];
    $comments = $row['comment_count'];
    $date = $row['date'];
}
if (isset($_POST['update_post'])) {
    $author = $_POST['author'];
    $title = $_POST['title'];
    $content =  escape($_POST['post_content']);
    $category = $_POST['post_category'];
    $status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $tags = $_POST['post_tags'];

    move_uploaded_file($post_image_temp, "..images/$post_image");
    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE id = $the_post_id";
        $select_image = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($select_image)) {
            $post_image = $row['image'];
        }
    }

    $query = "UPDATE posts SET ";
    $query .= "title = '{$title}', ";
    $query .= "category_id = '{$category}', ";
    $query .= "date = now(), ";
    $query .= "author = '{$author}', ";
    $query .= "status = '{$status}', ";
    $query .= "tags = '{$tags}', ";
    $query .= "image = '{$post_image}' ";
    $query .= "WHERE id = '{$the_post_id}' ";
    $update_post = mysqli_query($conn, $query);
    confirm($update_post);
    echo "<p class='bg-success'>Post updated! <a href='../post.php?p_id=$the_post_id'>View post</a> or <a href='posts.php'>Edit more posts</a></p>";
}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $title; ?>" id="title" class="form-control" type="text" name="title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category ID</label>

        <select name="post_category" id="">
            <?php
            $query = "SELECT * FROM categories";
            $getCategories = mysqli_query($conn, $query);
            confirm($getCategories);

            while ($row = mysqli_fetch_assoc($getCategories)) {
                $cat_id = $row["cat_id"];
                $cat_title = $row["cat_title"];
                if ($cat_id == $category) {
                    echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="author">Post Author</label>

        <select name="author" id="">
            <option value='<?php echo $author; ?>'><?php echo $author; ?></option>
            <?php
            $query = "SELECT * FROM users";
            $getUsers = mysqli_query($conn, $query);

            confirm($getUsers);
            while ($row = mysqli_fetch_assoc($getUsers)) {
                $user_id = $row["user_id"];
                $username = $row["username"];
                if ($username != $author) {
                    echo "<option value='{$username}'>{$username}</option>";
                }
            }

            ?>
        </select>
    </div>

    <!--   <div class="form-group">
        <label for="author">Post Author</label>
        <input value="<?php //echo $author; 
                        ?>" id="author" class="form-control" type="text" name="author">
    </div> -->

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="">
            <option value='<?php echo $status ?>'><?php echo $status ?></option>
            <?php if ($status == "draft") {
                echo "<option value='published'>Published</option>";
            } else {
                echo "<option value='draft'>Draft</option>";
            } ?>
        </select></div>

    <!--     <div class="form-group">
        <label for="post_status">Post Status</label>
        <input value="<?php echo $status; ?>" id="post_status" class="form-control" type="text" name="post_status">
    </div> -->

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img class="img-thumbnail" src="../images/<?php echo $image; ?>">
        <input id="post_image" class="form-control" type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $tags; ?>" id="post_tags" class="form-control" type="text" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="post_content" class="form-control" type="text" name="post_content" cols="30" rows="10"><?php echo str_replace('\r\n','</br>',$content); ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Publish Post">
    </div>
</form>