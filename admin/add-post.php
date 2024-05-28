<?php include("header.php");
include("config.php");
if (isset($_POST['submit'])) {

    session_start();


    if (isset($_FILES['fileToUpload'])) {
        $file_name = $_FILES['fileToUpload']["name"];
        $file_tmp = $_FILES['fileToUpload']["tmp_name"];
        $file_type = $_FILES['fileToUpload']["type"];
        $file_size = $_FILES['fileToUpload']["size"];
        $file_ext = strtolower(end(explode('.', $file_name)));
        $allow_extension = array("jpg", "jpeg", "png");
        $file_error = array();

        if (in_array($file_ext, $allow_extension) === false) {
            $file_error[] = "This extension file not allowed, Please choose a JPG or PNG file.";
        }
        if ($file_size > 2097152) {
            $file_error[] = "Image must be 2mb or lower.";
        }
        $save_img_name =  date("d_M_Y_h_i_sa")."_". basename($file_name);
        $img_save_target = "upload/";
        if (empty($file_error) == true) {
            move_uploaded_file($file_tmp, $img_save_target . $save_img_name);
        } else {
            print_r($file_error);
            die();
        }

    }


    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $post_decs = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $post_cate = mysqli_real_escape_string($conn, $_POST['category']);
    $post_date = date("d M, Y");
    $post_author = $_SESSION['user_id'];


    $sql_insert_post = "INSERT INTO post (title,description,category,post_date,author,post_img)
                        VALUES ('{$post_title}','{$post_decs}','{$post_cate}','{$post_date}','{$post_author}','{$save_img_name}');";
    $sql_insert_post .= "UPDATE category SET post = post + 1 WHERE category_id = '{$post_cate}'";

    if (mysqli_multi_query($conn, $sql_insert_post)) {
        header("Location:{$hostname}/admin/post.php");
    } else {
        echo "<div class='alert alert-danger'>Post Not Submit</div>";
    }

}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form -->
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Description</label>
                        <textarea name="postdesc" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Category</label>
                        <select name="category" class="form-control">
                            <option disabled selected> Select Category</option>

                            <?php
                            include("config.php");
                            $sql_category_list = "SELECT * from category" or die("Query Die!! --> sql_category_list");
                            $result_sql_category_list = mysqli_query($conn, $sql_category_list);

                            if (mysqli_num_rows($result_sql_category_list) > 0) {
                                while ($row = mysqli_fetch_assoc($result_sql_category_list)) {
                            ?>
                            <option value="<?php echo ($row['category_id']) ?>"><?php echo ($row['category_name']) ?>
                            </option>

                            <?php
                                }
                            }
                            ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Post image</label>
                        <input type="file" name="fileToUpload" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>
                <!--/Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>