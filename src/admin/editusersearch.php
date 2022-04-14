<?php
session_start();
require('../SessionHandler.inc.php');
require('../../connect.php');

if(!isSessionUserTeamMember($dbcon)) {
    header('Location: ../../index.php?error=waitwhat');
    exit();
}

$query = "SELECT id,username,avatarUrl FROM Users WHERE username LIKE '%" . $_POST["search"] . "%';";
$result = mysqli_query($dbcon, $query) or die('error gathering data.');
$output = '';

if(mysqli_num_rows($result) > 0) {
    $output .= '
    <tr>
        <th scope="col" style="width: 20%">User ID</th>
        <th scope="col" style="width: 50%">Username</th>
        <th scope="col" style="width: 30%">Options</th>
    </tr>';
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $output .= '<tr>
            <td>' . $row['id'] . '</td>
            <td><img src="' . $row['avatarUrl'] . '" height="32" width="32" style="border-radius: 50%;" /> <a href="profile?id=' . $row['id'] . '">' . $row['username'] . '</a></td>
            <td>
                <a href="editprofile?id=' . $row['id'] . '"><button type="button" class="btn btn-sm">Edit User</button></a>
                    <a href="awardmanager?id=' . $row['id'] . '"><button type="button" class="btn btn-sm">Manage Awards</button></a>
            </td>
            </tr>';
    }
    echo $output;
}
else {
    echo '<tr><td colspan="3" style="text-align: center;">No Results.</td></tr>';
}
