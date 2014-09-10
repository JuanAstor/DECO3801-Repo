$(document).ready(function(){

	$("#dialog").dialog({
		autoOpen:false,
	});

	$("#addButton").click(function(){
		$("#dialog").dialog("open");
	});
	
	$("#submit").click(function(){
		var lineNum = $("#lineNum").val();
		var comment = $("textarea#comSec").val();
		
		
		document.getElementById("comSec").innerHTML += 
		"<div id='comment'><p>Line " + lineNum + " - " + comment + 
		"</p></div>";
		
		alert("Submitted");
		
		return false;
		
	
	});	




});