<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');
        include ($_SERVER['DOCUMENT_ROOT'] . '/schedule/view/groups/actions/head.phtml');
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
        $query = "SELECT * FROM `mSchedule` WHERE `dateOfSchedule` = '$date' && `idOfGroup` = $id";
        $query = $MySQL -> query($query);
        $query = $query -> fetch_assoc();
        $sec_query = "SELECT * FROM `sSchedule` WHERE `dateOfSchedule` = '$date' && `idOfGroup` = $id && `countOfChanges` = (SELECT MAX(`countOfChanges`) FROM `sSchedule`)";
        $sec_query = $MySQL -> query($sec_query);
        $sec_query = $sec_query -> fetch_assoc();
        
        $nameOfGroup = "SELECT * FROM `groups` WHERE `id` = $id";
        $nameOfGroup = $MySQL -> query($nameOfGroup);
        $nameOfGroup = $nameOfGroup -> fetch_assoc();
        echo '
            <div class="modal"></div>
            <div class="workspace">';
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/h-menu.phtml');
        echo '
            <div class="message-box not-selected"></div>
            <h1 class="not-selected">Группа ' . $nameOfGroup['name'] . '</h1>
            <h1 class="not-selected" style="font-size: 1.1em;">Расписание на ' . $_GET['date'] . '</h1>
            <div class="wrapper">
                <div class="div-table">
                    <div class="div-row div-header">
                        <div class="div-cell">Пара</div>
                        <div class="div-cell">Дисциплина</div>
                        <div class="div-cell">Преподаватель</div>
                        <div class="div-cell">Корпус</div>
                        <div class="div-cell">Кабинет</div>
                    </div>';
        for ($i = 0; $i < 7; $i++) {
            if (empty($sec_query['lesson' . $i])) {
                $thumb_id = $query['lesson' . $i];
                $thi_query = "SELECT * FROM `mLessons$i` WHERE `id` = $thumb_id";
                $thi_query = $MySQL -> query($thi_query);
                if ($thi_query) {
                    $thi_query = $thi_query -> fetch_assoc();
                    $d = $thi_query['idOfDiscipline'];
                    $d_query = "SELECT * FROM `disciplines` WHERE `id` = $d";
                    $d_query = $MySQL -> query($d_query);
                    $d_query = $d_query -> fetch_assoc();
                    $t = $thi_query['idOfTeacher'];
                    $t_query = "SELECT * FROM `teachers` WHERE `id` = $t";
                    $t_query = $MySQL -> query($t_query);
                    $t_query = $t_query -> fetch_assoc();
                    $c = $thi_query['idOfClassroom'];
                    $c_query = "SELECT * FROM `classrooms` WHERE `id` = $c";
                    $c_query = $MySQL -> query($c_query);
                    $c_query = $c_query -> fetch_assoc();
                    $h = $c_query['idOfHousing'];
                    $h_query = "SELECT * FROM `housings` WHERE `id` = $h";
                    $h_query = $MySQL -> query($h_query);
                    $h_query = $h_query -> fetch_assoc();

                    echo '
                        <div class="div-row">
                            <div class="div-cell" data-title="Пара">' . ($i + 1) . '</div>
                            <div class="div-cell" data-title="Дисциплина">' . $d_query['fullName'] . '</div>
                            <div class="div-cell" data-title="Преподаватель">' . $t_query['lastName'] . ' ' . mb_substr($t_query['firstName'], 0, 1) . '.' . mb_substr($t_query['middleName'], 0, 1) . '.</div>
                            <div class="div-cell" data-title="Корпус">' . $h_query['numberOfHousing'] . '</div>
                            <div class="div-cell" data-title="Кабинет">' . $c_query['NumberOfClassroom'] . '</div>
                        </div>
                    ';
                }
            }
            else {
                $thumb_id = $sec_query['lesson' . $i];
                $thi_query = "SELECT * FROM `sLessons$i` WHERE `id` = $thumb_id";
                $thi_query = $MySQL -> query($thi_query);
                if ($thi_query) {
                    $thi_query = $thi_query -> fetch_assoc();
                    $d = $thi_query['idOfDiscipline'];
                    $d_query = "SELECT * FROM `disciplines` WHERE `id` = $d";
                    $d_query = $MySQL -> query($d_query);
                    $d_query = $d_query -> fetch_assoc();
                    $t = $thi_query['idOfTeacher'];
                    $t_query = "SELECT * FROM `teachers` WHERE `id` = $t";
                    $t_query = $MySQL -> query($t_query);
                    $t_query = $t_query -> fetch_assoc();
                    $c = $thi_query['idOfClassroom'];
                    $c_query = "SELECT * FROM `classrooms` WHERE `id` = $c";
                    $c_query = $MySQL -> query($c_query);
                    $c_query = $c_query -> fetch_assoc();
                    $h = $c_query['idOfHousing'];
                    $h_query = "SELECT * FROM `housings` WHERE `id` = $h";
                    $h_query = $MySQL -> query($h_query);
                    $h_query = $h_query -> fetch_assoc();

                    echo '
                        <div class="div-row">
                            <div class="div-cell" data-title="Пара">' . ($i + 1) . '</div>
                            <div class="div-cell" data-title="Дисциплина">' . $d_query['fullName'] . '</div>
                            <div class="div-cell" data-title="Преподаватель">' . $t_query['lastName'] . ' ' . mb_substr($t_query['firstName'], 0, 1) . '.' . mb_substr($t_query['middleName'], 0, 1) . '.</div>
                            <div class="div-cell" data-title="Корпус">' . $h_query['numberOfHousing'] . '</div>
                            <div class="div-cell" data-title="Кабинет">' . $c_query['NumberOfClassroom'] . '</div>
                        </div>
                    ';
                }
            }
        }
        echo '
                </div>
            </div>
                    <div class="not-selected img-sub">
                        <div class="not-selected img"></div>
                    </div>
                </div>
            </html>
        ';
    $MySQL -> close();
?>