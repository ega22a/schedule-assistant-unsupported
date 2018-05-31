<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/settings/actions/head.phtml');
        echo '
            <div class="modal"></div>
            <div class="workspace">';
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/h-menu.phtml');
        echo '
            </ul>
            <div class="message-box not-selected"></div>
            <h1 class="not-selected">Настройки</h1>
            <form>
                <div id="manager-settings">
                    <h2>Изменить логин</h2>
                    <div class="input">
                        <input type="text" placeholder="Введите новый логин" id="manager-settings-login">
                        <span></span>
                    </div>
                    <div class="input">
                        <input type="text" placeholder="Повторите новый логин" id="manager-settings-second-login">
                        <span></span>
                    </div>
                    <input type="button" class="not-float" onclick="SaveSettings(1);" value="Сохранить">
                    <h2>Изменить пароль</h2>
                    <div class="input">
                        <input type="password" placeholder="Введите новый пароль" id="manager-settings-password">
                        <span></span>
                    </div>
                    <div class="input">
                        <input type="password" placeholder="Повторите новый пароль" id="manager-settings-second-password">
                        <span></span>
                    </div>
                    <input type="button" class="not-float" onclick="SaveSettings(2);" value="Сохранить">
                </div>
                <div id="systems-settings">
                    <h2>Изменить имя методиста</h2>
                    <div class="input">
                        <input type="text" placeholder="Введите ФИО (Иванов И.И.)" id="systems-settings-admin">
                        <span></span>
                    </div>
                    <input type="button" class="not-float" onclick="SaveSettings(3);" value="Сохранить">
                    <h2>Изменить наименование учебного заведения</h2>
                    <div class="input">
                        <input type="text" placeholder="Новое название" id="systems-settings-school">
                        <span></span>
                    </div>
                    <input type="button" class="not-float" onclick="SaveSettings(4);" value="Сохранить">
                </div>
            </form>
        ';

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