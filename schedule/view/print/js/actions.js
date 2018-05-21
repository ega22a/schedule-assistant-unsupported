function PrintSchedule() {
    for (i = 1; i < document.getElementsByClassName('mdl-selectfield')[0].children[0].length; i++) {
        if (document.getElementsByClassName('mdl-selectfield')[0].children[0].children[i].selected) {
            var nameOfTeacher = document.getElementsByClassName('mdl-selectfield')[0].children[0].children[i].innerHTML.split(' ');
            for (j = 0; j < document.getElementsByClassName('admin-for-housing').length; j++) {
                document.getElementsByClassName('admin-for-housing')[j].innerHTML = nameOfTeacher[1] + ' ' + nameOfTeacher[0][0] + '.' + nameOfTeacher[2][0] + '.';
            }
        }
    }
    window.print();
}