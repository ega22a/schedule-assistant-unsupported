<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $administration = $_POST['administration'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($administration as $administrator) {
            $query = "UPDATE `administration` SET `isDelete` = 0 WHERE `id` = $administrator";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>