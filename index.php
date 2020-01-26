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
            $query = "SELECT * from posts";
            $getPosts = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($getPosts)) {
                $post_id = $row["id"];
                $post_title = $row["title"];
                $post_author = $row["author"]; 
                $post_date = $row["date"];
                $post_image = $row["image"];
                $post_content = substr($row["content"], 0, 150) . "...";
                $post_status = $row["status"];
                if ($post_status == 'published') {

            ?>
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
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo  $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

            <?php  }
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