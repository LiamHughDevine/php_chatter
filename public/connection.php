<?php
function mdb_connection()
{
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $database = "chatter";

    return mysqli_connect($server_name, $username, $password, $database);
}

function mdb_connection_test()
{
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $database = "chatter";

    return mysqli_connect($server_name, $username, $password, $database);
}

function mdb_disconect($mdb)
{
    $mdb -> close();
}
?>