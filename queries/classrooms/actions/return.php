<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $classrooms = $_POST['classrooms'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($classrooms as $classroom) {
            $query = "UPDATE `classrooms` SET `isDelete` = 0 WHERE `id` = $classroom";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>