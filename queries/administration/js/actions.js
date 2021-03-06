var del = [],
    ret = [];

$(document).ready(function(){
    $('.new-card').click(function(){
        var i = document.getElementsByClassName('card').length - 1,
            card = document.createElement('div'),
            ifExsist = false;
        card.className = 'card';
        card.id = 'c-' + i + '-' + i;
        for (var q = 0; q < i; q++) {
            if (document.getElementsByClassName('card')[q].id == 'c-' + i + '-' + i) {
                card.id = 'c-' + q + '-' + i + '-' + q;
                ifExsist = true;
            }
        }
        if (ifExsist) {
            card.innerHTML = '<div class="input"><input type="text" placeholder="Фамилия"><span></span></div><div class="input"><input type="text" placeholder="Имя"><span></span></div><div class="input"><input type="text" placeholder="Отчество"><span></span></div><div class="input"><input type="text" placeholder="Должность"><span></span></div><input type="button" onclick="DelSomething(\'' + card.id + '\');" value="Удалить">';
        }
        else {
            card.innerHTML = '<div class="input"><input type="text" placeholder="Фамилия"><span></span></div><div class="input"><input type="text" placeholder="Имя"><span></span></div><div class="input"><input type="text" placeholder="Отчество"><span></span></div><div class="input"><input type="text" placeholder="Должность"><span></span></div><input type="button" onclick="DelSomething(\'c-' + i + '-' + i + '\');" value="Удалить">';
        }
        $('.new-card').before(card);
        $(card).animate({"opacity": "1"}, "fast");
    })
})

function PushInDB() {
    var pushArr = [];
    for (var i = 0; i < document.getElementsByClassName('card').length - 1; i++) {
        var thumbArray = [];
        for (var j = 0; j < 4; j++) {
			if (document.getElementsByClassName('card')[i].children[j].children[0].value.trim() == '') {
				GetMessage(2, "Некоторые поля не были заполнены.");
				return false;
			}
			else {
                thumbArray[j] = document.getElementsByClassName('card')[i].children[j].children[0].value.trim();
                if (document.getElementsByClassName('card')[i].hasAttribute('db')) {
                    thumbArray[4] = parseInt(document.getElementsByClassName('card')[i].getAttribute('db'));
                }
	        }
        }
        pushArr[i] = thumbArray;
    }
    console.log(pushArr);
    $.post(
        '../actions/push.php',
        {
            'administration': pushArr,
            'del-id': del
        },
        function() {
            GetMessage(1, 'Записи успешно внесены!');
        }
    )
}

function ReturnOutDB() {
    $.post(
        '../actions/return.php',
        {
            'administration': ret
        },
        function() {
            GetMessage(1, 'Некоторые записи были возвращены!');
        }
    )
}