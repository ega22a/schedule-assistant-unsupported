<?php
    // Создание информационного файла о администраторе
    $email = $_POST['admin_email'];
    $fname = $_POST['admin_firstName'];
    $lname = $_POST['admin_lastName'];
    $mName = $_POST['admin_middleName'];

    $ADMIN = "<?php\n\tdefine('ADMIN_EMAIL', '$email');\n\tdefine('ADMIN_FIRSTNAME', '$fname');\n\tdefine('ADMIN_LASTNAME', '$lname');\n\tdefine('ADMIN_MIDDLENAME', '$mName');\n?>";
    $ADMIN_FILE = fopen('../../../config/admin.php', 'w');
    fwrite($ADMIN_FILE, $ADMIN);
    fclose($ADMIN_FILE);
?>