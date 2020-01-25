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
            if (isset($_POST["submit"])) {
                $searchQuery = $_POST["search"];
                $query = "SELECT * FROM posts WHERE tags LIKE '%$searchQuery%'";
                $reqQuery = mysqli_query($conn, $query);
                if (!$reqQuery) {
                    die("Query Failed" . mysqli_error($reqQuery));
                }

                $count = mysqli_num_rows($reqQuery);
                if ($count == 0) {
                    echo "<h1>No Results</h1>";
                } else {
                    while ($post = mysqli_fetch_assoc($reqQuery)) {
                        $post_title = $post["title"];
                        $post_author = $post["author"];
                        $post_date = $post["date"];
                        $post_image = $post["image"];
                        $post_content = $post["content"]; ?>

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
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
            <?php }
                }
            } ?>

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