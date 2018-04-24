<?php
    $teachers = $_POST['teachers'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($teachers as $teacher) {
        $query = "UPDATE `teachers` SET `isDelete` = 0 WHERE `id` = $teacher";
        $MySQL -> query($query);
    }

    $MySQL -> close();
?>