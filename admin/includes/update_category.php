<form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Edit Category</label>

                                <?php
                                if (isset($_GET['edit'])) {
                                    $cat_id = $_GET['edit'];
                                    $query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
                                    $getCategories = mysqli_query($conn, $query);

                                    while ($category = mysqli_fetch_assoc($getCategories)) {
                                        $cat_id = $category["cat_id"];
                                        $cat_title = $category["cat_title"];
                                ?>
                                        <input value="<?php if (isset($cat_title)) {
                                                            echo $cat_title;
                                                        } ?>" type="text" class="form-group" name="cat_title">
                                <?php }
                                }
                                ?>

                                <?php

                                if (isset($_POST['update'])) {
                                    $cat_title = $_POST['cat_title'];
                                    $query = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$cat_id}";
                                    $update_request = mysqli_query($conn, $query);
                                    if (!$update_request) {
                                        die('QUERY FILED' . mysqli_error($conn));
                                    }
                                }

                                ?>

                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update" value="Update Category">
                            </div>

                        </form>