<html>
    <head>
        <?php
            require('htmlhead.php');
            echo '<title>' . $config['global']['PAGE_TITLE_BOT_NAME'] . ' - Leaderboard</title>';

            $query = "SELECT teamMember,id,username,avatarUrl,level,exp FROM Users ORDER BY exp DESC;";
            $result = mysqli_query($dbcon, $query) or die('error gathering data.');
            //$num_rows = mysqli_num_rows($result);

        ?>
    </head>

    <body style="background-color:#f1f3f4;">
        <?php require('header.php'); ?>
        <div class="container" align="center">
            <?php require('error.php'); ?>

            <?php
                if(isset($_GET['login'])) {
                    if($_GET['login'] == "success") {
                        echo '<div class="alert alert-success">Logged in successfully. Welcome back, ' . getUsernameFromSession() . '!</div>';
                    }
                    else {
                        echo '<div class="alert alert-warning">How did you get that?</div>';
                    }
                }
                if(isset($_GET['logout'])) {
                    if($_GET['logout'] == "success") {
                        echo '<div class="alert alert-success">Logged out successfully. See you soon!</div>';
                    }
                    else {
                        echo '<div class="alert alert-warning">How did you get that?</div>';
                    }
                }
            ?>

            <div class="card mb-3"  style="width:90%;">
                <table class="table table-hover" style="width:100%; margin-bottom: 0rem;">
                    <thead>
                        <tr>
                            <th scope="col" colspan="6" style="text-align: center;">Leaderboard - Top <?php echo $config['leaderboard']['LEADERBOARD_LIMIT']; ?></th>
                        </tr>
                        <tr>
                            <th scope="col" style="width: 10%; text-align: center;">Rank</th>
                            <th scope="col" style="width: 3%;">Team</th>
                            <th scope="col" style="width: 45%">Username</th>
                            <th scope="col" style="width: 21%">Level</th>
                            <th scope="col" style="width: 21%">EXP</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $ranking = 1;

                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        if($ranking <= $config['leaderboard']['LEADERBOARD_LIMIT']) {
                            //if (@getimagesize($row['avatarUrl'])) {
                            echo "<tr><td style='text-align: center; vertical-align: middle;'>";
                            echo $ranking;
                            echo "</td>";

                            echo "<td style='text-align: center; vertical-align: middle;'>";
                            if($row['teamMember'] == 'Y' || $row['teamMember'] == 'y') {
                                echo "<img src=\"images/star.png\" height=\"20\" width=\"20\" />";
                            }
                            echo "</td>";

                            echo "<td style='vertical-align: middle;'><a class=\"p-2 text-dark\" href=\"profile.php?id=" . $row['id'] . " \">";
                            echo  "<img src=\"" . $row['avatarUrl'] . "\" height=\"32\" width=\"32\" style=\"border-radius: 50%;\" /> " . $row['username'];
                            echo "</a></td><td style='vertical-align: middle;'>";
                            echo $row['level'];
                            echo "</td><td style='vertical-align: middle;'>";
                            echo $row['exp'];
                            echo "</td></tr>";


                            $ranking++;
                            //}
                        }
                    }
                    ?>

                    </tbody>
                </table>
            </div>


            <?php require('footer.php'); ?>

        </div>
    </body>
</html>
