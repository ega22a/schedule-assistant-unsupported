<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $teachers = $_POST['teachers'];
        $del = $_POST['del-id'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($teachers as $teacher) {
            if (count($teacher) == 4) {
                $query = "SELECT * FROM `teachers` WHERE `id` = $teacher[3]";
                $result = $MySQL -> query($query);
                $result = $result -> fetch_array(MYSQLI_ASSOC);
                if ($teacher[0] != $result['lastName'] || $teacher[1] != $result['firstName'] || $teacher[2] != $result['middleName']) {
                    $query = "UPDATE `teachers` SET `lastName` = '$teacher[0]', `firstName` = '$teacher[1]', `middleName` = '$teacher[2]' WHERE `id` = $teacher[3]";
                    $MySQL -> query($query);
                }
            }
            if (count($teacher) == 3) {
                $query = "INSERT INTO `teachers` (`lastName`, `firstName`, `middleName`, `isDelete`) VALUES ('$teacher[0]', '$teacher[1]', '$teacher[2]', 0)";
                $MySQL -> query($query);
            }
        }
        if (!empty($del)) {
            foreach ($del as $teacher) {
                $query = "UPDATE `teachers` SET `isDelete` = 1 WHERE `id` = $teacher";
                $MySQL -> query($query);
            }
        }
    }

    $MySQL -> close();
?>