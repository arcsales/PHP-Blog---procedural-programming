<?php
if (isset($_POST['create_post'])) {
    $post_title = $_POST['title'];
    $post_author = $_POST['author'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
    //$post_comment_count = 4;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(category_id, author, status, date,title,content,image,tags )";
    $query .= "VALUES({$post_category_id}, '{$post_author}', '{$post_status}', now(), '{$post_title}', '{$post_content}', '{$post_image}', '{$post_tags}' )";
    $add_post = mysqli_query($conn, $query);
    confirm($add_post);
    $the_post_id = mysqli_insert_id($conn);
    echo "<p class='bg-success'>Post Added! <a href='../post.php?p_id=$the_post_id'>View post</a> or <a href='add_post.php'>Create more posts</a></p>";
}
?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input id="title" class="form-control" type="text" name="title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category ID</label>

        <select name="post_category" id="">
            <?php
            $query = "SELECT * FROM categories";
            $getCategories = mysqli_query($conn, $query);

            confirm($getCategories);
            while ($category = mysqli_fetch_assoc($getCategories)) {
                $cat_id = $category["cat_id"];
                $cat_title = $category["cat_title"];
                echo "<option name='{$cat_id}' value='{$cat_id}'>{$cat_title}</option>";
            }

            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="author">Post Author</label>
        <input id="author" class="form-control" type="text" name="author">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status">
            <option value="draft">Select Option</option>
            <option value="draft">Draft</option>
            <option value="published">Publish</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input id="post_image" class="form-control" type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input id="post_tags" class="form-control" type="text" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="body" class="form-control" type="text" name="post_content" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>