<?php
    if (file_exists('config/MySQL/const.php')) {
        echo 'File exsist!';
    }
    else {
        header('Location: queries/first-launch');
    }
?>