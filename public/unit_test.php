<?php
include 'data_retrieval.php';

user_test();
echo "<br>";
chat_room_test();
echo "<br>";
message_test();
echo "<br>";
attachment_test();
echo "<br>";

function user_test()
{
    try {
        $u = new user(1);
        echo "User Found Successfully";
        echo "<br>";
        if ($u->get_user_name() == "TestUser1") {
            echo "Username correct";
            echo "<br>";
        } else {
            echo "Username incorrect";
            echo "<br>";
        }

        if ($u->get_admin() == false) {
            echo "Admin correct";
            echo "<br>";
        } else {
            echo "Admin incorrect";
            echo "<br>";
        }

        if ($u->get_status() == 1) {
            echo "Status correct";
            echo "<br>";
        } else {
            echo "Status incorrect";
            echo "<br>";
        }
    } catch
    (DataNotFound $e) {
        echo "User not found";
        echo "<br>";
    }
}

function chat_room_test()
{
    try {
        $u = new chat_room(1);
        echo "Room Found Successfully";
        echo "<br>";
        if ($u->get_name() == "TestRoom1") {
            echo "Name correct";
            echo "<br>";
        } else {
            echo "Name incorrect";
            echo "<br>";
        }

        if ($u->get_pin() == "0MPRR63Y") {
            echo "Pin correct";
            echo "<br>";
        } else {
            echo "Pin incorrect";
            echo "<br>";
        }
    } catch
    (DataNotFound $e) {
        echo "Room not found";
        echo "<br>";
    }
}

function message_test()
{
    try {
        $u = new message(1);
        echo "Message Found Successfully";
        echo "<br>";
        if ($u->get_user_id() == 1) {
            echo "User correct";
            echo "<br>";
        } else {
            echo "User incorrect";
            echo "<br>";
        }

        if ($u->get_text() == "message 1 cr 1 user 1 attach donald gary") {
            echo "Text correct";
            echo "<br>";
        } else {
            echo "Text incorrect";
            echo "<br>";
        }
    } catch
    (DataNotFound $e) {
        echo "Message not found";
        echo "<br>";
    }
}

function attachment_test()
{
    try {
        $u = new attachment(1);
        echo "Attachment Found Successfully";
        echo "<br>";
        if ($u->get_message_id() == 1) {
            echo "Message correct";
            echo "<br>";
        } else {
            echo "Message incorrect";
            echo "<br>";
        }

        if ($u->get_path() == "donald.png") {
            echo "Path correct";
            echo "<br>";
        } else {
            echo "Parg incorrect";
            echo "<br>";
        }
    } catch
    (DataNotFound $e) {
        echo "Attachment not found";
        echo "<br>";
    }
}
?>