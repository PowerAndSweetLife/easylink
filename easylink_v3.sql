-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 août 2023 à 13:59
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `easylink_v3`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `app_lang` varchar(255) NOT NULL DEFAULT 'fr',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `contact`, `is_super_admin`, `app_lang`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$y/KMbJAFLpny5t4srvepDewg8V5GYNlC/XgcVi3g55TP1Jiya6jM2', 'Admin', 'Admin', 'admin@easylink.mg', '033 00 000 00', 1, 'en', NULL, '2023-08-17 03:20:06'),
(2, 'admin', '$2y$10$uiiqR2otkyApmtyo.jphm.7jfrJJOvnCCbgp2pz40Jum66EVIse8W', 'Admin', 'Admin', 'admin@easylink.mg', '033 00 000 00', 1, 'fr', NULL, NULL),
(4, 'SRV', '$2y$10$F8YjfYj5rNZMGbcVUbjDI.1buNseuFFAxyQbiwGUP9gyM988xXSK2', 'Steve Ray', 'Vaughan', 'srv@mail.me', '0343403434', 0, 'fr', '2023-08-17 02:49:58', '2023-08-17 02:49:58');

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `app_lang` varchar(255) NOT NULL DEFAULT 'en',
  `localization_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agents`
--

INSERT INTO `agents` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `contact`, `app_lang`, `localization_id`, `created_at`, `updated_at`, `address`, `phone`) VALUES
(9, 'MOR', '$2y$10$kEARE6qK5yHfjvlJTq/s8Owl4sM1E76bAXjBhGWyN1ZU0jywaL6ye', 'Conner', 'Morissette', 'uwill@gmail.com', '931.596.2597', 'en', 1, '2023-08-17 03:03:29', '2023-08-17 08:56:47', '{\"small\":\"617-59 \\u9023\\u6c5f\\u7e23\\u5357\\u7aff\\u9109\\u5927\\u8c50\\u8857205\\u5df7894\\u5f04120\\u865f22\\u6a13\",\"regular\":\"901 \\u5f70\\u5316\\u7e23\\u79c0\\u6c34\\u9109\\u4e2d\\u8857\\u8def217\\u5df7176\\u865f98\\u6a13\"}', '00-222');

-- --------------------------------------------------------

