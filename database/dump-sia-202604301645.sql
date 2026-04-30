-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: sia
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `program_paket_id` int unsigned NOT NULL,
  `nama_kelas` varchar(50) NOT NULL COMMENT 'Contoh: Kelas 4, Kelas 7, Kelas 10',
  `tingkat` int NOT NULL COMMENT 'Untuk pengurutan otomatis (4,5,6 / 7,8,9 / 10,11,12)',
  `is_aktif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_program_kelas` (`program_paket_id`,`nama_kelas`),
  CONSTRAINT `fk_kelas_program` FOREIGN KEY (`program_paket_id`) REFERENCES `program_paket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,1,'Kelas 4',4,1,'2026-04-29 06:57:12'),(2,1,'Kelas 5',5,1,'2026-04-29 06:57:12'),(3,1,'Kelas 6',6,1,'2026-04-29 06:57:12'),(4,2,'Kelas 7',7,1,'2026-04-29 06:57:12'),(5,2,'Kelas 8',8,1,'2026-04-29 06:57:12'),(6,2,'Kelas 9',9,1,'2026-04-29 06:57:12'),(7,3,'Kelas 10',10,1,'2026-04-29 06:57:12'),(8,3,'Kelas 11',11,1,'2026-04-29 06:57:12'),(9,3,'Kelas 12',12,1,'2026-04-29 06:57:12');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_paket`
--

