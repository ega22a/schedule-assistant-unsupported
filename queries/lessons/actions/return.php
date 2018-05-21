<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $disciplines = $_POST['disciplines'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($disciplines as $discipline) {
            $query = "UPDATE `disciplines` SET `isDelete` = 0 WHERE `id` = $discipline";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>