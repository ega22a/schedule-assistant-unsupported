<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        include ($_SERVER['DOCUMENT_ROOT'] . '/schedule/create/actions/head.phtml');
        echo '
            <div class="modal"></div>
            <div class="workspace">';
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/h-menu.phtml');
        echo '
            <div class="message-box not-selected"></div>
            <h1 class="not-selected">Создать расписание</h1>';
            require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';
        $query = "SELECT IF(NOT EXISTS(SELECT 1 FROM `administration` WHERE 1=1) OR NOT EXISTS(SELECT 1 FROM `classrooms` WHERE 1=1) OR NOT EXISTS(SELECT 1 FROM `disciplines` WHERE 1=1) OR NOT EXISTS(SELECT 1 FROM `groups` WHERE 1=1) OR NOT EXISTS(SELECT 1 FROM `housings` WHERE 1=1) OR NOT EXISTS(SELECT 1 FROM `teachers` WHERE 1=1),1,0) AS `empty`";
        $result = $MySQL -> query($query);
        $result = $result -> fetch_assoc();

        if ($result['empty'] == 1) {
            echo '
                <span class="wall"></span>
                <p class="wall-text not-selected">Прежде чем добавлять расписание, добавьте корпуса, кабинеты, группы, преподавателей и дисциплины!</p>
            ';
        }
        else {
            echo '
                <div class="input date-of-schedule">
                    <input type="text" placeholder="Дата" class="datepicker-here" readonly>
                    <span></span>
                </div>
            ';

            $query = "SELECT * FROM `housings`";
            $result = $MySQL -> query($query);

            while ($row = $result -> fetch_assoc()) {
                echo '
                    <h1 class="not-selected">Корпус №' . $row['numberOfHousing'] . ' (' . $row['dislocation'] . ')</h1>
                    <div class="big-table not-selected">
                ';
                
                $thumb_id = $row['id'];
                $s_query = "SELECT * FROM `groups` WHERE `idOfHousing` = $thumb_id";
                $s_result = $MySQL -> query($s_query);

                while ($s_row = $s_result -> fetch_assoc()) {
                    echo '
                        <table id="group-' . $s_row['id'] . '">
                            <tr>
                                <th colspan="4">' . $s_row['name'] . '</th>
                            </tr>
                            <tr>
                                <th class="table-th-number">Пара</th>
                                <th class="table-th-discipline">Дисциплина</th>
                                <th class="table-th-teacher">Преподаватель</th>
                                <th class="table-th-room">Кабинет</th>
                            </tr>';
                    for ($i = 1; $i < 8; $i++) {
                        echo '
                            <tr>
                                <th>' . $i . '</th>
                                <td>
                                    <input type="text" class="input-discipline">
                                    <ul></ul>
                                </td>
                                <td>
                                    <input type="text" class="input-teacher">
                                    <ul></ul>
                                </td>
                                <td>
                                    <input type="text" class="input-room">
                                    <ul></ul>
                                </td>
                            </tr>
                        ';
                    }
                    echo '
                        </table>
                    ';
                }
                echo '</div>';
            }
        }

        echo'
                    <div class="not-selected img-sub">
                        <div class="not-selected img"></div>
                    </div>
                </div>
            </html>
        ';
    }
    else {
        echo '<script type="text/javascript">document.location = \'/\'</script>';
    }
?>