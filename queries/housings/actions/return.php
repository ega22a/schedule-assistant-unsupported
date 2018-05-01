<?php
    $housings = $_POST['housings'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($housings as $housing) {
        $query = "UPDATE `housings` SET `isDelete` = 0 WHERE `id` = $housing";
        $MySQL -> query($query);
    }

    $MySQL -> close();
?>