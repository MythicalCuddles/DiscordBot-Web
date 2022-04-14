<html>
    <head>
        <?php
            require('htmlhead.php');
            echo '<title>' . $config['global']['PAGE_TITLE_BOT_NAME'] . ' - Edit User</title>';

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
        <div class="container" align="center">

            <div class="card border-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Administrator Edit Profile Feature</h5>
                    <p class="card-text">This feature is coming soon. Sorry about that!</p>
                </div>
            </div>

        </div>
        <?php require('footer.php'); ?>
    </body>
</html>
