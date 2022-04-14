<?php

function isUserLoggedIn() {
    if(isset($_SESSION['auth']) && isset($_SESSION['user'])) {
        return true;
    }
    else {
        return false;
    }
}

function getIdFromSession() {
    if(isUserLoggedIn()) {
        return $_SESSION['user']['id'];
    }
}

function getUsernameFromSession() {
    if(isUserLoggedIn()) {
        return $_SESSION['user']['username'];
    }
}

function getDiscriminatorFromSession() {
    if(isUserLoggedIn()) {
        return $_SESSION['user']['discriminator'];
    }
}

function getAvatarIdFromSession() {
    if(isUserLoggedIn()) {
        return $_SESSION['user']['avatar'];
    }
}

function getAvatarUrlFromSession() {
    if(isUserLoggedIn()) {
        return 'https://cdn.discordapp.com/avatars/' . getIdFromSession() . '/' . getAvatarIdFromSession() . '.png?size=128';
    }
}

function isSessionUserTeamMember($dbcon) {
    if(isUserLoggedIn()) {
        $_q = "SELECT teamMember FROM users WHERE id=?;";
        $_stmt = mysqli_stmt_init($dbcon);

        if(!$_stmt->prepare($_q)) {
          header('Location: index.php?error=sqlerror');
          exit();
        }

        $uid = getIdFromSession();
        $_stmt->bind_param("s", $uid);
        $_stmt->bind_result($_tMember);
        $_stmt->execute();
        $_stmt->store_result();

        while($_stmt->fetch()) {
            if(strtoupper($_tMember) == 'Y') {
                return true;
            }
            else {
                return false;
            }
        }

        $_stmt->close();
        exit();
    }
    else {
        return false;
    }
}
