<body>
	<div class="d-flex flex-column flex-md-row align-items-center p-2 px-md-4 mb-3 bg-white border-bottom box-shadow">
		<h5 class="my-0 mr-md-auto font-weight-normal"><a href="index.php"><?php echo $config['global']['PAGE_TITLE_BOT_NAME'] ?></a></h5>
		<nav class="my-2 my-md-0 mr-md-3">
			<a class="p-2 text-dark" href="index.php">Leaderboard</a>
			<a class="p-2 text-dark" href="bans.php">Ban List</a>
			<a class="p-2 text-dark" href="search.php">Users</a>
			<?php
				if(isUserLoggedIn()) {
					echo '<div class="btn-group">';
						echo '<button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle"></i> Account</button>';
						echo '<div class="dropdown-menu dropdown-menu-right">';
							echo '<a class="dropdown-item" href="profile.php?id=' . getIdFromSession() . '"><i class="fas fa-id-card"></i> Your Profile</a>';
							echo '<a class="dropdown-item" href="account.php"><i class="fas fa-edit"></i> Edit Profile</a>';
							echo '<div class="dropdown-divider"></div>';
							echo '<a class="dropdown-item btn-danger" href="src/logout.inc.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>';
							if(isSessionUserTeamMember($dbcon)) {
								echo '<div class="dropdown-divider"></div>';
								echo '<a class="dropdown-item btn-info" href="admincp.php"><i class="fas fa-user-shield"></i> Admin Panel</a>';
							}
						echo '</div>';
					echo '</div>';
				} else {
					echo '<a class="btn btn-outline-secondary text-dark" href="src/discord-php-kiss/oauth.php"><i class="fab fa-discord"></i> Login</a>';
				}
			?>



		</nav>
	</div>
</body>
