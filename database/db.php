<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "phantomdb"
);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>