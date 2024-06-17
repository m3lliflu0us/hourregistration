SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+02:00";

CREATE DATABASE IF NOT EXISTS `hourregistration` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

USE `hourregistration`;

DROP TABLE IF EXISTS `activity`;

CREATE TABLE IF NOT EXISTS `activity` (
  `activityId` int NOT NULL AUTO_INCREMENT,
  `assignmentId` int NOT NULL,
  `userId` int NOT NULL,
  `clockedIn` tinyint(1) DEFAULT '0',
  `clockedBegin` time DEFAULT NULL,
  `clockedEnd` time DEFAULT NULL,
  `selected` tinyint(1) DEFAULT '0',
  `totalTime` int DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  PRIMARY KEY (`activityId`),
  KEY `assignmentId` (`assignmentId`),
  KEY `userId` (`userId`)
) ENGINE = InnoDB AUTO_INCREMENT = 203 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `assignment`;

CREATE TABLE IF NOT EXISTS `assignment` (
  `assignmentId` int NOT NULL AUTO_INCREMENT,
  `clientId` int NOT NULL,
  `assignmentName` varchar(255) NOT NULL,
  `assignmentDescription` varchar(255) NOT NULL,
  PRIMARY KEY (`assignmentId`),
  KEY `clientId` (`clientId`)
) ENGINE = InnoDB AUTO_INCREMENT = 59 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `client`;

CREATE TABLE IF NOT EXISTS `client` (
  `clientId` int NOT NULL AUTO_INCREMENT,
  `clientFirstname` varchar(255) DEFAULT NULL,
  `clientLastname` varchar(255) DEFAULT NULL,
  `clientEmail` varchar(255) DEFAULT NULL,
  `clientPhoneNumber` varchar(255) DEFAULT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `companyAddress` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`clientId`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `messages`;

CREATE TABLE IF NOT EXISTS `messages` (
  `messageId` int NOT NULL AUTO_INCREMENT,
  `senderId` int NOT NULL,
  `recipientId` int NOT NULL,
  `messageText` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`messageId`),
  KEY `senderId` (`senderId`),
  KEY `recipientId` (`recipientId`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `userFirstname` varchar(100) NOT NULL,
  `userLastname` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPwd` varchar(255) NOT NULL,
  `userRole` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

ALTER TABLE
  `activity`
ADD
  CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`assignmentId`) REFERENCES `assignment` (`assignmentId`),
ADD
  CONSTRAINT `activity_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

ALTER TABLE
  `assignment`
ADD
  CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`clientId`) REFERENCES `client` (`clientId`);

ALTER TABLE
  `messages`
ADD
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `user` (`userId`),
ADD
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`recipientId`) REFERENCES `user` (`userId`);