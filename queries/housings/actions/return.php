<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $housings = $_POST['housings'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($housings as $housing) {
            $query = "UPDATE `housings` SET `isDelete` = 0 WHERE `id` = $housing";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>