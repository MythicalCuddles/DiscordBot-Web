<html>
    <head>
        <?php
            require('htmlhead.php');
            echo '<title>' . $config['global']['PAGE_TITLE_BOT_NAME'] . ' - Admin Panel</title>';

            if(!isSessionUserTeamMember($dbcon)) {
                header('Location: index.php?error=nopermission');
                exit();
            }
            // todo: stmt change & pagination
            $query = "SELECT id,username,avatarUrl FROM Users ORDER BY id asc;";
            $result = mysqli_query($dbcon, $query) or die('error gathering data.');
        ?>
    </head>

    <body style="background-color:#f1f3f4;">
        <?php require('header.php'); ?>
        <div class="container" align="center">
            <?php
            if(isset($_GET['error'])) {
    			$errorId = $_GET['error'];

    			if($errorId == "invalidid" || $errorId == "invaliduser") {
    				echo '<div class="alert alert-warning">
    							Unable to find profile with specified ID. Please try again.
    						</div>';
    			}
            }
            ?>
            <div class="card mb-3"  style="width:90%;">
                <table class="table table-hover table-sm" style="width:100%; margin-bottom: 0rem;">
                    <thead>
                        <tr>
                            <th scope="col" colspan="3" style="text-align: center;">Edit Users</th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="3"><input type="text" style="background-color:white;" class="form-control" placeholder="Username Search" name="search_text" id="search_text"></th>
                        </tr>
                    </thead>
                    <tbody id="result"></tbody>
                </table>
            </div>
        </div>
        <?php require('footer.php'); ?>
    </body>
</html>

<script>
    $(document).ready(function() {
        $('#search_text').keyup(function() {
            var txt = $(this).val();
            if(txt != '') {
                $.ajax({
                    url: "src/admin/editusersearch.php",
                    method: "POST",
                    data: {search:txt},
                    dataType: "text",
                    success:function(data) {
                        $('#result').html(data);
                    }
                });
            }
            else {
                $('#result').html('');
            }
        })
    })
</script>
