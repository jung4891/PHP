-- MySQL dump 10.13  Distrib 5.1.71, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: stc
-- ------------------------------------------------------
-- Server version	5.1.71

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
-- Table structure for table `site_device`
--

DROP TABLE IF EXISTS `site_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_device` (
  `seq` int(11) NOT NULL AUTO_INCREMENT COMMENT '기본ai',
  `customer` varchar(128) NOT NULL COMMENT '고객사/등록사이트',
  `produce` varchar(128) NOT NULL COMMENT '지원장비/시스템',
  `sn` varchar(128) DEFAULT NULL COMMENT 'Serial-NUM',
  `version` varchar(128) DEFAULT NULL COMMENT '버젼',
  `license` varchar(64) DEFAULT NULL COMMENT '라이센스',
  `writer` varchar(16) NOT NULL COMMENT '최종등록자',
  `end_date` datetime NOT NULL COMMENT '최종등록일',
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_device`
--

LOCK TABLES `site_device` WRITE;
/*!40000 ALTER TABLE `site_device` DISABLE KEYS */;
INSERT INTO `site_device` VALUES (17,'기장군청','11','11','11','11','조희찬','2017-03-01 14:22:58'),(18,'부산상수도사업본부','test','test','test','trest','김수성','2017-03-01 16:04:05'),(19,'기장군청','111','','','','김수성','2017-03-01 16:54:43'),(20,'기장군청','111','','','','김수성','2017-03-01 16:54:48'),(21,'기장군청','11111','','','','김수성','2017-03-01 16:54:56'),(22,'기장군청','12313133','','','','김수성','2017-03-01 16:55:06'),(23,'기장군청','123131313','','','','김수성','2017-03-01 16:55:12'),(24,'기장군청','124131312313','','','','김수성','2017-03-01 16:55:17'),(25,'기장군청','1231321313','','','','김수성','2017-03-01 16:55:23'),(26,'기장군청','11111','','','','김수성','2017-03-01 16:55:29'),(28,'해운대구청','테스트장비1','test_SN_01','1.0','100','조희찬','2017-03-01 21:53:23'),(29,'해운대구청','테스트장비2','test_SN_02','2.0','2017-02 30','조희찬','2017-03-01 21:53:49');
/*!40000 ALTER TABLE `site_device` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-02  8:44:04
