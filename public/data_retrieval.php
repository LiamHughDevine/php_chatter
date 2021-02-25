<?php
include 'sql_commands_test.php';

abstract class ChatterDB
{
    abstract function __construct($id);
    abstract function Add();
    abstract function Update();
    abstract function Delete();
}

class UserNotFound extends Exception
{

}

class User extends ChatterDB
{
    private $id;
    private $user_data;
    private $username;
    private $password;
    private $last_online;
    private $status;
    private $admin;

    public function __construct($id)
    {
        $user_data = retrieve_user($id)->fetch_array();

        try {
            $this->username = $user_data['username'];
            $this->password = $user_data["password"];
            $this->last_online = $user_data["last_online"];
            $this->status = $user_data["status"];

            if ($user_data['admin'] == 1)
            {
                $admin = true;
            }
            else
            {
                $admin = false;
            }
        }
        catch (Exception $e)
        {
            throw new UserNotFound();
        }
    }

    public function Add()
    {

    }

    public function Update()
    {

    }

    public function Delete()
    {

    }

    public function GetName()
    {
        return $this->username;
    }
}
?>
