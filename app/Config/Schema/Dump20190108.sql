CREATE DATABASE  IF NOT EXISTS `qar` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `qar`;
-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: qar
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
  `choice` char(3) NOT NULL,
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
  `acronym` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK` (`metric_type_id`),
  CONSTRAINT `fk_metrics_metric_types1` FOREIGN KEY (`metric_type_id`) REFERENCES `metric_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metrics`
--

LOCK TABLES `metrics` WRITE;
/*!40000 ALTER TABLE `metrics` DISABLE KEYS */;
INSERT INTO `metrics` VALUES (1,3,'LOC','Linhas de código (linhas de código pertencentes aos métodos)','2018-02-14 11:10:25','2018-02-14 11:10:25'),(2,3,'ACCM','Complexidade ciclomática do método (quantidade de caminhos diferentes no método);','2018-02-14 11:10:25','2018-02-14 11:10:25'),(4,2,'LIKERT','Mede atitudes e comportamentos utilizando opções de resposta que variam de um extremo a outro.','2018-02-14 11:10:25','2018-02-14 11:10:25'),(5,3,'CLMAX','Comprimento de linha (Máximo)','2018-02-14 11:10:25','2018-02-14 11:10:25'),(6,3,'CLAVER','Comprimento de linha (Média)','2018-02-14 11:10:25','2018-02-14 11:10:25'),(7,3,'QTDIDENT','quantidade de identificadores','2018-02-14 11:10:25','2018-02-14 11:10:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
INSERT INTO `participants` VALUES (5,2,5,1,'2018-09-02 16:33:21'),(7,2,5,4,'2018-09-02 18:30:20'),(8,2,5,4,'2018-09-02 18:34:15'),(9,2,5,4,'2018-09-02 18:34:38'),(10,2,5,4,'2018-09-02 18:35:18'),(11,2,5,4,'2018-11-26 15:59:49'),(12,2,5,4,'2018-11-26 15:59:58'),(13,2,5,4,'2018-11-26 16:00:07'),(14,2,5,4,'2018-11-26 16:00:14'),(15,2,5,4,'2018-11-26 16:00:21'),(16,2,5,4,'2018-11-26 16:00:28');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_types`
--

