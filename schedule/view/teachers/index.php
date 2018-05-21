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
        
        $nameOfTeacher = "SELECT * FROM `teachers` WHERE `id` = $id";
        $nameOfTeacher = $MySQL -> query($nameOfTeacher);
        $nameOfTeacher = $nameOfTeacher -> fetch_assoc();
        $nameOfTeacher = $nameOfTeacher['lastName'] . ' ' . $nameOfTeacher['firstName'] . ' ' . $nameOfTeacher['middleName'];

        echo '
            <div class="modal"></div>
            <div class="workspace">';
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/h-menu.phtml');
        echo '
            <div class="message-box not-selected"></div>
            <h1 class="not-selected">' . $nameOfTeacher . '</h1>
            <h1 class="not-selected" style="font-size: 1.1em;">Расписание на ' . $_GET['date'] . '</h1>
            <div class="wrapper">
                <div class="div-table">
                    <div class="div-row div-header">
                        <div class="div-cell">Пара</div>
                        <div class="div-cell">Дисциплина</div>
                        <div class="div-cell">Группа</div>
                        <div class="div-cell">Корпус</div>
                        <div class="div-cell">Кабинет</div>
                    </div>';

        $query = "SELECT * FROM `mSchedule` WHERE `dateOfSchedule` = '$date'";
        $query = $MySQL -> query($query);
        $sec_query = "SELECT * FROM `sSchedule` WHERE `dateOfSchedule` = '$date' && `countOfChanges` = (SELECT MAX(`countOfChanges`) FROM `sSchedule`)";
        $sec_query = $MySQL -> query($sec_query);
        
        $mainSchedule = [];
        while ($row = $query -> fetch_assoc()) {
            for ($i = 0; $i < 7; $i++) {
                $thumb_id = $row['lesson' . $i];
                $th_query = "SELECT * FROM `mLessons$i` WHERE `id` = $thumb_id";
                $th_query = $MySQL -> query($th_query);
                if ($th_query) {
                    $th_query = $th_query -> fetch_assoc();
                    if ($th_query['idOfTeacher'] == $id) {
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
                        $g = $row['idOfGroup'];
                        $g_query = "SELECT * FROM `groups` WHERE `id` = $g";
                        $g_query = $MySQL -> query($g_query);
                        $g_query = $g_query -> fetch_assoc();

                        $mainSchedule[] = [
                            'group' => $g_query['name'],
                            'numberOfLesson' => $i,
                            'discipline' => $d_query['fullName'],
                            'housing' => $h_query['numberOfHousing'],
                            'classroom' => $c_query['NumberOfClassroom']
                        ];
                    }
                }
            }
        }

        $secondSchedule = [];
        while ($row = $sec_query -> fetch_assoc()) {
            for ($i = 0; $i < 7; $i++) {
                $thumb_id = $row['lesson' . $i];
                $th_query = "SELECT * FROM `sLessons$i` WHERE `id` = $thumb_id";
                $th_query = $MySQL -> query($th_query);
                if ($th_query) {
                    $th_query = $th_query -> fetch_assoc();
                    if ($th_query['idOfTeacher'] == $id) {
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
                        $g = $row['idOfGroup'];
                        $g_query = "SELECT * FROM `groups` WHERE `id` = $g";
                        $g_query = $MySQL -> query($g_query);
                        $g_query = $g_query -> fetch_assoc();

                        $secondSchedule[] = [
                            'group' => $g_query['name'],
                            'numberOfLesson' => $i,
                            'discipline' => $d_query['fullName'],
                            'housing' => $h_query['numberOfHousing'],
                            'classroom' => $c_query['NumberOfClassroom']
                        ];
                    }
                }
            }
        }

        foreach ($mainSchedule as $lesson) {
            $secCounter = 0;
            foreach ($secondSchedule as $secondLesson) {
                if ($lesson['numberOfLesson'] != $secondLesson['numberOfLesson']) {
                    echo '
                        <div class="div-row">
                            <div class="div-cell" data-title="Пара">' . ($lesson['numberOfLesson'] + 1) . '</div>
                            <div class="div-cell" data-title="Дисциплина">' . $lesson['discipline'] . '</div>
                            <div class="div-cell" data-title="Группа">' . $lesson['group'] . '</div>
                            <div class="div-cell" data-title="Корпус">' . $lesson['housing'] . '</div>
                            <div class="div-cell" data-title="Кабинет">' . $lesson['classroom'] . '</div>
                        </div>
                    ';
                }
                else {
                    echo '
                        <div class="div-row">
                            <div class="div-cell" data-title="Пара">' . ($secondLesson['numberOfLesson'] + 1) . '</div>
                            <div class="div-cell" data-title="Дисциплина">' . $secondLesson['discipline'] . '</div>
                            <div class="div-cell" data-title="Группа">' . $secondLesson['group'] . '</div>
                            <div class="div-cell" data-title="Корпус">' . $secondLesson['housing'] . '</div>
                            <div class="div-cell" data-title="Кабинет">' . $secondLesson['classroom'] . '</div>
                        </div>
                    ';
                }
                $secCounter++;
            }
            if ($secCounter == 0) {
                echo '
                    <div class="div-row">
                        <div class="div-cell" data-title="Пара">' . ($lesson['numberOfLesson'] + 1) . '</div>
                        <div class="div-cell" data-title="Дисциплина">' . $lesson['discipline'] . '</div>
                        <div class="div-cell" data-title="Группа">' . $lesson['group'] . '</div>
                        <div class="div-cell" data-title="Корпус">' . $lesson['housing'] . '</div>
                        <div class="div-cell" data-title="Кабинет">' . $lesson['classroom'] . '</div>
                    </div>
                ';
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