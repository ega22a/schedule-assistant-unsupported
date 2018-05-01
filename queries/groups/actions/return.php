<?php
    $groups = $_POST['groups'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($groups as $group) {
        $query = "UPDATE `groups` SET `isDelete` = 0 WHERE `id` = $group";
        $MySQL -> query($query);
    }

    $MySQL -> close();
?>