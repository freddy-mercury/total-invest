function check_length(id, length) {
	if (document.getElementById(id).value.length > length) {
		document.getElementById(id).value = document.getElementById(id).value.substr(0, length);
	}
}
function calc(v, plan_id) {
	if (v <= parseInt(document.getElementById('max'+plan_id).value) && v >= parseInt(document.getElementById('min'+plan_id).value)) {
		var stamp = new Date();
		var count = 
(document.getElementById('term'+plan_id).value*86400/(document.getElementById('periodicy'+plan_id).value*document.getElementById('periodicy_value'+plan_id).value));
		var step = (document.getElementById('periodicy'+plan_id).value*document.getElementById('periodicy_value'+plan_id).value);
		if (document.getElementById('working_days'+plan_id).value == '1' && document.getElementById('percent_per'+plan_id).value == 'periodicity') {
			for (i=0;i<count;i++) {
				var st = stamp.toString();
				var dw = stamp.getDay();
				if (dw==6 || dw==0) {
					count--;
				}
				stamp.setSeconds( stamp.getSeconds() + step);
			}
		}
		if (document.getElementById('percent_per'+plan_id).value == 'term') {
			document.getElementById('calc'+plan_id).innerHTML = '$ ' + 
(parseFloat(v)*(document.getElementById('percent'+plan_id).value/100/(document.getElementById('term'+plan_id).value*86400/step))*count).toFixed(2);
		}
		else if (document.getElementById('percent_per'+plan_id).value == 'periodicity') {
			document.getElementById('calc'+plan_id).innerHTML = '$ ' + 
(parseFloat(v)+parseFloat(v)*(document.getElementById('percent'+plan_id).value/100)*count).toFixed(2);
		}
	}
	else document.getElementById('calc'+plan_id).innerHTML='$ 0';
}
var Signup = {
	CheckLogin: function(input_id) {
                $.get("/includes/inlines/check_login.php", { login: $(input_id).val() },
                   function(data){
                     $('#span_login').html(data);
                   });
	}
};
var Chat = {
	Send: function(text) {
		$.post('/includes/inlines/chat.php', { text: $('#chat_input').val() }, function(data) {
  			$('#chat_text').html(data);
		});
		$('#chat_input').val('');
	},
	Refresh: function() {
		$.post('/includes/inlines/chat.php', function(data) {
  			$('#chat_text').html(data);
		});
	}
};
