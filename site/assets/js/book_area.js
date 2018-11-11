$(document).ready(function(){
$(".btn-book").click(function() {
	var aarea_id = document.getElementById("input-area").value;
	var job_type_id = document.getElementById("input-job-type").value;
	var begin = document.getElementById("input-begin").value;
	var end = document.getElementById("input-end").value;
		
	jQuery.ajax({
	type: "POST",
	url: "book_area.php",
	data: {area_id : aarea_id, begin_dt : begin, end_dt : end, job : job_type_id},
	success: function(responce) {
		alert('Забронировано!'); 
		window.location.reload();
	}
	});
});
});
