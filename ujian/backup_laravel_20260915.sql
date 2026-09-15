/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.20-12.3.3-MariaDB, for Android (aarch64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	12.3.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `harga_modal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barang_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES
(1,'Beras 5kg','karung',1,200000.00,350000.00,'2026-09-03 07:46:53','2026-09-09 05:12:16'),
(2,'Gula 1kg','kg',100,14500.00,16000.00,'2026-09-03 07:46:53','2026-09-10 06:59:56'),
(3,'Minyak 1L','liter',100,18000.00,20500.00,'2026-09-03 07:46:53','2026-09-10 11:27:29'),
(4,'Beras Premium 5kg','Kg',60,500000.00,1000000.00,'2026-09-09 02:55:23','2026-09-10 09:09:41');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_08_25_071551_add_role_to_users_table',1),
(5,'2026_08_28_012449_create_barang_table',1),
(6,'2026_08_28_012733_create_pembelian_table',1),
(7,'2026_08_28_013044_create_transaksi_penjualan_table',1),
(8,'2026_09_01_071727_add_unique_index_to_nama_in_barang_table',1),
(9,'2026_09_02_073136_add_satuan_to_barang_table',1),
(10,'2026_09_03_070435_create_suppliers_table',1),
(11,'2026_09_03_070525_create_pembelian_table',2),
(12,'2026_09_03_070610_create_pembelian_detail_table',2),
(13,'2026_09_04_173415_add_snapshot_to_pembelian_detail_table',3),
(14,'2026_09_08_174821_create_penjualan_detail_table',4),
(15,'2026_09_08_180656_create_transaksi_penjualan_table',5),
(16,'2026_09_08_180754_create_penjualan_detail_table',5),
(17,'2026_09_09_105122_add_deleted_at_to_users_table',6),
(18,'2026_09_09_105440_add_display_name_to_users_table',7),
(19,'2026_09_09_112835_add_status_to_pembelian_table',8),
(20,'2026_09_09_121905_add_deleted_at_to_suppliers_table',9),
(21,'2026_09_09_122331_add_supplier_snapshot_to_pembelian_table',10),
(22,'2026_09_10_084738_drop_unique_constraint_from_suppliers_table',11),
(23,'2026_09_10_142147_add_pembayaran_to_transaksi_penjualan_table',12);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pembelian`
--

DROP TABLE IF EXISTS `pembelian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembelian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint(20) unsigned NOT NULL,
  `nama_supplier_snapshot` varchar(100) DEFAULT NULL,
  `total_harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('selesai','batal') NOT NULL DEFAULT 'selesai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembelian_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `pembelian_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembelian`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pembelian` WRITE;
/*!40000 ALTER TABLE `pembelian` DISABLE KEYS */;
INSERT INTO `pembelian` VALUES
(1,1,NULL,3200000.00,'selesai','2026-09-03 04:08:06','2026-09-03 04:08:06'),
(2,1,NULL,35600000.00,'selesai','2026-09-04 10:56:40','2026-09-04 10:56:40'),
(3,1,NULL,32000000.00,'batal','2026-09-04 21:50:13','2026-09-09 05:08:06'),
(8,1,NULL,1600000.00,'selesai','2026-09-08 06:10:11','2026-09-08 06:10:11'),
(9,1,NULL,18000.00,'selesai','2026-09-08 06:16:40','2026-09-08 06:16:40'),
(10,2,NULL,1450000.00,'selesai','2026-09-08 06:25:33','2026-09-08 06:25:33'),
(11,2,NULL,1450000.00,'selesai','2026-09-08 06:40:24','2026-09-08 06:40:24'),
(12,5,NULL,32000000.00,'batal','2026-09-08 07:10:58','2026-09-09 05:06:50'),
(13,5,NULL,32000000.00,'batal','2026-09-08 07:12:43','2026-09-09 05:06:10'),
(14,1,NULL,20000000.00,'batal','2026-09-09 02:09:16','2026-09-09 05:04:53');
/*!40000 ALTER TABLE `pembelian` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pembelian_detail`
--

DROP TABLE IF EXISTS `pembelian_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembelian_detail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pembelian_id` bigint(20) unsigned NOT NULL,
  `barang_id` bigint(20) unsigned NOT NULL,
  `nama_barang_snapshot` varchar(255) DEFAULT NULL,
  `satuan_snapshot` varchar(50) DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `harga_modal_saat_beli` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembelian_detail_pembelian_id_foreign` (`pembelian_id`),
  KEY `pembelian_detail_barang_id_foreign` (`barang_id`),
  CONSTRAINT `pembelian_detail_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`),
  CONSTRAINT `pembelian_detail_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembelian_detail`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pembelian_detail` WRITE;
/*!40000 ALTER TABLE `pembelian_detail` DISABLE KEYS */;
INSERT INTO `pembelian_detail` VALUES
(1,1,1,NULL,NULL,10,320000.00,3200000.00,'2026-09-03 04:08:06','2026-09-03 04:08:06'),
(2,2,1,NULL,NULL,100,320000.00,32000000.00,'2026-09-04 10:56:40','2026-09-04 10:56:40'),
(3,2,3,NULL,NULL,200,18000.00,3600000.00,'2026-09-04 10:56:40','2026-09-04 10:56:40'),
(4,3,1,NULL,NULL,100,320000.00,32000000.00,'2026-09-04 21:50:13','2026-09-04 21:50:13'),
(5,8,1,NULL,NULL,5,320000.00,1600000.00,'2026-09-08 06:10:11','2026-09-08 06:10:11'),
(6,9,3,NULL,NULL,1,18000.00,18000.00,'2026-09-08 06:16:40','2026-09-08 06:16:40'),
(7,10,2,NULL,NULL,100,14500.00,1450000.00,'2026-09-08 06:25:33','2026-09-08 06:25:33'),
(8,11,2,'Gula 1kg','kg',100,14500.00,1450000.00,'2026-09-08 06:40:24','2026-09-08 06:40:24'),
(9,12,1,'Beras 5kg','karung',100,320000.00,32000000.00,'2026-09-08 07:10:58','2026-09-08 07:10:58'),
(10,13,1,'Beras 5kg','karung',100,320000.00,32000000.00,'2026-09-08 07:12:43','2026-09-08 07:12:43'),
(12,14,1,'Beras 5kg','karung',100,200000.00,20000000.00,'2026-09-09 02:15:29','2026-09-09 02:15:29');
/*!40000 ALTER TABLE `pembelian_detail` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `penjualan_detail`
--

DROP TABLE IF EXISTS `penjualan_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `penjualan_detail` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint(20) unsigned NOT NULL,
  `barang_id` bigint(20) unsigned NOT NULL,
  `nama_barang_snapshot` varchar(255) DEFAULT NULL,
  `satuan_snapshot` varchar(50) DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `harga_jual_saat_transaksi` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualan_detail_penjualan_id_foreign` (`penjualan_id`),
  KEY `penjualan_detail_barang_id_foreign` (`barang_id`),
  CONSTRAINT `penjualan_detail_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`),
  CONSTRAINT `penjualan_detail_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `transaksi_penjualan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan_detail`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `penjualan_detail` WRITE;
/*!40000 ALTER TABLE `penjualan_detail` DISABLE KEYS */;
INSERT INTO `penjualan_detail` VALUES
(1,1,1,'Beras 5kg','karung',100,350000.00,35000000.00,'2026-09-08 11:54:18','2026-09-08 11:54:18'),
(3,2,1,'Beras 5kg','karung',50,320000.00,16000000.00,'2026-09-09 03:20:26','2026-09-09 03:20:26'),
(5,3,2,'Gula 1kg','kg',120,16000.00,1920000.00,'2026-09-10 06:59:56','2026-09-10 06:59:56'),
(6,4,3,'Minyak 1L','liter',100,20500.00,2050000.00,'2026-09-10 07:25:11','2026-09-10 07:25:11'),
(7,5,4,'Beras Premium 5kg','Kg',10,1000000.00,10000000.00,'2026-09-10 07:32:37','2026-09-10 07:32:37'),
(8,6,4,'Beras Premium 5kg','Kg',10,1000000.00,10000000.00,'2026-09-10 07:50:51','2026-09-10 07:50:51'),
(9,7,4,'Beras Premium 5kg','Kg',10,1000000.00,10000000.00,'2026-09-10 09:09:08','2026-09-10 09:09:08'),
(10,8,4,'Beras Premium 5kg','Kg',10,1000000.00,10000000.00,'2026-09-10 09:09:41','2026-09-10 09:09:41'),
(13,9,3,'Minyak 1L','liter',16,20500.00,328000.00,'2026-09-10 11:27:29','2026-09-10 11:27:29');
/*!40000 ALTER TABLE `penjualan_detail` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('i1ysjea2ngbvqsEjMoicKKST7ahz9wWcCrwKapw0',1,'127.0.0.1','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36','eyJfdG9rZW4iOiJORGdoRGg1UHE0aUk3eXBHTk5TZm9PTnl1MHM4aTFBeHk0MzNEUWFhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9iYXJhbmciLCJyb3V0ZSI6ImJhcmFuZy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1789268530),
('pKgdv8v8cR4anDbqQDH0PO3FluAixgCwoPJYPy4c',1,'127.0.0.1','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36','eyJfdG9rZW4iOiJBTXh5Q0VtQjZkQ2YxYndCcGV5dU1ZVDZoU1g2UWRNMWZWTTlLa0tWIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3Rlc3QtbGF5b3V0Iiwicm91dGUiOm51bGx9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=',1789040204),
('YF15RTGrczP4KxIHMFXUGTNjAHzcJJ19E387LbFV',1,'127.0.0.1','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36','eyJfdG9rZW4iOiJhMFlDVkx3QUJwNDVGNGtiSjR4d3VVeGs2aUc1bnJ4TjNmZTZPbWc3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmRcL2FkbWluIiwicm91dGUiOiJkYXNoYm9hcmQuYWRtaW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=',1789201237);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES
(1,'PT Sumber Jaya','2026-09-03 07:46:26','2026-09-09 10:57:13','2026-09-09 10:57:13'),
(2,'CV Maju Lancar','2026-09-03 07:46:26','2026-09-03 07:46:26',NULL),
(3,'UD Berkah Abadi','2026-09-03 07:46:26','2026-09-03 07:46:26',NULL),
(5,'Pak yanto','2026-09-08 07:07:02','2026-09-10 01:17:11','2026-09-10 01:17:11'),
(6,'Pak Yani','2026-09-10 01:19:18','2026-09-10 01:19:18',NULL),
(10,'Pak Asep','2026-09-10 01:23:49','2026-09-10 01:23:49',NULL),
(16,'Pak Yanto','2026-09-10 01:52:52','2026-09-10 03:04:04','2026-09-10 03:04:04'),
(17,'Pak Yanto','2026-09-10 04:54:54','2026-09-10 04:54:54',NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `transaksi_penjualan`
--

DROP TABLE IF EXISTS `transaksi_penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi_penjualan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `total_harga` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keuntungan_kotor` decimal(15,2) NOT NULL DEFAULT 0.00,
  `uang_dibayar` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kembalian` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_penjualan_user_id_foreign` (`user_id`),
  CONSTRAINT `transaksi_penjualan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_penjualan`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `transaksi_penjualan` WRITE;
/*!40000 ALTER TABLE `transaksi_penjualan` DISABLE KEYS */;
INSERT INTO `transaksi_penjualan` VALUES
(1,1,35000000.00,5000000.00,0.00,0.00,'2026-09-08 11:54:18','2026-09-08 11:54:18'),
(2,1,16000000.00,6000000.00,0.00,0.00,'2026-09-09 01:19:50','2026-09-09 03:20:26'),
(3,2,1920000.00,180000.00,0.00,0.00,'2026-09-10 06:57:28','2026-09-10 06:59:56'),
(4,1,2050000.00,250000.00,0.00,0.00,'2026-09-10 07:25:11','2026-09-10 07:25:11'),
(5,1,10000000.00,5000000.00,0.00,0.00,'2026-09-10 07:32:37','2026-09-10 07:32:37'),
(6,1,10000000.00,5000000.00,100000000.00,90000000.00,'2026-09-10 07:50:51','2026-09-10 07:50:51'),
(7,1,10000000.00,5000000.00,10000000.00,0.00,'2026-09-10 09:09:08','2026-09-10 09:09:08'),
(8,1,10000000.00,5000000.00,100000000.00,90000000.00,'2026-09-10 09:09:41','2026-09-10 09:09:41'),
(9,1,328000.00,40000.00,400000.00,72000.00,'2026-09-10 09:24:46','2026-09-10 11:27:29');
/*!40000 ALTER TABLE `transaksi_penjualan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','sales') NOT NULL DEFAULT 'sales',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Admin',NULL,'admin@catatrezekimu.com',NULL,'$2y$12$YgileFRFcXPs.PMVpPzS4eTH3avHI3RSh4GpBEAdZlI6UgzK6stk2','admin',NULL,'2026-09-03 00:39:46','2026-09-03 00:39:46',NULL),
(2,'Sales',NULL,'sales@catatrezekimu.com',NULL,'$2y$12$4B/FuqNVaVgGO8Gu2fDBgeAtqX6NTENuBm8jmukblafcg/aXXT/PG','sales',NULL,'2026-09-03 00:39:47','2026-09-03 00:39:47',NULL),
(3,'Arif','Arif','muhammadarifnurrohman96@gmail.com',NULL,'$2y$12$Eq3tSEmCcjXSO0Jb8QwhKuCloTWZBfZPLlh1rAIguZTfi8tgUds4q','sales',NULL,'2026-09-09 04:11:41','2026-09-09 04:11:49','2026-09-09 04:11:49'),
(4,'Arif','Arif (2)','muhammadarifnurrohman97@gmail.com',NULL,'$2y$12$mcBPMMsGzDVxu0sAWrieoubdObW7AQc03B19ngEV50QnCjZ/I6U8i','sales',NULL,'2026-09-09 04:14:59','2026-09-09 04:14:59',NULL),
(5,'sales','sales','sales5@catatrezekimu.com',NULL,'$2y$12$UseJuy2Lfr20IoNeBPJGM.al/fzgcQFaKbxDkA1Or3n9hpbUVASD6','sales',NULL,'2026-09-10 05:18:46','2026-09-10 05:21:32','2026-09-10 05:21:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-09-15 12:28:42
