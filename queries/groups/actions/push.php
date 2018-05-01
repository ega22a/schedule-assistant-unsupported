<?php
    $groups = $_POST['groups'];
    $del = $_POST['del-id'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($groups as $group) {
        if (count($group) == 2) {
            $query = "SELECT * FROM `groups` WHERE `id` = $group[1]";
            $result = $MySQL -> query($query);
            $result = $result -> fetch_array(MYSQLI_ASSOC);
            if ($group[0] != $result['name']) {
                $query = "UPDATE `groups` SET `name` = '$group[0]' WHERE `id` = $group[1]";
                $MySQL -> query($query);
            }
        }
        if (count($group) == 1) {
            $query = "INSERT INTO `groups` (`name`, `isDelete`) VALUES ('$group[0]', 0)";
            $MySQL -> query($query);
        }
    }
    if (!empty($del)) {
        foreach ($del as $group) {
            $query = "UPDATE `groups` SET `isDelete` = 1 WHERE `id` = $group";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>