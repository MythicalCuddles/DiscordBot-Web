<html>
    <head>
		<?php
            require('htmlhead.php');
			echo '<title>' . $config['global']['PAGE_TITLE_BOT_NAME'] . ' - Ban List</title>';

			if (!isset($_GET['page'])) {
				header('Location: bans.php?page=1');
				die('Error: Bad Page Number.');
			}

        	$query = "SELECT * FROM `bans` ORDER BY banID;";
        	$result = mysqli_query($dbcon, $query) or die('error gathering data.');

        	$num_rows = mysqli_num_rows($result);
        	$num_pages = ceil($num_rows/$config['bans']['BAN_RESULTS_PER_PAGE']);

        	$page = $_GET['page'];
        	$this_page_first_result = ($page-1)*$config['bans']['BAN_RESULTS_PER_PAGE'];

        	$query = 'SELECT * FROM `bans` ORDER BY banID DESC LIMIT ' . $this_page_first_result . ',' .  $config['bans']['BAN_RESULTS_PER_PAGE'];
        	$result = mysqli_query($dbcon, $query) or die('error gathering data.');
		?>
    </head>

    <body style="background-color:#f1f3f4;">
        <?php require('header.php'); ?>
        <div class="container" align="center">
            <div class="card mb-3"  style="width:90%;">
                <table class="table table-hover" style="width:100%; margin-bottom: 0rem;">
                    <thead>
                        <tr>
                            <th scope="col" colspan="6" style="text-align: center;">Ban List</th>
                        </tr>
                        <tr>
                            <th scope="col" style="width: 20%">Banned User</th>
                            <th scope="col" style="width: 25%">Guild Name</th>
                            <th scope="col" style="width: 20%">Issued By</th>
                            <th scope="col" style="width: 25%">Reason</th>
                            <th scope="col" style="width: 10%">Date Issued</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($num_rows == 0) {
                            echo '<tr><td colspan="6" style="text-align:center; vertical-align:middle;">No Recorded Bans</td></tr>';
                        }
                        else
                        {
                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                echo "<tr>";

                                echo "<td style='vertical-align: middle;'>";

                                $userQuery = "SELECT * FROM `users` WHERE id=" . $row['issuedTo'] . ";";
                                $userResults = mysqli_query($dbcon, $userQuery) or die('error gathering data.');
                                $num_userRows = mysqli_num_rows($userResults);
                                if($num_userRows == 1) {
                                    while($userRow = mysqli_fetch_array($userResults, MYSQLI_ASSOC)) {
                                        echo "<a href=\"profile.php?id=" . $row['issuedTo'] . " \"><img src=\"" . $userRow['avatarUrl'] . "\" height=\"32\" width=\"32\" style=\"border-radius: 50%;\" /> " . "@" . $userRow['username'] . "</a>";
                                    }
                                }
                                else {
                                    echo $row['issuedTo'];
                                }

                                echo "</td><td style='vertical-align: middle;'>";

                                $guildQuery = "SELECT * FROM `guilds` WHERE guildID=" . $row['inGuild'] . ";";
                                $guildResults = mysqli_query($dbcon, $guildQuery) or die('error gathering data.');
                                $num_guildRows = mysqli_num_rows($guildResults);
                                if($num_guildRows == 1) {
                                    while($guildRow = mysqli_fetch_array($guildResults, MYSQLI_ASSOC)) {
                                        echo $guildRow['guildName'];
                                    }
                                }
                                else {
                                    echo $row['issuedTo'];
                                }

                                echo "</td><td style='vertical-align: middle;'>";

                                $userQuery = "SELECT * FROM `users` WHERE id=" . $row['issuedBy'] . ";";
                                $userResults = mysqli_query($dbcon, $userQuery) or die('error gathering data.');
                                $num_userRows = mysqli_num_rows($userResults);
                                if($num_userRows == 1) {
                                    while($userRow = mysqli_fetch_array($userResults, MYSQLI_ASSOC)) {
                                        echo "<a href=\"profile.php?id=" . $row['issuedBy'] . " \"><img src=\"" . $userRow['avatarUrl'] . "\" height=\"32\" width=\"32\" style=\"border-radius: 50%;\" /> " . "@" . $userRow['username'] . "</a>";
                                    }
                                }
                                else {
                                    echo $row['issuedBy'];
                                }


                                echo "</td><td style='vertical-align: middle;'>";
                                if($row['banDescription'] == null) {
                                    echo 'No reason provided.';
                                }
                                else {
                                    echo  $row['banDescription'];
                                }

                                echo "</td><td style='vertical-align: middle;'>";
                                echo  date('d/M/Y', strtotime($row['dateIssued']));
                                echo "</td></tr>";
                            }
                        }
                    ?>

                    </tbody>
                </table>
            </div>

            <div>
                <?php
                    $onPage = 1;
                    if (isset($_GET['page'])) {
                        $onPage = $_GET['page'];
                    }

                    if($onPage != 1 && $num_pages > 1) {
                        echo '<a href="bans.php?page=1"><button type="button" class="btn btn-light"><<</button></a>';
                        echo '<a href="bans.php?page=' . ($onPage - 1) . '"><button type="button" class="btn btn-light"><</button></a>';
                    }

                    $startOnPage = $onPage - $config['bans']['PAGES_PER_SIDE'];
                    $endOnPage = $onPage + $config['bans']['PAGES_PER_SIDE'];
                    if($startOnPage < 1) { $startOnPage = 1; }
                    if($endOnPage > $num_pages) { $endOnPage = $num_pages; }

                    if($num_pages > 1) { // Must be more than 1 page before displaying page numbers
                        for (($page = $startOnPage); ($page <= $endOnPage); $page++) { //for ($page=1; $page<=$num_pages; $page++)
                            if($page == $onPage) {
                                echo '<button type="button" class="btn btn-primary">' . $page . '</button>';
                            } else {
                                echo '<a href="bans.php?page=' . $page . '"><button type="button" class="btn btn-light">' . $page . '</button></a>';
                            }
                        }
                    }


                    if($onPage != $num_pages && $num_pages > 1) {
                        echo '<a href="bans.php?page=' . ($onPage + 1) . '"><button type="button" class="btn btn-light">></button></a>';
                        echo '<a href="bans.php?page=' . $num_pages . '"><button type="button" class="btn btn-light">>></button></a>';
                    }

                ?>
            </div>
        </div>

        <?php require('footer.php'); ?>
    </body>
</html>
