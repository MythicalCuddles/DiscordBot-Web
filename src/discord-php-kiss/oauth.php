<?php
    require "discord_oauth.php";
    $config = require('../../config.php');
    require('../../connect.php');
    require('../SessionHandler.inc.php');

    $redirectURL = $config['oAuth']['REDIRECT_URI'];
    $clientID = $config['oAuth']['CLIENT_ID'];
    $clientSecret = $config['oAuth']['CLIENT_SECRET'];
    $scope = $config['oAuth']['SCOPE'];

    if (!isset($_GET['code'])) {
        discord_oauth_redirect($clientID, $scope, $redirectURL, true);
        exit();
    }

    $auth = discord_oauth_exchange($clientID, $clientSecret, $scope, $redirectURL, $_GET['code']);
    //echo "<h3>Auth Response:</h3>"; var_dump($auth);  echo "<hr>";
    if ($auth == null || !empty($auth['error'])) {
        die("Failed: Authorization was bad: " . $auth['error']);
    }

    $user = discord_oauth_get("/users/@me", $auth['access_token']);
    if ($user == null || !empty($user['message'])) {
        die("Failed: /users/@me threw a error: " . $user['message']);
    }

    session_start();
    session_regenerate_id(true);
    $_SESSION['auth'] = $auth;
    $_SESSION['user'] = $user;

    $user['id'] = getIdFromSession();
    $user['username'] = getUsernameFromSession();
    $user['avatarUrl'] = getAvatarUrlFromSession();

    $insertQuery = "INSERT IGNORE INTO users(id, username, avatarUrl) VALUES(?, ?, ?);";
    $insertStmt = mysqli_stmt_init($dbcon);
    $insertStmt->prepare($insertQuery);
    $insertStmt->bind_param("sss", $user['id'], $user['username'], $user['avatarUrl']);
    $insertStmt->execute();
    $insertStmt->close();

    $updateQuery = "UPDATE users SET avatarUrl=? WHERE id=?;";
    $updateStmt = mysqli_stmt_init($dbcon);
    $updateStmt->prepare($updateQuery);
    $updateStmt->bind_param("ss", $user['avatarUrl'], $user['id']);
    $updateStmt->execute();
    $updateStmt->close();

    unset($user);

    header('Location: ../../index.php?login=success');
    exit();


/*





    //Get the user
    $user = discord_oauth_get("/users/@me", $auth['access_token']);
    echo "<h3>User Response:</h3>"; var_dump($user);  echo "<hr>";

    if ($user == null || !empty($user['message']))
        echo("Failed: /users/@me threw a error: " . $user['message']);

	//Get the connections
    $connections = discord_oauth_get("/users/@me/connections", $auth['access_token']);
    echo '<h3>Connections Response:</h3>'; var_dump($connections); echo "<hr>";

    if ($connections == null || !empty($connections['message']))
        echo("Failed: /users/@me/connections threw a error: " . $connections['message']);

	//Get the guilds
    $guilds = discord_oauth_get("/users/@me/guilds", $auth['access_token']);
    echo "<h3>Guilds Response:</h3>"; var_dump($guilds);  echo "<hr>";

    if ($guilds == null || !empty($guilds['message']))
        echo("Failed: /users/@me/guilds threw a error: " . $guilds['message']);

    //Display the username
    echo "Welcome " . $user['username'];
    exit;
