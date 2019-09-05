html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Make Me Elvis - Remove Email</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<?php
$dbc = mysqli_connect('localhost', 'is_227_1', 'id_227_1', 'id_227_1')
or die('Ошибка подключения с MySQL server.');

$email = $_POST['email'];

$query = "DELETE FROM email_list WHERE email = '$email'";
mysqli_query($dbc, $query)
or die('Ошибка с соединения с базой данных  .');

echo 'Клиент удален: ' . $email;

mysqli_close($dbc);
?>

</body>
</html>
