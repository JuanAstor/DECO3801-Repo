SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema PeerReview
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `PeerReview` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `PeerReview` ;

-- -----------------------------------------------------
-- Table `PeerReview`.`Institution`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PeerReview`.`Institution` ;

CREATE TABLE IF NOT EXISTS `PeerReview`.`Institution` (
  `InstitutionID` INT NOT NULL AUTO_INCREMENT,
  `consumerKey` CHAR(60) NOT NULL,
  `AdminUser` CHAR(254) NULL,
  `Secret` char(60) NOT NULL,
  `Timezone` INT NOT NULL,
  PRIMARY KEY (`InstitutionID`),
  INDEX `UserID_idx` (`AdminUser` ASC),
  UNIQUE INDEX `consumerKey_UNIQUE` (`consumerKey` ASC),
  UNIQUE INDEX `InstitutionID_UNIQUE` (`InstitutionID` ASC),
  CONSTRAINT `AdminUserID`
    FOREIGN KEY (`AdminUser`)
    REFERENCES `PeerReview`.`User` (`UserID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PeerReview`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PeerReview`.`User` ;

CREATE TABLE IF NOT EXISTS `PeerReview`.`User` (
  `UserID` CHAR(254) NOT NULL,
  `FName` VARCHAR(45) NULL,
  `SName` VARCHAR(45) NULL,
  `Privileges` TINYTEXT NULL,
  `Password` CHAR(60) NULL,
  `InstitutionID` INT NOT NULL,
  PRIMARY KEY (`UserID`),
  INDEX `UserInstitutionID_idx` (`InstitutionID` ASC),
  CONSTRAINT `UserInstitutionID`
    FOREIGN KEY (`InstitutionID`)
    REFERENCES `PeerReview`.`Institution` (`InstitutionID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PeerReview`.`Course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PeerReview`.`Course` ;

CREATE TABLE IF NOT EXISTS `PeerReview`.`Course` (
  `CourseID` CHAR(8) NOT NULL,
  `Semester` CHAR(5) NOT NULL,
  `InstitutionID` INT NOT NULL,
  `CourseCoordinator` CHAR(254) NULL,
  PRIMARY KEY (`CourseID`, `Semester`, `InstitutionID`),
  INDEX `CourseCoordinator_idx` (`CourseCoordinator` ASC),
  INDEX `CourseInstitutionID_idx` (`InstitutionID` ASC),
  CONSTRAINT `CourseCoordinator`
    FOREIGN KEY (`CourseCoordinator`)
    REFERENCES `PeerReview`.`User` (`UserID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `CourseInstitutionID`
    FOREIGN KEY (`InstitutionID`)
    REFERENCES `PeerReview`.`Institution` (`InstitutionID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PeerReview`.`Assignment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PeerReview`.`Assignment` ;

CREATE TABLE IF NOT EXISTS `PeerReview`.`Assignment` (
  `AssignmentID` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `CourseID` CHAR(8) NOT NULL,
  `Semester` CHAR(5) NOT NULL,
  `InstitutionID` INT NOT NULL,
  `AssignmentDescription` VARCHAR(45) NULL,
  `AssignmentName` VARCHAR(45) NULL,
  `DueDate` DATE NULL,
  `DueTime` TIME NULL,
  PRIMARY KEY (`AssignmentID`),
  INDEX `CourseID_idx` (`CourseID` ASC, `Semester` ASC, `InstitutionID` ASC),
  CONSTRAINT `AssignmentCourseID`
    FOREIGN KEY (`CourseID` , `Semester` , `InstitutionID`)
    REFERENCES `PeerReview`.`Course` (`CourseID` , `Semester` , `InstitutionID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PeerReview`.`AssignmentFile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PeerReview`.`AssignmentFile` ;

CREATE TABLE IF NOT EXISTS `PeerReview`.`AssignmentFile` (
  `AssignmentID` MEDIUMINT UNSIGNED NOT NULL,
  `UserID` CHAR(254) NOT NULL,
  `FileID` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `FileName` TINYTEXT NOT NULL,
  `FileData` BLOB NOT NULL,
  `SubmissionTime` DATETIME NOT NULL,
  INDEX `UserID_idx` (`UserID` ASC),
  PRIMARY KEY (`FileID`),
  INDEX `AssignmentID_idx` (`AssignmentID` ASC),
  CONSTRAINT `AssignmentFileAssignmentID`
    FOREIGN KEY (`AssignmentID`)
    REFERENCES `PeerReview`.`Assignment` (`AssignmentID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `AssignmentFileAuthorID`
    FOREIGN KEY (`UserID`)
    REFERENCES `PeerReview`.`User` (`UserID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PeerReview`.`CourseEnrolment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PeerReview`.`CourseEnrolment` ;

CREATE TABLE IF NOT EXISTS `PeerReview`.`CourseEnrolment` (
  `UserID` CHAR(254) NOT NULL,
  `CourseID` CHAR(8) NOT NULL,
  `Semester` CHAR(5) NOT NULL,
  `InstitutionID` INT NOT NULL,
  INDEX `CourseID_idx` (`CourseID` ASC, `Semester` ASC, `InstitutionID` ASC),
  PRIMARY KEY (`UserID`, `CourseID`, `Semester`, `InstitutionID`),
  CONSTRAINT `EnrolmentUserID`
    FOREIGN KEY (`UserID`)
    REFERENCES `PeerReview`.`User` (`UserID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `EnrolmentCourseID`
    FOREIGN KEY (`CourseID` , `Semester` , `InstitutionID`)
    REFERENCES `PeerReview`.`Course` (`CourseID` , `Semester` , `InstitutionID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PeerReview`.`Reviewer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PeerReview`.`Reviewer` ;

CREATE TABLE IF NOT EXISTS `PeerReview`.`Reviewer` (
  `ReviewerID` CHAR(254) NOT NULL,
  `AssignmentID` MEDIUMINT UNSIGNED NOT NULL,
  `OwnerID` CHAR(254) NOT NULL,
  PRIMARY KEY (`ReviewerID`, `AssignmentID`, `OwnerID`),
  INDEX `ReviewerAssignment_idx` (`AssignmentID` ASC),
  INDEX `OwnerID_idx` (`OwnerID` ASC),
  CONSTRAINT `ReviewerID`
    FOREIGN KEY (`ReviewerID`)
    REFERENCES `PeerReview`.`User` (`UserID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ReviewerAssignment`
    FOREIGN KEY (`AssignmentID`)
    REFERENCES `PeerReview`.`Assignment` (`AssignmentID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `OwnerID`
    FOREIGN KEY (`OwnerID`)
    REFERENCES `PeerReview`.`User` (`UserID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PeerReview`.`Comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PeerReview`.`Comment` ;

CREATE TABLE IF NOT EXISTS `PeerReview`.`Comment` (
  `FileID` MEDIUMINT UNSIGNED NOT NULL,
  `UserID` CHAR(254) NOT NULL,
  `LineNumber` INT NOT NULL,
  `Contents` MEDIUMTEXT NOT NULL,
  PRIMARY KEY (`FileID`, `UserID`, `LineNumber`),
  INDEX `CommentUserID_idx` (`UserID` ASC),
  CONSTRAINT `CommentFileID0`
    FOREIGN KEY (`FileID`)
    REFERENCES `PeerReview`.`AssignmentFile` (`FileID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `CommentUserID0`
    FOREIGN KEY (`UserID`)
    REFERENCES `PeerReview`.`User` (`UserID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
