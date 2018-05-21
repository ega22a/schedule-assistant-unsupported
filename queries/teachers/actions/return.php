<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $teachers = $_POST['teachers'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($teachers as $teacher) {
            $query = "UPDATE `teachers` SET `isDelete` = 0 WHERE `id` = $teacher";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>