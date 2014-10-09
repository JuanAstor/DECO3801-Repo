

function loadCommentSystem(){
	$.ajaxSetup({ cache: false });
	
	
	// array to hold all comments "locally"
	var commentArray = [];
	
	// User ID of person browsing
	var userID = '12123434';
	//var userID = $_SESSION["user"];
	var fileID = '1';
	// User ID of reviewer
	
		
	
	function runAll(){
		
		console.log("called here");
			
		$.ajax({
		
			type: "POST",
			url: "comments.php",
			data: {"rtype": "user", "uid" : userID, "fid" : fileID},
			
			success: runStep1
				
		});		
		
		
	}

	function runStep1(data){
	
		var ownBool = false;
		var editBool = false;
	
		var privInfo = jQuery.parseJSON(data);	

		var adminResult = privInfo["Admin"];
		var ownerResult = (privInfo["0"])["UserID"];
				
		if(ownerResult == userID){
			ownBool = true;
			editBool = false;
		} else {
			ownBool = false;
			editBool = true;
		}
		
		loadCommentSystem(ownBool,editBool, 0);
				
		if(ownBool){
		
			$.ajax({ 
				
				type: "POST",
				url: "comments.php",
				data: {"rtype": "revUsers", "uid" : userID, "fid" : fileID},
					
				success: generateReviewTabs	
					
					
					
			});
				
		}
				
		console.log(ownBool);
		console.log(editBool);
			
	
	}
	
	function generateReviewTabs(data){
	
		var revInfo = jQuery.parseJSON(data);
		var revAmount = (revInfo["0"])["ReviewerAmount"];
		
		for (var i = 0; i < revAmount; i++){
			
				document.getElementById("tabs").innerHTML +=
				"<li><span class=\"tabSpan\" revNum = \"" + i + "\" >Review " + (i+1) + "</span></li>";	
				
		
		}
	
	
	}
	
	
	function loadCommentSystem(isOwner, editPriv, revNum){
		
		document.getElementById("coms").innerHTML = "";
		
		
		var lineNum = 0;
		var revID = "";
		var plainText = $('.prettyprint').text();
		plainText = plainText.split("\n");
		var lines = $.each(plainText, function(n, elem) {
						lineNum++;
						});
		
		var lineSpacing = (parseInt($(".prettyprint").css("height"), 10)/ lineNum);
		console.log(lineSpacing);
		
		
		
		
		if(!isOwner){
		
			for (var i = 1; i <= lineNum; i++){
			
				document.getElementById("coms").innerHTML +=
				"<span line=\"" + i + "\" hasCom=\"false\" class = \"hcbutton\" ></span>";		
		
			}
		
		} else {
		
			for (var i = 1; i <= lineNum; i++){
			
				document.getElementById("coms").innerHTML +=
				"<span line=\"" + i + "\" hasCom=\"false\" class = \"hcbuttonown\" ></span>";		
		
			}
			
		
		}
		
		
		$(".hcbutton").css("height", lineSpacing);
		$(".hcbutton").css("width", lineSpacing);
		$(".hccom").css("width", lineSpacing);
		$(".hccom").css("height", lineSpacing);
		$(".hcbuttonown").css("width", lineSpacing);
		$(".hcbuttonown").css("height", lineSpacing);
		
		
		if(!isOwner){
			fetchComments(isOwner, editPriv, revNum);
		} else {
			
			fetchComments(isOwner, editPriv, revNum);
		}
		
		
	
	}
	
	function fetchComments(isOwner, editPriv, revNum){	
		commentArray = [];
		
		$.ajax({
			type: "POST",
			url: "comments.php",
			data: {"rtype": "fetch", "revNum" : revNum, "uid" : userID,
					"fid" : fileID, "isOwner" : isOwner},
			success: function(json){				
				commentArray = jQuery.parseJSON(json);
				console.log(commentArray);
				loadComments(commentArray, isOwner, editPriv);
							
			}		
		
		});			
		
	}
	
	
	function loadComments(commentArray, isOwner, editPriv){
	
		console.log(editPriv);
		
	
		$.each(commentArray, function(index, comInfo){
					
			$('#coms').children().each(function(){
						
				if ($(this).attr('line') == comInfo['LineNumber']){
				
					var lineNum = comInfo['LineNumber'];
					var lineCom = comInfo['LineComment'];
						
				
					if(!isOwner){$(this).addClass('hccom').removeClass('hcbutton');
								 $(this).attr('hascom', 'true');}
					else { $(this).addClass('hccom').removeClass('hcbuttonown'); }
					
					
					if (!editPriv){ 	
					
						$(this).html("<span class=\"combox\"> <b> Line " +
						lineNum + "</b> <br />" + lineCom + "</span>");
						
					} else {

						$(this).html("<span class=\"combox\">  <b>Line " +
						lineNum + "</b> <br /><textarea class=\"trans\" readonly>" + lineCom
						+ "</textarea ><div class=\"editpriv\"><button id=\"editbut\" ></button>" +
						"<button id=\"delbut\" ></button></div></span>");
					
					}
					var txtArea = $(this).find(".trans");
					txtArea.css("height", 'auto');
					txtArea.css("height", (txtArea[0].scrollHeight + 'px'));
					$(this).children().hide();
				}						
			});				
		});			
	
	}
	
	function deleteComment(commentArray, lineNum){
		
		$.each(commentArray, function(index, comInfo){			
			
			if (lineNum == comInfo['LineNumber']){	
			
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
			
			if (lineNum == comInfo['LineNumber']){		
			
				storedCI = comInfo['LineComment'];
				
			}		
			
		});		
		
		return storedCI;
		
	}
	
	function replaceSpecialChars(string){
		
		var comment = string.replace(/[\\]/g, '\\\\')
							.replace(/[\/]/g, '\\/')
							.replace(/[\b]/g, '\\b')
							.replace(/[\f]/g, '\\f')
							.replace(/[\n]/g, '\\n')
							.replace(/[\r]/g, '\\r')
							.replace(/[\t]/g, '\\t')
							.replace(/\r\'|\r|\'/g,"&#38;")
							.replace(/\r\"|\r|\"/g,"&quot;");
				
		return comment;
	}

	//-------------------------------------------------------
	
	runAll();
	
	//$(".fileselect").ajaxComplete(runAll());
	
	$("#tabs").unbind();
	
	$("#tabs").on("click", ".tabSpan", function(){
		
		var revNum = $(this).attr("revnum");
		
		loadCommentSystem(true,false, revNum);
		
	
	});


	$("#coms").unbind();
		
	$("#coms").on("click", ".hccom", 
		function(){		
	
			
			if($(this).children().css("display") == "none"){
			
				$(".hcbutton").children().hide();
				$(".hccom").children().hide();
				$(this).children().toggle(300);		
				
			} else {
			
				//$(this).children().toggle(300);
			
			}
			
	});
	
	$("#coms").on("click", ".hcbutton", 
		function(){		
			
			if($(this).attr('hasCom') == 'false'){
			
				$(".hccom").children().hide();
				$(".hcbutton").children().hide();			
				$(".hcbutton").html("");
				$(this).html('<span class="combox">' +
					'<form id="addComForm" action="#" method="post">' +
					'<label><b> Add Comment </b></label>' +
					'<textarea id="comtext" name="comments" rows="8"></textarea>' +		
				'<input id="submit" type="submit" value="Submit"/></form>' +
				'</span>');
				
				$(this).children().hide();
				$(this).children().toggle(300);
				$(".hcbutton").attr('hasCom', 'false');
				$(this).attr('hasCom', 'true');
				
				
			} else {
			//	$(this).children().toggle(300);
			}
			
	});
		
		
	// Code for adding comments
	$("#coms").on('submit', '#addComForm', function(){		
		
		var parTag = $($($(this).parent()).parent());
		var lineNum = $($($(this).parent()).parent()).attr("line");
		
		var comment = replaceSpecialChars($("#comtext").val());
		
		var jsonStr = '{ "LineNumber" : "' + lineNum + '", "LineComment" : "' + comment +'" }'	
		console.log(jsonStr);		
		var jsonObject = JSON.parse(jsonStr);
		console.log(jsonObject);
		
		
		
		$.ajax({
			type: "POST",
			url: "comments.php",
			data: {"rtype": "add", "uid" : userID, "fid" : fileID,
					"lineNum": lineNum, "lineCom": comment},
			success: function(){
				commentArray.push(jsonObject);
				loadComments(commentArray, false, true);			
			}		
		
		});			
		
		
		
		
		return false;
	});
	
	$("#coms").on('submit', '#editComForm', function(){		
		
		var lineNum = $($($(this).parent()).parent()).attr("line");		
		var comment = replaceSpecialChars($("#comtext").val());
	
		
		var jsonStr = '{ "LineNumber" : "' + lineNum + '", "LineComment" : "' + comment +'" }'	
		console.log(jsonStr);		
		var jsonObject = JSON.parse(jsonStr);
		console.log(jsonObject);
		
		$.ajax({
			type: "POST",
			url: "comments.php",
			data: {"rtype": "edit", "uid" : userID, "fid" : fileID,
					"lineNum": lineNum, "lineCom": comment},
					
			success: function(){
			
				commentArray = deleteComment(commentArray, lineNum);
				commentArray.push(jsonObject);
				loadComments(commentArray, false, true);			
			}		
		
		});		
		
		return false;
	});
	
	
	
	
	$("#coms").on('click', '#delbut', function(){
	
		var parTag = $($($($(this).parent()).parent()).parent());
		var lineNum = parTag.attr("line");	
		
		if(confirm("Do you wish to delete this comment?")){
		
			$.ajax({
		
				type: "POST",
				url: "comments.php",
				data: {"rtype": "delete", "uid" : userID, "fid" : fileID,
						"lineNum": lineNum},
					
				success: function(){
			
					commentArray = deleteComment(commentArray, lineNum);
				
					$(parTag).addClass('hcbutton').removeClass('hccom');
					$(parTag).html("");
					$(parTag).attr("hasCom", "false");
			
					loadComments(commentArray, false, true);		
				}		
		
			});			
		
		}
	
	});
	
	$("#coms").on('click', '#editbut', function(){

		var parTag = $($($($(this).parent()).parent()).parent());
		var lineNum = parTag.attr("line");			
		var comInfo = editComment(commentArray, lineNum);

		$("#editComForm").remove();
		loadComments(commentArray,false,true);
	
		$(parTag).html('<span class="combox">' +
					'<form id="editComForm" action="#" method="post">' +
					'<label> <b>Edit Comment</b> </label>' +
					'<textarea id="comtext" name="comments" rows="8" >'+ comInfo +'</textarea>' +		
				'<input id="submit" type="submit" value="Submit"/></form>' +
				'</span>');
		
		
	});
	
	
	
}