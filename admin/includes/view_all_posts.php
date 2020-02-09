<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $post_value_id) {
        $bulk_options = $_POST['bulk-options'];
        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET status = '{$bulk_options}' WHERE id = $post_value_id ";
                $bulk_publish = mysqli_query($conn, $query);
                break;
            case 'draft':
                $query = "UPDATE posts SET status = '{$bulk_options}' WHERE id = $post_value_id ";
                $bulk_draft = mysqli_query($conn, $query);
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE id = $post_value_id ";
                $bulk_delete = mysqli_query($conn, $query);
                break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE id = $post_value_id ";
                $bulk_clone = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_array($bulk_clone)) {
                    $title = $row['title'];
                    $category_id = $row['category_id'];
                    $date = $row['date'];
                    $author = $row['author'];
                    $status = $row['status'];
                    $image = $row['image'];
                    $tags = $row['tags'];
                    $content = $row['content'];
                }

                $query = "INSERT INTO posts(title, category_id, date, author, status, image, tags, content )";
                $query .= "VALUES('{$title}', '{$category_id}', '{$date}', '{$author}', '{$status}', '{$image}', '{$tags}', '{$content}' )";
                $copy_query = mysqli_query($conn, $query);
                confirm($conn);
                break;
        }
    }
}
?>
<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk-options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>
        </div>
        <thead>
            <tr>
                <td><input type="checkbox" id="selectAllBoxes"></td>
                <td>ID</td>
                <td>Title</td>
                <td>Category</td>
                <td>Author</td>
                <td>Status</td>
                <td>Image</td>
                <td>Tags</td>
                <td>Comments</td>
                <td>Date</td>
                <td>Views</td>
                <td>View Post</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM posts ORDER BY id DESC";
            $getPosts = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($getPosts)) {
                $post_id = $row['id'];
                $author = $row['author'];
                $title = $row['title'];
                $category = $row['category_id'];
                $status = $row['status'];
                $image = $row['image'];
                $tags = $row['tags'];
                $comments = $row['comment_count'];
                $date = $row['date'];
                $views = $row['views_count'];
                echo "<tr>"; ?>

                <td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>

            <?php
                echo "<td>{$post_id}</td>
                                <td>{$title}</td>";

                $query = "SELECT * FROM categories WHERE cat_id = {$category}";
                $getCategories = mysqli_query($conn, $query);

                while ($category = mysqli_fetch_assoc($getCategories)) {
                    $cat_id = $category["cat_id"];
                    $cat_title = $category["cat_title"];
                }
                echo "<td>{$cat_title}</td>

                                <td>{$author}</td>
                                <td>{$status}</td>
                                <td><img class='img-thumbnail' src='../images/{$image}'/></td>
                                <td>{$tags}</td>";
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_query = mysqli_query($conn, $query);
                $comment_count = mysqli_num_rows($send_query);
                echo "<td>{$comment_count}</td>";

                echo "<td>{$date}</td>
                                <td><a href='posts.php?reset={$post_id}'>{$views}</a></td>
                                <td><a href='../post.php?p_id={$post_id}'>View</a></td>
                                <td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>
                                <td><a onClick =\"javascript: return confirm('Are you sure you want to delete the post?')\" href='posts.php?delete={$post_id}'>Delete</a></td>
                                </tr>";
            }
            ?>

        </tbody>
    </table>
</form>
<?php if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE id = {$post_id}";
    $getDeleted = mysqli_query($conn, $query);
    header("Location: posts.php");
}
if (isset($_GET['reset'])) {
    $post_id = $_GET['reset'];
    $query = "UPDATE posts SET views_count = 0 WHERE id = {$post_id}";
    $resetQuery = mysqli_query($conn, $query);
    header("Location: posts.php");
} ?>