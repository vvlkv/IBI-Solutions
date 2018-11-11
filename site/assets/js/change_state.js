$(document).ready(function(){
$(".btn-change-state").click(function() {
	var request_id = this.id;
	var state = document.getElementById("state_val").value;
	jQuery.ajax({
	type: "POST",
	url: "change_state.php",
	data: {req_id : request_id, state_code : state},
	success: function(responce) {
		alert("Состояние изменено!"); 
		window.location.reload();
	}
	});
});
});
