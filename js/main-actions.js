var selectedType,
    selectedDate,
    selectID;

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

function Modal(closeOrOpen, type) {
    switch (closeOrOpen) {
        case 1:
            $.post(
                '/queries/index/modal.php',
                {
                    'mNumber': type
                },
                function(data) {
                    document.getElementsByClassName('modal')[0].innerHTML = data;
                    var disabledDays = [0];

                    if (type == 2) {
                        $('.date-of-select').datepicker({
                            onRenderCell: function (date, cellType) {
                                if (cellType == 'day') {
                                    var day = date.getDay(),
                                        isDisabled = disabledDays.indexOf(day) != -1;
                        
                                    return {
                                        disabled: isDisabled
                                    }
                                }
                            },
                            onSelect: function (formattedDate, date, inst) {
                                selectedDate = formattedDate;
                                switch (selectedType) {
                                    case 1:
                                        $('.modal').animate({'opacity': '0'}, 'fast', function() {
                                            $('.modal').css('display', 'none');
                                            document.getElementsByClassName('modal')[0].innerHTML = '';
                                            $.post(
                                                '/queries/index/modal.php',
                                                {
                                                    'mNumber': 3
                                                },
                                                function(data) {
                                                    document.getElementsByClassName('modal')[0].innerHTML = data;
                                                    $('.modal').css('display', 'block');
                                                    $('.modal').animate({'opacity': '1'}, 'fast');
                                                }
                                            );
                                        })
                                    break;
                                    case 2:
                                        $('.modal').animate({'opacity': '0'}, 'fast', function() {
                                            $('.modal').css('display', 'none');
                                            document.getElementsByClassName('modal')[0].innerHTML = '';
                                            $.post(
                                                '/queries/index/modal.php',
                                                {
                                                    'mNumber': 4
                                                },
                                                function(data) {
                                                    document.getElementsByClassName('modal')[0].innerHTML = data;
                                                    $('.modal').css('display', 'block');
                                                    $('.modal').animate({'opacity': '1'}, 'fast');
                                                }
                                            );
                                        })
                                    break;
                                    case 3:
                                        $('.modal').animate({'opacity': '0'}, 'fast', function() {
                                            $('.modal').css('display', 'none');
                                            document.getElementsByClassName('modal')[0].innerHTML = '';
                                            $.post(
                                                '/queries/index/modal.php',
                                                {
                                                    'mNumber': 5
                                                },
                                                function(data) {
                                                    document.getElementsByClassName('modal')[0].innerHTML = data;
                                                    $('.modal').css('display', 'block');
                                                    $('.modal').animate({'opacity': '1'}, 'fast');
                                                }
                                            );
                                        })
                                    break;
                                }
                            }
                        })
                    }
                }
            )
            $('.modal').css('display', 'block');
            $('.modal').animate({'opacity': '1'}, 'fast');
        break;
        case 2:
            $('.modal').animate({'opacity': '0'}, 'fast', function() {
                $('.modal').css('display', 'none');
                document.getElementsByClassName('modal')[0].innerHTML = '';
            })
        break;
    }
}

function FinishSelect() {
    selectID = document.getElementsByClassName('mdl-selectfield')[0].children[0].value;
    switch (selectedType) {
        case 1:
            document.location = '/schedule/view/groups/?date=' + selectedDate + '&id=' + selectID;
        break;
        case 2:
            document.location = '/schedule/view/teachers/?date=' + selectedDate + '&id=' + selectID;
        break;
        case 3:
            document.location = '/schedule/view/print/?date=' + selectedDate + '&id=' + selectID;
        break;
    }
}

function Auth(exit) {
    if (!exit) {
        var login = document.getElementById('login').value.trim(),
            password = document.getElementById('password').value.trim(),
            fingerprint = '';
        new Fingerprint2().get(function(result) {
            fingerprint = result;
        });
        setTimeout(function() {
            $.post(
                '/queries/auth/auth.php',
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
        if (confirm("Вы уверены, что Вы хотите выйти?")) {
            var date = new Date(0);
            document.cookie = "digest=; path=/; expires=" + date.toUTCString();
            location.reload();
        }
    }
}