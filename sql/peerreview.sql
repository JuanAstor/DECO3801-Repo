-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2014 at 06:42 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `peerreview`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE IF NOT EXISTS `assignment` (
`AssignmentID` mediumint(8) unsigned NOT NULL,
  `CourseID` char(8) NOT NULL,
  `Semester` char(5) NOT NULL,
  `InstitutionID` int(11) NOT NULL,
  `AssignmentDescription` text,
  `AssignmentName` varchar(45) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `DueTime` time DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=514642 ;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`AssignmentID`, `CourseID`, `Semester`, `InstitutionID`, `AssignmentDescription`, `AssignmentName`, `DueDate`, `DueTime`) VALUES
(514637, 'CSSE1004', '20142', 2, 'Please use the LMS for the course materials.', 'Assignment 1 - Java', '2014-10-26', '23:59:00'),
(514638, 'ENGI3000', '20142', 2, 'Please submit the template file I placed in the BB course materials', 'Quiz 1 - Python in the Large', '2014-10-26', '23:59:00'),
(514639, 'DECO4000', '20142', 2, 'Submit files individually.', 'Checkpoint #2', '2014-10-10', '23:59:00'),
(514640, 'DECO3400', '20142', 2, 'Portfolio guidelines on BB. Please use the assignment templates as well.', 'HTML Assignment', '2014-10-12', '23:59:00'),
(514641, 'DECO2300', '20142', 2, 'Due date pushed back one week because I''m new to Peer Code Review :(', 'SQL Assignment #1', '2014-12-01', '23:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `assignmentfile`
--

CREATE TABLE IF NOT EXISTS `assignmentfile` (
  `AssignmentID` mediumint(8) unsigned NOT NULL,
  `UserID` char(254) NOT NULL,
`FileID` mediumint(8) unsigned NOT NULL,
  `FileName` tinytext NOT NULL,
  `FileData` blob NOT NULL,
  `SubmissionTime` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `FileID` mediumint(8) unsigned NOT NULL,
  `UserID` char(254) NOT NULL,
  `LineNumber` int(11) NOT NULL,
  `Contents` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `CourseID` char(8) NOT NULL,
  `Semester` char(5) NOT NULL,
  `InstitutionID` int(11) NOT NULL,
  `CourseCoordinator` char(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `Semester`, `InstitutionID`, `CourseCoordinator`) VALUES
('CSSE1004', '20142', 2, 'admin.user@lms.edu.au'),
('DECO2300', '20142', 2, 'admin.user@lms.edu.au'),
('DECO3400', '20142', 2, 'admin.user@lms.edu.au'),
('DECO4000', '20142', 2, 'admin.user@lms.edu.au'),
('ENGI3000', '20142', 2, 'admin.user@lms.edu.au');

-- --------------------------------------------------------

--
-- Table structure for table `courseenrolment`
--

CREATE TABLE IF NOT EXISTS `courseenrolment` (
  `UserID` char(254) NOT NULL,
  `CourseID` char(8) NOT NULL,
  `Semester` char(5) NOT NULL,
  `InstitutionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courseenrolment`
--

INSERT INTO `courseenrolment` (`UserID`, `CourseID`, `Semester`, `InstitutionID`) VALUES
('03957676@lms.edu.au', 'CSSE1004', '20142', 2),
('39475937@lms.edu.au', 'CSSE1004', '20142', 2),
('43586752@lms.edu.au', 'CSSE1004', '20142', 2),
('59237499@lms.edu.au', 'CSSE1004', '20142', 2),
('69434644@lms.edu.au', 'CSSE1004', '20142', 2),
('89755299@lms.edu.au', 'CSSE1004', '20142', 2),
('00663486@lms.edu.au', 'DECO2300', '20142', 2),
('03957676@lms.edu.au', 'DECO2300', '20142', 2),
('12689647@lms.edu.au', 'DECO2300', '20142', 2),
('39475937@lms.edu.au', 'DECO2300', '20142', 2),
('69434644@lms.edu.au', 'DECO2300', '20142', 2),
('00663486@lms.edu.au', 'DECO3400', '20142', 2),
('03957676@lms.edu.au', 'DECO3400', '20142', 2),
('12689647@lms.edu.au', 'DECO3400', '20142', 2),
('28349299@lms.edu.au', 'DECO3400', '20142', 2),
('39475937@lms.edu.au', 'DECO3400', '20142', 2),
('43586752@lms.edu.au', 'DECO3400', '20142', 2),
('59237499@lms.edu.au', 'DECO3400', '20142', 2),
('69434644@lms.edu.au', 'DECO3400', '20142', 2),
('79882648@lms.edu.au', 'DECO3400', '20142', 2),
('89755299@lms.edu.au', 'DECO3400', '20142', 2),
('97869992@lms.edu.au', 'DECO3400', '20142', 2),
('00663486@lms.edu.au', 'DECO4000', '20142', 2),
('43586752@lms.edu.au', 'DECO4000', '20142', 2),
('59237499@lms.edu.au', 'DECO4000', '20142', 2),
('79882648@lms.edu.au', 'DECO4000', '20142', 2),
('00663486@lms.edu.au', 'ENGI3000', '20142', 2),
('12689647@lms.edu.au', 'ENGI3000', '20142', 2),
('43586752@lms.edu.au', 'ENGI3000', '20142', 2),
('59237499@lms.edu.au', 'ENGI3000', '20142', 2),
('97869992@lms.edu.au', 'ENGI3000', '20142', 2);

-- --------------------------------------------------------

--
-- Table structure for table `institution`
--

CREATE TABLE IF NOT EXISTS `institution` (
`InstitutionID` int(11) NOT NULL,
  `consumerKey` char(45) NOT NULL,
  `AdminUser` char(254) DEFAULT NULL,
  `Secret` char(60) NOT NULL,
  `Timezone` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `institution`
--

INSERT INTO `institution` (`InstitutionID`, `consumerKey`, `AdminUser`, `Secret`, `Timezone`) VALUES
(2, 'university-of-queensland990', 'admin.user@lms.edu.au', 'Agc0JE5YiXexnnwF', 10);

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE IF NOT EXISTS `reviewer` (
  `ReviewerID` char(254) NOT NULL,
  `AssignmentID` mediumint(8) unsigned NOT NULL,
  `OwnerID` char(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserID` char(254) NOT NULL,
  `FName` varchar(45) DEFAULT NULL,
  `SName` varchar(45) DEFAULT NULL,
  `Privileges` tinytext,
  `Password` char(60) DEFAULT NULL,
  `InstitutionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FName`, `SName`, `Privileges`, `Password`, `InstitutionID`) VALUES
('00663486@lms.edu.au', 'Norma', 'Watts', 'Student', '$2y$10$c/xFdZZ6HULZ0p4/vOcE1uLhSkUE9kWAFkJf8U1h7bG1UwXaWBmJ2', 2),
('03957676@lms.edu.au', 'Roy', 'Alvarez', 'Student', '$2y$10$3aw4OxKzWK5rA4aP9.DU0uIWKnRCQuvVZ1zqxZMtLWJYwo3ihUk.y', 2),
('12689647@lms.edu.au', 'Angela', 'Crawford', 'Student', '$2y$10$gvCnIgQIIHjj.oAurbR0H.mEPpU4Bc3K9TnUtEh/pL0NUsCNFX1ae', 2),
('28349299@lms.edu.au', 'Teri', 'Lawson', 'Student', '$2y$10$.8ReUr5cRKWW/0UwvSMTBuAstsTn.61iIG.R7uAWvMrYc5vadY.9u', 2),
('39475937@lms.edu.au', 'Ernesto', 'Elliott', 'Student', '$2y$10$F6qPczcq6GClJUP84ocRHuDpTNYhoH7WTYSBwvVGilDMde3Fxisru', 2),
('43586752@lms.edu.au', 'Tyrone', 'Jackson', 'Student', '$2y$10$MEOEDwRUjj.i3bjxDxnP5O4Z9791W0B58qbrphBGfhy7FdaoCZhXu', 2),
('59237499@lms.edu.au', 'Lori', 'Underwood', 'Student', '$2y$10$G/aQyJuEkBXqsJBVyTGwUOhTl9YEcNIa/diPXosrX03B7Dm/wZ9Oa', 2),
('69434644@lms.edu.au', 'Francisco', 'Copeland', 'Student', '$2y$10$UFHvOcyDWy.P/UF6IUCPH.191wD1z8L/W8..M8SaeMjhEdndv5da6', 2),
('79882648@lms.edu.au', 'Armando', 'Lindsey', 'Student', '$2y$10$SYfT8gG90UahUodpCn0jq.R.qIsDGYWMOmVnnVB4eWv01vCJyPOQq', 2),
('89755299@lms.edu.au', 'Eleanor', 'Wagner', 'Student', '$2y$10$QmPlE7H/srVN6FQZIbdbpuIkulVrFk/weR9jog0ZpzlMBnu0W4TMS', 2),
('97869992@lms.edu.au', 'Ella', 'Hanson', 'Student', '$2y$10$EJ7T7mvhtvSNl150MMmpFeXgp1xafrdRngELD3y5PVwuaDSMS6UOi', 2),
('admin.user@lms.edu.au', 'Admin', 'User', 'Admin', '$2y$10$PqLsGLaHGlDATuxD4UCLn.gQMVEWSq/TcbW4C/wzO8WuJNhJKhvRG', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
 ADD PRIMARY KEY (`AssignmentID`), ADD KEY `CourseID_idx` (`CourseID`,`Semester`,`InstitutionID`);

--
-- Indexes for table `assignmentfile`
--
ALTER TABLE `assignmentfile`
 ADD PRIMARY KEY (`FileID`), ADD KEY `UserID_idx` (`UserID`), ADD KEY `AssignmentID_idx` (`AssignmentID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
 ADD PRIMARY KEY (`FileID`,`UserID`,`LineNumber`), ADD KEY `CommentUserID_idx` (`UserID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
 ADD PRIMARY KEY (`CourseID`,`Semester`,`InstitutionID`), ADD KEY `CourseCoordinator_idx` (`CourseCoordinator`), ADD KEY `CourseInstitutionID_idx` (`InstitutionID`);

--
-- Indexes for table `courseenrolment`
--
ALTER TABLE `courseenrolment`
 ADD PRIMARY KEY (`UserID`,`CourseID`,`Semester`,`InstitutionID`), ADD KEY `CourseID_idx` (`CourseID`,`Semester`,`InstitutionID`);

--
-- Indexes for table `institution`
--
ALTER TABLE `institution`
 ADD PRIMARY KEY (`InstitutionID`), ADD UNIQUE KEY `consumerKey_UNIQUE` (`consumerKey`), ADD UNIQUE KEY `InstitutionID_UNIQUE` (`InstitutionID`), ADD KEY `UserID_idx` (`AdminUser`);

--
-- Indexes for table `reviewer`
--
ALTER TABLE `reviewer`
 ADD PRIMARY KEY (`ReviewerID`,`AssignmentID`,`OwnerID`), ADD KEY `ReviewerAssignment_idx` (`AssignmentID`), ADD KEY `OwnerID_idx` (`OwnerID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`UserID`), ADD KEY `UserInstitutionID_idx` (`InstitutionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
MODIFY `AssignmentID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=514642;
--
-- AUTO_INCREMENT for table `assignmentfile`
--
ALTER TABLE `assignmentfile`
MODIFY `FileID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `institution`
--
ALTER TABLE `institution`
MODIFY `InstitutionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
ADD CONSTRAINT `AssignmentCourseID` FOREIGN KEY (`CourseID`, `Semester`, `InstitutionID`) REFERENCES `course` (`CourseID`, `Semester`, `InstitutionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assignmentfile`
--
ALTER TABLE `assignmentfile`
ADD CONSTRAINT `AssignmentFileAssignmentID` FOREIGN KEY (`AssignmentID`) REFERENCES `assignment` (`AssignmentID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `AssignmentFileAuthorID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
ADD CONSTRAINT `CommentFileID0` FOREIGN KEY (`FileID`) REFERENCES `assignmentfile` (`FileID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `CommentUserID0` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
ADD CONSTRAINT `CourseCoordinator` FOREIGN KEY (`CourseCoordinator`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `CourseInstitutionID` FOREIGN KEY (`InstitutionID`) REFERENCES `institution` (`InstitutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `courseenrolment`
--
ALTER TABLE `courseenrolment`
ADD CONSTRAINT `EnrolmentCourseID` FOREIGN KEY (`CourseID`, `Semester`, `InstitutionID`) REFERENCES `course` (`CourseID`, `Semester`, `InstitutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `EnrolmentUserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `institution`
--
ALTER TABLE `institution`
ADD CONSTRAINT `AdminUserID` FOREIGN KEY (`AdminUser`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reviewer`
--
ALTER TABLE `reviewer`
ADD CONSTRAINT `OwnerID` FOREIGN KEY (`OwnerID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `ReviewerAssignment` FOREIGN KEY (`AssignmentID`) REFERENCES `assignment` (`AssignmentID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `ReviewerID` FOREIGN KEY (`ReviewerID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `UserInstitutionID` FOREIGN KEY (`InstitutionID`) REFERENCES `institution` (`InstitutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
