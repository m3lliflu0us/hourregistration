SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+02:00";

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
) ENGINE = InnoDB AUTO_INCREMENT = 84 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `userFirstname` varchar(100) NOT NULL,
  `userLastname` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPwd` varchar(255) NOT NULL,
  `userRole` varchar(255) DEFAULT NULL,
  `last_active` datetime DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

INSERT INTO
  `user` (
    `userId`,
    `userFirstname`,
    `userLastname`,
    `userEmail`,
    `userPwd`,
    `userRole`,
    `last_active`
  )
VALUES
  (
    1,
    'admin',
    'test',
    'test@admin.com',
    '$2y$10$yzh/KuNN2ZhBtx9KKivlourPYbPKQFjVG2SyG7GXkySpQkE.bhppC',
    'administrator',
    '2024-06-17 09:16:42'
  ),
  (
    2,
    'sd',
    'test',
    'test@sd.com',
    '$2y$10$CNsWDyr0znjScy1KnW08/uK6Wna9mjM4jxh38myst2eu4dGEcUsMq',
    'SD',
    '2024-06-17 09:17:07'
  ),
  (
    3,
    'itsd',
    'test',
    'test@itsd.com',
    '$2y$10$U6k9xaY/7eKBoIpIZIyWQugYZ5PzV64jH0fntjFCL5dd9u8/6kvbS',
    'ITSD',
    NULL
  ),
  (
    4,
    'hybrid',
    'test',
    'test@hybrid.com',
    '$2y$10$wPQrClQh52U3pDws3l8gKOnVlKEyhB6IITWRm6USCOxCDZI7eoxdC',
    'hybrid',
    NULL
  ),
  (
    5,
    'test',
    'test',
    'test@test.com',
    '$2y$10$RaDeNqppyAa79ASJoWjAK.St/QzRqk57JC.UMCEo0WzOLpwn2.zsG',
    'administrator',
    NULL
  ),
  (
    6,
    'bryce',
    'bryce',
    'bryce@bryce.vom',
    '$2y$10$PruUhG.I3cFATzo6VOoIFOBmoYDmCAzApcdWDlXojn3KvE6lNUn1C',
    'administrator',
    NULL
  ),
  (
    8,
    'test',
    'test',
    'test@faf.com',
    '$2y$10$ByyjqSs6NjAaRE.Wib3zdORFrCLpCJYQ.UKVr1FqGePufK4DZmKc6',
    'administrator',
    NULL
  ),
  (
    9,
    'test',
    'test',
    'test@sdyufgdsuyf.com',
    '$2y$10$A4b/VLTVKgv0V1ssHePLPeWFnceif05uQd.DO4Dw2FVHDeT0zYVNe',
    'administrator',
    NULL
  ),
  (
    10,
    'tet',
    'tet',
    'test@testtest.copm',
    '$2y$10$cnkoXejDXyTwBfsxtE1n7eb9W/fbYLZ7wz62qKMS4/sqGQjQ77iNm',
    'administrator',
    NULL
  ),
  (
    11,
    'test',
    'test',
    '1@test.com',
    '$2y$10$y4fZh1BCWnTHhgMVjPfc8u1vuPZHPEygt/SC2Xa/ONmcex8f3vc3C',
    'administrator',
    NULL
  ),
  (
    12,
    'test',
    'test',
    'test@testfsd.com',
    '$2y$10$Xccc1OxHjB5Xfi9S9o0YM.3qDDfdneWiPg23dMXj2KEL2wqvuMV7i',
    'administrator',
    NULL
  ),
  (
    13,
    'admin',
    'test',
    'test@testadmin.com',
    '$2y$10$gaVC3hWI.UMkpmFukRivRuHlf6NnjISS98VBiUqyWa/2deELs3NaG',
    'administrator',
    NULL
  );

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