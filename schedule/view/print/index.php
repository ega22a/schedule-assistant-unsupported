<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/config/school.php');
    include ($_SERVER['DOCUMENT_ROOT'] . '/schedule/view/print/actions/head.phtml');
    require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';
    $date = $_GET['date'];
    $id = $_GET['id'];
    $date = explode('.', $date);
    $date = $date[2] . '-' . $date[1] . '-' . $date[0];

    $query = "SELECT * FROM `mSchedule` WHERE `dateOfSchedule` = '$date' LIMIT 1";
    $query = $MySQL -> query($query);
    if (empty($query -> fetch_assoc())) {
        echo '
            <script type="text/javascript">
                alert(\'Расписания на ' . $_GET['date'] . ' не существует. Вы будете перенаправлены на предыдущую страницу.\');
                history.back();
            </script>
        ';
    }

    echo '
        <div class="modal"></div>
        <div class="workspace">';
    include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/h-menu.phtml');
    echo '
        <div class="message-box not-selected"></div>
        <div class="select-admin">
            <h1 class="not-selected">Выберите представителя администрации</h1>
        </div>
    ';

    $query = "SELECT * FROM `administration` ORDER BY `lastName` ASC";
    $query = $MySQL -> query($query);
    echo '
        <div class="mdl-selectfield" style="max-width: 450px; margin: 0 auto">
            <select onchange="PrintSchedule();">
                <option disabled selected>Выберите представителя</option>
    ';
    while ($row = $query -> fetch_assoc()) {
        if (!$row['isDelete']) {
            echo '<option value=\'' . $row['id'] . '\'>' . $row['lastName'] . ' ' . $row['firstName'] . ' ' . $row['middleName'] . '</option>';
        }
    }
    echo '
            </select>
        </div>
    ';

    echo '
                <div class="not-selected img-sub">
                    <div class="not-selected img"></div>
                </div>
            </div>
            <div class="printable">
                <div class="sheet">
                    <table>
                        <tr>
                        <th rowspan="2" class="group">Группа</th>
                        <th colspan="2">1 Пара</th>
                        <th colspan="2">2 Пара</th>
                        <th colspan="2">3 Пара</th>
                        <th colspan="2">4 Пара</th>
                        <th colspan="2">5 Пара</th>
                        <th colspan="2">6 Пара</th>
                        <th colspan="2">7 Пара</th>
                    </tr>
                    <tr>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                    </tr>
    ';

    $housing_query = "SELECT * FROM `housings` WHERE `id` = $id";
    $housing_query = $MySQL -> query($housing_query);
    $housing_query = $housing_query -> fetch_assoc();

    $query = "SELECT * FROM `groups` WHERE `idOfHousing` = $id";
    $query = $MySQL -> query($query);
    $counter = 0;
    $sheet = 1;
    while ($row = $query -> fetch_assoc()) {
        $idOfGroup = $row['id'];
        if ($counter == 25) {
            $counter = 0;
            echo '
                </table>
                <table class="footer">
                        <tr>
                            <td>' . SCHOOL_NAME . '</td>
                            <td>УТВЕРЖДАЮ <span class="sign"></span> <span class="admin-for-housing"></span></td>
                        </tr>
                        <tr>
                            <td>Корпус № ' . $housing_query['numberOfHousing'] . ', ' . $housing_query['dislocation'] . ', ' . $_GET['date'] . ' г., лист ' . $sheet . '</td>
                            <td>Методист <span class="sign"></span> ' . SCHOOL_ADMIN . '</td>
                        </tr>
                    </table>
                </div>
                <div class="sheet">
                <table>
                    <tr>
                        <th rowspan="2" class="group">Группа</th>
                        <th colspan="2">1 Пара</th>
                        <th colspan="2">2 Пара</th>
                        <th colspan="2">3 Пара</th>
                        <th colspan="2">4 Пара</th>
                        <th colspan="2">5 Пара</th>
                        <th colspan="2">6 Пара</th>
                        <th colspan="2">7 Пара</th>
                    </tr>
                    <tr>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                        <th class="lesson">Дисциплина</th>
                        <th class="room">Каб</th>
                    </tr>
            ';
        }
        echo '
            <tr>
                <td rowspan="2" class="center">' . $row['name'] . '</td>
        ';
        $sec_query = "SELECT * FROM `mSchedule` WHERE `dateOfSchedule` = '$date' && `idOfGroup` = $idOfGroup";
        $sec_query = $MySQL -> query($sec_query);
        $otherQuery = "SELECT * FROM `sSchedule` WHERE `dateOfSchedule` = '$date' && `idOfGroup` = $idOfGroup && `countOfChanges` = (SELECT MAX(`countOfChanges`) FROM `sSchedule`)";
        $otherQuery = $MySQL -> query($otherQuery);
        $mainSchedule = [];
        while ($sec_row = $sec_query -> fetch_assoc()) {
            for ($i = 0; $i < 7; $i++) {
                $thumb_id = $sec_row['lesson' . $i];
                $th_query = "SELECT * FROM `mLessons$i` WHERE `id` = $thumb_id";
                $th_query = $MySQL -> query($th_query);
                if ($th_query) {
                    $th_query = $th_query -> fetch_assoc();
                    $d = $th_query['idOfDiscipline'];
                    $d_query = "SELECT * FROM `disciplines` WHERE `id` = $d";
                    $d_query = $MySQL -> query($d_query);
                    $d_query = $d_query -> fetch_assoc();
                    $c = $th_query['idOfClassroom'];
                    $c_query = "SELECT * FROM `classrooms` WHERE `id` = $c";
                    $c_query = $MySQL -> query($c_query);
                    $c_query = $c_query -> fetch_assoc();
                    $h = $c_query['idOfHousing'];
                    $h_query = "SELECT * FROM `housings` WHERE `id` = $h";
                    $h_query = $MySQL -> query($h_query);
                    $h_query = $h_query -> fetch_assoc();
                    $t = $th_query['idOfTeacher'];
                    $t_query = "SELECT * FROM `teachers` WHERE `id` = $d";
                    $t_query = $MySQL -> query($t_query);
                    $t_query = $t_query -> fetch_assoc();

                    $mainSchedule[] = [
                        'numberOfLesson' => $i,
                        'discipline' => $d_query['fullName'],
                        'housing' => $h_query['numberOfHousing'],
                        'classroom' => $c_query['NumberOfClassroom'],
                        'teacher' => $t_query['lastName'] . ' ' . mb_substr($t_query['firstName'], 0, 1) . '.' . mb_substr($t_query['middleName'], 0, 1) . '.'
                    ];
                }
                else {
                    $mainSchedule[] = '';
                }
            }
        }

        $secondSchedule = [];
        while ($th_row = $otherQuery -> fetch_assoc()) {
            for ($i = 0; $i < 7; $i++) {
                $thumb_id = $th_row['lesson' . $i];
                $th_query = "SELECT * FROM `sLessons$i` WHERE `id` = $thumb_id";
                $th_query = $MySQL -> query($th_query);
                if ($th_query) {
                    $th_query = $th_query -> fetch_assoc();
                    $d = $th_query['idOfDiscipline'];
                    $d_query = "SELECT * FROM `disciplines` WHERE `id` = $d";
                    $d_query = $MySQL -> query($d_query);
                    $d_query = $d_query -> fetch_assoc();
                    $c = $th_query['idOfClassroom'];
                    $c_query = "SELECT * FROM `classrooms` WHERE `id` = $c";
                    $c_query = $MySQL -> query($c_query);
                    $c_query = $c_query -> fetch_assoc();
                    $h = $c_query['idOfHousing'];
                    $h_query = "SELECT * FROM `housings` WHERE `id` = $h";
                    $h_query = $MySQL -> query($h_query);
                    $h_query = $h_query -> fetch_assoc();
                    $t = $th_query['idOfTeacher'];
                    $t_query = "SELECT * FROM `teachers` WHERE `id` = $d";
                    $t_query = $MySQL -> query($t_query);
                    $t_query = $t_query -> fetch_assoc();

                    $secondSchedule[] = [
                        'numberOfLesson' => $i,
                        'discipline' => $d_query['fullName'],
                        'housing' => $h_query['numberOfHousing'],
                        'classroom' => $c_query['NumberOfClassroom'],
                        'teacher' => $t_query['lastName'] . ' ' . mb_substr($t_query['firstName'], 0, 1) . '.' . mb_substr($t_query['middleName'], 0, 1) . '.'
                    ];
                }
                else {
                    $secondSchedule[] = '';
                }
            }
        }
        
        for ($i = 0; $i < count($mainSchedule); $i++) {
            for ($j = 0; $j < count($secondSchedule); $j++) {
                if (!empty($mainSchedule[$i]) && !empty($secondSchedule[$j]) && $mainSchedule[$i]['numberOfLesson'] == $secondSchedule[$j]['numberOfLesson']) {
                    $mainSchedule[$i] = $secondSchedule[$j];
                }
            }
        }

        for ($i = 0; $i < 7; $i++) {
            if (!empty($mainSchedule[$i]) && intval($mainSchedule[$i]['numberOfLesson']) == $i) {
                echo '
                    <td><div><div>' . $mainSchedule[$i]['discipline'] . '</div></div></td>
                    <td rowspan="2" class="center">' . $mainSchedule[$i]['housing'] . '<br>' . $mainSchedule[$i]['classroom'] . '</td>
                ';
            }
            else {
                echo '
                    <td></td>
                    <td rowspan="2" class="center"></td>
                ';
            }
        }
        echo '</tr><tr>';

        for ($i = 0; $i < 7; $i++) {
            if (!empty($mainSchedule[$i]) && intval($mainSchedule[$i]['numberOfLesson']) == $i) {
                echo '
                    <td><div><div>' . $mainSchedule[$i]['teacher'] . '</div></div></td>
                ';
            }
            else {
                echo '
                    <td></td>
                ';
            }
        }
        echo '</tr>';

        $counter++;
    }
    if ($counter != 0) {
        echo '
            </table>
            <table class="footer">
                    <tr>
                        <td>' . SCHOOL_NAME . '</td>
                        <td>УТВЕРЖДАЮ <span class="sign"></span> <span class="admin-for-housing"></span></td>
                    </tr>
                    <tr>
                        <td>Корпус № ' . $housing_query['numberOfHousing'] . ', ' . $housing_query['dislocation'] . ', ' . $_GET['date'] . ' г., лист ' . $sheet . '</td>
                        <td>Методист <span class="sign"></span> ' . SCHOOL_ADMIN . '</td>
                    </tr>
                </table>
            </div>
        ';
    }

    echo '
                    </table>
                </div>
            </div>
        </html>
    ';

    $MySQL -> close();
?>