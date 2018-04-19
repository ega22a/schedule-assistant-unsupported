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