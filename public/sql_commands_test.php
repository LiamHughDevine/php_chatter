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
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT username, password, last_online, status, admin FROM user WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
}

function update_user($id, $username, $password, $last_online, $status, $admin)
{
    $last_online = $last_online->format('Y-m-d H:i:s');
    if ($admin)
    {
        $admin = 1;
    }
    else
    {
        $admin = 0;
    }
    $sql = "UPDATE user SET username = '$username', password = '$password', last_online  = '$last_online', status = $status, admin = $admin WHERE id = $id";
    $mdb = mdb_connection_test();
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function retrieve_with_username($username)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT * FROM user WHERE username = '$username'";
    if (mysqli_num_rows(mysqli_query($mysqli, $sql)) > 0)
    {
        return true;
    }
    return false;
}

function delete_user($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "DELETE FROM user WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
}

function add_chat_room($name)
{
    $pin = null;
    while ($pin == null || retrieve_with_pin($pin))
    {
        $pin = generate_pin();
    }
    $mdb = mdb_connection_test();
    $sql = "INSERT INTO chat_room (name, pin) VALUES ('$name', '$pin')";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function update_chat_room($id, $name)
{
    $pin = null;
    while ($pin == null || retrieve_with_pin($pin))
    {
        $pin = generate_pin();
    }
    $sql = "UPDATE chat_room SET name = '$name', pin = '$pin' WHERE id = $id";
    $mdb = mdb_connection_test();
    $mdb->query($sql);
    mdb_disconect($mdb);
    echo $sql;
}

function room_pin($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT pin FROM chat_room WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
}

function retrieve_with_pin($pin)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT * FROM chat_room WHERE pin = '$pin'";
    if (mysqli_num_rows(mysqli_query($mysqli, $sql)) > 0)
    {
        return true;
    }
    return false;
}

function retrieve_chat_room($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT id, name, pin FROM chat_room WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
}

function get_chat_room_with_user($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT chat_room_id, privileges FROM chat_user WHERE user_id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
}

function delete_room($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "DELETE FROM chat_room WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
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
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT id, user_id, chat_room_id, message_text, time_stamp FROM message WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
}

function retrieve_messages_from_user($user_id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT id, user_id, chat_room_id, message_text, time_stamp FROM message WHERE user_id = $user_id";
    $result = $mysqli->query($sql);
    $rows = [];
    while($row = $result->fetch_array())
    {
        $rows[] = $row;
    }
    return $rows;
}

function retrieve_messages_from_room($room_id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT id, user_id, chat_room_id, message_text, time_stamp FROM message WHERE chat_room_id = $room_id";
    $result = $mysqli->query($sql);
    $rows = [];
    while($row = $result->fetch_array())
    {
        $rows[] = $row;
    }
    return $rows;
}

function update_message($id, $user_id, $room_id, $text, $time_stamp)
{
    $time_stamp = $time_stamp->format('Y-m-d H:i:s');
    $sql = "UPDATE message SET user_id = $user_id, chat_room_id = $room_id, message_text  = '$text', time_stamp = '$time_stamp' WHERE id = $id";
    $mdb = mdb_connection_test();
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function delete_message($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "DELETE FROM message WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
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
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "SELECT id, message_id, path FROM attachment WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
}

function delete_attachment($id)
{
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $sql = "DELETE FROM attachment WHERE id = $id";
    $select_query = $mysqli->prepare($sql);
    $select_query->execute();
    return $select_query->get_result();
}

function retrieve_attachments_from_message($message_id)
{
    $sql = "SELECT id, message_id, path FROM attachment WHERE message_id = $message_id";
    $mysqli = new mysqli("localhost", "root", "", "chatter_test");
    $result = $mysqli->query($sql);
    $rows = [];
    while($row = $result->fetch_array())
    {
        $rows[] = $row;
    }
    return $rows;
}

function update_attachment($id, $message_id, $path)
{
    $sql = "UPDATE attachment SET message_id = $message_id, path  = '$path' WHERE id = $id";
    $mdb = mdb_connection_test();
    $mdb->query($sql);
    mdb_disconect($mdb);
}
?>