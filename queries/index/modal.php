<?php
    /* Коды на вызов модальных окон:
        1 - авторизационное окно;
        2 - окно выбора даты.
    */
    $mNumber = $_POST['mNumber'];

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

        break;
    }
?>