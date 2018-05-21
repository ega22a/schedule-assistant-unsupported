<?php
    /* Коды на вызов модальных окон:
        1 - авторизационное окно;
        2 - окно выбора даты.
    */
    $mNumber = $_POST['mNumber'];

    require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    switch ($mNumber) {
        case 1:
            echo '
                <div class="m-body">
                    <form>
                        <span></span>
                        <div class="input">
                            <input type="text" id="login" placeholder="Логин">
                            <span></span>
                        </div>
                        <div class="input">
                            <input type="password" id="password" placeholder="Пароль">
                            <span></span>
                        </div>
                        <a href="#" class="link">Забыли пароль</a>
                        <input type="submit" value="Войти" onclick="Auth(false);">
                    </form>
                </div>
                <div class="close-modal" onclick="Modal(2);"></div>
            ';
        break;
        case 2:
        require_once $_SERVER['DOCUMENT_ROOT'] . '/queries/Mobile-Detect-2.8.31/Mobile_Detect.php';
        $detect = new Mobile_Detect;
        $str = '';
        if (!$detect -> isMobile()) {
            $str = 'style="display: inline-block; margin: 30px 0 0 70px;"';
        }
        echo '
            <div class="m-body">
                <div class="datepicker-here date-of-select" ' . $str . '></div>
            </div>
            <div class="close-modal" onclick="Modal(2);"></div>
    ';
        break;
        case 3:
            $query = "SELECT * FROM `groups` ORDER BY `idOfHousing` ASC";
            $query = $MySQL -> query($query);
            echo '
                <div class="m-body">
                    <div class="mdl-selectfield">
                        <select onchange="FinishSelect();">
                            <option disabled selected>Выберите группу</option>
            ';
            while ($row = $query -> fetch_assoc()) {
                if (!$row['isDelete']) {
                    echo '<option value=\'' . $row['id'] . '\'>' . $row['name'] . '</option>';
                }
            }
            echo '
                        </select>
                    </div>
                </div>
                <div class="close-modal" onclick="Modal(2);"></div>
            ';
        break;
        case 4:
            $query = "SELECT * FROM `teachers` ORDER BY `lastName` ASC";
            $query = $MySQL -> query($query);
            echo '
                <div class="m-body">
                    <div class="mdl-selectfield">
                        <select onchange="FinishSelect();">
                            <option disabled selected>Выберите преподавателя</option>
            ';
            while ($row = $query -> fetch_assoc()) {
                if (!$row['isDelete']) {
                    echo '<option value=\'' . $row['id'] . '\'>' . $row['lastName'] . ' ' . $row['firstName'] . ' ' . $row['middleName'] . '</option>';
                }
            }
            echo '
                        </select>
                    </div>
                </div>
                <div class="close-modal" onclick="Modal(2);"></div>
            ';
        break;
        case 5:
            $query = "SELECT * FROM `housings`";
            $query = $MySQL -> query($query);
            echo '
                <div class="m-body">
                    <div class="mdl-selectfield">
                        <select onchange="FinishSelect();">
                            <option disabled selected>Выберите корпус</option>
            ';
            while ($row = $query -> fetch_assoc()) {
                echo '<option value=\'' . $row['id'] . '\'>Корпус ' . $row['numberOfHousing'] . ' (' . $row['dislocation'] . ')</option>';
            }
            echo '
                        </select>
                    </div>
                </div>
                <div class="close-modal" onclick="Modal(2);"></div>
            ';
        break;
    }


    $MySQL -> close();
?>