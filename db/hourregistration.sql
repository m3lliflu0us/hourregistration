SET
  SQL_MODE = " NO_AUTO_VALUE_ON_ZERO ";

START TRANSACTION;

SET
  time_zone = " + 02 :00 ";

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
) ENGINE = InnoDB AUTO_INCREMENT = 181 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `assignment`;

CREATE TABLE IF NOT EXISTS `assignment` (
  `assignmentId` int NOT NULL AUTO_INCREMENT,
  `clientId` int NOT NULL,
  `assignmentName` varchar(255) NOT NULL,
  `assignmentDescription` varchar(255) NOT NULL,
  PRIMARY KEY (`assignmentId`),
  KEY `clientId` (`clientId`)
) ENGINE = InnoDB AUTO_INCREMENT = 57 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

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
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

INSERT INTO
  `client` (
    `clientId`,
    `clientFirstname`,
    `clientLastname`,
    `clientEmail`,
    `clientPhoneNumber`,
    `companyName`,
    `companyAddress`
  )
VALUES
  (
    4,
    'test',
    'test',
    'test@test.com',
    '0600000000',
    'test',
    'test 21'
  ),
  (
    5,
    'test',
    'test',
    'test@test.com',
    '0600000000',
    'testtest',
    'test 21'
  ),
  (
    6,
    'noway',
    'test',
    'test@test.com',
    '0601289214',
    'TEST',
    'test'
  ),
  (
    7,
    'test',
    'test',
    'test@test.com',
    '0602020202',
    'test',
    'test 6198 TE'
  );

DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `userFirstname` varchar(100) NOT NULL,
  `userLastname` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPwd` varchar(255) NOT NULL,
  `userRole` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

INSERT INTO
  `user` (
    `userId`,
    `userFirstname`,
    `userLastname`,
    `userEmail`,
    `userPwd`,
    `userRole`
  )
VALUES
  (
    1,
    'admin',
    'test',
    'test@admin.com',
    '$2y$10$yzh/KuNN2ZhBtx9KKivlourPYbPKQFjVG2SyG7GXkySpQkE.bhppC',
    'administrator'
  ),
  (
    2,
    'sd',
    'test',
    'test@sd.com',
    '$2y$10$CNsWDyr0znjScy1KnW08/uK6Wna9mjM4jxh38myst2eu4dGEcUsMq',
    'SD'
  ),
  (
    3,
    'itsd',
    'test',
    'test@itsd.com',
    '$2y$10$U6k9xaY/7eKBoIpIZIyWQugYZ5PzV64jH0fntjFCL5dd9u8/6kvbS',
    'ITSD'
  ),
  (
    4,
    'hybrid',
    'test',
    'test@hybrid.com',
    '$2y$10$wPQrClQh52U3pDws3l8gKOnVlKEyhB6IITWRm6USCOxCDZI7eoxdC',
    'hybrid'
  ),
  (
    5,
    'test',
    'test',
    'test@test.com',
    '$2y$10$RaDeNqppyAa79ASJoWjAK.St/QzRqk57JC.UMCEo0WzOLpwn2.zsG',
    'administrator'
  ),
  (
    6,
    'bryce',
    'bryce',
    'bryce@bryce.vom',
    '$2y$10$PruUhG.I3cFATzo6VOoIFOBmoYDmCAzApcdWDlXojn3KvE6lNUn1C',
    'administrator'
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