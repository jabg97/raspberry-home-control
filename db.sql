CREATE DATABASE  IF NOT EXISTS `home` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `home`;
-- MySQL dump 10.15  Distrib 10.0.32-MariaDB, for debian-linux-gnueabihf (armv8l)
--
-- Host: localhost    Database: home
-- ------------------------------------------------------
-- Server version	10.0.32-MariaDB-0+deb8u1

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
-- Table structure for table `dispositivos`
--

DROP TABLE IF EXISTS `dispositivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispositivos` (
  `pin` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `log` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`pin`),
  UNIQUE KEY `UNIQ_5C1C5F523A909126` (`nombre`),
  UNIQUE KEY `UNIQ_5C1C5F528F3F68C5` (`log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispositivos`
--

LOCK TABLES `dispositivos` WRITE;
/*!40000 ALTER TABLE `dispositivos` DISABLE KEYS */;
INSERT INTO `dispositivos` VALUES ('21-:-22','Puerta','13-:-6',3),('22','Bombillo baño','6',0),('29','Zona de Iluminacion #1','21',3),('3','comedor','8',1),('3-:-5','Cortina #1','8-:-9',3),('31','Zona de Iluminacion #2','22',3),('32','Zona de Iluminacion #3','26',3),('33','Sensor de Humo','23',0),('35','Sensor de Movimiento #1','24',2),('36','Sensor de Movimiento #2','27',2),('37','Zona de Iluminacion #4','25',3),('38','Zona de Iluminacion #5','28',3),('40','Zona de Iluminacion #6','29',3),('5','sensor 1','9',1),('7','sensor 2','7',1),('7-:-8','Cortina #2','7-:-15',3);
/*!40000 ALTER TABLE `dispositivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `in_out`
--

DROP TABLE IF EXISTS `in_out`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `in_out` (
  `pin` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `pout` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pin`,`pout`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `in_out`
--

LOCK TABLES `in_out` WRITE;
/*!40000 ALTER TABLE `in_out` DISABLE KEYS */;
INSERT INTO `in_out` VALUES ('33','33'),('33','35');
/*!40000 ALTER TABLE `in_out` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_device`
--

DROP TABLE IF EXISTS `user_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_device` (
  `pin` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pin`,`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_device`
--

LOCK TABLES `user_device` WRITE;
/*!40000 ALTER TABLE `user_device` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `codigo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rol` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fechalimite` datetime NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `UNIQ_EF687F2E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('admin','admin@admin.com','ROLE_ADMIN','$2y$04$dml5dj533XwS2xzdecELl.JxjVbcmVFHXXv15OJe7GsbXh9a79nRS','',null),('root','balantajaiver@gmail.com','ROLE_ADMIN','$2y$04$dml5dj533XwS2xzdecELl.JxjVbcmVFHXXv15OJe7GsbXh9a79nRS','',null);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-09 13:53:49