--
-- Structure de la table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) NOT NULL,
  `cob` datetime DEFAULT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 1,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manifest_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bookings`
--

INSERT INTO `bookings` (`id`, `reference`, `cob`, `is_open`, `client_id`, `agent_id`, `created_at`, `updated_at`, `manifest_id`) VALUES
(6, 'B230001', '2023-08-17 06:09:10', 0, 7, 9, '2023-08-17 03:07:08', '2023-08-17 03:07:08', 8),
(7, 'B230002', '2023-08-17 06:40:39', 0, 7, 9, '2023-08-17 03:40:02', '2023-08-17 03:40:02', 9),
(8, 'B230003', '2023-08-17 07:01:08', 0, 7, 9, '2023-08-17 04:00:38', '2023-08-17 04:00:38', 10),
(9, 'B230004', '2023-08-17 07:55:32', 0, 7, 9, '2023-08-17 04:47:38', '2023-08-17 04:47:38', 12),
(10, 'B230005', '2023-08-17 11:08:48', 0, 8, 9, '2023-08-17 08:05:57', '2023-08-17 08:08:48', 13),
(11, 'B230006', NULL, 1, 8, 9, '2023-08-17 08:17:12', '2023-08-17 08:23:11', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(8,2) NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `price`, `admin_id`, `created_at`, `updated_at`) VALUES
(12, 'Produits perissables', 15000.00, 1, '2023-08-17 02:42:50', '2023-08-17 02:43:05');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cbm` double(8,2) NOT NULL DEFAULT 0.00,
  `app_lang` varchar(255) NOT NULL DEFAULT 'fr',
  `civility` varchar(5) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `nif` varchar(255) DEFAULT NULL,
  `stat` varchar(255) DEFAULT NULL,
  `rcs` varchar(255) DEFAULT NULL,
  `cif_card` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email_confirmation_code` varchar(255) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `uid`, `email`, `contact`, `type`, `cbm`, `app_lang`, `civility`, `firstname`, `lastname`, `company_name`, `nif`, `stat`, `rcs`, `cif_card`, `password`, `email_confirmation_code`, `confirmed_at`, `created_at`, `updated_at`) VALUES
(7, 'MG23002', 'magdalena28@bayer.net', '+15519062789', 'company', 9.13, 'fr', NULL, NULL, NULL, 'Gottlieb-Nikolaus', '79240474', '55193368', '84797675', 'confirmemail_copy_copy.PNG', '$2y$10$MKkw2zGJkDAC4Ow9ZbjgGex76vYZrRSOTbyz61hf43uttWSB0rKDG', 'HYWL76Z4', '2023-08-17 06:04:10', '2023-08-17 03:04:06', '2023-08-17 05:05:22'),
(8, 'MG23003', 'jennyhery@proton.me', '+2613403434', 'individual', 3.83, 'fr', 'Mr.', 'Rakotoarisoa', 'Jenny', NULL, NULL, NULL, NULL, NULL, '$2y$10$Cl.Uz.Pq5QNWsj3LnrYNqOesH7kMAw0YOw40ZPKC/fz.tDjv894WC', 'L3MW8E3U', '2023-08-17 11:04:56', '2023-08-17 08:04:47', '2023-08-17 08:14:32');

-- --------------------------------------------------------

--
-- Structure de la table `colis`
--

CREATE TABLE `colis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `receip_number` varchar(255) NOT NULL,
  `courrier_company` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `dimensions` text DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `shiporder` varchar(255) NOT NULL,
  `send_at` datetime NOT NULL,
  `receive_at` datetime DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `colis`
--

