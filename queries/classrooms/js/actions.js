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
            card.innerHTML = '<div class="input"><input type="text" placeholder="Номер кабинета"><span></span></div>';
            $.post (
                '../actions/get.housings.select.php',
                {},
                function (data) {
                    card.innerHTML += data + '<input type="button" onclick="DelSomething(\'' + card.id + '\');" value="Удалить">';
                }
            )
        }
        else {
            card.innerHTML = '<div class="input"><input type="text" placeholder="Номер кабинета"><span></span></div>';
            $.post (
                '../actions/get.housings.select.php',
                {},
                function (data) {
                    card.innerHTML += data + '<input type="button" onclick="DelSomething(\'' + 'c-' + q + '-' + i + '\');" value="Удалить">';
                }
            )
        }
        $.when($('.new-card').before(card))
            .done(function(){
                $(card).animate({"opacity": "1"}, "fast");
            })
    })
})

function PushInDB() {
    var pushArr = [];
    for (var i = 0; i < document.getElementsByClassName('card').length - 1; i++) {
        var thumbArray = [];
		if (document.getElementsByClassName('card')[i].children[0].children[0].value.trim() == '') {
			GetMessage(2, "Некоторые поля не были заполнены.");
			return false;
		}
		else {
            thumbArray[0] = document.getElementsByClassName('card')[i].children[0].children[0].value.trim();
            for (j = 1; j < document.getElementsByClassName('card')[i].children[1].children[0].children.length; j++) {
                if (document.getElementsByClassName('card')[i].children[1].children[0].children[j].selected) {
                    thumbArray[1] = document.getElementsByClassName('card')[i].children[1].children[0].children[j].value;
                }
            }
            if (document.getElementsByClassName('card')[i].hasAttribute('db')) {
                thumbArray[2] = parseInt(document.getElementsByClassName('card')[i].getAttribute('db'));
            }
	    }
    pushArr[i] = thumbArray;
    }
    $.post(
        '../actions/push.php',
        {
            'classrooms': pushArr,
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
            'classrooms': ret
        },
        function() {
            GetMessage(1, 'Некоторые записи были возвращены!');
        }
    )
}