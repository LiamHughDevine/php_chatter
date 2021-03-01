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
    mdb_disconect($mdb);
    $sql = "SELECT username, password, last_online, status, admin FROM user WHERE id = $id";
    $selectQuery = $mysqli->prepare($sql);
    $selectQuery->execute();
    return $selectQuery->get_result();
}

function add_chat_room($name)
{
    $mdb = mdb_connection_test();
    $pin = generate_pin();
    $sql = "INSERT INTO chat_room (name, pin) VALUES ('$name', '$pin')";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function retrieve_chat_room($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter");
    $mdb = mdb_connection_test();
    mdb_disconect($mdb);
    $sql = "SELECT id, name, pin FROM chat_room WHERE id = $id";
    $selectQuery = $mysqli->prepare($sql);
    $selectQuery->execute();
    return $selectQuery->get_result();
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

function retrieve_message($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter");
    $mdb = mdb_connection_test();
    mdb_disconect($mdb);
    $sql = "SELECT id, user_id, chat_room_id, message_text, time_stamp FROM message WHERE id = $id";
    $selectQuery = $mysqli->prepare($sql);
    $selectQuery->execute();
    return $selectQuery->get_result();
}

function add_attachment($message_id, $path)
{
    $mdb = mdb_connection_test();
    $sql = "INSERT INTO attachment (message_id, path) VALUES ('$message_id', '$path')";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function retrieve_attachment($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter");
    $mdb = mdb_connection_test();
    mdb_disconect($mdb);
    $sql = "SELECT id, message_id, path FROM attachment WHERE id = $id";
    $selectQuery = $mysqli->prepare($sql);
    $selectQuery->execute();
    return $selectQuery->get_result();
}

?>