DROP TABLE IF EXISTS `program_paket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_paket` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_program` varchar(100) NOT NULL COMMENT 'Contoh: Paket A Setara SD/MI',
  `jenjang_setara` varchar(50) NOT NULL COMMENT 'SD/MI, SMP/MTs, SMA/SMK',
  `is_aktif` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama_program` (`nama_program`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_paket`
--

LOCK TABLES `program_paket` WRITE;
/*!40000 ALTER TABLE `program_paket` DISABLE KEYS */;
INSERT INTO `program_paket` VALUES (1,'Paket A Setara SD/MI','SD/MI',1,'2026-04-29 06:54:52'),(2,'Paket B Setara SMP/MTs','SMP/MTs',1,'2026-04-29 06:54:52'),(3,'Paket C Setara SMA/SMK','SMA/SMK',1,'2026-04-29 06:54:52');
/*!40000 ALTER TABLE `program_paket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responses_pendaftaran`
--

DROP TABLE IF EXISTS `responses_pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responses_pendaftaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nama_lengkap` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Pria','Wanita') NOT NULL,
  `agama` enum('Islam','Katholik','Protestan','Budha','Hindu','Konghucu','Yang lain') NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `alumni_sekolah` varchar(255) NOT NULL,
  `tahun_tamat` year NOT NULL,
  `alamat` text NOT NULL,
  `kelurahan` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `tinggal_bersama` enum('Orang Tua','Sendiri','Kontrakan','Yang lain') NOT NULL,
  `transportasi_sehari_hari` enum('Sepeda Motor','Angkutan Umum','Mobil','Jalan Kaki') NOT NULL,
  `program_paket_id` int unsigned NOT NULL,
  `kelas_id` int unsigned DEFAULT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_ibu_kandung` varchar(255) NOT NULL,
  `nik_ibu_kandung` varchar(16) NOT NULL,
  `nama_ayah_kandung` varchar(255) NOT NULL,
  `nik_ayah_kandung` varchar(16) NOT NULL,
  `pekerjaan_ibu` varchar(100) NOT NULL,
  `penghasilan_ibu` enum('0 - 500rb / bulan','500 rb - 1jt / bulan','1 jt - 2 jt / bulan','2 jt - 4 jt / bulan','lebih dari 4jt / bulan') NOT NULL,
  `pendidikan_ibu` enum('Tidak Sekolah','SD','SMP','SMA','D3','S1','S2','S3') NOT NULL,
  `pekerjaan_ayah` varchar(100) NOT NULL,
  `penghasilan_ayah` enum('0 - 500rb / bulan','500 rb - 1jt / bulan','1 jt - 2 jt / bulan','2 jt - 4 jt / bulan','lebih dari 4jt / bulan') NOT NULL,
  `pendidikan_ayah` enum('Tidak Sekolah','SD','SMP','SMA','D3','S1','S2','S3') NOT NULL,
  `no_handphone` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `orang_dikenal_pkbm` varchar(255) NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `file_akte_lahir` varchar(500) DEFAULT NULL,
  `file_ktp` varchar(500) DEFAULT NULL,
  `file_kartu_keluarga` varchar(500) DEFAULT NULL,
  `file_ijazah_terakhir` varchar(500) DEFAULT NULL,
  `file_raport` varchar(500) DEFAULT NULL,
  `file_pas_foto` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nik` (`nik`),
  UNIQUE KEY `unique_nisn` (`nisn`),
  KEY `idx_nik` (`nik`),
  KEY `idx_nisn` (`nisn`),
  KEY `idx_email` (`email`),
  KEY `idx_tanggal_daftar` (`tanggal_daftar`),
  KEY `fk_program_paket` (`program_paket_id`),
  KEY `fk_kelas` (`kelas_id`),
  CONSTRAINT `fk_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_program_paket` FOREIGN KEY (`program_paket_id`) REFERENCES `program_paket` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responses_pendaftaran`
--

LOCK TABLES `responses_pendaftaran` WRITE;
/*!40000 ALTER TABLE `responses_pendaftaran` DISABLE KEYS */;
INSERT INTO `responses_pendaftaran` VALUES (1,'2026-04-29 07:12:11','2026-04-29 07:12:11','Siti Aminah','2010-05-15','Bandung','Wanita','Islam',NULL,'SDN Sukamaju 01',2022,'Jl. Merdeka No. 10','Sukamaju','Cicadas','Bandung','Orang Tua','Jalan Kaki',1,1,'3273015505100001','Neng Kurnia','3273014405850001','Ujang Suryana','3273011203800001','Pedagang','1 jt - 2 jt / bulan','SMA','Sopir Angkutan','1 jt - 2 jt / bulan','SMP','081234567890, 085678901234','siti.aminah@email.com','Pak Dedi (Ketua RW)','2026-04-29',NULL,NULL,NULL,NULL,NULL,NULL),(2,'2026-04-29 07:12:11','2026-04-29 07:12:11','Budi Santoso','2009-11-20','Jakarta','Pria','Islam','1234567890','SDN Menteng 05',2021,'Jl. Anggrek No. 5','Menteng','Menteng','Jakarta Pusat','Sendiri','Sepeda Motor',1,2,'3171012011090001','Rina Wati','3171011508800001','Agus Santoso','3171010502780001','Ibu Rumah Tangga','0 - 500rb / bulan','SMP','Karyawan Swasta','2 jt - 4 jt / bulan','D3','085678901234','budi.santoso@email.com','Bu Sari (Guru PKBM)','2026-04-29',NULL,NULL,NULL,NULL,NULL,NULL),(3,'2026-04-29 07:12:11','2026-04-29 07:12:11','Dewi Lestari','2008-03-10','Surabaya','Wanita','Katholik',NULL,'SD Santa Maria',2020,'Jl. Kenangan No. 22','Gubeng','Gubeng','Surabaya','Kontrakan','Angkutan Umum',1,3,'3578011003080001','Maria Susanti','3578010512820001','Yohanes Lestari','3578012208790001','Guru Honorer','2 jt - 4 jt / bulan','S1','Wirausaha','lebih dari 4jt / bulan','S1','087711223344, 081299887766','dewi.lestari@email.com','Pastor Andreas','2026-04-29',NULL,NULL,NULL,NULL,NULL,NULL),(4,'2026-04-29 07:12:11','2026-04-29 07:12:11','Ahmad Rizki','2007-07-25','Yogyakarta','Pria','Islam','9876543210','SMPN 1 Yogyakarta',2019,'Jl. Malioboro No. 88','Sosromenduran','Gedongtengen','Yogyakarta','Orang Tua','Jalan Kaki',2,5,'3471012507070001','Sri Wahyuni','3471011006830001','Slamet Riyadi','3471010101800001','Pedagang Pasar','1 jt - 2 jt / bulan','SMP','PNS','2 jt - 4 jt / bulan','S1','085312345678','ahmad.rizki@email.com','Pak Hartono (Koordinator)','2026-04-29',NULL,NULL,NULL,NULL,NULL,NULL),(5,'2026-04-29 07:12:11','2026-04-29 07:12:11','Puteri Ayu Ningsih','2005-12-01','Semarang','Wanita','Budha',NULL,'SMPN 5 Semarang',2017,'Jl. Pandanaran No. 45','Mugassari','Semarang Selatan','Semarang','Orang Tua','Mobil',3,7,'3374010112050001','Linda Wijaya','3374012010800001','Wijaya Kusuma','3374011509780001','Dokter Umum','lebih dari 4jt / bulan','S2','Pengusaha','lebih dari 4jt / bulan','S1','081355667788, 085799001122','puteri.ayu@email.com','Bu Rina (Alumni PKBM)','2026-04-29',NULL,NULL,NULL,NULL,NULL,NULL),(6,'2026-04-29 01:25:46','2026-04-29 01:25:46','Test User','2000-01-01','Jakarta','Pria','Islam',NULL,'Test School',2020,'Jl. Test No. 1','Test','Test','Jakarta','Orang Tua','Sepeda Motor',1,NULL,'3171019999990001','Ibu Test','3171018888880001','Ayah Test','3171017777770001','IRT','1 jt - 2 jt / bulan','SMA','Wiraswasta','2 jt - 4 jt / bulan','SMA','081234567890','test1777451146@example.com','Test','2026-04-29',NULL,NULL,NULL,NULL,NULL,NULL),(7,'2026-04-29 01:35:12','2026-04-29 01:35:12','TEST_1777451712','2000-01-01','Test','Pria','Islam',NULL,'Test',2020,'Test','Test','Test','Test','Orang Tua','Jalan Kaki',1,NULL,'9999999999999999','Test','8888888888888888','Test','7777777777777777','Test','1 jt - 2 jt / bulan','SMA','Test','2 jt - 4 jt / bulan','SMA','081234567890','test_1777451712@example.com','Test','2026-04-29',NULL,NULL,NULL,NULL,NULL,NULL),(8,'2026-04-29 02:01:30','2026-04-29 02:01:30','ABDUL RAZAK','2000-01-01','Test','Pria','Islam',NULL,'Test',2020,'Test','Test','Test','Test','Orang Tua','Jalan Kaki',1,NULL,'1214060505140004','Test','8888888888888888','Test','7777777777777777','Test','1 jt - 2 jt / bulan','SMA','Test','2 jt - 4 jt / bulan','SMA','081234567890','sururi_ut@yahoo.co.id','Test','2026-04-29','uploads/pendaftaran/2pvRIZGwZwHBcjenWvxlcOpA4kTRMJEyB2tQgDJh.png',NULL,NULL,NULL,NULL,NULL),(9,'2026-04-29 02:57:00','2026-04-29 02:57:00','sadil','2026-04-22','TELUK DALAM','Pria','Islam','0123906654','dsad',2021,'Perum hutatap blok f no 5 sagulung\r\nPerumahan Buana Impian 1 Blok P No 6','test','dsa','Batam','Orang Tua','Sepeda Motor',1,NULL,'2171031809120044','dasdadad','2171050104000002','3123','2171050104000002','karyawan','0 - 500rb / bulan','Tidak Sekolah','dasd','0 - 500rb / bulan','Tidak Sekolah','082285550959, 082285556598, ','paudalmarhamahbatam@gmail.com','tester@gmail.com','2026-04-29','uploads/pendaftaran/TJg2xHahta0Nd8HqoV3eSjURNr611P398SkIm1ui.jpg','uploads/pendaftaran/ZFG7fdA8F1YjYESxOldV801aCMlqQ8KBsvJwIOpl.jpg','uploads/pendaftaran/kbqJ22clUnhEiHp7f6MLbkINYlXW7BJLoKAMlu0f.jpg','uploads/pendaftaran/hdrkSgJMG40QPwHbgUjZZlKn2te7jc44Z4vQSIKj.png','uploads/pendaftaran/RLuCooSFt6eY0dL70COBb343I5ejSQLeae4swIgz.jpg','uploads/pendaftaran/346RbOOXU1pwYDoWsHV1BCIc2EzI1GrceDMfENht.png');
/*!40000 ALTER TABLE `responses_pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sia'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-30 16:45:35
