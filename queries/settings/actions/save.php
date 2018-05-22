<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');

    if ($isAuth) {

        require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';
        
        $data = $_POST['data'];
        $digest = $_COOKIE['digest'];
        switch ($_POST['type']) {
            case 1:
                $MySQL -> query("UPDATE `managers` SET `manager_login` = '$data' WHERE `manager_digest` = '$digest'");
            break;
            case 2:
                $password = password_hash($data, PASSWORD_DEFAULT);
                $MySQL -> query("UPDATE `managers` SET `manager_password` = '$password' WHERE `manager_digest` = '$digest'");
            break;
            case 3:
                include($_SERVER['DOCUMENT_ROOT'] . '/config/school.php');
                $thumb = SCHOOL_NAME;
                unlink($_SERVER['DOCUMENT_ROOT'] . '/config/school.php');
                $SCHOOL = "<?php\n\tdefine('SCHOOL_NAME', '$thumb');\n\tdefine('SCHOOL_ADMIN', '$data');\n?>";
                $S_FILE = fopen($_SERVER['DOCUMENT_ROOT'] . '/config/school.php', 'w');
                fwrite($S_FILE, $SCHOOL);
                fclose($S_FILE);
            break;
            case 4:
                include($_SERVER['DOCUMENT_ROOT'] . '/config/school.php');
                $thumb = SCHOOL_ADMIN;
                unlink($_SERVER['DOCUMENT_ROOT'] . '/config/school.php');
                $SCHOOL = "<?php\n\tdefine('SCHOOL_NAME', $data);\n\tdefine('SCHOOL_ADMIN', '$thumb');\n?>";
                $S_FILE = fopen($_SERVER['DOCUMENT_ROOT'] . '/config/school.php', 'w');
                fwrite($S_FILE, $SCHOOL);
                fclose($S_FILE);
            break;
        }

        $MySQL -> close();
    }
    else {
        echo '<script type="text/javascript">document.location = \'/\'</script>';
    }
?>