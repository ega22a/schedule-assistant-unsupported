<?php
    if (file_exists('config/MySQL/const.php')) {
        echo '<!DOCTYPE html><html lang="ru">';
        include ('queries/index/head.phtml');
        include ('queries/index/body.phtml');
        echo '</html>';
    }
    else {
        header('Location: queries/first-launch');
    }
?>