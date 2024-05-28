<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="shortcut icon" type="x-con" href="http://localhost/CMS/admin/icon/graduation-cap.png">
    <title><?php echo ($page_title) ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include ("config.php");
    $current_page = basename($_SERVER['PHP_SELF']);

    switch ($current_page) {
        case 'author.php':
            if (isset($_GET['aid'])) {
                $sql_author_post = "SELECT * FROM post JOIN user ON post.author = user.user_id WHERE user.user_id = {$_GET['aid']}";
                $result_sql_author_post = mysqli_query($conn, $sql_author_post) or die("Query Die --> sql_author_post");
                $row_user = mysqli_fetch_assoc($result_sql_author_post);
                $page_title = "News By " . $row_user['first_name'] . $row_user['last_name'];
            } else {
                $page_title = "User not found!!";
            }

            break;
        case 'category.php':
            if (isset($_GET['cate_id'])) {
                $sql_author_post = "SELECT * FROM post JOIN category ON post.category = category.category_id WHERE post.category = {$_GET['cate_id']}";
                $result_sql_author_post = mysqli_query($conn, $sql_author_post) or die("Query Die --> sql_author_post");
                $row_user = mysqli_fetch_assoc($result_sql_author_post);
                $page_title = $row_user['category_name'] . " News";
            } else {
                $page_title = "Category not found!!";
            }
            break;
        case 'single.php':
            if (isset($_GET['post_id'])) {
                $sql_single_title = "SELECT * FROM post  WHERE post_id = {$_GET['post_id']}";
                $result_sql_single_title = mysqli_query($conn, $sql_single_title) or die("Query Die --> sql_single_title");
                $row_single = mysqli_fetch_assoc($result_sql_single_title);
                $page_title = $row_single['title'] . " News";
            } else {
                $page_title = "Post not found!!";
            }
            break;
        case 'search.php':
            if (isset($_GET['search'])) {
                $page_title = $_GET['search'];
            } else {
                $page_title = "Search result not found!!";
            }
            break;
        default:

            $page_title = $website_display_default_name;

            break;
    }
    ?>



    <!-- HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class=" col-md-offset-4 col-md-4">
                    <?php
                    include ("config.php");
                    $sql_setting_record = "SELECT * FROM settings";
                    $result_sql_setting_record = mysqli_query($conn, $sql_setting_record) or die("Query Die !! --> sql_setting_record");
                    if (mysqli_num_rows($result_sql_setting_record) > 0) {
                        while ($row_setting_record = mysqli_fetch_assoc($result_sql_setting_record)) {
                            if ($row_setting_record['logo'] == "") {
                                echo '<a href="index.php"><h1>' . $row_setting_record['websitename'] . '</h1></a>';
                            } else {
                                echo ('<a href="index.php" id="logo"><img src="admin/images/' . $row_setting_record['logo'] . '"></a>');
                            }
                        }
                    }
                    ?>
                </div>
                <!-- /LOGO -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="menu-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <?php
                    include ("config.php");
                    if (isset($_GET['cate_id'])) {
                        $cate_id_by_addbar = $_GET['cate_id'];
                    }
                    $sql_show_category_list = "SELECT * FROM category WHERE post > 0 ORDER BY category_id";
                    $result_sql_show_category_list = mysqli_query($conn, $sql_show_category_list) or die("Query Die --> sql_show_category_list");
                    if (mysqli_num_rows($result_sql_show_category_list) > 0) {
                        $active = "";
                        echo ("<ul class='menu'>");
                        echo ("<li><a href='{$hostname}'>Home</a></li>");
                        while ($row = mysqli_fetch_assoc($result_sql_show_category_list)) {
                            if (isset($_GET['cate_id'])) {
                                $cate_id_by_addbar = $_GET['cate_id'];
                                if ($row['category_id'] == $cate_id_by_addbar) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                            }
                            echo ("<li><a class = '{$active}' href='category.php?cate_id={$row['category_id']}'>{$row['category_name']}</a></li>");
                        }

                        ?>
                        <li class='bg-primary'><a href='<?php echo $hostname ?>/admin'>ADMIN CENTER</a></li>
                        <?php
                        echo ("</ul>");
                    }
                    // list-group-item-danger
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->