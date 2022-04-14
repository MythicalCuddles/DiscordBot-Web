<html>
    <head>
        <?php
            require('htmlhead.php');
            echo '<title>' . $config['global']['PAGE_TITLE_BOT_NAME'] . ' - Award Manager</title>';

            if(!isSessionUserTeamMember($dbcon)) {
                header('Location: index.php?error=nopermission');
                exit();
            }

            if(!isset($_GET['id'])) {
                header('Location: admincp.php?error=invalidid');
                exit();
            }

            require('src/admin/DBQ.inc.php');
            if(!isIdValidUser($dbcon, $_GET['id'])) {
                header('Location: admincp.php?error=invaliduser');
                exit();
            }
        ?>
    </head>

    <body style="background-color:#f1f3f4;">
        <?php require('header.php'); ?>
        <div class="container">
            <div style="background-color:#ffffff; padding:25px; border-radius:2%;">

                <h2 style="text-align:center;">Award Manager</h2>
                <p style="text-align:center;">Managing for </p>
                <h3>Add Award</h3>

                <br />
                <?php
                    // Awards
                    $awardQuery = "SELECT awardId,awardText,awardType,dateAwarded FROM awards WHERE userId=? ORDER BY dateAwarded DESC;";
                    $awardstmt = mysqli_stmt_init($dbcon);
                    mysqli_stmt_prepare($awardstmt, $awardQuery);
                    mysqli_stmt_bind_param($awardstmt, "s", $_GET['id']);
                    mysqli_stmt_execute($awardstmt);
                    mysqli_stmt_bind_result($awardstmt, $awardId, $awardText, $awardType, $dateAwarded);
                    mysqli_stmt_store_result($awardstmt);

                    if(mysqli_stmt_num_rows($awardstmt) != 0) {
                        $isThereMiddleContent = true;

                        echo '
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><strong><center>Awards Achieved</center></strong></h5>
                            </div>
                            <div class="card-body h-100">
                                <table class="table table-hover table-sm" style="margin-bottom: 0rem;">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Award</th>
                                            <th scope="col">Date Awarded</th>
                                            <th scope="col" class="text-right">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        ';

                        while(mysqli_stmt_fetch($awardstmt)) {
                            echo '
                            <tr>
                              <th scope="row"><i class="fas fa-award"></i></th>
                              <td>' . $awardType . '</td>
                              <td>' . $awardText . '</td>
                              <td>' . $dateAwarded . '</td>
                              <td class="text-right">
                                <a href="deleteaward?id=' . $awardId . '"><button type="button" class="btn btn-sm">Edit Award</button></a>
                                <a href="deleteaward?id=' . $awardId . '"><button type="button" class="btn btn-sm">Delete Award</button></a>
                              </td>
                            </tr>
                            ';
                        }

                        echo '
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-right">
                                            <td colspan="5"><small class="text-navy">Total Number of Awards: ' . $awardstmt->num_rows() . '</small></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <br />
                        ';
                    }
                    $awardstmt->close();
                ?>
            </div>
        </div>
        <?php require('footer.php'); ?>
    </body>
</html>
