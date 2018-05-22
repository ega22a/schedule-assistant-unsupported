function SaveSettings(num) {
    switch (num) {
        case 1:
            if (document.getElementById('manager-settings-login').value == '') {
                GetMessage(3, 'Чтобы изменить логин, введите его!');
            }
            else if (document.getElementById('manager-settings-login').value != document.getElementById('manager-settings-second-login').value) {
                GetMessage(3, 'Логины не совпадают!');
            }
            else {
                $.post(
                    'actions/save.php',
                    {
                        'type': 1,
                        'data': document.getElementById('manager-settings-login').value
                    },
                    function(data) {
                        GetMessage(1, 'Логин успешно изменен!');
                    }
                );
            }
        break;
        case 2:
            if (document.getElementById('manager-settings-password').value == '') {
                GetMessage(3, 'Чтобы изменить пароль, введите его!');
            }
            else if (document.getElementById('manager-settings-password').value != document.getElementById('manager-settings-second-password').value) {
                GetMessage(3, 'Пароли не совпадают!');
            }
            else {
                $.post(
                    'actions/save.php',
                    {
                        'type': 2,
                        'data': document.getElementById('manager-settings-password').value
                    },
                    function(data) {
                        GetMessage(1, 'Пароль успешно изменен!');
                    }
                );
            }
        break;
        case 3:
            if (document.getElementById('systems-settings-admin').value == '') {
                GetMessage(3, 'Чтобы изменить имя методиста, введите его имя!');
            }
            else {
                $.post(
                    'actions/save.php',
                    {
                        'type': 3,
                        'data': document.getElementById('systems-settings-admin').value
                    },
                    function(data) {
                        GetMessage(1, 'Имя успешно изменено!');
                    }
                );
            }
        break;
        case 4:
            if (document.getElementById('systems-settings-school').value == '') {
                GetMessage(3, 'Чтобы изменить наименование учебного заведения, введите его имя!');
            }
            else {
                $.post(
                    'actions/save.php',
                    {
                        'type': 4,
                        'data': document.getElementById('systems-settings-school').value
                    },
                    function(data) {
                        GetMessage(1, 'Наименование успешно изменено!');
                    }
                );
            }
        break;
    }
}