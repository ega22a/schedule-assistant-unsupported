<?php
    if (file_exists('../../../../config/MySQL/const.php')) {
        header("HTTP/1.0 403 Forbidden");
        exit();
    }
    
    // Представление страницы, как JSON-объект
    header('Content-Type: application/json');

    // Объявление переменных из POST-запроса
    $login = $_POST['DB_login'];
    $pass  = $_POST['DB_pass'];
    $name = $_POST['DB_name'];
    $host = $_POST['DB_host'];
    $charset = $_POST['DB_charset'];

    // Объявление массива, в котором будет собираться ответ
    $answer = [];

    // Попытка подключения к БД
    $mysqli = new mysqli($host, $login, $pass, $name);

    // Проверка правильности ввода логина, пароля и имени БД
    if (!($mysqli -> connect_error)) {
        $answer['errno'] = $mysqli -> connect_errno;

        // Объявляем функцию для генерации криптографических устойчивых данных, а также генерация логина, пароля и кодового слова
        function RandStr($level, $max) {
            $alphabet = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        
            switch ($level) {
                // Генерирование строки с цифрами и буквами
                case 1:
                    $str = '';
        
                    for ($i = 0; $i < $max; $i++) {
                        $str .= $alphabet[random_int(0, count($alphabet) - 1)];
                    }
                break;
                // Генерирование строки только с цифрами
                case 2:
                    $str = '';
        
                    for ($i = 0; $i < $max; $i++) {
                        $str .= random_int(0, 9);
                    }
                break;
            }
            return $str;
        }
        
        $manager_login = RandStr(1, 5);
        $manager_password = RandStr(2, 10);
        $manager_secret_word = RandStr(1, 25);
        $manager_digest = hash("sha256", RandStr(1, 125));
        
        // Заполнение данных на отдачу в форму, а также запись в БД
        $answer += [
            'manager_login' => $manager_login,
            'manager_password' => $manager_password,
            'manager_secret_word' => $manager_secret_word
        ];
        
        // Шифрование логина и кодового слова
        $manager_password = password_hash($manager_password, PASSWORD_DEFAULT);
        $manager_secret_word = password_hash($manager_secret_word, PASSWORD_DEFAULT);

        // Компоновка SQL-запроса на создание таблиц в БД
        $query = "
            CREATE TABLE `$name`.`teachers` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `firstName` TEXT NOT NULL,
                `lastName` TEXT NOT NULL,
                `middleName` TEXT NOT NULL, 
                PRIMARY KEY (`id`)
            );
            CREATE TABLE `$name`.`disciplines` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `shortName` TEXT NOT NULL,
                `fullName` TEXT NOT NULL,
                PRIMARY KEY (`id`)
            );
            CREATE TABLE `$name`.`housings` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `dislocation` TEXT NOT NULL,
                `numberOfHousing` TEXT NOT NULL,
                PRIMARY KEY (`id`)
            );
            CREATE TABLE `$name`.`groups` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` TEXT NOT NULL,
                PRIMARY KEY (`id`)
            ); 
            CREATE TABLE `$name`.`classrooms` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfHousing` INT NOT NULL,
                `NumberOfClassroom` TEXT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfHousing) REFERENCES housings(id)
            );
            CREATE TABLE `$name`.`mFirstLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mSecondLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mThirdLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mFourthLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mFifthLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mSixthLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mSeventhLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sFirstLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sSecondLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sThirdLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sFourthLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sFifthLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sSixthLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sSeventhLessons` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mSchedule` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `first` INT NOT NULL,
                `second` INT NOT NULL,
                `third` INT NOT NULL,
                `fourth` INT NOT NULL,
                `fifth` INT NOT NULL,
                `sixth` INT NOT NULL,
                `seventh` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (first) REFERENCES mFirstLessons(id),
                FOREIGN KEY (second) REFERENCES mSecondLessons(id),
                FOREIGN KEY (third) REFERENCES mThirdLessons(id),
                FOREIGN KEY (fourth) REFERENCES mFourthLessons(id),
                FOREIGN KEY (sixth) REFERENCES mSixthLessons(id),
                FOREIGN KEY (seventh) REFERENCES mSeventhLessons(id)
            );
            CREATE TABLE `$name`.`sSchedule` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `first` INT NOT NULL,
                `second` INT NOT NULL,
                `third` INT NOT NULL,
                `fourth` INT NOT NULL,
                `fifth` INT NOT NULL,
                `sixth` INT NOT NULL,
                `seventh` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (first) REFERENCES sFirstLessons(id),
                FOREIGN KEY (second) REFERENCES sSecondLessons(id),
                FOREIGN KEY (third) REFERENCES sThirdLessons(id),
                FOREIGN KEY (fourth) REFERENCES sFourthLessons(id),
                FOREIGN KEY (sixth) REFERENCES sSixthLessons(id),
                FOREIGN KEY (seventh) REFERENCES sSeventhLessons(id)
            );
            CREATE TABLE `$name`.`managers` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `manager_login` TEXT NOT NULL,
                `manager_password` TEXT NOT NULL,
                `manager_digest` TEXT NOT NULL,
                `secret_word` TEXT NOT NULL,
                `email` TEXT,
                PRIMARY KEY (`id`)
            );
            INSERT INTO `managers` (
                `manager_login`,
                `manager_password`,
                `manager_digest`,
                `secret_word`,
                `email`
            )
            VALUES (
                '$manager_login',
                '$manager_password',
                '$manager_digest',
                '$manager_secret_word',
                NULL
            );
        ";
        
        // Выполняем SQL-запрос
        $mysqli -> multi_query($query);

        // Создание конфигурирующего файла для работы с БД
        $MySQL_CONF = "<?php\n\tdefine('MySQL_LOGIN', '$login');\n\tdefine('MySQL_PASSWORD', '$pass');\n\tdefine('MySQL_HOST', '$host');\n\tdefine('MySQL_DB', '$name');\n?>";
        $MySQL_CONF_FILE = fopen('../../../config/MySQL/const.php', 'w');
        fwrite($MySQL_CONF_FILE, $MySQL_CONF);
        fclose($MySQL_CONF_FILE);

    }
    else {
        $answer['errno'] = $mysqli -> connect_errno;
    }

    // закрытие сессии с БД и вывод ответа от сервера в формате JSON
    $mysqli -> close();
    echo json_encode($answer);
?>