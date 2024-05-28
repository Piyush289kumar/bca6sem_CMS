<?php
include("config.php");
$post_id_by_addbar = $_GET['post_id'];
$cate_id_by_addbar = $_GET['cate_id'];

$sql_select_post_img = "SELECT * FROM post WHERE post_id = {$post_id_by_addbar}";
$result_sql_select_post_img = mysqli_query($conn, $sql_select_post_img) or die("Query Die !! --> sql_select_post_img");
if (mysqli_num_rows($result_sql_select_post_img)>0) {
    $row = mysqli_fetch_assoc($result_sql_select_post_img);
    unlink("upload/" . $row['post_img']);
}

$sql_delete_post = "DELETE FROM post WHERE post_id = {$post_id_by_addbar};";
$sql_delete_post .= "UPDATE category SET post = post - 1 WHERE category_id = {$cate_id_by_addbar}";
if (mysqli_multi_query($conn,$sql_delete_post)) {
    header("Location:{$hostname}/admin/post.php");
} else {
    echo ("<div class='alert alert-danger'>Can't Delete Post!!</div>");
}
mysqli_close($conn);

?>