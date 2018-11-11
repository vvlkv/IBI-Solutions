$(document).ready(function(){
$(".btn-add-comment").click(function() {
	var request_id = this.id;
	var com_remark = document.getElementById("comment_txt").value;
	jQuery.ajax({
	type: "POST",
	url: "add_comment.php",
	data: {req_id : request_id, remark : com_remark},
	success: function(responce) {
		alert("Комментарий добавлен!"); 
		window.location.reload();
	}
	});
});
});
