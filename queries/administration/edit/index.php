<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/administration/actions/head.phtml');
        echo '
            <div class="modal"></div>
            <div class="workspace">';
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/h-menu.phtml');
        echo '
            </ul>
            <div class="message-box not-selected"></div>
            <h1 class="not-selected">Добавить администрацию</h1>';

        // Совершаем соединение к БД
        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';
        $query = "SELECT * FROM `administration`";
        $result = $MySQL -> query($query);

        $i = 0;
        while ($row = $result -> fetch_assoc()) {
            if ($row['isDelete']) {
                Continue;
            }
            echo '
            <div class="card" id="c-' . $i . '" style="opacity: 1;" db="' . $row['id'] . '">
                <div class="input">
                    <input type="text" placeholder="Фамилия" value="' . $row['firstName'] . '">
                    <span></span>
                </div>
                <div class="input">
                    <input type="text" placeholder="Имя" value="' . $row['lastName'] . '">
                    <span></span>
                </div>
                <div class="input">
                    <input type="text" placeholder="Отчество" value="' . $row['middleName'] . '">
                    <span></span>
                </div>
                <div class="input">
                    <input type="text" placeholder="Должность" value="' . $row['position'] . '">
                    <span></span>
                </div>
                <input type="button" onclick="DelSomething(\'c-' . $i . '\'); del.push(' . $row['id'] . ');" value="В архив">
            </div>
            ';
            $i++;
        }

        $MySQL -> close();
        echo '
	        <div class="card new-card not-selected">
		        <span></span>
		        <p>Добавить ещё одного администратора</p>
	        </div>
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