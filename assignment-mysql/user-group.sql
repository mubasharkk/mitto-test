-- MySQL dump 10.13  Distrib 5.6.30, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: mitto_test
-- ------------------------------------------------------
-- Server version	5.6.30-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `usergroups`
--

DROP TABLE IF EXISTS `usergroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usergroups` (
  `groupId` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(255) NOT NULL,
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usergroups`
--

LOCK TABLES `usergroups` WRITE;
/*!40000 ALTER TABLE `usergroups` DISABLE KEYS */;
INSERT INTO `usergroups` VALUES (1,'admin'),(2,'employee'),(3,'customer');
/*!40000 ALTER TABLE `usergroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` int(11) DEFAULT NULL,
  `userName` varchar(20) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userName_UNIQUE` (`userName`),
  UNIQUE KEY `userEmail_UNIQUE` (`userEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'administrator','admin@demo.com'),(2,2,'sammy','sammy@demo.com'),(3,2,'james','james@demo.com'),(4,3,'chris','chris@demo.com'),(5,3,'jondoe','jon.doe@demo.com'),(6,3,'jenny','jenny@demo.com'),(7,3,'nancy','nancy@demo.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-16 20:18:57

/**
* Alternatively these queries can be used for inserting data
* For Users & UserGroups
*/

-- INSERT INTO usergroups values (NULL, "admin"), (NULL, "employee"), (NULL, "customer");

-- INSERT INTO users (groupId, userName, userEmail) VALUES 
-- (1, "administrator", "admin@demo.com"),
-- (2, "sammy", "sammy@demo.com"),
-- (2, "james", "james@demo.com"),
-- (3, "chris", "chris@demo.com"),
-- (3, "jondoe", "jon.doe@demo.com"),
-- (3, "jenny", "jenny@demo.com"),
-- (3, "nancy", "nancy@demo.com");


/**
* E) Write a SELECT query that produces a user list with the following columns: userId, userName, userEmail, groupName.
*/
SELECT u.userId, u.userName, u.userEmail, g.groupName FROM users u LEFT JOIN usergroups g ON g.groupId = u.groupId;


/**
* F) Write a SELECT query that lists all users being in the group admin or employee.
*/
SELECT u.*, g.groupName FROM users u LEFT JOIN usergroups g ON u.groupId = g.groupId WHERE g.groupName IN ("admin", "employee");

/**
* G) Write a SELECT query that lists all usergroups. Columns: groupName, the count of users in the group, a comma-separated list of usernames.
*/
SELECT g.*, count(u.userId) as members, GROUP_CONCAT(u.userName SEPARATOR ',') as userNames 
FROM usergroups g 
LEFT JOIN users u ON u.groupId = g.groupId 
GROUP BY g.groupId;