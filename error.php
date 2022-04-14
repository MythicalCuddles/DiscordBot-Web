<body>
	<?php
		if(isset($_GET['error'])) {
			$errorId = $_GET['error'];

			if($errorId == "userid" || $errorId == "invalidid") {
				echo '<div class="alert alert-warning">
							Sorry about that, but we couldn\'t find any profiles linked to that ID.
						</div>';
			}
            elseif($errorId == "loginrequired") {
              echo '<div class="alert alert-warning">You need to be logged in to access that page!</div>';
            }
			elseif($errorId == "nopermission") {
              echo '<div class="alert alert-danger">You do not have the required permissions to view that page!</div>';
			}
			elseif($errorId == "waitwhat") { // from adminsearchfetch.php
              echo '<div class="alert alert-danger">How did you end up here?! Anyways, that resource you tried to access is off limits!</div>';
			}
        }
	?>
</body>
