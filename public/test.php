<?php
include 'sql_commands_test.php';

function clear_table($table)
{
    $mdb = mdb_connection();
    $sql = "DELETE FROM $table";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function reset_auto_increment($table)
{
    $mdb = mdb_connection();
    $sql = "ALTER TABLE $table AUTO_INCREMENT = 0;";
    $mdb->query($sql);
    mdb_disconect($mdb);
}

function test_data_user()
{
    clear_table("user");
    reset_auto_increment("user");
    add_user("TestUser1", "test1", 0);
    add_user("TestUser2", "test2", 0);
    add_user("TestUser3", "test3", 0);
    add_user("TestUser4", "test4", 0);
    add_user("TestUser5", "test5", 0);
    add_user("TestAdmin", "testadmin", 1);
}

function test_data_chat_room()
{
    clear_table("chat_room");
    reset_auto_increment("chat_room");
    add_chat_room("TestRoom1");
    add_chat_room("TestRoom2");
    add_chat_room("TestRoom3");
}

function test_data_chat_user()
{
    clear_table("chat_user");
    add_chat_user(1, 1, 3);
    add_chat_user(2, 1, 1);
    add_chat_user(3, 1, 1);
    add_chat_user(2, 2, 3);
    add_chat_user(3, 2, 1);
    add_chat_user(4, 2, 1);
    add_chat_user(1, 3, 3);
    add_chat_user(2, 3, 2);
    add_chat_user(3, 3, 1);
    add_chat_user(4, 3, 1);
    add_chat_user(5, 3, 1);
}

function test_data_message()
{
    clear_table("message");
    reset_auto_increment("message");
    add_message(1, 1, "message 1 cr 1 user 1 attach donald gary");
    add_message(2, 1, "message 2 cr 1 user 2");
    add_message(3, 1, "message 3 cr 1 user 3");
    add_message(1, 1, "message 4 cr 1 user 1");
    add_message(3, 1, "message 5 cr 1 user 3");
    add_message(2, 1, "message 6 cr 1 user 2");

    add_message(2, 2, "message 1 cr 2 user 2");
    add_message(3, 2, "message 2 cr 2 user 3");
    add_message(4, 2, "message 3 cr 2 user 4");
    add_message(3, 2, "message 4 cr 2 user 3");
    add_message(4, 2, "message 5 cr 2 user 4");
    add_message(2, 2, "message 6 cr 2 user 2 attach will");

    add_message(1, 3, "message 1 cr 3 user 1");
    add_message(2, 3, "message 2 cr 3 user 2 attach jen");
    add_message(3, 3, "message 3 cr 3 user 3 attach gary");
    add_message(4, 3, "message 4 cr 3 user 4");
    add_message(5, 3, "message 5 cr 3 user 5");
    add_message(4, 3, "message 6 cr 3 user 4");
    add_message(2, 3, "message 7 cr 3 user 2");
    add_message(3, 3, "message 8 cr 3 user 3");
    add_message(1, 3, "message 9 cr 3 user 1");
}

function test_data_attachment()
{
    clear_table("attachment");
    reset_auto_increment("attachment");
    add_attachment(1, "donald.png");
    add_attachment(1, "gary.png");
    add_attachment(12, "will.png");
    add_attachment(14, "jen.png");
    add_attachment(15, "gary.png");
}

?>