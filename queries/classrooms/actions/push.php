<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        $classrooms = $_POST['classrooms'];
        $del = $_POST['del-id'];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        foreach ($classrooms as $classroom) {
            if (count($classroom) == 3) {
                $query = "SELECT * FROM `classrooms` WHERE `id` = $classroom[2]";
                $result = $MySQL -> query($query);
                $result = $result -> fetch_array(MYSQLI_ASSOC);
                if ($classroom[0] != $result['idOfHousing'] || $classroom[1] != $result['NumberOfClassroom']) {
                    $query = "UPDATE `classrooms` SET `idOfHousing` = '$classroom[1]', `NumberOfClassroom` = '$classroom[0]' WHERE `id` = $classroom[2]";
                    $MySQL -> query($query);
                }
            }
            if (count($classroom) == 2) {
                $query = "INSERT INTO `classrooms` (`idOfHousing`, `NumberOfClassroom`, `isDelete`) VALUES ('$classroom[1]', '$classroom[0]', 0)";
                $MySQL -> query($query);
            }
        }
        if (!empty($del)) {
            foreach ($del as $classroom) {
                $query = "UPDATE `classrooms` SET `isDelete` = 1 WHERE `id` = $classroom";
                $MySQL -> query($query);
            }
        }
    }

    $MySQL -> close();
?>