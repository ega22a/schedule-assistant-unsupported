<?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/mysql/const.php')) {
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

        include ('nouns.php');
        
        $manager_login = RandStr(1, 5);
        $manager_password = RandStr(2, 10);
        $manager_secret_word = [$nouns[random_int(0, count($nouns) - 1)], $nouns[random_int(0, count($nouns) - 1)], $nouns[random_int(0, count($nouns) - 1)]];
        $manager_digest = hash("sha256", RandStr(1, 125));
        
        // Заполнение данных на отдачу в форму, а также запись в БД
        $answer += [
            'manager_login' => $manager_login,
            'manager_password' => $manager_password,
            'manager_secret_word_1' => $manager_secret_word[0],
            'manager_secret_word_2' => $manager_secret_word[1],
            'manager_secret_word_3' => $manager_secret_word[2]
        ];
        
        // Шифрование логина и кодовых слов
        $manager_password = password_hash($manager_password, PASSWORD_DEFAULT);
        $manager_secret_word = [
            hash("sha256", $manager_secret_word[0]),
            hash("sha256", $manager_secret_word[1]),
            hash("sha256", $manager_secret_word[2])
        ];

        // Компоновка SQL-запроса на создание таблиц в БД
        $query = "
            CREATE TABLE `$name`.`teachers` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `firstName` TEXT NOT NULL,
                `lastName` TEXT NOT NULL,
                `middleName` TEXT,
                `isDelete` BOOLEAN NOT NULL,
                PRIMARY KEY (`id`)
            );
            CREATE TABLE `$name`.`disciplines` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `shortName` TEXT NOT NULL,
                `fullName` TEXT NOT NULL,
                `isDelete` BOOLEAN NOT NULL,
                PRIMARY KEY (`id`)
            );
            CREATE TABLE `$name`.`housings` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `dislocation` TEXT NOT NULL,
                `numberOfHousing` TEXT NOT NULL,
                `isDelete` BOOLEAN NOT NULL,
                PRIMARY KEY (`id`)
            );
            CREATE TABLE `$name`.`groups` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `name` TEXT NOT NULL,
                `idOfHousing` INT NOT NULL,
                `isDelete` BOOLEAN NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfHousing) REFERENCES housings(id)
            ); 
            CREATE TABLE `$name`.`classrooms` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfHousing` INT NOT NULL,
                `NumberOfClassroom` TEXT NOT NULL,
                `isDelete` BOOLEAN NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfHousing) REFERENCES housings(id)
            );
            CREATE TABLE `$name`.`mLessons0` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mLessons1` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mLessons2` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mLessons3` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mLessons4` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mLessons5` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`mLessons6` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sLessons0` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sLessons1` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sLessons2` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sLessons3` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sLessons4` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sLessons5` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfTeacher` INT NOT NULL,
                `idOfDiscipline` INT NOT NULL,
                `idOfClassroom` INT NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfTeacher) REFERENCES teachers(id),
                FOREIGN KEY (idOfDiscipline) REFERENCES disciplines(id),
                FOREIGN KEY (idOfClassroom) REFERENCES classrooms(id)
            );
            CREATE TABLE `$name`.`sLessons6` (
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
                `idOfGroup` INT NOT NULL,
                `dateOfSchedule` DATE NOT NULL,
                `lesson0` INT,
                `lesson1` INT,
                `lesson2` INT,
                `lesson3` INT,
                `lesson4` INT,
                `lesson5` INT,
                `lesson6` INT,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfGroup) REFERENCES groups(id),
                FOREIGN KEY (lesson0) REFERENCES mLessons0(id),
                FOREIGN KEY (lesson1) REFERENCES mLessons1(id),
                FOREIGN KEY (lesson2) REFERENCES mLessons2(id),
                FOREIGN KEY (lesson3) REFERENCES mLessons3(id),
                FOREIGN KEY (lesson4) REFERENCES mLessons4(id),
                FOREIGN KEY (lesson5) REFERENCES mLessons5(id),
                FOREIGN KEY (lesson6) REFERENCES mLessons6(id)
            );
            CREATE TABLE `$name`.`sSchedule` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `idOfGroup` INT NOT NULL,
                `dateOfSchedule` DATE NOT NULL,
                `countOfChanges` INT NOT NULL,
                `lesson0` INT,
                `lesson1` INT,
                `lesson2` INT,
                `lesson3` INT,
                `lesson4` INT,
                `lesson5` INT,
                `lesson6` INT,
                PRIMARY KEY (`id`),
                FOREIGN KEY (idOfGroup) REFERENCES groups(id),
                FOREIGN KEY (lesson0) REFERENCES sLessons0(id),
                FOREIGN KEY (lesson1) REFERENCES sLessons1(id),
                FOREIGN KEY (lesson2) REFERENCES sLessons2(id),
                FOREIGN KEY (lesson3) REFERENCES sLessons3(id),
                FOREIGN KEY (lesson4) REFERENCES sLessons4(id),
                FOREIGN KEY (lesson5) REFERENCES sLessons5(id),
                FOREIGN KEY (lesson6) REFERENCES sLessons6(id)
            );
            CREATE TABLE `$name`.`managers` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `manager_login` TEXT NOT NULL,
                `manager_password` TEXT NOT NULL,
                `manager_digest` TEXT NOT NULL,
                `secret_word_1` TEXT NOT NULL,
                `secret_word_2` TEXT NOT NULL,
                `secret_word_3` TEXT NOT NULL,
                `fingerprints` TEXT,
                `email` TEXT,
                PRIMARY KEY (`id`)
            );
            CREATE TABLE `$name`.`administration` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `firstName` TEXT NOT NULL,
                `lastName` TEXT NOT NULL,
                `middleName` TEXT,
                `position` TEXT NOT NULL,
                `isDelete` BOOLEAN NOT NULL,
                PRIMARY KEY (`id`)
            );
            INSERT INTO `managers` (
                `manager_login`,
                `manager_password`,
                `manager_digest`,
                `secret_word_1`,
                `secret_word_2`,
                `secret_word_3`,
                `fingerprints`,
                `email`
            )
            VALUES (
                '$manager_login',
                '$manager_password',
                '$manager_digest',
                '$manager_secret_word[0]',
                '$manager_secret_word[1]',
                '$manager_secret_word[2]',
                NULL,
                NULL
            );
        ";
        
        // Выполняем SQL-запрос
        $mysqli -> multi_query($query);

        // Создание конфигурирующего файла для работы с БД
        $MySQL_CONF = "<?php\n\tdefine('MySQL_LOGIN', '$login');\n\tdefine('MySQL_PASSWORD', '$pass');\n\tdefine('MySQL_HOST', '$host');\n\tdefine('MySQL_DB', '$name');\n?>";
        $MySQL_CONF_FILE = fopen($_SERVER['DOCUMENT_ROOT'] . '/config/mysql/const.php', 'w');
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