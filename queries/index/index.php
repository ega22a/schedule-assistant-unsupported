<?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/MySQL/const.php')) {
        header("HTTP/1.0 403 Forbidden");
        exit();
    }
    else {
        include($_SERVER['DOCUMENT_ROOT'] . '/queries/first-launch/actions/forms/firstForm.phtml');
    }
?>