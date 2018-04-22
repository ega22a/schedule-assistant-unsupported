<?php
    echo '
    <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="../../../css/main-style.css?' . time() . '">
            <link rel="stylesheet" href="../../../css/index-style.css?' . time() . '">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="../../../js/fingerprint2.js?' . time() . '"></script>
            <script src="js/action.js?' . time() . '"></script>
            <title>Ассистент/Расписание | Главная страница</title>
        </head>
    <body>
        <div class="modal" style="display: block; opacity: 1;">
            <div class="m-body">
                <form>
                    <p>В целях Вашей безопасности, введите пароль.</p>
                    <span></span>
                    <div class="input">
                        <input type="password" id="password" placeholder="Пароль">
                        <span></span>
                    </div>
                    <a href="#" class="link">Забыли пароль</a>
                    <input type="button" value="Войти" onclick="Check();">
                </form>
            </div>
        </div>
        </body>
        ';
?>