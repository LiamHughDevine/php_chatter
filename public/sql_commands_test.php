<?php
include 'connection.php';
include 'generator.php';

function add_user($username, $password, $admin)
{
    $mdb = mdb_connection_test();
    $sql = "INSERT INTO user (username, password, admin) VALUES ('$username', '$password', '$admin')";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function retrieve_user($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter");
    $mdb = mdb_connection_test();
    //$user_data = mysqli_query( $mdb, "SELECT username, password, last_online, status, admin FROM user WHERE id = $id", MYSQLI_USE_RESULT);
    mdb_disconect($mdb);
    $sql = "SELECT username, password, last_online, status, admin FROM user WHERE id = $id";
    $selectQuery = $mysqli->prepare($sql);
    $selectQuery->execute();
    $selectQueryResult = $selectQuery->get_result();
    return $selectQueryResult;
}

function add_chat_room($name)
{
    $mdb = mdb_connection_test();
    $pin = generate_pin();
    $sql = "INSERT INTO chat_room (name, pin) VALUES ('$name', '$pin')";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function add_chat_user($user_id, $chat_room_id, $privileges)
{
    $mdb = mdb_connection_test();
    $sql = "INSERT INTO chat_user (user_id, chat_room_id, privileges) VALUES ('$user_id', '$chat_room_id', '$privileges')";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function add_message($user_id, $chat_room_id, $message_text)
{
    $mdb = mdb_connection_test();
    $sql = "INSERT INTO message (user_id, chat_room_id, message_text) VALUES ('$user_id', '$chat_room_id', '$message_text')";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function add_attachment($message_id, $path)
{
    $mdb = mdb_connection_test();
    $sql = "INSERT INTO attachment (message_id, path) VALUES ('$message_id', '$path')";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

?>