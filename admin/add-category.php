<?php include "header.php"; 
if ($_SESSION['user_role'] == 0) {
    header("Location:{$hostname}/admin/");
}?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add New Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <?php
                  if (isset($_POST['save'])) {

                      include("config.php");
                      $category_name = mysqli_real_escape_string($conn,$_POST['cat']);

                                             
                      $sql_category_cheack = "SELECT category_name FROM category WHERE category_name = '{$category_name}'";

                      $result_sql_category_cheack = mysqli_query($conn, $sql_category_cheack) or die("Query Failed!! --> sql_category_cheack");
                      if (mysqli_num_rows($result_sql_category_cheack) > 0) {
                          echo ("<p style='color:red; font-size:25px; margin:10px 0px;'>Category Already Exits...</p>");
                      } else {

                          $sql_insert_category = "INSERT INTO category (category_name) VALUES ('{$category_name}')";

                          if (mysqli_query($conn, $sql_insert_category)) {
                              header("Location:{$hostname}/admin/category.php");
                          }
                      }


                  }
                  ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                    </div>
                    <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                </form>
                <!-- /Form End -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>