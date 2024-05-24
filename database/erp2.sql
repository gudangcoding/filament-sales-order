/*
 Navicat Premium Data Transfer

 Source Server         : Lokal
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : erp2

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 15/05/2024 11:23:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `categories_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `categories_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `categories_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 1, 1, 'Mainan Anak Cowok', 'mainan-anak-cowok', '2024-05-14 11:23:37', '2024-05-14 11:23:37');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_toko` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `no_rek` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customers_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `customers_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `customers_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (1, NULL, NULL, 'FUTIAN', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (2, NULL, NULL, 'ADE LALA', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (3, NULL, NULL, 'SAPRUDIN', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (4, NULL, NULL, 'RINA ARYANI', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (5, NULL, NULL, 'SUSANTO CIPUTR', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (6, NULL, NULL, 'SUSANTO CIPUTR', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (7, NULL, NULL, 'YURIANTO', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (9, NULL, NULL, 'LIT SIUNG', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (10, NULL, NULL, 'FUTIAN', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (11, NULL, NULL, 'SURYANTONO', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (12, NULL, NULL, 'RICKY', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (13, NULL, NULL, 'SUTARDJI', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (14, NULL, NULL, 'TIEN SURJANIWATI', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customers` VALUES (15, 1, NULL, 'aa', 'aa', 'aa', '123', '2024-05-15 11:02:15', '2024-05-15 11:02:15');

-- ----------------------------
-- Table structure for data_alamats
-- ----------------------------
DROP TABLE IF EXISTS `data_alamats`;
CREATE TABLE `data_alamats`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `no_rekening` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `atas_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_toko` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `data_alamats_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `data_alamats_team_id_foreign`(`team_id` ASC) USING BTREE,
  CONSTRAINT `data_alamats_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `data_alamats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of data_alamats
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for invoice_details
-- ----------------------------
DROP TABLE IF EXISTS `invoice_details`;
CREATE TABLE `invoice_details`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint UNSIGNED NULL DEFAULT NULL,
  `total_qty` int NULL DEFAULT NULL,
  `total_amount` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `invoice_details_invoice_id_foreign`(`invoice_id` ASC) USING BTREE,
  CONSTRAINT `invoice_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of invoice_details
-- ----------------------------

-- ----------------------------
-- Table structure for invoices
-- ----------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `data_alamat_id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `type_bayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tempo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_amount` decimal(10, 2) NULL DEFAULT NULL,
  `dp` decimal(10, 2) NULL DEFAULT NULL,
  `sisa` decimal(10, 2) NULL DEFAULT NULL,
  `kembali` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `invoices_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `invoices_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `invoices_data_alamat_id_foreign`(`data_alamat_id` ASC) USING BTREE,
  CONSTRAINT `invoices_data_alamat_id_foreign` FOREIGN KEY (`data_alamat_id`) REFERENCES `data_alamats` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `invoices_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of invoices
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2023_05_07_025052_create_teams_table', 1);
INSERT INTO `migrations` VALUES (6, '2024_05_07_010154_create_satuans_table', 1);
INSERT INTO `migrations` VALUES (8, '2024_05_07_025138_create_data_alamats_table', 1);
INSERT INTO `migrations` VALUES (9, '2024_05_07_025218_create_categories_table', 1);
INSERT INTO `migrations` VALUES (10, '2024_05_07_025219_create_products_table', 1);
INSERT INTO `migrations` VALUES (11, '2024_05_07_025239_create_sales_orders_table', 1);
INSERT INTO `migrations` VALUES (12, '2024_05_10_124157_create_invoices_table', 1);
INSERT INTO `migrations` VALUES (13, '2024_05_13_132633_create_mutasi_banks_table', 1);
INSERT INTO `migrations` VALUES (14, '2024_05_14_085401_create_customers_table', 1);
INSERT INTO `migrations` VALUES (15, '2024_05_07_024225_create_permission_tables', 2);
INSERT INTO `migrations` VALUES (16, '2024_05_14_112117_create_mutasi_unmatcheds_table', 3);
INSERT INTO `migrations` VALUES (17, '2024_05_14_171418_create_notifications_table', 4);
INSERT INTO `migrations` VALUES (18, '2024_05_14_171817_create_notifications_table', 5);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`, `model_type`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id` ASC, `model_type` ASC) USING BTREE,
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 'App\\Models\\User', 1);

-- ----------------------------
-- Table structure for mutasi_banks
-- ----------------------------
DROP TABLE IF EXISTS `mutasi_banks`;
CREATE TABLE `mutasi_banks`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `tanggal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jumlah` decimal(10, 2) NULL DEFAULT NULL,
  `type` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `saldo` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `mutasi_banks_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `mutasi_banks_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `mutasi_banks_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mutasi_banks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mutasi_banks
-- ----------------------------

-- ----------------------------
-- Table structure for mutasi_unmatcheds
-- ----------------------------
DROP TABLE IF EXISTS `mutasi_unmatcheds`;
CREATE TABLE `mutasi_unmatcheds`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `tanggal` date NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cabang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jumlah` decimal(10, 2) NULL DEFAULT NULL,
  `type` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `saldo` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `mutasi_unmatcheds_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `mutasi_unmatcheds_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `mutasi_unmatcheds_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mutasi_unmatcheds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mutasi_unmatcheds
-- ----------------------------

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `notifications_notifiable_type_notifiable_id_index`(`notifiable_type` ASC, `notifiable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 85 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'view_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (2, 'view_any_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (3, 'create_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (4, 'update_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (5, 'restore_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (6, 'restore_any_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (7, 'replicate_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (8, 'reorder_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (9, 'delete_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (10, 'delete_any_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (11, 'force_delete_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (12, 'force_delete_any_category', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (13, 'view_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (14, 'view_any_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (15, 'create_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (16, 'update_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (17, 'restore_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (18, 'restore_any_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (19, 'replicate_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (20, 'reorder_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (21, 'delete_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (22, 'delete_any_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (23, 'force_delete_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (24, 'force_delete_any_data::alamat', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (25, 'view_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (26, 'view_any_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (27, 'create_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (28, 'update_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (29, 'restore_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (30, 'restore_any_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (31, 'replicate_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (32, 'reorder_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (33, 'delete_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (34, 'delete_any_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (35, 'force_delete_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (36, 'force_delete_any_invoice', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (37, 'view_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (38, 'view_any_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (39, 'create_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (40, 'update_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (41, 'restore_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (42, 'restore_any_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (43, 'replicate_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (44, 'reorder_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (45, 'delete_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (46, 'delete_any_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (47, 'force_delete_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (48, 'force_delete_any_mutasi::bank', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (49, 'view_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (50, 'view_any_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (51, 'create_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (52, 'update_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (53, 'restore_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (54, 'restore_any_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (55, 'replicate_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (56, 'reorder_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (57, 'delete_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (58, 'delete_any_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (59, 'force_delete_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (60, 'force_delete_any_product', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (61, 'view_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (62, 'view_any_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (63, 'create_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (64, 'update_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (65, 'restore_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (66, 'restore_any_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (67, 'replicate_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (68, 'reorder_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (69, 'delete_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (70, 'delete_any_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (71, 'force_delete_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (72, 'force_delete_any_sales::order', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (73, 'view_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (74, 'view_any_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (75, 'create_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (76, 'update_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (77, 'restore_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (78, 'restore_any_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (79, 'replicate_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (80, 'reorder_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (81, 'delete_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (82, 'delete_any_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (83, 'force_delete_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');
INSERT INTO `permissions` VALUES (84, 'force_delete_any_user', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for product_variants
-- ----------------------------
DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE `product_variants`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NULL DEFAULT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `harga` int NULL DEFAULT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ukuran_kemasan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `isi` int NULL DEFAULT NULL,
  `stok` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_variants_product_id_foreign`(`product_id` ASC) USING BTREE,
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_variants
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `category_id` bigint UNSIGNED NULL DEFAULT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `format_satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `products_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `products_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `products_category_id_foreign`(`category_id` ASC) USING BTREE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `products_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 1);
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (3, 1);
INSERT INTO `role_has_permissions` VALUES (4, 1);
INSERT INTO `role_has_permissions` VALUES (5, 1);
INSERT INTO `role_has_permissions` VALUES (6, 1);
INSERT INTO `role_has_permissions` VALUES (7, 1);
INSERT INTO `role_has_permissions` VALUES (8, 1);
INSERT INTO `role_has_permissions` VALUES (9, 1);
INSERT INTO `role_has_permissions` VALUES (10, 1);
INSERT INTO `role_has_permissions` VALUES (11, 1);
INSERT INTO `role_has_permissions` VALUES (12, 1);
INSERT INTO `role_has_permissions` VALUES (13, 1);
INSERT INTO `role_has_permissions` VALUES (14, 1);
INSERT INTO `role_has_permissions` VALUES (15, 1);
INSERT INTO `role_has_permissions` VALUES (16, 1);
INSERT INTO `role_has_permissions` VALUES (17, 1);
INSERT INTO `role_has_permissions` VALUES (18, 1);
INSERT INTO `role_has_permissions` VALUES (19, 1);
INSERT INTO `role_has_permissions` VALUES (20, 1);
INSERT INTO `role_has_permissions` VALUES (21, 1);
INSERT INTO `role_has_permissions` VALUES (22, 1);
INSERT INTO `role_has_permissions` VALUES (23, 1);
INSERT INTO `role_has_permissions` VALUES (24, 1);
INSERT INTO `role_has_permissions` VALUES (25, 1);
INSERT INTO `role_has_permissions` VALUES (26, 1);
INSERT INTO `role_has_permissions` VALUES (27, 1);
INSERT INTO `role_has_permissions` VALUES (28, 1);
INSERT INTO `role_has_permissions` VALUES (29, 1);
INSERT INTO `role_has_permissions` VALUES (30, 1);
INSERT INTO `role_has_permissions` VALUES (31, 1);
INSERT INTO `role_has_permissions` VALUES (32, 1);
INSERT INTO `role_has_permissions` VALUES (33, 1);
INSERT INTO `role_has_permissions` VALUES (34, 1);
INSERT INTO `role_has_permissions` VALUES (35, 1);
INSERT INTO `role_has_permissions` VALUES (36, 1);
INSERT INTO `role_has_permissions` VALUES (37, 1);
INSERT INTO `role_has_permissions` VALUES (38, 1);
INSERT INTO `role_has_permissions` VALUES (39, 1);
INSERT INTO `role_has_permissions` VALUES (40, 1);
INSERT INTO `role_has_permissions` VALUES (41, 1);
INSERT INTO `role_has_permissions` VALUES (42, 1);
INSERT INTO `role_has_permissions` VALUES (43, 1);
INSERT INTO `role_has_permissions` VALUES (44, 1);
INSERT INTO `role_has_permissions` VALUES (45, 1);
INSERT INTO `role_has_permissions` VALUES (46, 1);
INSERT INTO `role_has_permissions` VALUES (47, 1);
INSERT INTO `role_has_permissions` VALUES (48, 1);
INSERT INTO `role_has_permissions` VALUES (49, 1);
INSERT INTO `role_has_permissions` VALUES (50, 1);
INSERT INTO `role_has_permissions` VALUES (51, 1);
INSERT INTO `role_has_permissions` VALUES (52, 1);
INSERT INTO `role_has_permissions` VALUES (53, 1);
INSERT INTO `role_has_permissions` VALUES (54, 1);
INSERT INTO `role_has_permissions` VALUES (55, 1);
INSERT INTO `role_has_permissions` VALUES (56, 1);
INSERT INTO `role_has_permissions` VALUES (57, 1);
INSERT INTO `role_has_permissions` VALUES (58, 1);
INSERT INTO `role_has_permissions` VALUES (59, 1);
INSERT INTO `role_has_permissions` VALUES (60, 1);
INSERT INTO `role_has_permissions` VALUES (61, 1);
INSERT INTO `role_has_permissions` VALUES (62, 1);
INSERT INTO `role_has_permissions` VALUES (63, 1);
INSERT INTO `role_has_permissions` VALUES (64, 1);
INSERT INTO `role_has_permissions` VALUES (65, 1);
INSERT INTO `role_has_permissions` VALUES (66, 1);
INSERT INTO `role_has_permissions` VALUES (67, 1);
INSERT INTO `role_has_permissions` VALUES (68, 1);
INSERT INTO `role_has_permissions` VALUES (69, 1);
INSERT INTO `role_has_permissions` VALUES (70, 1);
INSERT INTO `role_has_permissions` VALUES (71, 1);
INSERT INTO `role_has_permissions` VALUES (72, 1);
INSERT INTO `role_has_permissions` VALUES (73, 1);
INSERT INTO `role_has_permissions` VALUES (74, 1);
INSERT INTO `role_has_permissions` VALUES (75, 1);
INSERT INTO `role_has_permissions` VALUES (76, 1);
INSERT INTO `role_has_permissions` VALUES (77, 1);
INSERT INTO `role_has_permissions` VALUES (78, 1);
INSERT INTO `role_has_permissions` VALUES (79, 1);
INSERT INTO `role_has_permissions` VALUES (80, 1);
INSERT INTO `role_has_permissions` VALUES (81, 1);
INSERT INTO `role_has_permissions` VALUES (82, 1);
INSERT INTO `role_has_permissions` VALUES (83, 1);
INSERT INTO `role_has_permissions` VALUES (84, 1);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_guard_name_unique`(`name` ASC, `guard_name` ASC) USING BTREE,
  INDEX `roles_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `roles_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `roles_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, NULL, NULL, 'super_admin', 'web', '2024-05-14 09:29:21', '2024-05-14 09:29:21');

-- ----------------------------
-- Table structure for sales_detail
-- ----------------------------
DROP TABLE IF EXISTS `sales_detail`;
CREATE TABLE `sales_detail`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sales_order_id` bigint UNSIGNED NULL DEFAULT NULL,
  `product_id` bigint UNSIGNED NULL DEFAULT NULL,
  `satuan_id` bigint UNSIGNED NULL DEFAULT NULL,
  `harga` decimal(8, 2) NULL DEFAULT NULL,
  `qty` int NULL DEFAULT NULL,
  `subtotal` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sales_detail_sales_order_id_foreign`(`sales_order_id` ASC) USING BTREE,
  INDEX `sales_detail_product_id_foreign`(`product_id` ASC) USING BTREE,
  INDEX `sales_detail_satuan_id_foreign`(`satuan_id` ASC) USING BTREE,
  CONSTRAINT `sales_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_detail_sales_order_id_foreign` FOREIGN KEY (`sales_order_id`) REFERENCES `sales_orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_detail_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuans` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_detail
-- ----------------------------

-- ----------------------------
-- Table structure for sales_orders
-- ----------------------------
DROP TABLE IF EXISTS `sales_orders`;
CREATE TABLE `sales_orders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `no_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `data_alamat_id` bigint UNSIGNED NULL DEFAULT NULL,
  `satuan_id` bigint UNSIGNED NULL DEFAULT NULL,
  `total_amount` decimal(8, 2) NULL DEFAULT NULL,
  `total_barang` int NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sales_orders_no_order_unique`(`no_order` ASC) USING BTREE,
  INDEX `sales_orders_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `sales_orders_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `sales_orders_data_alamat_id_foreign`(`data_alamat_id` ASC) USING BTREE,
  INDEX `sales_orders_satuan_id_foreign`(`satuan_id` ASC) USING BTREE,
  CONSTRAINT `sales_orders_data_alamat_id_foreign` FOREIGN KEY (`data_alamat_id`) REFERENCES `data_alamats` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuans` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `sales_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_orders
-- ----------------------------

-- ----------------------------
-- Table structure for satuans
-- ----------------------------
DROP TABLE IF EXISTS `satuans`;
CREATE TABLE `satuans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of satuans
-- ----------------------------

-- ----------------------------
-- Table structure for team_user
-- ----------------------------
DROP TABLE IF EXISTS `team_user`;
CREATE TABLE `team_user`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `team_user_team_id_foreign`(`team_id` ASC) USING BTREE,
  INDEX `team_user_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `team_user_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `team_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of team_user
-- ----------------------------
INSERT INTO `team_user` VALUES (1, 1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for teams
-- ----------------------------
DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `teams_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teams
-- ----------------------------
INSERT INTO `teams` VALUES (1, 'PT Sinar abadi Jatirangga', 'pt-sinar-abadi-jatirangga', '2024-05-14 09:29:05', '2024-05-14 09:29:05');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin', 'a@a.com', NULL, '$2y$10$bhufHIf75XSG3iU4LyWQ2Oeg5USDEzZoq2ki48wMFuL6i14UcUsre', 0, NULL, '2024-05-14 09:28:45', '2024-05-14 09:28:45');

SET FOREIGN_KEY_CHECKS = 1;
