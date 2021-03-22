<?php
include 'sql_commands_test.php';

abstract class chatter_db implements JsonSerializable1
{
    abstract function __construct($id);
    abstract function update();
    abstract function delete(user $active_user);
    abstract function jsonSerialize();
}

class DataNotFound extends Exception
{

}

class IncorrectPermission extends Exception
{

}

class UsernameExists extends Exception
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
                $this->admin = true;
            }
            else
            {
                $this->admin = false;
            }
        }
        else
        {
            throw new DataNotFound();
        }
    }

    public static function add($username, $password)
    {
        if (retrieve_with_username($username))
        {
            throw new UsernameExists();
        }

        add_user($username, $password, 0);
    }

    public function update($username = null, $password = null, $last_online = null, $status = null, $admin = null)
    {
        if ($username == null) {
            $username = $this->username;
        }
        if ($password == null) {
            $password = $this->password;
        }
        if ($last_online == null) {
            $last_online = $this->last_online;
        }
        if ($status == null) {
            $status = $this->status;
        }
        if ($admin == null) {
            $admin = $this->admin;
        }

        update_user($this->id, $username, $password, $last_online, $status, $admin);
        $this->username = $username;
        $this->password = $password;
        $this->last_online = $last_online;
        $this->status = $status;
        $this->admin = $admin;
    }

    public function delete(user $active_user)
    {
        if ($active_user->get_admin() || $active_user->get_id() == $this->id)
        {
            $user_messages = message::get_message_from_user($this->id);
            foreach($user_messages as &$message)
            {
                $message->update(1);
            }

            try {
                delete_user($this->id);
            } catch (Exception $e)
            {
                foreach($user_messages as &$message)
                {
                    $message->update($this->id);
                }
            }

        }
        else
        {
            throw new IncorrectPermission();
        }
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

    public function jsonSerialize()
    {
        $chat_rooms = chat_room::get_chat_room_with_user($this->get_id());
        $chat_room_user = [];
        $chat_room_admin = [];
        $chat_room_owner = [];

        foreach ($chat_rooms as &$chat_room)
        {
        }

        return
        [
            'id' => $this->get_id(),
            'username' => $this->get_user_name(),
            'password' => $this->get_password(),
            'last_online' => $this->get_last_online(),
            'status' => $this->get_status(),
            'admin' => $this->get_admin()
        ];
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

    public static function add($name)
    {
        add_chat_room($name);
    }

    public function update($name = null)
    {
        if ($name == null)
        {
            $name = $this->name;
        }

        update_chat_room($this->id, $name);
        $this->name = $name;
        $this->pin = room_pin($this->id);
    }

    public function delete(user $active_user){
        if ($active_user->get_admin() == true || $active_user->get_id() == $this->id)
        {
            $room_messages = message::get_message_from_room($this->id);
            foreach($room_messages as &$message)
            {
                $message->delete($active_user);
            }
            delete_room($this->id);
        }
        else
        {
            throw new IncorrectPermission();
        }
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

    public static function get_chat_room_with_user($id)
    {
        $rooms = get_chat_room_with_user($id);
        $rooms_to_return = [
            member => array(),
            admim => array(),
            owner => array()
            ];
        for ($i = 0; $i <= count($rooms) - 1; $i++) {
            $m = new chat_room($rooms[$i]);
            if ($rooms[$i]['privileges'] == 1)
            {
                array_push($rooms_to_return['member'], $m);
            }
            else if ($rooms[$i]['privileges'] == 2)
            {
                array_push($rooms_to_return['admin'], $m);
            }
            else if ($rooms[$i]['privileges'] == 3)
            {
                array_push($rooms_to_return['owner'], $m);
            }
        }
        return $rooms_to_return;
    }

    public function jsonSerialize()
    {
        return
            [
                'id' => $this->get_id(),
                'name' => $this->get_name(),
                'pin' => $this->get_pin()
            ];
    }
}

class message extends chatter_db
{
    private $id;
    private $user_id;
    private $room_id;
    private $text;
    private $time_stamp;

    public function __construct($id){
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

    public static function add($user_id, $room_id, $text){
        add_message($user_id, $room_id, $text);
    }

    public function update($user_id = 0, $room_id = 0, $text = 0, $time_stamp = 0){
        if ($user_id == 0) {
            $user_id = $this->user_id;
        }
        if ($room_id == 0) {
            $room_id = $this->room_id;
        }
        if ($text == 0) {
            $text = $this->text;
        }
        if ($time_stamp == 0) {
            $time_stamp = $this->time_stamp;
        }

        update_message($this->id, $user_id, $room_id, $text, $time_stamp);
        $this->user_id = $user_id;
        $this->room_id = $room_id;
        $this->text = $text;
        $this->time_stamp = $time_stamp;
    }

    public function delete(user $active_user){
        if ($active_user->get_admin() == true || $active_user->get_id() == $this->user_id)
        {
            $message_attachments = attachment::get_attachment_from_message($this->id);
            foreach($message_attachments as &$attachment)
            {
                $attachment->delete($active_user);
            }

            delete_message($this->id);
        }
        else
        {
            throw new IncorrectPermission();
        }
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

    public function get_sender(){
        return user($this->user_id);
    }

    public function get_chat_room(){
        return chat_room($this->room_id);
    }

    public static function get_message_from_user($sender_id){
        $message_rows = retrieve_messages_from_user($sender_id);
        $messages_to_return = array();

        for ($i = 0; $i <= count($message_rows) - 1; $i++) {
            $m = new message($message_rows[$i]['id']);
            array_push($messages_to_return, $m);
        }
        return $messages_to_return;
    }

    public static function get_message_from_room($sender_id){
        $message_rows = retrieve_messages_from_room($sender_id);
        $messages_to_return = array();
        for ($i = 0; $i <= count($message_rows) - 1; $i++) {
            $m = new message($message_rows[$i]['id']);
            array_push($messages_to_return, $m);
        }
        return $messages_to_return;
    }

    public function jsonSerialize()
    {
        return
            [
                'id' => $this->get_id(),
                'user_id' => $this->get_user_id(),
                'room_id' => $this->get_room_id(),
                'text' => $this->get_text(),
                'time_stamp' => $this->get_time_stamp()
            ];
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

    public function add($message_id, $path)
    {
        add_attachment($message_id, $path);
    }

    public function update($message_id = 0, $path = null)
    {
        if ($message_id == 0) {
            $message_id = $this->message_id;
        }
        if ($path == null) {
            $path = $this->path;
        }

        update_attachment($this->id, $message_id, $path);
        $this->message_id = $message_id;
        $this->path = $path;
    }

    public function delete(user $active_user)
    {
        delete_attachment($this->id);
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

    public function get_message(){
        return message($this->message_id);
    }

    public static function get_attachment_from_message($message_id){
        $attachment_rows = retrieve_attachments_from_message($message_id);
        $attachments_to_return = array();

        for ($i = 0; $i <= count($attachment_rows) - 1; $i++) {
            $m = new attachment($attachment_rows[$i]['id']);
            array_push($attachments_to_return, $m);
        }
        return $attachments_to_return;
    }

    public function jsonSerialize()
    {
        return
            [
                'id' => $this->get_id(),
                'message_id' => $this->get_message_id(),
                'path' => $this->path()
            ];
    }
}

?>
