function Check() {
    var spl_arr = [];

    var spl = document.cookie.split('; ');
    for (var i = 0; i < spl.length; i++) {
        var sli = spl[i].split('=');
        spl_arr.push(sli);
    }

    var fingerprint = '';
    new Fingerprint2().get(function(result) {
        fingerprint = result;
    });
    setTimeout  (function(){
        $.post(
            'check.php',
            {
                'fingerprint': fingerprint,
                'password': document.getElementById('password').value.trim()
            },
            function (data) {
                if (data['loc'] != '') {
                    document.location = data['loc'];
                }
            }
        )
    }, 1000);
}