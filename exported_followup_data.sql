-- MySQL dump 10.13  Distrib 9.2.0, for macos15.2 (arm64)
--
-- Host: 127.0.0.1    Database: hala
-- ------------------------------------------------------
-- Server version	8.1.0

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
-- Table structure for table `surgery_types`
--

DROP TABLE IF EXISTS `surgery_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surgery_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surgery_types`
--

LOCK TABLES `surgery_types` WRITE;
/*!40000 ALTER TABLE `surgery_types` DISABLE KEYS */;
INSERT INTO `surgery_types` VALUES (6,'ولادة طبيعيه','2025-04-24 10:01:55','2025-04-24 10:01:55'),(7,'قيصرية اولى','2025-04-24 10:02:30','2025-04-24 10:02:30'),(8,'قيصرية ثانية','2025-04-24 10:02:43','2025-04-24 10:02:43'),(9,'قيصرية ثالثة','2025-04-24 10:02:55','2025-04-24 10:02:55'),(10,'قيصرية رابعة','2025-04-24 10:03:09','2025-04-24 10:03:09'),(11,'ناظور بطني','2025-04-24 11:01:13','2025-04-24 11:01:13'),(12,'ناظور','2025-04-25 05:38:03','2025-04-25 05:38:03');
/*!40000 ALTER TABLE `surgery_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospitals`
--

DROP TABLE IF EXISTS `hospitals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hospitals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitals`
--

LOCK TABLES `hospitals` WRITE;
/*!40000 ALTER TABLE `hospitals` DISABLE KEYS */;
INSERT INTO `hospitals` VALUES (3,'المستشفى الملكي','حي الجامعة','2025-04-24 09:51:38','2025-04-24 09:51:38'),(4,'الشرق الاوسط','الحرية','2025-04-24 09:52:09','2025-04-24 09:52:09'),(5,'القمة','العطيفية','2025-04-24 09:52:27','2025-04-24 09:52:27');
/*!40000 ALTER TABLE `hospitals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followup_template_surgery_type`
--

DROP TABLE IF EXISTS `followup_template_surgery_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `followup_template_surgery_type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `surgery_type_id` bigint unsigned NOT NULL,
  `followup_template_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `followup_template_surgery_type_surgery_type_id_foreign` (`surgery_type_id`),
  KEY `followup_template_surgery_type_followup_template_id_foreign` (`followup_template_id`),
  CONSTRAINT `followup_template_surgery_type_followup_template_id_foreign` FOREIGN KEY (`followup_template_id`) REFERENCES `followup_templates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `followup_template_surgery_type_surgery_type_id_foreign` FOREIGN KEY (`surgery_type_id`) REFERENCES `surgery_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followup_template_surgery_type`
--

LOCK TABLES `followup_template_surgery_type` WRITE;
/*!40000 ALTER TABLE `followup_template_surgery_type` DISABLE KEYS */;
INSERT INTO `followup_template_surgery_type` VALUES (11,6,9,NULL,NULL),(12,6,11,NULL,NULL),(13,6,10,NULL,NULL),(14,6,15,NULL,NULL),(15,7,12,NULL,NULL),(16,7,15,NULL,NULL),(17,7,14,NULL,NULL),(18,7,13,NULL,NULL),(19,8,15,NULL,NULL),(20,8,12,NULL,NULL),(21,8,14,NULL,NULL),(22,8,13,NULL,NULL),(23,9,13,NULL,NULL),(24,9,14,NULL,NULL),(25,9,12,NULL,NULL),(26,9,15,NULL,NULL),(27,10,13,NULL,NULL),(28,10,14,NULL,NULL),(29,10,12,NULL,NULL),(30,10,15,NULL,NULL),(31,12,16,NULL,NULL);
/*!40000 ALTER TABLE `followup_template_surgery_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followup_templates`
--

DROP TABLE IF EXISTS `followup_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `followup_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days_after_surgery` int NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followup_templates`
--

LOCK TABLES `followup_templates` WRITE;
/*!40000 ALTER TABLE `followup_templates` DISABLE KEYS */;
INSERT INTO `followup_templates` VALUES (9,'طبيعي ٣',3,'وياج فريق متابعة عيادة الدكتورة حلا , حبينا نطمئن على صحتج ونبلغج تحيات الدكتورة ونسألج على بعض التفاصيل\nاولاً شلونج؟ وشلون البيبي؟ إن شاء الله بخير؟\nأدويتج ماشية عليها بانتظام؟ لازم تلتزمين بيها لمدة ١٠ ايام بدون اي انقطاع حفاظاً على صحتج\nاذا امكن تدزيلنا صورة للعلاجات الي دتستخدميها\nاذا صار عندج قص عجان بالولادة اكو الم بالمنطقة ؟ الجرح شلونه ؟ اكو نزف او التهاب لو لا؟\nصار عندج أي مضاعفات؟ وتغذيتج شلونها؟ وطلعت بطنج لو بعد؟ قبض لو اسهال ؟ وشوكت اخر مرة طلعت ؟\nدتحركين شوية لو بعدج أغلب الوقت نايمة؟ لازم على الاقل ٣ ساعات تتحركين يومياً وهل فترة ياريت تكون اطول اذا صارت عندج سابقاً خثرة او سكر حمل او ارتفاع ضغط او امراض مزمنة اخرى\nولا تنسين إحنا هنا إذا تحتاجين أي شي.\nكل الهلا بيج،\nعيادة الدكتورة حلا حسين التميمي','2025-04-24 09:55:17','2025-04-24 09:55:17'),(10,'طبيعي ٩',9,'شلونج؟ وشلونه البيبي اليوم؟ ان شاء الله صحته تمام ؟\nنذكرك، باجر عدنا موعد رفع الخيط اذا عندج شق بالعجان . لا تنسين تنورينا بالعيادة، إحنا ننتظرچ ونحب نطمئن عليچ.\nالحمد لله على سلامتچ، ودوم إن شاء الله بخير وصحة. إذا عدچ أي استفسار، إحنا موجودين.\nتحياتنا،\nعيادة الدكتورة حلا حسين التميمي','2025-04-24 09:55:37','2025-04-24 09:55:37'),(11,'طبيعي ٣٩',39,'قرب موعد فحص الأربعين، نحب نشوفچ ونتطمن على صحتچ وصحة البيبي.\nكلش مهم تنورينا بالعيادة حتى نناقش وياچ نوع المانع اللي يناسب عمرچ وجسمچ، وايضاً كلش مهم فحص السونار بهذا الوقت حتى نتأكد الرحم رجع لمكانه الطبيعي في الحوض ؟ إحنا هنا حتى نساعدچ بالاختيار الصح.\nنتمنى نشوفچ بأقرب وقت ، وكل الهلا بيچ.\nتحياتنا،\nعيادة الدكتورة حلا حسين التميمي','2025-04-24 09:55:57','2025-04-24 09:55:57'),(12,'قيصرية ٣',3,'وياج فريق متابعة عيادة الدكتورة حلا , حبينا نطمئن على صحتج ونبلغج تحيات الدكتورة ونسألج على بعض التفاصيل\nاولاً شلونج؟ وشلون البيبي؟ إن شاء الله بخير؟\nأدويتج ماشية عليها بانتظام؟ لازم تلتزمين بيها لمدة ١٠ ايام بدون اي انقطاع حفاظاً على صحتج\nاذا امكن تدزيلنا صورة للعلاجات الي دتستخدميها\nشلون الضماد؟ يابس لو غيرتوا ؟ إذا بدلتيه برا أو داخل المستشفى، ياريت تبلغينا إذا تحتاجين أي مساعدة.\nصار عندج أي مضاعفات؟ وتغذيتج شلونها؟ وطلعت بطنج لو بعد؟ وشوكت اخر مرة طلعت ؟\nدتحركين شوية لو بعدج أغلب الوقت نايمة؟ لازم على الاقل ٣ ساعات تتحركين يومياً وهل فترة ياريت تكون اطول اذا صار عندج سابقاً خثرة او سكر حمل او ارتفاع ضغط او امراض مزمنة اخرى\nولا تنسين إحنا هنا إذا تحتاجين أي شي.\nكل الهلا بيج\nعيادة الدكتورة حلا حسين التميمي','2025-04-24 09:56:45','2025-04-24 09:56:45'),(13,'قيصرية ٩',9,'شلونج؟ وشلونه البيبي اليوم؟ ان شاء الله صحته تمام ؟\nنذكرك، باجر عدنا موعد رفع الخيط. لا تنسين تنورينا بالعيادة، إحنا ننتظرچ ونحب نطمئن عليچ.\nالحمد لله على سلامتچ، ودوم إن شاء الله بخير وصحة. إذا عدچ أي استفسار، إحنا موجودين.\nتحياتنا،\nعيادة الدكتورة حلا حسين التميمي','2025-04-24 09:57:02','2025-04-24 09:57:02'),(14,'قيصرية ٣٩',39,'قرب موعد فحص الأربعين، نحب نشوفچ ونتطمن على صحتچ وصحة البيبي.\nكلش مهم تنورينا بالعيادة حتى نناقش وياچ نوع المانع اللي يناسب عمرچ وجسمچ، وايضاً كلش مهم فحص السونار بهذا الوقت حتى نتأكد الرحم رجع لمكانه الطبيعي في الحوض ؟ إحنا هنا حتى نساعدچ بالاختيار الصح.\nنتمنى نشوفچ بأقرب وقت ، وكل الهلا بيچ.\nتحياتنا،\nعيادة الدكتورة حلا حسين التميمي','2025-04-24 09:57:21','2025-04-24 09:57:21'),(15,'عيد ميلاد الطفل',365,'اليوم ذكرى مميزة! مرّت سنة كاملة على جيّة صغيرچ الحلو للدنيا. عيد ميلاد سعيد إله، وإن شاء الله أيامه كلها فرح وسعادة وصحة.\nإحنا كلش فخورين بأنه كنا جزء من رحلتچ بالأمومة، وإن شاء الله تبقون دوم بخير وسعادة.\nكل عام وأنتِ وطفلچ بألف خير!\nتحياتنا،\nعيادة الدكتورة حلا حسين التميمي','2025-04-24 10:00:40','2025-04-24 10:00:40'),(16,'متابعة ناظور',5,'شلون صحتج','2025-04-25 05:37:46','2025-04-25 05:37:46');
/*!40000 ALTER TABLE `followup_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followup_surgery_type`
--

DROP TABLE IF EXISTS `followup_surgery_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `followup_surgery_type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `followup_template_id` bigint unsigned NOT NULL,
  `surgery_type_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `followup_surgery_type_followup_template_id_foreign` (`followup_template_id`),
  KEY `followup_surgery_type_surgery_type_id_foreign` (`surgery_type_id`),
  CONSTRAINT `followup_surgery_type_followup_template_id_foreign` FOREIGN KEY (`followup_template_id`) REFERENCES `followup_templates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `followup_surgery_type_surgery_type_id_foreign` FOREIGN KEY (`surgery_type_id`) REFERENCES `surgery_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followup_surgery_type`
--

LOCK TABLES `followup_surgery_type` WRITE;
/*!40000 ALTER TABLE `followup_surgery_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `followup_surgery_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-27 11:38:32
