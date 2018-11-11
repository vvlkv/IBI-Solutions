$(document).ready(function(){
$(".btn-route").click(function() {
	var request_id = this.id;
	var container = document.getElementById("circles");
	var childMas=container.childNodes; // массив потомков
    for (var i = 0; i < childMas.length;i++ ){
	if (childMas[i].getAttribute("stroke") == "#279D3C")
	   childMas[i].setAttribute("opacity", 0);
    }
	
	var point_from = document.getElementById("input-from").value;
	var point_to = document.getElementById("input-to").value;
	
	if (((point_from.localeCompare("322") == 0) && (point_to.localeCompare("350") == 0)) || ((point_from.localeCompare("350") == 0) && (point_to.localeCompare("322") == 0))) {
		var point1 = document.getElementById("323");
		var point2 = document.getElementById("324");
		var point3 = document.getElementById("325");
		var point4 = document.getElementById("329");
		var point5 = document.getElementById("330");
		var point6 = document.getElementById("365");
		var point7 = document.getElementById("331");
		var point8 = document.getElementById("332");
		var point9 = document.getElementById("333");
		var point10 = document.getElementById("334");
		var point11 = document.getElementById("336");
		var point12 = document.getElementById("338");
		var point13 = document.getElementById("340");
		var point14 = document.getElementById("342");
		var point15 = document.getElementById("363");
		var point16 = document.getElementById("344");
		var point17 = document.getElementById("346");
		var point18 = document.getElementById("348");
		point1.setAttribute("opacity", 1);
		point2.setAttribute("opacity", 1);
		point3.setAttribute("opacity", 1);
		point4.setAttribute("opacity", 1);
		point5.setAttribute("opacity", 1);
		point6.setAttribute("opacity", 1);
		point7.setAttribute("opacity", 1);
		point8.setAttribute("opacity", 1);
		point9.setAttribute("opacity", 1);
		point10.setAttribute("opacity", 1);
		point11.setAttribute("opacity", 1);
		point12.setAttribute("opacity", 1);
		point13.setAttribute("opacity", 1);
		point14.setAttribute("opacity", 1);
		point15.setAttribute("opacity", 1);
		point16.setAttribute("opacity", 1);
		point17.setAttribute("opacity", 1);
		point18.setAttribute("opacity", 1);
	}
	
	if (((point_from.localeCompare("300") == 0) && (point_to.localeCompare("303") == 0)) || ((point_from.localeCompare("303") == 0) && (point_to.localeCompare("300") == 0))) {
		var point1 = document.getElementById("301");
		var point2 = document.getElementById("302");
		point1.setAttribute("opacity", 1);
		point2.setAttribute("opacity", 1);
	}
	
	if (((point_from.localeCompare("301") == 0) && (point_to.localeCompare("348") == 0)) || ((point_from.localeCompare("348") == 0) && (point_to.localeCompare("301") == 0))) {
		var point1 = document.getElementById("361");
		var point2 = document.getElementById("353");
		var point3 = document.getElementById("352");
		var point4 = document.getElementById("350");
		point1.setAttribute("opacity", 1);
		point2.setAttribute("opacity", 1);
		point3.setAttribute("opacity", 1);
		point4.setAttribute("opacity", 1);
	}
	
	
	var to = document.getElementById(point_to);
	var from_ = document.getElementById(point_from);

	to.setAttribute("opacity", 1);
	from_.setAttribute("opacity", 1);
});
});