INSERT INTO `colis` (`id`, `receip_number`, `courrier_company`, `description`, `dimensions`, `attachments`, `status`, `shiporder`, `send_at`, `receive_at`, `client_id`, `agent_id`, `booking_id`, `created_at`, `updated_at`, `category_id`) VALUES
(9, 'LJJWR118', 'Kutch Inc', '12', '[{\"count\":3,\"length\":79,\"width\":79,\"height\":56,\"weight\":53}]', NULL, 'delivered', 'S230001', '2023-08-17 06:05:29', '2023-08-17 06:07:08', 7, 9, 6, '2023-08-17 03:05:29', '2023-08-17 03:15:14', 12),
(10, 'ODIHK241', 'Smith LLC', '12', '[{\"count\":2,\"length\":71,\"width\":100,\"height\":55,\"weight\":8}]', NULL, 'delivered', 'S230002', '2023-08-17 06:05:48', '2023-08-17 06:07:08', 7, 9, 6, '2023-08-17 03:05:48', '2023-08-17 03:15:14', 12),
(11, 'KFMWD250', 'Kerluke Group', '12', '[{\"count\":3,\"length\":56,\"width\":58,\"height\":73,\"weight\":17}]', NULL, 'delivered', 'S230003', '2023-08-17 06:39:19', '2023-08-17 06:40:06', 7, 9, 7, '2023-08-17 03:39:19', '2023-08-17 03:41:51', 12),
(12, 'DKUQC165', 'Streich-Murazik', '12', '[{\"count\":5,\"length\":90,\"width\":67,\"height\":62,\"weight\":30}]', NULL, 'delivered', 'S230004', '2023-08-17 06:39:23', '2023-08-17 06:40:06', 7, 9, 7, '2023-08-17 03:39:23', '2023-08-17 03:41:51', 12),
(13, 'UHCUN341', 'Tromp, Hickle and Corwin', '12', '[{\"count\":4,\"length\":99,\"width\":61,\"height\":81,\"weight\":77}]', NULL, 'delivered', 'S230005', '2023-08-17 06:39:24', '2023-08-17 06:40:02', 7, 9, 7, '2023-08-17 03:39:24', '2023-08-17 03:41:51', 12),
(14, 'ODDAS695', 'Hermann-Wolff', '12', '[{\"count\":5,\"length\":70,\"width\":71,\"height\":50,\"weight\":43}]', NULL, 'delivered', 'S230006', '2023-08-17 06:39:25', '2023-08-17 06:40:02', 7, 9, 7, '2023-08-17 03:39:25', '2023-08-17 03:41:51', 12),
(15, 'XGJVU478', 'O\'Conner Ltd', '12', '[{\"count\":1,\"length\":65,\"width\":96,\"height\":50,\"weight\":58}]', NULL, 'delivered', 'S230007', '2023-08-17 06:59:17', '2023-08-17 07:00:38', 7, 9, 8, '2023-08-17 03:59:17', '2023-08-19 04:04:35', 12),
(16, 'YLZOY546', 'Ziemann, Price and Emmerich', '12', '[{\"count\":5,\"length\":75,\"width\":53,\"height\":61,\"weight\":64}]', NULL, 'delivered', 'S230008', '2023-08-17 07:45:00', '2023-08-17 07:47:38', 7, 9, 9, '2023-08-17 04:45:00', '2023-08-17 04:59:50', 12),
(18, 'Soleil', 'Haley Ltd', '12', '[{\"count\":5,\"length\":98,\"width\":94,\"height\":71,\"weight\":10}]', NULL, 'delivered', 'S230010', '2023-08-17 11:05:24', '2023-08-17 11:05:57', 8, 9, 10, '2023-08-17 08:05:24', '2023-08-17 08:12:43', 12),
(19, 'Lune', 'Reichert-Davis', '12', '[{\"count\":1,\"length\":75,\"width\":77,\"height\":97,\"weight\":16}]', NULL, 'delivered', 'S230011', '2023-08-17 11:06:50', '2023-08-17 11:07:15', 8, 9, 10, '2023-08-17 08:06:50', '2023-08-17 08:12:43', 12),
(20, 'test', 'D\'Amore-Balistreri', 'laboriosam,error,numquam,harum', '[{\"count\":1,\"length\":59,\"width\":86,\"height\":60,\"weight\":18}]', NULL, 'receive', 'S230012', '2023-08-17 11:16:54', '2023-08-17 11:28:09', 8, 9, 11, '2023-08-17 08:16:54', '2023-08-17 08:28:09', 12),
(21, 'FYZDV286', 'Cruickshank, Mosciski and Bruen', 'optio,magni,omnis,reiciendis', '[{\"count\":2,\"length\":79,\"width\":62,\"height\":55,\"weight\":85}]', NULL, 'send', 'T230013', '2023-08-17 11:40:39', NULL, 8, 9, NULL, '2023-08-17 08:40:39', '2023-08-17 08:40:39', 12),
(22, 'NIIOI491', 'Romaguera, Jakubowski and Beatty', 'praesentium,aspernatur', '[{\"count\":1,\"length\":86,\"width\":96,\"height\":55,\"weight\":28}]', NULL, 'send', 'T230014', '2023-08-17 11:40:40', NULL, 8, 9, NULL, '2023-08-17 08:40:40', '2023-08-17 08:40:40', 12),
(23, 'IHIXP933', 'Daniel-Zemlak', 'consequatur,odit', '[{\"count\":3,\"length\":52,\"width\":68,\"height\":95,\"weight\":64}]', NULL, 'receive', 'S230015', '2023-08-17 11:40:41', '2023-08-17 11:40:54', 8, 9, 11, '2023-08-17 08:40:41', '2023-08-17 08:40:54', 12);

-- --------------------------------------------------------

--
-- Structure de la table `containers`
--

