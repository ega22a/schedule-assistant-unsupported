<?php
    $disciplines = $_POST['disciplines'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($disciplines as $discipline) {
        $query = "UPDATE `disciplines` SET `isDelete` = 0 WHERE `id` = $discipline";
        $MySQL -> query($query);
    }

    $MySQL -> close();
?>