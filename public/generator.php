<?php

function generate_pin()
{
    $pin = "";
    for ($i = 0; $i <= 7; $i++) {
        $x = 0;
        do {
            $x = rand(48, 90);
        } while (57 < $x && $x < 65);
        $pin = $pin . chr($x);
    }

    return $pin;
}

?>