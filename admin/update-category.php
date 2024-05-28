<?php include "header.php";
include("config.php");
$category_index_by_addbar = $_GET['category_index'];
    if (isset($_POST['sumbit'])) {
    $category_name = mysqli_escape_string($conn,$_POST['cat_name']);
        $sql_update_category = "UPDATE category SET category_name = '{$category_name}' WHERE category_id=  {$category_index_by_addbar}";
    if (mysqli_query($conn, $sql_update_category)) {
        
            header("Location:{$hostname}/admin/category.php");
     
    }
    }
 ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <?php
                include("config.php");
                
                
                                      
                $sql_show_category = "SELECT * FROM category WHERE category_id = {$category_index_by_addbar}";
                $result_sql_show_category = mysqli_query($conn, $sql_show_category) or die("Query Die!! --> sql_show_category");
                if (mysqli_num_rows($result_sql_show_category)>0) {
                    while ($row = mysqli_fetch_assoc($result_sql_show_category)) {
                // 
              
                ?>
                  <form action="<?php $_SERVER['PHP_SELF']?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id'] ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo($row['category_name']) ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="sumbit" class="btn btn-primary" value="Update" required />
                  </form>

                  <?php  }
                }?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
