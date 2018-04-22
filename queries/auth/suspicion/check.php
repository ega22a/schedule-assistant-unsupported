<?php
    // Представление страницы, как JSON-объект
    header('Content-Type: application/json');

    // Объявление массива, в котором будет собираться ответ
    $answer = [];

    // Объявляем авторизационные переменные
    $digest = $_COOKIE['digest'];
    $password = $_POST['password'];
    $fingerprint = $_POST['fingerprint'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    // Выполняем запрос на поиск контент-менеджера, формируем ответ в виде массива
    $query = "SELECT * FROM `managers` WHERE `manager_digest` = '$digest'";
    $result = $MySQL -> query($query);
    $result = $result -> fetch_array(MYSQLI_ASSOC);

    if (password_verify($password, $result['manager_password'])) {
        $thumb = $result['fingerprints'] . $fingerprint . ';';
        $query = "UPDATE `managers` SET `fingerprints` = '$thumb' WHERE `managers`.`manager_digest` = '$digest'";
        $MySQL -> query($query);
        $answer['loc'] = "/";
    }

    // Закрытие сессии с БД и вывод ответа от сервера в формате JSON
    $MySQL -> close();
    echo json_encode($answer);
?>