-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: pset7
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `transaction` varchar(4) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `symbol` varchar(8) NOT NULL,
  `shares` int(10) unsigned NOT NULL,
  `price` decimal(12,4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `datetime` (`datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (1,11,'BUY','0000-00-00 00:00:00','FOO',1,17336.0000),(3,11,'BUY','2016-08-01 03:51:14','AAPL',1,104.2100),(4,11,'BUY','2016-08-01 03:51:16','AAPL',1,104.2100),(6,11,'BUY','2016-08-01 03:56:18','FOO',123,17336.0000),(8,11,'BUY','2016-08-01 03:59:56','FOO',23,17336.0000),(9,11,'SELL','2016-08-01 04:00:08','FOO',23,17336.0000),(10,11,'BUY','2016-08-01 04:00:18','FOO',123,17336.0000),(11,11,'SELL','2016-08-01 04:00:48','AAPL',102,104.2100),(12,11,'BUY','2016-08-01 04:00:56','AAPL',123,104.2100),(13,11,'SELL','2016-08-01 04:12:23','GOOG',124,768.7900),(14,11,'BUY','2016-08-01 04:12:37','GOOG',123,768.7900),(15,9,'SELL','2016-08-01 05:38:35','AAPL',1,104.2100),(16,9,'SELL','2016-08-01 05:38:42','FREE',100,1.1500),(17,9,'SELL','2016-08-01 05:39:13','GOOG',1,768.7900),(18,9,'SELL','2016-08-01 05:39:20','MSFT',1,56.6800),(19,9,'SELL','2016-08-01 05:39:27','ORCL',1,41.0400),(20,9,'BUY','2016-08-01 05:39:41','ORCL',1,41.0400),(21,9,'BUY','2016-08-01 05:39:58','MSFT',1,56.6800),(22,9,'BUY','2016-08-01 05:40:09','GOOG',1,768.7900),(23,9,'BUY','2016-08-01 05:40:39','AAPL',1,104.2100),(24,9,'BUY','2016-08-01 05:40:58','FREE',1024,1.1500),(25,11,'BUY','2016-08-01 05:43:46','TSLA',123,234.7900),(26,11,'BUY','2016-08-01 05:44:11','YHOO',123,38.1900),(27,11,'BUY','2016-08-02 00:31:07','SPU',13,12.7900),(28,11,'BUY','2016-08-02 00:31:45','SPU',110,12.7900),(29,11,'BUY','2016-08-03 22:18:51','SPU',1,10.6700),(30,11,'BUY','2016-08-03 22:48:30','SPU',1,10.6700),(31,11,'BUY','2016-08-04 02:21:12','FOO',1,17336.0000),(32,11,'BUY','2016-08-04 02:32:30','FOO',1,17336.0000),(33,11,'BUY','2016-08-04 03:14:45','FOO',1,17336.0000),(34,11,'SELL','2016-08-04 03:34:22','SPU',125,10.6700),(35,11,'SELL','2016-08-04 03:38:08','FREE',4242,1.1500),(36,11,'BUY','2016-08-04 03:38:33','FREE',123,1.1500),(37,11,'BUY','2016-08-04 19:48:04','SPU',23,10.8600),(38,11,'SELL','2016-08-04 20:14:07','SPU',23,10.8000),(39,11,'BUY','2016-08-04 20:15:28','SPU',17,10.8200),(40,11,'SELL','2016-08-04 20:15:46','SPU',17,10.8200);
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolios`
--

DROP TABLE IF EXISTS `portfolios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portfolios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `symbol` varchar(8) NOT NULL,
  `shares` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`symbol`),
  UNIQUE KEY `user_id_2` (`user_id`,`symbol`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolios`
--

LOCK TABLES `portfolios` WRITE;
/*!40000 ALTER TABLE `portfolios` DISABLE KEYS */;
INSERT INTO `portfolios` VALUES (11,11,'ORCL',123),(14,11,'MSFT',123),(17,11,'IBM',123),(34,11,'FOO',126),(35,11,'AAPL',123),(36,11,'GOOG',123),(37,9,'ORCL',1),(38,9,'MSFT',1),(39,9,'GOOG',1),(40,9,'AAPL',1),(41,9,'FREE',1024),(42,11,'TSLA',123),(43,11,'YHOO',123),(50,11,'FREE',123);
/*!40000 ALTER TABLE `portfolios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cash` decimal(65,4) unsigned NOT NULL DEFAULT '0.0000',
  `username` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT 'username@example.com',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,10000.0000,'andi','$2y$10$c.e4DK7pVyLT.stmHxgAleWq4yViMmkwKz3x8XCo4b/u3r8g5OTnS','username@example.com'),(2,10000.0000,'caesar','$2y$10$0p2dlmu6HnhzEMf9UaUIfuaQP7tFVDMxgFcVs0irhGqhOxt6hJFaa','username@example.com'),(3,10000.0000,'eli','$2y$10$COO6EnTVrCPCEddZyWeEJeH9qPCwPkCS0jJpusNiru.XpRN6Jf7HW','username@example.com'),(4,10000.0000,'hdan','$2y$10$o9a4ZoHqVkVHSno6j.k34.wC.qzgeQTBHiwa3rpnLq7j2PlPJHo1G','username@example.com'),(5,10000.0000,'jason','$2y$10$ci2zwcWLJmSSqyhCnHKUF.AjoysFMvlIb1w4zfmCS7/WaOrmBnLNe','username@example.com'),(6,10000.0000,'john','$2y$10$dy.LVhWgoxIQHAgfCStWietGdJCPjnNrxKNRs5twGcMrQvAPPIxSy','username@example.com'),(7,10000.0000,'levatich','$2y$10$fBfk7L/QFiplffZdo6etM.096pt4Oyz2imLSp5s8HUAykdLXaz6MK','username@example.com'),(8,10000.0000,'rob','$2y$10$3pRWcBbGdAdzdDiVVybKSeFq6C50g80zyPRAxcsh2t5UnwAkG.I.2','username@example.com'),(9,7851.6800,'skroob','$2y$10$395b7wODm.o2N7W5UZSXXuXwrC0OtFB17w4VjPnCIn/nvv9e4XUQK','username@example.com'),(10,10000.0000,'zamyla','$2y$10$UOaRF0LGOaeHG4oaEkfO4O7vfI34B1W23WqHr9zCpXL68hfQsS3/e','username@example.com'),(11,1031074.1600,'modus','$2y$10$IEqLFs3OgVZQziPLdp/D8e.OMeSzHDMZ4XaxPA5AtcZbSLlUgCiIW','matt.obert@gmail.com'),(12,10000.0000,'cowface','$2y$10$jQ0RjXrlJEhF/zJbQA1vjeI5e2aUcJEOYx.kLdClTr569yQV.W8LK','foo@bar.com');
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

-- Dump completed on 2016-08-04 20:32:44
