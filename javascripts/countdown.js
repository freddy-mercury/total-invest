function countdown(id, from, to) {
	var diff = to - from;
	var days = Math.floor(diff/(3600*24)); //days
	var hours = Math.floor((diff-days*3600*24)/3600); //hours
	var minutes = Math.floor((diff-days*86400-hours*3600)/60); //minutes
	var seconds = diff-days*86400-hours*3600-minutes*60;
	if (days+hours+minutes+seconds==0) {
		document.getElementById(id).style.color = 'red';
		document.getElementById(id).innerHTML = '<span>Check your statistics!</span>';
		location.reload();
	}
	else {
		if (hours<10) hours = '0'+hours;
		if (minutes<10) minutes = '0'+minutes;
		if (seconds<10) seconds = '0'+seconds;
		document.getElementById(id).innerHTML = '<span>Next earning in '+days+'d '+hours+':'+minutes+':'+seconds+'</span>';
	}
	from++;
	setTimeout("countdown('"+id+"', "+from+","+to+")", 1000);
}
