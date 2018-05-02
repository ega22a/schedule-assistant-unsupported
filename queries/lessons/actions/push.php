<?php
    $disciplines = $_POST['disciplines'];
    $del = $_POST['del-id'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($disciplines as $discipline) {
        if (count($discipline) == 3) {
            $query = "SELECT * FROM `teachers` WHERE `id` = $discipline[2]";
            $result = $MySQL -> query($query);
            $result = $result -> fetch_array(MYSQLI_ASSOC);
            if ($discipline[0] != $result['shortName'] || $discipline[1] != $result['fullName']) {
                $query = "UPDATE `disciplines` SET `shortName` = '$discipline[0]', `fullName` = '$discipline[1]' WHERE `id` = $discipline[2]";
                $MySQL -> query($query);
            }
        }
        if (count($discipline) == 2) {
            $query = "INSERT INTO `disciplines` (`shortName`, `fullName`, `isDelete`) VALUES ('$discipline[0]', '$discipline[1]', 0)";
            $MySQL -> query($query);
        }
    }
    if (!empty($del)) {
        foreach ($del as $discipline) {
            $query = "UPDATE `disciplines` SET `isDelete` = 1 WHERE `id` = $discipline";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>