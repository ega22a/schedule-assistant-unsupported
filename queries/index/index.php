<?php
    if (file_exists('../../config/MySQL/const.php')) {
        header("HTTP/1.0 403 Forbidden");
        exit();
    }
    else {
        include('actions/forms/firstForm.phtml');
    }
?>