CREATE TABLE `containers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `carrier` varchar(255) NOT NULL,
  `vessel_voyage` varchar(255) NOT NULL,
  `port_of_load` varchar(255) NOT NULL,
  `port_of_discharge` varchar(255) NOT NULL,
  `etd` datetime NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `containers`
--

INSERT INTO `containers` (`id`, `number`, `type`, `carrier`, `vessel_voyage`, `port_of_load`, `port_of_discharge`, `etd`, `is_available`, `created_at`, `updated_at`, `agent_id`) VALUES
(8, 'KBDTY204', '40\'', 'Price-Pacocha', 'Error/Omnis', 'China', 'Tamatave', '2023-08-17 00:00:00', 0, '2023-08-17 03:08:21', '2023-08-17 08:41:43', 9),
(9, 'YLELP735', '20\'', 'Goodwin-Ritchie', 'Est/Fugit', 'China', 'Tamatave', '2023-08-17 00:00:00', 0, '2023-08-17 03:40:23', '2023-08-17 03:40:45', 9),
(10, 'PTVSF009', '40\'', 'Strosin, Homenick and Jerde', 'Voluptas/Doloribus', 'China', 'Tamatave', '2023-08-17 00:00:00', 0, '2023-08-17 04:00:59', '2023-08-17 04:02:01', 9),
(11, 'AYYPM566', '40\'', 'Ward and Sons', 'Ut/Sint', 'China', 'Tamatave', '2023-08-17 00:00:00', 0, '2023-08-17 04:53:07', '2023-08-17 04:55:01', 9),
(12, 'JYPUJ363', '40\'', 'Dach, Leffler and Jast', 'Omnis/Molestiae', 'China', 'Tamatave', '2023-08-17 00:00:00', 0, '2023-08-17 04:55:24', '2023-08-17 04:55:38', 9),
(13, 'YAJSE996', '40\'', 'Harber-Rowe', 'Doloribus/Molestiae', 'China', 'Tamatave', '2023-08-17 00:00:00', 0, '2023-08-17 08:06:26', '2023-08-17 08:08:55', 9),
(14, 'TYIGD598', '40\'', 'Boyle, Senger and Feil', 'Id/Nam', 'China', 'Tamatave', '2023-08-17 00:00:00', 1, '2023-08-17 08:21:33', '2023-08-17 08:21:33', 9);

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(30,2) DEFAULT NULL,
  `amount_ariary` double(30,2) DEFAULT NULL,
  `amount_paid` double(30,2) DEFAULT NULL,
  `rest` double(30,2) DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `storage_fee` text DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`id`, `amount`, `amount_ariary`, `amount_paid`, `rest`, `is_paid`, `booking_id`, `created_at`, `updated_at`, `storage_fee`) VALUES
(6, 27450.00, 115290000.00, 115290000.00, 0.00, 1, 6, '2023-08-17 03:07:08', '2023-08-17 03:15:38', '0'),
(7, 86700.00, 150000.00, 150000.00, 0.00, 1, 7, '2023-08-17 03:40:02', '2023-08-17 03:42:28', '0'),
(8, 4650.00, 20925000.00, 20925000.00, 0.00, 1, 8, '2023-08-17 04:00:38', '2023-08-21 04:05:38', '0'),
(9, 18150.00, 150000.00, 150000.00, 0.00, 1, 9, '2023-08-17 04:47:38', '2023-08-17 05:00:10', '32000'),
(10, 57450.00, 258525000.00, 258525000.00, 0.00, 1, 10, '2023-08-17 08:05:57', '2023-08-17 08:13:02', '0'),
(11, NULL, NULL, NULL, NULL, 0, 11, '2023-08-17 08:17:12', '2023-08-17 08:17:12', '0');

-- --------------------------------------------------------

--
-- Structure de la table `facture_histories`
--

CREATE TABLE `facture_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_paid` double(30,2) DEFAULT NULL,
  `paid` double(30,2) DEFAULT NULL,
  `rest` double(30,2) DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL,
  `facture_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `method_payment` varchar(255) NOT NULL,
  `reference_payment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `facture_histories`
--

INSERT INTO `facture_histories` (`id`, `to_paid`, `paid`, `rest`, `date_paiement`, `facture_id`, `created_at`, `updated_at`, `method_payment`, `reference_payment`) VALUES
(6, 115290000.00, 115290000.00, 0.00, '2023-08-17 06:15:38', 6, '2023-08-17 03:15:38', '2023-08-17 03:15:38', 'cash', 'facturation, rakoto'),
(7, 150000.00, 150000.00, 0.00, '2023-08-17 06:42:28', 7, '2023-08-17 03:42:28', '2023-08-17 03:42:28', 'cash', 'test'),
(8, 20925000.00, 20925000.00, 0.00, '2023-08-21 07:05:38', 8, '2023-08-21 04:05:38', '2023-08-21 04:05:38', 'cash', 'test storage fee'),
(9, 150000.00, 150000.00, 0.00, '2023-08-17 08:00:10', 9, '2023-08-17 05:00:10', '2023-08-17 05:00:10', 'cash', 'test'),
(10, 258525000.00, 258525000.00, 0.00, '2023-08-17 11:13:02', 10, '2023-08-17 08:13:02', '2023-08-17 08:13:02', 'cash', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `last_message_clients`
--

CREATE TABLE `last_message_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `last_message_clients`
--

