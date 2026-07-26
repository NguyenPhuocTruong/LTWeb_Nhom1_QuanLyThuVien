<?php
    $mysqli = new mysqli("localhost", "root", "", "library");
    if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);
?>