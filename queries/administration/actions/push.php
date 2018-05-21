<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $administration = $_POST['administration'];
        $del = $_POST['del-id'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($administration as $administrator) {
            if (count($administrator) == 5) {
                $query = "SELECT * FROM `administration` WHERE `id` = $administrator[4]";
                $result = $MySQL -> query($query);
                $result = $result -> fetch_array(MYSQLI_ASSOC);
                if ($administrator[0] != $result['firstName'] || $administrator[1] != $result['lastName'] || $administrator[2] != $result['middleName'] || $administrator != $result['position']) {
                    $query = "UPDATE `administration` SET `firstName` = '$administrator[0]', `lastName` = '$administrator[1]', `middleName` = '$administrator[2]', `position` = '$administrator[3]' WHERE `id` = $administrator[4]";
                    $MySQL -> query($query);
                }
            }
            if (count($administrator) == 4) {
                $query = "INSERT INTO `administration` (`firstName`, `lastName`, `middleName`, `position`, `isDelete`) VALUES ('$administrator[0]', '$administrator[1]', '$administrator[2]', '$administrator[3]', 0)";
                $MySQL -> query($query);
            }
        }
        if (!empty($del)) {
            foreach ($del as $administrator) {
                $query = "UPDATE `administration` SET `isDelete` = 1 WHERE `id` = $administrator";
                $MySQL -> query($query);
            }
        }
    }
    
    $MySQL -> close();
?>