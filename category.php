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
            if (isset($_GET['category'])) {
                $post_cat_id = $_GET['category'];
            }
            $query = "SELECT * from posts WHERE category_id = {$post_cat_id}";
            $getPosts = mysqli_query($conn, $query);
            while ($post = mysqli_fetch_assoc($getPosts)) {
                $post_id = $post["id"];
                $post_title = $post["title"];
                $post_author = $post["author"];
                $post_date = $post["date"];
                $post_image = $post["image"];
                $post_content = substr($post["content"], 0, 150) . "..."; ?>

                <h2>
                    <a href="post.php?p_id=<?php echo  $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo  $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

            <?php  } ?>

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