
<?php include "header.php";
include("config.php");

if ($_SESSION['user_role'] == 0) {
    header("Location:{$hostname}/admin/");
}

// UPDATION CODE

if (isset($_POST['Submit'])) {



    if (empty($_FILES['logo']['name'])) {
        $file_name = $_POST['old_logo'];
    } else {
        if (isset($_FILES['logo'])) {
            $file_name = $_FILES['logo']["name"];
            $file_tmp = $_FILES['logo']["tmp_name"];
            $file_type = $_FILES['logo']["type"];
            $file_size = $_FILES['logo']["size"];
            $file_ext = strtolower(end(explode('.', $file_name)));
            $allow_extension = array("jpg", "jpeg", "png");
            $file_error = array();
    
            if (in_array($file_ext, $allow_extension) === false) {
                $file_error[] = "This extension file not allowed, Please choose a JPG or PNG file.";
            }
            if ($file_size > 2097152) {
                $file_error[] = "Image must be 2mb or lower.";
            }
    
            if (empty($file_error) == true) {
                move_uploaded_file($file_tmp, "images/" . $file_name);
            } else {
                print_r($file_error);
                die();
            }
    
        }
    }
    
    $websitename = mysqli_real_escape_string($conn, $_POST['website_name']);
    $footer = mysqli_real_escape_string($conn, $_POST['footer_desc']);

    $sql_update_post = "UPDATE settings SET websitename = '{$websitename}', logo = '{$file_name}', footerdesc = '{$footer}'";

    if (mysqli_query($conn, $sql_update_post)) {
        header("Location:{$hostname}");
    } else {
        echo "<div class='alert alert-danger'>Settings is Not Update !!</div>";
    }

}
 ?>
 
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="admin-heading">
                    <h1>Website Settings</h1>
                </div>
                <div class="col-md-offset-3 col-md-6">
                    <?php
                    include("config.php");
                    $sql_settings_record = "SELECT * FROM settings";
                    $result_sql_settings_record = mysqli_query($conn, $sql_settings_record) or die("Query Failed !! --> sql_settings_record");
                    if (mysqli_num_rows($result_sql_settings_record) > 0) {
                        while ($row = mysqli_fetch_assoc($result_sql_settings_record)) {
                    ?>
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="website_name">Website Name</label>
                            <input type="text" name="website_name" value="<?php echo $row['websitename'] ?>"
                                class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="logo">Website Logo</label>
                            <input type="file" name="logo">
                            <img src="images/<?php echo $row['logo'] ?>" alt="Image not found!!" style="height:35px;">
                            <input type="hidden" name="old_logo">
                        </div>
                        <div class="form-group">
                            <label for="footer-desc">Footer Description</label>
                            <textarea name="footer_desc" class="form-control" rows="5"
                                required><?php echo $row['footerdesc'] ?></textarea>
                        </div>
                        <input type="submit" name="Submit" value="Save" class="btn btn-primary" required>
                        <?php }
                    } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>