<?php
include 'sql_commands_test.php';

abstract class chatter_db
{
    abstract function __construct($id);
    abstract function add();
    abstract function update();
    abstract function delete();
}

class DataNotFound extends Exception
{

}

class user extends chatter_db
{
    private $id;
    private $username;
    private $password;
    private $last_online;
    private $status;
    private $admin;

    public function __construct($id)
    {
        $this->id = $id;
        $user_data = retrieve_user($id)->fetch_array();

        if (isset($user_data))
        {
            $this->username = $user_data['username'];
            $this->password = $user_data["password"];
            try {
                $this->last_online = new DateTime($user_data['last_online']);
            } catch (Exception $e) {
            }
            $this->status = $user_data['status'];

            if ($user_data['admin'] == 1)
            {
                $admin = true;
            }
            else
            {
                $admin = false;
            }
        }
        else
        {
            throw new DataNotFound();
        }
    }

    public function add()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function get_user_name(){
        return $this->username;
    }

    public function get_id(){
        return $this->id;
    }

    public function get_password(){
        return $this->password;
    }

    public function get_last_online(){
        return $this->last_online;
    }

    public function get_status(){
        return $this->status;
    }

    public function get_admin(){
        return $this->admin;
    }
}

class chat_room extends chatter_db
{
    private $id;
    private $name;
    private $pin;

    public function __construct($id)
    {
        $this->id = $id;
        $room_data = retrieve_chat_room($id)->fetch_array();

        if (isset($room_data))
        {
            $this->name = $room_data['name'];
            $this->pin = $room_data['pin'];
        }
        else
        {
            throw new DataNotFound();
        }
    }

    public function add()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function get_name(){
        return $this->name;
    }

    public function get_id(){
        return $this->id;
    }

    public function get_pin(){
        return $this->pin;
    }
}

class message extends chatter_db
{
    private $id;
    private $user_id;
    private $room_id;
    private $text;
    private $time_stamp;

    public function __construct($id)
    {
        $this->id = $id;
        $message_data = retrieve_message($id)->fetch_array();

        if (isset($message_data))
        {
            $this->user_id = $message_data['user_id'];
            $this->room_id = $message_data['chat_room_id'];
            $this->text = $message_data['message_text'];
            try {
                $this->time_stamp = new DateTime($message_data['time_stamp']);
            } catch (Exception $e) {
            }
        }
        else
        {
            throw new DataNotFound();
        }
    }

    public function add()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function get_user_id(){
        return $this->user_id;
    }

    public function get_id(){
        return $this->id;
    }

    public function get_room_id(){
        return $this->room_id;
    }

    public function get_text(){
        return $this->text;
    }

    public function get_time_stamp(){
        return $this->time_stamp;
    }
}

class attachment extends chatter_db
{
    private $id;
    private $message_id;
    private $path;

    public function __construct($id)
    {
        $this->id = $id;
        $attachment_data = retrieve_attachment($id)->fetch_array();

        if (isset($attachment_data))
        {
            $this->message_id = $attachment_data['message_id'];
            $this->path = $attachment_data['path'];
        }
        else
        {
            throw new DataNotFound();
        }
    }

    public function add()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function get_message_id(){
        return $this->message_id;
    }

    public function get_id(){
        return $this->id;
    }

    public function get_path(){
        return $this->path;
    }
}
?>
