<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $groups = $_POST['groups'];
        $del = $_POST['del-id'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($groups as $group) {
            if (count($group) == 3) {
                $query = "SELECT * FROM `groups` WHERE `id` = $group[2]";
                $result = $MySQL -> query($query);
                $result = $result -> fetch_assoc();
                if ($group[0] != $result['name'] || $group[1] != $result['idOfHousing']) {
                    $query = "UPDATE `groups` SET `idOfHousing` = '$group[1]', `name` = '$group[0]' WHERE `id` = $group[2]";
                    $MySQL -> query($query);
                }
            }
            if (count($group) == 2) {
                $query = "INSERT INTO `groups` (`idOfHousing`, `name`, `isDelete`) VALUES ('$group[1]', '$group[0]', 0)";
                $MySQL -> query($query);
            }
        }
        if (!empty($del)) {
            foreach ($del as $group) {
                $query = "UPDATE `groups` SET `isDelete` = 1 WHERE `id` = $group";
                $MySQL -> query($query);
            }
        }
    }

    $MySQL -> close();
?>