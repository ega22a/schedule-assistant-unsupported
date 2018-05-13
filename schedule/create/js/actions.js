var id = [],
    it = [],
    ir = [];

$(document).ready(function(){
    var disabledDays = [0];

    $('.datepicker-here').datepicker({
        onRenderCell: function (date, cellType) {
            if (cellType == 'day') {
                var day = date.getDay(),
                    isDisabled = disabledDays.indexOf(day) != -1;
    
                return {
                    disabled: isDisabled
                }
            }
        }
    })

    $.post(
        'actions/get.all.php',
        {},
        function(data) {
            id = data['id'];
            it = data['it'];
            ir = data['ir'];
        }
    )

    $('input[type="text"]').keyup(function(){
        var c = 0;
        $(this).parent()[0].className = '';
        switch ($(this)[0].className) {
            case 'input-discipline':
                $(this).siblings()[0].innerHTML = '';
                for (var i = 0; i < id.length; i++) {
                    if (id[i].toUpperCase().indexOf($(this)[0].value.toUpperCase()) != -1) {
                        var li = document.createElement('li');
                        li.className = 'dynamicLi';
                        li.innerHTML = id[i];
                        $(this).siblings()[0].appendChild(li);
                        c++;
                    }
                }
                if (c != 0) {
                    $($(this).siblings()).css("display", "block");
                }
            break;
            case 'input-teacher':
                $(this).siblings()[0].innerHTML = '';
                for (var i = 0; i < it.length; i++) {
                    if (it[i].toUpperCase().indexOf($(this)[0].value.toUpperCase()) != -1) {
                        var li = document.createElement('li');
                        li.className = 'dynamicLi';
                        li.innerHTML = it[i];
                        $(this).siblings()[0].appendChild(li);
                        c++;
                    }
                }
                if (c != 0) {
                    $($(this).siblings()).css("display", "block");
                }
            break;
            case 'input-room':
                $(this).siblings()[0].innerHTML = '';
                for (var i = 0; i < ir.length; i++) {
                    if (ir[i].toUpperCase().indexOf($(this)[0].value.toUpperCase()) != -1) {
                        var li = document.createElement('li');
                        li.className = 'dynamicLi';
                        li.innerHTML = ir[i];
                        $(this).siblings()[0].appendChild(li);
                        c++;
                    }
                }
                if (c != 0) {
                    $($(this).siblings()).css("display", "block");
                }
            break;
        }
    })
    
    $('body').on('click', '.dynamicLi', function(){
        $(this).parent().siblings()[0].value = $(this)[0].innerHTML;
        $(this).parent().siblings()[0].id = $(this)[0].id;
    })
    
    $('input[type="text"]').focusout(function(){
        var t = $(this);
        setTimeout(function(){
            $(t.siblings()).css("display", "none");
            $(t).siblings()[0].innerHTML = '';
        }, 250)
    })
})

function saveSchedule() {
    var doneJSON = [],
        bigTable = document.getElementsByClassName('big-table'),
        checkMatches = false,
        checkEmptyCell = 0,
        checkAllCell = 0;

    for (var i = 0; i < bigTable.length; i++) {
        for (var j = 0; j < bigTable[i].children.length; j++) {
            for (var k = 2; k < bigTable[i].children[j].children[0].children.length; k++) {
                for (var l = 1; l < bigTable[i].children[j].children[0].children[k].children.length; l++) {
                    bigTable[i].children[j].children[0].children[k].children[l].className = '';
                    checkAllCell++;
                    if (bigTable[i].children[j].children[0].children[k].children[l].children[0].value == '') {
                        checkEmptyCell++;
                    }
                }
            }
        }
    }
    if (checkAllCell == checkEmptyCell) {
        GetMessage(3, 'Вы не можете сохранить пустое расписание!');
        return false;
    }

    for (var i = 0; i < bigTable.length; i++) {
        var housingArray = [];
        for (var j = 0; j < bigTable[i].children.length; j++) {
            var groupObj = {},
            lessonsArray = [];
            groupObj.group = bigTable[i].children[j].id;
            for (var k = 2; k < bigTable[i].children[j].children[0].children.length; k++) {
                var lessonArray = []
                    checkEmpty = 0;
                for (var l = 1; l < bigTable[i].children[j].children[0].children[k].children.length; l++) {
                    if (bigTable[i].children[j].children[0].children[k].children[l].children[0].value != '') {
                        switch (bigTable[i].children[j].children[0].children[k].children[l].children[0].className) {
                            case 'input-discipline':
                                if (id.indexOf(bigTable[i].children[j].children[0].children[k].children[l].children[0].value) == -1) {
                                    bigTable[i].children[j].children[0].children[k].children[l].className = 'error-cell';
                                    checkMatches = true;
                                }
                            break;
                            case 'input-teacher':
                                if (it.indexOf(bigTable[i].children[j].children[0].children[k].children[l].children[0].value) == -1) {
                                    bigTable[i].children[j].children[0].children[k].children[l].className = 'error-cell';
                                    checkMatches = true;
                                }
                            break;
                            case 'input-room':
                                if (ir.indexOf(bigTable[i].children[j].children[0].children[k].children[l].children[0].value) == -1) {
                                    bigTable[i].children[j].children[0].children[k].children[l].className = 'error-cell';
                                    checkMatches = true;
                                }
                            break;
                        }
                    }
                    else {
                        checkEmpty++;
                    }
                    lessonArray.push(bigTable[i].children[j].children[0].children[k].children[l].children[0].value);
                }
                if (checkEmpty < 3 && checkEmpty != 0) {
                    GetMessage(3, 'Некоторая пара заполнена некорректно!');
                    for (var l = 1; l < bigTable[i].children[j].children[0].children[k].children.length; l++) {
                        bigTable[i].children[j].children[0].children[k].children[l].className = 'error-cell';
                    }
                    return false;
                }
                checkEmpty = 0;
                lessonsArray.push(lessonArray);
            }
            groupObj.lessons = lessonsArray;
            housingArray.push(groupObj);
        }
        doneJSON.push(housingArray);
    }
    if (checkMatches) {
        GetMessage(3, 'В выделенных ячейках присутсвтуют несовпадения!');
    }
    else {
        if (document.getElementsByClassName('datepicker-here')[0].value != '') {
            $.post(
                'actions/create.php',
                {
                    'date': document.getElementsByClassName('datepicker-here')[0].value,
                    'schedule': JSON.stringify(doneJSON)
                },
                function(data) {
                    switch (data['errno']) {
                        case 0:
                            if (confirm('Расписание на' + document.getElementsByClassName('datepicker-here')[0].value + 'число уже существует. Вы хотите сохранить расписание как изменение?')) {
                                $.post(
                                    'actions/create.php',
                                    {
                                        'date': document.getElementsByClassName('datepicker-here')[0].value,
                                        'schedule': JSON.stringify(doneJSON),
                                        'agree': true
                                    }
                                ),
                                function(s_data) {
                                    switch (s_data['errno']) {
                                        case 10:
                                            GetMessage(1, 'Расписание успешно сохранено!');
                                        break;
                                    }
                                }
                            }
                        break;
                        case 10:
                            GetMessage(1, 'Расписание успешно сохранено!');
                        break;
                    }
                }
            )
        }
        else {
            GetMessage(3, 'Выберите дату расписания!');
        }
    }
}