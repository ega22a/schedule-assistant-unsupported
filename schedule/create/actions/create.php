<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    /*
        Номера состояний:
        0 - основное расписание на выбранную дату уже существует;
        10 - Расписание занесено в базу данных;
        20-x - Изменение успешно сохранено (x - количество изменений).
    */

    if ($isAuth) {
        $date = $_POST['date'];
        $schedule = json_decode($_POST['schedule']);
        $agree = $_POST['agree'];

        header('Content-Type: application/json');
        $answer = [];

        $date = explode('.', $date);
        $date = $date[2] . '-' . $date[1] . '-' . $date[0];

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

            $m_check = "SELECT * FROM `mSchedule` WHERE `dateOfSchedule` = '$date' LIMIT 1";
            $m_check = $MySQL -> query($m_check);
        if (empty($m_check -> fetch_assoc())) {
            foreach ($schedule as $housing) {
                foreach ($housing as $group) {
                    $idOfGroup = intval(explode('-', $group -> group)[1]);
                    $idsOfLessons = [];
                    $counter = 0;
                    foreach ($group -> lessons as $lesson) {
                        $discipline[0] = trim(explode(' (', $lesson[0])[0]);
                        $discipline[1] = trim(substr(explode(' (', $lesson[0])[1], 0, -1));
                        $teacher = explode(' ', $lesson[1]);
                        $classroom[0] = trim(mb_substr(explode(' ', $lesson[2])[0], 1));
                        $classroom[1] = trim(mb_substr(explode(' ', $lesson[2])[1], 1));
                        
                        $d_query = "SELECT `id` FROM `disciplines` WHERE `id` = `shortName` = '$discipline[0]' && `fullName` = '$discipline[1]'";
                        $d_query = $MySQL -> query($d_query);
                        $d_query = intval($d_query -> fetch_assoc()['id']);
                        $t_query = "SELECT `id` FROM `teachers` WHERE `firstName` = '$teacher[1]' && `lastName` = '$teacher[0]' && `middleName` = '$teacher[2]'";
                        $t_query = $MySQL -> query($t_query);
                        $t_query = intval($t_query -> fetch_assoc()['id']);
                        $h_query = "SELECT `id` FROM `housings` WHERE `numberOfHousing` = '$classroom[0]'";
                        $h_query = $MySQL -> query($h_query);
                        $h_query = intval($h_query -> fetch_assoc()['id']);
                        $c_query = "SELECT `id` FROM `classrooms` WHERE `idOfHousing` = $h_query && `NumberOfClassroom` = '$classroom[1]'";
                        $c_query = $MySQL -> query($c_query);
                        $c_query = intval($c_query -> fetch_assoc()['id']);

                        $name_of_table = 'mLessons' . $counter;
                        $m_query = "INSERT INTO `$name_of_table` (`idOfTeacher`, `idOfDiscipline`, `idOfClassroom`) VALUES ($t_query, $d_query, $c_query)";
                        $MySQL -> query($m_query);
                        $idsOfLessons[] = $MySQL -> insert_id;
                        $counter++;
                    }
                    $insert_query = "INSERT INTO `mSchedule` (`idOfGroup`, `dateOfSchedule`, `lesson0`, `lesson1`, `lesson2`, `lesson3`, `lesson4`, `lesson5`, `lesson6`) VALUES ($idOfGroup, '$date', IF($idsOfLessons[0] = 0, NULL, $idsOfLessons[0]), IF($idsOfLessons[1] = 0, NULL, $idsOfLessons[1]), IF($idsOfLessons[2] = 0, NULL, $idsOfLessons[2]), IF($idsOfLessons[3] = 0, NULL, $idsOfLessons[3]), IF($idsOfLessons[4] = 0, NULL, $idsOfLessons[4]), IF($idsOfLessons[5] = 0, NULL, $idsOfLessons[5]), IF($idsOfLessons[6] = 0, NULL, $idsOfLessons[6]))";
                    $MySQL -> query($insert_query);
                    $answer['errno'] = 10;
                }
            }
        }
        elseif ($agree) {
            $query_sec = "SELECT `countOfChanges` FROM `sSchedule` WHERE `dateOdSchedule` = '$date'";
            $query_sec = $MySQL -> query($query_sec);
            $sec_counter = 0;

            while ($row = $query_sec -> fetch_assoc()) {
                if ($sec_counter < $row['countOfChanges']) {
                    $sec_counter++;
                }
            }

            foreach ($schedule as $housing) {
                foreach ($housing as $group) {
                    $idOfGroup = intval(explode('-', $group -> group)[1]);
                    $idsOfLessons = [];
                    $counter = 0;
                    foreach ($group -> lessons as $lesson) {
                        $discipline[0] = trim(explode(' (', $lesson[0])[0]);
                        $discipline[1] = trim(substr(explode(' (', $lesson[0])[1], 0, -1));
                        $teacher = explode(' ', $lesson[1]);
                        $classroom[0] = trim(mb_substr(explode(' ', $lesson[2])[0], 1));
                        $classroom[1] = trim(mb_substr(explode(' ', $lesson[2])[1], 1));
                        
                        $d_query = "SELECT `id` FROM `disciplines` WHERE `id` = `shortName` = '$discipline[0]' && `fullName` = '$discipline[1]'";
                        $d_query = $MySQL -> query($d_query);
                        $d_query = intval($d_query -> fetch_assoc()['id']);
                        $t_query = "SELECT `id` FROM `teachers` WHERE `firstName` = '$teacher[1]' && `lastName` = '$teacher[0]' && `middleName` = '$teacher[2]'";
                        $t_query = $MySQL -> query($t_query);
                        $t_query = intval($t_query -> fetch_assoc()['id']);
                        $h_query = "SELECT `id` FROM `housings` WHERE `numberOfHousing` = '$classroom[0]'";
                        $h_query = $MySQL -> query($h_query);
                        $h_query = intval($h_query -> fetch_assoc()['id']);
                        $c_query = "SELECT `id` FROM `classrooms` WHERE `idOfHousing` = $h_query && `NumberOfClassroom` = '$classroom[1]'";
                        $c_query = $MySQL -> query($c_query);
                        $c_query = intval($c_query -> fetch_assoc()['id']);

                        $name_of_table = 'sLessons' . $counter;
                        $m_query = "INSERT INTO `$name_of_table` (`idOfTeacher`, `idOfDiscipline`, `idOfClassroom`) VALUES ($t_query, $d_query, $c_query)";
                        $MySQL -> query($m_query);
                        $idsOfLessons[] = $MySQL -> insert_id;
                        $counter++;
                    }
                    $insert_query = "INSERT INTO `sSchedule` (`idOfGroup`, `dateOfSchedule`, `countOfChanges` `lesson0`, `lesson1`, `lesson2`, `lesson3`, `lesson4`, `lesson5`, `lesson6`) VALUES ($idOfGroup, '$date', $sec_counter, IF($idsOfLessons[0] = 0, NULL, $idsOfLessons[0]), IF($idsOfLessons[1] = 0, NULL, $idsOfLessons[1]), IF($idsOfLessons[2] = 0, NULL, $idsOfLessons[2]), IF($idsOfLessons[3] = 0, NULL, $idsOfLessons[3]), IF($idsOfLessons[4] = 0, NULL, $idsOfLessons[4]), IF($idsOfLessons[5] = 0, NULL, $idsOfLessons[5]), IF($idsOfLessons[6] = 0, NULL, $idsOfLessons[6]))";
                    $MySQL -> query($insert_query);
                    $answer['errno'] = 10 . '-' . $sec_counter;
                }
            }
        }
        else {
            $answer['errno'] = 0;
        }

        echo json_encode($answer);
    }
    else {
        echo '<script type="text/javascript">document.location = \'/\'</script>';
    }
    $MySQL -> close();
?>