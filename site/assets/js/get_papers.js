$(document).ready(function(){
$(".btn-get-doc").click(function() {
	var dpid = document.getElementById("input-doc").value;
	alert(dpid); 
	jQuery.ajax({
	type: "POST",
	url:  location.href,
	data: {dp_id : dpid},
	success: function(responce) {
		alert('ыч!'); 
		window.location.reload();
	}
	});
});
});
