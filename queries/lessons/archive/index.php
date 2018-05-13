<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/lessons/actions/head.phtml');
        echo '
            <div class="modal"></div>
            <div class="workspace">';
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/h-menu.phtml');
        echo '
            </ul>
            <div class="message-box not-selected"></div>
            <h1 class="not-selected">Архив дисциплин</h1>';

        // Совершаем соединение к БД
        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';
        $query = "SELECT * FROM `disciplines`";
        $result = $MySQL -> query($query);

        $i = 0;
        while ($row = $result -> fetch_assoc()) {
            if ($row['isDelete']) {
                echo '
                    <div class="card" id="с-' . $i . '" style="opacity: 1;">
                        <div class="input">
                            <input type="text" readonly value="' . $row['shortName'] . '">
                            <span></span>
                        </div>
                        <div class="input">
                            <input type="text" readonly value="' . $row['fullName'] . '">
                            <span></span>
                        </div>
                        <input type="button" class="return" onclick="DelSomething(\'с-' . $i . '\');  ret.push(' . $row['id'] . ');" value="Из архива">
                    </div>
                ';
                $i++;
            }
        }

        if ($i == 0) {
            echo '<span class="wall"></span><p class="wall-text not-selected">Архив пуст...</p>';
        }

        $MySQL -> close();
        echo '
        </div>
    </html>
    ';
    }
    else {
        echo '<script type="text/javascript">document.location = \'/\'</script>';
    }
?>