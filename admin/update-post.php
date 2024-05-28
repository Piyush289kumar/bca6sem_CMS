<?php include "header.php";
include("config.php");

// Secure Code
if ($_SESSION['user_role'] == 0) {
    $post_id_by_addbar = $_GET['post_id'];
    $sql_get_author_for_secrue_code = "SELECT author FROM post
                           WHERE  post_id = {$post_id_by_addbar}";
$result_sql_get_author_for_secrue_code = mysqli_query($conn, $sql_get_author_for_secrue_code) or die("Query Failed !! --> sql_show_post_data");
    $row_result_sql_get_author_for_secrue_code = mysqli_fetch_assoc($result_sql_get_author_for_secrue_code);
    if ($_SESSION['user_id'] != $row_result_sql_get_author_for_secrue_code['author']) {
        header("Location:{$hostname}/admin/");
    }
}


$post_id_by_addbar = $_GET['post_id'];


// UPDATION CODE

if (isset($_POST['submit'])) {



    if (empty($_FILES['new-image']['name'])) {
        $save_img_name =   $_POST['old-image'];
        
    } else {
        if (isset($_FILES['new-image'])) {
            $file_name = $_FILES['new-image']["name"];
            $file_tmp = $_FILES['new-image']["tmp_name"];
            $file_type = $_FILES['new-image']["type"];
            $file_size = $_FILES['new-image']["size"];
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
    }
    
    $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $post_decs = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $post_cate = mysqli_real_escape_string($conn, $_POST['category']);
    $old_category = $_POST['old_category'];
    $new_category = $_POST['category'];

    $sql_update_post = "UPDATE post SET title = '{$post_title}', description = '{$post_decs}', category = '{$post_cate}', post_img = '{$save_img_name}' WHERE post_id = '{$post_id_by_addbar}';";

    if ($_POST['old_category'] !=  $_POST['category']) {
    $sql_update_post .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
        $sql_update_post .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']};";
    
    }

    $result_sql_update_post = mysqli_multi_query($conn, $sql_update_post);
    if ($result_sql_update_post) {
        header("Location:{$hostname}/admin/post.php");
    } else {
        echo "<div class='alert alert-danger'>Post is Not Update !!</div>";
    }

}
 ?>
 
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Update Post</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form for show edit-->
                <?php
                
                
                $sql_show_post_data = "SELECT post.post_id, post.category, post.title, post.description, post.post_date, post.post_img,
                                category.category_name, category.category_id FROM post
                                LEFT JOIN category ON post.category = category.category_id
                                LEFT JOIN user ON post.author = user.user_id
                                WHERE  post.post_id = {$post_id_by_addbar}";
                $result_sql_show_post_data = mysqli_query($conn, $sql_show_post_data) or die("Query Failed !! --> sql_show_post_data");
                if (mysqli_num_rows($result_sql_show_post_data) > 0) {
                    while ($row = mysqli_fetch_assoc($result_sql_show_post_data)) {

                ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <input type="hidden" name="post_id" class="form-control" value="<?php echo ($row['post_id']) ?>"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputTile">Title</label>
                        <input type="text" name="post_title" class="form-control" id="exampleInputUsername"
                            value="<?php echo ($row['title'])?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"> Description</label>
                        <textarea name="postdesc" class="form-control" required
                            rows="5"><?php echo ($row['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputCategory">Category</label>
                        <select name="category" class="form-control">
                            <option disabled > Select Category</option>
                            <?php
                            $sql_category_list = "SELECT * from category";
                            $result_sql_category_list = mysqli_query($conn, $sql_category_list) or die("Query Die!! --> sql_category_list");
                            if (mysqli_num_rows($result_sql_category_list) > 0) {
                                while ($row_cate = mysqli_fetch_assoc($result_sql_category_list)) {

                                    if ($row_cate['category_id'] == $row['category']) {
                                        $select_cate = "selected";
                                } else {
                                    $select_cate = "";
                                }
                            echo("<option {$select_cate} value='{$row_cate['category_id']}'>{$row_cate['category_name']}</option>");
                            
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" value="<?php echo $row['category'];?>" name="old_category">
                    </div>
                    <div class="form-group">
                        <label for="">Post image</label>
                        <input type="file" name="new-image">

                        <img src="upload/<?php echo $row['post_img']; ?>" height="150px">

                        <input type="hidden" name="old-image" value="<?php echo $row['post_img']; ?>"> 
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                </form>
                <!-- Form End -->
                <?php
                        }
                    } else {
                        echo ("<div class='alert alert-danger'>Result Not Found.</div>");
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
