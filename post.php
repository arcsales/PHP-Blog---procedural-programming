<?php include('includes/db.php'); ?>
<?php include('includes/header.php'); ?>

<!-- Navigation -->
<?php include('includes/nav.php'); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            if (isset($_GET['p_id'])) {
                $post_id = $_GET['p_id'];

                $view_query = "UPDATE posts SET views_count = views_count + 1 WHERE id = $post_id ";
                $update_views = mysqli_query($conn, $view_query);
                confirm($conn);

                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    $query = "SELECT * FROM posts WHERE id = {$post_id}";
                } else {

                    $query = "SELECT * FROM posts WHERE id = {$post_id} AND status = 'published'";
                }

                $getPosts = mysqli_query($conn, $query);
                if (mysqli_num_rows($getPosts) < 1) {

                    echo "<h1 class='text-center'>No posts available!</h1>";
                } else {
                    while ($post = mysqli_fetch_assoc($getPosts)) {
                        $post_title = $post["title"];
                        $post_author = $post["author"];
                        $post_date = $post["date"];
                        $post_image = $post["image"];
                        $post_content = $post["content"]; ?>

                        <h1 class="page-header">
                            Posts
                        </h1>

                        <h2>
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content; ?></p>

                        <hr>

                    <?php  } ?>

                    <?php
                    if (isset($_POST['create_comment'])) {
                        $post_id = $_GET['p_id'];
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        if (!empty($post_id) && !empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                            $query .= "VALUES ($post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now() )";
                            $post_comment = mysqli_query($conn, $query);
                            if (!$post_comment) {
                                die('Something is wrong' . mysqli_error($conn));
                            }
                            /*       $query = "UPDATE posts SET comment_count = comment_count + 1 ";
                    $query .= "WHERE id=$post_id";
                    $updateComment = mysqli_query($conn, $query); */
                            echo "<script>alert('Your comment is awaiting for moderation!')</script>";
                        } else {
                            echo "<script>alert('Fields cannot be empty!')</script>";
                        }
                    }

                    ?>

                    <!-- Comments form -->
                    <div class="well">
                        <h4>Leave a comment</h4>
                        <form action="" method="post" role="form">
                            <div class="form-group">
                                <label for="Author">Author</label>
                                <input class="form-control" type="text" name="comment_author">
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input class="form-control" type="email" name="comment_email">
                            </div>

                            <div class="form-group">
                                <label for="Comment">Comment</label>
                                <textarea name="comment_content" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                        </form>
                    </div>


                    <!-- Posted Comments -->
                    <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
                    $query .= "AND comment_status = 'approved' ";
                    $query .= "ORDER BY comment_id DESC";
                    $select_all_comments = mysqli_query($conn, $query);
                    if (!($select_all_comments)) {
                        die('Query failed' . mysqli_error($conn));
                    }
                    while ($row = mysqli_fetch_assoc($select_all_comments)) {
                        $comment_date = $row['comment_date'];
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                    ?>

                        <!-- Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author ?>
                                    <small><?php echo $comment_date ?></small>
                                </h4>
                                <?php echo $comment_content ?>
                            </div>
                        </div>

            <?php }
                }
            } else {
                header("Location: index.php");
            }  ?>




            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include('includes/sidebar.php'); ?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include("includes/footer.php"); ?>