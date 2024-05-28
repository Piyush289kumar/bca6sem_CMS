<!-- Footer -->
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                                <?php
            include("config.php");
            $sql_setting_record = "SELECT * FROM settings";
            $result_sql_setting_record = mysqli_query($conn, $sql_setting_record) or die("Query Die !! --> sql_setting_record");
            if (mysqli_num_rows($result_sql_setting_record) > 0) {
                while ($row_setting_record = mysqli_fetch_assoc($result_sql_setting_record)) {
                    if ($row_setting_record['footerdesc'] == "") {
                        echo '<span>Footer Not Found!!</span>';
                    } else {
                        echo '<span>' . $row_setting_record['footerdesc'] . '</span>';
                    }
                }
            }
            ?>
            </div>
        </div>
    </div>
</div>
<!-- /Footer -->
</body>

</html>