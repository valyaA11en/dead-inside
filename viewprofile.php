<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
    }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mismatch - Просмотр профиля</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<h3>Mismatch - View Profile</h3>

<?php
require_once('appvars.php');
require_once('connectvars.php');

if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Пожалуйста <a href="login.php">Войти в систему</a> что бы получить доступ к системе.</p>';
    exit();
}
else {
    echo('<p class="login">Вы вошли как' . $_SESSION['username'] . '. <a href="logout.php">выйти</a>.</p>');
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!isset($_GET['user_id'])) {
    $query = "SELECT username, first_name, last_name, gender, birthdate, city, state, picture FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
}
else {
    $query = "SELECT username, first_name, last_name, gender, birthdate, city, state, picture FROM mismatch_user WHERE user_id = '" . $_GET['user_id'] . "'";
}
$data = mysqli_query($dbc, $query);

if (mysqli_num_rows($data) == 1) {
    $row = mysqli_fetch_array($data);
    echo '<table>';
    if (!empty($row['username'])) {
        echo '<tr><td class="label">Username:</td><td>' . $row['username'] . '</td></tr>';
    }
    if (!empty($row['first_name'])) {
        echo '<tr><td class="label">First name:</td><td>' . $row['first_name'] . '</td></tr>';
    }
    if (!empty($row['last_name'])) {
        echo '<tr><td class="label">Last name:</td><td>' . $row['last_name'] . '</td></tr>';
    }
    if (!empty($row['gender'])) {
        echo '<tr><td class="label">Gender:</td><td>';
        if ($row['gender'] == 'M') {
            echo 'Male';
        }
        else if ($row['gender'] == 'F') {
            echo 'Female';
        }
        else {
            echo '?';
        }
        echo '</td></tr>';
    }
    if (!empty($row['birthdate'])) {
        if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
            echo '<tr><td class="label">Birthdate:</td><td>' . $row['birthdate'] . '</td></tr>';
        }
        else {
            // Show only the birth year for everyone else
            list($year, $month, $day) = explode('-', $row['birthdate']);
            echo '<tr><td class="label">Year born:</td><td>' . $year . '</td></tr>';
        }
    }
    if (!empty($row['city']) || !empty($row['state'])) {
        echo '<tr><td class="label">Location:</td><td>' . $row['city'] . ', ' . $row['state'] . '</td></tr>';
    }
    if (!empty($row['picture'])) {
        echo '<tr><td class="label">Picture:</td><td><img src="' . MM_UPLOADPATH . $row['picture'] .
            '" alt="Profile Picture" /></td></tr>';
    }
    echo '</table>';
    if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
        echo '<p>Would you like to <a href="editprofile.php">edit your profile</a>?</p>';
    }

else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
}

mysqli_close($dbc);
?>
</body>
</html>
