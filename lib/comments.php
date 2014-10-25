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
			
				$idArraySql = "SELECT DISTINCT `UserID`	FROM `comment`WHERE (`FileID` = ?)";							
				$query = MySQL::getInstance()->prepare($idArraySql);
				$query->execute(array($fileID));			
				$results = 	$query->fetchAll(PDO::FETCH_ASSOC);
				
				if(!(empty($results))){
					$userID = $results[$revNum];
					$userID = $userID["UserID"];
				}
			} 
			
			$sql = "SELECT `LineNumber`,`Contents` FROM `comment` WHERE (`UserID` = ?) AND (`FileID` = ?)
					ORDER BY `LineNumber` ASC ";
			$query = MySQL::getInstance()->prepare($sql);
			$query->execute(array($userID, $fileID));			
			$results = 	$query->fetchAll(PDO::FETCH_ASSOC);								

			echo json_encode($results);		
		
			break;
		
		// Adds a comment for the review
		case "add":
		
			$lineNum = $_POST['lineNum'];
			$lineCom = $_POST['lineCom'];
			
			$sql =  "INSERT INTO `comment`(`FileID`, `UserID`, `LineNumber`, `Contents`) 
				VALUES (?,?,?,?)";
			$query = MySQL::getInstance()->prepare($sql);
			return $query->execute(array($fileID, $userID, $lineNum, $lineCom));
			break;
			
		// Edits a comment for the review	
		case "edit":
		
			$lineNum = $_POST['lineNum'];
			$lineCom = $_POST['lineCom'];
			
			$sql = "UPDATE `comment` 
				SET `Contents`= ? WHERE (`FileID` =?) AND (`UserID` = ?) AND (`LineNumber`=?)";
			$query = MySQL::getInstance()->prepare($sql);
			return $query->execute(array($lineCom, $fileID, $userID, $lineNum));
			break;
			
		// Deletes a comment from the review	
		case "delete":
		
			$lineNum = $_POST['lineNum'];
			
			$sql = "DELETE FROM `comment`WHERE (`UserID` = ?) AND (`FileID` = ?) AND (`LineNumber` = ?)";
			$query = MySQL::getInstance()->prepare($sql);				
			return $query->execute(array($userID, $fileID, $lineNum));
							
			break;
		
		// Returns is the user is an admin/is owner of the file
		case "user":
		
			$sql = "SELECT `UserID`	FROM `assignmentfile` WHERE (`FileID` = ?)";
			$query = MySQL::getInstance()->prepare($sql);
			$query->execute(array($fileID));	
			
			$results = 	$query->fetchAll(PDO::FETCH_ASSOC);								
			$results['Admin'] = check_if_admin($userID);
							
			echo json_encode($results);				
			break;
		
		// Returns amount of users that have reviwed file
		case "revUsers":
			
			$sql = "SELECT COUNT(DISTINCT `UserID`)	AS `ReviewerAmount`	FROM `comment` WHERE (`FileID` = ?)";
			$query = MySQL::getInstance()->prepare($sql);
			$query->execute(array($fileID));	
			
			$results = 	$query->fetchAll(PDO::FETCH_ASSOC);
								
			echo json_encode($results);				
			break;
							
	
	}

?>