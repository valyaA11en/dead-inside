    <?php
    session_start();


    if (!isset($_SESSION['user_id'])) {
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['username'] = $_COOKIE['username'];
        }
    }
    ?>


        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Mismatch - Edit Profile</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
    <h3>Mismatch - Edit Profile</h3>

    <?php
    require_once('appvars.php');
    require_once('connectvars.php');
    if (!isset($_SESSION['user_id'])) {
        echo '<p class="login">Пожалуйста <a href="login.php">Введите логин</a>чтобы получить доступ к этой странице.</p>';
        exit();
    }
    else {
        echo('<p class="login">вы вошли как ' . $_SESSION['username'] . '. <a href="logout.php">выйти</a>.</p>');
    }


    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_POST['submit'])) {

        $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
        $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
        $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
        $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
        $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
        $state = mysqli_real_escape_string($dbc, trim($_POST['state']));
        $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
        $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
        $new_picture_type = $_FILES['new_picture']['type'];
        $new_picture_size = $_FILES['new_picture']['size'];
        list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
        $error = false;


        if (!empty($new_picture)) {
            if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
                    ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE) &&
                ($new_picture_width <= MM_MAXIMGWIDTH) && ($new_picture_height <= MM_MAXIMGHEIGHT)) {
                if ($_FILES['file']['error'] == 0) {

                    $target = MM_UPLOADPATH . basename($new_picture);
                    if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {

                        if (!empty($old_picture) && ($old_picture != $new_picture)) {
                            @unlink(MM_UPLOADPATH . $old_picture);
                        }
                    }
                    else {

                        @unlink($_FILES['new_picture']['tmp_name']);
                        $error = true;
                        echo '<p class="error">К сожалению, при загрузке вашей фотографии возникла проблема.</p>';
                    }
                }
            }
            else {

                @unlink($_FILES['new_picture']['tmp_name']);
                $error = true;
                echo '<p class="error">Ваше изображение должно быть в формате GIF, JPEG или PNG, размером не более' . (MM_MAXFILESIZE / 1024) .
                    ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
            }
        }

        if (!$error) {
            if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate) && !empty($city) && !empty($state)) {

                if (!empty($new_picture)) {
                    $query = "UPDATE mismatch_user SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', " .
                        " birthdate = '$birthdate', city = '$city', state = '$state', picture = '$new_picture' WHERE user_id = '" . $_SESSION['user_id'] . "'";
                }
                else {
                    $query = "UPDATE mismatch_user SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', " .
                        " birthdate = '$birthdate', city = '$city', state = '$state' WHERE user_id = '" . $_SESSION['user_id'] . "'";
                }
                mysqli_query($dbc, $query);

                echo '<p>Ваш профиль был успешно обновлен.Вы не хотите <a href="viewprofile.php">посмотреть свой профиль</a>?</p>';

                mysqli_close($dbc);
                exit();
            }
            else {
                echo '<p class="error">Вы должны ввеси все данные профиля(изображенние не обязательно).</p>';
            }
        }
    }
    else {
        $query = "SELECT first_name, last_name, gender, birthdate, city, state, picture FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);

        if ($row != NULL) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $gender = $row['gender'];
            $birthdate = $row['birthdate'];
            $city = $row['city'];
            $state = $row['state'];
            $old_picture = $row['picture'];
        }
        else {
            echo '<p class="error">Возникла проблема с доступом к вашему профилю.</p>';
        }
    }

    mysqli_close($dbc);
    ?>

    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
        <fieldset>
            <legend>Personal Information</legend>
            <label for="firstname">First name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name; ?>" /><br />
            <label for="lastname">Last name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
                <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
            </select><br />
            <label for="birthdate">Birthdate:</label>
            <input type="text" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" /><br />
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" /><br />
            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php if (!empty($state)) echo $state; ?>" /><br />
            <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
            <label for="new_picture">Picture:</label>
            <input type="file" id="new_picture" name="new_picture" />
            <?php if (!empty($old_picture)) {
                echo '<img class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" />';
            } ?>
        </fieldset>
        <input type="submit" value="Save Profile" name="submit" />
    </form>
    </body>
    </html>