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
-- Table structure for table `tech_doc_basic`
--

DROP TABLE IF EXISTS `tech_doc_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tech_doc_basic` (
  `seq` int(11) NOT NULL AUTO_INCREMENT COMMENT '기본ai',
  `doc_num` varchar(64) NOT NULL COMMENT '문서번호',
  `customer` varchar(128) NOT NULL COMMENT '고객사',
  `customer_manager` varchar(50) DEFAULT NULL,
  `produce` varchar(64) NOT NULL COMMENT '지원 장비/시스템',
  `work_name` varchar(16) NOT NULL COMMENT '작업명',
  `writer` varchar(16) NOT NULL COMMENT '작성자',
  `total_time` varchar(5) DEFAULT NULL,
  `start_time` datetime NOT NULL COMMENT '시작시간',
  `end_time` datetime NOT NULL COMMENT '종료시간',
  `engineer` varchar(128) NOT NULL COMMENT '담당SE',
  `handle` varchar(16) NOT NULL COMMENT '지원방법',
  `subject` varchar(255) DEFAULT NULL,
  `work_process_time` varchar(255) DEFAULT NULL,
  `work_process` text NOT NULL COMMENT '처리절차(내용)',
  `result` text NOT NULL COMMENT '처리결과',
  `insert_date` datetime NOT NULL COMMENT '입력일',
  `update_date` datetime NOT NULL COMMENT '수정일',
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tech_doc_basic`
--

LOCK TABLES `tech_doc_basic` WRITE;
/*!40000 ALTER TABLE `tech_doc_basic` DISABLE KEYS */;
INSERT INTO `tech_doc_basic` VALUES (1,'DUIT-TECH-08-16-11-005','기장군청',NULL,'MF2','방화벽제거','조희찬','3:00','0000-00-00 00:00:00','0000-00-00 00:00:00','조희찬','방문지원','2.0.22 버전 Unix 설치 가이드 (Solalis)','{[10:00-11:00]}','테스트','완료','2017-02-27 04:52:54','2017-02-27 04:52:54'),(2,'DUIT-TECH-08-16-11-005','',NULL,'','','김수성','','0000-00-00 00:00:00','0000-00-00 00:00:00','','','','','','','2017-02-27 13:21:07','2017-02-27 13:21:07'),(3,'DUIT-TECH-08-16-11-005','기장군청',NULL,'mf2','','김수성','','0000-00-00 00:00:00','0000-00-00 00:00:00','','','','{[-]}','','','2017-02-27 13:32:54','2017-02-27 13:32:54'),(4,'DUIT-TECH-08-16-11-005','',NULL,'','','조희찬','','0000-00-00 00:00:00','0000-00-00 00:00:00','','','','','','','2017-02-27 21:43:53','2017-02-27 21:43:53'),(5,'DUIT-TECH-08-16-11-005','기장군청',NULL,'MF2 110, MFI ','','조희찬','','0000-00-00 00:00:00','0000-00-00 00:00:00','','','','{[-]}','완료','','2017-02-27 22:59:19','2017-02-27 22:59:19');
/*!40000 ALTER TABLE `tech_doc_basic` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-28 18:34:18
