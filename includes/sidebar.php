<?php
if (ifItIsMethod('post')) {
    if (isset($_POST['login'])) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            loginUser($_POST['username'], $_POST['password']);
        } else {
            redirect('index.php');
        }
    }
}
?>

<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>

        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>


    <!-- Login Form -->
    <div class="well">
        <?php if (isset($_SESSION['role'])) : ?>
            <h4>Logged in as: <?php echo $_SESSION['username']; ?></h4>
            <a href="admin/includes/logout.php" class="btn btn-primary">Logout</a>
        <?php else : ?>
            <h4>Login</h4>
            <form method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Login</button>
                    </span>
                </div>

                <div class="form-group">
                    <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password</a>
                </div>
            </form>
            <!-- /.input-group -->
        <?php endif; ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    $query = "SELECT * from categories";
                    $getCategories = mysqli_query($conn, $query);
                    while ($category = mysqli_fetch_assoc($getCategories)) {
                        $cat_id = $category["cat_id"];
                        $cat_title = $category["cat_title"];
                        echo "<li><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include("widget.php") ?>

</div>