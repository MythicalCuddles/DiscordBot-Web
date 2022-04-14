<html>
    <head>
		<?php
            require('htmlhead.php');
			echo '<title>' . $config['global']['PAGE_TITLE_BOT_NAME'] . ' - Search</title>';

			// Paginator Part in URL - Handler
			if (!isset($_GET['page'])) {
				if(isset($_GET['username'])) {
					$criteria = $_GET['username'];
					header('Location: search.php?page=1&username=' . $criteria);
				} else {
					header('Location: search.php?page=1');
				}
				die('Error: Bad Page Number.');
			}
			// end.

			// Searching Criteria in URL - Handler
			if(isset($_GET['username'])) {
				$criteria = $_GET['username'];
				$query = "SELECT * FROM `Users` WHERE username LIKE '%" . $criteria . "%' ORDER BY id;";
			} else {
				$query = "SELECT * FROM `Users` ORDER BY id;";
			}

			$result = mysqli_query($dbcon, $query) or header('Location: search.php?page=1&error=invalidsearch') and exit();

			$num_rows = mysqli_num_rows($result);
			$num_pages = ceil($num_rows/$config['search']['SEARCH_RESULTS_PER_PAGE']);

			$page = $_GET['page'];
			$this_page_first_result = ($page-1)*$config['search']['SEARCH_RESULTS_PER_PAGE'];

			if(isset($_GET['username'])) {
				$query = 'SELECT * FROM `Users` WHERE username LIKE \'%' . $criteria .'%\' ORDER BY id LIMIT ' . $this_page_first_result . ',' .  $config['search']['SEARCH_RESULTS_PER_PAGE'];
			} else {
				$query = 'SELECT * FROM `Users` ORDER BY id LIMIT ' . $this_page_first_result . ',' .  $config['search']['SEARCH_RESULTS_PER_PAGE'];
			}

			$result = mysqli_query($dbcon, $query) or (header('Location: search.php?page=1&error=invalidsearch') and exit());
			// end.
		?>
    </head>

    <body style="background-color:#f1f3f4;">
		<?php require('header.php'); ?>

		<div class="container">
			<form class="input-group mb-3" action="search.php" method="get">
				<?php
					if(empty($criteria)) {
						echo '<input type="text" style="background-color:white;" class="form-control" placeholder="Username Search" name="username">';
					} else {
						echo '<input type="text" style="background-color:white;" class="form-control" placeholder="Username Search" name="username" value="' . $criteria . '">';
					}
				?>
				<button class="btn btn-dark" type="submit">Search</button>
			</form>

            <?php
                if(isset($_GET['error'])) {
                    $errorId = $_GET['error'];

                    if($errorId == "invalidsearch") {
                        echo '<div class="alert alert-danger">
                                    Your search query was invalid. Please try something else, or try again.
                                </div>';
                    }
                }
            ?>

			<div class="card-columns" align="center">
				<?php
					if($num_rows == 0) {
						echo '</div><div class="card text-center text-white bg-danger mb-3">';
							echo '<div class="card-body">';
								echo '<h5 class="card-title">Search Results</h5>';
								echo '<p class="card-text">Sorry, we couldn\'t find any users that matched the criteria you provided. Please try again.</p>';
							echo '</div>';
						echo '</div><div>';
					}
					else {
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
							//if (@getimagesize($row['avatarUrl'])) {
								if($row['teamMember'] == 'Y') {
									echo '<div class="card border-dark mb-3" style="max-width: 540px;">';
								}
								else if($row['patreonSupporter']) {
									echo '<div class="card border-warning mb-3" style="max-width: 540px;">';
								}
								else if($row['isBeingIgnored'] == 'Y') {
									echo '<div class="card border-danger mb-3" style="max-width: 540px;">';
								}
								else {
									echo '<div class="card border-light mb-3" style="max-width: 540px;">';
								}

								echo '<div class="row no-gutters">';
									echo '<div class="col-md-4">';
										echo '<img src="' . $row['avatarUrl'] . '" class="card-img" style="border-radius:50%; padding:2%;">';
									echo '</div>';
								echo '<div class="col-md-8">';
									echo '<div class="card-body">';
										echo '<p class="card-title"><a href="profile.php?id=' . $row['id'] . '">' . $row['username'] . '</a></p>';
										echo '<p class="card-text"><small>Level: ' . $row['level'] . ' | EXP: ' . $row['exp'] . '</small></p>';
									echo '</div>';
								echo '</div></div>';

								if($row['teamMember'] == 'Y') {
									echo '<div class="card-footer text-muted"><small>' . $config['strings']['TEAM_MEMBER'] . '</small></div>';
								}
								else if($row['patreonSupporter']) {
									echo '<div class="card-footer text-muted"><small>' . $config['strings']['PATREON_SUPPORTER'] . '</small></div>';
								}
								else if($row['isBeingIgnored'] == 'Y') {
									echo '<div class="card-footer text-muted"><small>' . $config['strings']['BOT_IGNORED'] . '</small></div>';
								}
								else {
									echo '<div class="card-footer text-muted"><small>Standard User</small></div>';
								}

								echo '</div>';
							//}
						}
					}
				?>
			</div>

			<br />

			<div align="center">
				<?php
					$onPage = 1;
					if (isset($_GET['page'])) {
						$onPage = $_GET['page'];
					}

					if($onPage != 1 && $num_pages > 1) {
						echo '<a href="search.php?page=1"><button type="button" class="btn btn-light"><<</button></a>';
						echo '<a href="search.php?page=' . ($onPage - 1) . '"><button type="button" class="btn btn-light"><</button></a>';
					}

					$startOnPage = $onPage - $config['search']['PAGES_PER_SIDE'];
					$endOnPage = $onPage + $config['search']['PAGES_PER_SIDE'];
					if($startOnPage < 1) { $startOnPage = 1; }
					if($endOnPage > $num_pages) { $endOnPage = $num_pages; }

					for (($page = $startOnPage); ($page <= $endOnPage); $page++) { //for ($page=1; $page<=$num_pages; $page++)
						if($page == $onPage) {
							echo '<button type="button" class="btn btn-primary">' . $page . '</button>';
						} else {
							echo '<a href="search.php?page=' . $page . '"><button type="button" class="btn btn-light">' . $page . '</button></a>';
						}
					}

					if($onPage != $num_pages && $num_pages > 1) {
						echo '<a href="search.php?page=' . ($onPage + 1) . '"><button type="button" class="btn btn-light">></button></a>';
						echo '<a href="search.php?page=' . $num_pages . '"><button type="button" class="btn btn-light">>></button></a>';
					}

				?>
			</div>

		</div> <!-- CONTAINER CLOSE -->

		<?php require('footer.php'); ?>
    </body>
</html>
