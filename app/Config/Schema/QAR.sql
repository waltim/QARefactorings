-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: QAR
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.16.04.1

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `result_question_id` int(11) NOT NULL,
  `choice` char(1) NOT NULL,
  `justify` text,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK` (`user_id`),
  KEY `fk_answers_result_questions1_idx` (`result_question_id`),
  CONSTRAINT `fk_answers_result_questions1` FOREIGN KEY (`result_question_id`) REFERENCES `result_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_answers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language_search_events`
--

DROP TABLE IF EXISTS `language_search_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language_search_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` tinyint(4) NOT NULL,
  `search_event_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_languages_has_search_events_search_events1_idx` (`search_event_id`),
  KEY `fk_languages_has_search_events_languages1_idx` (`language_id`),
  CONSTRAINT `fk_languages_has_search_events_languages1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_languages_has_search_events_search_events1` FOREIGN KEY (`search_event_id`) REFERENCES `search_events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language_search_events`
--

LOCK TABLES `language_search_events` WRITE;
/*!40000 ALTER TABLE `language_search_events` DISABLE KEYS */;
INSERT INTO `language_search_events` VALUES (5,1,5,'2018-09-02 16:33:20');
/*!40000 ALTER TABLE `language_search_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(25) NOT NULL,
  `brush` varchar(25) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'Java','java','2018-02-14 11:10:20');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metric_types`
--

DROP TABLE IF EXISTS `metric_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metric_types` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metric_types`
--

