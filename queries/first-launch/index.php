<?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/mysql/const.php')) {
        header("HTTP/1.0 403 Forbidden");
        exit();
    }
    else {
        for ($i = 0; $i < 256; $i++) {
            for ($j = 0; $j < 256; $j++) {
                if ($_SERVER['REMOTE_ADDR'] == '192.168.' . $i . '.' . $j || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
                    include($_SERVER['DOCUMENT_ROOT'] . '/queries/first-launch/actions/forms/firstForm.phtml');
                    Exit;
                }
            }
        }
        include($_SERVER['DOCUMENT_ROOT'] . '/queries/first-launch/actions/forms/error.phtml');
    }
?>