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
	
	$("#user1JSON").click(function(){
		var my_json;
		$.getJSON('files/user1.json', function(json){
			my_json = json;
			console.log(my_json);
			
			$.each(my_json, function(file, comments){
				if(file == 'file2.txt'){
					$.each(comments, function(index, comInfo){
						$('#coms').children().each(function(){
							if ($(this).attr('line') == comInfo['linenum']){
								$(this).addClass('hccom').removeClass('hcbutton');
								
							}
						
						});
						console.log(comInfo['linenum'] + " " + comInfo['comment']);
					
					});
				
				}
			
			});
			
		});
		
		
	
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