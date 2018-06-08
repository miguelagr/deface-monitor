//<!--Ejemplo.js-->
//$(atributo o etiqueta a modificar).funcionarealizar-->
$(document).ready(function(){
	/*
	$("p").click(function(){
		$(this).hide();

	});

	//para referenciar a una etiqueta
	$("#p1").click(function(){
	$(this).hide();
	});

	$(".cl1").click(function(){
		$(this).hide();

	});	

	$("button").click(function(){
		$("p").hide(100);
	});

	$("#m").click(function(){
		$("p").hide();
	});

	$("#o").click(function(){
		$("p").show(100);
	});

	//muestra y oculta con el mismo elemento.
	$("button").click(function(){
		$("p").toggle.(10000);
	});

	$("#p1").mousecenter(function(){
		alert("Estas sobre p1");
	});

	$("#p1").mouseleave(function(){
		alert("Saliste de p1");
	});

	$("cl1").hover(function(){
		alert("Estas sobre cl1");
	},function(){
		alert("Saliste de cl1");
	});
	*/

	$("button").click(function(){
		var d1 = $("#d1");
		d1.fadeToggle(3000);
		//$("#d1").fadeToggle(100);
		$("#d2").fadeToggle(10000);
		$("#d3").fadeToggle();
	});

	$("#id").click(function(){
		$("#panel").slideToggle();
		//$("#panel").fadeToggle();
		//$("#panel").sideUp();
	});
	
});