$(document).ready(function(){
$(".btn-create-user").click(function() {
	var vkid = document.getElementById("input-vkid").value;
	var mail = document.getElementById("input-email").value;	
	var username = document.getElementById("input-first-name").value;
	var last = document.getElementById("input-last-name").value;
	var pass = document.getElementById("input-password").value;
	var birthdate = document.getElementById("input-birth").value;
	var aarea_id = document.getElementById("input-area").value;
	var timetable_id = document.getElementById("input-timetable").value;
	var post_id = document.getElementById("input-post").value;
	var cat = document.getElementById("input-cat").value;
	var sphone = document.getElementById("input-selfphone").value;
	var wphone = document.getElementById("input-workphone").value;
		
	jQuery.ajax({
	type: "POST",
	url: "create_user.php",
	data: {vk_id : vkid, email : mail, name : username, lastname : last, passw : pass, birth : birthdate, area_id : aarea_id, timetable : timetable_id, post : post_id, category : cat, selfphone : sphone, workphone : wphone},
	success: function(responce) {
		alert('Пользователь добавлен!'); 
		window.location.reload();
	}
	});
});
});
