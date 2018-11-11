$(document).ready(function(){
$(".btn-assign").click(function() {
	var request_id = this.id;
	var executer = document.getElementById("assign_val").value;
	jQuery.ajax({
	type: "POST",
	url: "assign_request.php",
	data: {req_id : request_id, executer_id : executer},
	success: function(responce) {
		alert("Заявка назначена!"); 
		window.location.reload();
	}
	});
});
});
