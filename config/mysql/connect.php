<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/config/mysql/const.php');
    $MySQL = new mysqli(MySQL_HOST, MySQL_LOGIN, MySQL_PASSWORD, MySQL_DB);
?>