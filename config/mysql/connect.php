<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/config/mysql/const.php');
    $MySQL = new mysqli(MySQL_HOST, MySQL_LOGIN, MySQL_PASSWORD, MySQL_DB);

    $MySQL -> set_charset("utf8");
    $MySQL -> query("SET NAMES 'utf8'");
    $MySQL -> query("SET CHARACTER SET 'utf8'");
    $MySQL -> query("SET SESSION collation_connection = 'utf8_general_ci'");
?>