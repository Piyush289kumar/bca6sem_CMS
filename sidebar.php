<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->

    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
        <div class="recent-post">
            <?php
            include("config.php");
            $recent_post_limit_show = 5;
            
            $sql_recent_post = "SELECT *  FROM post
            LEFT JOIN category ON post.category = category.category_id
            ORDER BY post.post_id DESC LIMIT 0,{$recent_post_limit_show}";
            
            $result_sql_recent_post = mysqli_query($conn, $sql_recent_post) or die("Query Die !! --> sql_recent_post");
            if (mysqli_num_rows($result_sql_recent_post) > 0) {

                while ($row = mysqli_fetch_assoc($result_sql_recent_post)) {
            ?>


            <div class="recent-post">
                <a class="post-img" href="single.php?post_id=<?php echo ($row['post_id']) ?>">
                    <img src="admin/upload/<?php echo $row['post_img'] ?>" alt="Image not found !!" />
                </a>
                <div class="post-content">
                    <h5><a href="single.php?post_id=<?php echo ($row['post_id']) ?>"><?php echo $row['title'] ?></a>
                    </h5>
                    <span>
                        <i class="fa fa-tags" aria-hidden="true"></i>
                        <a href='category.php?cate_id=<?php echo ($row['category']) ?>'><?php echo $row['category_name'] ?></a>
                    </span>
                    <span>
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <?php echo $row['post_date'] ?>
                    </span>
                    <a class="read-more" href="single.php?post_id=<?php echo ($row['post_id']) ?>">read more</a>
                </div>
            </div>



            <?php
                }
            } else {
                echo ("<div class='alert alert-danger'>No Record</div>");
            }
            ?>

        </div>


        <!-- /recent posts box -->
    </div>