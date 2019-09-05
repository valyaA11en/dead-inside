<?php

include_once('config.php');
$mysqli = new mysqli(HOST , USER , PASS , DB , PORT);
if ($mysqli->connect_errno) { // Проверка на ошибку подключения
    exit();
}

$type = $mysqli->real_escape_string(trim($_POST['type']));
$id = $mysqli->real_escape_string(intval($_POST['id']));

// Одобрить
if ($type == "allow"){
    $sql = "UPDATE `request` SET `status` = 1 WHERE `id` = '$id'";
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

// Отклонить
if ($type == "deny"){
    $sql = "UPDATE `request` SET `status` = 0 WHERE `id` = '$id'";
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

// Пересмотреть
if ($type == "wait"){
    $sql = "UPDATE `request` SET `status` = 2 WHERE `id` = '$id'";
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