-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: sgcp_db
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointment` (
  `id_appointment` int(11) NOT NULL AUTO_INCREMENT,
  `doctor` int(11) NOT NULL,
  `patient` int(11) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `description` varchar(45) DEFAULT '-',
  `photo` varchar(100) NOT NULL DEFAULT 'default_photo.ico',
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_appointment`),
  KEY `doctor` (`doctor`),
  KEY `patient` (`patient`),
  CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`doctor`) REFERENCES `doctor` (`id_doctor`),
  CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`patient`) REFERENCES `patient` (`id_patient`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES (25,3,1,'2023-07-06','08:00:00','','img_ce759a1d9fde084e6455472a866685ac.jpg',1),(56,3,14,'2023-08-08','08:00:00','','default_photo.ico',2),(57,3,13,'2023-08-08','08:30:00','','default_photo.ico',2),(60,3,2,'2023-08-08','10:30:00','','default_photo.ico',2),(61,3,12,'2023-08-08','10:00:00','','default_photo.ico',2),(62,3,1,'2023-08-08','09:30:00','','default_photo.ico',3);
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `id_calendar` int(11) NOT NULL AUTO_INCREMENT,
  `doctor` int(11) NOT NULL,
  `week_number` varchar(20) NOT NULL,
  `week_range` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `final_time` time NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_calendar`),
  KEY `doctor` (`doctor`),
  CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`doctor`) REFERENCES `doctor` (`id_doctor`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` VALUES (6,3,'Week 26 year 2023','2023-06-26 - 2023-07-02','2023-06-26','10:00:00','12:00:00',1),(7,3,'Week 25 year 2023','2023-06-19 - 2023-06-25','2023-06-21','10:00:00','12:00:00',1),(8,3,'Week 25 year 2023','2023-06-19 - 2023-06-25','2023-06-22','10:00:00','12:00:00',1),(9,3,'Week 25 year 2023','2023-06-19 - 2023-06-25','2023-06-22','13:00:00','18:00:00',1),(10,3,'Week 25 year 2023','2023-06-19 - 2023-06-25','2023-06-23','13:00:00','18:00:00',1),(11,3,'Week 26 year 2023','2023-06-26 - 2023-07-02','2023-06-27','08:30:00','12:00:00',2),(12,3,'Week 27 year 2023','2023-07-03 - 2023-07-09','2023-07-03','08:30:00','12:00:00',1),(13,3,'Week 27 year 2023','2023-07-03 - 2023-07-09','2023-07-04','08:30:00','12:00:00',1),(14,3,'Week 27 year 2023','2023-07-03 - 2023-07-09','2023-07-04','13:30:00','18:00:00',1),(15,3,'Week 27 year 2023','2023-07-03 - 2023-07-09','2023-07-05','08:00:00','10:00:00',1),(16,3,'Week 27 year 2023','2023-07-03 - 2023-07-09','2023-07-06','08:00:00','10:00:00',1),(17,3,'Week 27 year 2023','2023-07-03 - 2023-07-09','2023-07-07','08:00:00','10:00:00',1),(19,3,'Week 27 year 2023','2023-07-03 - 2023-07-09','2023-07-07','13:00:00','18:00:00',1),(20,5,'Week 25 year 2023','2023-06-19 - 2023-06-25','2023-06-24','08:30:00','12:00:00',1),(21,5,'Week 25 year 2023','2023-06-19 - 2023-06-25','2023-06-24','13:30:00','17:30:00',2),(22,3,'Week 26 year 2023','2023-06-26 - 2023-07-02','2023-06-27','08:00:00','12:00:00',0),(23,3,'Week 22 year 2023','2023-05-29 - 2023-06-04','2023-06-02','08:00:00','12:00:00',1),(24,3,'Week 32 year 2023','2023-08-07 - 2023-08-13','2023-08-07','08:00:00','12:00:00',1),(25,3,'Week 32 year 2023','2023-08-07 - 2023-08-13','2023-08-08','08:00:00','12:00:00',1);
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctor` (
  `id_doctor` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `specialty` varchar(45) NOT NULL,
  `cell_phone` varchar(10) NOT NULL,
  `home_address` varchar(25) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_doctor`),
  KEY `user` (`user`),
  CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor`
--

LOCK TABLES `doctor` WRITE;
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` VALUES (3,20,'Neonatologo','0988552212','Portoviejo',1),(4,21,'Pediatra','096521546','Portoviejo',0),(5,22,'Pediatra','0985642257','Portoviejo',1),(6,23,'Pediatra','0985465421','Jipijapa',1);
/*!40000 ALTER TABLE `doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicalcontrol`
--

DROP TABLE IF EXISTS `medicalcontrol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicalcontrol` (
  `id_medicalcontrol` int(11) NOT NULL AUTO_INCREMENT,
  `appointment` int(11) NOT NULL,
  `recipe` int(11) NOT NULL,
  `months_age` int(11) NOT NULL,
  `weight_kg` decimal(5,2) NOT NULL,
  `weight_pounds` decimal(5,2) NOT NULL,
  `height_cm` decimal(5,2) NOT NULL,
  `bmi_quant` decimal(5,2) NOT NULL,
  `bmi_quali` varchar(15) NOT NULL,
  `temperature` decimal(5,2) DEFAULT 0.00,
  `observation` varchar(100) DEFAULT '-',
  PRIMARY KEY (`id_medicalcontrol`),
  KEY `appointment` (`appointment`),
  KEY `recipe` (`recipe`),
  CONSTRAINT `medicalcontrol_ibfk_1` FOREIGN KEY (`appointment`) REFERENCES `appointment` (`id_appointment`),
  CONSTRAINT `medicalcontrol_ibfk_2` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id_recipe`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicalcontrol`
--

LOCK TABLES `medicalcontrol` WRITE;
/*!40000 ALTER TABLE `medicalcontrol` DISABLE KEYS */;
INSERT INTO `medicalcontrol` VALUES (2,25,7,2,10.00,22.05,65.00,23.67,'Normal',0.00,'');
/*!40000 ALTER TABLE `medicalcontrol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id_module` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(25) NOT NULL,
  `description` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_module`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'Dashboard','Dashboard',1),(2,'Área personal','Personal area',1),(3,'Usuarios','Users',1),(4,'Roles','Roles',1),(5,'Pacientes','Patients',1),(6,'Control pacientes','Control patients',1),(7,'Familiares','Familiares',1),(8,'Doctores','Doctores',1),(9,'Horarios','Horarios de atención ',1),(10,'Citas','Agenda-miento de citas',1),(11,'Notificaciones','Notificaciones',1),(12,'Consultorio','Consultorio',1),(13,'Configuración','configuración',1);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_notification`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (13,'Pre-cita','Solicitud de cita para control médico',1),(14,'Pre-cita','Solicitud de cita para control médico',2);
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_details`
--

DROP TABLE IF EXISTS `notification_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_details` (
  `id_notification_details` int(11) NOT NULL AUTO_INCREMENT,
  `sending_user` int(11) NOT NULL,
  `recipient_user` int(11) NOT NULL,
  `notification` int(11) NOT NULL,
  `appointment` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_notification_details`),
  KEY `sending_user` (`sending_user`),
  KEY `recipient_user` (`recipient_user`),
  KEY `notification` (`notification`),
  KEY `appointment` (`appointment`),
  CONSTRAINT `notification_details_ibfk_1` FOREIGN KEY (`sending_user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `notification_details_ibfk_2` FOREIGN KEY (`recipient_user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `notification_details_ibfk_3` FOREIGN KEY (`notification`) REFERENCES `notification` (`id_notification`),
  CONSTRAINT `notification_details_ibfk_4` FOREIGN KEY (`appointment`) REFERENCES `appointment` (`id_appointment`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_details`
--

LOCK TABLES `notification_details` WRITE;
/*!40000 ALTER TABLE `notification_details` DISABLE KEYS */;
INSERT INTO `notification_details` VALUES (7,17,8,13,25,'2023-07-06 00:53:15'),(8,17,8,14,62,'2023-08-08 21:34:39');
/*!40000 ALTER TABLE `notification_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parents`
--

DROP TABLE IF EXISTS `parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parents` (
  `id_parents` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `repr` int(11) NOT NULL,
  `father_name` varchar(25) NOT NULL,
  `father_lastname` varchar(25) NOT NULL,
  `mother_name` varchar(25) NOT NULL,
  `mother_lastname` varchar(25) NOT NULL,
  `home_phone` varchar(10) DEFAULT NULL,
  `cell_phone` varchar(10) NOT NULL,
  `cell_phone2` varchar(10) DEFAULT NULL,
  `home_address` varchar(25) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_parents`),
  KEY `user` (`user`),
  CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parents`
--

LOCK TABLES `parents` WRITE;
/*!40000 ALTER TABLE `parents` DISABLE KEYS */;
INSERT INTO `parents` VALUES (1,17,3,'Jose Manuel','Vera Caicedo','Fernanda Maria','Moreira Pereira','5235852','0956231578','0965325122','Portoviejo',1),(9,35,3,'Carlos Jose','Mendoza Gutierrez','Marisol Hidelina','Barcia Velez','5235852','0985642212','','Portoviejo',1),(10,36,2,'Jose Luis','Hidrobo','Filala Dymala','Moreira','5235823','0956231578','','Manta',1),(11,37,1,'Roquen Dilan','Mendoza Ruiz','Hilda Maria','Diaz Mera','576323','0965325241','0956798431','Jipijapa',1);
/*!40000 ALTER TABLE `parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `id_patient` int(11) NOT NULL AUTO_INCREMENT,
  `parents` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(1) NOT NULL,
  `weight_kg` decimal(5,2) NOT NULL,
  `weight_pounds` decimal(5,2) NOT NULL,
  `height` double(5,2) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `family_obs` varchar(255) NOT NULL DEFAULT 'Ninguna',
  `personal_obs` varchar(255) NOT NULL DEFAULT 'Ninguna',
  `general_obs` varchar(255) NOT NULL DEFAULT 'Ninguna',
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_patient`),
  KEY `parents` (`parents`),
  CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`parents`) REFERENCES `parents` (`id_parents`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,1,'1314521254','Miguel Jose','Vera Moreira','2023-06-08','M',10.00,22.05,25.00,'AB+','Ninguna','Hospital, Parto','Ninguna','2023-05-29 16:45:12',1),(2,1,'1314652496','Rosa Flor','Vera Moreira','2023-06-08','F',11.00,24.25,12.00,'O+','Ninguna','Ninguna','Ninguna','2023-07-04 01:19:32',1),(9,9,'1315625458','Mathias Josue','Mendoza Barcia','2023-06-01','M',7.00,15.43,11.00,'O+','Alergias, Prematuro','Clinica, Cesaria ','Ninguna','2023-07-12 21:23:05',1),(12,10,'1317382645','Jose Manuel','Dymala Moreira','2023-05-02','M',5.00,11.02,8.00,'O+','Ninguna','Hospital, Parto, 6 horas, estado critico','Ninguna','2023-07-12 21:38:23',1),(13,11,'1325496325','Josselyn Mariel','Diaz Mera','2023-07-01','F',5.00,11.02,12.00,'A+','Ninguna','Ninguna','Todo en orden','2023-07-13 21:42:02',1),(14,9,'1348579652','Salome Velissa','Mendoza Barcia','2023-05-02','F',4.00,8.82,11.00,'B+','Ninguna','Clinica, Cesaria','Ninguna','2023-07-13 21:45:14',1);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id_permissions` int(11) NOT NULL AUTO_INCREMENT,
  `rol` int(11) NOT NULL,
  `module` int(11) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_permissions`),
  KEY `rol` (`rol`),
  KEY `module` (`module`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`),
  CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`module`) REFERENCES `module` (`id_module`)
) ENGINE=InnoDB AUTO_INCREMENT=614 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (237,2,1,1,1,1,1),(238,2,2,1,1,1,1),(239,2,3,1,1,1,1),(240,2,4,0,0,0,0),(241,2,5,0,0,0,0),(242,2,6,0,0,0,0),(539,5,1,0,0,0,0),(540,5,2,1,0,0,0),(541,5,3,0,0,0,0),(542,5,4,0,0,0,0),(543,5,5,0,0,0,0),(544,5,6,0,0,0,0),(545,5,7,0,0,0,0),(546,5,8,0,0,0,0),(547,5,9,0,0,0,0),(548,5,10,0,0,0,0),(549,5,11,0,0,0,0),(550,5,12,1,1,1,1),(575,1,1,1,1,1,1),(576,1,2,1,1,1,1),(577,1,3,1,1,1,1),(578,1,4,1,1,1,1),(579,1,5,1,1,1,1),(580,1,6,1,1,1,1),(581,1,7,1,1,1,1),(582,1,8,1,1,1,1),(583,1,9,1,1,1,1),(584,1,10,1,1,1,1),(585,1,11,1,1,1,1),(586,1,12,1,1,1,1),(587,1,13,1,1,1,1),(588,4,1,0,0,0,0),(589,4,2,1,0,0,0),(590,4,3,0,0,0,0),(591,4,4,0,0,0,0),(592,4,5,0,0,0,0),(593,4,6,1,1,1,1),(594,4,7,0,0,0,0),(595,4,8,0,0,0,0),(596,4,9,1,1,1,1),(597,4,10,1,1,1,1),(598,4,11,0,0,0,0),(599,4,12,0,0,0,0),(600,4,13,0,0,0,0),(601,3,1,1,1,1,1),(602,3,2,0,0,0,0),(603,3,3,0,0,0,0),(604,3,4,0,0,0,0),(605,3,5,1,0,1,0),(606,3,6,0,0,0,0),(607,3,7,1,1,1,1),(608,3,8,1,1,1,1),(609,3,9,0,0,0,0),(610,3,10,1,1,0,0),(611,3,11,1,1,1,1),(612,3,12,0,0,0,0),(613,3,13,0,0,0,0);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipe`
--

DROP TABLE IF EXISTS `recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipe` (
  `id_recipe` int(11) NOT NULL AUTO_INCREMENT,
  `medication` text DEFAULT NULL,
  `indication` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_recipe`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipe`
--

LOCK TABLES `recipe` WRITE;
/*!40000 ALTER TABLE `recipe` DISABLE KEYS */;
INSERT INTO `recipe` VALUES (7,'<p></p><ul><li>Colufase fco 30 ml #1</li><li>Kid cal fco #1</li></ul><p></p>','<p></p><ul><li>Leche 1 vaso al día&nbsp;</li><li>dieta general</li><li>cuidados habituales</li><li>Halss</li></ul><p></p>',1);
/*!40000 ALTER TABLE `recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(25) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Super admin','Super admin',1),(2,'Administrator','Administrator',1),(3,'Secretaria','Secretaria',1),(4,'Doctor/a','Doctor/a',1),(5,'Representante','Representante legal de pacientes',1),(42,'cajero','aswq',0),(44,'cajeroassda','asdasd',0),(45,'Super As','AS',0),(46,'cajero','asasas',0),(47,'cajeroadsda','asdasd',0);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id_settings` int(11) NOT NULL AUTO_INCREMENT,
  `system_name` varchar(30) NOT NULL,
  `session_time` time NOT NULL,
  `generate_reports` varchar(3) NOT NULL,
  `scheduling_time` time NOT NULL,
  `generate_certificate` varchar(3) NOT NULL,
  `print_recipe` varchar(3) NOT NULL,
  PRIMARY KEY (`id_settings`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'SGCP','00:30:00','YES','00:30:00','YES','YES');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(120) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'JH','Admin','admin','240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9','admin@info.com','',1),(8,'Cristian','Bravo','@cribra2023','15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225','bravo@gmail.com',NULL,1),(12,'Jose Manuel','Zambrano','jzambrano2023','15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225','josezam1@gmail.com','',1),(13,'Maria','Veles','mveles2023','e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855','josx0921@gmail.com',NULL,0),(17,'Maria Jimena','Moreira Gonzalez','@marmor2023','15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225','joma@gmail.com',NULL,1),(20,'Jhonny','Hidalgo','@jhohid2023','15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225','hidalgo@gmail.com',NULL,1),(21,'Mirian','Perez','mperez2023','11a4ff66d6fb6ac10c3f0c037ffa637e517aa15f711632b06f72dc15f76dc7a9','hida@gmail.com',NULL,0),(22,'Gisella','Zambrano','@giszam2023','e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855','gisella@gmail.com',NULL,1),(23,'Leonela Maria','Bravo','@leobra2023','15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225','leo@gmail.com',NULL,1),(35,'Leonel Andres','Garcia Hidrobo','@leogar02','9699e56e52019fdce0040e3efffbd31442fafc4d830750763630bc101009f903','leoasd@gmail.com',NULL,1),(36,'Filala Dymala','Moreira','@filmor35','c232673b6eb0355ed1f5390efa2a10167cc75ec4b7699f466ce9462e7fedfa7a','josezam0da921@gmail.com',NULL,1),(37,'Roquen Dilan','Mendoza Ruiz','@roqmen42','3673f1deb5b3d1aeb69b195fe357ec11e8dd72121b7f0730db70d65988f4ed53','rweer@gmail.com',NULL,1),(38,'Holger Fernando','Gallego Mantios','@holgal2023','7988726306d7ef6a1c771e1d276d9a60e2a679100ad8f493d5c72adb133cf845','holgaa12@gmail.com',NULL,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `id_user_roles` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_user_roles`),
  KEY `user` (`user`),
  KEY `rol` (`rol`),
  CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=413 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (200,13,1,0),(201,13,2,0),(202,13,3,0),(203,13,4,1),(240,20,1,0),(241,20,2,0),(242,20,3,0),(243,20,4,1),(244,21,1,0),(245,21,2,0),(246,21,3,0),(247,21,4,1),(248,12,1,0),(249,12,2,0),(250,12,3,0),(251,12,4,0),(252,12,5,1),(253,22,1,0),(254,22,2,0),(255,22,3,0),(256,22,4,1),(257,22,5,0),(258,23,1,0),(259,23,2,0),(260,23,3,0),(261,23,4,1),(262,23,5,0),(283,1,1,1),(284,1,2,0),(285,1,3,0),(286,1,4,0),(287,1,5,0),(328,8,1,0),(329,8,2,1),(330,8,3,1),(331,8,4,0),(332,8,5,0),(333,17,1,0),(334,17,2,0),(335,17,3,0),(336,17,4,0),(337,17,5,1),(393,35,1,0),(394,35,2,0),(395,35,3,0),(396,35,4,0),(397,35,5,1),(398,36,1,0),(399,36,2,0),(400,36,3,0),(401,36,4,0),(402,36,5,1),(403,37,1,0),(404,37,2,0),(405,37,3,0),(406,37,4,0),(407,37,5,1),(408,38,1,0),(409,38,2,1),(410,38,3,0),(411,38,4,0),(412,38,5,0);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-09 14:13:48
