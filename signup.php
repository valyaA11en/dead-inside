<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mismatch - Подписаться</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<h3>Mismatch - Подписаться</h3>

<?php
require_once('appvars.php');
require_once('connectvars.php');


$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
        $query = "SELECT * FROM mismatch_user WHERE username = '$username'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 0) {
            $query = "INSERT INTO mismatch_user (username, password, join_date) VALUES ('$username', SHA('$password1'), NOW())";
            mysqli_query($dbc, $query);

            echo '<p>Ваша новая учетная звпись была успешно создана.Теперь вы готовы <a href="login.php">Авторизоваться</a>.</p>';

            mysqli_close($dbc);
            exit();
        }
        else {
            echo '<p class="error">Учетная запись уже существует для этого имени пользователя.Пожалуйста,используйте другой адрес.</p>';
            $username = "";
        }
    }
    else {
        echo '<p class="error">Вы должны ввести все регистрационные данные, включая желаемый пароль, дважды.</p>';
    }
}
mysqli_close($dbc);
?>

<p>Пожалуйста, введите ваше имя и желаемый пороль, что юы подписаться рассогласование.</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
        <legend>Registration Info</legend>
        <label for="username">имя пользователя:</label>
        <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
        <label for="password1">пороль:</label>
        <input type="password" id="password1" name="password1" /><br />
        <label for="password2">пороль (повторите):</label>
        <input type="password" id="password2" name="password2" /><br />
    </fieldset>
    <input type="submit" value="Sign Up" name="submit" />
</form>
</body>
</html>
