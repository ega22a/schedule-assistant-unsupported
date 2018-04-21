<?php
    /*
        Коды отвера errno:
            0 - пользователь не найден;
            2 - пользователь найден, пароль верен.
    */
    // Представление страницы, как JSON-объект
    header('Content-Type: application/json');

    // Объявление массива, в котором будет собираться ответ
    $answer = [];

    // Объявляем авторизационные переменные
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fingerprint = $_POST['fingerprint'];

    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    // Выполняем запрос на поиск контент-менеджера, формируем ответ в виде массива
    $query = "SELECT * FROM `managers` WHERE `manager_login` = '$login'";
    $result = $MySQL -> query($query);
    $result = $result -> fetch_array(MYSQLI_ASSOC);

    if (!empty($result)) {
        // Если нашли пользователя, то сверяем пароль
        if (password_verify($password, $result['manager_password'])) {
            // Если пароль совпал, то проверяем, есть ли отпечатки браузера в ячейке
            if (empty($result['fingerprints'])) {
                // Если пусты, то авторизируем пользователя, записываем отпечаток браузера в БД
                $query = "UPDATE `managers` SET `fingerprints` = '$fingerprint;' WHERE `managers`.`manager_login` = '$login'";
                $MySQL -> query($query);
                setcookie('digest', $result['manager_digest'], time() + 31557600, "/");
                $answer['errno'] = 2;
            }
            else {
                // Если поле fingerprints в БД не пусто, то сверяем с полученым отпечатком
                $fingerprints = explode(';', $result['fingerprints']);
                $fingerprintExsist = FALSE;
                foreach ($fingerprints as $value) {
                    if ($value == $fingerprint) {
                        // Если отпечаток есть, переключаем триггер
                        $fingerprintExsist = TRUE;
                    }
                }
                if ($fingerprintExsist) {
                    // Если отпечаток есть в БД, то авторизируем пользователя
                    setcookie('digest', $result['manager_digest'], time() + 31557600, "/");
                    $answer['errno'] = 2;
                }
                else {
                    // Если нет, то вносим отпечаток в список, а затем в БД, а также авторизируем пользователя
                    $result['fingerprints'] .= $fingerprint . ';';
                    $thumb = $result;
                    $query = "UPDATE `managers` SET `fingerprints` = '$thumb' WHERE `managers`.`manager_login` = '$login'";
                    $MySQL -> query($query);
                    setcookie('digest', $result['manager_digest'], time() + 31557600, "/");
                    $answer['errno'] = 2;
                }
            }
        }
        else {
            $answer['errno'] = 0;
        }
    }
    else {
        $answer['errno'] = 0;
    }

    // Закрытие сессии с БД и вывод ответа от сервера в формате JSON
    $MySQL -> close();
    echo json_encode($answer);
?>