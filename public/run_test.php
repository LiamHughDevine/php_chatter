<?php
include 'data_retrieval.php';

try {
    $u = new User(1);
    echo $u->GetUserName();
}
catch (UserNotFound $e)
{
    echo "error";
}

?>