LOCK TABLES `question_types` WRITE;
/*!40000 ALTER TABLE `question_types` DISABLE KEYS */;
INSERT INTO `question_types` VALUES (1,'Multipla Escolha','2018-02-14 11:10:25'),(2,'Descritiva','2018-02-14 11:10:25'),(3,'Numerica','2018-02-14 11:10:25'),(4,'Likert','2019-01-06 11:10:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,5,1,'Considerando essa transformação específica, a alteração de código corresponde a um refatoramento para a introdução de expressões lambda?',NULL,'2018-09-02 18:30:20','2018-09-02 18:30:20'),(2,7,1,'Considerando essa transformação específica, você concorda que a adoção de expressões lambda melhoram a legibilidade?',NULL,'2018-09-02 18:30:20','2018-09-02 18:30:20'),(3,8,1,'Considerando essa transformação específica, você concorda que é fácil compreender o propósito da transformação?',NULL,'2018-09-02 18:34:15','2018-09-02 18:34:15'),(4,9,1,'Considerando essa transformação específica, você concorda que ela deveria ser aplicada?',NULL,'2018-09-02 18:34:39','2018-09-02 18:34:39'),(5,10,1,'Considerando essa transformação específica, a redução da quantidade de branches (laços de repetição como for ou while e sentenças condicionais como if-then-else ou switch cases) é perceptível?',NULL,'2018-09-02 18:35:18','2018-09-02 18:35:18'),(6,11,1,'Considerando essa transformação específica, a redução da quantidade de linhas de código é relevante?',NULL,'2018-11-26 15:59:49','2018-11-26 15:59:49');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `result_questions`
--

LOCK TABLES `result_questions` WRITE;
/*!40000 ALTER TABLE `result_questions` DISABLE KEYS */;
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
  `before` varchar(15) DEFAULT NULL,
  `after` varchar(15) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK` (`transformation_id`,`metric_id`),
  KEY `fk_results_metrics1_idx` (`metric_id`),
  CONSTRAINT `fk_results_metrics1` FOREIGN KEY (`metric_id`) REFERENCES `metrics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_results_transformations1` FOREIGN KEY (`transformation_id`) REFERENCES `transformations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2924 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
INSERT INTO `results` VALUES (2918,970,1,'3','4','2019-01-06 23:06:49'),(2919,970,2,'2','2','2019-01-06 23:06:49'),(2920,970,4,NULL,NULL,'2019-01-06 23:06:49'),(2921,970,5,'39','21','2019-01-06 23:06:49'),(2922,970,6,'15.75','12.6','2019-01-06 23:06:49'),(2923,970,7,'4','4','2019-01-06 23:06:50');
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
INSERT INTO `search_events` VALUES (5,'Análise do impacto na compreensão de programasJava com a adoção de expressões lambda','Universidade de Brasília','2018-09-02 16:33:20','2018-09-02 16:33:20');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transformation_types`
--

LOCK TABLES `transformation_types` WRITE;
/*!40000 ALTER TABLE `transformation_types` DISABLE KEYS */;
INSERT INTO `transformation_types` VALUES (1,'Anonymous inner classes -> Lambda','2018-02-14 11:10:25'),(2,'(for) to ForEach -> Lambda','2018-02-14 11:10:25'),(3,'(for) to Filter -> Lambda','2018-02-14 11:10:25'),(4,'(If) to anyMatch -> Lambda','2018-02-14 11:10:25'),(5,'(for) to Map -> Lambda','2018-02-14 11:10:25'),(6,'(for) to Map/Reduce -> Lambda','2018-11-29 15:50:25'),(7,'(for) to Map/Collect  -> Lambda','2018-11-29 15:50:25'),(8,'(for) to Filter/Count -> Lambda','2018-11-29 15:50:25'),(9,'(for) to Filter/Collect -> Lambda','2018-11-29 15:50:25'),(10,'(for) to Filter/ForEach -> Lambda','2018-11-30 12:50:25'),(11,'(for) to Filter/FlatMap -> Lambda','2018-01-12 12:50:25'),(13,'(for) to Map/FlatMap -> Lambda','2018-01-12 12:50:25'),(14,'(for) to ForEach/FlatMap -> Lambda','2018-01-12 12:50:25'),(15,'(for) to Map/Count -> Lambda','2018-01-12 12:50:25'),(16,'(for) to FlatMap -> Lambda','2018-01-12 12:50:25');
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
  `apt` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transformations_languages1_idx` (`language_id`),
  KEY `fk_transformations_transformation_types1_idx` (`transformation_type_id`),
  KEY `fk_transformations_search_events1_idx` (`search_event_id`),
  CONSTRAINT `fk_transformations_languages1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transformations_search_events1` FOREIGN KEY (`search_event_id`) REFERENCES `search_events` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transformations_transformation_types1` FOREIGN KEY (`transformation_type_id`) REFERENCES `transformation_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=971 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transformations`
--

LOCK TABLES `transformations` WRITE;
/*!40000 ALTER TABLE `transformations` DISABLE KEYS */;
INSERT INTO `transformations` VALUES (970,2,1,5,'<p>-   for (CRFThread thread : threads) {\r\n<br/>-     thread.start();\r\n<br/>-    }\r\n<br/><br/></p>',NULL,'<p>+    threads.forEach(\r\n<br/>+      thread -&gt; {\r\n<br/>+       thread.start();\r\n<br/>+      });\r\n<br/><br/></p>',NULL,'2019-01-06 23:06:49','2019-01-06 23:06:50','diff-e112047b36af77d670c0d4f1df5f040f-20190106230649','https://github.com/stanfordnlp/CoreNLP/pull/545/commits/f950190a60d01c522578ddea728a5180e09b0f40#diff-e112047b36af77d670c0d4f1df5f040f','/var/www/QARefactorings/app/webroot/files/diff-e112047b36af77d670c0d4f1df5f040f-20190106230649/a.txt','/var/www/QARefactorings/app/webroot/files/diff-e112047b36af77d670c0d4f1df5f040f-20190106230649/b.txt','168','172',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_languages`
--

LOCK TABLES `user_languages` WRITE;
/*!40000 ALTER TABLE `user_languages` DISABLE KEYS */;
INSERT INTO `user_languages` VALUES (16,3,1,5,'2018-12-16 10:31:16','2018-12-16 10:31:16'),(17,3,1,5,'2018-12-16 10:31:33','2018-12-16 10:31:33'),(18,2,1,5,'2018-12-16 13:17:26','2018-12-16 13:17:26');
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
  `formation` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `FK` (`user_type_id`),
  CONSTRAINT `fk_users_user_types` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,3,'waltimlmm','1b8718b4bcca35caec81818db8598c84fa03aafd','Walter Lucas','Masculino','1','waltimlmm@gmail.com',0,'2018-01-30 21:37:26','2018-12-16 13:17:26','PGC','AS'),(3,1,'jose','f59f2822bb2354b93ab71a6d93104c1137f76210','jose','Masculino','1','jose@jose.com',18,'2018-03-07 17:42:33','2018-12-16 10:31:33','PGI','AD'),(4,3,'rbonifacio123','26b25a5963b9b7c4180507ba5d7c308b856f9d34','rbonifacio','Masculino','1','rbonifacio123@gmail.com',0,'2018-11-26 14:46:48','2018-12-03 07:18:15','DC','OT'),(5,1,'thiagohd93','303438fec1c1a0a4400324a5ef3d6f3bc5b1c05d','Thiago Dias','Masculino','1','thiagohd93@gmail.com',0,'2018-11-26 21:02:29','2018-11-26 21:03:40','SC',''),(6,1,'carvalhosobrinhomatheus','5a8896569dda900fff4ded12652c77ca797c7ccc','Matheus de Carvalho Sobrinho','Masculino','1','carvalhosobrinhomatheus@gmail.com',0,'2018-12-03 13:21:50','2018-12-03 13:54:59','PGI','DJ'),(7,1,'dariosantosbsb','178bf0bd98b9d1de5da4e263512305fdb80b218b','Dário Samtos','Masculino','1','dario.santos.bsb@redes.unb.br',0,'2018-12-03 13:22:06','2018-12-04 10:51:00','PGI','DP'),(8,1,'guns945','213db0ed6dc3384885a392cfb4e832fa2ea69b6d','willian junior','Masculino','1','guns945@gmail.com',0,'2018-12-04 00:04:54','2018-12-04 00:45:10','MM','OT'),(9,1,'luisfrt','f59f2822bb2354b93ab71a6d93104c1137f76210','Luis Felipe','Masculino','1','luisfrt@gmail.com',0,'2018-12-04 08:59:31','2018-12-04 09:21:09','MM','AD'),(10,1,'evertonagilar','f59f2822bb2354b93ab71a6d93104c1137f76210','EVERTON DE VARGAS AGILAR','Masculino','1','evertonagilar@gmail.com',0,'2018-12-05 18:43:48','2018-12-05 19:08:08','MM','DS'),(11,1,'contrariador','85b94e4f10cd22a0f7d09d30c303093115b8e60d','Fabio R','Masculino','1','contrariador@gmail.com',0,'2018-12-05 19:33:22','2018-12-05 19:33:22','','');
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

-- Dump completed on 2019-01-08  8:10:58
