var del = [];

$(document).ready(function(){
    $('.new-teacher').click(function(){
        var i = document.getElementsByClassName('teacher-card').length - 1,
            card = document.createElement('div');
        card.className = 'teacher-card';
        card.id = 'teacher-' + i + '-' + i;
        card.innerHTML = '<div class="input"><input type="text" placeholder="Фамилия"><span></span></div><div class="input"><input type="text" placeholder="Имя"><span></span></div><div class="input"><input type="text" placeholder="Отчество"><span></span></div><input type="button" onclick="DelSomething(\'teacher-' + i + '-' + i + '\');" value="Удалить">';
        $('.new-teacher').before(card);
        $('#teacher-' + i + '-' + i).animate({"opacity": "1"}, "fast");
    })
})

function PushInDB() {
    var teacherArray = [];
    if (document.getElementsByClassName('teacher-card').length == 1) {
		GetMessage(3, "Создайте хотя-бы одного преподавателя!")
    }
    else {
        for (var i = 0; i < document.getElementsByClassName('teacher-card').length - 1; i++) {
            var thumbArray = [];
            for (var j = 0; j < 3; j++) {
				if (document.getElementsByClassName('teacher-card')[i].children[j].children[0].value.trim() == '') {
					GetMessage(2, "Некоторые поля не были заполнены.");
					return false;
				}
				else {
                    thumbArray[j] = document.getElementsByClassName('teacher-card')[i].children[j].children[0].value.trim();
                    if (document.getElementsByClassName('teacher-card')[i].hasAttribute('db')) {
                        thumbArray[3] = parseInt(document.getElementsByClassName('teacher-card')[i].getAttribute('db'));
                    }
				}
            }
            teacherArray[i] = thumbArray;
            console.log(thumbArray);
        }
        console.log(del);
        $.post(
            '../actions/push.php',
            {
                'teachers': teacherArray,
                'del-id': del
            }
        )
    }
}