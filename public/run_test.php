<?php
include 'data_retrieval.php';

try {
    $c = new chat_room(1);
    $u = new user(7);
    $c->delete($u);
    echo "Success";
}
catch (Exception $e)
{
    echo "Error:";
    echo "<br>";
    echo $e;
}

?>