LOCK TABLES `metric_types` WRITE;
/*!40000 ALTER TABLE `metric_types` DISABLE KEYS */;
INSERT INTO `metric_types` VALUES (2,'Qualitativa','2018-02-14 11:10:22'),(3,'Quantitativa','2018-02-14 11:10:25');
/*!40000 ALTER TABLE `metric_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metrics`
--

DROP TABLE IF EXISTS `metrics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metrics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metric_type_id` tinyint(4) NOT NULL,
  `acronym` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK` (`metric_type_id`),
  CONSTRAINT `fk_metrics_metric_types1` FOREIGN KEY (`metric_type_id`) REFERENCES `metric_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metrics`
--

LOCK TABLES `metrics` WRITE;
/*!40000 ALTER TABLE `metrics` DISABLE KEYS */;
INSERT INTO `metrics` VALUES (1,3,'LOC','Linhas de código (linhas de código pertencentes aos métodos)','2018-02-14 11:10:25','2018-02-14 11:10:25'),(2,3,'ACCM','Complexidade ciclomática do método (quantidade de caminhos diferentes no método);','2018-02-14 11:10:25','2018-02-14 11:10:25'),(4,2,'LIKERT','Mede atitudes e comportamentos utilizando opções de resposta que variam de um extremo a outro.','2018-02-14 11:10:25','2018-02-14 11:10:25');
/*!40000 ALTER TABLE `metrics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participant_types`
--

DROP TABLE IF EXISTS `participant_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participant_types` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participant_types`
--

LOCK TABLES `participant_types` WRITE;
/*!40000 ALTER TABLE `participant_types` DISABLE KEYS */;
INSERT INTO `participant_types` VALUES (1,'Responsavel',NULL),(2,'Coordenador',NULL),(3,'Intrevistado',NULL),(4,'Cooperador',NULL);
/*!40000 ALTER TABLE `participant_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `search_event_id` int(11) NOT NULL,
  `participant_type_id` tinyint(4) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_participants_search_events1_idx` (`search_event_id`),
  KEY `fk_participants_users1_idx` (`user_id`),
  KEY `fk_participants_participant_types1_idx` (`participant_type_id`),
  CONSTRAINT `fk_participants_participant_types1` FOREIGN KEY (`participant_type_id`) REFERENCES `participant_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_participants_search_events1` FOREIGN KEY (`search_event_id`) REFERENCES `search_events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_participants_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
INSERT INTO `participants` VALUES (5,2,5,1,'2018-09-02 16:33:21'),(7,2,5,4,'2018-09-02 18:30:20'),(8,2,5,4,'2018-09-02 18:34:15'),(9,2,5,4,'2018-09-02 18:34:38'),(10,2,5,4,'2018-09-02 18:35:18');
/*!40000 ALTER TABLE `participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_types`
--

DROP TABLE IF EXISTS `question_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_types` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(25) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_types`
--

LOCK TABLES `question_types` WRITE;
/*!40000 ALTER TABLE `question_types` DISABLE KEYS */;
INSERT INTO `question_types` VALUES (1,'Multipla Escolha','2018-02-14 11:10:25'),(2,'Descritiva','2018-02-14 11:10:25'),(3,'Numerica','2018-02-14 11:10:25');
/*!40000 ALTER TABLE `question_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `participant_id` int(11) NOT NULL,
  `question_type_id` tinyint(4) NOT NULL,
  `description` text COLLATE utf8_czech_ci NOT NULL,
  `jumps` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questions_question_types1_idx` (`question_type_id`),
  KEY `fk_questions_participants1_idx` (`participant_id`),
  CONSTRAINT `fk_questions_participants1` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_questions_question_types1` FOREIGN KEY (`question_type_id`) REFERENCES `question_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (2,7,1,'É fácil compreender o propósito desta transformação?',NULL,'2018-09-02 18:30:20','2018-09-02 18:30:20'),(3,8,1,'Você concorda que a transformação melhorou a legibilidade?',NULL,'2018-09-02 18:34:15','2018-09-02 18:34:15'),(4,9,1,'Você concorda que a transformação tornou o código mais conciso?',NULL,'2018-09-02 18:34:39','2018-09-02 18:34:39'),(5,10,1,'Você concorda que essa transformação é relevante?',NULL,'2018-09-02 18:35:18','2018-09-02 18:35:18');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `result_questions`
--

DROP TABLE IF EXISTS `result_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `result_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_result_questions_questions1_idx` (`question_id`),
  KEY `fk_result_questions_results1_idx` (`result_id`),
  CONSTRAINT `fk_result_questions_questions1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_result_questions_results1` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `result_questions`
--

LOCK TABLES `result_questions` WRITE;
/*!40000 ALTER TABLE `result_questions` DISABLE KEYS */;
INSERT INTO `result_questions` VALUES (37,165,2,'2018-09-15 20:05:34'),(38,165,3,'2018-09-15 20:05:34'),(39,165,4,'2018-09-15 20:05:34'),(40,165,5,'2018-09-15 20:05:34'),(41,177,2,'2018-09-15 20:05:35'),(42,177,3,'2018-09-15 20:05:35'),(43,177,4,'2018-09-15 20:05:35'),(44,177,5,'2018-09-15 20:05:35'),(45,180,2,'2018-09-15 20:05:35'),(46,180,3,'2018-09-15 20:05:35'),(47,180,4,'2018-09-15 20:05:35'),(48,180,5,'2018-09-15 20:05:35'),(49,183,2,'2018-09-15 20:05:35'),(50,183,3,'2018-09-15 20:05:35'),(51,183,4,'2018-09-15 20:05:35'),(52,183,5,'2018-09-15 20:05:35'),(53,186,2,'2018-09-15 20:05:35'),(54,186,3,'2018-09-15 20:05:35'),(55,186,4,'2018-09-15 20:05:35'),(56,186,5,'2018-09-15 20:05:35'),(57,189,2,'2018-09-15 20:05:35'),(58,189,3,'2018-09-15 20:05:35'),(59,189,4,'2018-09-15 20:05:35'),(60,189,5,'2018-09-15 20:05:35'),(61,192,2,'2018-09-15 20:05:35'),(62,192,3,'2018-09-15 20:05:36'),(63,192,4,'2018-09-15 20:05:36'),(64,192,5,'2018-09-15 20:05:36'),(65,195,2,'2018-09-15 20:05:36'),(66,195,3,'2018-09-15 20:05:36'),(67,195,4,'2018-09-15 20:05:36'),(68,195,5,'2018-09-15 20:05:36'),(69,210,2,'2018-09-15 20:05:36'),(70,210,3,'2018-09-15 20:05:36'),(71,210,4,'2018-09-15 20:05:36'),(72,210,5,'2018-09-15 20:05:36'),(73,213,2,'2018-09-15 20:05:36'),(74,213,3,'2018-09-15 20:05:36'),(75,213,4,'2018-09-15 20:05:36'),(76,213,5,'2018-09-15 20:05:36'),(77,225,2,'2018-09-15 20:05:36'),(78,225,3,'2018-09-15 20:05:36'),(79,225,4,'2018-09-15 20:05:36'),(80,225,5,'2018-09-15 20:05:36'),(81,228,2,'2018-09-15 20:05:36'),(82,228,3,'2018-09-15 20:05:37'),(83,228,4,'2018-09-15 20:05:37'),(84,228,5,'2018-09-15 20:05:37'),(85,231,2,'2018-09-15 20:05:37'),(86,231,3,'2018-09-15 20:05:37'),(87,231,4,'2018-09-15 20:05:37'),(88,231,5,'2018-09-15 20:05:37'),(89,234,2,'2018-09-15 20:05:37'),(90,234,3,'2018-09-15 20:05:37'),(91,234,4,'2018-09-15 20:05:37'),(92,234,5,'2018-09-15 20:05:37'),(93,237,2,'2018-09-15 20:05:37'),(94,237,3,'2018-09-15 20:05:37'),(95,237,4,'2018-09-15 20:05:37'),(96,237,5,'2018-09-15 20:05:37'),(97,198,2,'2018-09-15 20:05:37'),(98,198,3,'2018-09-15 20:05:37'),(99,198,4,'2018-09-15 20:05:37'),(100,198,5,'2018-09-15 20:05:37'),(101,204,2,'2018-09-15 20:05:37'),(102,204,3,'2018-09-15 20:05:37'),(103,204,4,'2018-09-15 20:05:38'),(104,204,5,'2018-09-15 20:05:38'),(105,216,2,'2018-09-15 20:05:38'),(106,216,3,'2018-09-15 20:05:38'),(107,216,4,'2018-09-15 20:05:38'),(108,216,5,'2018-09-15 20:05:38'),(109,219,2,'2018-09-15 20:05:38'),(110,219,3,'2018-09-15 20:05:38'),(111,219,4,'2018-09-15 20:05:38'),(112,219,5,'2018-09-15 20:05:38'),(113,201,2,'2018-09-15 20:05:38'),(114,201,3,'2018-09-15 20:05:38'),(115,201,4,'2018-09-15 20:05:38'),(116,201,5,'2018-09-15 20:05:38'),(117,207,2,'2018-09-15 20:05:39'),(118,207,3,'2018-09-15 20:05:39'),(119,207,4,'2018-09-15 20:05:39'),(120,207,5,'2018-09-15 20:05:39'),(121,168,2,'2018-09-15 20:05:39'),(122,168,3,'2018-09-15 20:05:39'),(123,168,4,'2018-09-15 20:05:39'),(124,168,5,'2018-09-15 20:05:39'),(125,171,2,'2018-09-15 20:05:39'),(126,171,3,'2018-09-15 20:05:39'),(127,171,4,'2018-09-15 20:05:39'),(128,171,5,'2018-09-15 20:05:39'),(129,174,2,'2018-09-15 20:05:39'),(130,174,3,'2018-09-15 20:05:39'),(131,174,4,'2018-09-15 20:05:40'),(132,174,5,'2018-09-15 20:05:40'),(133,222,2,'2018-09-15 20:05:40'),(134,222,3,'2018-09-15 20:05:40'),(135,222,4,'2018-09-15 20:05:40'),(136,222,5,'2018-09-15 20:05:40');
/*!40000 ALTER TABLE `result_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transformation_id` int(11) NOT NULL,
  `metric_id` int(11) NOT NULL,
  `before` int(11) DEFAULT NULL,
  `after` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK` (`transformation_id`,`metric_id`),
  KEY `fk_results_metrics1_idx` (`metric_id`),
  CONSTRAINT `fk_results_metrics1` FOREIGN KEY (`metric_id`) REFERENCES `metrics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_results_transformations1` FOREIGN KEY (`transformation_id`) REFERENCES `transformations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
INSERT INTO `results` VALUES (163,64,1,4,4,'2018-09-15 20:01:08'),(164,64,2,1,1,'2018-09-15 20:01:08'),(165,64,4,NULL,NULL,'2018-09-15 20:01:08'),(166,65,1,12,8,'2018-09-15 20:01:12'),(167,65,2,3,1,'2018-09-15 20:01:12'),(168,65,4,NULL,NULL,'2018-09-15 20:01:12'),(169,66,1,10,6,'2018-09-15 20:01:18'),(170,66,2,2,1,'2018-09-15 20:01:19'),(171,66,4,NULL,NULL,'2018-09-15 20:01:19'),(172,67,1,8,4,'2018-09-15 20:01:20'),(173,67,2,1,1,'2018-09-15 20:01:21'),(174,67,4,NULL,NULL,'2018-09-15 20:01:21'),(175,68,1,7,20,'2018-09-15 20:01:23'),(176,68,2,1,3,'2018-09-15 20:01:23'),(177,68,4,NULL,NULL,'2018-09-15 20:01:23'),(178,69,1,11,28,'2018-09-15 20:01:25'),(179,69,2,2,7,'2018-09-15 20:01:25'),(180,69,4,NULL,NULL,'2018-09-15 20:01:25'),(181,70,1,3,7,'2018-09-15 20:01:39'),(182,70,2,1,1,'2018-09-15 20:01:39'),(183,70,4,NULL,NULL,'2018-09-15 20:01:39'),(184,71,1,7,15,'2018-09-15 20:01:41'),(185,71,2,1,2,'2018-09-15 20:01:41'),(186,71,4,NULL,NULL,'2018-09-15 20:01:41'),(187,72,1,6,7,'2018-09-15 20:01:43'),(188,72,2,1,1,'2018-09-15 20:01:43'),(189,72,4,NULL,NULL,'2018-09-15 20:01:43'),(190,73,1,6,7,'2018-09-15 20:01:45'),(191,73,2,1,1,'2018-09-15 20:01:45'),(192,73,4,NULL,NULL,'2018-09-15 20:01:45'),(193,74,1,18,12,'2018-09-15 20:01:49'),(194,74,2,1,1,'2018-09-15 20:01:49'),(195,74,4,NULL,NULL,'2018-09-15 20:01:49'),(196,75,1,14,8,'2018-09-15 20:01:52'),(197,75,2,1,1,'2018-09-15 20:01:52'),(198,75,4,NULL,NULL,'2018-09-15 20:01:52'),(199,76,1,3,5,'2018-09-15 20:01:54'),(200,76,2,1,1,'2018-09-15 20:01:54'),(201,76,4,NULL,NULL,'2018-09-15 20:01:54'),(202,77,1,11,5,'2018-09-15 20:01:56'),(203,77,2,5,2,'2018-09-15 20:01:56'),(204,77,4,NULL,NULL,'2018-09-15 20:01:56'),(205,78,1,7,9,'2018-09-15 20:01:59'),(206,78,2,4,3,'2018-09-15 20:01:59'),(207,78,4,NULL,NULL,'2018-09-15 20:02:00'),(208,79,1,17,10,'2018-09-15 20:02:05'),(209,79,2,1,1,'2018-09-15 20:02:05'),(210,79,4,NULL,NULL,'2018-09-15 20:02:05'),(211,80,1,6,10,'2018-09-15 20:02:07'),(212,80,2,1,1,'2018-09-15 20:02:07'),(213,80,4,NULL,NULL,'2018-09-15 20:02:07'),(214,81,1,16,7,'2018-09-15 20:02:08'),(215,81,2,6,6,'2018-09-15 20:02:09'),(216,81,4,NULL,NULL,'2018-09-15 20:02:09'),(217,82,1,8,6,'2018-09-15 20:02:12'),(218,82,2,3,3,'2018-09-15 20:02:12'),(219,82,4,NULL,NULL,'2018-09-15 20:02:12'),(220,83,1,7,6,'2018-09-15 20:02:31'),(221,83,2,1,1,'2018-09-15 20:02:31'),(222,83,4,NULL,NULL,'2018-09-15 20:02:31'),(223,84,1,7,11,'2018-09-15 20:02:33'),(224,84,2,3,3,'2018-09-15 20:02:33'),(225,84,4,NULL,NULL,'2018-09-15 20:02:33'),(226,85,1,5,5,'2018-09-15 20:02:35'),(227,85,2,2,2,'2018-09-15 20:02:35'),(228,85,4,NULL,NULL,'2018-09-15 20:02:35'),(229,86,1,15,15,'2018-09-15 20:02:42'),(230,86,2,5,5,'2018-09-15 20:02:42'),(231,86,4,NULL,NULL,'2018-09-15 20:02:42'),(232,87,1,9,2,'2018-09-15 20:02:44'),(233,87,2,1,1,'2018-09-15 20:02:44'),(234,87,4,NULL,NULL,'2018-09-15 20:02:45'),(235,88,1,19,17,'2018-09-15 20:02:47'),(236,88,2,3,3,'2018-09-15 20:02:47'),(237,88,4,NULL,NULL,'2018-09-15 20:02:47'),(238,89,1,12,8,'2018-09-16 11:20:23'),(239,89,2,3,1,'2018-09-16 11:20:23'),(240,89,4,NULL,NULL,'2018-09-16 11:20:23');
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search_events`
--

DROP TABLE IF EXISTS `search_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `school` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_events`
--

LOCK TABLES `search_events` WRITE;
/*!40000 ALTER TABLE `search_events` DISABLE KEYS */;
INSERT INTO `search_events` VALUES (5,'Impacto de refatorações de código com expressões lambda sobre a legibilidade: Uma análise experimental','Universidade de Brasília','2018-09-02 16:33:20','2018-09-02 16:33:20');
/*!40000 ALTER TABLE `search_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transformation_type_languages`
--

DROP TABLE IF EXISTS `transformation_type_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transformation_type_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` tinyint(4) NOT NULL,
  `transformation_type_id` tinyint(4) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transformation_type_languages_languages1_idx` (`language_id`),
  KEY `fk_transformation_type_languages_transformation_types1_idx` (`transformation_type_id`),
  CONSTRAINT `fk_transformation_type_languages_languages1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transformation_type_languages_transformation_types1` FOREIGN KEY (`transformation_type_id`) REFERENCES `transformation_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transformation_type_languages`
--

LOCK TABLES `transformation_type_languages` WRITE;
/*!40000 ALTER TABLE `transformation_type_languages` DISABLE KEYS */;
/*!40000 ALTER TABLE `transformation_type_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transformation_types`
--

DROP TABLE IF EXISTS `transformation_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transformation_types` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(120) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transformation_types`
--

LOCK TABLES `transformation_types` WRITE;
/*!40000 ALTER TABLE `transformation_types` DISABLE KEYS */;
INSERT INTO `transformation_types` VALUES (1,'Anonymous inner classes -> Lambda','2018-02-14 11:10:25'),(2,'ForEach -> Lambda','2018-02-14 11:10:25'),(3,'ForEach/Filter -> Lambda','2018-02-14 11:10:25'),(4,'ForEach/Exist -> Lambda','2018-02-14 11:10:25'),(5,'ForEach/Map -> Lambda','2018-02-14 11:10:25');
/*!40000 ALTER TABLE `transformation_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transformations`
--

DROP TABLE IF EXISTS `transformations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transformations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transformation_type_id` tinyint(4) NOT NULL,
  `language_id` tinyint(4) NOT NULL,
  `search_event_id` int(11) NOT NULL,
  `code_before` text,
  `deletions` varchar(50) DEFAULT NULL,
  `code_after` text,
  `additions` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `diff_id` text NOT NULL,
  `site_link` text NOT NULL,
  `old_code` varchar(255) DEFAULT NULL,
  `new_code` varchar(255) DEFAULT NULL,
  `line_start` varchar(45) DEFAULT NULL,
  `line_end` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transformations_languages1_idx` (`language_id`),
  KEY `fk_transformations_transformation_types1_idx` (`transformation_type_id`),
  KEY `fk_transformations_search_events1_idx` (`search_event_id`),
  CONSTRAINT `fk_transformations_languages1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transformations_search_events1` FOREIGN KEY (`search_event_id`) REFERENCES `search_events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transformations_transformation_types1` FOREIGN KEY (`transformation_type_id`) REFERENCES `transformation_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transformations`
--

LOCK TABLES `transformations` WRITE;
/*!40000 ALTER TABLE `transformations` DISABLE KEYS */;
INSERT INTO `transformations` VALUES (64,1,1,5,'<p>\n<br/>    	@Override\n<br/>    -	public boolean supportsParameter(MethodParameter parameter) {\n<br/>    -		return parameter.hasParameterAnnotation(Value.class);\n<br/>    	}\n<br/>    <br/></p>',NULL,'<p>\n<br/>    	@Override\n<br/>    +	public boolean supportsParameter(MethodParameter param) {\n<br/>    +		return checkAnnotatedParamNoReactiveWrapper(param, Value.class, (annot, type) -&gt; true);\n<br/>    	}\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:08','2018-09-15 20:01:08','diff-82984a3951d9fc77df2cd9d6421dc5d6-20180915200108','https://github.com/spring-projects/spring-framework/commit/164204ca04b9b369267ef5e36c2f243b3898bae1#diff-82984a3951d9fc77df2cd9d6421dc5d6','/var/www/QARefactorings/app/webroot/files/diff-82984a3951d9fc77df2cd9d6421dc5d6-20180915200108/a.txt','/var/www/QARefactorings/app/webroot/files/diff-82984a3951d9fc77df2cd9d6421dc5d6-20180915200108/b.txt','L49','R57'),(65,5,1,5,'<p>\n<br/>        public ListField(String name, String humanName, List&lt;String&gt; defaultValue, Map&lt;String, String&gt; values, String description, Optional isOptional, Attribute... attributes) {\n<br/>            super(FIELD_TYPE, name, humanName, description, isOptional);\n<br/>            this.defaultValue = defaultValue;\n<br/>            this.values = values;\n<br/>    -\n<br/>    -        this.attributes = new ArrayList&lt;&gt;();\n<br/>    -        if (attributes != null) {\n<br/>    -            for (Attribute attribute : attributes) {\n<br/>    -                this.attributes.add(attribute.toString().toLowerCase(Locale.ENGLISH));\n<br/>    -            }\n<br/>    -        }\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>\n<br/>        public ListField(String name, String humanName, List&lt;String&gt; defaultValue, Map&lt;String, String&gt; values, String description, Optional isOptional, Attribute... attributes) {\n<br/>            super(FIELD_TYPE, name, humanName, description, isOptional);\n<br/>            this.defaultValue = defaultValue;\n<br/>            this.values = values;\n<br/>    +        this.attributes = Arrays.stream(attributes)\n<br/>    +                .map(attribute -&gt; attribute.toString().toLowerCase(Locale.ENGLISH))\n<br/>    +                .collect(Collectors.toList());\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:12','2018-09-15 20:01:12','diff-d663fea3b2dce1447b9948bc83ad3683-20180915200112','https://github.com/Graylog2/graylog2-server/commit/50f59c0f17786f1ac180037728e4c8486ef873ae#diff-d663fea3b2dce1447b9948bc83ad3683','/var/www/QARefactorings/app/webroot/files/diff-d663fea3b2dce1447b9948bc83ad3683-20180915200112/a.txt','/var/www/QARefactorings/app/webroot/files/diff-d663fea3b2dce1447b9948bc83ad3683-20180915200112/b.txt','L46','R49'),(66,5,1,5,'<p>d>\n<br/>        private static Collection&lt;CharSequenceJavaFileObject&gt; wrap(final Map&lt;String, CharSequence&gt; sources)\n<br/>        {\n<br/>    -        final Collection&lt;CharSequenceJavaFileObject&gt; collection = new ArrayList&lt;&gt;(sources.size());\n<br/>    -        for (final Map.Entry&lt;String, CharSequence&gt; entry : sources.entrySet())\n<br/>    -        {\n<br/>    -            collection.add(new CharSequenceJavaFileObject(entry.getKey(), entry.getValue()));\n<br/>    -        }\n<br/>    -\n<br/>    -        return collection;\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>        private static Collection&lt;CharSequenceJavaFileObject&gt; wrap(final Map&lt;String, CharSequence&gt; sources)\n<br/>        {\n<br/>    +        return sources.entrySet()\n<br/>    +            .stream()\n<br/>    +            .map((e) -&gt; new CharSequenceJavaFileObject(e.getKey(), e.getValue())).collect(toList());\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:18','2018-09-15 20:01:19','diff-37b7ff89b52726a431d8fc73423ffd79-20180915200118','https://github.com/real-logic/Agrona/commit/394dee1cb09b2c06b4ff887bfe7fcb813862fb3c#diff-37b7ff89b52726a431d8fc73423ffd79','/var/www/QARefactorings/app/webroot/files/diff-37b7ff89b52726a431d8fc73423ffd79-20180915200118/a.txt','/var/www/QARefactorings/app/webroot/files/diff-37b7ff89b52726a431d8fc73423ffd79-20180915200118/b.txt','L166','R176'),(67,5,1,5,'<p>d>\n<br/>        @Override\n<br/>        public List&lt;String&gt; attributes(final String attribute) {\n<br/>    -        return Lists.transform(this, new Function&lt;E, String&gt;() {\n<br/>    -            public String apply(E webElement) {\n<br/>    -                return webElement.attribute(attribute);\n<br/>    -            }\n<br/>    -        });\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>        @Override\n<br/>        public List&lt;String&gt; attributes(final String attribute) {\n<br/>    +        return stream().map(webElement -&gt; webElement.attribute(attribute)).collect(Collectors.toList());\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:20','2018-09-15 20:01:21','diff-b8d56c1e212b1e2b113c91aeb2c19cd8-20180915200120','https://github.com/FluentLenium/FluentLenium/commit/73bac61cc819c5f04d8acac29575877e18de3332#diff-b8d56c1e212b1e2b113c91aeb2c19cd8','/var/www/QARefactorings/app/webroot/files/diff-b8d56c1e212b1e2b113c91aeb2c19cd8-20180915200120/a.txt','/var/www/QARefactorings/app/webroot/files/diff-b8d56c1e212b1e2b113c91aeb2c19cd8-20180915200120/b.txt','L417','R421'),(68,1,1,5,'<p>d>\n<br/>                @Override\n<br/>    -            public void onFailure(Exception t) {\n<br/>    -                logger.warn((Supplier&lt;?&gt;) () -&gt; new ParameterizedMessage(\"Failed to clear scroll [{}]\", scrollId), t);\n<br/>                    onCompletion.run();\n<br/>                }\n<br/>            });\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>                @Override\n<br/>    +            public void onFailure(Exception e) {\n<br/>    +                logFailure(e);\n<br/>                    onCompletion.run();\n<br/>                }\n<br/>    +\n<br/>    +            private void logFailure(Exception e) {\n<br/>    +                if (e instanceof ResponseException) {\n<br/>    +                    ResponseException re = (ResponseException) e;\n<br/>    +                    if (remoteVersion.before(Version.V_2_0_0) &amp;&amp; re.getResponse().getStatusLine().getStatusCode() == 404) {\n<br/>    +                        logger.debug((Supplier&lt;?&gt;) () -&gt; new ParameterizedMessage(\n<br/>    +                                &quot;Failed to clear scroll [{}] from pre-2.0 Elasticsearch. This is normal if the request terminated &quot;\n<br/>    +                                        + &quot;normally as the scroll has already been cleared automatically.&quot;, scrollId), e);\n<br/>    +                        return;\n<br/>    +                    }\n<br/>    +                }\n<br/>    +                logger.warn((Supplier&lt;?&gt;) () -&gt; new ParameterizedMessage(&quot;Failed to clear scroll [{}]&quot;, scrollId), e);\n<br/>    +            }\n<br/>            });\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:22','2018-09-15 20:01:23','diff-10be32893f947fec2c278044519a4d21-20180915200122','https://github.com/elastic/elasticsearch/commit/d479b0e7c722569d99bbe30f70c2ac2a7b8fb597#diff-10be32893f947fec2c278044519a4d21','/var/www/QARefactorings/app/webroot/files/diff-10be32893f947fec2c278044519a4d21-20180915200122/a.txt','/var/www/QARefactorings/app/webroot/files/diff-10be32893f947fec2c278044519a4d21-20180915200122/b.txt','L120','R141'),(69,1,1,5,'<p>>\n<br/>    -    /** ensure a cluster is form with {@link #nodes}.size() nodes, but do so by using the client of the specified node */\n<br/>        private void validateClusterFormed(String viaNode) {\n<br/>    -        final int size = nodes.size();\n<br/>    -        logger.trace(&quot;validating cluster formed via [{}], expecting [{}]&quot;, viaNode, size);\n<br/>            final Client client = client(viaNode);\n<br/>    -        ClusterHealthResponse response = client.admin().cluster().prepareHealth().setWaitForNodes(Integer.toString(size)).get();\n<br/>    -        if (response.isTimedOut()) {\n<br/>    -            logger.warn(&quot;failed to wait for a cluster of size [{}], got [{}]&quot;, size, response);\n<br/>    -            throw new IllegalStateException(&quot;cluster failed to reach the expected size of [&quot; + size + &quot;]&quot;);\n<br/>            }\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>>\n<br/>    +    /** ensure a cluster is formed with all published nodes, but do so by using the client of the specified node */\n<br/>        private void validateClusterFormed(String viaNode) {\n<br/>    +        Set&lt;DiscoveryNode&gt; expectedNodes = new HashSet&lt;&gt;();\n<br/>    +        for (NodeAndClient nodeAndClient : nodes.values()) {\n<br/>    +            expectedNodes.add(getInstanceFromNode(ClusterService.class, nodeAndClient.node()).localNode());\n<br/>    +        }\n<br/>    +        logger.trace(&quot;validating cluster formed via [{}], expecting {}&quot;, viaNode, expectedNodes);\n<br/>            final Client client = client(viaNode);\n<br/>    +        try {\n<br/>    +            if (awaitBusy(() -&gt; {\n<br/>    +                DiscoveryNodes discoveryNodes = client.admin().cluster().prepareState().get().getState().nodes();\n<br/>    +                if (discoveryNodes.getSize() != expectedNodes.size()) {\n<br/>    +                    return false;\n<br/>    +                }\n<br/>    +                for (DiscoveryNode expectedNode : expectedNodes) {\n<br/>    +                    if (discoveryNodes.nodeExists(expectedNode) == false) {\n<br/>    +                        return false;\n<br/>    +                    }\n<br/>    +                }\n<br/>    +                return true;\n<br/>    +            }, 30, TimeUnit.SECONDS) == false) {\n<br/>    +                throw new IllegalStateException(&quot;cluster failed to from with expected nodes &quot; + expectedNodes + &quot; and actual nodes &quot; +\n<br/>    +                    client.admin().cluster().prepareState().get().getState().nodes());\n<br/>    +            }\n<br/>    +        } catch (InterruptedException e) {\n<br/>    +            throw new IllegalStateException(e);\n<br/>            }\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:24','2018-09-15 20:01:25','diff-80781e38e5de74275f62a1934ae17d9a-20180915200124','https://github.com/elastic/elasticsearch/commit/7c55d7084253a5040587ba3ac62139ce005d1963#diff-80781e38e5de74275f62a1934ae17d9a','/var/www/QARefactorings/app/webroot/files/diff-80781e38e5de74275f62a1934ae17d9a-20180915200124/a.txt','/var/www/QARefactorings/app/webroot/files/diff-80781e38e5de74275f62a1934ae17d9a-20180915200124/b.txt','L1074','R1104'),(70,1,1,5,'<p>d>\n<br/>        private void initFab() {\n<br/>    -        mFloatingButton.setOnClickListener(v -&gt; mPresenter.addNewApp());\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>        private void initFab() {\n<br/>    +        mFloatingButton.setOnClickListener(v -&gt; {\n<br/>    +            CircularAnim.fullActivity(this, mFloatingButton)\n<br/>    +                    .colorOrImageRes(R.color.colorPrimaryRavel)\n<br/>    +                    .go(() -&gt; ListAppActivity.gotoListApp(this));\n<br/>    +        });\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:39','2018-09-15 20:01:39','diff-a3e60a66d5d32b8a6755633f27ee2aee-20180915200139','https://github.com/asLody/VirtualApp/commit/963f78c437609897b78904df6e6dd4509ec46b56#diff-a3e60a66d5d32b8a6755633f27ee2aee','/var/www/QARefactorings/app/webroot/files/diff-a3e60a66d5d32b8a6755633f27ee2aee-20180915200139/a.txt','/var/www/QARefactorings/app/webroot/files/diff-a3e60a66d5d32b8a6755633f27ee2aee-20180915200139/b.txt','L109','R125'),(71,1,1,5,'<p>\n<br/>        // We should unregister all deployed verticles.\n<br/>    @@ -26,12 +30,23 @@ public void stop() {\n<br/>      @Bind(aggregate = true)\n<br/>      public void bindVerticle(Verticle verticle) {\n<br/>        LOGGER.info(&quot;Deploying verticle &quot; + verticle);\n<br/>    -    vertx.deployVerticle(verticle);\n<br/>      }\n<br/>    <br/></p>',NULL,'<p>\n<br/>        // We should unregister all deployed verticles.\n<br/>    @@ -26,12 +30,23 @@ public void stop() {\n<br/>      @Bind(aggregate = true)\n<br/>      public void bindVerticle(Verticle verticle) {\n<br/>        LOGGER.info(&quot;Deploying verticle &quot; + verticle);\n<br/>    +    TcclSwitch.executeWithTCCLSwitch(() -&gt; {\n<br/>    +      vertx.deployVerticle(verticle, ar -&gt; {\n<br/>    +        if (ar.succeeded()) {\n<br/>    +          deploymentIds.put(verticle, ar.result());\n<br/>    +        } else {\n<br/>    +          LOGGER.log(Level.SEVERE, &quot;Cannot deploy &quot; + verticle, ar.cause());\n<br/>    +        }\n<br/>    +      });\n<br/>    +    });\n<br/>      }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:41','2018-09-15 20:01:41','diff-ee83a3df87aeca91562e7452094768eb-20180915200141','https://github.com/vert-x3/vertx-examples/commit/c980de3d9c44b21950700a28164622a236cb0632#diff-ee83a3df87aeca91562e7452094768eb','/var/www/QARefactorings/app/webroot/files/diff-ee83a3df87aeca91562e7452094768eb-20180915200141/a.txt','/var/www/QARefactorings/app/webroot/files/diff-ee83a3df87aeca91562e7452094768eb-20180915200141/b.txt','L23','R43'),(72,1,1,5,'<p>\n<br/>      @Validate\n<br/>    -  public void start() {\n<br/>        LOGGER.info(&quot;Creating vertx HTTP server&quot;);\n<br/>    -    server = vertx.createHttpServer().requestHandler((r) -&gt; {\n<br/>          r.response().end(&quot;Hello from OSGi !&quot;);\n<br/>        }).listen(8080);\n<br/>    <br/></p>',NULL,'<p>\n<br/>      @Validate\n<br/>    +  public void start() throws Exception {\n<br/>        LOGGER.info(&quot;Creating vertx HTTP server&quot;);\n<br/>    +    HttpServer server = executeWithTCCLSwitch(() -&gt; vertx.createHttpServer());\n<br/>    +    server.requestHandler((r) -&gt; {\n<br/>          r.response().end(&quot;Hello from OSGi !&quot;);\n<br/>        }).listen(8080);\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:43','2018-09-15 20:01:43','diff-5522c63d606923f978eb04c2eb5e85bb-20180915200143','https://github.com/vert-x3/vertx-examples/commit/c980de3d9c44b21950700a28164622a236cb0632#diff-5522c63d606923f978eb04c2eb5e85bb','/var/www/QARefactorings/app/webroot/files/diff-5522c63d606923f978eb04c2eb5e85bb-20180915200143/a.txt','/var/www/QARefactorings/app/webroot/files/diff-5522c63d606923f978eb04c2eb5e85bb-20180915200143/b.txt','L21','R32'),(73,1,1,5,'<p>\n<br/>        // Start the front end server using the Jax-RS controller\n<br/>        vertx.createHttpServer()\n<br/>            .requestHandler(new VertxRequestHandler(vertx, deployment))\n<br/>    -        .listen(8080);\n<br/>    -    System.out.println(&quot;started&quot;);\n<br/>      }\n<br/>    <br/></p>',NULL,'<p>\n<br/>        // Start the front end server using the Jax-RS controller\n<br/>        vertx.createHttpServer()\n<br/>            .requestHandler(new VertxRequestHandler(vertx, deployment))\n<br/>    +        .listen(8080, ar -&gt; {\n<br/>    +          System.out.println(&quot;Server started on port &quot;+ ar.result().actualPort());\n<br/>    +        });\n<br/>      }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:45','2018-09-15 20:01:45','diff-519e3a1391145ba93c3a91bcd4474d33-20180915200145','https://github.com/vert-x3/vertx-examples/commit/4da3461c80594f15598f66e96c39ba21772abf3f#diff-519e3a1391145ba93c3a91bcd4474d33','/var/www/QARefactorings/app/webroot/files/diff-519e3a1391145ba93c3a91bcd4474d33-20180915200145/a.txt','/var/www/QARefactorings/app/webroot/files/diff-519e3a1391145ba93c3a91bcd4474d33-20180915200145/b.txt','L20','R27'),(74,1,1,5,'<p>\n<br/>        @Test\n<br/>        public void testExportCSV() throws Throwable\n<br/>        {\n<br/>    -        ExportDBTask task = new ExportDBTask(null);\n<br/>    -        task.setListener(new ExportDBTask.Listener()\n<br/>    -        {\n<br/>    -            @Override\n<br/>    -            public void onExportDBFinished(String filename)\n<br/>    -            {\n<br/>    -                assertThat(filename, is(not(nullValue())));\n<br/>    -                File f = new File(filename);\n<br/>    -                assertTrue(f.exists());\n<br/>    -                assertTrue(f.canRead());\n<br/>    -            }\n<br/>            });\n<br/>    -        task.execute();\n<br/>            waitForAsyncTasks();\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>\n<br/>        @Test\n<br/>        public void testExportCSV() throws Throwable\n<br/>        {\n<br/>    +        ExportDBTask task = new ExportDBTask(filename -&gt; {\n<br/>    +            assertThat(filename, is(not(nullValue())));\n<br/>    +            File f = new File(filename);\n<br/>    +            assertTrue(f.exists());\n<br/>    +            assertTrue(f.canRead());\n<br/>            });\n<br/>    +        taskRunner.execute(task);\n<br/>            waitForAsyncTasks();\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:49','2018-09-15 20:01:49','diff-d1aadeca7890eb5e0471d5d3ef093f3f-20180915200149','https://github.com/iSoron/uhabits/commit/d54de9df89b23e4a9c57dcf1cf5c2e639cb09bd9#diff-d1aadeca7890eb5e0471d5d3ef093f3f','/var/www/QARefactorings/app/webroot/files/diff-d1aadeca7890eb5e0471d5d3ef093f3f-20180915200149/a.txt','/var/www/QARefactorings/app/webroot/files/diff-d1aadeca7890eb5e0471d5d3ef093f3f-20180915200149/b.txt','L48','R60'),(75,2,1,5,'<p>\n<br/>            Map&lt;String, Object&gt; output = new HashMap&lt;&gt;();\n<br/>            output.put(Messages.SUMMARY_KEY,\n<br/>                Formatter.formatSummary(numFiles, numSkipped, numErrors, numWarnings).replace(NEWLINE_PATTERN, &quot;&quot;));\n<br/>    -        Collections.sort(FILES, Collections.reverseOrder(new Comparator&lt;Map&lt;String, Object&gt;&gt;() {\n<br/>    -            @Override\n<br/>    -            public int compare(Map&lt;String, Object&gt; o1, Map&lt;String, Object&gt; o2) {\n<br/>    -                return Integer.compare(\n<br/>    -                    ((List) o1.get(Messages.VIOLATIONS_KEY)).size(),\n<br/>    -                    ((List) o2.get(Messages.VIOLATIONS_KEY)).size()\n<br/>    -                );\n<br/>    -            }\n<br/>    -        }));\n<br/>            output.put(Messages.FILES_KEY, FILES);\n<br/>            output.put(Messages.VERSION_LONG_OPT, new ConfigProperties().getVersion());\n<br/>    <br/></p>',NULL,'<p>\n<br/>            Map&lt;String, Object&gt; output = new HashMap&lt;&gt;();\n<br/>            output.put(Messages.SUMMARY_KEY,\n<br/>                Formatter.formatSummary(numFiles, numSkipped, numErrors, numWarnings).replace(NEWLINE_PATTERN, &quot;&quot;));\n<br/>    +        // Sort files by descending order of the number of violations\n<br/>    +        FILES.sort((o1, o2) -&gt;\n<br/>    +            ((List) o2.get(Messages.VIOLATIONS_KEY)).size() - ((List) o1.get(Messages.VIOLATIONS_KEY)).size());\n<br/>            output.put(Messages.FILES_KEY, FILES);\n<br/>            output.put(Messages.VERSION_LONG_OPT, new ConfigProperties().getVersion());\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:52','2018-09-15 20:01:52','diff-ca76d22f3669b4c5f8955c445e291079-20180915200152','https://github.com/sleekbyte/tailor/commit/15c3a3a862a27c73504a9f9965c9a986be6a232e#diff-ca76d22f3669b4c5f8955c445e291079','/var/www/QARefactorings/app/webroot/files/diff-ca76d22f3669b4c5f8955c445e291079-20180915200152/a.txt','/var/www/QARefactorings/app/webroot/files/diff-ca76d22f3669b4c5f8955c445e291079-20180915200152/b.txt','L80','R86'),(76,3,1,5,'<p>d>\n<br/>        private long getNumMessagesWithSeverity(Severity severity) {\n<br/>    -        return msgBuffer.values().stream().filter(msg -&gt; msg.getSeverity().equals(severity)).count();\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>        private long getNumMessagesWithSeverity(Severity severity) {\n<br/>    +        return msgBuffer.values().stream()\n<br/>    +            .filter(msg -&gt; !ignoredLineNumbers.contains(msg.getLineNumber()))\n<br/>    +            .filter(msg -&gt; msg.getSeverity().equals(severity)).count();\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:54','2018-09-15 20:01:54','diff-6ba9e01f8a0556527567496ee6f3ab38-20180915200154','https://github.com/sleekbyte/tailor/commit/ee3c8df2847889622c381412b14ea817dae7af5c#diff-6ba9e01f8a0556527567496ee6f3ab38','/var/www/QARefactorings/app/webroot/files/diff-6ba9e01f8a0556527567496ee6f3ab38-20180915200154/a.txt','/var/www/QARefactorings/app/webroot/files/diff-6ba9e01f8a0556527567496ee6f3ab38-20180915200154/b.txt','L135','R141'),(77,2,1,5,'<p>d>\n<br/>         */\n<br/>        private void walkParseTree(List&lt;SwiftBaseListener&gt; listeners, TopLevelContext tree) {\n<br/>            ParseTreeWalker walker = new ParseTreeWalker();\n<br/>    -        for (SwiftBaseListener listener : listeners) {\n<br/>    -            // The following listeners are used by DeclarationListener to walk the tree\n<br/>    -            if (listener instanceof ConstantNamingListener || listener instanceof KPrefixListener) {\n<br/>    -                continue;\n<br/>    -            }\n<br/>    -            walker.walk(listener, tree);\n<br/>    -        }\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>         */\n<br/>        private void walkParseTree(List&lt;SwiftBaseListener&gt; listeners, TopLevelContext tree) {\n<br/>            ParseTreeWalker walker = new ParseTreeWalker();\n<br/>    +        listeners.forEach(listener -&gt; walker.walk(listener, tree));\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:56','2018-09-15 20:01:56','diff-241fb54b6817fdeccb9de857051ca79a-20180915200156','https://github.com/sleekbyte/tailor/commit/2b6961dee5176d315242014f41187da3c7fb69b9#diff-241fb54b6817fdeccb9de857051ca79a','/var/www/QARefactorings/app/webroot/files/diff-241fb54b6817fdeccb9de857051ca79a-20180915200156/a.txt','/var/www/QARefactorings/app/webroot/files/diff-241fb54b6817fdeccb9de857051ca79a-20180915200156/b.txt','L210','R215'),(78,3,1,5,'<p>d>\n<br/>            if (left != null) {\n<br/>    -            Token leftToken = left instanceof ParserRuleContext ? ((ParserRuleContext) left).getStop()\n<br/>    -                : ((TerminalNodeImpl) left).getSymbol();\n<br/>                Token start = ctx.getStart();\n<br/>    -            if (start.getLine() - leftToken.getLine() != 2) {\n<br/>                    printer.error(Messages.FUNCTION + Messages.NEWLINE_BEFORE, ListenerUtil.getTokenLocation(start));\n<br/>                }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>            if (left != null) {\n<br/>                Token start = ctx.getStart();\n<br/>    +            long numberOfNewLineChars = tokenStream.getHiddenTokensToLeft(start.getTokenIndex(), SwiftLexer.WHITESPACE)\n<br/>    +                .stream()\n<br/>    +                .filter(token -&gt; token.getText().equals(&quot;\\n&quot;))\n<br/>    +                .count();\n<br/>    +            if (numberOfNewLineChars &lt; 2) {\n<br/>                    printer.error(Messages.FUNCTION + Messages.NEWLINE_BEFORE, ListenerUtil.getTokenLocation(start));\n<br/>                }\n<br/>    <br/></p>',NULL,'2018-09-15 20:01:59','2018-09-15 20:02:00','diff-ec262536ff63a6278db137e284fded7d-20180915200159','https://github.com/sleekbyte/tailor/commit/404e54a103cafbc39c96fc6675dc4f4d469e4ba3#diff-ec262536ff63a6278db137e284fded7d','/var/www/QARefactorings/app/webroot/files/diff-ec262536ff63a6278db137e284fded7d-20180915200159/a.txt','/var/www/QARefactorings/app/webroot/files/diff-ec262536ff63a6278db137e284fded7d-20180915200159/b.txt','L598','R611'),(79,1,1,5,'<p>d>\n<br/>    	public void afterPropertiesSet() throws Exception {\n<br/>    		this.sftpFolder.create();\n<br/>    		this.localFolder.create();\n<br/>    -		server.setPasswordAuthenticator(new PasswordAuthenticator() {\n<br/>    -\n<br/>    -			@Override\n<br/>    -			public boolean authenticate(String arg0, String arg1, ServerSession arg2) {\n<br/>    -				return true;\n<br/>    -			}\n<br/>    -\n<br/>    -		});\n<br/>    		server.setPort(0);\n<br/>    -		server.setKeyPairProvider(new SimpleGeneratorHostKeyProvider(\"hostkey.ser\"));\n<br/>    -		this.server.setSubsystemFactories(Collections.&lt;NamedFactory&lt;Command&gt;&gt;singletonList(new SftpSubsystem.Factory()));\n<br/>    -		this.server.setFileSystemFactory(new VirtualFileSystemFactory(sftpRootFolder.getAbsolutePath()));\n<br/>    		server.start();\n<br/>    	}\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>    	public void afterPropertiesSet() throws Exception {\n<br/>    		this.sftpFolder.create();\n<br/>    		this.localFolder.create();\n<br/>    +		server.setPasswordAuthenticator((arg0, arg1, arg2) -&gt; true);\n<br/>    		server.setPort(0);\n<br/>    +		server.setKeyPairProvider(new SimpleGeneratorHostKeyProvider(new File(\"hostkey.ser\")));\n<br/>    +		this.server.setSubsystemFactories(Collections.singletonList(new SftpSubsystemFactory()));\n<br/>    +		this.server.setFileSystemFactory(new VirtualFileSystemFactory(sftpRootFolder.toPath()));\n<br/>    		server.start();\n<br/>    	}\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:05','2018-09-15 20:02:05','diff-98d3fc2674005c86b06aeab170c1175a-20180915200205','https://github.com/spring-projects/spring-integration/commit/cb76cfac16f9f4db6d24449585b87aa048f55e1a#diff-98d3fc2674005c86b06aeab170c1175a','/var/www/QARefactorings/app/webroot/files/diff-98d3fc2674005c86b06aeab170c1175a-20180915200205/a.txt','/var/www/QARefactorings/app/webroot/files/diff-98d3fc2674005c86b06aeab170c1175a-20180915200205/b.txt','L120','R126'),(80,1,1,5,'<p>\n<br/>        @Produces\n<br/>        @CustomHumanTaskService\n<br/>        @Override\n<br/>        public CommandBasedTaskService produceTaskService() {\n<br/>    -        return super.produceTaskService();\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>\n<br/>        @Produces\n<br/>        @CustomHumanTaskService\n<br/>        @Override\n<br/>        public CommandBasedTaskService produceTaskService() {\n<br/>    +        CommandBasedTaskService taskServiceMock = Mockito.mock(CommandBasedTaskService.class);\n<br/>    +        Mockito.when(taskServiceMock.execute(Mockito.any())).thenAnswer((InvocationOnMock invocation) -&gt; {\n<br/>    +            throw new CustomTaskServiceInUse();\n<br/>    +        });\n<br/>    +        return taskServiceMock;\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:07','2018-09-15 20:02:07','diff-81c4ecd721868f3875ca8390cb33d9ac-20180915200207','https://github.com/kiegroup/jbpm/commit/0b6955d69fc377d421dd23e2f2d30872f4ce62cb#diff-81c4ecd721868f3875ca8390cb33d9ac','/var/www/QARefactorings/app/webroot/files/diff-81c4ecd721868f3875ca8390cb33d9ac-20180915200207/a.txt','/var/www/QARefactorings/app/webroot/files/diff-81c4ecd721868f3875ca8390cb33d9ac-20180915200207/b.txt','L45','R42'),(81,2,1,5,'<p>d>\n<br/>            private void initExtensions(Context context) {\n<br/>    -            for (SwaggerModelExtension extension : extensionRegistry.getSwaggerModelExtensions())\n<br/>    -                extension.setGlobalContext(context);\n<br/>    -\n<br/>    -            for (OverviewDocumentExtension extension : extensionRegistry.getOverviewDocumentExtensions())\n<br/>    -                extension.setGlobalContext(context);\n<br/>    -\n<br/>    -            for (DefinitionsDocumentExtension extension : extensionRegistry.getDefinitionsDocumentExtensions())\n<br/>    -                extension.setGlobalContext(context);\n<br/>    -\n<br/>    -            for (PathsDocumentExtension extension : extensionRegistry.getPathsDocumentExtensions())\n<br/>    -                extension.setGlobalContext(context);\n<br/>    -\n<br/>    -            for (SecurityDocumentExtension extension : extensionRegistry.getSecurityDocumentExtensions())\n<br/>    -                extension.setGlobalContext(context);\n<br/>            }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>            private void initExtensions(Context context) {\n<br/>    +            extensionRegistry.getSwaggerModelExtensions().forEach(extension -&gt; extension.setGlobalContext(context));\n<br/>    +            extensionRegistry.getOverviewDocumentExtensions().forEach(extension -&gt; extension.setGlobalContext(context));\n<br/>    +            extensionRegistry.getDefinitionsDocumentExtensions().forEach(extension -&gt; extension.setGlobalContext(context));\n<br/>    +            extensionRegistry.getPathsDocumentExtensions().forEach(extension -&gt; extension.setGlobalContext(context));\n<br/>    +            extensionRegistry.getSecurityDocumentExtensions().forEach(extension -&gt; extension.setGlobalContext(context));\n<br/>            }\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:08','2018-09-15 20:02:09','diff-fc1497af780df894f7dbd24bb4d4809e-20180915200208','https://github.com/Swagger2Markup/swagger2markup/commit/5b1a1a2bcf4194a9cdea203011b099cb82dc70ac#diff-fc1497af780df894f7dbd24bb4d4809e','/var/www/QARefactorings/app/webroot/files/diff-fc1497af780df894f7dbd24bb4d4809e-20180915200208/a.txt','/var/www/QARefactorings/app/webroot/files/diff-fc1497af780df894f7dbd24bb4d4809e-20180915200208/b.txt','L321','R328'),(82,2,1,5,'<p>d>\n<br/>            if (CollectionUtils.isNotEmpty(produces)) {\n<br/>                buildSectionTitle(PRODUCES, docBuilder);\n<br/>                docBuilder.newLine();\n<br/>    -            for (String produce : produces) {\n<br/>    -                docBuilder.unorderedListItem(literalText(produce));\n<br/>    -            }\n<br/>                docBuilder.newLine();\n<br/>            }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>            if (CollectionUtils.isNotEmpty(produces)) {\n<br/>                buildSectionTitle(PRODUCES, docBuilder);\n<br/>                docBuilder.newLine();\n<br/>    +            produces.forEach(produce -&gt; docBuilder.unorderedListItem(literalText(produce)));\n<br/>                docBuilder.newLine();\n<br/>            }\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:12','2018-09-15 20:02:12','diff-b2371b91ec873932df80f1e8da819b19-20180915200212','https://github.com/Swagger2Markup/swagger2markup/commit/551aeed83574c8179f912841c92d3fdd59e51005#diff-b2371b91ec873932df80f1e8da819b19','/var/www/QARefactorings/app/webroot/files/diff-b2371b91ec873932df80f1e8da819b19-20180915200212/a.txt','/var/www/QARefactorings/app/webroot/files/diff-b2371b91ec873932df80f1e8da819b19-20180915200212/b.txt','L565','R568'),(83,5,1,5,'<p>\n<br/>        @Override\n<br/>        public Observable&lt;byte[]&gt; writeDescriptor(UUID serviceUuid, UUID characteristicUuid, UUID descriptorUuid, byte[] data) {\n<br/>    -        discoverServices()\n<br/>                    .flatMap(rxBleDeviceServices -&gt; rxBleDeviceServices.getDescriptor(serviceUuid, characteristicUuid, descriptorUuid))\n<br/>    -                .map(bluetoothGattDescriptor -&gt; bluetoothGattDescriptor.setValue(data)).subscribe();\n<br/>    -        return Observable.just(data);\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>\n<br/>        @Override\n<br/>        public Observable&lt;byte[]&gt; writeDescriptor(UUID serviceUuid, UUID characteristicUuid, UUID descriptorUuid, byte[] data) {\n<br/>    +        return discoverServices()\n<br/>                    .flatMap(rxBleDeviceServices -&gt; rxBleDeviceServices.getDescriptor(serviceUuid, characteristicUuid, descriptorUuid))\n<br/>    +                .map(bluetoothGattDescriptor -&gt; bluetoothGattDescriptor.setValue(data)).flatMap(ignored -&gt; Observable.just(data));\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:31','2018-09-15 20:02:31','diff-e16a3667ed79c289ca17f768878f1115-20180915200231','https://github.com/Polidea/RxAndroidBle/commit/4f8b60d952305335224b50ce00c0e2c25e23e872#diff-e16a3667ed79c289ca17f768878f1115','/var/www/QARefactorings/app/webroot/files/diff-e16a3667ed79c289ca17f768878f1115-20180915200231/a.txt','/var/www/QARefactorings/app/webroot/files/diff-e16a3667ed79c289ca17f768878f1115-20180915200231/b.txt','L61','R67'),(84,1,1,5,'<p>d>\n<br/>        @NonNull\n<br/>        private Observable&lt;byte[]&gt; setupCharacteristicNotification(BluetoothGattDescriptor bluetoothGattDescriptor, boolean enabled) {\n<br/>    -        final BluetoothGattCharacteristic bluetoothGattCharacteristic = bluetoothGattDescriptor.getCharacteristic();\n<br/>    -        return bluetoothGatt.setCharacteristicNotification(bluetoothGattCharacteristic, enabled)\n<br/>    -                ? writeDescriptor(bluetoothGattDescriptor, enabled ? ENABLE_NOTIFICATION_VALUE : DISABLE_NOTIFICATION_VALUE)\n<br/>    -                : Observable.error(new BleCannotSetCharacteristicNotificationException(bluetoothGattCharacteristic));\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>        @NonNull\n<br/>        private Observable&lt;byte[]&gt; setupCharacteristicNotification(BluetoothGattDescriptor bluetoothGattDescriptor, boolean enabled) {\n<br/>    +        final BluetoothGattCharacteristic characteristic = bluetoothGattDescriptor.getCharacteristic();\n<br/>    +\n<br/>    +        if (bluetoothGatt.setCharacteristicNotification(characteristic, enabled)) {\n<br/>    +            return writeDescriptor(bluetoothGattDescriptor, enabled ? ENABLE_NOTIFICATION_VALUE : DISABLE_NOTIFICATION_VALUE)\n<br/>    +                    .onErrorResumeNext(throwable -&gt; error(new BleCannotSetCharacteristicNotificationException(characteristic)));\n<br/>    +        } else {\n<br/>    +            return error(new BleCannotSetCharacteristicNotificationException(characteristic));\n<br/>    +        }\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:33','2018-09-15 20:02:33','diff-70127ee1ccd288fc48bab1e941023361-20180915200233','https://github.com/Polidea/RxAndroidBle/commit/3ab592ad3366e3961e768acf02802c2c16ca7911#diff-70127ee1ccd288fc48bab1e941023361','/var/www/QARefactorings/app/webroot/files/diff-70127ee1ccd288fc48bab1e941023361-20180915200233/a.txt','/var/www/QARefactorings/app/webroot/files/diff-70127ee1ccd288fc48bab1e941023361-20180915200233/b.txt','L129','R142'),(85,1,1,5,'<p>\n<br/>        @Provides @NonNull @Singleton\n<br/>        public HttpLoggingInterceptor provideHttpLoggingInterceptor() {\n<br/>    -        HttpLoggingInterceptor httpLoggingInterceptor = new HttpLoggingInterceptor();\n<br/>            httpLoggingInterceptor.setLevel(BuildConfig.DEBUG ? BODY : NONE);\n<br/>            return httpLoggingInterceptor;\n<br/>    <br/></p>',NULL,'<p>\n<br/>        @Provides @NonNull @Singleton\n<br/>        public HttpLoggingInterceptor provideHttpLoggingInterceptor() {\n<br/>    +        HttpLoggingInterceptor httpLoggingInterceptor = new HttpLoggingInterceptor(message -&gt; Timber.d(message));\n<br/>            httpLoggingInterceptor.setLevel(BuildConfig.DEBUG ? BODY : NONE);\n<br/>            return httpLoggingInterceptor;\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:35','2018-09-15 20:02:35','diff-a2afc5fdcf3469676fe934fb27ff465a-20180915200235','https://github.com/artem-zinnatullin/qualitymatters/commit/7d1b1e2e8b5aeddf75ab79a607c9c0484ddb20e9#diff-a2afc5fdcf3469676fe934fb27ff465a','/var/www/QARefactorings/app/webroot/files/diff-a2afc5fdcf3469676fe934fb27ff465a-20180915200235/a.txt','/var/www/QARefactorings/app/webroot/files/diff-a2afc5fdcf3469676fe934fb27ff465a-20180915200235/b.txt','L26','R33'),(86,1,1,5,'<p>\n<br/>    -        SelectionProbabilityWeightFactory&lt;DummyMove&gt; probabilityWeightFactory = new SelectionProbabilityWeightFactory&lt;DummyMove&gt;() {\n<br/>    -            public double createProbabilityWeight(ScoreDirector scoreDirector, DummyMove move) {\n<br/>    -                if (move.getCode().equals(&quot;e1&quot;)) {\n<br/>                        return 1000.0;\n<br/>    -                } else if (move.getCode().equals(\"e2\")) {\n<br/>                        return 200.0;\n<br/>    -                } else if (move.getCode().equals(\"e3\")) {\n<br/>                        return 30.0;\n<br/>    -                } else if (move.getCode().equals(\"e4\")) {\n<br/>                        return 4.0;\n<br/>    -                } else {\n<br/>                        throw new IllegalStateException(&quot;Unknown move (&quot; + move + &quot;).&quot;);\n<br/>    -                }\n<br/>                }\n<br/>            };\n<br/>    <br/></p>',NULL,'<p>\n<br/>    +        SelectionProbabilityWeightFactory&lt;TestdataSolution, DummyMove&gt; probabilityWeightFactory\n<br/>    +                = (scoreDirector, move) -&gt; {\n<br/>    +            switch (move.getCode()) {\n<br/>    +                case &quot;e1&quot;:\n<br/>                        return 1000.0;\n<br/>    +                case \"e2\":\n<br/>                        return 200.0;\n<br/>    +                case \"e3\":\n<br/>                        return 30.0;\n<br/>    +                case \"e4\":\n<br/>                        return 4.0;\n<br/>    +                default:\n<br/>                        throw new IllegalStateException(&quot;Unknown move (&quot; + move + &quot;).&quot;);\n<br/>                }\n<br/>            };\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:42','2018-09-15 20:02:42','diff-8674b26e82b057866d6ec76cfbadb8fe-20180915200242','https://github.com/kiegroup/optaplanner/commit/0c371e68d7e694e9b1ec472329a9c6a02ee07e24#diff-8674b26e82b057866d6ec76cfbadb8fe','/var/www/QARefactorings/app/webroot/files/diff-8674b26e82b057866d6ec76cfbadb8fe-20180915200242/a.txt','/var/www/QARefactorings/app/webroot/files/diff-8674b26e82b057866d6ec76cfbadb8fe-20180915200242/b.txt','L41','R58'),(87,1,1,5,'<p>\n<br/>    -        SelectionSorter&lt;TestdataSolution, TestdataValue&gt; sorter = new SelectionSorter&lt;TestdataSolution, TestdataValue&gt;() {\n<br/>    -            public void sort(ScoreDirector scoreDirector, List&lt;TestdataValue&gt; selectionList) {\n<br/>    -                Collections.sort(selectionList, new Comparator&lt;TestdataValue&gt;() {\n<br/>    -                    public int compare(TestdataValue a, TestdataValue b) {\n<br/>    -                        return a.getCode().compareTo(b.getCode());\n<br/>    -                    }\n<br/>    -                });\n<br/>    -            }\n<br/>    -        };\n<br/>    <br/></p>',NULL,'<p>\n<br/>    +        SelectionSorter&lt;TestdataSolution, TestdataValue&gt; sorter = (scoreDirector, selectionList)\n<br/>    +                -&gt; Collections.sort(selectionList, (a, b) -&gt; a.getCode().compareTo(b.getCode()));\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:44','2018-09-15 20:02:45','diff-786d5dfd7f5e10d3aebe3ecd4dca3070-20180915200244','https://github.com/kiegroup/optaplanner/commit/0c371e68d7e694e9b1ec472329a9c6a02ee07e24#diff-786d5dfd7f5e10d3aebe3ecd4dca3070','/var/www/QARefactorings/app/webroot/files/diff-786d5dfd7f5e10d3aebe3ecd4dca3070-20180915200244/a.txt','/var/www/QARefactorings/app/webroot/files/diff-786d5dfd7f5e10d3aebe3ecd4dca3070-20180915200244/b.txt','L62','R65'),(88,1,1,5,'<p>d>\n<br/>        public void deleteProcess(final CloudProcess process) {\n<br/>            logger.info(&quot;Scheduling delete of process ({}).&quot;, process);\n<br/>    -        doProblemFactChange(new ProblemFactChange() {\n<br/>    -            public void doChange(ScoreDirector scoreDirector) {\n<br/>    -                CloudBalance cloudBalance = (CloudBalance) scoreDirector.getWorkingSolution();\n<br/>    -                // Remove the planning entity itself\n<br/>    -                for (Iterator&lt;CloudProcess&gt; it = cloudBalance.getProcessList().iterator(); it.hasNext(); ) {\n<br/>    -                    CloudProcess workingProcess = it.next();\n<br/>    -                    if (Objects.equals(workingProcess, process)) {\n<br/>    -                        scoreDirector.beforeEntityRemoved(workingProcess);\n<br/>    -                        it.remove(); // remove from list\n<br/>    -                        scoreDirector.afterEntityRemoved(workingProcess);\n<br/>    -                        break;\n<br/>    -                    }\n<br/>                    }\n<br/>    -                scoreDirector.triggerVariableListeners();\n<br/>                }\n<br/>            });\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>d>\n<br/>        public void deleteProcess(final CloudProcess process) {\n<br/>            logger.info(&quot;Scheduling delete of process ({}).&quot;, process);\n<br/>    +        doProblemFactChange(scoreDirector -&gt; {\n<br/>    +            CloudBalance cloudBalance = scoreDirector.getWorkingSolution();\n<br/>    +            // Remove the planning entity itself\n<br/>    +            for (Iterator&lt;CloudProcess&gt; it = cloudBalance.getProcessList().iterator(); it.hasNext(); ) {\n<br/>    +                CloudProcess workingProcess = it.next();\n<br/>    +                if (Objects.equals(workingProcess, process)) {\n<br/>    +                    scoreDirector.beforeEntityRemoved(workingProcess);\n<br/>    +                    it.remove(); // remove from list\n<br/>    +                    scoreDirector.afterEntityRemoved(workingProcess);\n<br/>    +                    break;\n<br/>                    }\n<br/>                }\n<br/>    +            scoreDirector.triggerVariableListeners();\n<br/>            });\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-15 20:02:46','2018-09-15 20:02:47','diff-c00b643f2fa9fd24f5e41df33667dab3-20180915200246','https://github.com/kiegroup/optaplanner/commit/84c379549cbf3c84948bec3e44452749582f887e#diff-c00b643f2fa9fd24f5e41df33667dab3','/var/www/QARefactorings/app/webroot/files/diff-c00b643f2fa9fd24f5e41df33667dab3-20180915200246/a.txt','/var/www/QARefactorings/app/webroot/files/diff-c00b643f2fa9fd24f5e41df33667dab3-20180915200246/b.txt','L314','R326'),(89,5,1,5,'<p>\n<br/>        public ListField(String name, String humanName, List&lt;String&gt; defaultValue, Map&lt;String, String&gt; values, String description, Optional isOptional, Attribute... attributes) {\n<br/>            super(FIELD_TYPE, name, humanName, description, isOptional);\n<br/>            this.defaultValue = defaultValue;\n<br/>            this.values = values;\n<br/>    -\n<br/>    -        this.attributes = new ArrayList&lt;&gt;();\n<br/>    -        if (attributes != null) {\n<br/>    -            for (Attribute attribute : attributes) {\n<br/>    -                this.attributes.add(attribute.toString().toLowerCase(Locale.ENGLISH));\n<br/>    -            }\n<br/>    -        }\n<br/>        }\n<br/>    <br/></p>',NULL,'<p>\n<br/>        public ListField(String name, String humanName, List&lt;String&gt; defaultValue, Map&lt;String, String&gt; values, String description, Optional isOptional, Attribute... attributes) {\n<br/>            super(FIELD_TYPE, name, humanName, description, isOptional);\n<br/>            this.defaultValue = defaultValue;\n<br/>            this.values = values;\n<br/>    +        this.attributes = Arrays.stream(attributes)\n<br/>    +                .map(attribute -&gt; attribute.toString().toLowerCase(Locale.ENGLISH))\n<br/>    +                .collect(Collectors.toList());\n<br/>        }\n<br/>    <br/></p>',NULL,'2018-09-16 11:20:23','2018-09-16 11:20:23','diff-d663fea3b2dce1447b9948bc83ad3683-20180916112023','https://github.com/Graylog2/graylog2-server/commit/50f59c0f17786f1ac180037728e4c8486ef873ae#diff-d663fea3b2dce1447b9948bc83ad3683','/var/www/QARefactorings/app/webroot/files/diff-d663fea3b2dce1447b9948bc83ad3683-20180916112023/a.txt','/var/www/QARefactorings/app/webroot/files/diff-d663fea3b2dce1447b9948bc83ad3683-20180916112023/b.txt','L45','R49');
/*!40000 ALTER TABLE `transformations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_languages`
--

DROP TABLE IF EXISTS `user_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `language_id` tinyint(4) NOT NULL,
  `experience` tinyint(2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_has_languages_languages1_idx` (`language_id`),
  KEY `fk_users_has_languages_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_languages_languages1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_languages_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_languages`
--

LOCK TABLES `user_languages` WRITE;
/*!40000 ALTER TABLE `user_languages` DISABLE KEYS */;
INSERT INTO `user_languages` VALUES (2,2,1,5,'2018-09-06 14:18:14','2018-09-06 14:18:14');
/*!40000 ALTER TABLE `user_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `description` varchar(25) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (1,'candidato','2018-01-30 21:28:00'),(2,'pesquisador','2018-01-30 21:28:00'),(3,'administrador','2018-01-30 21:28:00');
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` tinyint(4) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(120) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sex` varchar(20) NOT NULL,
  `status` char(1) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `trophy` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `FK` (`user_type_id`),
  CONSTRAINT `fk_users_user_types` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,3,'waltimlmm','1b8718b4bcca35caec81818db8598c84fa03aafd','Walter Lucas','Masculino','1','waltimlmm@gmail.com',8,'2018-01-30 21:37:26','2018-09-06 14:48:02'),(3,1,'jose','67b18bc94fc98794d03fdb57ef6a4019911d52b4','jose','Não informado','1','jose@jose.com',0,'2018-03-07 17:42:33','2018-03-12 16:51:39');
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

-- Dump completed on 2018-10-30 21:35:21
