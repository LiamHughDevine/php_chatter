<?php
$server_name = "localhost";
$username = "root";
$password = "";
$database = "chatter";

$conn = mysqli_connect($server_name, $username, $password, $database);
$sql = "INSERT INTO chat_room (name, pin) VALUES ('test', '12345')";

$conn->query($sql);

$conn->close();
?>