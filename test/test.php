<?php
$server_name = "localhost";
$username = "root";
$password = "";
$database = "chatter";

$conn = mysqli_connect($server_name, $username, $password, $database);

if ($conn -> connect_error)
{
    die("connection failed".$conn -> connect_error);
}
else
{
    echo "connection succeeded";
}

$sql = "SELECT id, username, password FROM user";
$result = $conn->query($sql);

$sql = "INSERT INTO user (username, password, salt, admin) VALUES ('testuser1', 'test1', 0, 0)";

$conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Username: " . $row["username"]. " - Password: " . $row["password"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();

function delete_table()
{
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $database = "chatter";
    $min = 10000;
    $max = 99999;
    $conn = mysqli_connect($server_name, $username, $password, $database);
    try {
        $ran = rand (10000, 99999);
        echo "confirm deletion by entering " . $ran;
        throw new Exception();
    }
    catch (Exception $e)
    {
        echo "delete cancelled";
    }
    $sql = "DELETE FROM user";
}

?>