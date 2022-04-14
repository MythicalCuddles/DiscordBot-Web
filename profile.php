<!DOCTYPE HTML>
<html>
	<head>
		<?php
            require('htmlhead.php');
			require('src/Parsedown/Parsedown.php');
			echo '<title>' . $config['global']['PAGE_TITLE_BOT_NAME'] . ' - User Profile</title>';

			if (!isset($_GET['id'])) {
				header('Location: index.php?error=userid');
				exit();
			} else {
				$userId = $_GET['id'];
			}

			// Get Profile Information
			$query = "SELECT id,username,avatarUrl,level,exp,
				name,gender,pronouns,about,teamMember,patreonSupporter,isBeingIgnored,
				pokemonGoFriendCode,minecraftUsername,snapchatUsername,instagramUsername,githubUsername,websiteUrl
				FROM users WHERE id=? LIMIT 1";
			$stmt = mysqli_stmt_init($dbcon);
			if(!mysqli_stmt_prepare($stmt, $query)) {
		      header('Location: index.php?error=sqlerror');
		      exit();
		    }
			mysqli_stmt_bind_param($stmt, "s", $userId);
			mysqli_stmt_bind_result($stmt, $uId, $uUsername, $uAvatarUrl, $uLevel, $uEXP,
				$uName, $uGender, $uPronouns, $uAbout, $uTeamMember, $uPatreonSupporter, $uIsBeingIgnored,
				$uPokemonGo, $uMinecraft, $uSnapchat, $uInstagram, $uGitHub, $uWebsiteUrl);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);

			$resultCount = mysqli_stmt_num_rows($stmt);
	        if($resultCount != 1) {
	          header('Location: index.php?error=invalidid');
	          exit();
	        }
			// end[profile info].

			$isThereMiddleContent = false;
		?>
		<base href="profile.php?id=<?php echo $uId; ?>" />
	</head>
	<body style="background-color:#f1f3f4;">
        <?php require('header.php'); ?>
		<div class="container">
			<?php while(mysqli_stmt_fetch($stmt)) { ?>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php"><?php echo $config['global']['BREADCRUMB_INDEX_TITLE']; ?></a></li>
					<li class="breadcrumb-item"><a href="search.php">Users</a></li>
					<li class="breadcrumb-item active"><?php echo $uUsername; ?></li>
				</ol>
			</nav>



			<div class="container" style="background-color:#ffffff; padding:15px; border-radius:1%;">
		    <div class="row">

						<!-- Left Bar -->
		        <div class="col-12 col-lg-4 col-xl-3 order-1 order-lg-1">
		            <div class="card mb-3">
		                <div class="card-body text-center">
		                    <img src="<?php echo $uAvatarUrl; ?>" alt="" class="img-fluid rounded-circle mb-2" width="128" height="128">
		                    <h4 class="card-title mb-0"><?php echo $uUsername; ?></h4>
							<?php
								if(strtoupper($uTeamMember) == 'Y') {
									echo '<span class="badge badge-primary">' . $config['strings']['TEAM_MEMBER'] . '</span>';
								}
								elseif($uPatreonSupporter) {
									echo '<span class="badge badge-warning">' . $config['strings']['PATREON_SUPPORTER'] . '</span>';
								}
								elseif(strtoupper($uIsBeingIgnored) == 'Y') {
									echo '<span class="badge badge-danger">' . $config['strings']['BOT_IGNORED'] . '</span>';
								}
								else {
									echo '<span class="badge badge-dark">Standard User</span>';
								}

								if(isUserLoggedIn()) {
									if($userId == getIdFromSession()) {
										echo '<br />';
										echo '<a class="btn btn-outline-primary" href="account.php"><i class="fas fa-edit"></i> Edit Profile</a>';
									}
									elseif(isSessionUserTeamMember($dbcon)) {
										echo '<br />';
										echo '<a class="btn btn-danger" href="editprofile.php?id=' . $userId . '"><i class="fas fa-user-edit"></i> Edit this Profile</a>';
									}
								}
							?>
		                </div>
		            </div>
					<div class="card mb-3">
		                <div class="card-header">
		                    <h5 class="card-title mb-0"><strong><center>Level & EXP</center></strong></h5>
		                </div>
		                <div class="card-body">
		                    <ul class="list-unstyled mb-0">
								<center>
			                        <li class="mb-1">Level <?php echo $uLevel; ?></li>
			                        <li class="mb-1"><?php echo $uEXP; ?> EXP</li>
									<li class="mb-1"><?php
										$userLevel = $uLevel + 1;
										$math = (0.04 * (pow($userLevel, 3))) + (0.8 * (pow($userLevel, 2))) + (2 * $userLevel);
										echo '(' . (round($math) - $uEXP) . ' EXP to Level Up)';
									?></li>
		                    	</center>
							</ul>
		                </div>
		            </div>
					<?php
						if($uName != null || $uGender != null || $uPronouns != null || $uMinecraft != null || $uPokemonGo != null) {
							echo '
					            <div class="card mb-3">
					                <div class="card-header">
					                    <h5 class="card-title mb-0"><strong><center>About</center></strong></h5>
					                </div>
					                <div class="card-body">
										<table class="table table-sm table-hover table-borderless" style="margin-bottom: 0rem;">
											<thead>
												<tr>
													<th scope="col" colspan="2" class="text-center">About ' . $uUsername . '</th>
												</tr>
											</thead>
											<tbody>
							';

							if($uName != null) {
								echo '<tr>';
									echo '<th scope="row">Name</td>';
									echo '<td class="text-right">' . $uName . '</td>';
								echo '</tr>';
							}

							if($uGender != null) {
								echo '<tr>';
									echo '<th scope="row">Gender</td>';
									echo '<td class="text-right">' . $uGender . '</td>';
								echo '</tr>';
							}

							if($uPronouns != null) {
								echo '<tr>';
									echo '<th scope="row">Pronouns</td>';
									echo '<td class="text-right">' . $uPronouns . '</td>';
								echo '</tr>';
							}

							if($uMinecraft != null) {
								echo '<tr>';
									echo '<th scope="row">Minecraft</td>';
									echo '<td class="text-right">' . $uMinecraft . '</td>';
								echo '</tr>';
							}

							if($uPokemonGo != null) {
								echo '<tr>';
									echo '<th scope="row">Pokémon Go</td>';
									echo '<td class="text-right">' . '<a href="https://chart.googleapis.com/chart?chs=300x300&cht=qr&' . str_replace(" ", "", $uPokemonGo) . '&choe=UTF-8" target="_blank" title="Click for QR Code">' . $uPokemonGo . '</a></td>';
								echo '</tr>';
							}
						echo '

										</tbody>
									</table>
				                </div>
				            </div>
							';
						}
					?>

								<?php
								if($uWebsiteUrl != null || $uInstagram != null || $uSnapchat != null || $uGitHub != null) {
								echo '<div class="card mb-3">
		                <div class="card-header">
		                    <h5 class="card-title mb-0"><strong><center>Socials</center></strong></h5>
		                </div>
		                <div class="card-body">
		                    <ul class="list-unstyled mb-0"><center>';

							if($uWebsiteUrl != null) {
								echo '
								<li class="mb-1">
								<i class="fas fa-globe"></i> <a href="' . $uWebsiteUrl . '" target="_blank">Website</a>
								</li>';
							}

							if($uInstagram != null) {
								echo '
								<li class="mb-1">
								<i class="fab fa-instagram"></i> <a href="https://www.instagram.com/' . $uInstagram . '" target="_blank" title="Instagram">Instagram</a>
								</li>';
							}

							if($uSnapchat != null) {
								echo '
								<li class="mb-1">
								<i class="fab fa-snapchat-ghost"></i> <a href="https://www.snapchat.com/add/' . $uSnapchat .'" target="_blank" title="Snapchat">Snapchat</a>
								</li>';
							}

							if($uGitHub != null) {
								echo '
								<li class="mb-1">
								<i class="fab fa-github"></i> <a href="https://github.com/' . $uGitHub . '" target="_blank" title="GitHub">GitHub</a>
								</li>';
							}

							echo '
		                    </center></ul>
		                </div>
		            </div>';
							}?>
		        </div>

				<!-- Right Bar -->
		        <div class="col-12 col-lg-8 col-xl-9 order-2 order-lg-2">
					<?php
						if(!empty($uAbout)) {
							echo '
							<div class="card">
									<div class="card-body h-100">
											<div class="media">
													<img src="' . $uAvatarUrl . '" width="56" height="56" class="rounded-circle mr-3">
													<div class="media-body">
															<small class="float-right text-navy">About</small>
															<p class="mb-2"><strong>' . $uUsername . '</strong></p>
															';

															$Parsedown = new Parsedown();
															$str = $Parsedown->text($uAbout);
															echo nl2br($str);

															echo '
													</div>
											</div>
									</div>
							</div>
							<br />
							';
							$isThereMiddleContent = true;
						}

						// Awards
						$awardQuery = "SELECT awardId,awardText,awardType,dateAwarded FROM awards WHERE userId=? ORDER BY dateAwarded DESC;";
						$awardstmt = mysqli_stmt_init($dbcon);
						mysqli_stmt_prepare($awardstmt, $awardQuery);
						mysqli_stmt_bind_param($awardstmt, "s", $uId);
						mysqli_stmt_execute($awardstmt);
						mysqli_stmt_bind_result($awardstmt, $awardId, $awardText, $awardType, $dateAwarded);
						mysqli_stmt_store_result($awardstmt);

						if(mysqli_stmt_num_rows($awardstmt) != 0) {
							$isThereMiddleContent = true;

							echo '
							<div class="card">
				                <div class="card-header">
				                    <h5 class="card-title mb-0"><strong><center>Awards</center></strong></h5>
				                </div>
								<div class="card-body h-100">
									<table class="table table-hover table-sm" style="margin-bottom: 0rem;">
										<thead>
											<tr>
												<th scope="col"></th>
												<th scope="col">Category</th>
												<th scope="col">Award</th>
												<th scope="col" class="text-right">Date Awarded</th>
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
								  <td class="text-right">' . $dateAwarded . '</td>
								</tr>
								';
							}

							echo '
										</tbody>
										<tfoot>
											<tr class="text-right">
												<td colspan="4"><small class="text-navy">Total Number of Awards: ' . $awardstmt->num_rows() . '</small></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<br />
							';
						}
						$awardstmt->close();

						// GUILDS
						$guildsQuery = "SELECT guildId,guildName,guildIcon,dateJoined FROM guilds WHERE ownedBy=? ORDER BY dateJoined DESC;";
						$guildstmt = mysqli_stmt_init($dbcon);
						mysqli_stmt_prepare($guildstmt, $guildsQuery);
						mysqli_stmt_bind_param($guildstmt, "s", $uId);
						mysqli_stmt_execute($guildstmt);
						mysqli_stmt_bind_result($guildstmt, $gId, $gName, $gIcon, $gJoinDate);
						mysqli_stmt_store_result($guildstmt);
						if(mysqli_stmt_num_rows($guildstmt) != 0) {
							$isThereMiddleContent = true;
							echo '
							<div class="card">
				                <div class="card-header">
				                    <h5 class="card-title mb-0"><strong><center>Guilds</center></strong></h5>
				                </div>
								<div class="card-body h-100">
									<table class="table table-hover table-sm" style="margin-bottom: 0rem;">
										<thead>
											<tr>
												<th scope="col" width="15%"></th>
												<th scope="col" width="55%">Guild Name</th>
												<th scope="col" width="30%" class="text-right">Bot Join Date</th>
											</tr>
										</thead>
										<tbody>
							';

							while(mysqli_stmt_fetch($guildstmt)) {
								echo '
								<tr>
								  <th scope="row"><img src="' . $gIcon . '" class="img-fluid rounded-circle mb-2" width="64" height="64" /></th>
								  <td>' . $gName . '</td>
								  <td class="text-right">' . date('j', strtotime($gJoinDate)) . '<sup>' . date('S ', strtotime($gJoinDate)) . '</sup>' . date('F Y', strtotime($gJoinDate)) . '</td>
								</tr>
								';
							}

							echo '
										</tbody>
									</table>
								</div>
							</div>
							<br />
							';
						}
						$guildstmt->close();

						if(!$isThereMiddleContent) {
							echo '
								<div class="card">
										<div class="card-body h-100">
												<div class="media">
														<img src="' . $uAvatarUrl . '" width="56" height="56" class="rounded-circle mr-3">
														<div class="media-body">
																<small class="float-right text-navy">No Content</small>
																<p class="mb-2"><strong>' . $uUsername . '</strong></p>
																<p>Oh noes! ' . $uUsername . ' doesn\'t seem to have set their about message or earned any awards!</p>
														</div>
												</div>
										</div>
								</div>
								<br />
								';
						}
					?>
				</div>
			</div>
		</div>
		<br />
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php"><?php echo $config['global']['BREADCRUMB_INDEX_TITLE']; ?></a></li>
				<li class="breadcrumb-item"><a href="search.php">Users</a></li>
				<li class="breadcrumb-item active"><?php echo $uUsername; ?></li>
			</ol>
		</nav>

		<?php
		}
		$stmt->close();
		require('footer.php'); ?>
	</body>
</html>
