<?php
    // Создание информационного файла о администраторе и учебном заведении
    $email = $_POST['admin_email'];
    $fname = $_POST['admin_firstName'];
    $lname = $_POST['admin_lastName'];
    $mName = $_POST['admin_middleName'];
    $sData = $_POST['school_data'];
    $sAdmin = $_POST['school_admin'];

    $ADMIN = "<?php\n\tdefine('ADMIN_EMAIL', '$email');\n\tdefine('ADMIN_FIRSTNAME', '$fname');\n\tdefine('ADMIN_LASTNAME', '$lname');\n\tdefine('ADMIN_MIDDLENAME', '$mName');\n?>";
    $ADMIN_FILE = fopen($_SERVER['DOCUMENT_ROOT'] . '/config/admin.php', 'w');
    fwrite($ADMIN_FILE, $ADMIN);
    fclose($ADMIN_FILE);
    $SCHOOL = "<?php\n\tdefine('SCHOOL_NAME', '$sData');\n\tdefine('SCHOOL_ADMIN', '$sAdmin');\n?>";
    $S_FILE = fopen($_SERVER['DOCUMENT_ROOT'] . '/config/school.php', 'w');
    fwrite($S_FILE, $SCHOOL);
    fclose($S_FILE);
?>