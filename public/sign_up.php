<?php
include 'sql_commands.php';

$username = $_POST["username"];
$password = $_POST["password"];

add_user($username, $password, 1);
?>