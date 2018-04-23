<?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/mysql/const.php')) {
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/auth/auto-auth.php');
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/head.phtml');
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/body.phtml');
    }
    else {
        header('Location: queries/first-launch');
    }
?>