INSERT INTO `last_message_clients` (`id`, `message`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 'asdfasdf', 7, '2023-08-17 07:26:15', '2023-08-17 07:26:15');

-- --------------------------------------------------------

--
-- Structure de la table `localizations`
--

CREATE TABLE `localizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `region` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `localizations`
--

INSERT INTO `localizations` (`id`, `region`, `country`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'Guangzhou', 'Chine', NULL, NULL, NULL),
(2, 'Wuhan', 'Chine', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `mada_agents`
--

CREATE TABLE `mada_agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `app_lang` varchar(255) NOT NULL DEFAULT 'fr',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mada_agents`
--

INSERT INTO `mada_agents` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `contact`, `app_lang`, `created_at`, `updated_at`) VALUES
(3, 'rakoto', '$2y$10$8nWvJmLVPGpyv3gV0w0SwuwSzDJNP560eBq0idIkFwU3TYPxQR9RK', 'Jean', 'Rakotobe', 'rkb@mail.me', '0343403434', 'fr', '2023-08-17 02:47:38', '2023-08-17 02:47:49');

-- --------------------------------------------------------

--
-- Structure de la table `manifests`
--

CREATE TABLE `manifests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) NOT NULL,
  `container_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `eta` datetime DEFAULT NULL,
  `ata` datetime DEFAULT NULL,
  `pic` datetime DEFAULT NULL,
  `freetime` int(11) DEFAULT NULL,
  `del` datetime DEFAULT NULL,
  `bmoi_rate` double(8,2) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `foc` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `manifests`
--

INSERT INTO `manifests` (`id`, `reference`, `container_id`, `agent_id`, `created_at`, `updated_at`, `status`, `eta`, `ata`, `pic`, `freetime`, `del`, `bmoi_rate`, `unit`, `foc`) VALUES
(8, 'M230001', 8, 9, '2023-08-17 03:08:21', '2023-08-17 03:15:01', 'Ready to delivered', '2023-08-17 00:00:00', '2023-08-11 00:00:00', '2023-08-23 00:00:00', 1, '2023-08-26 00:00:00', 4200.00, 'USD', '2023-08-23 00:00:00'),
(9, 'M230002', 9, 9, '2023-08-17 03:40:23', '2023-08-17 03:43:29', 'Ready to delivered', '2023-08-17 00:00:00', '2023-08-17 00:00:00', '2023-08-29 00:00:00', 1, '2023-08-17 00:00:00', 4500.00, 'USD', '2023-08-29 00:00:00'),
(10, 'M230003', 10, 9, '2023-08-17 04:00:59', '2023-08-19 04:04:26', 'Ready to delivered', '2023-08-18 00:00:00', '2023-08-18 00:00:00', '2023-08-30 00:00:00', 0, '2023-08-18 00:00:00', 4500.00, 'USD', '2023-08-30 00:00:00'),
(11, 'M230004', 11, 9, '2023-08-17 04:53:07', '2023-08-17 04:58:22', 'Ready to delivered', '2023-08-10 00:00:00', '2023-08-10 00:00:00', '2023-08-22 00:00:00', 1, '2023-08-10 00:00:00', 4500.00, 'USD', '2023-08-22 00:00:00'),
(12, 'M230005', 12, 9, '2023-08-17 04:55:24', '2023-08-17 04:58:39', 'Ready to delivered', '2023-08-02 00:00:00', '2023-08-02 00:00:00', '2023-08-14 00:00:00', 1, '2023-08-03 00:00:00', NULL, NULL, '2023-08-14 00:00:00'),
(13, 'M230006', 13, 9, '2023-08-17 08:06:26', '2023-08-17 08:11:54', 'Ready to delivered', '2023-08-11 00:00:00', '2023-08-11 00:00:00', '2023-08-23 00:00:00', 0, '2023-08-11 00:00:00', 4500.00, 'USD', '2023-08-23 00:00:00'),
(14, 'M230007', 14, 9, '2023-08-17 08:21:33', '2023-08-17 08:21:33', 'on board', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `body`, `is_read`, `client_id`, `admin_id`, `sender`, `created_at`, `updated_at`) VALUES
(1, 'asdfasdf', 0, 7, NULL, 'client', '2023-08-17 07:26:15', '2023-08-17 07:26:15');

-- --------------------------------------------------------

--
-- Structure de la table `metadata`
--

CREATE TABLE `metadata` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `metadata`
--

INSERT INTO `metadata` (`id`, `key`, `value`, `admin_id`, `created_at`, `updated_at`) VALUES
(6, '2023_last_uid', '3', NULL, '2023-08-16 10:56:19', '2023-08-17 08:04:47'),
(7, 'cbm_min', '150000', 1, NULL, '2023-08-17 02:45:00'),
(8, '2023_last_shiporder', '15', NULL, '2023-08-17 03:05:29', '2023-08-17 08:40:41'),
(9, '2023_last_booking_ref', '6', NULL, '2023-08-17 03:07:08', '2023-08-17 08:17:12'),
(10, '2023_last_manifest_ref', '7', NULL, '2023-08-17 03:08:21', '2023-08-17 08:21:33');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_07_17_160530_create_clients_table', 1),
(6, '2023_07_18_102242_create_metadata_table', 1),
(7, '2023_07_19_053606_create_admins_table', 1),
(8, '2023_07_19_173346_create_categories_table', 1),
(9, '2023_07_19_175235_create_units_table', 1),
(10, '2023_07_19_180524_create_localizations_table', 1),
(11, '2023_07_19_184235_create_agents_table', 1),
(12, '2023_07_19_190328_add_address_to_agent', 1),
(13, '2023_07_20_062750_create_bookings_table', 1),
(14, '2023_07_20_062851_create_colis_table', 1),
(15, '2023_07_20_074105_add_category_to_colis', 1),
(16, '2023_07_20_191430_create_containers_table', 1),
(17, '2023_07_20_200540_create_manifests_table', 1),
(18, '2023_07_20_200858_add_agent_to_container', 1),
(19, '2023_07_20_201301_add_manifest_to_bookings', 1),
(20, '2023_07_20_212440_add_status_to_manifests', 1),
(21, '2023_07_21_050619_add_dates_fields_to_manifest', 1),
(22, '2023_07_21_062228_create_factures_table', 1),
(23, '2023_07_21_062241_create_facture_histories_table', 1),
(24, '2023_07_23_080629_create_messages_table', 1),
(25, '2023_07_23_093500_create_last_message_clients_table', 1),
(26, '2023_08_03_104748_create_mada_agents_table', 1),
(27, '2023_08_04_054741_add_fields_to_facture_histories', 1),
(28, '2023_08_11_081729_create_notifications_table', 2),
(29, '2023_08_11_112811_add_phone_to_agents', 3),
(30, '2023_08_11_130434_add_foc_to_manifests', 4);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `original` text NOT NULL,
  `modified` text NOT NULL,
  `colis_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `units`
