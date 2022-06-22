<?php
require "Mail.php";

$sensores = array("Sensor de Humo", "Sensor de Movimiento #1", "Sensor de Movimiento #2");

exec("gpio mode 23 in");
exec("gpio read 23", $actual);
echo "\nPin 33) " . $sensores[0] . " (" . $actual[0] . ")";

if ($actual[0] == 1) {
    new Mail(0);
    echo "\nPin 33 Activado (" . $sensores[0] . ")";
    exec("gpio mode 23 out");
    exec("gpio write 23 1");
}

exec("gpio mode 24 in");
exec("gpio read 24", $actual);
echo "\n\nPin 35) " . $sensores[1] . " (" . $actual[1] . ")";

if ($actual[1] == 1) {
    new Mail(1);
    echo "\nPin 35 Activado (" . $sensores[1] . ")";
    exec("gpio mode 24 out");
    exec("gpio write 24 1");
}

exec("gpio mode 27 in");
exec("gpio read 27", $actual);
echo "\n\nPin 36) " . $sensores[2] . " (" . $actual[2] . ")";

if ($actual[2] == 1) {
    new Mail(2);
    echo "\nPin 36 Activado (" . $sensores[2] . ")";
    exec("gpio mode 27 out");
    exec("gpio write 27 1");
}
