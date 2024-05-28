<?php
include("config.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location:{$hostname}/admin/");
}


$current_page = basename($_SERVER['PHP_SELF']);
$prefix_word = "ADMIN Panel";
switch ($current_page) {
    case 'add-category.php':
        $page_title = "{$prefix_word} - Category Add";
        break;
    case 'add-post.php':
        $page_title = "{$prefix_word} - Post Add";
        break;
    case 'add-user.php':
        $page_title = "{$prefix_word} - User Add";
        break;
    case 'category.php':
        $page_title = "{$prefix_word} - Category";
        break;
    case 'post.php':
        $page_title = "{$prefix_word} - Post";
        break;
    case 'settings.php':
        $page_title = "{$prefix_word} - Settings";
        break;
    case 'update-category.php':
        $page_title = "{$prefix_word} - Category Update";
        break;
    case 'update-post.php':
        $page_title = "{$prefix_word} - Post Update";
        break;
    case 'update-user.php':
        $page_title = "{$prefix_word} - User Update";
        break;
    case 'users.php':
        $page_title = "{$prefix_word} - Users";
        break;
    default:
        $page_title = $website_display_default_name;
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="shortcut icon" type="x-con" href="http://CMSacstproject.infinityfreeapp.com/admin/icon/graduation-cap.png">
    <title><?php echo ($page_title); ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="../css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- HEADER -->
    <div id="header-admin">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-2">

                    <?php
                    include("config.php");
                    $sql_setting_record = "SELECT * FROM settings";
                    $result_sql_setting_record = mysqli_query($conn, $sql_setting_record) or die("Query Die !! --> sql_setting_record");
                    if (mysqli_num_rows($result_sql_setting_record) > 0) {
                        while ($row_setting_record = mysqli_fetch_assoc($result_sql_setting_record)) {
                            if ($row_setting_record['logo'] == "") {
                                echo '<a href="index.php"><h1>' . $row_setting_record['websitename'] . '</h1></a>';
                            } else {
                                echo ('<a href="index.php" id="logo"><img src="images/' . $row_setting_record['logo'] . '"></a>');
                            }
                        }
                    }
                    ?>
                </div>
                <!-- /LOGO -->
                <!-- LOGO-Out -->
                <div class="col-md-offset-7  col-md-3">
                    <a href="logout.php" class="admin-logout">Hello <?php echo $_SESSION['username']; ?>, LOGOUT</a>
                </div>
                <!-- /LOGO-Out -->
            </div>
        </div>
    </div>
    <!-- /HEADER -->
    <!-- Menu Bar -->
    <div id="admin-menubar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="admin-menu">
                        <li>
                            <a href="post.php">Post</a>
                        </li>
                        <?php
                            if ($_SESSION['user_role'] == 1) {
                            ?>
                        <li>
                            <a href="category.php">Category</a>
                        </li>
                        <li>
                            <a href="users.php">Users</a>
                        </li>
                        <li>
                            <a href="settings.php">Settings</a>
                        </li>

                        <?php
                            }
                            ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Menu Bar -->