--

INSERT INTO `units` (`id`, `name`, `alias`, `admin_id`, `created_at`, `updated_at`) VALUES
(2, 'Dollar americain', 'USD', NULL, NULL, NULL),
(4, 'Ariary Malagasy', 'MGA', 1, '2023-08-17 02:44:30', '2023-08-17 02:44:30');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agents_localization_id_foreign` (`localization_id`);

--
-- Index pour la table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_client_id_foreign` (`client_id`),
  ADD KEY `bookings_agent_id_foreign` (`agent_id`),
  ADD KEY `bookings_manifest_id_foreign` (`manifest_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `colis`
--
ALTER TABLE `colis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `colis_client_id_foreign` (`client_id`),
  ADD KEY `colis_agent_id_foreign` (`agent_id`),
  ADD KEY `colis_booking_id_foreign` (`booking_id`),
  ADD KEY `colis_category_id_foreign` (`category_id`);

--
-- Index pour la table `containers`
--
ALTER TABLE `containers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `containers_agent_id_foreign` (`agent_id`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factures_booking_id_foreign` (`booking_id`);

--
-- Index pour la table `facture_histories`
--
ALTER TABLE `facture_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facture_histories_facture_id_foreign` (`facture_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `last_message_clients`
--
ALTER TABLE `last_message_clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `localizations`
--
ALTER TABLE `localizations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mada_agents`
--
ALTER TABLE `mada_agents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `manifests`
--
ALTER TABLE `manifests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manifests_container_id_foreign` (`container_id`),
  ADD KEY `manifests_agent_id_foreign` (`agent_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_client_id_foreign` (`client_id`),
  ADD KEY `messages_admin_id_foreign` (`admin_id`);

--
-- Index pour la table `metadata`
--
ALTER TABLE `metadata`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `colis`
--
ALTER TABLE `colis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `containers`
--
ALTER TABLE `containers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `facture_histories`
--
ALTER TABLE `facture_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `last_message_clients`
--
ALTER TABLE `last_message_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `localizations`
--
ALTER TABLE `localizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `mada_agents`
--
ALTER TABLE `mada_agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `manifests`
--
ALTER TABLE `manifests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `metadata`
--
ALTER TABLE `metadata`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_localization_id_foreign` FOREIGN KEY (`localization_id`) REFERENCES `localizations` (`id`);

--
-- Contraintes pour la table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `bookings_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `bookings_manifest_id_foreign` FOREIGN KEY (`manifest_id`) REFERENCES `manifests` (`id`);

--
-- Contraintes pour la table `colis`
--
ALTER TABLE `colis`
  ADD CONSTRAINT `colis_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `colis_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `colis_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `colis_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `containers`
--
ALTER TABLE `containers`
  ADD CONSTRAINT `containers_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`);

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Contraintes pour la table `facture_histories`
--
ALTER TABLE `facture_histories`
  ADD CONSTRAINT `facture_histories_facture_id_foreign` FOREIGN KEY (`facture_id`) REFERENCES `factures` (`id`);

--
-- Contraintes pour la table `manifests`
--
ALTER TABLE `manifests`
  ADD CONSTRAINT `manifests_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`),
  ADD CONSTRAINT `manifests_container_id_foreign` FOREIGN KEY (`container_id`) REFERENCES `containers` (`id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `messages_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
