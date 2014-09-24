$(document).ready(function(){

	//$("#dialog").dialog({
	//	autoOpen:false,
	//});

	//$("#addButton").click(function(){
	//	$("#dialog").dialog("open");
	//});
	
	//$("#submit").click(function(){
	//	var lineNum = $("#lineNum").val();
	//	var comment = $("textarea#comSec").val();
		
		
	//	document.getElementById("comSec").innerHTML += 
	//	"<div id='comment'><p>Line " + lineNum + " - " + comment + 
	//	"</p></div>";
		
	//	$("#dialog").dialog("close");
	//	alert("Submitted");
		
		
	//	return false;
		
	
	//});	
	
	$("#testButton").click(function(){
		//alert("works");
		var lineNum = 0;
		var plainText = $('.prettyprint').text();
		plainText = plainText.split("\n");
		var lines = $.each(plainText, function(n, elem) {
						lineNum++;
						});
						
		for (var i = 1; i <= lineNum; i++){
			document.getElementById("coms").innerHTML +=
			"<span line=\"" + i + "\" class = \"hcbutton\" ></span>";		
		
		}
		
		
		console.log(lineNum);
	
	});
		
	$("#coms").on("click", ".hcbutton", 
		function(){
			$(this).addClass('hccom').removeClass('hcbutton');
		});
		
	
							
		
	
	$(".hcbutton").click(
		function(){
			console.log("works");
			$(this).addClass('hccom').removeClass('hcbutton');
		
	});
	
	$(".hccom").click(
		function(){
		Console.log("works");
			$(this).addClass('hcbutton').removeClass('hccom');	
	});



});