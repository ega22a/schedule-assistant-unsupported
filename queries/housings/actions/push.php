<?php
    $housings = $_POST['housings'];
    $del = $_POST['del-id'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    foreach ($housings as $housing) {
        if (count($housing) == 3) {
            $query = "SELECT * FROM `housings` WHERE `id` = $housing[2]";
            $result = $MySQL -> query($query);
            $result = $result -> fetch_array(MYSQLI_ASSOC);
            if ($housing[0] != $result['dislocation'] || $housing[1] != $result['numberOfHousing']) {
                $query = "UPDATE `housings` SET `dislocation` = '$housing[0]', `numberOfHousing` = '$housing[1]' WHERE `id` = $housing[2]";
                $MySQL -> query($query);
            }
        }
        if (count($housing) == 2) {
            $query = "INSERT INTO `housings` (`dislocation`, `numberOfHousing`, `isDelete`) VALUES ('$housing[0]', '$housing[1]', 0)";
            $MySQL -> query($query);
        }
    }
    if (!empty($del)) {
        foreach ($del as $housing) {
            $query = "UPDATE `housings` SET `isDelete` = 1 WHERE `id` = $housing";
            $MySQL -> query($query);
        }
    }

    $MySQL -> close();
?>