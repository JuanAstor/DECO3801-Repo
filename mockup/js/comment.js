$(document).ready(function(){

	var commentArray = [];
	
	function loadCommentSystem(){
		//alert("works");
		var lineNum = 0;
		var plainText = $('.prettyprint').text();
		plainText = plainText.split("\n");
		var lines = $.each(plainText, function(n, elem) {
						lineNum++;
						});
		
		var lineSpacing = (parseInt($(".prettyprint").css("height"), 10)/ lineNum);
		console.log(lineSpacing);
		
		
		for (var i = 1; i <= lineNum; i++){
			document.getElementById("coms").innerHTML +=
			"<span line=\"" + i + "\" addCom=\"false\" class = \"hcbutton\" ></span>";		
		
		}
		
		
		$(".hcbutton").css("height", lineSpacing);
		$(".hcbutton").css("width", lineSpacing);
		$(".hccom").css("width", lineSpacing);
		$(".hccom").css("height", lineSpacing);
		
		console.log(lineNum);
	
	}

	
	function loadComments(commentArray){
		console.log(commentArray);
		$.each(commentArray, function(index, comInfo){
					
			$('#coms').children().each(function(){
						
				if ($(this).attr('line') == comInfo['linenum']){
							
					$(this).addClass('hccom').removeClass('hcbutton');
								
					$(this).html("<span class=\"combox\">  Line " +
						comInfo['linenum'] + " - " + comInfo['comment'] + "</span>");
								
					$(this).children().hide();
				}						
			});				
		});			
	
	}
	
	$(".fileselect").on("click", ".filelinks", loadCommentSystem());
	
	
	$("#user1JSON").click(function(){
		var my_json;
		$.getJSON('files/user1.json', function(json){
		
			my_json = json;
			console.log(my_json);
			
			$.each(my_json, function(key, comments){
				if(key == 'comments'){
				
					commentArray = comments;
					
					loadComments(commentArray);
				}			
			});			
		});	
	});
		
	$("#coms").on("click", ".hccom", 
		function(){
			$(".hccom").children().hide();
			$(".hcbutton").children().hide();
			$(this).children().toggle();
			
	});
	
	$("#coms").on("click", ".hcbutton", 
		function(){
			//Fix current submit button
			$(".hccom").children().hide();
			$(".hcbutton").children().hide();
			$(this).children().toggle();
			
			if($(this).attr('addCom') == 'false'){
				$(this).html('<span class="combox">' +
					'<form id="addComForm" action="#" method="post">' +
					'<label> Add Comment </label>' +
					'<textarea name="comments" rows="6"></textarea>' +		
				'<input id="submit" type="submit" value="Submit"/></form>' +
				'</span>');
				$(this).attr('addCom', 'true');
			} else {
				
			}
			
	});
		
		
	// Code for adding comments
	$("#coms").on('submit', '#addComForm', function(){		
		
		var lineNum;
		var comment;
		
		var lineNum = $($($(this).parent()).parent()).attr("line");
		var comment = $("textarea").val();		
		
		var jsonStr = '{ "linenum" : "' + lineNum + '", "comment" : "' + comment +'" }'		
		var jsonObject = JSON.parse(jsonStr);
		
		commentArray.push(jsonObject);
		
		loadComments(commentArray);
		
		
		return false;
	});
	
	



});