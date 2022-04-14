<?php

function isIdValidUser($dbcon, $uID) {
    //todo: stmt change
    $query = 'SELECT id FROM users WHERE id=' . $uID;
    $result = mysqli_query($dbcon, $query) or die('error gathering data.');
    $num_rows = mysqli_num_rows($result);
    if($num_rows == 1) {
        return true;
    } else {
        return false;
    }
}
