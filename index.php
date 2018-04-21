<?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/mysql/const.php')) {
        echo '<!DOCTYPE html><html lang="ru">';
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/head.phtml');
        include ($_SERVER['DOCUMENT_ROOT'] . '/queries/index/body.phtml');
        echo '</html>';
    }
    else {
        header('Location: queries/first-launch');
    }
?>