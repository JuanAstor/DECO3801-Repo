$(document).ready(function(){

	var commentArray = [];
	var editPriv = true;
	
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
					
					
					if (!editPriv){ 	
					
						$(this).html("<span class=\"combox\">  Line " +
						comInfo['linenum'] + " - " + comInfo['comment'] + "</span>");
						
					} else {

						$(this).html("<span class=\"combox\">  Line " +
						comInfo['linenum'] + " - " + comInfo['comment'] 
						+ "<div class=\"editpriv\"><button id=\"editbut\" ></button>" +
						"<button id=\"delbut\" ></button></div></span>");
					
					}
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
					'<textarea id="comtext" name="comments" rows="4"></textarea>' +		
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
		
		var comment = $("textarea").val().replace(/\r\n|\r|\n/g,"<br />");;
		
		console.log(comment);

		
		
		
		
		var jsonStr = '{ "linenum" : "' + lineNum + '", "comment" : "' + comment +'" }'	
		console.log(jsonStr);		
		var jsonObject = JSON.parse(jsonStr);
		console.log(jsonObject);
		
		commentArray.push(jsonObject);
		
		loadComments(commentArray);
		
		
		return false;
	});
	
	
	$("#coms").on('click', '#delbut', function(){	
		alert("DELETED");
	
	});
	
	$("#coms").on('click', '#editbut', function(){	
		alert("EDITED");
	
	});



});