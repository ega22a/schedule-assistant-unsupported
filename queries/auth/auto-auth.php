<?php
    // Объявляем авторизационные переменные
    $digest = $_COOKIE['digest'];
    $fingerprint = $_POST['fingerprint'];

    // Совершаем соединение к БД
    require_once  $_SERVER['DOCUMENT_ROOT'] . '/config/MySQL/connect.php';

    // Выполняем запрос на поиск контент-менеджера, формируем ответ в виде массива
    $query = "SELECT * FROM `managers` WHERE `manager_digest` = '$digest'";
    $result = $MySQL -> query($query);
    $result = $result -> fetch_array(MYSQLI_ASSOC);

    // Проверяем отпечаток с базой. Если отпечаток не найден, то пересылаем на заглушку с просьбой ввода пароля
    $fingerprints = explode(';', $result['fingerprints']);
    $fingerprintExsist = FALSE;
    foreach ($fingerprints as $value) {
        if ($value == $fingerprint) {
            // Если отпечаток есть, переключаем триггер
            $fingerprintExsist = TRUE;
        }
    }
    if (!$fingerprintExsist) {
        echo '<script type="text/javascript">document.location = \'suspicion\';</script>';
    }

    $MySQL -> close();
?>