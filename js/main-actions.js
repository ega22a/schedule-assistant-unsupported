$(document).ready(function(){
    var fingerprint = '';
    new Fingerprint2().get(function(result) {
        fingerprint = result;
    });
    setInterval(function(){
        $.post(
            '/queries/auth/auto-auth.php',
            {
                'fingerprint': fingerprint
            },
            function (data) {
                if (data['loc'] != '') {
                    document.location = data['loc'];
                }
            }
        )
    }, 1000);
})

function DelSomething(id, timeout) {
	setTimeout(function(){
		$('#' + id).animate({"opacity": "0"}, "fast", function(){
        	$('#' + id).remove();
    	})
	}, timeout)
}

function GetMessage(lev, str) {
	var mCount = document.getElementsByClassName('message-box')[0].children.length,
		newMessage = document.createElement('div'),
		mBox = document.getElementsByClassName('message-box')[0];
	newMessage.className ='message';
	newMessage.id = 'message-' + mCount;
	switch (lev) {
		case 1:
			newMessage.className += ' push';
			newMessage.innerHTML = '<span onclick="DelSomething(\'message-' + mCount + '\', 0)"></span><p>' + str + '</p>';
			mBox.insertBefore(newMessage, mBox.firstChild);
			$('#message-' + mCount).animate({"opacity": "1"},  'fast');
			DelSomething('message-' + mCount, 7000);
		break;
		case 2:
			newMessage.className += ' alert';
			newMessage.innerHTML = '<span onclick="DelSomething(\'message-' + mCount + '\', 0)"></span><p>' + str + '</p>';
			mBox.insertBefore(newMessage, mBox.firstChild);
			$('#message-' + mCount).animate({"opacity": "1"},  'fast');
			DelSomething('message-' + mCount, 7000);
		break;
		case 3:
			newMessage.className += ' warning';
			newMessage.innerHTML = '<span onclick="DelSomething(\'message-' + mCount + '\', 0)"></span><p>' + str + '</p>';
			mBox.insertBefore(newMessage, mBox.firstChild);
			$('#message-' + mCount).animate({"opacity": "1"},  'fast');
			DelSomething('message-' + mCount, 7000);
		break;
	}
}

function Modal(closeOrOpen) {
    switch (closeOrOpen) {
        case 1:
            $('.modal').css('display', 'block');
            $('.modal').animate({'opacity': '1'}, 'fast');
        break;
        case 2:
            $('.modal').animate({'opacity': '0'}, 'fast', function() {
                $('.modal').css('display', 'none');
            })
        break;
    }
}

function Auth(exit) {
    var login = document.getElementById('login').value.trim(),
        password = document.getElementById('password').value.trim();
    if (!exit) {
        var fingerprint = '';
        new Fingerprint2().get(function(result) {
            fingerprint = result;
        });
        setTimeout(function() {
            $.post(
                'queries/auth/auth.php',
                {
                    'login': login,
                    'password': password,
                    'fingerprint': fingerprint
    
                },
                function (data) {
                    switch (data['errno']) {
                        case 0:
                            GetMessage(3, 'Вы ввели неправильно логин или пароль!');
                        break;
                        case 2:
                            location.reload();
                        break;
                    }
                }
            )
        }, 1000)
    }
    else {

    }
}