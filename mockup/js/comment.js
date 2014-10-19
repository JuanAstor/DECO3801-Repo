$(document).ready(function(){

	$.ajaxSetup({ cache: false });
	var commentArray = [];
	var editPriv = true;
	var fileURL = 'files/user1.json';
	
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
	
	
	$(".fileselect").on("click", "#user1JSONLoad", function(){	
		
		$.getJSON(fileURL, function(json){			
			
			$.each(json, function(key, comments){
				if(key == 'comments'){
				
					commentArray = comments;					
					loadComments(commentArray);
				}			
			});			
		});	
		
		
	});
	
	$(".fileselect").on("click", "#user1JSONSave", function(){		
		$.ajax({
			type: 'POST', 
			url: 'saveJSON.php', 
			data: {'mydata':commentArray, 'url':fileURL},
			success: function(data) { 
             alert("COOL");
			},
		failure: function (data) {
           alert('Please try again');
       }
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
					'<textarea id="comtext" name="comments" rows="8"></textarea>' +		
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
	
	function deleteComment(commentArray, lineNum){
		
		$.each(commentArray, function(index, comInfo){			
			
			if (lineNum == comInfo['linenum']){		
			
				commentArray = jQuery.grep(commentArray, function(element, eleIndex){
					
					return (element != comInfo);


				});
				
			}			
			
		});	
		
		return commentArray;
		
	}
	
	function editComment(commentArray, lineNum){
	
		var storedCI;
		
		$.each(commentArray, function(index, comInfo){			
			
			if (lineNum == comInfo['linenum']){		
			
				storedCI = comInfo['comment'];
				
			}		
			
		});		
		
		return storedCI;
		
	}
	
	$("#coms").on('click', '#delbut', function(){
	
		var parTag = $($($($(this).parent()).parent()).parent());
		var lineNum = parTag.attr("line");	
		console.log(lineNum);
		
		commentArray = deleteComment(commentArray, lineNum);
		
		$(parTag).addClass('hcbutton').removeClass('hccom');
		$(parTag).html("");
		$(parTag).attr("addcom", "false");
		
		loadComments(commentArray);
		
	
	});
	
	$("#coms").on('click', '#editbut', function(){

		var parTag = $($($($(this).parent()).parent()).parent());
		var lineNum = parTag.attr("line");	
		
		var comInfo = editComment(commentArray, lineNum);
		commentArray = deleteComment(commentArray, lineNum);
	
		$(parTag).html('<span class="combox">' +
					'<form id="addComForm" action="#" method="post">' +
					'<label> Edit Comment </label>' +
					'<textarea id="comtext" name="comments" rows="8">'+ comInfo +'</textarea>' +		
				'<input id="submit" type="submit" value="Submit"/></form>' +
				'</span>');
		
		
	});
	
	
	
	
});