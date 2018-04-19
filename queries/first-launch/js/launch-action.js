function ConnectToDB() {
	var db_login = document.getElementById('DB_login').value.trim(),
		db_pass = document.getElementById('DB_password').value.trim(),
		db_name = document.getElementById('DB_name').value.trim(),
		db_host = document.getElementById('DB_host').value.trim(),
        db_charset = document.getElementById('DB_charset').value.trim(),
        err = true;
	
	if (db_login == '' || db_pass == '' || db_name == '') {
		GetMessage(3, 'Вы не ввели логин, пароль или имя базы данных!');
		err = false;
	}
	
	if (db_host == '') {
		db_host = 'localhost';
	}
	if (db_charset == '') {
		db_charset = 'utf8';
    }
    
    if (err) {
        $.post(
            'actions/create-db-get-json.php',
            {
                'DB_login': db_login,
                'DB_pass': db_pass,
                'DB_name': db_name,
                'DB_host': db_host,
                'DB_charset': db_charset
            },
            function(data) {
                switch (data['errno']) {
                    case 1045:
                        GetMessage(3, 'Вы указали неверные данные для подключения к БД!');
                    break;
                    case 0:
                        document.getElementById('requestLogin').innerHTML = data['manager_login'];
                        document.getElementById('requestPass').innerHTML = data['manager_password'];
                        document.getElementById('requestWord_1').innerHTML = data['manager_secret_word_1'];
                        document.getElementById('requestWord_2').innerHTML = data['manager_secret_word_2'];
                        document.getElementById('requestWord_3').innerHTML = data['manager_secret_word_3'];
                        $('.absolute-message').css('display', 'block');
                        $('.absolute-message').animate({'opacity': '1'}, 'fast');
                    break;
                }
            }
        )
    }
};

function continueInstalation() {
	if (confirm("Вы уверены, что можно продолжить?")) {
		$('.absolute-message').animate({'opacity': '0'}, 'fast', function() {
            $('.absolute-message').css('display', 'none');
            $('#removeForm').animate({'opacity': '0'}, 'fast', function() {
                $('#removeForm').remove();
                var form = document.createElement('form');
                form.id = 'lastForm';
                form.style = 'opacity: 0;';
                $(form).load('actions/forms/secondForm.phtml');
                document.getElementsByClassName('workspace')[0].appendChild(form);
                $('#lastForm').animate({'opacity': '1'}, 'fast');
            });
        });
	}
}

function finishInstallation() {
    var admin_email = document.getElementById('admin_email').value.trim(),
        admin_firstName = document.getElementById('admin_firstName').value.trim(),
        admin_lastName = document.getElementById('admin_lastName').value.trim(),
        admin_middleName = document.getElementById('admin_middleName').value.trim(),
        err = true;

    if (admin_email == '' || admin_firstName == '' || admin_lastName == '') {
        GetMessage(3, 'Вы не ввели e-mail, имя или фамилию!');
		err = false;
    }

    if (err) {
        $.post(
            'actions/second-action.php',
            {
                "admin_email": admin_email,
                "admin_firstName": admin_firstName,
                "admin_lastName": admin_lastName,
                "admin_middleName": admin_middleName
            },
            function() {
                document.location = '../../';
            }
        )
    }
}