<?php 
include("config.php");
$category_index_by_addbar = $_GET['category_index'];

$sql_category_delete = "DELETE FROM category WHERE category_id = {$category_index_by_addbar}" or die("Query Failed!! --> sql_category_delete");
if (mysqli_query($conn,$sql_category_delete)) {
    header("Location:{$hostname}/admin/category.php");
}
mysqli_close($conn);
?>