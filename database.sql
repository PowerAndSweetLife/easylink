-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 24 août 2023 à 06:02
-- Version du serveur : 10.6.12-MariaDB-cll-lve
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u531497831_easylink`
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
(1, 'admin', '$2y$10$y/KMbJAFLpny5t4srvepDewg8V5GYNlC/XgcVi3g55TP1Jiya6jM2', 'Admin', 'Admin', 'admin@easylink.mg', '033 00 000 00', 1, 'fr', NULL, '2023-08-23 06:42:41'),
(2, 'admin', '$2y$10$uiiqR2otkyApmtyo.jphm.7jfrJJOvnCCbgp2pz40Jum66EVIse8W', 'Admin', 'Admin', 'admin@easylink.mg', '033 00 000 00', 1, 'fr', NULL, NULL);

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
(1, 'VAN', '$2y$10$YqLnN.PBxO5ddSpTyH5hCeyjutFnO1AEK84nPtWx3AcF3B6wiEMVq', 'Deangelo', 'Vandervort', 'grady.thora@kessler.com', '(509) 784-7765', 'en', 1, '2023-08-23 07:14:16', '2023-08-23 07:14:16', '{\"small\":\"220-52 \\u5f70\\u5316\\u7e23\\u6c38\\u9756\\u9109\\u9f8d\\u83ef\\u5357\\u8857\\u4e5d\\u6bb5660\\u5df7452\\u5f04102\\u865f98\\u6a13\",\"regular\":\"959-10 \\u81fa\\u4e2d\\u5e02\\u5357\\u5340\\u798f\\u93ae\\u8def\\u4e8c\\u6bb5114\\u5df7927\\u5f04729\\u865f\"}', '000-222');

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
(1, 'B230007', '2023-08-23 12:51:40', 0, 3, 1, '2023-08-23 12:50:26', '2023-08-23 12:50:26', 1),
(2, 'B230008', '2023-08-23 12:57:52', 0, 4, 1, '2023-08-23 12:57:27', '2023-08-23 12:57:27', 1);

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
(1, 'Produit Corrosif', 15000.00, 1, '2023-08-23 06:47:44', '2023-08-23 07:15:11');

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
(1, 'MG23014', 'jennyhery@proton.me', '+1 (765) 679-4616', 'company', 0.00, 'fr', NULL, NULL, NULL, 'Terry Inc', '54309464', '29929854', '16247132', NULL, '$2y$10$vrM3gMyrxaQfj7eN.eTcAelyreRCVsrh9E3MHxhLoxHN1VfuT5iHe', '42Q9HTC5', '2023-08-23 07:26:07', '2023-08-23 07:25:34', '2023-08-23 07:26:07'),
(2, 'MG23015', 'kathleen69@marks.net', '859.488.5266', 'company', 0.00, 'fr', NULL, NULL, NULL, 'Ritchie PLC', '80964629', '65569046', '43191942', NULL, '$2y$10$7UbCPUM1QaTF07pwTk21k.feO10jwLJBrbTtKp0CDZDah0xGRP8Ui', 'NKNE7M72', '2023-08-23 07:44:01', '2023-08-23 07:43:58', '2023-08-23 07:44:01'),
(3, 'MG23016', 'erik52@yahoo.com', '445-673-1178', 'company', 0.00, 'fr', NULL, NULL, NULL, 'Lakin, Kuhic and Ryan', '56487736', '21962003', '27978718', NULL, '$2y$10$3POsuJk.okP55rAPDQLPcuvN5CZFLNwskSqrFdMLfnvWqJjS7QoJS', '6K2Z75SE', '2023-08-23 12:48:50', '2023-08-23 12:48:45', '2023-08-23 12:48:50'),
(4, 'MG23017', 'lilly41@bayer.org', '+14582959149', 'company', 3.80, 'fr', NULL, NULL, NULL, 'Dach Inc', '12396164', '27491021', '29381945', NULL, '$2y$10$Xz60bxQC7pfXzEoZX4Avq.h74esfCeolBfFa9ZeXAXYEmaDdx4udS', 'WT6663N2', '2023-08-23 12:53:54', '2023-08-23 12:53:42', '2023-08-23 13:47:05');

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
(1, 'ECLNY213', 'Lebsack, Wyman and Bosco', '1', '[{\"count\":5,\"length\":79,\"width\":100,\"height\":77,\"weight\":74}]', NULL, 'Ready to delivered', 'S230016', '2023-08-23 12:49:07', '2023-08-23 12:50:26', 3, 1, 1, '2023-08-23 12:49:07', '2023-08-23 13:45:14', 1),
(2, 'QEOXA299', 'Rosenbaum-Gorczany', '1', '[{\"count\":3,\"length\":75,\"width\":93,\"height\":70,\"weight\":100}]', NULL, 'delivered', 'S230017', '2023-08-23 12:54:08', '2023-08-23 12:57:27', 4, 1, 2, '2023-08-23 12:54:08', '2023-08-23 13:47:05', 1),
(3, 'RNMZQ223', 'Krajcik-Bailey', '1', '[{\"count\":4,\"length\":78,\"width\":75,\"height\":100,\"weight\":98}]', NULL, 'delivered', 'S230018', '2023-08-23 12:54:17', '2023-08-23 12:57:25', 4, 1, 2, '2023-08-23 12:54:17', '2023-08-23 13:47:00', 1);

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
(1, 'XRAXU282', '40\'', 'Daugherty, Runte and Aufderhar', 'Nemo/Reprehenderit', 'China', 'Tamatave', '2023-08-23 00:00:00', 0, '2023-08-23 07:16:05', '2023-08-23 13:00:52', 1);

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
(1, 45600.00, 214320000.00, 214320000.00, 0.00, 1, 1, '2023-08-23 12:50:27', '2023-08-23 13:45:24', '82000'),
(2, 57000.00, 267900000.00, 31000000.00, 236900000.00, 0, 2, '2023-08-23 12:57:27', '2023-08-23 13:15:11', '102000');

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
(1, 267900000.00, 1000000.00, 266900000.00, '2023-08-23 13:14:38', 2, '2023-08-23 13:14:38', '2023-08-23 13:14:38', 'cash', 'Test paiement'),
(2, 266900000.00, 30000000.00, 236900000.00, '2023-08-23 13:15:12', 2, '2023-08-23 13:15:12', '2023-08-23 13:15:12', 'cash', 'Okey'),
(3, 214320000.00, 214320000.00, 0.00, '2023-08-23 13:45:24', 1, '2023-08-23 13:45:24', '2023-08-23 13:45:24', 'cash', 'total');

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
(1, 'Guangzhou', 'Chine', 1, '2023-08-23 06:44:52', '2023-08-23 06:44:52');

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
(1, 'RAK', '$2y$10$sSIkM7FNGEyGk7mBn7YgxOCI6Ew2bBi5vQjcdyMU.3XEkEiB.T4ua', 'Jean Marc', 'Rakotobe', 'rak@mail.me', '0343403434', 'fr', '2023-08-23 07:14:44', '2023-08-23 07:14:44');

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
(1, 'M230008', 1, 1, '2023-08-23 07:16:05', '2023-08-23 13:12:06', 'Ready to delivered', '2023-08-08 00:00:00', '2023-08-08 00:00:00', '2023-08-20 00:00:00', 5, '2023-08-13 00:00:00', 4700.00, 'USD', '2023-08-20 00:00:00');

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
(6, '2023_last_uid', '17', NULL, '2023-08-16 10:56:19', '2023-08-23 12:53:42'),
(7, 'cbm_min', '150000', 1, NULL, '2023-08-17 02:45:00'),
(8, '2023_last_shiporder', '18', NULL, '2023-08-17 03:05:29', '2023-08-23 12:54:17'),
(9, '2023_last_booking_ref', '8', NULL, '2023-08-17 03:07:08', '2023-08-23 12:57:25'),
(10, '2023_last_manifest_ref', '8', NULL, '2023-08-17 03:08:21', '2023-08-23 07:16:05');

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
(1, 'US Dollar', 'USD', 1, '2023-08-23 07:14:00', '2023-08-23 07:14:00');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `colis`
--
ALTER TABLE `colis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `containers`
--
ALTER TABLE `containers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `facture_histories`
--
ALTER TABLE `facture_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `last_message_clients`
--
ALTER TABLE `last_message_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `localizations`
--
ALTER TABLE `localizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `mada_agents`
--
ALTER TABLE `mada_agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `manifests`
--
ALTER TABLE `manifests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
