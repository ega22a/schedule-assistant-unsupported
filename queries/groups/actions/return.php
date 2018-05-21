<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $groups = $_POST['groups'];

    require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($groups as $group) {
            $query = "UPDATE `groups` SET `isDelete` = 0 WHERE `id` = $group";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>