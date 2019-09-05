<?php

if (isset($_POST['submit'])) {

    $price = 0;

    $km = $_POST['km'];
    $kg = $_POST['kg'];
    $address = $_POST['address'];
    for ($i = 1; $i <= $km; $i++) {
        $price += 25;
    }

    if ($kg >= 30) {
        for ($i = 30; $i <= $kg; $i++) {
            $price += 15;
        }
    }

    if ($price < 400) {
        $price = 400;
    }

    $card = "
    ";
}


?>

<html>
<head>
    <title>РУС2</title>
    <style>
        .demo-card-square.mdl-card {
            width: 320px;
            height: 320px;
            float: left;
            margin: 1rem;
            position: relative;
        }

        .demo-card-square.mdl-card:hover {
            box-shadow: 0 8px 10px 1px rgba(0, 0, 0, .14), 0 3px 14px 2px rgba(0, 0, 0, .12), 0 5px 5px -3px rgba(0, 0, 0, .2);
        }

        .demo-card-square > .mdl-card__title {
            color: #fff;
            background: #03a9f4;
        }

        .demo-card-square > .mdl-card__accent {
            background: #ff9800;
        }

        body {
            padding: 20px;
            background: #fafafa;
            position: relative;
        }
    </style>
</head>
<body>
<?php if (isset($_POST['submit'])){
    echo "<div class=\"mdl-card mdl-shadow--2dp demo-card-square\">
    <div class=\"mdl-card__title mdl-card--expand\">
        <h2 class=\"mdl-card__title-text\">Карточка клиента</h2>
    </div>
    <div class=\"mdl-card__supporting-text\">
        Адрес доставки: $address
    </div>
    <div class=\"mdl-card__supporting-text\">
        Километры: $km
    </div>
    <div class=\"mdl-card__supporting-text\">
        Килограм: $kg
    </div>
    <div class=\"mdl-card__supporting-text\">
        Стоимость доставки: $price
    </div>
</div>";
} else {
    echo "
<form action=\"\" method=\"post\">
    <input type=\"text\" name=\"km\" placeholder=\"Сколько км:\">
    <input type=\"text\" name=\"kg\" placeholder=\"Сколько кг:\">
    <input type=\"text\" name=\"address\" placeholder=\"Адрес доставки:\">
    <input type=\"submit\" name=\"submit\" placeholder=\"Рассчитать\">
</form>";
} ?>

</body>
</html>
