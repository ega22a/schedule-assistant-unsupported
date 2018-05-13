<?php
    $classrooms = $_POST['classrooms'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($classrooms as $classroom) {
        $query = "UPDATE `classrooms` SET `isDelete` = 0 WHERE `id` = $classroom";
        $MySQL -> query($query);
    }

    $MySQL -> close();
?>