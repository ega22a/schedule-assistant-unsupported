<?php

    $isAuth = FALSE;

    // Объявляем авторизационные переменные
    $digest = $_COOKIE['digest'];

    // Совершаем соединение к БД
    require_once  $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    // Выполняем запрос на поиск контент-менеджера, формируем ответ в виде массива
    if (!empty($digest)) {
        $query = "SELECT * FROM `managers` WHERE `manager_digest` = '$digest'";
        $result = $MySQL -> query($query);
        $result = $result -> fetch_array(MYSQLI_ASSOC);
    }

    // Если ответ есть, то пропускаем пользователя
    if (!empty($result)) {
        $isAuth = TRUE;
    }

    // Закрытие сессии с БД
    $MySQL -> close();
?>