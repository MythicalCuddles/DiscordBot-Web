<html>
    <head>
		<?php
            require('htmlhead.php');
			echo '<title>' . $config['global']['PAGE_TITLE_BOT_NAME'] .  ' - Dashboard</title>';

            if(!isUserLoggedIn()) {
                header('Location: index.php?error=loginrequired');
                exit();
            }

            
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#aboutTextarea").emojioneArea({
                    filtersPosition: "bottom"
                });
            });
        </script>
    </head>

    <body style="background-color:#f1f3f4;">
        <?php require('header.php'); ?>

  		<div class="container">

            <?php

                $query = "SELECT name,gender,pronouns,about,
                                pokemonGoFriendCode,minecraftUsername,snapchatUsername,instagramUsername,githubUsername,
                                websiteUrl,websiteName
                            FROM users WHERE id=?";
                $stmt = mysqli_stmt_init($dbcon);
                $stmt->prepare($query);
                $uid = getIdFromSession();
                $stmt->bind_param("s", $uid);
                $stmt->bind_result($uName, $uGender, $uPronouns, $uAbout, $uPokemonGo, $uMinecraft, $uSnapchat, $uInstagram, $uGitHub, $uWebsiteURL, $uWebsiteName);
                $stmt->execute();
                $stmt->store_result();

                while($stmt->fetch()) {
            ?>


            <div style="background-color:#ffffff; padding:25px; border-radius:2%;">
                <h2 style="text-align:center;">Account<sup><sup>beta</sup></sup></h2>
                <h3>Edit Profile</h3>
                <?php
                    if(isset($_GET['status'])) {
                        $status = $_GET['status'];

                        if($status = "profileUpdated") {
                            echo '<div class="card border-success mb-3">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">Profile Updated!</h5>';
                            echo '<p class="card-text">You\'ve successfully updated your profile! You can <a href="profile.php?id=' . getIdFromSession() . '">view your changes here</a>.</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    else {
                        echo '<div class="card border-success mb-3">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Edit Profile Feature</h5>';
                        echo '<p class="card-text">This feature is still in beta and may have some issues as we continue to work on it. Thank you for your patience.</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>

                <form class="form-group" action="src/updateprofile.inc.php" method="post">
                    <div class="form-label-group">
                        <label for="uName">Name</label>
                        <input type="text" class="form-control" name="uName" id="uName" placeholder="Your Name" value="<?php echo $uName; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">Gender</label>
                        <input type="text" class="form-control" name="uGender" id="uGender" placeholder="Gender" value="<?php echo $uGender; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">Pronouns</label>
                        <input type="text" class="form-control" name="uPronouns" id="uPronouns" placeholder="Pronouns" value="<?php echo $uPronouns; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uAbout">About</label>
                        <textarea id="aboutTextarea" type="text" rows="7" name="uAbout" id="uAbout" class="form-control" style="width:100%;"><?php echo $uAbout; ?></textarea>
                        <small class="float-right"><a href="<?php echo $config['links']['DISCORD_FORMATTING_GUIDE']; ?>" target="_blank">Learn more about Discord Formatting</a> |
                            Emojis by <a href="https://github.com/mervick/emojionearea" target="_blank">emojionearea</a></small>
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">Pokémon Go Friend Code</label>
                        <input type="text" class="form-control" name="uPokemonGo" id="uPokemonGo" placeholder="Pokémon Go Friend Code" value="<?php echo $uPokemonGo; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">Minecraft Username</label>
                        <input type="text" class="form-control" name="uMinecraft" id="uMinecraft" placeholder="Minecraft Username" value="<?php echo $uMinecraft; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">Snapchat Username</label>
                        <input type="text" class="form-control" name="uSnapchat" id="uSnapchat" placeholder="Snapchat Username" value="<?php echo $uSnapchat; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">Instagram Username</label>
                        <input type="text" class="form-control" name="uInstagram" id="uInstagram" placeholder="Instagram Username" value="<?php echo $uInstagram; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">GitHub Username</label>
                        <input type="text" class="form-control" name="uGitHub" id="uGitHub" placeholder="GitHub Username" value="<?php echo $uGitHub; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">Website Name</label>
                        <input type="text" class="form-control" name="uWebName" id="uWebName" placeholder="Website Name" value="<?php echo $uWebsiteName; ?>">
                    </div>
                    <br />

                    <div class="form-label-group">
                        <label for="uName">Website URL</label>
                        <input type="text" class="form-control" name="uWebURL" id="uWebURL" placeholder="Website URL" value="<?php echo $uWebsiteURL; ?>">
                    </div>
                    <br />

                    <div class="text-right">
                        <button type="submit" class="btn btn-group-right btn-primary" name="updateProfile" >Update Profile</button>
                    </div>
                </form>
            </div>

            <?php
                }
                $stmt->close();
                require('footer.php');
            ?>
  		</div>
    </body>
</html>
