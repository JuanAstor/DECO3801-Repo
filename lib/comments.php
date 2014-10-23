<?php
	require("mysql.php");
	require("queries.php");
	
	$reqType = $_POST['rtype'];
	$userID = $_POST['uid'];
	$fileID = $_POST['fid'];
	
	switch ($reqType){
		
		// Retrieves all comments for review
		case "fetch":
			
			$ownerBool = $_POST['isOwner'];
			$revNum = $_POST['revNum'];
			
			if ($ownerBool == "true"){
			
				$idArrayQuery = MySQL::getInstance()->query("SELECT DISTINCT `UserID`
							FROM `comment`
							WHERE (`FileID` = '". $fileID. "')");							
							
				$results = 	$idArrayQuery->fetchAll();
				
				$userID = $results[$revNum];
				$userID = $userID["UserID"];
			} 
			
			$query = MySQL::getInstance()->query("SELECT `LineNumber`,`Contents`
					FROM `comment`
					WHERE (`UserID` = '". $userID ." ') AND (`FileID` = '". $fileID." ')
					ORDER BY `LineNumber` ASC ");								

			echo json_encode($query->fetchAll());
			
				
		
		
			break;
		
		// Adds a comment for the review
		case "add":
		
			$lineNum = $_POST['lineNum'];
			$lineCom = $_POST['lineCom'];
			
			$query =  MySQL::getInstance()->query("INSERT INTO `comment`
				(`FileID`, `UserID`, `LineNumber`, `Contents`) 
				VALUES ('".$fileID."','".$userID."','".$lineNum."','".$lineCom."')");
			return $query;
			break;
			
		// Edits a comment for the review	
		case "edit":
		
			$lineNum = $_POST['lineNum'];
			$lineCom = $_POST['lineCom'];
			
			$query = MySQL::getInstance()->query("UPDATE `comment` 
				SET `Contents`= '".$lineCom."' WHERE (`FileID` ='".$fileID."') 
				AND (`UserID` = '".$userID."') AND (`LineNumber`='".$lineNum."')");
			return $query;
			break;
			
		// Deletes a comment from the review	
		case "delete":
		
			$lineNum = $_POST['lineNum'];
			
			$query = MySQL::getInstance()->query("DELETE FROM `comment`
							WHERE (`UserID` = '". $userID . "') AND (`FileID` = '". $fileID. "')
							AND (`LineNumber` = '".$lineNum."')");
			return $query;
							
			break;
		
		// Returns is the user is an admin/is owner of the file
		case "user":
		
			$query = MySQL::getInstance()->query("SELECT `UserID`
							FROM `assignmentfile`
							WHERE (`FileID` = '". $fileID. "')");
							
			$results = 	$query->fetchAll();
			$results['Admin'] = check_if_admin($userID);
							
			echo json_encode($results);				
			break;
		
		// Returns amount of users that have reviwed file
		case "revUsers":
			
			$query = MySQL::getInstance()->query("SELECT COUNT(DISTINCT `UserID`)
					AS `ReviewerAmount`
					FROM `comment`
					WHERE (`FileID` = '".$fileID."')");
							
							
			$results = 	$query->fetchAll();
			
									
			echo json_encode($results);				
			break;
							
	
	}

?>