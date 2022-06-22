<?php
$json = json_decode(file_get_contents("http://192.168.18.19/home/web/json"));
if (count($json) > 0) {
    foreach ($json as $device) {
        $data = explode($device->log, "-:-", 2);
        $comando = "gpio mode " . $data[0] . " out";
        exec($comando);
        if (count($data) > 1) {
            $comando = "gpio mode " . $data[1] . " out";
            exec($comando);
            if ($device->signal == 2) {
                $comando = "gpio write " . $data[0] . " 1";
                exec($comando);
                $comando = "gpio write " . $data[1] . " 0";
                exec($comando);
            } else if ($device->signal == 3) {
                $comando = "gpio write " . $data[0] . " 0";
                exec($comando);
                $comando = "gpio write " . $data[1] . " 1";
                exec($comando);
            } else if ($device->signal == 4) {
                $comando = "gpio write " . $data[0] . " 1";
                exec($comando);
                $comando = "gpio write " . $data[1] . " 1";
                exec($comando);
            }

        } else {
            $comando = "gpio write " . $data[0] . " " . $device->signal . "";
            exec($comando);
        }
    }
}
