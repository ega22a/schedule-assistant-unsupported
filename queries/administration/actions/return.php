<?php
    $administration = $_POST['administration'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($administration as $administrator) {
        $query = "UPDATE `administration` SET `isDelete` = 0 WHERE `id` = $administrator";
        $MySQL -> query($query);
    }

    $MySQL -> close();
?>