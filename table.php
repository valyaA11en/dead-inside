<?php

include_once('config.php');
$mysqli = new mysqli(HOST , USER , PASS , DB , PORT);
if ($mysqli->connect_errno) { // Проверка на ошибку подключения
    exit();
}

$sql = "SELECT * FROM `request`";
$query = $mysqli->query($sql);

?>

<html>
<head>
    <title>Заявки</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<table>
    <a href='#' class='pure-material-button-contained' onclick='window.location.reload();' style="margin: 5px; position: absolute; left: 0; top: 0">Обновить таблицу</a>
    <thead>
    <tr>
        <th>ID</th>
        <th>Номер автомобиля</th>
        <th>Номер трейлера</th>
        <th>ФИО водителя</th>
        <th>ФИО пассажиров</th>
        <th>Статус заявки</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($response = $query->fetch_object()){
        echo "<tr>";
        echo "<td>$response->id</td>"; // ID
        echo "<td>$response->car_number</td>"; // Автомобильный номер
        echo "<td>$response->trailer_number</td>"; // Номер трейлера
        echo "<td>$response->full_name</td>"; // ФИО Водителя
        echo "<td>$response->name</td>"; // ФИО Пассажиров
        if ($response->status == 0){ // Отклонено
            echo "<td>Отклонено</td>"; // Статус
        }
        if ($response->status == 1){ // Принято
            echo "<td>Принято</td>"; // Статус
        }
        if ($response->status == 2){ // В ожидании
            echo "<td>В ожидании/Пересмотрении</td>"; // Статус
        }
        if ($response->status == 0){ // Отклонено
            echo "<td><a href='#' class='pure-material-button-contained wait' onclick='wait_request($response->id)' style='margin: 5px;'>Пересмотреть</a></td>"; // Действия
        }
        if ($response->status == 1){ // Принято
            echo "<td><a href='#' class='pure-material-button-contained wait' onclick='wait_request($response->id)' style='margin: 5px;'>Пересмотреть</a></td>"; // Действия
        }
        if ($response->status == 2){ // В ожидании
            echo "<td><a href='#' class='pure-material-button-contained success' onclick='allow_request($response->id)' style='margin: 5px;'>Принять</a><a href='#' class='pure-material-button-contained error' onclick='deny_request($response->id)' style='margin: 5px;'>Отклонить</a></td>"; // Действия
        }
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<script src="jquery.min.js"></script>
<script src="sweetalert.min.js"></script>
<script src="index2.js"></script>

</body>
</html>