<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/classrooms/actions/head.phtml');
        echo '
            <div class="modal"></div>
            <div class="workspace">';
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/h-menu.phtml');
        echo '
            </ul>
            <div class="message-box not-selected"></div>
            <h1 class="not-selected">Добавить корпуса</h1>';

        // Совершаем соединение к БД
        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';
        $query = "SELECT * FROM `housings`";
        $result = $MySQL -> query($query);

        $i = 0;
        while ($row = $result -> fetch_assoc()) {
            if ($row['isDelete']) {
                Continue;
            }
            $i++;
        }

        if ($i == 0) {
            echo '
                <span class="wall"></span>
                <p class="wall-text not-selected">Прежде чем добавлять кабинеты, добавьте корпуса!</p>
                <p class="wall-text not-selected">Также, если нужные корпуса находятся в архиве, то вытащите их.</p>
            ';
        }
        else {
            $query = "SELECT * FROM `classrooms`";
            $result = $MySQL -> query($query);
            $i = 0;
            while ($row = $result -> fetch_assoc()) {
                if ($row['isDelete']) {
                    Continue;
                }
                echo '
                    <div class="card" id="c-' . $i . '" style="opacity: 1;" db="' . $row['id'] . '">
                        <div class="input">
                            <input type="text" placeholder="Номер кабинета" value="' . $row['NumberOfClassroom'] . '">
                            <span></span>
                        </div>
                ';
                $sec_query = "SELECT * FROM `housings`";
                $sec_query = $MySQL -> query($sec_query);
                echo '<select class="custom-select">';
                while ($s_row = $sec_query -> fetch_assoc()) {
                    echo '<option value="' . $s_row['id'] . '" ' . ($s_row[id] == $row['idOfHousing']) ? 'selected' : '' . '>Корпус ' . $s_row['NumberOfHousing'] . ' (' . $s_row['dislocation'] . ')</option>';
                }
                echo '</select>';
                echo '
                        <input type="button" onclick="DelSomething(\'c-' . $i . '\'); del.push(' . $row['id'] . ');" value="В архив">
                    </div>
                ';
                $i++;
            }
            echo '
	            <div class="card new-card not-selected">
		            <span></span>
		            <p>Добавить ещё один кабинет</p>
	            </div>
                <div class="not-selected img-sub">
                    <div class="not-selected img"></div>
                </div>
            ';
        }

        echo '
                </div>
            </html>
        ';

        $MySQL -> close();
    }
    else {
        echo '<script type="text/javascript">document.location = \'/\'</script>';
    }
?>