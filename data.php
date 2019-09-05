<?php
include_once('config.php');

$mysqli = new mysqli(HOST , USER , PASS , DB , PORT);
if ($mysqli->connect_errno) { // Проверка на ошибку подключения
    exit();
}

$car_number = $mysqli->real_escape_string(trim($_POST['car_number'])); // Автомобильный номер
$trailer_number = @$mysqli->real_escape_string(trim($_POST['trailer_number'])); // Номер прицепа
$full_name = $mysqli->real_escape_string(trim($_POST['full_name'])); // ФИО водителя
$name = $mysqli->real_escape_string(trim($_POST['name'])); // ФИО пассажиров (через ;)

if (empty($car_number) || empty($full_name)){
    $data = [
        'response' => false
    ];
    $json = json_encode($data);
    echo $json;
} else {
    if (empty($trailer_number)){
        $trailer_number = "";
    }
    $sql = "INSERT INTO `request` (`car_number`, `trailer_number`, `full_name`, `name`, `status`) VALUES ('$car_number', '$trailer_number', '$full_name', '$name', 2)";
    if ($mysqli->query($sql)){
        $data = [
            'response' => true
        ];
        $json = json_encode($data);
        echo $json;
    } else {
        $data = [
            'response' => false
        ];
        $json = json_encode($data);
        echo $json;
    }
}