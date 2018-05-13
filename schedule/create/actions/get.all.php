<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');
    header('Content-Type: application/json');

    $answer = [
        'id' => [],
        'it' => [],
        'ir' => []
    ];

    if ($isAuth) {
        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

        $query = "SELECT * FROM `classrooms`";
        $result = $MySQL -> query($query);

        while ($row = $result -> fetch_assoc()) {
            if (!$row['isDelete']) {
                $idoh = $row['idOfHousing'];
                $s_query = "SELECT * FROM `housings` WHERE `id` = $idoh";
                $s_result = $MySQL -> query($s_query);
                $s_result = $s_result -> fetch_assoc();
                $answer['ir'][] = 'К' . $s_result['numberOfHousing'] . ' А' . $row['NumberOfClassroom'];
            }
        }

        $query = "SELECT * FROM `teachers`";
        $result = $MySQL -> query($query);

        while ($row = $result -> fetch_assoc()) {
            if (!$row['isDelete']) {
                $answer['it'][] = $row['lastName'] . ' ' . $row['firstName'] . ' ' . $row['middleName'];
            }
        }

        $query = "SELECT * FROM `disciplines`";
        $result = $MySQL -> query($query);

        while ($row = $result -> fetch_assoc()) {
            if (!$row['isDelete']) {
                $answer['id'][] = $row['shortName'] . ' (' . $row['fullName'] . ')';
            }
        }

        echo json_encode($answer);
    }
    else {
        echo '<script type="text/javascript">document.location = \'/\'</script>';
    }
    $MySQL -> close();
?>