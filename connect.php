<?php

$database = require('config.php');

$dbcon = mysqli_connect($database['database']['DB_HOSTNAME'], $database['database']['DB_USERNAME'], $database['database']['DB_PASSWORD'], $database['database']['DB_NAME']);
$dbcon -> set_charset("utf8mb4");
