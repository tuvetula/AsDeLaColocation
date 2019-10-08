<?php
$date = date("Ymd_Gis");
$data = print_r(json_decode(file_get_contents('php://input'), true), true);
file_put_contents('../../public/LogsRobots/'.$date.'.log', $data);