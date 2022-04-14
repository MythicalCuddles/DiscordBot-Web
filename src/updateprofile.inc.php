<?php

if(isset($_POST['updateProfile'])) {
    require('../connect.php');
    require('../src/SessionHandler.inc.php');
    session_start();

    $profile['id'] = getIdFromSession();
    $profile['name'] = $_POST['uName'];
    $profile['gender'] = $_POST['uGender'];
    $profile['pronouns'] = $_POST['uPronouns'];
    $profile['about'] = $_POST['uAbout'];
    $profile['pokemongo'] = $_POST['uPokemonGo'];
    $profile['minecraft'] = $_POST['uMinecraft'];
    $profile['snapchat'] = $_POST['uSnapchat'];
    $profile['instagram'] = $_POST['uInstagram'];
    $profile['github'] = $_POST['uGitHub'];
    $profile['webname'] = $_POST['uWebName'];
    $profile['weburl'] = $_POST['uWebURL'];

    $updateQuery = "UPDATE users SET name=?,gender=?,pronouns=?,about=?,pokemonGoFriendCode=?,minecraftUsername=?,snapchatUsername=?,instagramUsername=?,githubUsername=?,websiteName=?,websiteURL=? WHERE id=?;";
    $updateStmt = mysqli_stmt_init($dbcon);
    $updateStmt->prepare($updateQuery);
    $updateStmt->bind_param("ssssssssssss", $profile['name'], $profile['gender'], $profile['pronouns'], $profile['about'], $profile['pokemongo'], $profile['minecraft'], $profile['snapchat'], $profile['instagram'], $profile['github'], $profile['webname'], $profile['weburl'], $profile['id']);
    $updateStmt->execute();
    $updateStmt->close();

    unset($profile);
    header("Location: ../account.php?status=profileUpdated");
    exit();
}
else {
    header("Location: ../index.php");
    exit();
}
