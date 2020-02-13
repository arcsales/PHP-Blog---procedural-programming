<?php include("includes/header.php"); ?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include("includes/nav.php") ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Blank Page
                        <small>Author</small>
                    </h1>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Author</td>
                                <td>Comment</td>
                                <td>Email</td>
                                <td>Status</td>
                                <td>In Response to</td>
                                <td>Date</td>
                                <td>Approve</td>
                                <td>Unapprove</td>
                                <td>Delete</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($conn, $_GET['id']) . " ";
                            $getComments = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($getComments)) {
                                $comment_id = $row['comment_id'];
                                $comment_author = $row['comment_author'];
                                $comment_post_id = $row['comment_post_id'];
                                $comment_email = $row['comment_email'];
                                $comment_content = $row['comment_content'];
                                $comment_status = $row['comment_status'];
                                $comment_date = $row['comment_date'];
                                echo "<tr>
                    <td>{$comment_id}</td>
                    <td>{$comment_author}</td>
                    <td>{$comment_content}</td>";

                                echo "<td>{$comment_email}</td>
            <td>{$comment_status}</td>";
                                $query = "SELECT * FROM posts WHERE id = $comment_post_id";
                                $request_post_title = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($request_post_title)) {
                                    $post_id = $row['id'];
                                    $post_title = $row['title'];
                                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                                }
                                echo "<td>{$comment_date}</td>
                    <td><a href='post_comments.php?approve={$comment_id}&id=" . $_GET['id'] . "'>Approve</a></td>
                    <td><a href='post_comments.php?unapprove={$comment_id}&id=" . $_GET['id'] . "'>Unapprove</a></td>
                    <td><a href='post_comments.php?delete={$comment_id}&id=" . $_GET['id'] . "'>Delete</a></td>
                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php if (isset($_GET['approve'])) {
                        $comment_id = $_GET['approve'];
                        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $comment_id";
                        $getApprove = mysqli_query($conn, $query);
                        header("Location: post_comments.php?id=" . $_GET['id'] . " ");
                    }
                    if (isset($_GET['unapprove'])) {
                        $comment_id = $_GET['unapprove'];
                        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $comment_id";
                        $getUnapprove = mysqli_query($conn, $query);
                        header("Location: post_comments.php?id=" . $_GET['id'] . " ");
                    }
                    if (isset($_GET['delete'])) {
                        $comment_id = $_GET['delete'];
                        $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
                        $getDeleted = mysqli_query($conn, $query);
                        header("Location: post_comments.php?id=" . $_GET['id'] . " ");
                    } ?>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php include("includes/footer.php"); ?>