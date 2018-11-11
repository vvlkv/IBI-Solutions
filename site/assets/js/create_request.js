$(document).ready(function(){
$(".btn-create-request").click(function() {
	var tmp_req_id = this.id;
	var aarea_id = document.getElementById("input-area").value;
	var job_type_id = document.getElementById("input-job-type").value;
	var remark_txt = document.getElementById("input-remark").value;
	var cat = document.getElementById("input-cat").value;
		
	jQuery.ajax({
	type: "POST",
	url: "create_request.php",
	data: {area_id : aarea_id, category : cat, remark : remark_txt, job : job_type_id, tmp : tmp_req_id},
	success: function(responce) {
		alert('Заявка создана!'); 
		window.location.reload();
	}
	});
});
});
