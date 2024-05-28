<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    if (isset($_GET['cate_id'])) {
                        $cate_id_by_addbar = $_GET['cate_id'];
                    }
                    $sql_total_post_record = "SELECT * from category WHERE category_id = {$cate_id_by_addbar}" or die("Query Failed !! --> sql_total_post_record");
                    $result_sql_total_post_record = mysqli_query($conn, $sql_total_post_record);
                    $post_row_num = mysqli_fetch_assoc($result_sql_total_post_record);
                    ?>
                    <h2 class="page-heading"><b><?php echo $post_row_num['category_name']; ?></b></h2>
                    <?php
                        include("config.php");
                        if (isset($_GET['page_index'])) {
                            $page_index_by_addbar = $_GET['page_index'];
                        } else {
                            $page_index_by_addbar = 1;
                        }
                        $record_limi = 5;
                        $offset = ($page_index_by_addbar - 1) * $record_limi;
                        $sql_show_post_record = "SELECT *  FROM post
                        LEFT JOIN category ON post.category = category.category_id
                        LEFT JOIN user ON post.author = user.user_id
                        WHERE post.category = '{$cate_id_by_addbar}'
                        ORDER BY post.post_id DESC LIMIT {$offset},{$record_limi}" or die("Query Failed!! --> sql_show_post_record");
                        $result_sql_show_post_record = mysqli_query($conn, $sql_show_post_record);
                        if (mysqli_num_rows($result_sql_show_post_record) > 0) {
                            while ($row = mysqli_fetch_assoc($result_sql_show_post_record)) {
                        ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?post_id=<?php echo ($row['post_id']) ?>"><img
                                        src="admin/upload/<?php echo $row['post_img']; ?>" alt="Picture unlink" /></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?post_id=<?php echo ($row['post_id']) ?>'><?php echo $row['title']; ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href="category.php?cate_id=<?php echo ($row['category']) ?>"><?php echo $row['category_name']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']; ?>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo substr($row['description'], 0, 180) . '....'; ?>
                                    </p>
                                    <a class='read-more pull-right'
                                        href='single.php?post_id=<?php echo ($row['post_id']) ?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                        }
                        if (mysqli_num_rows($result_sql_total_post_record) > 0) {
                            $total_post_record = $post_row_num['post'];
                            $total_page = ceil($total_post_record / $record_limi);
                            echo ("<ul class='pagination admin-pagination'>");
                            if ($page_index_by_addbar > 1) {
                                echo ("<li><a href='$hostname/category.php?cate_id={$cate_id_by_addbar}&page_index=" . ($page_index_by_addbar - 1) . "'>Prev</a></li>");
                            }
                            for ($i = 1; $i <= $total_page; $i++) {

                                if ($page_index_by_addbar == $i) {
                                    $active_page = "active";
                                } else {
                                    $active_page = "";
                                }
                                echo ("<li class=$active_page><a href='$hostname/category.php?cate_id={$cate_id_by_addbar}&page_index=$i'>$i</a></li>");
                            }
                            if ($page_index_by_addbar < $total_page) {
                                echo ("<li><a href='$hostname/category.php?cate_id={$cate_id_by_addbar}&page_index=" . ($page_index_by_addbar + 1) . "'>Next</a></li>");
                            }
                            echo ("</ul>");
                        }
                        ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>