<?php include('includes/db.php'); ?>
<?php include('includes/header.php'); ?>

<!-- Navigation -->
<?php include('includes/nav.php'); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8"> 

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <?php
            if (isset($_GET['p_id'])) {
                $post_id = $_GET['p_id'];
                $post_author = $_GET['author'];
            }



            $query = "SELECT * from posts WHERE author = '{$post_author}' ";
            $getPosts = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($getPosts)) {
                $post_title = $row["title"];
                $post_author = $row["author"];
                $post_date = $row["date"];
                $post_image = $row["image"];
                $post_content = $row["content"]; ?>

                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
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
                    $query = "UPDATE posts SET comment_count = comment_count + 1 ";
                    $query .= "WHERE id=$post_id";
                    $updateComment = mysqli_query($conn, $query);
                    echo "<script>alert('Your comment is awaiting for moderation!')</script>";
                } else {
                    echo "<script>alert('Fields cannot be empty!')</script>";
                }
            }

            ?>




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