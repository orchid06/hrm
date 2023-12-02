-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 03, 2023 at 12:56 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `genlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_settings` longtext COLLATE utf8mb4_unicode_ci,
  `permissions` longtext COLLATE utf8mb4_unicode_ci,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `super_admin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `created_by`, `updated_by`, `uid`, `role_id`, `user_name`, `name`, `phone`, `email`, `notification_settings`, `permissions`, `address`, `email_verified_at`, `password`, `status`, `super_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '5Wvv-oLHaD6gL-fWW1', NULL, 'admin', 'SuperAdmin', '01616243666', 'admin@gmail.com', NULL, NULL, NULL, '2023-07-08 13:29:18', '$2y$10$puy0HdMlBWiuaVlcHDFv1e.HBvak7M.9sls/q5k/BbvsTFC/327am', '1', '1', NULL, '2023-07-08 13:29:19', '2023-08-03 09:02:55'),
(2, 1, NULL, '3wdi-VuAjExqQ-EgR5', 1, 'navowexy', 'Salvador Ortega', '+1 (878) 693-4648', 'pyrubajaxi@mailinator.com', NULL, NULL, NULL, NULL, '$2y$10$VMZvofrFgU37zXfLLilYvuVI2v/M0EcaSCIrHvgeo6E2zBSmHlote', '1', '0', NULL, '2023-07-15 09:19:36', '2023-07-15 09:19:36'),
(3, 1, 1, '4AT7-RHJcdmDH-Ttg6', 1, 'vusoves', 'Boris Schultz', '+1 (125) 659-7149', 'hujij@mailinator.com', NULL, NULL, NULL, NULL, '$2y$10$T/ahtfj1XRrsQ7nOcTqg7.Bdo/KvFJYHcYUTI48dqYkaiDayqc7Nu', '1', '0', NULL, '2023-07-15 09:26:24', '2023-07-15 09:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint UNSIGNED NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `position`, `status`, `created_at`, `updated_at`) VALUES
(1, 'article_details', '1', '2023-07-30 13:07:53', '2023-08-01 04:43:09'),
(2, 'articles', '1', '2023-07-30 13:07:53', '2023-08-01 04:43:08'),
(3, 'link_details', '1', '2023-07-30 13:07:53', '2023-08-01 04:43:06'),
(4, 'contact_top', '1', '2023-07-30 13:07:53', '2023-08-01 04:43:05'),
(5, 'contact_bottom', '1', '2023-07-30 13:07:53', '2023-08-01 04:43:04'),
(6, 'redirect_link_top', '1', '2023-07-30 13:07:53', '2023-07-30 13:07:53'),
(7, 'redirect_link_bottom', '1', '2023-07-30 13:07:53', '2023-07-31 04:57:16'),
(8, 'page_details', '1', '2023-07-31 06:28:00', '2023-08-01 04:43:10');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `view` int NOT NULL DEFAULT '0',
  `liked_by` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `likes_count` int NOT NULL DEFAULT '0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `feature` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `uid`, `created_by`, `updated_by`, `category_id`, `title`, `slug`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `view`, `liked_by`, `likes_count`, `status`, `feature`, `created_at`, `updated_at`) VALUES
(5, 'Qzcq-GfevXTyw-gZ60', 1, 1, 8, 'Earth: Our Home in the Cosmos - A Remarkable Blue Planet Teeming with Life', 'earth', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">Earth, the\r\nthird planet from the Sun and the only known celestial body to harbor life, is\r\na mesmerizing blue gem nestled in the vast expanse of the cosmos. From its\r\nstunning landscapes to its diverse ecosystems, Earth has been the cradle of\r\nhumanity and a sanctuary for countless species for millions of years. This\r\narticle delves into the wonders of our home planet, exploring its geological\r\nhistory, unique features, and the delicate balance that sustains life.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span style=\"font-size:15.0pt;line-height:107%;\r\nborder:solid #D9D9E3 1.0pt;mso-border-alt:solid #D9D9E3 .25pt;padding:0in\"><o:p>&nbsp;</o:p></span></b></p>\r\n\r\n<p class=\"MsoNormal\"><b><span style=\"font-size:15.0pt;line-height:107%;\r\nborder:solid #D9D9E3 1.0pt;mso-border-alt:solid #D9D9E3 .25pt;padding:0in\">A\r\nGeological Time Capsule:</span></b><span style=\"font-size:15.0pt;line-height:\r\n107%\"> Unravel the geological history of Earth, which spans over 4.5 billion\r\nyears, and discover how ancient processes have shaped the planet\'s surface,\r\ncontinents, and oceans.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span style=\"font-size:15.0pt;line-height:107%;\r\nborder:solid #D9D9E3 1.0pt;mso-border-alt:solid #D9D9E3 .25pt;padding:0in\">The\r\nHydrosphere:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Dive\r\ninto the mysteries of Earth\'s hydrosphere, featuring the vast oceans and their\r\ncrucial role in regulating the planet\'s climate and supporting a rich tapestry\r\nof marine life.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span style=\"font-size:15.0pt;line-height:107%;\r\nborder:solid #D9D9E3 1.0pt;mso-border-alt:solid #D9D9E3 .25pt;padding:0in\">Biodiversity\r\nand Ecosystems:</span></b><span style=\"font-size:15.0pt;line-height:107%\">\r\nExplore the incredible diversity of life on Earth, from the deepest rainforests\r\nto the coldest Polar Regions, and learn about the intricate web of interactions\r\nthat sustain ecosystems.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span style=\"font-size:15.0pt;line-height:107%;\r\nborder:solid #D9D9E3 1.0pt;mso-border-alt:solid #D9D9E3 .25pt;padding:0in\">The\r\nHuman Impact:</span></b><span style=\"font-size:15.0pt;line-height:107%\">\r\nUnderstand the impact of human activities on Earth, including climate change,\r\ndeforestation, and pollution, and the urgent need for sustainable practices to\r\nprotect our planet\'s future.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span style=\"font-size:15.0pt;line-height:107%;\r\nborder:solid #D9D9E3 1.0pt;mso-border-alt:solid #D9D9E3 .25pt;padding:0in\">Astounding\r\nNatural Phenomena:</span></b><span style=\"font-size:15.0pt;line-height:107%\">\r\nWitness extraordinary natural phenomena like the Northern Lights, volcanic\r\neruptions, and meteor showers, showcasing Earth\'s dynamic and ever-changing\r\nnature.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\"><b><span style=\"font-size:15.0pt;line-height:107%;\r\nborder:solid #D9D9E3 1.0pt;mso-border-alt:solid #D9D9E3 .25pt;padding:0in\">Space\r\nExploration and Beyond:</span></b><span style=\"font-size:15.0pt;line-height:\r\n107%\"> Discover the endeavors of humanity to explore space, including lunar\r\nmissions and the search for potential habitable exoplanets, as we seek to\r\nexpand our understanding of the universe.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>', '{\"en\":\"Earth: A Remarkable Blue Planet Teeming with Life\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Discover the wonders of Earth, our beautiful blue oasis in the vastness of the cosmos. This article explores the unique features, diverse ecosystems, and the significance of Earth as a haven for life. Join us on a journey to understand the delicate balance that sustains us and the responsibility we share in preserving this precious planet.\",\"al\":\"xc\",\"bj\":\"asdasdxxxx\",\"dz\":null,\"bh\":null}', '[\"Earth\",\"Planet\",\"Blue Planet\",\"Geology\",\"Hydrosphere\",\"Biodiversity\",\"Ecosystems\",\"Climate Change\",\"Natural Phenomena\",\"Space Exploration\",\"Sustainability\",\"Oceans\",\"Continents\",\"Life on Earth\",\"Environmental Conservation\",\"Northern Lights\",\"Volcanic Eruptions\",\"Meteor Showers\",\"Exoplanets\"]', 138, '[1]', 1, '1', '1', '2023-07-16 09:54:31', '2023-08-03 12:23:07'),
(6, '60Mc-ijjWizNC-sOMm', 1, 1, 8, 'Unreal Engine: Revolutionizing the World of Game Development', 'unreal-engine', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In the\r\never-evolving world of game development, Unreal Engine stands tall as a\r\ngame-changing technology that has reshaped the industry. Developed by Epic\r\nGames, Unreal Engine has become the go-to choice for both indie developers and\r\nAAA studios due to its unparalleled capabilities and versatility.</span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\"><o:p><br></o:p></span></p><p class=\"MsoNormal\" style=\"text-indent:.5in\"><br></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Realistic Graphics:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Unreal Engine\'s advanced rendering\r\ncapabilities and high-fidelity graphics have set new standards for realism in\r\nmodern gaming. With its powerful rendering engine and visual effects, developers\r\ncan create breathtakingly lifelike environments that draw players into a truly\r\nimmersive experience.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Blueprint Visual\r\nScripting</span></b><span style=\"font-size:15.0pt;line-height:107%\">: One of\r\nUnreal Engine\'s standout features is its intuitive visual scripting system\r\nknown as Blueprints. This innovative node-based system allows developers to\r\ncreate complex gameplay mechanics and interactions without the need for\r\nextensive coding, significantly reducing development time and facilitating\r\nrapid prototyping.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Versatile Platform</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Unreal Engine supports\r\nmulti-platform game development, enabling developers to target various\r\nplatforms such as PC, consoles, mobile devices, and virtual reality headsets.\r\nThis cross-platform support is instrumental in reaching a broad audience and\r\nmaximizing a game\'s potential success.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Robust Toolset</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Unreal Engine provides a\r\ncomprehensive set of tools that cover every aspect of game development,\r\nincluding level design, animation, physics, and AI. Its powerful editor allows\r\nfor seamless integration of assets, simplifying the workflow and allowing\r\ndevelopers to focus on unleashing their creative vision.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Active Community and\r\nMarketplace</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Unreal Engine\r\nboasts a thriving community of developers who actively contribute to its growth\r\nand provide support to newcomers. Additionally, the Unreal Marketplace offers a\r\nwealth of assets, plugins, and tools that further enhance the development\r\nprocess and empower creators with ready-made resources.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Continuous Evolution</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Epic Games continuously updates\r\nUnreal Engine with new features and optimizations, ensuring it remains at the\r\nforefront of technological advancements. This commitment to innovation allows\r\ndevelopers to stay ahead in an ever-competitive gaming industry.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><b><span style=\"font-size:15.0pt;line-height:107%\">Conclusion</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Unreal Engine has undeniably left\r\nan indelible mark on the game development landscape, revolutionizing the way\r\ngames are created and experienced. Its stunning visuals, user-friendly tools,\r\nand constant evolution make it an indispensable asset for aspiring developers\r\nand seasoned studios alike. As technology progresses, Unreal Engine continues\r\nto shape the future of gaming, promising even more astounding virtual worlds\r\nand unparalleled experiences for players worldwide.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>', '{\"en\":\"Unreal Engine: The Game-Changing Technology for Next-Gen Game Development\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Discover the power of Unreal Engine, a cutting-edge game development platform that has revolutionized the gaming industry. Explore its remarkable features, stunning graphics, and robust tools that empower developers to create immersive and realistic virtual worlds.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"Unreal Engine\",\"Game development\",\"Game engine\",\"Graphics rendering\",\"Visual scripting\",\"Blueprints\",\"Cross-platform development\",\"Level design\",\"Animation\",\"Virtual reality\",\"Unreal Marketplace\",\"Indie game development\",\"AAA game studios\",\"Realistic virtual worlds\",\"Immersive gaming experience\"]', 38, '[1,37]', 2, '1', '1', '2023-07-16 10:31:40', '2023-08-03 12:24:17'),
(7, 'LAaP-NNkwUBSL-Rjz1', 1, 1, 8, 'John Wick: Chapter 3 - Parabellum: A Thrilling Action Saga Unleashing Unprecedented Mayhem', 'voluptatem-cillum-d', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In the\r\nadrenaline-fueled world of hitman John Wick, nothing is ever straightforward.\r\nJohn Wick: Chapter 3 - Parabellum, the third installment of the iconic action\r\nfranchise, catapults audiences into an electrifying ride filled with non-stop\r\naction and gripping intrigue. Directed by Chad Stahelski, the film picks up\r\nright where the second one left off, immersing viewers into a relentless\r\npursuit for survival.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><strong style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\"><span style=\"font-size:15.0pt;line-height:107%;font-family:\"Segoe UI\",sans-serif;\r\ncolor:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;mso-border-alt:\r\nsolid #D9D9E3 .25pt;padding:0in\">The Unstoppable Action:</span></strong><span style=\"font-size:15.0pt;line-height:107%;color:black;mso-themecolor:text1\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">From its opening minutes to the heart-pounding climax, John\r\nWick 3 never allows a moment to breathe. Keanu Reeves delivers an awe-inspiring\r\nperformance as the seemingly unstoppable assassin, taking on hordes of\r\nadversaries in a spectacular display of martial arts, gunplay, and knife\r\nfights. The film showcases some of the most intricate and visceral fight\r\nchoreography ever seen on the big screen, setting a new standard for action\r\nfilmmaking.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">One of the film\'s most remarkable highlights is the stunning\r\n\"one-shot\" sequence, where John Wick battles his way through a\r\nseemingly endless succession of foes in an exhilarating and seamless shot that\r\nleaves audiences on the edge of their seats. The movie\'s action sequences are a\r\nmasterclass in kinetic storytelling, making John Wick 3 a must-see for action\r\nenthusiasts.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><strong style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\"><span style=\"font-size:15.0pt;line-height:107%;font-family:\"Segoe UI\",sans-serif;\r\ncolor:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;mso-border-alt:\r\nsolid #D9D9E3 .25pt;padding:0in\">Unraveling Intrigue:</span></strong><span style=\"font-size:15.0pt;line-height:107%;color:black;mso-themecolor:text1\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">Beyond the relentless action, John Wick: Chapter 3 -\r\nParabellum also delves into the intricate and secretive world of assassins and\r\ntheir code. The film explores the High Table, a council that governs the\r\nunderground world of hitmen, and delves deeper into John Wick\'s past and the\r\norigins of his skills. The narrative takes unexpected turns, as alliances are\r\nformed, loyalties are tested, and dangerous new adversaries emerge, leaving audiences\r\nenthralled by the story\'s twists and turns.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">The enigmatic Continental Hotel, a sanctuary for assassins,\r\nplays a pivotal role in the film\'s plot. The establishment\'s strict rules and\r\ncode of conduct add layers of intrigue, as characters navigate through a\r\ntreacherous landscape of double-crosses and betrayals.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><strong style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\"><span style=\"font-size:15.0pt;line-height:107%;font-family:\"Segoe UI\",sans-serif;\r\ncolor:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;mso-border-alt:\r\nsolid #D9D9E3 .25pt;padding:0in\">Raising the Bar for the Action Genre:</span></strong><span style=\"font-size:15.0pt;line-height:107%;color:black;mso-themecolor:text1\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">John Wick: Chapter 3 - Parabellum is more than just a popcorn\r\naction flick; it elevates the entire genre to new heights. With its intense\r\naction set-pieces and engaging storytelling, the film strikes a perfect balance\r\nbetween adrenaline and emotion. Keanu Reeves\' portrayal of John Wick has become\r\niconic, and he continues to embody the character\'s stoicism and vulnerability\r\nwith perfection.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">Moreover, the film\'s success lies not only in its action and\r\nsuspense but also in its commitment to world-building. The intricate web of\r\nassassin lore, hidden societies, and moral codes adds depth to the story,\r\nmaking the audience yearn for more.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><strong style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\"><span style=\"font-size:15.0pt;line-height:107%;font-family:\"Segoe UI\",sans-serif;\r\ncolor:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;mso-border-alt:\r\nsolid #D9D9E3 .25pt;padding:0in\">Conclusion:</span></strong><span style=\"font-size:15.0pt;line-height:107%;color:black;mso-themecolor:text1\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">In conclusion, John Wick: Chapter 3 - Parabellum is a\r\ncinematic triumph that raises the bar for action films. It boasts stunning\r\nchoreography, relentless action sequences, and an engaging plot that keeps\r\nviewers glued to the screen. Keanu Reeves shines once again as the legendary\r\nhitman, showcasing why the character of John Wick has become a modern-day\r\ncinematic icon. So, lock and load as you immerse yourself in the heart-stopping\r\nworld of John Wick 3 - an unmissable cinematic experience that leaves you\r\ncraving for more.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>', '{\"en\":\"John Wick 3: Parabellum - An Action-Packed Thrill Ride of Unstoppable Retribution\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Join John Wick on an adrenaline-pumping journey in \'Parabellum,\' the third installment of the action-packed franchise. Brace yourself for heart-pounding combat, breathtaking stunts, and a relentless pursuit of survival in this high-octane saga.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"John Wick\",\"Chapter 3\",\"Parabellum\",\"Keanu Reeves\",\"action film\",\"hitman\",\"assassin\",\"one-shot sequence\",\"fight choreography\",\"martial arts\",\"gunplay\",\"intrigue\",\"High Table\",\"Continental Hotel\",\"alliances\",\"loyalty\",\"double-cross\",\"world-building\",\"cinematic triumph\"]', 61, NULL, 0, '1', '1', '2023-07-16 10:31:53', '2023-08-03 12:23:14'),
(8, 'toTf-6Do32b3n-x7S0', 1, 1, 8, 'Unveiling the Cosmos: The Marvels of James Webb Space Telescope', 'james-webb-telescope', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In the vast\r\nexpanse of the cosmos, humanity\'s insatiable curiosity about the universe finds\r\na powerful ally in the James Webb Space Telescope (JWST). A joint venture by\r\nNASA, the European Space Agency (ESA), and the Canadian Space Agency (CSA), the\r\nJWST is poised to be a game-changer in space exploration. Let\'s embark on a\r\nthrilling journey as we delve into the marvels of the James Webb Space\r\nTelescope and its monumental mission to unveil the cosmos.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Quest for Clarity</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Scheduled to succeed the iconic\r\nHubble Space Telescope, the JWST is designed to provide unparalleled clarity in\r\ncapturing celestial wonders. Equipped with state-of-the-art instruments and a\r\nmassive primary mirror, it promises to revolutionize our understanding of\r\ndistant galaxies, stars, and planetary systems.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Precision Engineering</span></b><span style=\"font-size:15.0pt;line-height:107%\">: The construction of the James Webb\r\nSpace Telescope is an engineering marvel. Spanning the size of a tennis court\r\nwhen fully deployed, its segmented mirror enables precise observations through\r\na process called \"segmented space optics,\" ensuring accurate data\r\ncollection from deep space.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Unfolding the Universe</span></b><span style=\"font-size:15.0pt;line-height:107%\">: The JWST\'s journey to the cosmos\r\ninvolves a complex unfolding process. Its delicate components will unfurl in\r\nspace like an intricate origami, preparing the telescope for its mission of\r\ncosmic revelation. This precise deployment is critical to its performance and\r\nsuccess.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Infrared Insights</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Unlike its predecessor, the JWST\r\noperates in the infrared range, enabling astronomers to peer through cosmic\r\ndust and observe celestial phenomena that would otherwise remain hidden. This\r\ncapability allows for groundbreaking discoveries, including insights into star\r\nformation and the formation of galaxies.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Time Travel with Light:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> As light travels vast distances\r\nthrough space, it also journeys back in time. The JWST\'s powerful instruments\r\ncan detect ancient light that originated billions of years ago, providing a\r\nglimpse into the early stages of the universe, offering a time-traveling\r\nexperience through light.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">A Global Endeavor</span></b><span style=\"font-size:15.0pt;line-height:107%\">: The JWST is a testament to\r\ninternational collaboration in space exploration. Bringing together the\r\nexpertise and resources of NASA, ESA, and CSA, this unprecedented partnership\r\nsymbolizes the united pursuit of scientific discovery and human exploration\r\nbeyond our home planet.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Quest for Life Beyond\r\nEarth</span></b><span style=\"font-size:15.0pt;line-height:107%\">: The JWST\'s\r\ncapabilities extend to the study of exoplanets - planets outside our solar\r\nsystem. By analyzing the atmospheres of these distant worlds, scientists hope\r\nto find evidence of habitability or even signs of life beyond Earth, igniting\r\nthe quest for extraterrestrial existence.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">New Avenues of Discovery</span></b><span style=\"font-size:15.0pt;line-height:107%\">: The James Webb Space Telescope\r\npromises a cascade of new discoveries, from unraveling the mysteries of black\r\nholes to investigating the formation of stars and planets. Its potential\r\ncontributions to astronomy are boundless, providing a window into the\r\nuniverse\'s most enigmatic phenomena.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In\r\nconclusion, the James Webb Space Telescope stands as an emblem of human\r\ningenuity and exploration. With its cutting-edge technology and advanced\r\ninstruments, this celestial marvel promises to redefine our understanding of\r\nthe cosmos. From the birth of galaxies to the search for life beyond Earth, the\r\nJWST embarks on an unprecedented quest, inspiring generations to come in their\r\npursuit of knowledge about the enigmatic universe that surrounds us.<o:p></o:p></span></p><p class=\"MsoNormal\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\"> </span></p>', '{\"en\":\"James Webb Space Telescope: Peering into the Cosmos with Unprecedented Precision\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Embark on an astronomical odyssey with the James Webb Space Telescope, a marvel of modern space exploration. Discover its cutting-edge technology, superlative instruments, and ambitious mission to revolutionize our understanding of the universe.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"James Webb Space Telescope\",\"space exploration\",\"astronomy\",\"celestial observation\",\"infrared imaging\",\"cosmic revelation\",\"segmented space optics\",\"engineering marvel\",\"astronomical discoveries\",\"Hubble Space Telescope successor\",\"international collaboration\",\"time-traveling light\",\"exoplanet study\",\"quest for life beyond Earth\",\"cosmic phenomena\",\"human exploration\",\"celestial wonders\"]', 32, '[37]', 13, '1', '1', '2023-07-16 11:42:18', '2023-08-03 12:38:38');
INSERT INTO `articles` (`id`, `uid`, `created_by`, `updated_by`, `category_id`, `title`, `slug`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `view`, `liked_by`, `likes_count`, `status`, `feature`, `created_at`, `updated_at`) VALUES
(9, '4LtG-6T1uGORp-7vA6', 1, 1, 8, 'The Evolution of the Automobile Industry: How Tesla is Shaping the Future', 'et-repudiandae-disti', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">The\r\nautomobile industry has been a cornerstone of modern society, shaping the way\r\nwe live and travel for over a century. However, in recent years, a paradigm\r\nshift has been underway, led by the pioneering efforts of Tesla, a\r\nrevolutionary electric vehicle manufacturer. In this article, we delve into the\r\nevolution of the automobile industry, with a spotlight on how Tesla is\r\npropelling the transformation towards sustainable and innovative mobility\r\nsolutions.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">A Legacy of Automobile\r\nAdvancements:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The\r\nautomobile industry\'s rich history is marked by continual advancements, from\r\nthe introduction of mass production by Ford to the integration of sophisticated\r\ntechnologies. However, Tesla stands out as a true game-changer, sparking a\r\nrevolution in the way we perceive and interact with vehicles.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Electrifying the\r\nFuture:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Tesla\'s\r\nunwavering commitment to electric mobility has been a driving force behind the\r\ntransformation of the automotive landscape. By pioneering long-range electric\r\nvehicles with exceptional performance, Tesla has shattered preconceptions about\r\nelectric cars, making them attractive alternatives to traditional internal\r\ncombustion engines.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Sustainable Vision:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Tesla\'s vision extends beyond\r\nproducing electric vehicles. The company is committed to sustainability\r\nthroughout its operations, from renewable energy solutions in its factories to\r\nrecycling initiatives for battery components. Tesla\'s holistic approach to\r\nsustainability has set new standards for environmental responsibility within\r\nthe industry.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Autonomy and Smart\r\nTechnology:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Tesla\'s\r\nintroduction of advanced driver-assistance features and Autopilot capabilities\r\nhas accelerated the push towards autonomous driving. As one of the leading\r\nplayers in autonomous vehicle development, Tesla\'s focus on smart technology is\r\nreshaping the concept of transportation, emphasizing safety, efficiency, and\r\nconvenience.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Disrupting the\r\nTraditional Model</span></b><span style=\"font-size:15.0pt;line-height:107%\">:\r\nTesla\'s direct-to-consumer sales model and online ordering system have disrupted\r\nthe traditional dealership model. By bypassing conventional distribution\r\nchannels, Tesla has challenged the status quo and embraced a customer-centric\r\napproach, allowing for a more streamlined and personalized buying experience.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Charging Infrastructure</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Recognizing the importance of\r\ncharging infrastructure for the widespread adoption of electric vehicles, Tesla\r\nhas invested heavily in its Supercharger network. This extensive and rapidly\r\nexpanding charging infrastructure provides Tesla owners with convenient access\r\nto fast charging, alleviating range anxiety and promoting EV adoption.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Inspiring Innovation</span></b><span style=\"font-size:15.0pt;line-height:107%\">: Beyond its own products, Tesla\'s\r\ninnovations have sparked a ripple effect across the industry, inspiring other\r\nautomakers to invest in electric vehicles and sustainable practices. Tesla\'s\r\npresence has accelerated the transition towards cleaner and smarter mobility\r\nsolutions industry-wide.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Shaping the Future:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> As the automobile industry continues\r\nto evolve, Tesla remains at the forefront, pushing the boundaries of what is\r\npossible with innovative design, technology, and a commitment to\r\nsustainability. Tesla\'s impact goes beyond its success as a company; it serves\r\nas a catalyst for a more sustainable and greener automotive future.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\"> </span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In\r\nconclusion, the automobile industry is witnessing a transformative era, driven\r\nby Tesla\'s relentless pursuit of innovation and sustainability. From electric\r\nvehicles to autonomous technology and sustainable practices, Tesla is\r\nrevolutionizing transportation and reshaping the industry\'s future. With its\r\nvisionary approach and groundbreaking achievements, Tesla inspires the world to\r\nembrace cleaner and smarter mobility solutions, leading the way towards a\r\ngreener and more sustainable tomorrow.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\"> </span></p>', '{\"en\":\"Tesla: Revolutionizing the Automobile Industry with Innovation and Sustainability\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Explore the transformative impact of Tesla on the automobile industry, revolutionizing transportation with its groundbreaking electric vehicles, sustainable practices, and visionary approach. Discover how Tesla is driving the shift towards cleaner and smarter mobility solutions for a greener and more sustainable future.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"Tesla\",\"automobile industry\",\"electric vehicles\",\"sustainable practices\",\"innovation\",\"visionary approach\",\"autonomous driving\",\"smart technology\",\"charging infrastructure\",\"direct-to-consumer sales\",\"customer-centric approach\",\"environmental responsibility\",\"greener future\",\"electric mobility\",\"automotive revolution\",\"transportation transformation\"]', 39, '[]', 0, '1', '1', '2023-07-16 11:42:24', '2023-08-01 05:23:31'),
(10, 'YQBa-VRcTTynw-LgS6', 1, 1, 8, 'Bonsai Tree: A Timeless Art of Miniature Beauty and Tranquility', 'bonsai-tree', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In the\r\ndelicate world of horticulture, few art forms capture the essence of nature\'s\r\nbeauty and tranquility quite like the bonsai tree. The art of cultivating\r\nbonsai, originating in ancient China and refined in Japan, has enthralled\r\nenthusiasts for centuries. In this article, we embark on a journey to explore\r\nthe captivating world of bonsai trees, unraveling the secrets of this living\r\nart form and its profound connection with nature.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">A Glimpse of Bonsai\'s\r\nOrigins:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The origins\r\nof bonsai trace back to the sophisticated gardens of ancient China. Over time,\r\nthis art form made its way to Japan, where it was further refined and embraced\r\nas a contemplative practice, symbolizing harmony between man and nature.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Cultivation and\r\nPatience:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Bonsai\r\ncultivation requires unwavering patience and careful attention. By training\r\nyoung trees into miniature forms, bonsai artists skillfully shape their growth,\r\ncreating living masterpieces that mimic the grandeur of their full-sized\r\ncounterparts.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Nature in Miniature:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Bonsai trees are a harmonious blend\r\nof art and science. The delicate balance between aesthetics and horticultural\r\npractices is evident in each meticulously pruned branch and tenderly shaped\r\nroot, giving life to miniature forests that exude timeless beauty.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Styles and Techniques: </span></b><span style=\"font-size:15.0pt;line-height:107%\">Bonsai artists employ various styles\r\nand techniques to achieve distinct representations of nature\'s grandeur. From\r\nthe elegant cascading style to the dramatic windswept design, each bonsai tree\r\nreflects a unique narrative and a glimpse into the artist\'s vision.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">A Journey of\r\nContemplation: </span></b><span style=\"font-size:15.0pt;line-height:107%\">The\r\nart of bonsai extends beyond mere aesthetics. For many practitioners,\r\ncultivating and caring for bonsai trees is a meditative journey, fostering a\r\ndeep appreciation for nature\'s intricacies and teaching the virtues of patience\r\nand mindfulness.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Connection with Nature:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Bonsai embodies a profound\r\nconnection with nature. In each delicately pruned leaf and gracefully contoured\r\ntrunk, there lies an intimate understanding of the life cycle, seasons, and the\r\nephemerality of existence.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Living Legacy:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Bonsai trees are not merely\r\ndecorative artifacts; they are living, breathing legacies of history and\r\nculture. Passed down through generations, each bonsai carries the wisdom of its\r\ncaretakers and serves as a testament to the enduring allure of this ancient art\r\nform.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Embracing Tranquility:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> As we immerse ourselves in the world\r\nof bonsai trees, we embrace the tranquility that emanates from these miniature\r\nwonders. The art of bonsai not only invites us to pause and reflect on the\r\nbeauty of the natural world but also beckons us to find solace in the\r\nsimplicity of life.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In\r\nconclusion, the bonsai tree stands as a living testament to the timeless art of\r\ncultivating beauty and tranquility in miniature form. As we explore the\r\nintricate world of bonsai, we are reminded of the delicate interplay between\r\nman and nature, and the profound harmony that can be achieved through patient\r\ncultivation and contemplation. Bonsai trees continue to enchant and inspire,\r\nweaving a captivating tale of nature\'s enduring allure and our enduring\r\nconnection with the world around us.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>', '{\"en\":\"Bonsai Tree: Unraveling the Art of Miniature Beauty and Tranquility\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Discover the enchanting world of bonsai trees, an ancient art form that embodies miniature beauty and tranquility. Explore the highlights of bonsai cultivation, the art of shaping nature\'s essence into living masterpieces, and the profound connection between man and nature.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"bonsai tree\",\"bonsai cultivation\",\"miniature beauty\",\"art of bonsai\",\"horticulture\",\"Japanese art\",\"Chinese origins\",\"bonsai styles\",\"bonsai techniques\",\"harmony with nature\",\"patience and mindfulness\",\"living masterpieces\",\"nature\'s grandeur\",\"contemplation\",\"connection with nature\",\"ancient art form\",\"bonsai artists\",\"meditative journey\",\"bonsai legacy\",\"enduring allure\",\"bonsai aesthetics\"]', 22, NULL, 0, '1', '1', '2023-07-16 11:42:29', '2023-07-31 13:17:58'),
(11, '38jS-7FYPVJKK-TBDO', 1, 1, 8, 'The Manhattan Project: Oppenheimer and the Trinity Test - A Pioneering Journey into Nuclear Science', 'the-manhattan-project', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In the\r\nannals of scientific history, few endeavors rival the audacity and significance\r\nof the Manhattan Project. Spearheaded by physicist J. Robert Oppenheimer, this\r\nclandestine research and development initiative aimed to unlock the secrets of\r\nnuclear science during World War II. At the heart of this transformative\r\nproject stood the legendary Trinity Test - a monumental event that heralded the\r\nbirth of the nuclear age.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Manhattan Project\'s\r\nGenesis:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Born from\r\nthe crucible of wartime urgency and the looming specter of global conflict, the\r\nManhattan Project began in 1939. The United States, recognizing the potential\r\npower of nuclear fission, embarked on a mission to harness this scientific\r\nmarvel.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">J. Robert Oppenheimer:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The Enigmatic Mastermind: At the\r\nhelm of the Manhattan Project stood J. Robert Oppenheimer, a brilliant\r\nphysicist with a multifaceted persona. Leading a diverse team of scientists,\r\nengineers, and specialists, Oppenheimer tirelessly pursued the development of\r\nthe first atomic bomb.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Trinity Test:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> A Moment of Revelation: On July 16,\r\n1945, the world held its breath as the Trinity Test was conducted in the\r\ndesolate Jornada del Muerto desert near Alamogordo, New Mexico. The successful\r\ndetonation of the first atomic bomb was a profound revelation - marking the\r\ndawn of a new age, where the forces of nuclear energy would forever change the\r\ncourse of history.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Impact on World War II\r\nand Beyond:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The\r\nsuccess of the Trinity Test prompted the use of atomic bombs in combat during\r\nWorld War II. The bombings of Hiroshima and Nagasaki in August 1945 led to\r\nJapan\'s surrender, but also raised complex moral and ethical questions about\r\nthe use of nuclear weapons.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Nuclear Technology\'s\r\nDual Nature:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The\r\nManhattan Project\'s success provided mankind with unparalleled access to\r\nnuclear energy. It offered the promise of clean and abundant power generation,\r\nwhile simultaneously creating fearsome weapons of mass destruction, shaping\r\nglobal politics and diplomacy for decades to come.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Legacy and Ethical\r\nReflections:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The\r\nManhattan Project\'s legacy is deeply intertwined with the broader themes of\r\nscientific progress, national security, and the responsibility of humanity to\r\nharness powerful technologies responsibly. The ethical debates surrounding\r\nnuclear weapons persist to this day.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Advancements in Nuclear\r\nScience:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Post-World\r\nWar II, nuclear science continued to advance, with peaceful applications in\r\nnuclear energy, medical treatments, and space exploration. However, the specter\r\nof nuclear proliferation and disarmament remained critical global concerns.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In\r\nconclusion, the Manhattan Project and the Trinity Test stand as watershed\r\nmoments in human history. The collaborative efforts of brilliant minds and the\r\nastonishing discoveries in nuclear science paved the way for both the marvels\r\nand perils of nuclear technology. As we reflect on this pivotal chapter in\r\nscientific exploration, we are reminded of the need for responsible stewardship\r\nof powerful technologies, ensuring that they serve humanity\'s betterment and a\r\npeaceful future.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>', '{\"en\":\"The Manhattan Project: Oppenheimer, Trinity Test, and the Nuclear Revolution\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Delve into the groundbreaking Manhattan Project, led by J. Robert Oppenheimer, as it embarked on a journey into the world of nuclear science. Uncover the highlights of the Trinity Test, a pivotal moment that forever altered the course of history, shaping the era of nuclear technology.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"Manhattan Project\",\"Oppenheimer\",\"Trinity Test\",\"nuclear science\",\"J. Robert Oppenheimer\",\"nuclear technology\",\"World War II\",\"atomic bomb\",\"nuclear energy\",\"nuclear weapons\",\"scientific progress\",\"ethical reflections\",\"nuclear proliferation\",\"peaceful applications\",\"national security\",\"global politics\",\"nuclear disarmament\"]', 64, NULL, 0, '1', '1', '2023-07-16 11:42:35', '2023-07-31 08:28:29'),
(12, 'npNI-8CJUnF9T-RDy8', 1, 1, 8, 'Space Exploration: Mars and Beyond with SpaceX Leading the Way', 'space-exploration', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">The vast\r\nexpanse of space has always captivated the human imagination, beckoning us to\r\nventure beyond our planet\'s boundaries and explore the cosmos. In the modern\r\nera of space exploration, one name stands out as a pioneer in pushing the\r\nboundaries of what\'s possible - SpaceX. Join us on an exhilarating journey as\r\nwe delve into the forefront of space exploration, with a special focus on Mars\r\nand the pioneering efforts of SpaceX.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Martian Frontier:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Mars, the red planet, has long been\r\nthe focus of fascination for astronomers, scientists, and dreamers alike. Its\r\npotential as a second home for humanity, with its similarities to Earth and\r\nabundant resources, has fueled our curiosity and exploration endeavors.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">SpaceX\'s Vision:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Founded by visionary entrepreneur Elon\r\nMusk, SpaceX (Space Exploration Technologies Corp.) has emerged as a\r\ngame-changer in space exploration. Driven by the ambitious goal of making life\r\nmultiplanetary, SpaceX envisions the colonization of Mars as a stepping stone\r\ntowards interplanetary exploration.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Mars Missions:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> SpaceX has set its sights on Mars\r\nwith an array of missions planned to get us there. Notably, the Starship\r\nspacecraft, a fully reusable vehicle, is being developed to transport humans\r\nand cargo to the red planet. With iterative prototypes and groundbreaking\r\ntechnology, SpaceX is inching closer to making interplanetary travel a reality.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Reusability Revolution:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> One of SpaceX\'s most significant\r\nachievements is its reusability revolution. By successfully landing and reusing\r\nthe first stages of its Falcon 9 rockets, SpaceX has drastically reduced the\r\ncost of space travel, making it more accessible for future missions, including\r\nthose to Mars.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Advancing Space\r\nTechnology:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Beyond\r\nMars, SpaceX has its sights set on even grander missions, such as exploring the\r\nouter planets and establishing a human presence on the Moon. Their\r\ntechnological advancements, such as the Starship spacecraft and the Super Heavy\r\nrocket booster, are critical steps towards these ambitious endeavors.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:16.0pt;mso-bidi-font-size:15.0pt;line-height:\r\n107%\">Beyond Mars: <o:p></o:p></span></b></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Exploring the Cosmos:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> While Mars is a focal point, space\r\nexploration extends far beyond our neighboring planet. With advancements in\r\ntelescopes and spacecraft, we continue to explore distant exoplanets, black\r\nholes, and the vast expanses of our universe, seeking answers to some of the\r\nmost profound questions about our existence.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Inspiring a Generation:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> SpaceX\'s endeavors have ignited a\r\nrenewed interest in space exploration among the younger generation. By\r\ncombining innovation, entrepreneurship, and a bold vision for the future,\r\nSpaceX inspires a new wave of aspiring scientists, engineers, and explorers to\r\ndream big and reach for the stars.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In\r\nconclusion, space exploration continues to be an enthralling journey, with Mars\r\nserving as a pivotal destination and SpaceX leading the charge. With its\r\nambitious vision and technological advancements, SpaceX brings us closer to the\r\ndream of making humanity a multiplanetary species. As we journey beyond Mars\r\nand explore the cosmos, we are reminded of our collective fascination with the\r\nstars and our innate desire to uncover the mysteries of the universe.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>', '{\"en\":\"Space Exploration: Journey to Mars and Beyond with SpaceX\'s Visionary Leadership\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Embark on an awe-inspiring journey through space exploration, delving into the ambition of reaching Mars and beyond. Discover SpaceX\'s groundbreaking efforts as they lead humanity towards interplanetary travel and the promise of a multi-planetary future.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"space exploration\",\"Mars exploration\",\"SpaceX\",\"interplanetary travel\",\"colonization of Mars\",\"space missions\",\"Starship spacecraft\",\"Falcon 9 rockets\",\"reusability revolution\",\"space technology\",\"cosmic exploration\",\"interstellar travel\",\"Mars colonization vision\",\"space pioneers\",\"inspiring innovation\"]', 96, '[1]', 1, '1', '1', '2023-07-16 11:42:40', '2023-08-03 11:14:11'),
(13, 'TEY6-FB5amxen-7dP2', 1, 1, 8, 'GPT-4 and Beyond: Paving the Path to the Future of AI', 'odit-in-pariatur-ci', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In the\r\never-evolving landscape of artificial intelligence (AI), GPT-4 stands as a\r\ntestament to the remarkable progress made in the field. Developed by OpenAI,\r\nGPT-4 (Generative Pre-trained Transformer 4) represents the next leap forward\r\nin language models, with unprecedented capabilities that transcend its\r\npredecessors. As we embark on a journey into the future of AI, let us explore\r\nthe highlights of GPT-4 and the transformative implications it holds for various\r\nindustries.<o:p></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Power of GPT-4:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> GPT-4 is a prodigious AI language\r\nmodel, surpassing its predecessors in both scale and performance. With billions\r\nof parameters and enhanced training techniques, GPT-4 exhibits unparalleled\r\nnatural language understanding and generation abilities. Its capabilities\r\nextend to generating human-like text, answering complex questions, and even\r\noffering creative narratives.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Intelligent Automation:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> GPT-4\'s advanced language\r\ncomprehension has accelerated the development of intelligent automation across\r\nindustries. From customer service to content creation, GPT-4\'s ability to\r\nanalyze and generate contextually relevant responses streamlines processes,\r\nleading to enhanced efficiency and productivity.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Navigating Complex\r\nData: </span></b><span style=\"font-size:15.0pt;line-height:107%\">In the realm\r\nof big data, GPT-4 becomes an invaluable tool for extracting insights and\r\npatterns from vast datasets. By understanding context and contextually\r\nconnecting information, GPT-4 aids researchers, analysts, and businesses in\r\nmaking data-driven decisions with unprecedented precision.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Human-Machine\r\nCollaboration:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> As\r\nGPT-4 demonstrates exceptional language comprehension, it paves the way for\r\nenhanced human-machine collaboration. The model can assist in drafting reports,\r\nsummarizing lengthy documents, and offering context-based recommendations, empowering\r\nhumans to focus on higher-level tasks.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Ethical Considerations:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The rapid advancement of AI,\r\nincluding GPT-4, brings forth critical ethical considerations. Ensuring\r\ntransparency, avoiding bias, and safeguarding data privacy become paramount in\r\nharnessing the full potential of AI for the greater good. Striking a balance\r\nbetween technological progress and responsible deployment remains a pivotal\r\nchallenge.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">NLP Revolution:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> GPT-4 signifies a major milestone in\r\nNatural Language Processing (NLP), with profound implications for machine\r\ntranslation, sentiment analysis, and information retrieval. By refining\r\nlanguage generation and understanding, GPT-4 redefines how humans interact with\r\nAI-driven systems.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">AI in Education:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The integration of GPT-4 into educational\r\nsettings introduces transformative possibilities. AI-powered tutoring,\r\npersonalized learning paths, and intelligent assessment tools pave the way for\r\na more inclusive and adaptive education system.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Future of GPT:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> As AI research advances, the potential\r\nfor future iterations of GPT, such as GPT-5 and beyond, holds the promise of\r\neven more sophisticated AI capabilities. The journey towards Artificial General\r\nIntelligence (AGI) becomes increasingly tangible.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;\r\nline-height:107%\">&nbsp;</span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In\r\nconclusion, GPT-4 represents a significant milestone in the realm of AI\r\nlanguage models, paving the path towards intelligent automation and\r\nunprecedented language understanding. As we embrace the possibilities that\r\nGPT-4 and future iterations offer, it is imperative to navigate the ethical challenges\r\nand ensure responsible AI deployment. The future of AI, with GPT-4 as a beacon\r\nof progress, holds immense potential to revolutionize industries, augment human\r\npotential, and shape a more intelligent and connected world.<o:p></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>', '{\"en\":\"GPT-4 and the Future of AI: A Leap Towards Intelligent Automation\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Explore the revolutionary advancements of GPT-4, the latest in AI language models, and its profound impact on diverse industries. Delve into the possibilities of intelligent automation, natural language understanding, and the ethical considerations that shape the future of AI.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"GPT-4\",\"AI language model\",\"intelligent automation\",\"natural language understanding\",\"future of AI\",\"machine learning\",\"big data insights\",\"human-machine collaboration\",\"ethical AI\",\"NLP revolution\",\"AI in education\",\"responsible AI deployment\",\"AGI\",\"transformative technology\",\"artificial intelligence\"]', 26, '[1]', 1, '1', '1', '2023-07-16 16:01:50', '2023-07-31 13:18:22'),
(14, '1VJZ-GFc8vZbw-dZsR', 1, 1, 8, 'Unraveling the Mysteries of Quantum Physics: A Journey into the Quantum Realm', 'unraveling-the-mysteries-of-quantum-physics', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">The realm of\r\nquantum physics is a captivating and enigmatic domain that challenges our\r\nperception of reality. In this article, we embark on a journey into the quantum\r\nrealm, uncovering the intriguing principles that govern particles at the\r\nsmallest scales and revolutionize our understanding of the universe.</span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\"><o:p><br></o:p></span></p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\"><o:p><br></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Dual Nature of\r\nParticles:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> One of\r\nthe most astounding aspects of quantum physics is the dual nature of particles,\r\nbest exemplified by the famous double-slit experiment. Particles, such as\r\nelectrons and photons, can display both particle-like and wave-like behaviors\r\nsimultaneously. This phenomenon challenges classical physics and reveals the\r\nextraordinary nature of the quantum world.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Superposition and\r\nEntanglement:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Quantum\r\nsuperposition allows particles to exist in multiple states simultaneously until\r\nobserved, unlike classical objects that have definite states. Entanglement, on\r\nthe other hand, connects particles in a way that their properties become\r\nlinked, regardless of distance. These phenomena have profound implications for\r\nquantum computing and quantum communication.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Uncertainty Principle:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The Heisenberg Uncertainty Principle\r\nstates that it is impossible to simultaneously know both the position and\r\nmomentum of a particle with absolute precision. This fundamental principle\r\nintroduces inherent uncertainty into the behavior of particles, shaping the\r\nprobabilistic nature of quantum mechanics.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Quantum Mechanics and\r\nTechnology:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Quantum\r\nmechanics has led to the development of revolutionary technologies. Quantum\r\ncomputing promises exponential computational power, potentially solving complex\r\nproblems that are beyond classical computers. Quantum cryptography ensures\r\nsecure communication by utilizing the principles of quantum entanglement.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Quantum Tunneling:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Quantum tunneling allows particles\r\nto penetrate energy barriers that classical physics would deem insurmountable.\r\nThis phenomenon is vital in understanding nuclear fusion, semiconductor\r\ndevices, and even the process of how stars shine.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Applications in Modern\r\nScience: </span></b><span style=\"font-size:15.0pt;line-height:107%\">Quantum\r\nphysics has found practical applications in various fields. Magnetic resonance\r\nimaging (MRI) in medicine, quantum sensors in navigation, and quantum optics in\r\ncommunication are just a few examples where quantum principles have made a\r\nsignificant impact.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">Schrödinger\'s Cat\r\nParadox:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The famous\r\nthought experiment proposed by Erwin Schrödinger involves a cat in a\r\nhypothetical state of being both alive and dead simultaneously. This paradox\r\nhighlights the bizarre and counterintuitive nature of quantum mechanics,\r\nsparking debates about the interpretation of quantum theory.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><b><span style=\"font-size:15.0pt;line-height:107%\">The Quest for Quantum\r\nGravity:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Quantum\r\nmechanics and general relativity are two pillars of modern physics, but they\r\nremain incompatible at certain scales. The search for a unified theory of\r\nquantum gravity is one of the most significant challenges in theoretical\r\nphysics today.</span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;line-height:107%\"><o:p><br></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.5in\"><span style=\"font-size:15.0pt;line-height:107%\"><o:p><br></o:p></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In\r\nconclusion, the world of quantum physics is a captivating realm where particles\r\ndefy classical intuition and follow extraordinary laws. From the dual nature of\r\nparticles to the mind-bending concepts of superposition and entanglement,\r\nquantum mechanics continues to expand our understanding of the universe. Its\r\npractical applications and potential technological breakthroughs promise to\r\nreshape the future of science<o:p></o:p></span></p>', '{\"en\":\"Journey into the Quantum Realm: Unraveling the Mysteries of Quantum Physics\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Explore the fascinating world of quantum physics, where particles behave in mysterious ways, and the laws of classical physics break down. Delve into the highlights of quantum mechanics and its implications for our understanding of the universe.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"Quantum\",\"Physics\",\"Quantum Physics\",\"particles\",\"Superposition\",\"Uncertainty Principle\",\"Quantum Mechanics\",\"Quantum Tunneling\",\"Applications\",\"Schr\\u00f6dinger\'s Cat Paradox\"]', 91, '[]', 60, '1', '1', '2023-07-16 16:02:23', '2023-08-03 09:56:20');
INSERT INTO `articles` (`id`, `uid`, `created_by`, `updated_by`, `category_id`, `title`, `slug`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `view`, `liked_by`, `likes_count`, `status`, `feature`, `created_at`, `updated_at`) VALUES
(15, 'qsTU-OsmNtgCP-72a0', 1, 1, 8, 'Technology Transformations: A Journey into the World of Advancements', 'technology-transformations', '<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">In today\'s\r\nfast-paced world, technology is the driving force behind transformative changes\r\nacross various industries. From the convenience of our daily lives to the\r\nadvancements in business processes, technology plays a pivotal role. In this\r\narticle, we embark on a thrilling journey through the world of technology\r\ntransformations, delving into the key highlights that are shaping the future.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoListParagraphCxSpFirst\" style=\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><b><span style=\"font-size:15.0pt;line-height:107%\">Artificial Intelligence\r\n(AI):</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Artificial\r\nIntelligence has emerged as a game-changer, revolutionizing industries from\r\nhealthcare to finance. With machine learning algorithms and data analysis\r\ncapabilities, AI enables automation, predictive insights, and personalization.\r\nFrom chatbots assisting customer service to autonomous vehicles, the applications\r\nof AI are boundless, fostering efficiency and convenience.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoListParagraphCxSpLast\"><span style=\"font-size:15.0pt;line-height:\r\n107%\">&nbsp;</span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><b><span style=\"font-size:15.0pt;line-height:107%\">Internet of Things\r\n(IoT): </span></b><span style=\"font-size:15.0pt;line-height:107%\">The Internet\r\nof Things connects devices and gadgets to the internet, creating a vast network\r\nof interconnected smart devices. Home automation, smart cities, and industrial\r\napplications are some examples of IoT\'s impact. The ability to monitor and\r\ncontrol devices remotely enhances efficiency and optimizes resource management.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><b><span style=\"font-size:15.0pt;line-height:107%\">Blockchain Technology:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Blockchain technology has disrupted\r\ntraditional systems by providing decentralized and secure transactions.\r\nOriginally known for its association with cryptocurrencies, blockchain\'s\r\npotential reaches beyond finance. Supply chain management, voting systems, and\r\nintellectual property protection are areas where blockchain brings transparency\r\nand immutability.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><b><span style=\"font-size:15.0pt;line-height:107%\">5G Connectivity:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> The advent of 5G connectivity\r\npromises lightning-fast internet speeds and low latency. This technology\r\nenables seamless communication between devices, empowering emerging\r\ntechnologies like augmented reality (AR) and virtual reality (VR). The\r\nproliferation of 5G will revolutionize how we experience digital content and\r\ninteract with each other.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><b><span style=\"font-size:15.0pt;line-height:107%\">Biotechnology\r\nAdvancements:</span></b><span style=\"font-size:15.0pt;line-height:107%\">\r\nBiotechnology is transforming healthcare and agriculture with breakthroughs in\r\ngenomics, gene editing, and bioinformatics. Personalized medicine, disease\r\nprevention, and sustainable farming practices are some of the remarkable\r\noutcomes. Biotechnology has the potential to revolutionize human health and the\r\nglobal food supply chain.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><b><span style=\"font-size:15.0pt;line-height:107%\">Renewable Energy\r\nSolutions:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> As the\r\nworld embraces sustainable practices, technology plays a critical role in\r\nharnessing renewable energy sources. Solar panels, wind turbines, and energy\r\nstorage solutions are leading the way to a greener future. Integration of renewable\r\nenergy into power grids promotes environmental stewardship and energy\r\nindependence.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><b><span style=\"font-size:15.0pt;line-height:107%\">Quantum Computing:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> Quantum computing is poised to solve\r\ncomplex problems that traditional computers cannot. Its immense processing\r\npower holds the potential to revolutionize industries such as drug discovery,\r\ncryptography, and optimization. Quantum supremacy represents a significant leap\r\nin computing capabilities.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><b><span style=\"font-size:15.0pt;line-height:107%\">Cybersecurity\r\nInnovations:</span></b><span style=\"font-size:15.0pt;line-height:107%\"> With\r\nincreased reliance on technology, cybersecurity has become a top priority.\r\nInnovations in cybersecurity technologies such as advanced encryption,\r\nbehavioral analysis, and threat intelligence are crucial in safeguarding\r\nsensitive data and digital infrastructure.</span></p><p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><span style=\"font-size:15.0pt;line-height:107%\"><o:p><br></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left: 0.5in; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><span style=\"font-size:15.0pt;line-height:107%\"><o:p><br></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"white-space-collapse: preserve; --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ;\"><span style=\"font-size:15.0pt;line-height:107%\">In conclusion, technology transformations are reshaping our world in profound ways. From the realms of AI and IoT to blockchain and quantum computing, advancements are paving the way for a futuristic society. Embracing these technological highlights can unlock a plethora of opportunities for businesses and individuals alike. As we journey the future, embracing technology with responsible stewardship will ensure a world of endless possibilities and progress.<o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size:15.0pt;line-height:107%\">&nbsp;</span></p>', '{\"en\":\"Embracing the Future: A Dive into the World of Technology Transformations\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Explore the dynamic realm of technology transformations, where innovations shape the way we live, work, and interact. From artificial intelligence to blockchain, discover the highlights of cutting-edge technologies driving progress and reshaping our world.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"Technology\",\"Artificial Intelligence\",\"AI\",\"Internet\",\"IoT\",\"Blockchain\",\"5G Connectivity\",\"Biotechnology\",\"Renewable Energy\",\"Quantum Computing\",\"Cybersecurity\"]', 96, '[1]', 826, '1', '0', '2023-07-22 13:42:50', '2023-08-03 12:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `article_comments`
--

CREATE TABLE `article_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint DEFAULT NULL,
  `article_id` bigint UNSIGNED DEFAULT NULL,
  `comments` longtext COLLATE utf8mb4_unicode_ci,
  `liked_by` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `likes_count` int NOT NULL DEFAULT '0',
  `approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_comments`
--

INSERT INTO `article_comments` (`id`, `uid`, `user_id`, `admin_id`, `article_id`, `comments`, `liked_by`, `likes_count`, `approved`, `created_at`, `updated_at`) VALUES
(1, '0tTc-xFI6Jb7e-pyw2', 1, NULL, 5, 'approved comments1', '[]', 0, '1', '2023-07-22 11:27:20', '2023-08-03 04:56:01'),
(2, 'vyOi-NmbtFfdj-Kzh3', 1, NULL, 5, 'approved comments2', '[]', 0, '1', '2023-07-22 11:27:28', '2023-08-03 04:56:03'),
(8, '2SP7-hcZJPffh-oMtd', NULL, 1, 5, 'sad', '[]', 50, '1', '2023-07-23 06:32:36', '2023-08-03 04:56:04'),
(9, '0ref-wK4Vdedc-h5lw', 1, NULL, 5, 'asdsad', '[]', 0, '0', '2023-07-23 07:49:18', '2023-07-27 05:40:32'),
(10, 'bn11-tEvID2Xi-sBR8', 1, NULL, 5, 'asds', '[1]', 1, '0', '2023-07-23 07:51:04', '2023-07-27 05:35:34'),
(11, 'iOV3-Pbmn41Gj-OeL5', 37, NULL, 8, 'zxSA', '[37]', 1, '1', '2023-08-03 12:38:51', '2023-08-03 12:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `feature` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `top` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `show_in_banner` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `uid`, `created_by`, `updated_by`, `parent_id`, `title`, `slug`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `feature`, `top`, `show_in_banner`, `created_at`, `updated_at`) VALUES
(8, '3g8m-u8Fs9gCE-yVXX', 1, 1, NULL, '{\"en\":\"Arts\",\"al\":null}', '{\"en\":\"arts\",\"al\":\"\"}', '{\"en\":\"test childer\",\"al\":null}', '{\"en\":\"test childer\",\"al\":null,\"bj\":null}', '[\"test childer\",\"scaf\"]', '1', '1', '1', '1', '2023-07-16 09:01:57', '2023-08-02 11:50:55'),
(10, 'o9p0-5r5uR5rG-rx19', 1, 1, NULL, '{\"en\":\"Buisness\",\"al\":null}', '{\"en\":\"business\",\"al\":\"\"}', '{\"en\":\"Sint aliqua Sit qu\",\"al\":null}', '{\"en\":\"Itaque aut suscipit\",\"al\":null,\"bj\":null}', NULL, '1', '1', '1', '0', '2023-07-16 09:09:38', '2023-08-02 11:55:05'),
(11, '5rJB-EU8hduAU-bBz2', 1, 1, 8, '{\"en\":\"Media\",\"al\":null}', '{\"en\":\"media\",\"al\":\"\"}', '{\"en\":\"Quis commodi quae et\",\"al\":null}', '{\"en\":\"Dolore velit atque v\",\"al\":null,\"bj\":null}', NULL, '1', '1', '1', '1', '2023-07-16 09:09:45', '2023-08-02 11:58:02'),
(12, 'b9p2-DyF0KuCJ-vDA5', 1, 1, 8, '{\"en\":\"Movie\",\"al\":null}', '{\"en\":\"movie\",\"al\":\"\"}', '{\"en\":\"Ut sed quis qui est\",\"al\":null}', '{\"en\":\"Facilis cupidatat de\",\"al\":null,\"bj\":null}', NULL, '1', '1', '1', '0', '2023-07-16 09:09:49', '2023-08-02 11:58:55'),
(16, '215c-K6jthTxC-AuMj', 1, 1, 8, '{\"en\":\"Jokes\",\"al\":null}', '{\"en\":\"zxxxxxx\",\"al\":\"\"}', '{\"en\":null,\"al\":null}', '{\"en\":null,\"al\":null,\"bj\":null}', NULL, '1', '1', '1', '0', '2023-07-16 10:16:22', '2023-08-02 12:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` smallint NOT NULL DEFAULT '0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `uid`, `created_by`, `updated_by`, `name`, `address`, `review`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(4, '599P-XPYRioNw-byqL', 1, 1, 'Magee Morton', 'Cumque animi ut off', 'Magni magnam vero in', 2, '1', '2023-07-16 11:21:49', '2023-07-18 12:07:04'),
(5, 'SFLI-tBfeIY7H-Ltl4', 1, 1, 'Sydnee Estesdddxxxx', 'Facere ex est assumxxx', 'Fugit dolor ut consxxx', 5, '1', '2023-07-16 11:22:52', '2023-07-16 11:27:58'),
(6, '0Z9X-9ZTxm40u-TXNt', 1, NULL, 'Dante Parks', 'Ratione similique al', 'Id iste rerum ut mol', 5, '1', '2023-07-16 11:28:19', '2023-07-16 11:28:19'),
(7, '7kAz-GmUgiSOY-rUIV', 1, NULL, 'Owen Brooks', 'Beatae in proident', 'Numquam vitae nemo v', 3, '1', '2023-07-18 12:07:11', '2023-07-18 12:07:11'),
(8, 'HAOc-tWmTz45s-RfD5', NULL, NULL, 'Nafiz Khan', 'qe333', 'sadasd', 2, '1', '2023-07-23 10:23:40', '2023-07-23 10:23:40'),
(10, '3t5k-un2r9wuP-NTf4', NULL, NULL, 'Max', 'sadasd', 'asdsa', 1, '0', '2023-07-23 10:26:09', '2023-07-23 10:26:09'),
(11, '82f1-DqNeykun-RWuX', NULL, NULL, 'Nafiz Khanxx', 'sdsa', 'sds', 3, '0', '2023-07-23 10:26:55', '2023-07-23 10:26:55'),
(12, 'A36S-l66BFIWJ-uU01', NULL, 1, 'Nafiz Khassn', 'sadsad', 'sas', 4, '0', '2023-07-23 10:27:08', '2023-07-23 10:32:28'),
(13, '75V0-veSbAWYz-1lwG', 1, 1, 'Kenyon Houston', 'Unde elit ea quia d', 'Ab error aut et qui', 5, '1', '2023-08-02 12:56:54', '2023-08-02 12:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `uid`, `name`, `email`, `address`, `message`, `created_at`, `updated_at`) VALUES
(2, '71tE-WKV5gTAC-iSv2', 'Maisie Saunders', 'figapyg@mailinator.com', 'Dolorum nulla pariat', 'Recusandae Et et vo', '2023-07-23 08:50:12', '2023-07-23 08:50:12'),
(3, '4SzU-LHvQ8GDd-WIQl', 'Aphrodite Rodriquez', 'xamizuzuci@mailinator.com', 'Aut fuga Elit null', 'Cupidatat error quod', '2023-07-23 08:50:18', '2023-07-23 08:50:18');

-- --------------------------------------------------------

--
-- Table structure for table `ctas`
--

CREATE TABLE `ctas` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ctas`
--

INSERT INTO `ctas` (`id`, `uid`, `created_by`, `updated_by`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, '3hgK-2xOs5p4r-lyd1', 1, 1, 'Aut voluptates eaquexxx', 'Quaerat eum sed quixxx', '1', '2023-07-16 12:11:17', '2023-07-16 12:14:07'),
(3, 'cGMn-KGKy5ZOw-WCF3', 1, 1, 'Sit nostrum facilis', 'Aliqua Est pariatu', '1', '2023-07-16 12:11:26', '2023-07-16 16:37:18'),
(5, '2GmN-bCqvKQxW-6ash', 1, NULL, 'Test', 'TestTestTest', '1', '2023-08-02 12:53:51', '2023-08-02 12:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `icon` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `uid`, `created_by`, `updated_by`, `icon`, `question`, `answer`, `status`, `created_at`, `updated_at`) VALUES
(2, '007j-gkgicJ2P-r0Ii', 1, 1, 'bi bi-align-top', 'Is there a cost associated with submitting my website?', 'We offer both free and premium listing options. Free listings include basic information, while premium listings may offer additional features and enhanced visibility for a fee.', '1', '2023-07-16 13:04:47', '2023-08-02 12:28:03'),
(3, '6r0Q-q5NUmAEx-F2XC', 1, NULL, 'bi bi-arrow-90deg-left', 'How can I submit my website to the directory?', 'To submit your website, go to the \"Submit a Link\" or \"Add Your Site\" section on our website. Provide the URL, title, description, and choose the most appropriate category for your website.', '1', '2023-07-16 13:06:20', '2023-08-02 12:27:43'),
(4, 'RE8N-B29a4NL4-1s89', 1, NULL, 'bi bi-align-middle', 'What is a link directory website?', 'A link directory website is a platform that compiles and categorizes links to various websites, resources, and services on the internet, making it easier for users to find relevant information.', '1', '2023-07-26 07:44:18', '2023-08-02 12:27:22'),
(5, 'Wmv8-2SENyFMI-UsO6', 1, NULL, 'bi bi-arrow-down-square', 'How long does the review process take for submitted links?', 'Our team reviews each submission to ensure it meets our guidelines. The review process typically takes 1-2 business days. You will receive a notification once your link is approved or if further action is required.', '1', '2023-08-02 12:29:04', '2023-08-02 12:29:04'),
(6, '5E2Y-pLr2mLem-ftGb', 1, NULL, 'bi bi-arrow-left-circle-fill', 'Can I suggest a new category for the directory?', 'es, we welcome suggestions for new categories. Please use the \"Contact Us\" form to suggest a new category, and we\'ll consider adding it if it fits our directory\'s scope.', '1', '2023-08-02 12:29:25', '2023-08-02 12:29:25'),
(7, '3jbi-7PhX9gox-Gyea', 1, NULL, 'bi bi-bag-dash', 'How can I improve my website\'s visibility in the directory?', 'To enhance your website\'s visibility, consider opting for a premium listing, providing a detailed description, and choosing the most relevant category. Regular updates to your website\'s content can also improve its visibility.', '1', '2023-08-02 12:29:51', '2023-08-02 12:29:51');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` bigint UNSIGNED NOT NULL,
  `link_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `link_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2023-07-27 05:01:30', '2023-07-27 05:01:30'),
(2, 5, 1, '2023-07-27 05:01:34', '2023-07-27 05:01:34'),
(3, 8, 1, '2023-07-27 05:02:39', '2023-07-27 05:02:39'),
(4, 6, 1, '2023-07-27 05:04:00', '2023-07-27 05:04:00'),
(5, 2, 1, '2023-07-27 12:15:46', '2023-07-27 12:15:46'),
(8, 2, 37, '2023-08-03 12:15:05', '2023-08-03 12:15:05'),
(9, 3, 37, '2023-08-03 12:28:03', '2023-08-03 12:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Active : 1,Inactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `uid`, `updated_by`, `name`, `slug`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Banner section', 'banner_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Find Nearby\"},\"motion_heading\":{\"type\":\"text\",\"value\":\"Travel & Tourism\"},\"short_description\":{\"type\":\"textarea\",\"value\":\"The best way to find yourself in the service of others\"},\"banner_image\":{\"type\":\"file\",\"size\":\"1900x750\",\"value\":\"64ca40ea4a1971690976490.jpg\"}}}', '1', NULL, '2023-08-03 11:56:03'),
(2, NULL, 1, 'Explore section', 'explore_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Explore By Categories\"},\"sub_heading\":{\"type\":\"text\",\"value\":\"Discover best things to do restaurants, shopping, hotels, cafes and places around the world by categories.\"}}}', '1', NULL, '2023-08-03 11:59:07'),
(3, NULL, 1, 'Latest link section', 'latest_link_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Latest Links\"},\"sub_heading\":{\"type\":\"text\",\"value\":\"Browse the Populars Link.\"},\"btn_name\":{\"type\":\"text\",\"value\":\"View More\"}}}', '1', NULL, '2023-08-03 11:59:17'),
(4, NULL, NULL, 'Popular link section', 'popular_link_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Popular Links\"},\"sub_heading\":{\"type\":\"text\",\"value\":\"Browse the Populars Link.\"},\"btn_name\":{\"type\":\"text\",\"value\":\"View More\"}}}', '1', NULL, '2023-07-17 08:31:10'),
(5, NULL, NULL, 'Cta section', 'cta_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"How It Works\"},\"sub_heading\":{\"type\":\"text\",\"value\":\"Let\'s know about the process.\"}}}', '1', NULL, '2023-07-17 08:31:38'),
(6, NULL, NULL, 'Faq section', 'faq_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Do You Have Questions?\"},\"sub_heading\":{\"type\":\"text\",\"value\":\"Explore the popular listings around the world.\"}}}', '1', NULL, '2023-07-17 08:31:56'),
(7, NULL, NULL, 'Client section', 'client_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Happy Clients\"},\"sub_heading\":{\"type\":\"text\",\"value\":\"We collect reviews from our users so you can get an honest opinion of what an experience with our website are really like!\"},\"banner_image\":{\"type\":\"file\",\"size\":\"1900x750\",\"value\":\"64b68766a86741689683814.jpg\"}}}', '1', NULL, '2023-07-18 12:36:58'),
(8, NULL, NULL, 'Counter section', 'counter_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Millions of People\"},\"sub_heading\":{\"type\":\"text\",\"value\":\"Millions of People We collect reviews from our users so you can get an honest opinion of what an experience with our website are really like\"}}}', '1', NULL, '2023-07-17 08:33:20'),
(9, NULL, 1, 'Article section', 'article_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Popular Articles\"},\"sub_heading\":{\"type\":\"text\",\"value\":\"Popular articles are here for you to read.\"},\"btn_name\":{\"type\":\"text\",\"value\":\"View More\"}}}', '1', NULL, '2023-08-01 06:37:35'),
(10, NULL, NULL, 'Footer section', 'footer_section', '{\"static_element\":{\"short_description\":{\"type\":\"textarea\",\"value\":\"Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatem iusto repudiandae ab natus minima error dicta ullam nemo dolorem tempore?\"}}}', '1', NULL, '2023-07-17 08:34:07'),
(12, NULL, NULL, 'Social section', 'social_section', '{\"static_element\":{\"facebook\":{\"icon\":\"<i class=\\\"fa-brands fa-facebook\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"},\"google\":{\"icon\":\"<i class=\\\"fa-brands fa-facebook\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"},\"linked_in\":{\"icon\":\"<i class=\\\"fa-brands fa-facebook\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"},\"twitter\":{\"icon\":\"<i class=\\\"fa-brands fa-facebook\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"},\"instagram\":{\"icon\":\"<i class=\\\"fa-brands fa-facebook\\\"><\\/i>\",\"url\":\"#\",\"type\":\"text\"}}}', '1', NULL, '2023-07-17 17:12:04'),
(14, NULL, NULL, 'Newsletter section', 'newsletter_section', '{\"static_element\":{\"heading\":{\"type\":\"text\",\"value\":\"Demo\"},\"short_description\":{\"type\":\"textarea\",\"value\":\"Demo\"}}}', '1', NULL, '2023-07-17 14:01:57'),
(15, NULL, 1, 'Breadcrumb section', 'breadcrumb_section', '{\"static_element\":{\"banner_image\":{\"type\":\"file\",\"size\":\"800x200\",\"value\":\"64b91800e301a1689851904.jpg\"}}}', '1', NULL, '2023-07-20 11:45:37'),
(16, NULL, 1, 'Authentication section', 'authentication_section', '{\"static_element\":{\"banner_image\":{\"type\":\"file\",\"size\":\"600x400\",\"value\":\"64bd12af47cd91690112687.png\"}}}', '1', NULL, '2023-07-23 11:44:47'),
(19, NULL, 1, 'Pre loader', 'pre_loader', '{\"static_element\":{\"image\":{\"type\":\"file\",\"size\":\"150x150\",\"value\":\"64c64deb17e1b1690717675.gif\"}}}', '1', NULL, '2023-07-30 11:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint UNSIGNED NOT NULL,
  `imageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `disk` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `imageable_type`, `imageable_id`, `name`, `disk`, `type`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\Core\\Setting', 5, '64a969063b8621688824070.png', 'local', NULL, '2023-07-08 13:47:50', '2023-07-08 13:47:50'),
(4, 'App\\Models\\Admin\\Admin', 1, '64a9691dda6731688824093.png', 'local', NULL, '2023-07-08 13:48:14', '2023-07-08 13:48:14'),
(10, 'App\\Models\\Admin', 3, '64b266c9aaa8e1689413321.png', 'local', NULL, '2023-07-15 09:28:42', '2023-07-15 09:28:42'),
(13, 'App\\Models\\Admin\\Category', 5, '64b3abb94a9f91689496505.png', 'local', NULL, '2023-07-16 08:35:05', '2023-07-16 08:35:05'),
(14, 'App\\Models\\Admin\\Category', 3, '64b3adbca8cab1689497020.png', 'local', NULL, '2023-07-16 08:43:40', '2023-07-16 08:43:40'),
(17, 'App\\Models\\Client', 4, '64b3d2cd89abb1689506509.png', 'local', NULL, '2023-07-16 11:21:49', '2023-07-16 11:21:49'),
(18, 'App\\Models\\Client', 5, '64b3d448aa8771689506888.png', 'local', NULL, '2023-07-16 11:28:08', '2023-07-16 11:28:08'),
(23, 'App\\Models\\Admin\\Frontend', 7, '64b68766a86741689683814.jpg', 'local', NULL, '2023-07-18 12:36:58', '2023-07-18 12:36:58'),
(25, 'App\\Models\\Admin\\Frontend', 15, '64b91800e301a1689851904.jpg', 'local', NULL, '2023-07-20 11:18:25', '2023-07-20 11:18:25'),
(28, 'App\\Models\\Client', 12, '64bd007cc89b31690108028.jpg', 'local', NULL, '2023-07-23 10:27:08', '2023-07-23 10:27:08'),
(29, 'App\\Models\\Admin\\Frontend', 16, '64bd12af47cd91690112687.png', 'local', NULL, '2023-07-23 11:44:47', '2023-07-23 11:44:47'),
(37, 'App\\Models\\User', 1, '64c21012624bd1690439698.png', 'local', NULL, '2023-07-27 06:34:58', '2023-07-27 06:34:58'),
(38, 'App\\Models\\Admin\\PaymentMethod', 1, '64c22671413c61690445425.png', 'local', NULL, '2023-07-27 08:10:25', '2023-07-27 08:10:25'),
(39, 'App\\Models\\Admin\\PaymentMethod', 2, '64c226c5363071690445509.png', 'local', NULL, '2023-07-27 08:11:49', '2023-07-27 08:11:49'),
(40, 'App\\Models\\Admin\\PaymentMethod', 3, '64c2272b86b8f1690445611.jpg', 'local', NULL, '2023-07-27 08:13:31', '2023-07-27 08:13:31'),
(41, 'App\\Models\\Admin\\PaymentMethod', 4, '64c227691ecdb1690445673.jpg', 'local', NULL, '2023-07-27 08:14:33', '2023-07-27 08:14:33'),
(42, 'App\\Models\\Admin\\PaymentMethod', 5, '64c22801cba471690445825.jpg', 'local', NULL, '2023-07-27 08:17:05', '2023-07-27 08:17:05'),
(43, 'App\\Models\\Admin\\PaymentMethod', 6, '64c22844c56bb1690445892.jpg', 'local', NULL, '2023-07-27 08:18:13', '2023-07-27 08:18:13'),
(44, 'App\\Models\\Admin\\PaymentMethod', 7, '64c22bcfd721f1690446799.jpg', 'local', NULL, '2023-07-27 08:33:20', '2023-07-27 08:33:20'),
(45, 'App\\Models\\Admin\\PaymentMethod', 8, '64c22bf13f3b21690446833.jpg', 'local', NULL, '2023-07-27 08:33:53', '2023-07-27 08:33:53'),
(46, 'App\\Models\\Admin\\PaymentMethod', 9, '64c22c21e26f91690446881.jpg', 'local', NULL, '2023-07-27 08:34:41', '2023-07-27 08:34:41'),
(47, 'App\\Models\\Admin\\PaymentMethod', 10, '64c22cdec95bf1690447070.jpg', 'local', NULL, '2023-07-27 08:37:50', '2023-07-27 08:37:50'),
(48, 'App\\Models\\Admin\\PaymentMethod', 11, '64c22d2ce8b491690447148.jpg', 'local', NULL, '2023-07-27 08:39:08', '2023-07-27 08:39:08'),
(49, 'App\\Models\\Admin\\PaymentMethod', 12, '64c22d5b5b0b41690447195.jpg', 'local', NULL, '2023-07-27 08:39:55', '2023-07-27 08:39:55'),
(50, 'App\\Models\\PaymentLog', 6, '64c25ac431bae1690458820.jpg', 'local', NULL, '2023-07-27 11:53:40', '2023-07-27 11:53:40'),
(56, 'App\\Models\\PaymentLog', 15, '64c4ffdbc22b81690632155.jpg', 'local', NULL, '2023-07-29 12:02:35', '2023-07-29 12:02:35'),
(57, 'App\\Models\\PaymentLog', 16, '64c5008ecb0ba1690632334.jpg', 'local', NULL, '2023-07-29 12:05:34', '2023-07-29 12:05:34'),
(58, 'App\\Models\\PaymentLog', 16, '64c5008ed06261690632334.jpg', 'local', NULL, '2023-07-29 12:05:34', '2023-07-29 12:05:34'),
(59, 'App\\Models\\PaymentLog', 17, '64c5021c4e6eb1690632732.jpg', 'local', 'local', '2023-07-29 12:12:12', '2023-07-29 12:12:12'),
(60, 'App\\Models\\PaymentLog', 17, '64c5021c51a4e1690632732.jpg', 'local', 'local', '2023-07-29 12:12:12', '2023-07-29 12:12:12'),
(61, 'App\\Models\\PaymentLog', 18, '64c502d694f9c1690632918.jpg', 'local', 'image', '2023-07-29 12:15:18', '2023-07-29 12:15:18'),
(62, 'App\\Models\\PaymentLog', 18, '64c502d69aa391690632918.jpg', 'local', 'nidimage', '2023-07-29 12:15:18', '2023-07-29 12:15:18'),
(63, 'App\\Models\\PaymentLog', 19, '64c5037fbaf981690633087.jpg', 'local', 'image', '2023-07-29 12:18:07', '2023-07-29 12:18:07'),
(64, 'App\\Models\\PaymentLog', 19, '64c5037fbe6131690633087.jpg', 'local', 'nidimage', '2023-07-29 12:18:07', '2023-07-29 12:18:07'),
(65, 'App\\Models\\PaymentLog', 20, '64c503fe119f91690633214.png', 'local', 'image', '2023-07-29 12:20:15', '2023-07-29 12:20:15'),
(66, 'App\\Models\\PaymentLog', 20, '64c503ff4e6fc1690633215.jpg', 'local', 'nidimage', '2023-07-29 12:20:15', '2023-07-29 12:20:15'),
(67, 'App\\Models\\PaymentLog', 21, '64c5043fd45331690633279.jpg', 'local', 'image', '2023-07-29 12:21:19', '2023-07-29 12:21:19'),
(68, 'App\\Models\\PaymentLog', 21, '64c5043fd95571690633279.jpg', 'local', 'nidimage', '2023-07-29 12:21:19', '2023-07-29 12:21:19'),
(69, 'App\\Models\\PaymentLog', 22, '64c5055d4f9ac1690633565.jpg', 'local', 'image', '2023-07-29 12:26:05', '2023-07-29 12:26:05'),
(70, 'App\\Models\\PaymentLog', 22, '64c5055d534ab1690633565.jpg', 'local', 'nidimage', '2023-07-29 12:26:05', '2023-07-29 12:26:05'),
(71, 'App\\Models\\PaymentLog', 22, '64c5057c454161690633596.jpg', 'local', 'image', '2023-07-29 12:26:36', '2023-07-29 12:26:36'),
(72, 'App\\Models\\PaymentLog', 22, '64c5057c47b6b1690633596.jpg', 'local', 'nidimage', '2023-07-29 12:26:36', '2023-07-29 12:26:36'),
(73, 'App\\Models\\PaymentLog', 23, '64c505b847b881690633656.png', 'local', 'image', '2023-07-29 12:27:36', '2023-07-29 12:27:36'),
(74, 'App\\Models\\PaymentLog', 23, '64c505b84e0851690633656.jpg', 'local', 'nidimage', '2023-07-29 12:27:36', '2023-07-29 12:27:36'),
(76, 'App\\Models\\Admin\\Frontend', 19, '64c64deb17e1b1690717675.gif', 'local', NULL, '2023-07-30 11:47:56', '2023-07-30 11:47:56'),
(78, 'App\\Models\\Admin\\PaymentMethod', 25, '64c73ce3810e01690778851.png', 'local', NULL, '2023-07-31 04:47:32', '2023-07-31 04:47:32'),
(79, 'App\\Models\\Admin\\PaymentMethod', 23, '64c73e893a30f1690779273.png', 'local', NULL, '2023-07-31 04:54:33', '2023-07-31 04:54:33'),
(80, 'App\\Models\\Admin\\PaymentMethod', 22, '64c7400a2c2f21690779658.png', 'local', NULL, '2023-07-31 05:00:58', '2023-07-31 05:00:58'),
(81, 'App\\Models\\Admin\\PaymentMethod', 26, '64c740d52213b1690779861.png', 'local', NULL, '2023-07-31 05:04:21', '2023-07-31 05:04:21'),
(82, 'App\\Models\\Admin\\PaymentMethod', 21, '64c7428fdb6701690780303.jpg', 'local', NULL, '2023-07-31 05:11:44', '2023-07-31 05:11:44'),
(84, 'App\\Models\\Ad', 1, '64c7446d596a61690780781.png', 'local', NULL, '2023-07-31 05:19:42', '2023-07-31 05:19:42'),
(85, 'App\\Models\\Ad', 2, '64c744b20fcbc1690780850.png', 'local', NULL, '2023-07-31 05:20:50', '2023-07-31 05:20:50'),
(86, 'App\\Models\\Ad', 3, '64c744bf7b8fe1690780863.png', 'local', NULL, '2023-07-31 05:21:03', '2023-07-31 05:21:03'),
(89, 'App\\Models\\Ad', 6, '64c744efb52911690780911.png', 'local', NULL, '2023-07-31 05:21:51', '2023-07-31 05:21:51'),
(90, 'App\\Models\\Ad', 7, '64c744fdb21351690780925.png', 'local', NULL, '2023-07-31 05:22:05', '2023-07-31 05:22:05'),
(106, 'App\\Models\\Article', 15, '64c749bb03b341690782139.png', 'local', NULL, '2023-07-31 05:42:19', '2023-07-31 05:42:19'),
(107, 'App\\Models\\Article', 14, '64c75069774ed1690783849.png', 'local', NULL, '2023-07-31 06:10:49', '2023-07-31 06:10:49'),
(108, 'App\\Models\\Link', 14, '64c752499dff11690784329.png', 'local', 'thumbs', '2023-07-31 06:18:50', '2023-07-31 06:18:50'),
(111, 'App\\Models\\Link', 13, '64c755de083491690785246.png', 'local', 'thumbs', '2023-07-31 06:34:06', '2023-07-31 06:34:06'),
(117, 'App\\Models\\Link', 8, '64c75ac6a175b1690786502.png', 'local', 'thumbs', '2023-07-31 06:55:03', '2023-07-31 06:55:03'),
(121, 'App\\Models\\Article', 13, '64c75da35f7ff1690787235.png', 'local', NULL, '2023-07-31 07:07:15', '2023-07-31 07:07:15'),
(122, 'App\\Models\\Link', 7, '64c7606e6ce3f1690787950.png', 'local', 'thumbs', '2023-07-31 07:19:15', '2023-07-31 07:19:15'),
(123, 'App\\Models\\Article', 12, '64c765dc6a36f1690789340.png', 'local', NULL, '2023-07-31 07:42:20', '2023-07-31 07:42:20'),
(124, 'App\\Models\\Link', 15, '64c766d4378f81690789588.png', 'local', 'thumbs', '2023-07-31 07:46:28', '2023-07-31 07:46:28'),
(125, 'App\\Models\\Article', 11, '64c770a0ed1cc1690792096.png', 'local', NULL, '2023-07-31 08:28:17', '2023-07-31 08:28:17'),
(126, 'App\\Models\\Link', 6, '64c772f7ad6431690792695.jpg', 'local', 'thumbs', '2023-07-31 08:38:21', '2023-07-31 08:38:21'),
(127, 'App\\Models\\Link', 5, '64c776046aca71690793476.jpg', 'local', 'thumbs', '2023-07-31 08:51:16', '2023-07-31 08:51:16'),
(128, 'App\\Models\\Link', 3, '64c778203b88a1690794016.png', 'local', 'thumbs', '2023-07-31 09:00:16', '2023-07-31 09:00:16'),
(129, 'App\\Models\\Link', 2, '64c77a8f018351690794639.png', 'local', 'thumbs', '2023-07-31 09:10:39', '2023-07-31 09:10:39'),
(138, 'App\\Models\\Link', 15, '64c77c07455731690795015.jpg', 'local', 'gallary', '2023-07-31 09:16:55', '2023-07-31 09:16:55'),
(139, 'App\\Models\\Link', 15, '64c77c074ea801690795015.png', 'local', 'gallary', '2023-07-31 09:16:55', '2023-07-31 09:16:55'),
(140, 'App\\Models\\Link', 15, '64c77c07564d01690795015.png', 'local', 'gallary', '2023-07-31 09:16:55', '2023-07-31 09:16:55'),
(141, 'App\\Models\\Link', 15, '64c77c075ffe81690795015.png', 'local', 'gallary', '2023-07-31 09:16:55', '2023-07-31 09:16:55'),
(142, 'App\\Models\\Link', 14, '64c77cbf2bb311690795199.jpg', 'local', 'gallary', '2023-07-31 09:19:59', '2023-07-31 09:19:59'),
(143, 'App\\Models\\Link', 14, '64c77cbf3224e1690795199.png', 'local', 'gallary', '2023-07-31 09:19:59', '2023-07-31 09:19:59'),
(144, 'App\\Models\\Link', 14, '64c77cbf383841690795199.jpg', 'local', 'gallary', '2023-07-31 09:19:59', '2023-07-31 09:19:59'),
(145, 'App\\Models\\Link', 14, '64c77cbf3d23e1690795199.jpg', 'local', 'gallary', '2023-07-31 09:19:59', '2023-07-31 09:19:59'),
(146, 'App\\Models\\Link', 13, '64c77d563bd451690795350.png', 'local', 'gallary', '2023-07-31 09:22:30', '2023-07-31 09:22:30'),
(147, 'App\\Models\\Link', 13, '64c77d5642eaf1690795350.jpg', 'local', 'gallary', '2023-07-31 09:22:30', '2023-07-31 09:22:30'),
(148, 'App\\Models\\Link', 13, '64c77d564772d1690795350.jpg', 'local', 'gallary', '2023-07-31 09:22:30', '2023-07-31 09:22:30'),
(149, 'App\\Models\\Link', 13, '64c77d564c9371690795350.jpg', 'local', 'gallary', '2023-07-31 09:22:30', '2023-07-31 09:22:30'),
(150, 'App\\Models\\Link', 8, '64c77e39abab31690795577.png', 'local', 'gallary', '2023-07-31 09:26:17', '2023-07-31 09:26:17'),
(151, 'App\\Models\\Link', 8, '64c77e39b629e1690795577.jpg', 'local', 'gallary', '2023-07-31 09:26:17', '2023-07-31 09:26:17'),
(152, 'App\\Models\\Link', 8, '64c77e39bc7821690795577.png', 'local', 'gallary', '2023-07-31 09:26:17', '2023-07-31 09:26:17'),
(153, 'App\\Models\\Link', 8, '64c77e39c322c1690795577.png', 'local', 'gallary', '2023-07-31 09:26:17', '2023-07-31 09:26:17'),
(154, 'App\\Models\\Link', 7, '64c77f048c1b51690795780.png', 'local', 'gallary', '2023-07-31 09:29:40', '2023-07-31 09:29:40'),
(155, 'App\\Models\\Link', 7, '64c77f04986d91690795780.jpg', 'local', 'gallary', '2023-07-31 09:29:40', '2023-07-31 09:29:40'),
(156, 'App\\Models\\Link', 7, '64c77f049fdab1690795780.png', 'local', 'gallary', '2023-07-31 09:29:40', '2023-07-31 09:29:40'),
(157, 'App\\Models\\Link', 7, '64c77f04a94231690795780.png', 'local', 'gallary', '2023-07-31 09:29:40', '2023-07-31 09:29:40'),
(158, 'App\\Models\\Link', 6, '64c77ff88dbc11690796024.png', 'local', 'gallary', '2023-07-31 09:33:44', '2023-07-31 09:33:44'),
(159, 'App\\Models\\Link', 6, '64c77ff898dc71690796024.jpg', 'local', 'gallary', '2023-07-31 09:33:44', '2023-07-31 09:33:44'),
(160, 'App\\Models\\Link', 6, '64c77ff89edd31690796024.png', 'local', 'gallary', '2023-07-31 09:33:44', '2023-07-31 09:33:44'),
(161, 'App\\Models\\Link', 6, '64c77ff8a55ae1690796024.jpg', 'local', 'gallary', '2023-07-31 09:33:44', '2023-07-31 09:33:44'),
(166, 'App\\Models\\Link', 3, '64c78158211f21690796376.png', 'local', 'gallary', '2023-07-31 09:39:36', '2023-07-31 09:39:36'),
(167, 'App\\Models\\Link', 3, '64c781582b8931690796376.jpg', 'local', 'gallary', '2023-07-31 09:39:36', '2023-07-31 09:39:36'),
(168, 'App\\Models\\Link', 3, '64c7815832e0f1690796376.jpg', 'local', 'gallary', '2023-07-31 09:39:36', '2023-07-31 09:39:36'),
(169, 'App\\Models\\Link', 3, '64c78158396c61690796376.jpg', 'local', 'gallary', '2023-07-31 09:39:36', '2023-07-31 09:39:36'),
(170, 'App\\Models\\Link', 2, '64c781e734da31690796519.png', 'local', 'gallary', '2023-07-31 09:41:59', '2023-07-31 09:41:59'),
(171, 'App\\Models\\Link', 2, '64c781e73d4541690796519.png', 'local', 'gallary', '2023-07-31 09:41:59', '2023-07-31 09:41:59'),
(172, 'App\\Models\\Link', 2, '64c781e742ace1690796519.jpg', 'local', 'gallary', '2023-07-31 09:41:59', '2023-07-31 09:41:59'),
(173, 'App\\Models\\Link', 2, '64c781e747cdb1690796519.png', 'local', 'gallary', '2023-07-31 09:41:59', '2023-07-31 09:41:59'),
(174, 'App\\Models\\Article', 10, '64c7849bcc65b1690797211.png', 'local', NULL, '2023-07-31 09:53:31', '2023-07-31 09:53:31'),
(175, 'App\\Models\\Article', 9, '64c7878417bcf1690797956.png', 'local', NULL, '2023-07-31 10:05:56', '2023-07-31 10:05:56'),
(176, 'App\\Models\\Article', 8, '64c78baa113211690799018.png', 'local', NULL, '2023-07-31 10:23:38', '2023-07-31 10:23:38'),
(177, 'App\\Models\\Admin\\PaymentMethod', 13, '64c78c31040491690799153.jpg', 'local', NULL, '2023-07-31 10:25:53', '2023-07-31 10:25:53'),
(178, 'App\\Models\\Article', 7, '64c78de5318b61690799589.png', 'local', NULL, '2023-07-31 10:33:09', '2023-07-31 10:33:09'),
(179, 'App\\Models\\Admin\\PaymentMethod', 17, '64c78e14da8801690799636.jpg', 'local', NULL, '2023-07-31 10:33:56', '2023-07-31 10:33:56'),
(180, 'App\\Models\\Admin\\PaymentMethod', 16, '64c78f7c69af91690799996.jpg', 'local', NULL, '2023-07-31 10:39:56', '2023-07-31 10:39:56'),
(181, 'App\\Models\\Article', 6, '64c7912bceb031690800427.png', 'local', NULL, '2023-07-31 10:47:08', '2023-07-31 10:47:08'),
(182, 'App\\Models\\Admin\\PaymentMethod', 15, '64c7921ae07791690800666.jpg', 'local', NULL, '2023-07-31 10:51:06', '2023-07-31 10:51:06'),
(183, 'App\\Models\\Article', 5, '64c7944160c911690801217.png', 'local', NULL, '2023-07-31 11:00:18', '2023-07-31 11:00:18'),
(186, 'App\\Models\\Ticket', 9, '64c8dbf64bfe21690885110.jpg', 'local', 'ticket_file', '2023-08-01 10:18:30', '2023-08-01 10:18:30'),
(187, 'App\\Models\\Ticket', 9, '64c8dbf64d9841690885110.jpg', 'local', 'ticket_file', '2023-08-01 10:18:30', '2023-08-01 10:18:30'),
(188, 'App\\Models\\Ticket', 9, '64c8dbf64f61a1690885110.txt', 'local', 'ticket_file', '2023-08-01 10:18:30', '2023-08-01 10:18:30'),
(189, 'App\\Models\\Ticket', 10, '64c8e390246081690887056.png', 'local', 'ticket_file', '2023-08-01 10:50:56', '2023-08-01 10:50:56'),
(190, 'App\\Models\\Ticket', 10, '64c8e39025fa11690887056.png', 'local', 'ticket_file', '2023-08-01 10:50:56', '2023-08-01 10:50:56'),
(191, 'App\\Models\\Ticket', 10, '64c8e39027b7a1690887056.txt', 'local', 'ticket_file', '2023-08-01 10:50:56', '2023-08-01 10:50:56'),
(195, 'App\\Models\\Core\\Setting', 4, '64c8e9595a4191690888537.png', 's3', NULL, '2023-08-01 11:15:37', '2023-08-01 11:15:37'),
(196, 'App\\Models\\Ticket', 14, '64c8e9ececc821690888684.jpg', 's3', 'ticket_file', '2023-08-01 11:18:05', '2023-08-01 11:18:05'),
(197, 'App\\Models\\Ticket', 14, '64c8e9ed569931690888685.jpg', 's3', 'ticket_file', '2023-08-01 11:18:05', '2023-08-01 11:18:05'),
(199, 'App\\Models\\Ticket', 14, '64c8e9ed9f7c41690888685.txt', 's3', 'ticket_file', '2023-08-01 11:18:05', '2023-08-01 11:18:05'),
(201, 'App\\Models\\Core\\Setting', 3, '64c9dcd6585e51690950870.png', 'local', NULL, '2023-08-02 04:34:31', '2023-08-02 04:34:31'),
(202, 'App\\Models\\Admin\\Frontend', 1, '64ca40ea4a1971690976490.jpg', 'local', NULL, '2023-08-02 11:41:31', '2023-08-02 11:41:31'),
(204, 'App\\Models\\Link', 5, '64ca41abcf24b1690976683.png', 'local', 'gallary', '2023-08-02 11:44:43', '2023-08-02 11:44:43'),
(205, 'App\\Models\\Link', 5, '64ca41abd99141690976683.png', 'local', 'gallary', '2023-08-02 11:44:43', '2023-08-02 11:44:43'),
(206, 'App\\Models\\Link', 5, '64ca41abe1db41690976683.png', 'local', 'gallary', '2023-08-02 11:44:43', '2023-08-02 11:44:43'),
(207, 'App\\Models\\Link', 19, '64ca423d72dc91690976829.png', 'local', 'thumbs', '2023-08-02 11:47:09', '2023-08-02 11:47:09'),
(208, 'App\\Models\\Admin\\Category', 8, '64ca43930d1e91690977171.jpg', 'local', NULL, '2023-08-02 11:52:51', '2023-08-02 11:52:51'),
(209, 'App\\Models\\Admin\\Category', 10, '64ca4419a46081690977305.jpg', 'local', NULL, '2023-08-02 11:55:05', '2023-08-02 11:55:05'),
(210, 'App\\Models\\Admin\\Category', 11, '64ca44caac5b81690977482.jpg', 'local', NULL, '2023-08-02 11:58:02', '2023-08-02 11:58:02'),
(212, 'App\\Models\\Admin\\Category', 12, '64ca4541958651690977601.jpg', 'local', NULL, '2023-08-02 12:00:02', '2023-08-02 12:00:02'),
(213, 'App\\Models\\Admin\\Category', 16, '64ca45840609b1690977668.jpg', 'local', NULL, '2023-08-02 12:01:08', '2023-08-02 12:01:08'),
(214, 'App\\Models\\Ad', 8, '64ca4d7e1a2e01690979710.jpg', 'local', NULL, '2023-08-02 12:35:10', '2023-08-02 12:35:10'),
(215, 'App\\Models\\Cta', 5, '64ca51df3276a1690980831.jpg', 'local', NULL, '2023-08-02 12:53:51', '2023-08-02 12:53:51'),
(216, 'App\\Models\\Cta', 3, '64ca523aeb7b51690980922.jpg', 'local', NULL, '2023-08-02 12:55:23', '2023-08-02 12:55:23'),
(217, 'App\\Models\\Cta', 2, '64ca524580cb31690980933.jpg', 'local', NULL, '2023-08-02 12:55:34', '2023-08-02 12:55:34'),
(220, 'App\\Models\\Client', 13, '64ca52a7b75501690981031.jpg', 'local', NULL, '2023-08-02 12:57:12', '2023-08-02 12:57:12'),
(221, 'App\\Models\\Ad', 4, '64ca57ee7676c1690982382.jpg', 'local', NULL, '2023-08-02 13:19:42', '2023-08-02 13:19:42'),
(222, 'App\\Models\\Ad', 5, '64ca580a1f9ea1690982410.jpg', 'local', NULL, '2023-08-02 13:20:10', '2023-08-02 13:20:10'),
(223, 'App\\Models\\Admin', 1, '64cb35a8095b71691039144.jpg', 'local', NULL, '2023-08-03 05:05:44', '2023-08-03 05:05:44'),
(224, 'App\\Models\\PaymentLog', 106, '64cb3a934138f1691040403.jpg', 'local', 'image', '2023-08-03 05:26:43', '2023-08-03 05:26:43'),
(225, 'App\\Models\\PaymentLog', 106, '64cb3a9345f661691040403.jpg', 'local', 'nidimage', '2023-08-03 05:26:43', '2023-08-03 05:26:43'),
(226, 'App\\Models\\PaymentLog', 107, '64cb3e6fa81881691041391.jpg', 'local', 'image', '2023-08-03 05:43:11', '2023-08-03 05:43:11'),
(227, 'App\\Models\\PaymentLog', 107, '64cb3e6fab65d1691041391.jpg', 'local', 'nidimage', '2023-08-03 05:43:11', '2023-08-03 05:43:11'),
(232, 'App\\Models\\User', 37, '64cb98a1ba3061691064481.jpg', 'local', NULL, '2023-08-03 12:08:01', '2023-08-03 12:08:01'),
(238, 'App\\Models\\Ticket', 15, '64cb9bc988ddd1691065289.png', 'local', 'ticket_file', '2023-08-03 12:21:29', '2023-08-03 12:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(6, 'default', '{\"uuid\":\"b764a807-1dff-4e37-afbd-2f130d09ee7c\",\"displayName\":\"App\\\\Jobs\\\\SendMailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendMailJob\",\"command\":\"O:20:\\\"App\\\\Jobs\\\\SendMailJob\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:8:\\\"template\\\";s:20:\\\"SUBSCRIPTION_EXPIRED\\\";s:4:\\\"code\\\";a:2:{s:4:\\\"time\\\";O:13:\\\"Carbon\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2023-08-03 16:54:14.247417\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:10:\\\"Asia\\/Dhaka\\\";}s:4:\\\"name\\\";s:8:\\\"Premimum\\\";}}\"}}', 0, NULL, 1691060055, 1691060055);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `ltr` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `uid`, `created_by`, `updated_by`, `name`, `code`, `is_default`, `status`, `ltr`, `created_at`, `updated_at`) VALUES
(1, 'lmC7-KWc80cO2-WGW1', 1, 1, 'English', 'en', '1', '1', '1', '2023-07-08 13:29:19', '2023-07-15 07:42:53'),
(8, '7ITH-YuE1KC6q-m8xk', 1, NULL, 'Albania', 'al', '0', '1', '1', '2023-08-02 08:42:22', '2023-08-02 08:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `visible_url` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `tags` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category` text COLLATE utf8mb4_unicode_ci,
  `liked_by` text COLLATE utf8mb4_unicode_ci,
  `deep_links` text COLLATE utf8mb4_unicode_ci,
  `social_media` text COLLATE utf8mb4_unicode_ci,
  `expired_at` date DEFAULT NULL,
  `likes_count` int NOT NULL DEFAULT '0',
  `view` int NOT NULL DEFAULT '0',
  `link_attribute` text COLLATE utf8mb4_unicode_ci,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `bypass_details_page` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `feature_on_home` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `verified` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `show_qr_code` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `uid`, `user_id`, `package_id`, `admin_id`, `url`, `visible_url`, `slug`, `title`, `description`, `tags`, `phone`, `email`, `address`, `country`, `map_address`, `category`, `liked_by`, `deep_links`, `social_media`, `expired_at`, `likes_count`, `view`, `link_attribute`, `meta_title`, `meta_description`, `meta_keywords`, `bypass_details_page`, `feature_on_home`, `verified`, `approved`, `show_qr_code`, `created_at`, `updated_at`) VALUES
(2, '4wKr-RbG1eGyq-lutS', 26, NULL, NULL, 'https://www.adobe.com/', 'adobe.com', 'adobe', 'Adobe: Creative, marketing and document management solutions', 'Adobe Inc. is a leading multinational software company renowned for its creative software solutions and digital experience platforms. Founded in 1982, Adobe has played a transformative role in shaping the digital landscape. From iconic applications like Photoshop, Illustrator, and InDesign that revolutionized digital creativity, to powerful tools like Adobe Experience Cloud for marketing and analytics, Adobe empowers professionals and businesses worldwide to craft immersive digital experiences. With a focus on innovation and customer-centricity, Adobe continues to be a driving force behind the evolution of digital media and technology.', '[\"Adobe\",\"Creativity & Design\",\"PDF\"]', '+ 800-585-0774', 'adobepr@adobe.com', 'Adobe\r\n345 Park Avenue\r\nSan Jose, CA 95110-2704', 'United States', '{\"lat\":\"37.33273990030624\",\"lon\":\"-121.89528780030908\",\"zoom\":\"13.814415182598932\"}', '[\"8\"]', '[1]', '[{\"title\":\"Adobe | Photography\",\"url\":\"https:\\/\\/www.adobe.com\\/creativecloud\\/photography.html\",\"link_attribute\":\"regular_link\"},{\"title\":\"Adobe | Students\",\"url\":\"https:\\/\\/www.adobe.com\\/creativecloud\\/buy\\/students.html\",\"link_attribute\":\"regular_link\"},{\"title\":\"Adobe | Enterprise\",\"url\":\"https:\\/\\/www.adobe.com\\/creativecloud\\/business\\/enterprise.html\",\"link_attribute\":\"regular_link\"}]', '{\"facebook\":\"http:\\/\\/www.facebook.com\\/Adobe\",\"twitter\":\"http:\\/\\/twitter.com\\/Adobe\",\"instagram\":\"#\",\"linkedIn\":\"http:\\/\\/www.linkedin.com\\/company\\/adobe\",\"whatsApp\":\"#\",\"telegram\":\"#\"}', '2023-11-24', 5, 77, 'regular_link', '{\"en\":\"Adobe Inc.: Empowering Digital Creativity and Experiences\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Discover Adobe Inc., the pioneering multinational software company known for its creative software solutions and digital experience platforms. Explore iconic applications like Photoshop, Illustrator, and InDesign, alongside powerful tools from Adobe Experience Cloud, shaping immersive digital experiences for professionals and businesses worldwide.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"Adobe Inc.\",\"creative software\",\"digital experience\",\"Photoshop\",\"Illustrator\",\"InDesign\",\"Adobe Experience Cloud\",\"digital creativity\",\"software solutions\",\"digital media\",\"technology\",\"marketing\",\"analytics\",\"customer-centricity\",\"innovation\"]', '1', '0', '1', '1', '0', '2023-07-04 11:07:22', '2023-08-03 12:37:04'),
(3, '3hOu-CSAHuTxZ-DOog', 26, NULL, NULL, 'https://edition.cnn.com/', 'edition.cnn.com', 'cnn', 'Breaking News, Latest News and Videos | CNN', 'CNN, or Cable News Network, is a prominent global news organization known for its comprehensive and real-time coverage of news, current events, and in-depth analysis. Established in 1980, CNN has become a leading source for breaking news and reliable reporting on various topics, including politics, business, technology, entertainment, and more. With an extensive network of journalists and correspondents worldwide, CNN strives to deliver accurate and unbiased reporting, keeping audiences informed and engaged with the latest developments happening across the globe.', '[\"CNN\",\"News\",\"World\",\"Sports\",\"Entertainment\"]', '+1 (404) 827-1500', 'tips@cnn.com', '1 CNN Center Atlanta, Georgia 30303', 'United States', '{\"lat\":\"33.511263845617876\",\"lon\":\"-84.33158179292407\",\"zoom\":\"5.595881443989774\"}', '[\"8\",\"11\"]', '{\"1\":34}', '[{\"title\":\"CNN | World\",\"url\":\"https:\\/\\/edition.cnn.com\\/world\",\"link_attribute\":\"regular_link\"},{\"title\":\"CNN | Sports\",\"url\":\"https:\\/\\/edition.cnn.com\\/sport\",\"link_attribute\":\"regular_link\"},{\"title\":\"CNN | Entertainment\",\"url\":\"https:\\/\\/edition.cnn.com\\/entertainment\",\"link_attribute\":\"regular_link\"}]', '{\"facebook\":\"https:\\/\\/facebook.com\\/CNN\",\"twitter\":\"https:\\/\\/twitter.com\\/CNN\",\"instagram\":\"https:\\/\\/instagram.com\\/CNN\",\"linkedIn\":\"###xxx\",\"whatsApp\":\"#xxx\",\"telegram\":\"#xxx\"}', '2023-08-04', 29, 24, 'regular_link', '{\"en\":\"CNN - Cable News Network: Comprehensive Global News and Analysis\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Stay informed with CNN, the renowned global news organization providing real-time coverage, breaking news, and in-depth analysis on politics, business, technology, entertainment, and more. Trust CNN\'s extensive network of journalists to deliver accurate and unbiased reporting from around the world.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"CNN\",\"Cable News Network\",\"global news\",\"real-time coverage\",\"breaking news\",\"in-depth analysis\",\"politics\",\"business\",\"technology\",\"entertainment\",\"journalists\",\"unbiased reporting\",\"reliable news source\"]', '1', '0', '1', '1', '0', '2023-06-14 11:17:55', '2023-08-03 12:56:28'),
(5, 'ug50-v4Yr3p84-Vxj2', 26, NULL, NULL, 'https://www.starlink.com/', 'starlink.com', 'starlink', 'Starlink', 'Starlink is a cutting-edge satellite internet constellation project developed by SpaceX, aimed at providing global, high-speed, and reliable internet access to underserved and remote regions. By deploying a network of thousands of small satellites in low Earth orbit, Starlink seeks to bridge the digital divide, offering fast and low-latency internet connections to users across the globe. With its ambitious vision and ongoing deployment efforts, Starlink has the potential to revolutionize internet connectivity and redefine the way we stay connected in the modern world.', '[\"Elon Musk\",\"Starlink\",\"Global Internet\",\"SpaceX\"]', NULL, NULL, NULL, 'United States', '{\"lat\":\"33.911728789032125\",\"lon\":\"-118.35239030301696\",\"zoom\":\"12.328524668192124\"}', '[\"12\"]', '{\"1\":34}', '[{\"title\":\"Starlink | Mobility\",\"url\":\"https:\\/\\/www.starlink.com\\/mobility\",\"link_attribute\":\"regular_link\"},{\"title\":\"Starlink | Aviation\",\"url\":\"https:\\/\\/www.starlink.com\\/aviation\",\"link_attribute\":\"regular_link\"},{\"title\":\"Starlink | Swarm\",\"url\":\"https:\\/\\/swarm.space\\/\",\"link_attribute\":\"regular_link\"}]', '{\"facebook\":null,\"twitter\":\"https:\\/\\/twitter.com\\/Starlink\",\"instagram\":\"Labore tempora labor\",\"linkedIn\":\"Beatae dolorem ad co\",\"whatsApp\":\"Magnam consectetur\",\"telegram\":\"Quis sint natus simi\"}', '2023-08-04', 70, 104, 'ugc', '{\"en\":\"Starlink: Revolutionizing Global Internet Connectivity with SpaceX\'s Satellite Network\",\"al\":null}', '{\"en\":\"Explore Starlink, SpaceX\'s cutting-edge satellite internet project, bringing high-speed and reliable internet access to underserved regions worldwide. Learn about the deployment of thousands of low Earth orbit satellites, bridging the digital divide and revolutionizing global internet connectivity.\",\"al\":null}', '[\"Starlink\",\"SpaceX\",\"satellite internet\",\"global connectivity\",\"high-speed internet\",\"reliable internet\",\"low Earth orbit satellites\",\"bridging the digital divide\",\"internet access\",\"underserved regions\",\"space technology\",\"satellite network\",\"modern connectivity\"]', '1', '0', '1', '1', '0', '2023-07-24 16:18:02', '2023-08-03 12:31:45'),
(6, '15hD-zoshNu4d-PM71', 26, NULL, NULL, 'https://www.spacex.com/', 'spacex.com', 'spacex', 'SpaceX', 'SpaceX, founded by visionary entrepreneur Elon Musk, is a pioneering aerospace company that has revolutionized space exploration and technology. With a relentless pursuit of making life multiplanetary, SpaceX is at the forefront of cutting-edge innovations in rocket design and space travel. Notable achievements include the successful development of the Falcon and Starship spacecraft, reusable rocket technology, and the historic first private crewed missions to the International Space Station. SpaceX\'s ambitious vision extends beyond Earth, with plans to colonize Mars and explore the cosmos, inspiring a new era of space exploration and igniting the imagination of humanity\'s interstellar future.', '[\"Elon Musk\",\"SpaceX\",\"Rocket\",\"Falcon\",\"Starship\"]', '+1 310-363-6000', NULL, 'CA 90250 HAWTHORNE, CALIFORNIA,', 'United States', '{\"lat\":\"33.9131094978889\",\"lon\":\"-118.35077713122595\",\"zoom\":\"10.358874445846663\"}', '[\"8\",\"10\",\"12\",\"16\"]', '{\"1\":34}', '[{\"title\":\"Falcon 9\",\"url\":\"https:\\/\\/www.spacex.com\\/vehicles\\/falcon-9\\/\",\"link_attribute\":\"regular_link\"},{\"title\":\"Falcon Heavy\",\"url\":\"https:\\/\\/www.spacex.com\\/vehicles\\/falcon-heavy\\/\",\"link_attribute\":\"regular_link\"},{\"title\":\"Starship\",\"url\":\"https:\\/\\/www.spacex.com\\/vehicles\\/starship\\/\",\"link_attribute\":\"regular_link\"}]', '{\"facebook\":\"Libero rem libero co\",\"twitter\":\"https:\\/\\/twitter.com\\/SpaceX\",\"instagram\":\"https:\\/\\/www.instagram.com\\/spacex\\/?hl=en\",\"linkedIn\":\"https:\\/\\/www.linkedin.com\\/company\\/spacex\",\"whatsApp\":\"Adipisicing voluptas\",\"telegram\":\"Consectetur laborio\"}', '2023-08-04', 57, 91, 'nofollow', '{\"en\":\"SpaceX: Pioneering Space Exploration and Interstellar Vision\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Explore SpaceX, the revolutionary aerospace company founded by Elon Musk, leading the charge in space exploration and technology. Discover their groundbreaking innovations, reusable rockets, and ambitious plans for interplanetary travel, including the colonization of Mars.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"SpaceX\",\"aerospace company\",\"space exploration\",\"rocket technology\",\"Elon Musk\",\"Falcon spacecraft\",\"Starship spacecraft\",\"interplanetary travel\",\"Mars colonization\",\"reusable rockets\",\"space missions\",\"interstellar vision\",\"space technology\",\"historic space missions\",\"private space company\"]', '1', '1', '1', '1', '0', '2023-04-24 16:18:41', '2023-08-03 12:16:00'),
(7, 'rs5Q-LzQOG5AU-Vxj9', 26, NULL, NULL, 'https://www.rockstargames.com/', 'rockstargames.com', 'rockstar', 'Rockstar Games', 'Rockstar Games is a renowned video game developer and publisher, celebrated for creating immersive and groundbreaking gaming experiences. With a track record of producing iconic titles such as Grand Theft Auto series, Red Dead Redemption, and Max Payne, Rockstar Games has left an indelible mark on the gaming industry. Their commitment to storytelling, open-world exploration, and attention to detail has garnered a loyal fan base worldwide. As innovators in the gaming realm, Rockstar Games continues to push the boundaries of interactive entertainment, captivating players with their richly crafted virtual worlds and engaging gameplay.', '[\"Rockstar Games\",\"Rockstar\",\"Games\",\"Headquarters\"]', '+1 866-922-8694', 'support@rockstargames.com', '110 W 44th St, New York City, New York, 10036, United States', 'United States', '{\"lat\":\"40.705724503188634\",\"lon\":\"-74.00548629586822\",\"zoom\":\"9.327946819570622\"}', '[\"8\",\"10\",\"11\",\"12\",\"16\"]', '[34]', '[{\"title\":\"Red Dead Redemption 2\",\"url\":\"https:\\/\\/www.rockstargames.com\\/games\\/reddeadredemption2\",\"link_attribute\":\"regular_link\"},{\"title\":\"Grand Theft Auto Five\",\"url\":\"https:\\/\\/www.rockstargames.com\\/gta-v\",\"link_attribute\":\"regular_link\"},{\"title\":\"grand Theft Auto Online\",\"url\":\"https:\\/\\/www.rockstargames.com\\/gta-online\",\"link_attribute\":\"regular_link\"}]', '{\"facebook\":\"https:\\/\\/www.facebook.com\\/rockstargames\",\"twitter\":\"https:\\/\\/twitter.com\\/RockstarGames\",\"instagram\":\"https:\\/\\/www.instagram.com\\/rockstargames\\/\",\"linkedIn\":\"Aperiam iste sapient\",\"whatsApp\":\"Debitis pariatur Od\",\"telegram\":\"Delectus quam velit\"}', '2023-08-04', 90, 86, 'regular_link', '{\"en\":\"Rockstar Games: Iconic Video Game Developer & Publisher\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Discover the world of Rockstar Games, a leading video game developer and publisher known for creating iconic titles like Grand Theft Auto, Red Dead Redemption, and Max Payne. Immerse yourself in their immersive storytelling, open-world exploration, and attention to detail that have captivated gamers worldwide.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"Rockstar Games\",\"video game developer\",\"video game publisher\",\"Grand Theft Auto\",\"Red Dead Redemption\",\"Max Payne\",\"gaming industry\",\"immersive storytelling\",\"open-world exploration\",\"attention to detail\",\"interactive entertainment\",\"iconic video games\"]', '1', '1', '1', '1', '0', '2023-05-24 16:19:35', '2023-08-03 11:39:29'),
(8, '73Nr-CE38SE1O-rhyB', 26, NULL, NULL, 'https://www.icc-cricket.com', 'icc-cricket.com', 'international-cricket-council', 'Official International Cricket Council Website', 'The Official International Cricket Council (ICC) Website is the ultimate destination for cricket enthusiasts worldwide. As the governing body for the sport, ICC showcases the latest news, scores, and updates on international cricket tournaments, including the ICC Cricket World Cup and ICC T20 World Cup. With comprehensive statistics, player profiles, and engaging multimedia content, cricket fans can immerse themselves in the world of their favorite players and teams. Stay connected to the heart of cricket as ICC\'s website brings you closer to the excitement, drama, and passion that define this gentleman\'s game.', '[\"ICC\",\"Headquarters\",\"International Cricket Council\"]', '+971 4 3828800', 'enquiries@icc-cricket.com', 'Street 69, Dubai Sports City, Sh Mohammed Bin Zayed Road, Dubai, PO Box 500 070, UAE', 'United Arab Emirates', '{\"lat\":\"25.022318397762874\",\"lon\":\"55.198517886954335\",\"zoom\":\"12.676626551846457\"}', '[\"8\",\"11\",\"12\"]', '[]', '[{\"title\":\"Official ICC Men\'s Cricket World Cup 2023 Website\",\"url\":\"https:\\/\\/www.cricketworldcup.com\\/\",\"link_attribute\":\"regular_link\"},{\"title\":\"Official ICC Men\'s World Test Championship 2023 Website\",\"url\":\"https:\\/\\/www.worldtestchampionship.com\\/\",\"link_attribute\":\"regular_link\"},{\"title\":\"Official ICC Women\'s T20 World Cup 2023 Website\",\"url\":\"https:\\/\\/www.t20worldcup.com\\/\",\"link_attribute\":\"regular_link\"}]', '{\"facebook\":\"http:\\/\\/www.facebook.com\\/icc\",\"twitter\":\"http:\\/\\/www.twitter.com\\/ICC\",\"instagram\":\"http:\\/\\/www.instagram.com\\/ICC\",\"linkedIn\":\"Proident qui veniam\",\"whatsApp\":\"Non aliqua Commodi\",\"telegram\":\"Accusamus fuga Et q\"}', '2023-08-04', 70, 36, 'nofollow', '{\"en\":\"Official International Cricket Council Website | ICC Cricket Updates & News\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Explore the Official International Cricket Council (ICC) Website for the latest updates, scores, and news on international cricket tournaments, including the ICC Cricket World Cup and ICC T20 World Cup. Delve into player profiles, comprehensive statistics, and captivating multimedia content, immersing yourself in the heart of cricket\'s excitement and passion.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"ICC\",\"International Cricket Council\",\"cricket updates\",\"cricket news\",\"ICC Cricket World Cup\",\"ICC T20 World Cup\",\"cricket scores\",\"cricket statistics\",\"player profiles\",\"cricket multimedia\",\"cricket tournaments\",\"cricket enthusiasts\",\"gentleman\'s game\"]', '1', '0', '1', '1', '0', '2023-05-26 05:57:24', '2023-08-03 12:31:46'),
(13, 'LDXC-cjR90uiR-vvi4', 26, NULL, NULL, 'https://www.fifa.com/fifaplus/en', 'fifa.com/fifaplus/en', 'fifa', 'FIFA | The Home of Football', 'FIFA, The Home of Football, is the international governing body for the world\'s most beloved sport. As the Fédération Internationale de Football Association, FIFA is responsible for organizing and promoting football\'s major tournaments, including the FIFA World Cup, a global spectacle that captivates billions of fans every four years. Beyond its role in organizing events, FIFA works to develop the game at all levels, fostering its growth and unity worldwide. With a rich history and a passion for the sport, FIFA remains dedicated to preserving football\'s spirit and bringing people together through the universal language of the beautiful game.', '[\"Fifa\",\"Headquarters\"]', '+41 43 222 7272', 'media@fifa.org', 'FIFA headquarters, Forrenweidstrasse, 8044 Zürich, Switzerland', 'Switzerland', '{\"lat\":\"47.38133940226703\",\"lon\":\"8.571653511129238\",\"zoom\":\"15.949062673267294\"}', '[\"11\",\"16\"]', '[]', '[{\"title\":\"FIFA Women\'s World Cup Australia & New Zealand 2023\",\"url\":\"https:\\/\\/www.fifa.com\\/fifaplus\\/en\\/tournaments\\/womens\\/womensworldcup\\/australia-new-zealand2023?intcmp=(p_fifaplus)_(c_webheader-main)_(sc_tournaments)_(ssc_fwwc-2023)_(da_04052023)_(l_en)\",\"link_attribute\":\"regular_link\"},{\"title\":\"FIFA World Cup 26\",\"url\":\"https:\\/\\/www.fifa.com\\/fifaplus\\/en\\/tournaments\\/mens\\/worldcup\\/canadamexicousa2026?intcmp=(p_fifaplus)_(c_webheader-main)_(sc_tournaments)_(ssc_fwc-2026)_(da_04052023)_(l_en)\",\"link_attribute\":\"regular_link\"}]', '{\"facebook\":\"https:\\/\\/www.facebook.com\\/fifaworldcup\\/?ref=embed_page\",\"twitter\":\"https:\\/\\/twitter.com\\/FIFAcom?ref_src=twsrc%5Etfw%7Ctwcamp%5Eembeddedtimeline%7Ctwterm%5Escreen-name%3AFIFAcom%7Ctwcon%5Es1_c1\",\"instagram\":\"Quia anim cupiditate\",\"linkedIn\":\"https:\\/\\/ch.linkedin.com\\/company\\/fifa\",\"whatsApp\":\"Dignissimos officia\",\"telegram\":\"Necessitatibus iste\"}', '2023-08-04', 0, 3, 'regular_link', '{\"en\":\"FIFA | The Home of Football: Uniting Nations Through the Beautiful Game\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Discover FIFA, The Home of Football, where passion, talent, and teamwork collide. As the international governing body, FIFA orchestrates the iconic FIFA World Cup and fosters football\'s growth worldwide. Explore the rich history and global impact of the beautiful game, as it unites nations and transcends borders.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"FIFA\",\"The Home of Football\",\"FIFA World Cup\",\"international football\",\"football governing body\",\"football organization\",\"global sports\",\"football history\",\"football events\",\"football development\",\"sports unity\",\"football tournaments\",\"beautiful game\",\"football passion\"]', '1', '0', '1', '1', '0', '2023-07-29 05:53:48', '2023-08-03 12:31:42'),
(14, '1w8z-mun2ROLk-gAIs', 26, NULL, NULL, 'https://www.thetimes.co.uk/', 'thetimes.co.uk', 'the-times', 'The Times And The Sunday Times', 'TIME magazine, an iconic publication with a rich history, is a globally renowned source of in-depth journalism and impactful storytelling. Since its founding in 1923, TIME has been at the forefront of reporting on world events, politics, culture, and human interest stories. With its striking cover images and thought-provoking articles, TIME continues to inform, inspire, and shape public discourse on issues that shape our world. A trusted name in journalism, TIME remains a symbol of insightful reporting and a window into the ever-changing currents of our time.', '[\"Times\"]', '0207 711 1527', 'care@thetimes.co.uk', 'The News Building, London\r\n1 London Bridge Place, SE1 9GF', 'United States', '{\"lat\":\"40.756901088522596\",\"lon\":\"-73.98656762071731\",\"zoom\":\"14.85419334264616\"}', '[\"10\",\"11\",\"12\"]', '[1]', '[{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"},{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"}]', '{\"facebook\":null,\"twitter\":null,\"instagram\":null,\"linkedIn\":null,\"whatsApp\":null,\"telegram\":null}', '2023-08-08', 1, 3, 'regular_link', '{\"en\":\"TIME Magazine | Global Journalism | World Events | Culture | Human Interest Stories\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Discover the world-class journalism of TIME magazine, covering global events, politics, culture, and captivating human interest stories. Stay informed and inspired by thought-provoking articles and striking cover images that shape our understanding of the world.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"TIME magazine\",\"global journalism\",\"world events\",\"politics\",\"culture\",\"human interest stories\",\"thought-provoking articles\",\"cover images\",\"impactful storytelling\",\"trusted name in journalism\",\"reporting\",\"news\"]', '1', '1', '1', '1', '0', '2023-03-29 06:33:07', '2023-08-03 12:28:14'),
(15, '2qLZ-mfCN3le7-knGa', 1, NULL, NULL, 'https://www.foxsports.com/', 'foxsports.com', 'fox-sports', 'FOX Sports News, Scores, Schedules, Odds, Shows, Streams & Videos | FOX Sports', 'FOX Sports is a comprehensive sports media platform that provides fans with up-to-date news, live scores, schedules, odds, and a diverse range of sports-related content. With an array of captivating shows, live streams, and videos, FOX Sports keeps enthusiasts engaged and informed about their favorite sports. From thrilling game highlights to in-depth analysis and expert commentary, FOX Sports caters to sports enthusiasts worldwide, offering an immersive and dynamic experience that celebrates the excitement of sports in all its glory.', '[\"Fox\",\"Fox Sports\",\"fine\"]', '123123214', 'NewsFromFOXSports@fox.com', NULL, NULL, NULL, '[\"10\"]', NULL, '[{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"},{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"},{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"},{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"},{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"}]', '{\"facebook\":null,\"twitter\":\"https:\\/\\/twitter.com\\/FOXSports\",\"instagram\":null,\"linkedIn\":null,\"whatsApp\":null,\"telegram\":null}', '2023-08-04', 0, 1, 'regular_link', '{\"en\":\"FOX Sports: News, Scores, Schedules, Odds, Shows, Streams & Videos\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Stay connected with FOX Sports for the latest sports news, live scores, schedules, odds, and a diverse array of sports-related content. Enjoy captivating shows, live streams, and videos, keeping you informed and engaged in the world of sports.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"FOX Sports\",\"sports news\",\"live scores\",\"sports schedules\",\"sports odds\",\"sports shows\",\"sports streams\",\"sports videos\",\"sports media platform\",\"sports enthusiasts\",\"game highlights\",\"sports analysis\",\"expert commentary\",\"sports entertainment\"]', '1', '0', '1', '1', '0', '2023-03-31 06:46:01', '2023-08-03 12:31:52'),
(19, 'Pa7L-oQ7j4Zcl-rHq7', NULL, NULL, 1, 'https://www.cricbuzz.com/', NULL, 'live-cricket-score,-schedule,-latest-news,-stats-&-videos-|-cricbuzz.com', 'Live Cricket Score, Schedule, Latest News, Stats & Videos | Cricbuzz.com', 'Get Live Cricket Scores, Scorecard, Schedules of International and Domestic cricket matches along with Latest News, Videos and ICC Cricket Rankings of Players on Cricbuzz.', NULL, NULL, NULL, NULL, NULL, '{\"lat\":\"46.331568400058075\",\"lon\":\"24.620361328124996\",\"zoom\":\"5\"}', '[\"8\"]', NULL, '[{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"},{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"},{\"title\":null,\"url\":null,\"link_attribute\":\"regular_link\"}]', '{\"facebook\":null,\"twitter\":null,\"instagram\":null,\"linkedIn\":null,\"whatsApp\":null,\"telegram\":null}', NULL, 0, 2, 'regular_link', '{\"en\":null,\"al\":null}', '{\"en\":null,\"al\":null}', NULL, '0', '0', '0', '1', '0', '2023-08-02 11:47:09', '2023-08-02 12:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `link_browsers`
--

CREATE TABLE `link_browsers` (
  `id` bigint UNSIGNED NOT NULL,
  `link_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `link_browsers`
--

INSERT INTO `link_browsers` (`id`, `link_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 5, 34, '2023-07-27 04:20:47', '2023-07-27 04:20:47'),
(2, 3, 34, '2023-07-27 04:21:32', '2023-07-27 04:21:32'),
(11, 15, 1, '2023-07-31 06:46:41', '2023-07-31 06:46:41'),
(12, 2, 1, '2023-07-31 06:52:41', '2023-07-31 06:52:41'),
(13, 5, 1, '2023-08-01 04:42:36', '2023-08-01 04:42:36'),
(14, 6, 1, '2023-08-01 04:57:44', '2023-08-01 04:57:44'),
(15, 7, 1, '2023-08-01 06:00:07', '2023-08-01 06:00:07'),
(16, 3, 1, '2023-08-01 06:56:08', '2023-08-01 06:56:08'),
(17, 19, 1, '2023-08-02 11:47:16', '2023-08-02 11:47:16'),
(18, 6, 37, '2023-08-03 12:16:00', '2023-08-03 12:16:00'),
(19, 3, 37, '2023-08-03 12:16:12', '2023-08-03 12:16:12'),
(20, 5, 37, '2023-08-03 12:22:52', '2023-08-03 12:22:52'),
(21, 2, 37, '2023-08-03 12:37:04', '2023-08-03 12:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `link_reviews`
--

CREATE TABLE `link_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci,
  `ratings` int NOT NULL DEFAULT '0',
  `approved` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `link_reviews`
--

INSERT INTO `link_reviews` (`id`, `uid`, `link_id`, `user_id`, `review`, `ratings`, `approved`, `created_at`, `updated_at`) VALUES
(2, NULL, 2, 1, 'asdas', 3, '1', '2023-07-25 15:35:53', '2023-07-26 05:36:21'),
(3, NULL, 3, 1, 'asdsa', 3, '1', '2023-07-26 05:35:48', '2023-07-26 05:36:19'),
(4, NULL, 3, 1, 'xczxcc', 4, '1', '2023-07-26 05:35:55', '2023-07-26 05:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `mail_gateways`
--

CREATE TABLE `mail_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credential` longtext COLLATE utf8mb4_unicode_ci,
  `default` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_gateways`
--

INSERT INTO `mail_gateways` (`id`, `uid`, `created_by`, `updated_by`, `code`, `name`, `credential`, `default`, `created_at`, `updated_at`) VALUES
(1, 'WmHy-Bezy77AJ-pdu1', 1, 1, '101SMTP', 'SMTP', '{\"driver\":\"smtp\",\"host\":\"sandbox.smtp.mailtrap.io\",\"port\":\"2525\",\"encryption\":\"SSL\",\"username\":\"b63e9096ba3921\",\"password\":\"f1bca5495781d2\",\"from\":{\"address\":\"nafiz0khan1@gmail.com\",\"name\":\"nafiz khan\"}}', '1', '2023-07-10 10:20:32', '2023-07-15 11:08:47'),
(2, '2wit-nOQwnYC7-wq0s', 1, 1, '104PHP', 'PHP MAIL', '[]', '0', '2023-07-10 10:20:32', '2023-07-15 10:56:19'),
(3, 'fqJt-BrjihLeQ-mmn3', 1, 1, '102SENDGRID', 'SendGrid Api', '{\"app_key\":\"#\",\"from\":{\"address\":\"x\",\"name\":\"###dd\"}}', '0', '2023-07-10 10:20:32', '2023-07-15 10:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_id` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `name` json NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_in_header` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `show_in_footer` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `uid`, `serial_id`, `created_by`, `updated_by`, `name`, `url`, `show_in_header`, `show_in_footer`, `status`, `created_at`, `updated_at`) VALUES
(7, 'uIXd-rA0tUrrc-eDc5', 5, 1, 1, '{\"al\": null, \"bj\": null, \"en\": \"Articles\"}', 'http://localhost/genLink/articles', '1', '0', '1', '2023-07-22 04:30:05', '2023-07-22 04:44:09'),
(8, '8TW2-wx5M5FcK-MKty', 6, 1, 1, '{\"al\": null, \"en\": \"Contacts\"}', 'http://localhost/genLink/contacts', '1', '0', '1', '2023-07-23 07:00:23', '2023-08-03 12:34:04'),
(9, 'i1Ip-Ha2IY17q-dPo3', 7, 1, 1, '{\"al\": null, \"bh\": null, \"bj\": null, \"dz\": null, \"en\": \"Forum\"}', 'http://localhost/genLink', '0', '0', '1', '2023-07-31 11:47:51', '2023-08-01 06:40:15'),
(10, '5bcY-OPVX8DEh-vSl4', 8, 1, 1, '{\"al\": null, \"en\": \"Community\"}', 'http://localhost/genLink', '1', '0', '1', '2023-07-31 11:49:06', '2023-08-03 12:34:43'),
(11, '2t3Q-xJikUbCh-FFDC', 9, 1, 1, '{\"al\": null, \"en\": \"Entertainment\"}', 'http://localhost/genLink/', '1', '0', '1', '2023-07-31 11:50:57', '2023-08-03 12:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `ticket_id` bigint UNSIGNED DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `admin_id`, `ticket_id`, `message`, `created_at`, `updated_at`) VALUES
(6, NULL, 10, '<p>Demo SubjectDemo SubjectDemo SubjectDemo Subject<br></p>', '2023-08-01 10:50:56', '2023-08-01 10:50:56'),
(7, NULL, 10, 'adasd', '2023-08-01 10:59:34', '2023-08-01 10:59:34'),
(8, NULL, 10, 'xcxc', '2023-08-01 10:59:38', '2023-08-01 10:59:38'),
(9, NULL, 10, '<p>xczxc</p>', '2023-08-01 11:01:11', '2023-08-01 11:01:11'),
(10, NULL, 10, '<p>ccccc</p>', '2023-08-01 11:01:17', '2023-08-01 11:01:17'),
(11, NULL, 11, '<p>asd</p>', '2023-08-01 11:11:15', '2023-08-01 11:11:15'),
(12, NULL, 12, '<p>asd</p>', '2023-08-01 11:11:28', '2023-08-01 11:11:28'),
(15, 1, NULL, 'ASDASFFASF', '2023-08-01 13:20:03', '2023-08-01 13:20:03'),
(16, 1, NULL, 'ASDASFFASF', '2023-08-01 13:20:43', '2023-08-01 13:20:43'),
(17, 1, NULL, 'rdtyhdt', '2023-08-01 13:20:49', '2023-08-01 13:20:49'),
(18, 1, NULL, 'fsdf', '2023-08-01 13:21:26', '2023-08-01 13:21:26'),
(19, NULL, 14, '<p>asdasd</p>', '2023-08-01 13:21:53', '2023-08-01 13:21:53'),
(20, 1, 14, 'asdsad', '2023-08-01 13:21:59', '2023-08-01 13:21:59'),
(21, NULL, 14, '<p>qwrq</p>', '2023-08-02 04:35:38', '2023-08-02 04:35:38'),
(22, NULL, 14, '<p>qwrqwr</p>', '2023-08-02 04:35:42', '2023-08-02 04:35:42'),
(23, NULL, 14, '<p>sada</p>', '2023-08-02 04:35:49', '2023-08-02 04:35:49'),
(24, NULL, 14, '<p>wqqweqwe</p>', '2023-08-02 04:35:55', '2023-08-02 04:35:55'),
(25, NULL, 14, '<p>wqewqe</p>', '2023-08-02 04:35:59', '2023-08-02 04:35:59'),
(26, NULL, 14, '<p>wqewq</p>', '2023-08-02 04:36:04', '2023-08-02 04:36:04'),
(27, 1, 14, 'sad', '2023-08-02 04:59:14', '2023-08-02 04:59:14'),
(28, 1, 14, 'asd', '2023-08-02 04:59:16', '2023-08-02 04:59:16'),
(29, NULL, 14, '<p>qwewqe</p>', '2023-08-02 05:00:02', '2023-08-02 05:00:02'),
(30, 1, 14, 'sadasd', '2023-08-02 05:00:45', '2023-08-02 05:00:45'),
(31, 1, 14, 'as', '2023-08-02 05:00:49', '2023-08-02 05:00:49'),
(32, 1, 14, 'sadsad', '2023-08-02 05:01:05', '2023-08-02 05:01:05'),
(33, NULL, 14, '<p>sadasd</p>', '2023-08-02 05:01:18', '2023-08-02 05:01:18'),
(36, NULL, 15, '<p>This is a test</p>', '2023-08-03 12:21:29', '2023-08-03 12:21:29'),
(37, NULL, 15, '<p>Hello</p>', '2023-08-03 12:21:47', '2023-08-03 12:21:47'),
(38, 1, 15, 'aggasasg', '2023-08-03 12:22:11', '2023-08-03 12:22:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_06_11_101656_create_admins_table', 1),
(6, '2023_06_12_045319_create_languages_table', 1),
(7, '2023_06_12_045405_create_translations_table', 1),
(8, '2023_06_12_063444_create_settings_table', 1),
(9, '2023_06_13_130230_add_country_code_to_users_table', 1),
(10, '2023_06_14_055945_add_creator_to_admins_table', 1),
(11, '2023_06_15_053643_create_roles_table', 1),
(12, '2023_06_15_114919_add_role_id_to_admins_table', 1),
(13, '2023_06_15_124627_add_ltr_to_languages_table', 1),
(14, '2023_06_17_045913_add_name_column_to_admins_table', 1),
(15, '2023_06_25_110314_create_images_table', 1),
(16, '2023_06_26_201611_add_creator_to_users_table', 1),
(17, '2023_06_26_204759_create_faqs_table', 1),
(18, '2023_06_26_222520_create_clients_table', 1),
(19, '2023_06_26_223207_create_templates_table', 1),
(20, '2023_06_26_223307_create_payment_methods_table', 1),
(21, '2023_06_26_223423_create_pages_table', 1),
(22, '2023_06_26_223509_create_menus_table', 1),
(23, '2023_06_26_223616_create_contacts_table', 1),
(24, '2023_06_26_223703_create_subscribers_table', 1),
(25, '2023_07_09_110125_add_type_column_to_payment_methods_table', 2),
(26, '2023_07_09_110426_add_type_column_to_payment_methods_table', 3),
(27, '2023_07_10_002040_create_mailgateways_table', 4),
(28, '2023_07_10_155409_create_smsgateways_table', 4),
(29, '2023_07_10_161535_create_sms_gateways_table', 5),
(30, '2023_07_10_161751_create_mail_gateways_table', 5),
(31, '2023_07_11_161121_add_o_auth_id_to_users_table', 6),
(32, '2023_07_12_111808_create_otps_table', 7),
(33, '2023_07_14_171648_create_categories_table', 8),
(35, '2023_07_14_200955_create_articles_table', 10),
(36, '2023_07_14_205353_create_article_comments_table', 11),
(37, '2023_07_14_212912_create_packages_table', 11),
(38, '2023_07_16_174807_create_ctas_table', 11),
(39, '2023_07_16_191644_create_visitors_table', 12),
(40, '2023_07_17_120854_create_frontends_table', 13),
(41, '2023_07_19_190840_create_seos_table', 14),
(42, '2023_07_22_233150_create_notifications_table', 15),
(43, '2023_07_24_114753_create_links_table', 16),
(44, '2023_07_24_122051_create_link_reviews_table', 16),
(45, '2023_07_24_223152_create_packages_table', 17),
(46, '2023_07_25_134045_create_favourites_table', 18),
(47, '2023_07_25_134234_create_link_browsers_table', 18),
(48, '2023_07_27_144628_create_payment_logs_table', 19),
(49, '2023_07_27_144715_create_subscriptions_table', 19),
(50, '2023_07_27_144734_create_transactions_table', 19),
(51, '2023_07_28_185417_create_jobs_table', 20),
(52, '2023_07_30_183032_create_ads_table', 21),
(53, '2023_08_01_130142_create_tickets_table', 22),
(54, '2023_08_01_130712_create_messages_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `uid`, `user_id`, `admin_id`, `message`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'gLk3-qjv3kBXY-7RC2', NULL, NULL, 'Dorian Armstrong Just contacted you.', 'http://localhost/genLink/admin/contacts', '1', '2023-07-23 07:43:14', '2023-08-03 08:44:39'),
(2, 'wG69-EryA2VsU-V7A4', NULL, NULL, 'sad@gmail.com Just Subscribed', 'http://localhost/genLink/admin/subscribers', '1', '2023-07-23 07:46:59', '2023-08-03 08:44:39'),
(4, '4jpJ-UdXTT7zn-FAp0', NULL, NULL, 'Nafiz Khan has just commented on an article', 'http://localhost/genLink/admin/article/Qzcq-GfevXTyw-gZ60/comments', '1', '2023-07-23 07:51:04', '2023-08-03 08:44:39'),
(5, '7SA7-InVv7M6h-RcYy', NULL, NULL, 'sss@gmail.com Just Subscribed', 'http://localhost/genLink/admin/subscribers', '1', '2023-07-23 08:44:51', '2023-08-03 08:44:39'),
(6, '81fb-snCllWAz-fovl', NULL, NULL, 'Maisie Saunders Just contacted you.', 'http://localhost/genLink/admin/contacts', '1', '2023-07-23 08:50:12', '2023-08-03 08:44:39'),
(7, '7l7Z-KZjhaK8u-h4uY', NULL, NULL, 'Aphrodite Rodriquez Just contacted you.', 'http://localhost/genLink/admin/contacts', '1', '2023-07-23 08:50:18', '2023-08-03 08:44:39'),
(8, 'hpIW-adfmtN4Y-5Wd8', NULL, NULL, 'Nafiz Khan Just Reviewed Us', 'http://localhost/genLink/admin/client-review/list', '1', '2023-07-23 10:23:40', '2023-08-03 08:44:39'),
(9, 'wokj-JBgyWbdg-IWQ6', NULL, NULL, 'Max Just Reviewed Us', 'http://localhost/genLink/admin/client-review/list', '1', '2023-07-23 10:26:09', '2023-08-03 08:44:39'),
(10, '7DlZ-ARFiwufi-z0wd', NULL, NULL, 'Nafiz Khanxx Just Reviewed Us', 'http://localhost/genLink/admin/client-review/list', '1', '2023-07-23 10:26:55', '2023-08-03 08:44:39'),
(11, '6zIn-6tI2hGM2-gsPN', NULL, NULL, 'Nafiz Khassn Just Reviewed Us', 'http://localhost/genLink/admin/client-review/list', '1', '2023-07-23 10:27:08', '2023-08-03 08:44:39'),
(12, 'jpq2-oUuzgy3g-sE52', NULL, NULL, 'Nafiz Khan Just Reviewed A Link', 'http://localhost/genLink/admin/link/review/list', '1', '2023-07-25 15:35:44', '2023-08-03 08:44:39'),
(13, 'wLhE-weoivE4T-ITY2', NULL, NULL, 'Nafiz Khan Just Reviewed A Link', 'http://localhost/genLink/admin/link/review/list', '1', '2023-07-25 15:35:53', '2023-08-03 08:44:39'),
(14, '2MpB-BWnLIEmM-NXmq', NULL, NULL, 'Nafiz Khan Just Reviewed A Link', 'http://localhost/genLink/admin/link/review/list', '1', '2023-07-26 05:35:48', '2023-08-03 08:44:39'),
(15, 'P4o2-TVmf4bet-VzS6', NULL, NULL, 'Nafiz Khan Just Reviewed A Link', 'http://localhost/genLink/admin/link/review/list', '1', '2023-07-26 05:35:55', '2023-08-03 08:44:39'),
(16, 'WltY-3b3rn3Hu-pZp4', NULL, NULL, 'Nafiz Khan Just Reviewed A Link', 'http://localhost/genLink/admin/link/review/list', '1', '2023-07-26 05:43:46', '2023-08-03 08:44:39'),
(17, '9hHP-whrQiLim-6yaY', NULL, NULL, 'Nafiz Khan Just Reviewed A Link', 'http://localhost/genLink/admin/link/review/list', '1', '2023-07-26 06:21:46', '2023-08-03 08:44:39'),
(18, 'YlsO-jSxGoQfa-AFb1', NULL, NULL, 'Nafiz Khan has Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-07-29 05:38:42', '2023-08-03 08:44:39'),
(19, '6p7d-jCcxs8aW-KoYd', NULL, NULL, 'Nafiz Khan has Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-07-29 05:39:55', '2023-08-03 08:44:39'),
(20, 'EgWo-pv1CQNMi-3JM2', NULL, NULL, 'Nafiz Khan Just Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-07-29 05:43:20', '2023-08-03 08:44:39'),
(21, 'H22x-6Ta7f1g4-q7G7', NULL, NULL, 'Nafiz Khan Just Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-07-29 05:49:36', '2023-08-03 08:44:39'),
(22, '6fxD-E64pZij3-Q0b7', NULL, NULL, 'Nafiz Khan Just Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-07-29 05:53:48', '2023-08-03 08:44:39'),
(23, '9dUi-iRX06eCM-NLav', NULL, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/dolorum-voluptatem-q', '1', '2023-07-29 06:01:29', '2023-08-03 08:44:39'),
(24, 'xkbp-1jZOJeM8-44D1', 1, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/dolorum-voluptatem-q', '1', '2023-07-29 06:13:14', '2023-07-31 07:23:59'),
(25, '5hIB-Mu9tgsId-9eje', 1, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/dolorum-voluptatem-q', '1', '2023-07-29 06:19:52', '2023-07-31 07:23:59'),
(26, '1jsH-Ro70EuWI-4xRS', NULL, NULL, 'Nafiz Khan Just Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-07-29 06:33:07', '2023-08-03 08:44:39'),
(27, 'aiNC-R9tNQ1VX-aA34', 1, NULL, 'Your Subscription Status Has Been Updated!', 'http://localhost/genLink/user/subscription', '1', '2023-07-30 06:40:24', '2023-07-31 07:23:59'),
(28, '6lDk-RT4h36UM-aifI', 1, NULL, 'Your Latest Subscription Request Has Been Accepted!!', 'http://localhost/genLink/user/subscription', '1', '2023-07-30 08:00:09', '2023-07-31 07:23:59'),
(29, 'TWHS-SVjUEizr-8ye8', 1, NULL, 'Your Latest Subscription Request Has Been Accepted!!', 'http://localhost/genLink/user/subscription', '1', '2023-07-30 08:09:54', '2023-07-31 07:23:59'),
(30, '8E7i-viCMCJph-1EHQ', 1, NULL, 'SuperAdmin Just Approved Your Link', 'http://192.168.0.122/genLink/link/details/the-times', '1', '2023-07-31 06:19:55', '2023-07-31 07:23:59'),
(31, '4Tt2-1y8pjnbw-ue6b', NULL, NULL, 'Nafiz Khan Just Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-07-31 06:46:02', '2023-08-03 08:44:39'),
(32, 'jDeY-9k1i6q0v-Xox5', 1, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/foxurl', '1', '2023-07-31 06:46:31', '2023-07-31 07:23:59'),
(33, 'krGL-Crq7lRrw-Nwr5', NULL, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/store?64C8E9EC', '1', '2023-08-01 13:20:43', '2023-08-03 08:44:39'),
(34, '0FFG-sPq7v9I1-MRb0', NULL, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/store?64C8E9EC', '1', '2023-08-01 13:20:49', '2023-08-03 08:44:39'),
(35, 'Yerx-QeCNayBw-CPp7', NULL, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/store?64C8E9EC', '1', '2023-08-01 13:21:26', '2023-08-03 08:44:39'),
(36, 'Ghgm-03JRGvhY-7ue2', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/store?64C8E9EC', '1', '2023-08-01 13:21:53', '2023-08-03 08:44:39'),
(37, '6r8g-ZM5zFYvu-qDLN', NULL, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/store?64C8E9EC', '1', '2023-08-01 13:21:59', '2023-08-03 08:44:39'),
(38, 'd8Gf-F9LD8Dyy-EtI5', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/store?64C8E9EC', '1', '2023-08-02 04:35:38', '2023-08-03 08:44:39'),
(39, '5gR4-81wsTG16-McvR', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/store?64C8E9EC', '1', '2023-08-02 04:35:42', '2023-08-03 08:44:39'),
(40, '3Ges-zb4XvD6A-YEdO', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/store?64C8E9EC', '1', '2023-08-02 04:35:49', '2023-08-03 08:44:39'),
(41, 'RH2O-O3JmfZ5m-5vz1', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/store?64C8E9EC', '1', '2023-08-02 04:35:55', '2023-08-03 08:44:39'),
(42, '4KjS-yCSfr6p8-WuWR', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/store?64C8E9EC', '1', '2023-08-02 04:35:59', '2023-08-03 08:44:39'),
(43, 'NLi9-Jx7Afa5P-Ox57', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/store?64C8E9EC', '1', '2023-08-02 04:36:04', '2023-08-03 08:44:39'),
(44, 'Od0a-IgyxxX8K-VG95', 1, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/store?64C8E9EC', '1', '2023-08-02 04:59:14', '2023-08-02 04:59:45'),
(45, 'GVJ0-j7C6su2e-8Ee0', 1, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/store?64C8E9EC', '1', '2023-08-02 04:59:16', '2023-08-02 04:59:29'),
(46, '2eEE-o1fcztkz-ZLq1', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/store?64C8E9EC', '1', '2023-08-02 05:00:02', '2023-08-03 08:44:39'),
(47, 'dbFZ-5O3EaJka-AHn7', 1, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/64C8E9EC', '0', '2023-08-02 05:00:45', '2023-08-02 05:00:45'),
(48, 'mvco-HP2AX3SA-fcS5', 1, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/64C8E9EC', '0', '2023-08-02 05:00:49', '2023-08-02 05:00:49'),
(49, '0wmx-zrjuKZap-I9dd', 1, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/64C8E9EC', '1', '2023-08-02 05:01:05', '2023-08-02 05:01:13'),
(50, 'kDZy-kJtoLM2J-k0Y4', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/64C8E9EC', '1', '2023-08-02 05:01:18', '2023-08-03 08:44:39'),
(51, 'Aejl-jvi28qPQ-lOA3', NULL, NULL, 'Nafiz Khan Just Replied To A Ticket', 'http://localhost/genLink/admin/ticket/reply/64C8E9EC', '1', '2023-08-02 05:03:22', '2023-08-03 08:44:39'),
(52, '9g5T-e5A4lOiw-Wp2j', 1, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://localhost/genLink/user/ticket/reply/64C8E9EC', '0', '2023-08-02 05:51:46', '2023-08-02 05:51:46'),
(53, '66Qf-pl8XCZbw-8l8w', NULL, NULL, 'Nafiz Khan Just Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-08-02 09:38:52', '2023-08-03 08:44:39'),
(54, '4pc4-Xuqvdhwp-ZUuW', NULL, NULL, 'Nafiz Khan Just Reviewed A Link', 'http://localhost/genLink/admin/link/review/list', '1', '2023-08-02 09:58:10', '2023-08-03 08:44:39'),
(55, '3aDD-dp0DQbI2-5az4', NULL, NULL, 'Nafiz Khan Just Reviewed A Link', 'http://localhost/genLink/admin/link/review/list', '1', '2023-08-02 09:58:28', '2023-08-03 08:44:39'),
(56, 'EY1Q-l0bsufs5-jTx5', NULL, NULL, 'Nafiz Khan Just Created A Link', 'http://localhost/genLink/admin/link/list', '1', '2023-08-02 10:06:15', '2023-08-03 08:44:39'),
(57, '4NtU-6H6q3FFI-YWD4', 1, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/fox-sports', '0', '2023-08-02 11:43:26', '2023-08-02 11:43:26'),
(58, 'Sc3F-8NwDyw3u-sIP8', 26, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/the-times', '0', '2023-08-02 11:43:28', '2023-08-02 11:43:28'),
(59, 'errO-TU8fKZZe-mQu8', 1, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/fox-sports', '1', '2023-08-02 11:43:29', '2023-08-02 12:20:05'),
(60, 'jNI3-odNHsSoP-OmD7', 26, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/spacex', '0', '2023-08-02 11:43:31', '2023-08-02 11:43:31'),
(61, 'y2ZF-gYWJVUwR-aXH7', 26, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/starlink', '0', '2023-08-02 11:43:34', '2023-08-02 11:43:34'),
(62, 'qtRC-1r4r7DJx-mrl1', 26, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/fifa', '0', '2023-08-02 11:43:36', '2023-08-02 11:43:36'),
(63, '8aJ0-DQm9Euzk-m66c', 26, NULL, 'SuperAdmin Just Approved Your Link', 'http://localhost/genLink/link/details/fifa', '0', '2023-08-02 11:43:37', '2023-08-02 11:43:37'),
(64, 'AfxD-rvpjocss-AHT0', NULL, NULL, 'Nafiz Khan Just Request For A Subscription', 'http://localhost/genLink/admin/payment/logs', '1', '2023-08-03 05:43:11', '2023-08-03 08:44:39'),
(65, '4irB-mwbFuIfg-NU4q', NULL, NULL, 'Nafiz Khan Just Purchase A New Plan', 'http://localhost/genLink/admin/subscription/logs', '1', '2023-08-03 08:53:32', '2023-08-03 08:53:40'),
(66, 'NDFk-yKlftXDd-S6i2', 1, NULL, 'Your Running Subscription Is Expired !!', 'http://localhost/genLink/user/subscription', '0', '2023-08-03 10:54:15', '2023-08-03 10:54:15'),
(67, '7W1f-FcIFn10a-4C1c', 26, NULL, 'Experiment Just Approved Your Link', 'http://192.168.0.122/genLink/details/fifa', '0', '2023-08-03 11:39:59', '2023-08-03 11:39:59'),
(68, 'prKY-3qDbRjxj-fcG2', NULL, NULL, 'Nafiz Khan Just Purchase A New Plan', 'http://localhost/genLink/admin/subscription/logs', '1', '2023-08-03 11:45:03', '2023-08-03 11:46:09'),
(69, '3e2G-5hKoheSt-jsfw', NULL, NULL, 'Experiment Just Purchase A New Plan', 'http://192.168.0.122/genLink/admin/subscription/logs', '0', '2023-08-03 12:08:41', '2023-08-03 12:08:41'),
(70, '1djM-e7mqpPRv-viUZ', NULL, NULL, 'Experiment Just Had A New Subscription Plan', 'http://192.168.0.122/genLink/admin/subscription/logs', '0', '2023-08-03 12:08:41', '2023-08-03 12:08:41'),
(71, 'BPqx-CB9BXXI8-uaH3', NULL, NULL, 'Experiment Just Created A Link', 'http://192.168.0.122/genLink/admin/link/list', '0', '2023-08-03 12:11:39', '2023-08-03 12:11:39'),
(72, '4WdJ-lFKrqrKQ-xJiN', NULL, NULL, 'Experiment Just Created A Link', 'http://localhost/genLink/admin/link/list', '0', '2023-08-03 12:17:50', '2023-08-03 12:17:50'),
(73, '0wP4-ixP4jtwc-Wj4j', NULL, NULL, 'Experiment Just Created A Link', 'http://192.168.0.122/genLink/admin/link/list', '0', '2023-08-03 12:18:42', '2023-08-03 12:18:42'),
(74, 'csE0-G1Bp5pVW-OrN8', NULL, NULL, 'Experiment Just Create A ', 'http://192.168.0.122/genLink/admin/ticket/reply/store?64CB9BC9', '0', '2023-08-03 12:21:29', '2023-08-03 12:21:29'),
(75, '8zoa-FWfY34ER-bbMA', NULL, NULL, 'Experiment Just Replied To a Ticket', 'http://192.168.0.122/genLink/admin/ticket/reply/64CB9BC9', '1', '2023-08-03 12:21:47', '2023-08-03 12:55:35'),
(76, '7OUb-7ZvRCE6w-YjQj', 37, NULL, 'SuperAdmin Just Replied To A Ticket', 'http://192.168.0.122/genLink/user/ticket/reply/64CB9BC9', '1', '2023-08-03 12:22:11', '2023-08-03 12:22:30'),
(77, '7cjl-oLO8GFwD-6N39', NULL, NULL, 'Experiment has just commented on an article', 'http://localhost/genLink/admin/article/toTf-6Do32b3n-x7S0/comments', '1', '2023-08-03 12:38:51', '2023-08-03 12:41:46');

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint UNSIGNED NOT NULL,
  `otpable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otpable_id` bigint UNSIGNED NOT NULL,
  `otp` text COLLATE utf8mb4_unicode_ci,
  `type` text COLLATE utf8mb4_unicode_ci,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(20,2) NOT NULL DEFAULT '0.00',
  `discount_price` double(20,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `deep_links` bigint NOT NULL DEFAULT '0',
  `link_expires_in` bigint DEFAULT NULL,
  `links_per_day` bigint NOT NULL DEFAULT '0',
  `bypass_details_page` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `allow_contact` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `allow_address` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `changing_visible_url` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `show_verified` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `allow_link_attribute` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `feature_on_home` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Inactive : 0',
  `recommended` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `qr_code` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `uid`, `created_by`, `updated_by`, `title`, `duration`, `price`, `discount_price`, `description`, `deep_links`, `link_expires_in`, `links_per_day`, `bypass_details_page`, `allow_contact`, `allow_address`, `changing_visible_url`, `show_verified`, `allow_link_attribute`, `feature_on_home`, `status`, `recommended`, `qr_code`, `created_at`, `updated_at`) VALUES
(2, '64zH-9p049XxV-QKoo', 1, 1, 'Free', 'WEEKLY', 0.00, 0.00, 'Free Package', 2, 2, 2, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2023-07-26 14:52:39', '2023-07-29 07:36:52'),
(3, 'qL3d-242ZZpBv-IN18', 1, 1, 'Premimum', 'UNLIMITED', 1.00, 1.00, 'Premimum package', 5, 4, 15, '1', '1', '0', '1', '1', '1', '1', '1', '0', '1', '2023-07-26 14:57:47', '2023-07-30 16:55:12'),
(4, 'feMl-5PZMLIHc-vfF8', 1, NULL, 'Demo Package', 'MONTHLY', 1320000.00, 23900.00, 'Demo Package', 3, 5, 288, '1', '1', '0', '1', '1', '1', '1', '1', '0', '0', '2023-07-26 15:59:20', '2023-08-03 11:08:24');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_id` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` longtext COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `show_in_header` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes: 1,No: 0',
  `show_in_footer` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes: 1,No: 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `uid`, `serial_id`, `created_by`, `updated_by`, `title`, `slug`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `show_in_header`, `show_in_footer`, `created_at`, `updated_at`) VALUES
(5, 'cftD-gUr077dB-4L26', 62, 1, NULL, '{\"en\":\"Terms & Condition\",\"al\":\"xxxx\",\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"terms-&-condition\",\"al\":\"xxxx\",\"bj\":\"\",\"dz\":\"\",\"bh\":\"\"}', '{\"en\":\"<ol><li style=\\\"text-align: justify;\\\"><strong><span style=\\\"font-size:\\r\\n15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;mso-ascii-theme-font:\\r\\nminor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;mso-border-alt:\\r\\nsolid #D9D9E3 .25pt;padding:0in\\\">Terms and Conditions of Use<\\/span><\\/strong><\\/li><li style=\\\"text-align: justify;\\\"><strong><span style=\\\"font-size:\\r\\n15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;mso-ascii-theme-font:\\r\\nminor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;mso-border-alt:\\r\\nsolid #D9D9E3 .25pt;padding:0in\\\"><br><\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"><o:p><\\/o:p><\\/span><\\/li><\\/ol><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">1. Introduction<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> Welcome to Quick<\\/span><span style=\\\"color: black; font-size: 15pt; background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">Pack (\\\"the Website\\\"), owned and operated by [Your Company Name].<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\">These Terms and Conditions (\\\"Terms\\\") govern your access and use of the Website. By using our services, you agree to comply with these Terms and our Privacy Policy. If you disagree with any part of these Terms, please\\r\\nrefrain from using the Website.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">2. Eligibility<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> By accessing and using the Website, you represent and warrant that you are at least 18 years\\r\\nold and have the legal capacity to enter into these Terms. If you are accessing the Website on behalf of a company or entity, you further warrant that you have the authority to bind that entity to these Terms.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">3. User Accounts<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 3.1. To access certain features and services on the Website, you may be required to\\r\\ncreate a user account. You agree to provide accurate and complete information during the registration process and to keep your account credentials secure.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">3.2. You are solely responsible for all activities that occur under your account. Notify us immediately of any unauthorized use or security breach related to your account.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">4. Website Content<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 4.1. The Website allows users to organize and manage website resources, articles, links, tags, and related content (\\\"User Content\\\").<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">4.2. By submitting User Content, you grant us a non-exclusive, worldwide, royalty-free, sub licensable, and transferable license to use, reproduce, distribute, display, and perform the User Content in connection with the operation of the Website and our business.<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\"><o:p><br><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\"><o:p><br><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">4.3. You are solely responsible for the User Content you submit. You warrant that you own or have the necessary rights, licenses, or permissions to grant the aforementioned license.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">4.4. We reserve the right to remove, modify, or refuse any User Content that violates these Terms or our policies, infringes on third-party rights, or is otherwise inappropriate.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">5. Intellectual Property<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 5.1. The Website and its content, including but not limited to text, graphics, logos, icons, images, software, audio, and video clips, are the property of [Your Company Name] and protected by applicable intellectual property laws.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">5.2. You may not use, reproduce, distribute, modify, display, or create derivative works of any part of the Website or its content without our explicit written permission.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">6. Third-Party Websites and Content<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;\\r\\nmso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;\\r\\nmso-themecolor:text1\\\"> 6.1. The Website may contain links to third-party websites, products, or services (\\\"Third-Party Content\\\"). We do not endorse or assume any responsibility for Third-Party Content, and your access to and use of such content are entirely at your own risk.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">6.2. We are not liable for any damages or losses resulting from your interaction with Third-Party Content.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">7. Prohibited Conduct<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 7.1. You agree not to engage in any of the following prohibited activities while using the Website: a. Violating any applicable laws, regulations, or third-party rights. b. Uploading or sharing content that is illegal, defamatory, harmful, obscene, or otherwise objectionable. c. Impersonating any person or entity or providing false information. d. Engaging in any activity that could disable, overburden, or impair the Website\'s proper functioning. e. Using any automated means, such as bots or scripts, to access or interact with the Website. Attempting to gain unauthorized access to any part of the Website or its systems.<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"><o:p><br><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"><o:p><br><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">8. Subscription Plans and Payments<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;\\r\\nmso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;color:black;\\r\\nmso-themecolor:text1\\\"> 8.1. We offer different subscription plans with varying features and benefits. By subscribing to a plan, you agree to pay the applicable fees as outlined on the Website.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">8.2. Payments will be processed through third-party payment processors. You agree to comply with their terms and conditions.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">8.3. We reserve the right to modify the subscription plans, fees, and payment methods. Any changes will be communicated to you through the Website or email.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">9. Termination<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 9.1. We reserve the right to suspend, restrict, or terminate your access to the Website at any time and for any reason, without notice or liability.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">9.2. Upon termination, your user account and any associated data may be permanently deleted from our systems.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">10. Disclaimer of Warranties<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 10.1. The Website is provided \\\"as is,\\\" without warranties of any kind, whether express or implied. We do not warrant that the Website will be error-free, secure, or uninterrupted.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">10.2. We make no representations or guarantees regarding the accuracy, completeness, or reliability of any content on the Website.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">11. Limitation of Liability<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 11.1. To the fullest extent permitted by applicable law, we shall not be liable for any direct, indirect, incidental, special, consequential, or exemplary damages, including but not limited to damages for loss of profits, goodwill, data, or other intangible losses, resulting from your use of the Website or any content therein.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">12. Indemnification<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 12.1. You agree to indemnify and hold [Your Company Name], its affiliates, officers, directors, employees, and agents harmless from any claims, losses, liabilities, damages, costs, or expenses, including reasonable attorneys\' fees, arising out of or related to your use of the Website, violation of these Terms, or infringement of any rights of a third party.<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"><o:p><br><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"><o:p><br><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">13. Modifications<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 13.1. We reserve the right to update or modify these Terms at any time, without notice. The latest version of the Terms will be posted on the Website, and your continued use of the Website constitutes acceptance of any changes.<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">14. Governing Law and Jurisdiction<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 14.1. These Terms shall be governed by and construed in accordance with the laws of [Your Jurisdiction]. Any dispute arising under or in connection with these Terms shall be subject to the exclusive jurisdiction of the courts of [Your Jurisdiction].<o:p><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"text-align:justify\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\">\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n<\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\"Calibri\\\",sans-serif;\\r\\nmso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:\\r\\nminor-latin;color:black;mso-themecolor:text1;border:solid #D9D9E3 1.0pt;\\r\\nmso-border-alt:solid #D9D9E3 .25pt;padding:0in\\\">15. Contact Information<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> 15.1. If you have any questions or concerns regarding these Terms or the Website, you may contact us at  <\\/span><span style=\\\"font-size: 15pt; line-height: 107%; color: black; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\\\">quickpack@gmail.com<\\/span><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\"><o:p><\\/o:p><\\/span><\\/p>\",\"al\":\"<p>Home\\r\\nPages\\r\\nCreate<\\/p><ol class=\\\"breadcrumb m-0\\\" style=\\\"box-sizing: border-box; margin: 0px !important; padding: var(--bs-breadcrumb-padding-y) var(--bs-breadcrumb-padding-x); outline: 0px; list-style: none; --bs-breadcrumb-padding-x: 0; --bs-breadcrumb-padding-y: 0; --bs-breadcrumb-margin-bottom: 1rem; --bs-breadcrumb-bg: ; --bs-breadcrumb-border-radius: ; --bs-breadcrumb-divider-color: var(--bs-secondary-color); --bs-breadcrumb-item-padding-x: 0.5rem; --bs-breadcrumb-item-active-color: var(--bs-secondary-color); display: flex; flex-wrap: wrap; font-size: 15px; background-color: rgb(243, 243, 249); border-radius: var(--bs-breadcrumb-border-radius); color: rgb(119, 119, 119); font-family: system-ui, -apple-system, \\\" segoe=\\\"\\\" ui\\\",=\\\"\\\" roboto,=\\\"\\\" \\\"helvetica=\\\"\\\" neue\\\",=\\\"\\\" \\\"noto=\\\"\\\" sans\\\",=\\\"\\\" \\\"liberation=\\\"\\\" arial,=\\\"\\\" sans-serif,=\\\"\\\" \\\"apple=\\\"\\\" color=\\\"\\\" emoji\\\",=\\\"\\\" \\\"segoe=\\\"\\\" ui=\\\"\\\" symbol\\\",=\\\"\\\" emoji\\\";=\\\"\\\" font-style:=\\\"\\\" normal;=\\\"\\\" font-variant-ligatures:=\\\"\\\" font-variant-caps:=\\\"\\\" font-weight:=\\\"\\\" 400;=\\\"\\\" letter-spacing:=\\\"\\\" orphans:=\\\"\\\" 2;=\\\"\\\" text-align:=\\\"\\\" start;=\\\"\\\" text-indent:=\\\"\\\" 0px;=\\\"\\\" text-transform:=\\\"\\\" none;=\\\"\\\" widows:=\\\"\\\" word-spacing:=\\\"\\\" -webkit-text-stroke-width:=\\\"\\\" white-space:=\\\"\\\" text-decoration-thickness:=\\\"\\\" initial;=\\\"\\\" text-decoration-style:=\\\"\\\" text-decoration-color:=\\\"\\\" initial;\\\"=\\\"\\\"><li class=\\\"breadcrumb-item active\\\" style=\\\"box-sizing: border-box; margin: 0px; padding: 0px; outline: 0px; list-style-type: none; color: var(--text-secondary); font-size: 14px; line-height: 1;\\\"><a href=\\\"http:\\/\\/localhost\\/genLink\\/admin\\/dashboard\\\" style=\\\"box-sizing: border-box; margin: 0px; padding: 0px; outline: 0px; color: var(--text-primary); text-decoration: none; line-height: 1;\\\">Home<\\/a><\\/li><li class=\\\"breadcrumb-item active\\\" style=\\\"box-sizing: border-box; margin: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: var(--bs-breadcrumb-item-padding-x); outline: 0px; list-style-type: none; color: var(--text-secondary); font-size: 14px; line-height: 1;\\\"><a href=\\\"http:\\/\\/localhost\\/genLink\\/admin\\/page\\/list\\\" style=\\\"box-sizing: border-box; margin: 0px; padding: 0px; outline: 0px; color: var(--text-primary); text-decoration: none; --bs-link-color-rgb: var(--bs-link-hover-color-rgb); line-height: 1;\\\">Pages<\\/a><\\/li><li class=\\\"breadcrumb-item \\\" style=\\\"box-sizing: border-box; margin: 0px; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: var(--bs-breadcrumb-item-padding-x); outline: 0px; list-style-type: none; font-size: 14px; line-height: 1; color: var(--text-secondary);\\\">Createxxxx<\\/li><\\/ol><p><br><\\/p>\",\"bj\":\"<p>Basic Information<\\/p><h4 class=\\\"card-title\\\" style=\\\"box-sizing: border-box; margin-top: 0px; margin-right: 0px; margin-bottom: var(--bs-card-title-spacer-y); margin-left: 0px; padding: 0px; outline: 0px; font-weight: 500; line-height: 1.2; color: var(--text-primary); font-size: 18px; font-family: system-ui, -apple-system, \\\"Segoe UI\\\", Roboto, \\\"Helvetica Neue\\\", \\\"Noto Sans\\\", \\\"Liberation Sans\\\", Arial, sans-serif, \\\"Apple Color Emoji\\\", \\\"Segoe UI Emoji\\\", \\\"Segoe UI Symbol\\\", \\\"Noto Color Emoji\\\"; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\\\">Basic Information<\\/h4>\",\"dz\":null,\"bh\":null}', '{\"en\":\"Quick Pack- Organize Websites, Tags, Links, and Articles | [Your Website URL]\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Simplify your online life with [Your Website Name]. Organize and manage websites, tags, links, and articles effortlessly. Deep link capability and tailored subscription packs available. Join now!\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"Website organization\",\"Website management\",\"Tags and links organizer\",\"Article creation\",\"Deep link capability\",\"Subscription packs\",\"Simplify online life\",\"Website resources management\",\"User-friendly interface\"]', '1', '1', '1', '2023-07-17 05:53:24', '2023-07-31 11:40:21');
INSERT INTO `pages` (`id`, `uid`, `serial_id`, `created_by`, `updated_by`, `title`, `slug`, `description`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `show_in_header`, `show_in_footer`, `created_at`, `updated_at`) VALUES
(6, '4BjW-jjCFevZi-oH6q', 98, 1, 1, '{\"en\":\"About\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"about\",\"al\":\"\",\"bj\":\"\",\"dz\":\"\",\"bh\":\"\"}', '{\"en\":\"<p class=\\\"MsoNormal\\\"><span style=\\\"color: rgb(0, 0, 0); font-size: 20px;\\\">Are you tired of managing multiple websites, tags, and links scattered all over the internet? Do you wish there was a simple and efficient way to organize and access all your favorite online resources in one place? Look no further! Quick Pack is the perfect solution for individuals, professionals, and businesses seeking a comprehensive website organization platform.<\\/span><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"color: rgb(0, 0, 0); font-size: 20px;\\\"><br><\\/span><\\/p><p class=\\\"MsoNormal\\\"><strong><span style=\\\"font-size:15.0pt;line-height:107%;\\r\\nfont-family:\\\" calibri\\\",sans-serif;mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:=\\\"\\\" minor-latin;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;=\\\"\\\" border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">Welcome\\r\\nto Quick Pack- Your Ultimate Website Organization Platform!<\\/span><\\/strong><o:p><\\/o:p><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><o:p>&nbsp;<\\/o:p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:\\r\\nCalibri;mso-bidi-theme-font:minor-latin\\\">We empower users to unravel the vast\\r\\ndigital landscape through efficient organization and seamless exploration. Our\\r\\njourney began with a simple yet powerful vision: to provide a comprehensive\\r\\nsolution for individuals and businesses seeking to navigate the internet with\\r\\nease and purpose. We understood that the internet can be a labyrinth of\\r\\ninformation, and finding the right websites, tags, and links can be\\r\\noverwhelming. Hence, we set out to create a user-centric hub that streamlines\\r\\nthe process, allowing you to access, organize, and manage websites\\r\\neffortlessly.<\\/span><\\/p><p class=\\\"MsoNormal\\\"><br><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\">Our story started with a passionate team of tech enthusiasts and web aficionados who recognized the untapped potential of a centralized web organization tool. Armed with a desire to revolutionize web browsing and the pursuit of knowledge, we embarked on an exciting adventure to build a platform that transcends conventional bookmarking and takes internet exploration to new heights.<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><br><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">Through <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">meticulous planning and tireless development, we crafted a user-friendly <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">interface that would be both intuitive for newcomers and customizable for <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">seasoned users. At the heart of our platform lies a powerful tagging system <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">that empowers you to categorize and label websites according to your interests, <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">professional needs, or personal preferences. Gone are the days of sifting <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">through a sea of bookmarks; now, you can effortlessly find the most relevant <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">websites with just a few clicks.<\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\"><br><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\">We believe in the beauty of simplicity, which is why we designed our platform to be versatile yet elegantly straight forward. You can effortlessly add, remove, and rearrange bookmarks in your personalized folders, all while having a delightful visual representation of each website for a quick glance. Say goodbye to chaos and welcome seamless organization.<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\"><br><\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">One <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">of our core principles is inclusivity. Our platform caters to individuals from <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">all walks of life - students, researchers, creatives, entrepreneurs, and anyone <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">with a curiosity for the web. We firmly believe that knowledge should be <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">accessible to all, and our platform serves as a bridge between you and a <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">universe of information.<\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\">As we embarked on this venture, we knew that building a sustainable online community was essential. That\'s why we foster a sense of belonging through user accounts and profiles, enabling you to curate your own digital identity and build a network of like-minded individuals. Collaboration is the cornerstone of progress, and together, we create a collective knowledge pool that benefits everyone.<o:p><\\/o:p><\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\"><br><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\">We understand the importance of security and privacy in today\'s digital age. Rest assured, our commitment to safeguarding your data is unwavering. We employ cutting-edge security measures to protect your information, so you can focus on exploring the web without a worry.<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\"><br><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">But <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">our journey doesn\'t end here. We\'re continually evolving and innovating to meet <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">your evolving needs. Our dedicated team tirelessly gathers user feedback and <\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">suggestions, using them as guiding stars to steer us toward a brighter future. The horizon of possibilities stretches before us, and we invite you to be a part of our ongoing tale. <\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\"><br><\\/span><span style=\\\"font-size: 15pt; color: var(--text-secondary); background-color: var(--card-bg); font-family: var(--font-primary); text-align: var(--bs-body-text-align);\\\">In this ever-expanding universe of information, we are your navigational compass. Join us on this odyssey as we embark on a quest to make the web an organized and enriching experience for all. Together, we\'ll redefine the way we interact with the digital realm and unlock the true potential of the internet.<\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:\\r\\nCalibri;mso-bidi-theme-font:minor-latin\\\">&nbsp;<\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:black;mso-themecolor:text1;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;=\\\"\\\" mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">Simplify Your Online Life:<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin\\\"> At <span style=\\\"color:black;mso-themecolor:\\r\\ntext1\\\">Quick Pack, <\\/span>we understand the challenges of navigating the vast internet landscape. Our platform empowers you to centralize your website collection, tags, links, and articles, making it effortless to find, manage, and share your online resources. Whether you\'re a student, a researcher, a marketer, or simply an avid internet user, our user-friendly interface will transform your online experience.<o:p><\\/o:p><\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:\\r\\nCalibri;mso-bidi-theme-font:minor-latin\\\">&nbsp;<\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:black;mso-themecolor:text1;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;=\\\"\\\" mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">Create and Organize Articles with Ease:<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;\\r\\nmso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\"> With <span style=\\\"color:black;mso-themecolor:text1\\\">Quick Pack <\\/span>\'s powerful admin panel, you can effortlessly create and publish articles. Whether you\'re running a blog, an online magazine, or a knowledge-sharing platform, our article\\r\\ncreation tool is designed to cater to your needs. We offer various metrics and analytics based on different user subscription packs, providing you with valuable insights into your content\'s performance and engagement.<o:p><\\/o:p><\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:\\r\\nCalibri;mso-bidi-theme-font:minor-latin\\\">&nbsp;<\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:black;mso-themecolor:text1;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;=\\\"\\\" mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">Tailored Subscription Packs:<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin\\\"> We understand that different users have unique requirements. That\'s why we offer a range of subscription packs to suit your specific needs. Whether you\'re an individual user, a small business, or a large enterprise, we have the perfect plan for you. Unlock advanced features, enhanced analytics, and additional customization options with our premium subscription packs.<o:p><\\/o:p><\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:\\r\\nCalibri;mso-bidi-theme-font:minor-latin\\\">&nbsp;<\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:black;mso-themecolor:text1;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;=\\\"\\\" mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">Empowering Link Features with Deep Link Capability:<\\/span><\\/strong><strong><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;font-family:\\\" calibri\\\",sans-serif;mso-ascii-theme-font:minor-latin;=\\\"\\\" mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-latin;color:#d1d5db;=\\\"\\\" border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\"> <\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin\\\">&nbsp;Our innovative link features allow you to organize, categorize, and store your favorite websites efficiently. With deep link capability, you can dive directly into specific sections or pages within a website, saving you valuable time and effort. Say goodbye to endless searching and bookmark clutter - with <span style=\\\"color:black;mso-themecolor:text1\\\">Quick Pack<\\/span>, you\'ll experience a seamless browsing experience like never before.<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><br><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:black;mso-themecolor:text1;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;=\\\"\\\" mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">Collaborate and Share with Ease:<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> <\\/span><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin\\\">Collaboration is at the core of <span style=\\\"color:black;mso-themecolor:text1\\\">Quick Pack<\\/span>. Whether you\'re working on a group project, managing a team, or collaborating with clients, our platform enables seamless sharing and organizing of website resources. With our built-in sharing options, you can easily invite others to view, edit, or comment on your collections, fostering efficient teamwork and knowledge sharing.<o:p><\\/o:p><\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:\\r\\nCalibri;mso-bidi-theme-font:minor-latin\\\">&nbsp;<\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:black;mso-themecolor:text1;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;=\\\"\\\" mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">Privacy and Security<\\/span><\\/strong><strong><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:#d1d5db;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;mso-border-alt:solid=\\\"\\\" .25pt;=\\\"\\\" padding:0in\\\"=\\\"\\\">:<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;\\r\\nmso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\"> We take the security and privacy of our users seriously. Your data is protected using state-of-the-art encryption and security protocols, ensuring that your valuable information is safe from unauthorized access. Additionally, we provide customizable privacy settings, allowing you to control who can view and interact with your shared collections.<o:p><\\/o:p><\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:black;mso-themecolor:text1;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;=\\\"\\\" mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\"><br><\\/span><\\/strong><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:15.0pt;line-height:107%;font-family:\\\" calibri\\\",sans-serif;=\\\"\\\" mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:=\\\"\\\" minor-latin;color:black;mso-themecolor:text1;border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;=\\\"\\\" mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">24\\/7 Customer Support:<\\/span><\\/strong><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1\\\"> <\\/span><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin\\\">At <span style=\\\"color:black;mso-themecolor:\\r\\ntext1\\\">Quick Pack<\\/span>, we believe in delivering exceptional user experiences. Our dedicated customer support team is available round the clock to address any queries, concerns, or technical issues you may encounter. Feel confident knowing that you have a reliable support system to rely on whenever you need assistance.<\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><span style=\\\"font-size:15.0pt;line-height:107%;mso-bidi-font-family:Calibri;\\r\\nmso-bidi-theme-font:minor-latin\\\"><o:p><br><\\/o:p><\\/span><\\/p><p class=\\\"MsoNormal\\\" style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; white-space-collapse: preserve;\\\"><strong style=\\\"--tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(69,89,164,.5); --tw-ring-offset-shadow: 0 0 transparent; --tw-ring-shadow: 0 0 transparent; --tw-shadow: 0 0 transparent; --tw-shadow-colored: 0 0 transparent; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; color: var(--tw-prose-bold);\\\"><span style=\\\"font-size:16.0pt;mso-bidi-font-size:15.0pt;line-height:107%;font-family:\\r\\n\\\" calibri\\\",sans-serif;mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:=\\\"\\\" minor-latin;mso-bidi-theme-font:minor-latin;color:black;mso-themecolor:text1;=\\\"\\\" border:solid=\\\"\\\" #d9d9e3=\\\"\\\" 1.0pt;mso-border-alt:solid=\\\"\\\" .25pt;padding:0in\\\"=\\\"\\\">Join Us Today,<\\/span><\\/strong><span style=\\\"font-size:16.0pt;mso-bidi-font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin;\\r\\ncolor:black;mso-themecolor:text1\\\"> <\\/span><span style=\\\"font-size:15.0pt;\\r\\nline-height:107%;mso-bidi-font-family:Calibri;mso-bidi-theme-font:minor-latin\\\">Don\'t let the chaos of the internet overwhelm you. Embrace the simplicity, efficiency, and organization that <span style=\\\"color:black;mso-themecolor:text1\\\">Quick Pack<\\/span> offers. Join us today and experience the convenience of having all your favorite websites, tags, links, and articles at your fingertips. Take control of your online life with <span style=\\\"color:black;mso-themecolor:text1\\\">Quick Pack!<\\/span><o:p><\\/o:p><\\/span><\\/p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span style=\\\"font-size:15.0pt;line-height:107%\\\">Thank you\\r\\nfor being a part of our journey. Let\'s organize the web, one click at a time<\\/span><\\/p><p><\\/p>\",\"al\":null,\"bj\":\"About<ol><li><\\/li><li><strike><sup><\\/sup><\\/strike><\\/li><\\/ol>\",\"dz\":null,\"bh\":null}', '{\"en\":\"About\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"Discover a revolutionary platform that empowers users to effortlessly organize and explore the vast web. Seamlessly manage websites, tags, and links with our user-friendly interface and powerful tagging system. Join us on a journey to redefine internet browsing, fostering a community of knowledge seekers while prioritizing security and privacy. Unleash the true potential of the internet with our innovative web organization tool.\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"about\",\"quick pack\",\"Web organization\",\"Website management\",\"Tags and links\",\"Internet browsing\",\"Bookmarking\",\"Web exploration\",\"User-friendly interface\",\"Tagging system\",\"Website categorization\",\"Online community\",\"Knowledge seekers\",\"Internet navigation\",\"Digital identity\",\"Data security\",\"Privacy protection\",\"Web innovation\",\"Seamless browsing\",\"Web discovery\",\"Internet optimization\",\"Digital revolution\"]', '1', '1', '1', '2023-07-18 16:55:44', '2023-07-31 11:26:50');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `method_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `charge` double(8,2) DEFAULT NULL,
  `rate` double(8,2) DEFAULT NULL,
  `final_amount` double(8,2) DEFAULT NULL,
  `transaction` text COLLATE utf8mb4_unicode_ci,
  `custom_data` text COLLATE utf8mb4_unicode_ci,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Complete : 1,Pending : 0,Cancel : 2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_logs`
--

INSERT INTO `payment_logs` (`id`, `user_id`, `method_id`, `package_id`, `amount`, `charge`, `rate`, `final_amount`, `transaction`, `custom_data`, `feedback`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 3, 3, 25.00, 11.00, 10.00, 360.00, '1R6NPJ983T48', NULL, NULL, '0', '2023-07-27 10:23:24', '2023-07-27 10:23:24'),
(4, 1, 3, 3, 25.00, 11.00, 10.00, 360.00, 'SGKY824FCCBT', NULL, NULL, '0', '2023-07-27 10:25:00', '2023-07-27 10:25:00'),
(5, 1, 21, 3, 25.00, 1.00, 1.10, 29.00, 'YWMVFNAWABVC', NULL, NULL, '0', '2023-07-27 11:03:55', '2023-07-27 11:03:55'),
(6, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, 'T7NJZ37VJZ44', '{\"name\":{\"field_name\":\"Stephanie Osborn\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (858) 506-1461\",\"type\":\"text\"},\"address\":{\"field_name\":\"Nihil aut asperiores\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c25ac431bae1690458820.jpg\",\"type\":\"file\"}}', 'xasd', '0', '2023-07-27 11:04:52', '2023-08-01 06:50:06'),
(7, 1, 3, 4, 23.00, 10.00, 10.00, 330.00, '4KOXRQ6QCVSE', NULL, NULL, '0', '2023-07-27 11:56:08', '2023-07-27 11:56:08'),
(8, 1, 3, 3, 25.00, 11.00, 10.00, 360.00, '32YDHKMZAQHK', NULL, NULL, '0', '2023-07-27 12:41:52', '2023-07-27 12:41:52'),
(9, 1, 3, 3, 25.00, 11.00, 10.00, 360.00, 'YP1WCTNVCO3B', NULL, NULL, '0', '2023-07-27 12:45:52', '2023-07-27 12:45:52'),
(10, 1, 3, 3, 25.00, 11.00, 10.00, 360.00, '1F5PZDQQPF2J', NULL, NULL, '0', '2023-07-27 12:46:18', '2023-07-27 12:46:18'),
(11, 1, 3, 3, 25.00, 11.00, 10.00, 360.00, 'K2HTWCBDO4OW', NULL, NULL, '0', '2023-07-27 12:48:00', '2023-07-27 12:48:00'),
(12, 1, 3, 2, 0.00, 10.00, 10.00, 100.00, '3G33MY951AOC', NULL, NULL, '0', '2023-07-27 13:14:03', '2023-07-27 13:14:03'),
(13, 1, 3, 3, 25.00, 11.00, 10.00, 360.00, '75YU9FJVJ8QV', NULL, NULL, '0', '2023-07-29 09:10:35', '2023-07-29 09:10:35'),
(14, 1, 21, 3, 25.00, 1.00, 1.10, 29.00, 'J53VJ84F2P1N', NULL, NULL, '0', '2023-07-29 11:59:55', '2023-07-29 11:59:55'),
(15, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, 'VQS6XVEQAEHP', '{\"name\":{\"field_name\":\"Roanna Gordon\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (782) 599-1186\",\"type\":\"text\"},\"address\":{\"field_name\":\"Quos ut amet dolore\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c4ffdb8baf01690632155.jpg\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64c4ffdbc22b81690632155.jpg\",\"type\":\"file\"}}', NULL, '0', '2023-07-29 12:00:53', '2023-07-29 12:02:35'),
(16, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, 'YHFAWB5F7NPS', '{\"name\":{\"field_name\":\"Aileen Vinson\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (593) 651-7106\",\"type\":\"text\"},\"address\":{\"field_name\":\"Veniam magnam itaqu\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c5008ecb0ba1690632334.jpg\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64c5008ed06261690632334.jpg\",\"type\":\"file\"}}', NULL, '0', '2023-07-29 12:05:13', '2023-07-29 12:05:34'),
(17, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, '1T62AGFCR3ZQ', '{\"name\":{\"field_name\":\"Justin Blanchard\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (548) 999-8733\",\"type\":\"text\"},\"address\":{\"field_name\":\"Quos voluptas est of\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c5021c4e6eb1690632732.jpg\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64c5021c51a4e1690632732.jpg\",\"type\":\"file\"}}', NULL, '0', '2023-07-29 12:11:58', '2023-07-29 12:12:12'),
(18, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, 'H5QVV7ZG34QG', '{\"name\":{\"field_name\":\"Abra Pacheco\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (697) 968-2476\",\"type\":\"text\"},\"address\":{\"field_name\":\"Neque consectetur qu\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c502d694f9c1690632918.jpg\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64c502d69aa391690632918.jpg\",\"type\":\"file\"}}', NULL, '0', '2023-07-29 12:15:04', '2023-07-29 12:15:18'),
(19, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, '74Y1SO5VK87M', '{\"name\":{\"field_name\":\"Claudia Allen\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (639) 406-1366\",\"type\":\"text\"},\"address\":{\"field_name\":\"Omnis optio modi ex\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c5037fbaf981690633087.jpg\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64c5037fbe6131690633087.jpg\",\"type\":\"file\"}}', NULL, '0', '2023-07-29 12:17:48', '2023-07-29 12:18:07'),
(20, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, 'ADSSCAW14VXC', '{\"name\":{\"field_name\":\"Laurel Burt\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (655) 868-3562\",\"type\":\"text\"},\"address\":{\"field_name\":\"Quia unde voluptate\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c503fe119f91690633214.png\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64c503ff4e6fc1690633215.jpg\",\"type\":\"file\"}}', NULL, '0', '2023-07-29 12:19:58', '2023-07-29 12:20:15'),
(21, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, '4NDDGG38O8NR', '{\"name\":{\"field_name\":\"Nicole Boyer\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (975) 916-2573\",\"type\":\"text\"},\"address\":{\"field_name\":\"Ut qui in neque prov\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c5043fd45331690633279.jpg\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64c5043fd95571690633279.jpg\",\"type\":\"file\"}}', 'adasd', '1', '2023-07-29 12:21:03', '2023-07-30 08:09:54'),
(22, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, 'R8F7EW19QPC7', NULL, NULL, '0', '2023-07-29 12:23:08', '2023-07-29 12:23:08'),
(23, 1, 26, 3, 25.00, 1.00, 1.00, 26.00, '349R4FCDE7W6', '{\"name\":{\"field_name\":\"Ina Rich\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (156) 661-5947\",\"type\":\"text\"},\"address\":{\"field_name\":\"Assumenda fugit del\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64c505b847b881690633656.png\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64c505b84e0851690633656.jpg\",\"type\":\"file\"}}', 'successs', '1', '2023-07-29 12:27:13', '2023-07-30 08:00:09'),
(24, 1, 4, 3, 25.00, 1.00, 1.00, 26.00, '6R1B3T325OY3', NULL, NULL, '0', '2023-07-30 16:04:57', '2023-07-30 16:04:57'),
(25, 1, 3, 3, 25.00, 11.00, 10.00, 360.00, 'ADURBE94ZC1U', NULL, NULL, '0', '2023-07-30 16:09:03', '2023-07-30 16:09:03'),
(26, 1, 4, 3, 25.00, 1.00, 1.00, 26.00, 'FNU9HB98NM2O', NULL, NULL, '0', '2023-07-30 16:10:25', '2023-07-30 16:10:25'),
(27, 1, 4, 3, 25.00, 1.00, 1.00, 26.00, '8H1OW7VBW3S3', NULL, NULL, '0', '2023-07-30 16:20:56', '2023-07-30 16:20:56'),
(28, 1, 4, 3, 25.00, 1.00, 1.00, 26.00, 'REB5PUV4Q6GJ', NULL, NULL, '0', '2023-07-30 16:21:25', '2023-07-30 16:21:25'),
(29, 1, 4, 3, 25.00, 1.00, 1.00, 26.00, '7CMB964W4R2G', NULL, NULL, '0', '2023-07-30 16:27:58', '2023-07-30 16:27:58'),
(30, 1, 4, 3, 25.00, 1.00, 1.00, 26.00, '6YB6SVCU6A46', NULL, NULL, '0', '2023-07-30 16:40:43', '2023-07-30 16:40:43'),
(31, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'SXC3O3M3AKBJ', NULL, NULL, '0', '2023-07-30 16:55:59', '2023-07-30 16:55:59'),
(32, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, '4XJR1D4UECPB', NULL, NULL, '1', '2023-07-30 16:59:55', '2023-07-30 17:04:06'),
(33, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'HYAVME12JG4C', NULL, NULL, '1', '2023-07-30 17:05:38', '2023-07-30 17:06:07'),
(34, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, '8D3UYPJX38AV', NULL, NULL, '1', '2023-07-30 17:10:03', '2023-07-30 17:10:41'),
(35, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'Q7MXD4QGWR7T', NULL, NULL, '1', '2023-07-30 17:14:31', '2023-07-30 17:15:08'),
(36, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'A9KO6ZWX4ND4', NULL, NULL, '1', '2023-07-30 17:15:51', '2023-07-30 17:16:18'),
(37, 1, 9, 3, 1.00, 1.00, 1.00, 2.00, 'VMNSTCMOEKOW', NULL, NULL, '1', '2023-07-31 07:46:44', '2023-07-31 07:51:02'),
(38, 1, 3, 3, 1.00, 10.00, 10.00, 110.00, '3MOSP45WSJHT', NULL, NULL, '0', '2023-07-31 08:29:17', '2023-07-31 08:29:17'),
(39, 1, 6, 3, 1.00, 2.00, 1.00, 3.00, 'X18NBH9PU3XY', NULL, NULL, '0', '2023-07-31 08:34:28', '2023-07-31 08:34:28'),
(40, 1, 6, 3, 1.00, 2.00, 1.00, 3.00, 'BJQA51549N87', NULL, NULL, '0', '2023-07-31 08:36:15', '2023-07-31 08:36:15'),
(41, 1, 6, 3, 1.00, 2.00, 1.00, 3.00, 'C6J3TW3QF3D3', NULL, NULL, '0', '2023-07-31 08:39:35', '2023-07-31 08:39:35'),
(42, 1, 3, 3, 1.00, 10.00, 10.00, 110.00, 'Z58O2B67B3YJ', NULL, NULL, '0', '2023-07-31 08:41:21', '2023-07-31 08:41:21'),
(43, 1, 22, 3, 1.00, 100.00, 0.31, 31.00, '92G4U76P1TN5', NULL, NULL, '0', '2023-07-31 08:44:19', '2023-07-31 08:44:19'),
(44, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'NEKR968SO54T', NULL, NULL, '1', '2023-07-31 08:55:57', '2023-07-31 08:56:47'),
(45, 1, 21, 3, 1.00, 100.00, 272.71, 27544.00, '2JONNFRSQ3QX', NULL, NULL, '0', '2023-07-31 08:57:02', '2023-07-31 08:57:02'),
(46, 1, 25, 3, 1.00, 100.00, 108.23, 10931.00, 'QE9X7TMZ48MJ', NULL, NULL, '0', '2023-07-31 08:59:04', '2023-07-31 08:59:04'),
(47, 1, 7, 3, 1.00, 2.00, 1.00, 3.00, '9MVEP2D9D3PF', NULL, NULL, '0', '2023-07-31 09:16:15', '2023-07-31 09:16:15'),
(48, 1, 7, 3, 1.00, 2.00, 1.00, 3.00, '616OKERDT3KZ', NULL, NULL, '0', '2023-07-31 09:25:04', '2023-07-31 09:25:04'),
(49, 1, 7, 3, 1.00, 2.00, 1.00, 3.00, '8HGXHP8TFT6R', NULL, NULL, '0', '2023-07-31 09:39:46', '2023-07-31 09:39:46'),
(50, 1, 10, 3, 1.00, 1.00, 1.00, 2.00, '84OYDGJ7DBTF', NULL, NULL, '0', '2023-07-31 09:45:50', '2023-07-31 09:45:50'),
(51, 1, 11, 3, 1.00, 1.00, 73.51, 147.00, 'GGN3OZ6FOWU1', NULL, NULL, '0', '2023-07-31 09:46:28', '2023-07-31 09:46:28'),
(52, 1, 10, 3, 1.00, 1.00, 1.00, 2.00, 'EOMXS2QF8XCN', NULL, NULL, '0', '2023-07-31 09:54:44', '2023-07-31 09:54:44'),
(53, 1, 10, 3, 1.00, 1.00, 1.00, 2.00, 'PX1HQFD1GA3Z', NULL, NULL, '0', '2023-07-31 09:55:28', '2023-07-31 09:55:28'),
(54, 1, 9, 3, 1.00, 1.00, 1.00, 2.00, '3UZ232FBH5OJ', NULL, NULL, '0', '2023-07-31 09:56:06', '2023-07-31 09:56:06'),
(55, 1, 10, 3, 1.00, 1.00, 1.00, 2.00, 'B47PVEV2Z4PX', NULL, NULL, '0', '2023-07-31 09:56:10', '2023-07-31 09:56:10'),
(56, 1, 10, 3, 1.00, 1.00, 1.00, 2.00, 'JPBDNAKW95QB', NULL, NULL, '1', '2023-07-31 09:59:39', '2023-07-31 10:00:32'),
(57, 1, 11, 3, 1.00, 1.00, 73.51, 147.00, '5E1PTBNZJVXN', NULL, NULL, '0', '2023-07-31 10:03:46', '2023-07-31 10:03:46'),
(58, 1, 11, 3, 1.00, 1.00, 73.51, 147.00, 'GRPR6WOT9XT3', NULL, NULL, '0', '2023-07-31 10:04:00', '2023-07-31 10:04:00'),
(59, 1, 11, 3, 1.00, 1.00, 73.51, 147.00, 'TRUR4ODUKP1F', NULL, NULL, '0', '2023-07-31 10:04:28', '2023-07-31 10:04:28'),
(60, 1, 11, 3, 1.00, 1.00, 73.51, 147.00, 'WVZ6Q6ZGA5AP', NULL, NULL, '0', '2023-07-31 10:05:59', '2023-07-31 10:05:59'),
(61, 1, 12, 3, 1.00, 1.00, 0.01, 0.00, 'TOMR3PYGO4UM', NULL, NULL, '0', '2023-07-31 10:07:48', '2023-07-31 10:07:48'),
(62, 1, 8, 3, 1.00, 2.00, 1.00, 3.00, '8124C9D4V3HU', NULL, NULL, '0', '2023-07-31 10:08:31', '2023-07-31 10:08:31'),
(63, 1, 12, 3, 1.00, 1.00, 0.01, 0.00, '68D8BZU8H635', NULL, NULL, '0', '2023-07-31 10:21:12', '2023-07-31 10:21:12'),
(64, 1, 12, 3, 1.00, 1.00, 0.01, 0.00, 'JUJSOQPK4ZHR', NULL, NULL, '0', '2023-07-31 10:22:06', '2023-07-31 10:22:06'),
(65, 1, 12, 3, 1.00, 1.00, 0.01, 0.00, 'KC9YKPMYXBKA', NULL, NULL, '0', '2023-07-31 10:22:38', '2023-07-31 10:22:38'),
(66, 1, 12, 3, 1.00, 1.00, 1.00, 2.00, '3M1MYB7ZOH6O', NULL, NULL, '0', '2023-07-31 10:24:03', '2023-07-31 10:24:03'),
(67, 1, 17, 3, 1.00, 1.00, 1.00, 2.00, 'DU371RKR3OAJ', NULL, NULL, '0', '2023-07-31 10:36:54', '2023-07-31 10:36:54'),
(68, 1, 16, 3, 1.00, 1.00, 1.00, 2.00, 'A7O3XB3ACV6O', NULL, NULL, '0', '2023-07-31 10:49:20', '2023-07-31 10:49:20'),
(69, 1, 15, 3, 1.00, 1.00, 1.00, 2.00, 'AO5AD9MTNDD6', NULL, NULL, '0', '2023-07-31 10:54:22', '2023-07-31 10:54:22'),
(70, 1, 2, 3, 1.00, 1.00, 100.00, 200.00, 'DNUVVBSBJM68', NULL, NULL, '0', '2023-07-31 11:09:21', '2023-07-31 11:09:21'),
(71, 1, 1, 3, 1.00, 2.00, 100.00, 300.00, 'Q4DD9Y5XOX34', NULL, NULL, '0', '2023-07-31 11:15:48', '2023-07-31 11:15:48'),
(72, 1, 1, 3, 1.00, 2.00, 100.00, 300.00, 'HYYASHMWT14O', NULL, NULL, '0', '2023-07-31 11:16:48', '2023-07-31 11:16:48'),
(73, 1, 3, 3, 1.00, 10.00, 10.00, 110.00, 'FS4932KG9AYE', NULL, NULL, '0', '2023-07-31 11:17:07', '2023-07-31 11:17:07'),
(74, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'NHW9XKMZXG1T', NULL, NULL, '0', '2023-07-31 11:17:15', '2023-07-31 11:17:15'),
(75, 1, 25, 3, 1.00, 100.00, 108.23, 10931.00, '9RM2EDSWF9QS', NULL, NULL, '0', '2023-07-31 11:17:27', '2023-07-31 11:17:27'),
(76, 1, 6, 3, 1.00, 2.00, 1.00, 3.00, '6K8US1AU14F6', NULL, NULL, '0', '2023-07-31 11:17:34', '2023-07-31 11:17:34'),
(77, 1, 7, 3, 1.00, 2.00, 1.00, 3.00, '3N921W2XCVO8', NULL, NULL, '0', '2023-07-31 11:17:47', '2023-07-31 11:17:47'),
(78, 1, 9, 3, 1.00, 1.00, 1.00, 2.00, 'RF8TNUJS8SG5', NULL, NULL, '0', '2023-07-31 11:17:58', '2023-07-31 11:17:58'),
(79, 1, 10, 3, 1.00, 1.00, 1.00, 2.00, 'FFCHY5PAQEHU', NULL, NULL, '0', '2023-07-31 11:18:13', '2023-07-31 11:18:13'),
(80, 1, 11, 3, 1.00, 1.00, 73.51, 147.00, 'BRVSPUWY9T9Z', NULL, NULL, '0', '2023-07-31 11:18:37', '2023-07-31 11:18:37'),
(81, 1, 12, 3, 1.00, 1.00, 1.00, 2.00, '3SWP8MK9K6DZ', NULL, NULL, '0', '2023-07-31 11:18:44', '2023-07-31 11:18:44'),
(82, 1, 15, 3, 1.00, 1.00, 1.00, 2.00, '4UYMNUPAG96U', NULL, NULL, '0', '2023-07-31 11:18:54', '2023-07-31 11:18:54'),
(83, 1, 16, 3, 1.00, 1.00, 1.00, 2.00, 'GW8DC5U7JT4O', NULL, NULL, '0', '2023-07-31 11:19:03', '2023-07-31 11:19:03'),
(84, 1, 17, 3, 1.00, 1.00, 1.00, 2.00, 'DKE2GEZGNPCV', NULL, NULL, '0', '2023-07-31 11:19:13', '2023-07-31 11:19:13'),
(85, 1, 16, 3, 1.00, 1.00, 1.00, 2.00, 'FK72H6S6C34K', NULL, NULL, '0', '2023-07-31 12:56:50', '2023-07-31 12:56:50'),
(86, 1, 1, 3, 1.00, 2.00, 100.00, 300.00, 'PPDQZFHOU3KM', NULL, NULL, '0', '2023-08-02 04:36:36', '2023-08-02 04:36:36'),
(87, 1, 2, 3, 1.00, 1.00, 100.00, 200.00, '26BP4TJYVSAD', NULL, NULL, '0', '2023-08-02 04:36:57', '2023-08-02 04:36:57'),
(88, 1, 3, 3, 1.00, 10.00, 10.00, 110.00, 'P86WA439X1ZA', NULL, NULL, '0', '2023-08-02 04:39:38', '2023-08-02 04:39:38'),
(89, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, '5UJSA9SXAKZM', NULL, NULL, '0', '2023-08-02 04:40:00', '2023-08-02 04:40:00'),
(90, 1, 7, 3, 1.00, 2.00, 1.00, 3.00, '95K3SUW6FAOD', NULL, NULL, '0', '2023-08-02 04:40:39', '2023-08-02 04:40:39'),
(91, 1, 16, 3, 1.00, 1.00, 1.00, 2.00, 'OZSFQPDNAQE8', NULL, NULL, '0', '2023-08-02 04:41:05', '2023-08-02 04:41:05'),
(92, 1, 17, 3, 1.00, 1.00, 1.00, 2.00, 'TO8TBJVV6GKV', NULL, NULL, '0', '2023-08-02 04:41:20', '2023-08-02 04:41:20'),
(93, 1, 1, 3, 1.00, 2.00, 100.00, 300.00, '7R729SV26WA3', NULL, NULL, '0', '2023-08-02 04:41:27', '2023-08-02 04:41:27'),
(94, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'ZJNGAHTU8H2X', NULL, NULL, '0', '2023-08-02 10:20:51', '2023-08-02 10:20:51'),
(95, 1, 1, 3, 1.00, 2.00, 100.00, 300.00, 'WF2S45AY94RY', NULL, NULL, '0', '2023-08-02 11:11:20', '2023-08-02 11:11:20'),
(96, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'JZGWR95W3WNT', NULL, NULL, '1', '2023-08-02 11:22:25', '2023-08-02 11:23:16'),
(97, 1, 7, 3, 1.00, 2.00, 1.00, 3.00, 'ORANBTQHMT6O', NULL, NULL, '0', '2023-08-02 11:32:42', '2023-08-02 11:32:42'),
(98, 1, 9, 3, 1.00, 1.00, 1.00, 2.00, 'PRNQVZ5J2YG2', NULL, NULL, '1', '2023-08-02 11:32:56', '2023-08-02 11:35:08'),
(99, 1, 10, 3, 1.00, 1.00, 1.00, 2.00, '2EG2CBSOVO3S', NULL, NULL, '0', '2023-08-02 11:35:23', '2023-08-02 11:35:23'),
(100, 1, 26, 3, 1.00, 1.00, 1.00, 2.00, 'O8C9V4HURHCD', NULL, NULL, '0', '2023-08-03 05:07:51', '2023-08-03 05:07:51'),
(101, 1, 3, 3, 1.00, 10.00, 10.00, 110.00, 'K4MEXBDXEHJD', NULL, NULL, '0', '2023-08-03 05:08:51', '2023-08-03 05:08:51'),
(102, 1, 26, 3, 1.00, 1.00, 1.00, 2.00, '3DOC2Z2O39RJ', NULL, NULL, '0', '2023-08-03 05:12:01', '2023-08-03 05:12:01'),
(103, 1, 26, 3, 1.00, 1.00, 1.00, 2.00, 'AC1BJ3EW6U8V', NULL, NULL, '0', '2023-08-03 05:13:53', '2023-08-03 05:13:53'),
(104, 1, 26, 3, 1.00, 1.00, 1.00, 2.00, 'BY67ACJSS4TV', NULL, NULL, '0', '2023-08-03 05:14:31', '2023-08-03 05:14:31'),
(105, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'UFVKKT2538TT', NULL, NULL, '0', '2023-08-03 05:26:15', '2023-08-03 05:26:15'),
(106, 1, 26, 3, 1.00, 1.00, 1.00, 2.00, 'K4XKZDJ5276R', '{\"name\":{\"field_name\":\"Ebony Pittman\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (743) 936-1945\",\"type\":\"text\"},\"address\":{\"field_name\":\"Earum et ipsa autem\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64cb3a934138f1691040403.jpg\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64cb3a9345f661691040403.jpg\",\"type\":\"file\"}}', 'Success', '1', '2023-08-03 05:26:25', '2023-08-03 05:27:52'),
(107, 1, 26, 3, 1.00, 1.00, 1.00, 2.00, 'ZZG7ROK5X8QV', '{\"name\":{\"field_name\":\"Ivan Dixon\",\"type\":\"text\"},\"phone\":{\"field_name\":\"+1 (279) 749-9658\",\"type\":\"text\"},\"address\":{\"field_name\":\"Esse dolores laborio\",\"type\":\"textarea\"},\"image\":{\"field_name\":\"64cb3e6fa81881691041391.jpg\",\"type\":\"file\"},\"nidimage\":{\"field_name\":\"64cb3e6fab65d1691041391.jpg\",\"type\":\"file\"}}', 'sadasdsad', '1', '2023-08-03 05:41:29', '2023-08-03 05:43:39'),
(108, 1, 3, 4, 45.00, 0.00, 1.00, 45.00, 'TTSCCK6ENGGB', NULL, NULL, '1', '2023-08-03 08:43:32', '2023-08-03 08:43:32'),
(109, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, '357ECOX59KSJ', NULL, NULL, '1', '2023-08-03 08:48:19', '2023-08-03 08:48:19'),
(110, 1, 1, 3, 1.00, 2.00, 100.00, 300.00, 'G7DFS3TBG7W4', NULL, NULL, '1', '2023-08-03 08:53:32', '2023-08-03 08:53:32'),
(111, 1, 26, 3, 1.00, 1.00, 1.00, 2.00, 'C53XSJ7EU8V6', NULL, NULL, '1', '2023-08-03 11:35:17', '2023-08-03 11:35:17'),
(112, 1, 7, 3, 1.00, 2.00, 1.00, 3.00, 'OZ6V7RFVV98U', NULL, NULL, '1', '2023-08-03 11:35:35', '2023-08-03 11:35:35'),
(113, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, 'MGG2PNYQNKJ9', NULL, NULL, '1', '2023-08-03 11:35:51', '2023-08-03 11:35:51'),
(114, 1, 2, 3, 1.00, 1.00, 100.00, 200.00, 'CDPC41ECSA4P', NULL, NULL, '1', '2023-08-03 11:36:35', '2023-08-03 11:36:35'),
(115, 1, 26, 3, 1.00, 1.00, 1.00, 2.00, '31FJBHYSWPY4', NULL, NULL, '1', '2023-08-03 11:36:58', '2023-08-03 11:36:58'),
(116, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, '2ZKCF1M9WNS3', NULL, NULL, '1', '2023-08-03 11:39:20', '2023-08-03 11:39:20'),
(117, 1, 1, 3, 1.00, 2.00, 100.00, 300.00, '6W2NUJTOAVEK', NULL, NULL, '0', '2023-08-03 11:42:30', '2023-08-03 11:42:30'),
(118, 1, 2, 3, 1.00, 1.00, 100.00, 200.00, 'ERV17TTJ5KKD', NULL, NULL, '0', '2023-08-03 11:43:00', '2023-08-03 11:43:00'),
(119, 1, 25, 3, 1.00, 100.00, 108.23, 10931.00, 'HU6KY2TXUXNV', NULL, NULL, '0', '2023-08-03 11:43:11', '2023-08-03 11:43:11'),
(120, 1, 4, 3, 1.00, 1.00, 1.00, 2.00, '4QZWZD3KENNJ', NULL, NULL, '1', '2023-08-03 11:43:38', '2023-08-03 11:45:03'),
(121, 1, 9, 3, 1.00, 1.00, 1.00, 2.00, 'JTJMT4PFF9QF', NULL, NULL, '0', '2023-08-03 11:45:23', '2023-08-03 11:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_id` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supported_currency` json DEFAULT NULL,
  `currency_symbol` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters` json NOT NULL,
  `extra_parameters` json DEFAULT NULL,
  `convention_rate` double(8,2) NOT NULL DEFAULT '0.00',
  `percentage_charge` double(4,2) NOT NULL DEFAULT '0.00',
  `fixed_charge` double(8,2) NOT NULL DEFAULT '0.00',
  `payment_notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `type` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Automatic : 1,Manual : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `uid`, `serial_id`, `created_by`, `updated_by`, `name`, `code`, `currency`, `supported_currency`, `currency_symbol`, `parameters`, `extra_parameters`, `convention_rate`, `percentage_charge`, `fixed_charge`, `payment_notes`, `status`, `type`, `created_at`, `updated_at`) VALUES
(1, '8I9O-Kk0c9RYP-f4gq', 1, 1, 1, 'bkash', 'bkash', 'BDT', '[\"BDT\"]', '৳', '{\"api_key\": \"4f6o0cjiki2rfm34kfdadl1eqq\", \"sandbox\": \"1\", \"password\": \"sandboxTokenizedUser02@12345\", \"username\": \"sandboxTokenizedUser02\", \"api_secret\": \"2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b\"}', '{\"callback\": \"ipn\"}', 100.00, 2.00, 2.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-27 08:35:39'),
(2, '954x-nbxQFKgK-9hzk', 1, 1, 1, 'nagad', 'nagad', 'BDT', '[\"BDT\"]', '৳', '{\"pri_key\": \"MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCJakyLqojWTDAVUdNJLvuXhROV+LXymqnukBrmiWwTYnJYm9r5cKHj1hYQRhU5eiy6NmFVJqJtwpxyyDSCWSoSmIQMoO2KjYyB5cDajRF45v1GmSeyiIn0hl55qM8ohJGjXQVPfXiqEB5c5REJ8Toy83gzGE3ApmLipoegnwMkewsTNDbe5xZdxN1qfKiRiCL720FtQfIwPDp9ZqbG2OQbdyZUB8I08irKJ0x/psM4SjXasglHBK5G1DX7BmwcB/PRbC0cHYy3pXDmLI8pZl1NehLzbav0Y4fP4MdnpQnfzZJdpaGVE0oI15lq+KZ0tbllNcS+/4MSwW+afvOw9bazAgMBAAECggEAIkenUsw3GKam9BqWh9I1p0Xmbeo+kYftznqai1pK4McVWW9//+wOJsU4edTR5KXK1KVOQKzDpnf/CU9SchYGPd9YScI3n/HR1HHZW2wHqM6O7na0hYA0UhDXLqhjDWuM3WEOOxdE67/bozbtujo4V4+PM8fjVaTsVDhQ60vfv9CnJJ7dLnhqcoovidOwZTHwG+pQtAwbX0ICgKSrc0elv8ZtfwlEvgIrtSiLAO1/CAf+uReUXyBCZhS4Xl7LroKZGiZ80/JE5mc67V/yImVKHBe0aZwgDHgtHh63/50/cAyuUfKyreAH0VLEwy54UCGramPQqYlIReMEbi6U4GC5AQKBgQDfDnHCH1rBvBWfkxPivl/yNKmENBkVikGWBwHNA3wVQ+xZ1Oqmjw3zuHY0xOH0GtK8l3Jy5dRL4DYlwB1qgd/Cxh0mmOv7/C3SviRk7W6FKqdpJLyaE/bqI9AmRCZBpX2PMje6Mm8QHp6+1QpPnN/SenOvoQg/WWYM1DNXUJsfMwKBgQCdtddE7A5IBvgZX2o9vTLZY/3KVuHgJm9dQNbfvtXw+IQfwssPqjrvoU6hPBWHbCZl6FCl2tRh/QfYR/N7H2PvRFfbbeWHw9+xwFP1pdgMug4cTAt4rkRJRLjEnZCNvSMVHrri+fAgpv296nOhwmY/qw5Smi9rMkRY6BoNCiEKgQKBgAaRnFQFLF0MNu7OHAXPaW/ukRdtmVeDDM9oQWtSMPNHXsx+crKY/+YvhnujWKwhphcbtqkfj5L0dWPDNpqOXJKV1wHt+vUexhKwus2mGF0flnKIPG2lLN5UU6rs0tuYDgyLhAyds5ub6zzfdUBG9Gh0ZrfDXETRUyoJjcGChC71AoGAfmSciL0SWQFU1qjUcXRvCzCK1h25WrYS7E6pppm/xia1ZOrtaLmKEEBbzvZjXqv7PhLoh3OQYJO0NM69QMCQi9JfAxnZKWx+m2tDHozyUIjQBDehve8UBRBRcCnDDwU015lQN9YNb23Fz+3VDB/LaF1D1kmBlUys3//r2OV0Q4ECgYBnpo6ZFmrHvV9IMIGjP7XIlVa1uiMCt41FVyINB9SJnamGGauW/pyENvEVh+ueuthSg37e/l0Xu0nm/XGqyKCqkAfBbL2Uj/j5FyDFrpF27PkANDo99CdqL5A4NQzZ69QRlCQ4wnNCq6GsYy2WEJyU2D+K8EBSQcwLsrI7QL7fvQ==\", \"pub_key\": \"MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjBH1pFNSSRKPuMcNxmU5jZ1x8K9LPFM4XSu11m7uCfLUSE4SEjL30w3ockFvwAcuJffCUwtSpbjr34cSTD7EFG1Jqk9Gg0fQCKvPaU54jjMJoP2toR9fGmQV7y9fz31UVxSk97AqWZZLJBT2lmv76AgpVV0k0xtb/0VIv8pd/j6TIz9SFfsTQOugHkhyRzzhvZisiKzOAAWNX8RMpG+iqQi4p9W9VrmmiCfFDmLFnMrwhncnMsvlXB8QSJCq2irrx3HG0SJJCbS5+atz+E1iqO8QaPJ05snxv82Mf4NlZ4gZK0Pq/VvJ20lSkR+0nk+s/v3BgIyle78wjZP1vWLU4wIDAQAB\", \"sandbox\": \"1\", \"marchent_id\": \"683002007104225\", \"marchent_number\": \"01817535192\"}', '{\"callback\": \"ipn\"}', 100.00, 1.00, 1.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-27 08:35:48'),
(3, 'YQ6C-e8EGTmi0-pzL2', 3, 1, 1, 'paypal', 'paypal', 'USD', '[\"AUD\", \"BRL\", \"CAD\", \"DKK\", \"EUR\", \"HKD\", \"HUF\", \"INR\", \"JPY\", \"MYR\", \"MXN\", \"TWD\", \"NZD\", \"PHP\", \"PLN\", \"GBP\", \"RUB\", \"SGD\", \"SEK\", \"CHF\", \"THB\", \"USD\"]', '$', '{\"secret\": \"EPx-YEgvjKDRFFu3FAsMue_iUMbMH6jHu408rHdn4iGrUCM8M12t7mX8hghUBAWwvWErBOa4Uppfp0Eh\", \"cleint_id\": \"AUrvcotEVWZkksiGir6Ih4PyalQcguQgGN-7We5O1wBny3tg1w6srbQzi6GQEO8lP3yJVha2C6lyivK9\"}', '[]', 10.00, 2.00, 10.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-27 10:21:59'),
(4, '848P-yHNsotHx-gsCG', 4, 1, 1, 'stripe', 'stripe', 'USD', '[\"USD\", \"AUD\", \"BRL\", \"CAD\", \"CHF\", \"DKK\", \"EUR\", \"GBP\", \"HKD\", \"INR\", \"JPY\", \"MXN\", \"MYR\", \"NOK\", \"NZD\", \"PLN\", \"SEK\", \"SGD\"]', '$', '{\"secret_key\": \"sk_test_51NZcwCH3Ugpk7wDMijpwMOOxxkIGl60W3eCLGYCd04710YtxHyddq4PDqtEj4bC1e67UcVbzNc9t9f93XDxEWeFd003chrll2A\", \"publishable_key\": \"pk_test_51NZcwCH3Ugpk7wDMMGdBRspoONxv9VctHqwkHqhJ01FI11EGyLZcb34wSmEDVAEQc49bnPabqlgJUQ0t1fgRsR2500RtgrJszn\"}', '[]', 1.00, 0.00, 0.50, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-30 16:59:32'),
(6, '4jyo-ho6zkhDE-sbDt', 6, 1, 1, 'payeer', 'payeer', 'RUB', '[\"USD\", \"EUR\", \"RUB\"]', 'RUB', '{\"secret_key\": \"817b347f8c9315713fe68402a186c569673c624\", \"merchant_id\": \"1560632740\"}', '{\"status\": \"ipn\"}', 1.00, 2.10, 2.26, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-27 08:18:12'),
(7, 'XuE4-o7MPrX1A-s3y8', 7, 1, 1, 'paystack', 'paystack', 'NGN', '[\"USD\", \"NGN\"]', 'NGN', '{\"public_key\": \"pk_test_f922aa1a87101e3fd029e13024006862fdc0b8c7\", \"secret_key\": \"sk_test_b8d571f97c1b41d409ba339eb20b005377751dff\"}', '{\"webhook\": \"ipn\", \"callback\": \"ipn\"}', 1.00, 1.00, 2.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-27 08:36:06'),
(9, 'DV0m-OsVbyl59-Pec3', 9, 1, 1, 'flutterwave', 'flutterwave', 'USD', '[\"KES\", \"GHS\", \"NGN\", \"USD\", \"GBP\", \"EUR\", \"UGX\", \"TZS\"]', 'USD', '{\"public_key\": \"FLWPUBK_TEST-5d9bb05bba2c13aa6c7a1ec7d7526ba2-X\", \"secret_key\": \"FLWSECK_TEST-2ac7b05b6b9fa8a423eb58241fd7bbb6-X\", \"encryption_key\": \"FLWSECK_TEST32e13665a95a\"}', '[]', 1.00, 1.00, 1.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-27 08:36:25'),
(10, '5aRM-oFVhxckt-6UzA', 10, 1, 1, 'razorpay', 'razorpay', 'INR', '[\"INR\"]', 'INR', '{\"key_id\": \"rzp_test_kiOtejPbRZU90E\", \"key_secret\": \"osRDebzEqbsE1kbyQJ4y0re7\"}', '[]', 1.00, 1.00, 0.50, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-27 08:37:50'),
(11, '6rT8-fKc9FlTu-kdLx', 11, 1, 1, 'instamojo', 'instamojo', 'INR', '[\"INR\"]', 'INR', '{\"salt\": \"19d38908eeff4f58b2ddda2c6d86ca25\", \"api_key\": \"test_2241633c3bc44a3de84a3b33969\", \"auth_token\": \"test_279f083f7bebefd35217feef22d\"}', '[]', 73.51, 1.00, 1.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-27 08:39:08'),
(12, 'Ux8l-glHMxyDl-AIA3', 12, 1, 1, 'mollie', 'mollie', 'USD', '[\"AED\", \"AUD\", \"BGN\", \"BRL\", \"CAD\", \"CHF\", \"CZK\", \"DKK\", \"EUR\", \"GBP\", \"HKD\", \"HRK\", \"HUF\", \"ILS\", \"ISK\", \"JPY\", \"MXN\", \"MYR\", \"NOK\", \"NZD\", \"PHP\", \"PLN\", \"RON\", \"RUB\", \"SEK\", \"SGD\", \"THB\", \"TWD\", \"USD\", \"ZAR\"]', 'USD', '{\"api_key\": \"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}', '[]', 1.00, 1.00, 1.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-31 10:23:50'),
(15, 'DxTu-bX70EzCv-tfY2', 15, 1, 1, 'payumoney', 'payumoney', 'INR', '[\"INR\"]', 'INR', '{\"salt\": \"eCwWELxi\", \"merchant_key\": \"gtKFFx\"}', '[]', 1.00, 1.00, 1.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-31 10:51:06'),
(16, 'DvpZ-jbdC1mbd-OPC3', 16, 1, 1, 'mercadopago', 'mercadopago', 'BRL', '[\"ARS\", \"BOB\", \"BRL\", \"CLF\", \"CLP\", \"COP\", \"CRC\", \"CUC\", \"CUP\", \"DOP\", \"EUR\", \"GTQ\", \"HNL\", \"MXN\", \"NIO\", \"PAB\", \"PEN\", \"PYG\", \"USD\", \"UYU\", \"VEF\", \"VES\"]', 'BRL', '{\"access_token\": \"TEST-705032440135962-041006-ad2e021853f22338fe1a4db9f64d1491-421886156\"}', '[]', 1.00, 1.00, 1.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-31 10:39:56'),
(17, 'tRIM-m8XsAp4l-dKC3', 17, 1, 1, 'cashmaal', 'cashmaal', 'PKR', '[\"USD\", \"PKR\"]', 'PKR', '{\"web_id\": \"3748\", \"ipn_key\": \"546254628759524554647987\"}', '{\"ipn_url\": \"ipn\"}', 1.00, 1.00, 1.00, NULL, '1', '1', '2023-07-08 13:29:19', '2023-07-31 10:33:56'),
(21, 'WpQD-nAVQLDEh-SGW3', 24, 1, NULL, 'Bank Transfer', 'BankTransfer', 'ARS', NULL, '$', '{\"RefundPolicy\": {\"type\": \"textarea\", \"field_name\": \"RefundPolicy\", \"validation\": \"required\", \"field_label\": \"Refund Policy\"}, \"OrderReference\": {\"type\": \"text\", \"field_name\": \"OrderReference\", \"validation\": \"required\", \"field_label\": \"Order Reference\"}, \"ProcessingTime\": {\"type\": \"text\", \"field_name\": \"ProcessingTime\", \"validation\": \"required\", \"field_label\": \"Processing Time\"}, \"PaymentInstructions\": {\"type\": \"textarea\", \"field_name\": \"PaymentInstructions\", \"validation\": \"required\", \"field_label\": \"Payment Instructions\"}}', NULL, 272.71, 10.00, 100.00, 'This option allows customers to transfer funds directly from their bank account to the merchant\'s bank account. The admin panel would provide instructions for customers to initiate the transfer.', '1', '0', '2023-07-09 12:41:51', '2023-07-31 05:11:43'),
(22, '1rfZ-hKF819ZA-ty0u', 27, 1, NULL, 'Phone Payment', 'PhonePayment', 'KWD', NULL, 'د.ك', '{\"Name\": {\"type\": \"text\", \"field_name\": \"Name\", \"validation\": \"required\", \"field_label\": \"Name\"}, \"PhoneNumber\": {\"type\": \"text\", \"field_name\": \"PhoneNumber\", \"validation\": \"required\", \"field_label\": \"Phone Number\"}}', NULL, 0.31, 10.00, 100.00, 'The admin panel might include a feature for manual phone payments, where customers can call a designated phone number to provide their payment details to a customer service representative.', '1', '0', '2023-07-09 12:55:14', '2023-07-31 05:06:11'),
(23, 'DFt3-LeryHm7R-1pp4', 55, 1, NULL, 'Check/Money Order', 'CheckMoneyOrder', 'INR', NULL, '₹', '{\"MailingAddress\": {\"type\": \"textarea\", \"field_name\": \"MailingAddress\", \"validation\": \"nullable\", \"field_label\": \"Mailing Address\"}, \"PaymentProcessingTime\": {\"type\": \"text\", \"field_name\": \"PaymentProcessingTime\", \"validation\": \"required\", \"field_label\": \"Payment Processing Time\"}, \"PolicyforUnpaidorReturnedPayments\": {\"type\": \"textarea\", \"field_name\": \"PolicyforUnpaidorReturnedPayments\", \"validation\": \"nullable\", \"field_label\": \"Policy for Unpaid or Returned Payments\"}}', NULL, 82.29, 10.00, 100.00, 'Customers can send a physical check or money order to the merchant by mail. The merchant processes the payment once the check is received and cleared.', '1', '0', '2023-07-09 13:08:03', '2023-07-31 04:54:33'),
(25, '1MK5-BLsjCnTI-PC37', 5, 1, NULL, 'Cash on Delivery', 'CashonDelivery', 'BDT', NULL, '৳', '{\"Name\": {\"type\": \"text\", \"field_name\": \"Name\", \"validation\": \"required\", \"field_label\": \"Name\"}, \"Email\": {\"type\": \"text\", \"field_name\": \"Email\", \"validation\": \"required\", \"field_label\": \"Email\"}, \"Address\": {\"type\": \"textarea\", \"field_name\": \"Address\", \"validation\": \"required\", \"field_label\": \"Address\"}, \"PhoneNumber\": {\"type\": \"text\", \"field_name\": \"PhoneNumber\", \"validation\": \"required\", \"field_label\": \"Phone Number\"}, \"PaymentProcessingTime\": {\"type\": \"text\", \"field_name\": \"PaymentProcessingTime\", \"validation\": \"required\", \"field_label\": \"Payment Processing Time\"}}', NULL, 108.23, 10.00, 100.00, 'Customers pay for their purchases in cash when the product is delivered to their doorstep. This method is commonly used for local deliveries or in regions where online payment adoption is low.', '1', '0', '2023-07-15 12:51:21', '2023-07-31 05:05:37'),
(26, 'tTgw-ziPK4Cxv-ai60', 1, 1, NULL, 'Bank T', 'BankT', 'USD', NULL, '$', '{\"name\": {\"type\": \"text\", \"field_name\": \"name\", \"validation\": \"required\", \"field_label\": \"name\"}, \"image\": {\"type\": \"file\", \"field_name\": \"image\", \"validation\": \"required\", \"field_label\": \"image\"}, \"phone\": {\"type\": \"text\", \"field_name\": \"phone\", \"validation\": \"required\", \"field_label\": \"phone\"}, \"address\": {\"type\": \"textarea\", \"field_name\": \"address\", \"validation\": \"required\", \"field_label\": \"address\"}, \"nidimage\": {\"type\": \"file\", \"field_name\": \"nidimage\", \"validation\": \"required\", \"field_label\": \"nid image\"}}', NULL, 1.00, 1.00, 1.00, 'Demo Note', '1', '0', '2023-07-27 11:03:32', '2023-08-03 09:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` json DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `uid`, `created_by`, `updated_by`, `name`, `permissions`, `status`, `created_at`, `updated_at`) VALUES
(1, 'b2Ns-okMuJoHE-KIO6', 1, 1, 'Manager', '{\"faq\": [\"view_faq\", \"create_faq\", \"update_faq\", \"delete_faq\"], \"role\": [\"view_role\", \"create_role\", \"update_role\", \"delete_role\"], \"user\": [\"view_user\", \"create_user\", \"update_user\", \"delete_user\"], \"staff\": [\"view_staff\", \"create_staff\", \"update_staff\", \"delete_staff\"], \"settings\": [\"view_settings\", \"update_settings\"], \"dashboard\": [\"view_dashboard\"], \"payment_method\": [\"view_method\", \"update_method\"]}', '1', '2023-07-08 13:29:19', '2023-07-17 09:25:18'),
(2, '2Wzf-qNKnw3FR-iF62', 1, 1, 'demo', '{\"cta\": [\"view_cta\", \"create_cta\", \"update_cta\", \"delete_cta\"], \"faq\": [\"view_faq\", \"create_faq\", \"update_faq\", \"delete_faq\"], \"link\": [\"view_link\", \"create_link\", \"update_link\", \"delete_link\"], \"menu\": [\"view_menu\", \"create_menu\", \"update_menu\", \"delete_menu\"], \"page\": [\"view_page\", \"create_page\", \"update_page\", \"delete_page\"], \"role\": [\"view_role\", \"create_role\", \"update_role\", \"delete_role\"], \"user\": [\"view_user\", \"create_user\", \"update_user\", \"delete_user\"], \"staff\": [\"view_staff\", \"create_staff\", \"update_staff\", \"delete_staff\"], \"client\": [\"view_client\", \"create_client\", \"update_client\", \"delete_client\"], \"article\": [\"view_article\", \"create_article\", \"update_article\", \"delete_article\"], \"gateway\": [\"view_gateway\", \"update_gateway\"], \"category\": [\"view_category\", \"create_category\", \"update_category\", \"delete_category\"], \"frontend\": [\"view_frontend\", \"update_frontend\"], \"language\": [\"view_language\", \"translate_language\", \"create_language\", \"update_language\", \"delete_language\"], \"settings\": [\"view_settings\", \"update_settings\"], \"dashboard\": [\"view_dashboard\"], \"notification\": [\"view_notification\"], \"payment_method\": [\"view_method\", \"create_method\", \"update_method\", \"delete_method\"], \"notification_template\": [\"view_template\", \"update_template\"]}', '0', '2023-07-15 09:49:48', '2023-07-24 15:31:27');

-- --------------------------------------------------------

--
-- Table structure for table `seos`
--

CREATE TABLE `seos` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `identifier` text COLLATE utf8mb4_unicode_ci,
  `title` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seos`
--

INSERT INTO `seos` (`id`, `uid`, `updated_by`, `identifier`, `title`, `slug`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(16, '2mY6-iDf6aI3R-vtcd', 1, 'home', '{\"en\":\"home\",\"al\":null}', '/', '{\"en\":\"home\",\"al\":null}', '{\"en\":\"home\",\"al\":null}', '[\"adas\"]', '2023-07-20 08:51:20', '2023-08-03 12:50:16'),
(17, 'zlVa-L01Xef7g-gai5', NULL, 'latest-link', '{\"en\":\"latest-link\"}', 'latest-link', '{\"en\":\"latest-link\"}', '{\"en\":\"latest-link\"}', '[\"latest-link\"]', '2023-07-20 08:51:20', '2023-07-20 08:51:20'),
(18, 'v6rV-dMw9DkRg-iVw5', NULL, 'popular-links', '{\"en\":\"popular-links\"}', 'popular-links', '{\"en\":\"popular-links\"}', '{\"en\":\"popular-links\"}', '[\"popular-links\"]', '2023-07-20 08:51:20', '2023-07-20 08:51:20'),
(19, '4VAE-xgjmCOJS-Nn6g', NULL, 'contacts', '{\"en\":\"contacts\"}', 'contacts', '{\"en\":\"contacts\"}', '[\"contacts\"]', '[\"popular-links\"]', '2023-07-20 08:51:20', '2023-07-20 08:51:20'),
(20, '4FBb-zUui1KNG-OZNc', NULL, 'client-review', '{\"en\":\"client-review\"}', 'client-review', '{\"en\":\"client-review\"}', '{\"en\":\"client-review\"}', '[\"client-review\"]', '2023-07-20 08:51:20', '2023-07-20 08:51:20'),
(21, '50g9-RTE1aNZF-xkmo', 1, 'articles', '{\"en\":\"articles\",\"al\":null,\"bj\":null}', 'articles', '{\"en\":\"articles\",\"al\":null,\"bj\":null}', '{\"en\":\"articles\",\"al\":null,\"bj\":null}', '[\"articles\"]', '2023-07-20 08:51:20', '2023-07-22 05:05:13'),
(22, '9PZt-1kFHceHK-3Dx5', NULL, 'link-categories', '{\"en\":\"link-categories\"}', 'link-categories', '{\"en\":\"link-categories\"}', '{\"en\":\"link-categories\"}', '[\"link-categories\"]', '2023-07-20 08:51:20', '2023-07-20 08:51:20'),
(23, 'mAvW-hsmrgda8-4750', 1, 'pages', '{\"en\":\"pages\",\"al\":null,\"bj\":null}', 'page', '{\"en\":\"pages\",\"al\":null,\"bj\":null}', '{\"en\":\"pages\",\"al\":null,\"bj\":null}', '[\"pages\"]', '2023-07-20 09:59:02', '2023-07-20 10:22:31'),
(24, 'GccG-41DSFpUi-ZR57', 1, 'articles-categories', '{\"en\":\"articles-categories\",\"al\":null,\"bj\":null}', 'article/category', '{\"en\":\"articles_categories\",\"al\":null,\"bj\":null}', '{\"en\":\"articles_categories\",\"al\":null,\"bj\":null}', '[\"articles_categories\"]', '2023-07-22 07:39:45', '2023-07-22 07:42:01'),
(25, '6JR1-jHeZ3kYf-uig1', NULL, 'feedback', '{\"en\":\"feedback\"}', 'feedback', '{\"en\":\"feedback\"}', '{\"en\":\"feedback\"}', '[\"feedback\"]', '2023-07-23 09:51:57', '2023-07-23 09:51:57'),
(26, '7Hwo-weI0z5Dm-P5tn', NULL, 'login', '{\"en\":\"login\"}', 'login', '{\"en\":\"login\"}', '{\"en\":\"login\"}', '[\"login\"]', '2023-07-23 11:38:16', '2023-07-23 11:38:16'),
(27, 'tDzL-1RYQDr88-eAx2', NULL, 'register', '{\"en\":\"register\"}', 'register', '{\"en\":\"register\"}', '{\"en\":\"register\"}', '[\"register\"]', '2023-07-23 11:38:16', '2023-07-23 11:38:16'),
(28, 'p3Ag-ofIdphNn-Lld7', 1, 'verification', '{\"en\":\"verification\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '', '{\"en\":\"auth_verification\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '{\"en\":\"auth_verification\",\"al\":null,\"bj\":null,\"dz\":null,\"bh\":null}', '[\"auth_verification\"]', '2023-07-23 11:38:16', '2023-07-24 05:03:43'),
(29, '6ZlH-3fAVzgPD-zx0v', NULL, 'tags', '{\"en\":\"tags\"}', 'tags', '{\"en\":\"tags\"}', '{\"en\":\"tags\"}', '[\"tags\"]', '2023-07-25 09:07:12', '2023-07-25 09:07:12'),
(30, '9A1W-Hd8IXI4S-xtT7', NULL, 'link-redirect', '{\"en\":\"link-redirect\"}', 'link-redirect', '{\"en\":\"link-redirect\"}', '{\"en\":\"link-redirect\"}', '[\"link-redirect\"]', '2023-07-25 10:31:41', '2023-07-25 10:31:41'),
(31, 'SP5f-5k1QYRyM-Cdq5', NULL, 'link-country', '{\"en\":\"link-country\"}', 'country', '{\"en\":\"link-country\"}', '{\"en\":\"link-country\"}', '[\"link-country\"]', '2023-07-25 11:31:52', '2023-07-25 11:31:52'),
(32, '3LNf-S9nQ82eM-wEZS', NULL, 'feature-link', '{\"en\":\"feature-link\"}', 'feature', '{\"en\":\"link-country\"}', '{\"en\":\"link-country\"}', '[\"link-country\"]', '2023-07-25 11:31:52', '2023-07-25 11:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `plugin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `uid`, `key`, `value`, `status`, `plugin`, `created_at`, `updated_at`) VALUES
(1, NULL, 'site_name', 'quick_pack', '1', '1', NULL, NULL),
(2, NULL, 'logo_icon', '#', '1', '1', NULL, NULL),
(3, NULL, 'site_logo', '64c9dcd6585e51690950870.png', '1', '1', NULL, '2023-08-02 04:34:31'),
(4, NULL, 'user_site_logo', '64c8e9595a4191690888537.png', '1', '1', NULL, '2023-08-01 11:15:37'),
(5, NULL, 'site_favicon', '64a969063b8621688824070.png', '1', '1', NULL, '2023-07-08 13:47:50'),
(6, NULL, 'phone', '0xxxxxxxx', '1', '1', NULL, NULL),
(7, NULL, 'address', '##', '1', '1', NULL, NULL),
(8, NULL, 'email', 'quickpack@gmail.com', '1', '1', NULL, NULL),
(9, NULL, 'user_authentication', '{\"registration\":\"1\",\"login\":\"1\",\"login_with\":[\"user_name\",\"email\",\"phone\"]}', '1', '1', NULL, '2023-07-22 11:21:53'),
(10, NULL, 'login_with', '[\"email\"]', '1', '1', NULL, NULL),
(11, NULL, 'last_corn_run', '', '1', '1', NULL, NULL),
(12, NULL, 'default_sms_template', 'hi {{name}}, {{message}}xxxx', '1', '1', NULL, NULL),
(13, NULL, 'default_mail_template', 'hi {{name}}, {{message}}', '1', '1', NULL, NULL),
(14, NULL, 'two_factor_auth', '0', '1', '1', NULL, NULL),
(15, NULL, 'two_factor_auth_with', '{\"google\":\"1\",\"sms\":\"0\",\"mail\":\"0\"}', '1', '1', NULL, NULL),
(16, NULL, 'sms_otp_verification', '1', '1', '1', NULL, NULL),
(17, NULL, 'sms_notifications', '1', '1', '1', NULL, '2023-07-19 12:21:11'),
(18, NULL, 'email_verification', '1', '1', '1', NULL, '2023-07-26 07:26:52'),
(19, NULL, 'email_notifications', '1', '1', '1', NULL, '2023-07-19 12:21:11'),
(20, NULL, 'slack_notifications', '1', '1', '1', NULL, '2023-07-19 12:21:22'),
(21, NULL, 'slack_channel', 'xxx', '1', '1', NULL, NULL),
(22, NULL, 'slack_web_hook_url', 'https://hooks.slack.com/services/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', '1', '1', NULL, NULL),
(23, NULL, 'time_zone', '\'Asia/Dhaka\'', '1', '1', NULL, NULL),
(24, NULL, 'app_debug', '1', '1', '1', NULL, '2023-07-26 07:27:42'),
(25, NULL, 'maintenance_mode', '0', '1', '1', NULL, NULL),
(26, NULL, 'demo_mode', '1', '1', '1', NULL, '2023-07-19 12:21:12'),
(27, NULL, 'pagination_number', '10', '1', '1', NULL, NULL),
(28, NULL, 'copy_right_text', '2023', '1', '1', NULL, NULL),
(29, NULL, 'country', 'United States', '1', '1', NULL, NULL),
(30, NULL, 'currency', 'USD', '1', '1', NULL, NULL),
(31, NULL, 'currency_symbol', '$', '1', '1', NULL, NULL),
(32, NULL, 'ticket_settings', '[{\"labels\":\"Subject\",\"type\":\"text\",\"required\":\"1\",\"placeholder\":\"Subject\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"subject\"},{\"labels\":\"Message\",\"type\":\"textarea\",\"required\":\"1\",\"placeholder\":\"Your Message Here ....\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"description\"},{\"labels\":\"Attachments\",\"type\":\"file\",\"required\":\"0\",\"placeholder\":\"You Can Upload Multiple File Here\",\"default\":\"1\",\"multiple\":\"1\",\"name\":\"attachment\"}]', '1', '1', NULL, '2023-08-01 10:17:05'),
(34, NULL, 'same_site_name', '0', '1', '1', NULL, '2023-08-03 10:07:51'),
(35, NULL, 'user_site_name', 'Demo Name', '1', '1', NULL, NULL),
(36, NULL, 'google_recaptcha', '{\"key\":\"6Lc5PpImAAAAABM-m4EgWw8vGEb7Tqq5bMOSI1Ot\",\"secret_key\":\"6Lc5PpImAAAAACdUh5Hth8NXRluA04C-kt4Xdbw7\",\"status\":\"0\"}', '1', '1', NULL, '2023-07-26 07:19:12'),
(37, NULL, 'strong_password', '0', '1', '1', NULL, NULL),
(38, NULL, 'captcha', '0', '1', '1', NULL, '2023-07-19 12:23:02'),
(39, NULL, 'sign_up_bonus', '0', '1', '1', NULL, NULL),
(40, NULL, 'default_recaptcha', '1', '1', '1', NULL, '2023-07-26 07:19:12'),
(41, NULL, 'captcha_with_login', '1', '1', '1', NULL, '2023-07-26 07:13:46'),
(42, NULL, 'captcha_with_registration', '0', '1', '1', NULL, '2023-07-26 07:10:02'),
(43, NULL, 'social_login', '1', '1', '1', NULL, '2023-07-31 06:39:15'),
(44, NULL, 'social_login_with', '{\"google_oauth\":{\"client_id\":\"580301070453-job03fms4l7hrlnobt7nr5lbsk9bvoq9.apps.googleusercontent.com\",\"client_secret\":\"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\",\"status\":\"1\"},\"facebook_oauth\":{\"client_id\":\"5604901016291309\",\"client_secret\":\"41c62bf15c8189171196ffde1d2a6848\",\"status\":\"1\"}}', '1', '1', NULL, NULL),
(45, NULL, 'google_map', '{\"key\":\"#\"}', '1', '1', NULL, NULL),
(46, NULL, 'storage', 'local', '1', '1', NULL, NULL),
(47, NULL, 'mime_types', '[\"gif\",\"jpeg\",\"jpg\",\"pdf\",\"png\",\"xlsx\"]', '1', '1', NULL, NULL),
(48, NULL, 'max_file_size', '20000', '1', '1', NULL, NULL),
(49, NULL, 'max_file_upload', '4', '1', '1', NULL, NULL),
(50, NULL, 'aws_s3', '{\"s3_key\":\"AKIAVHNVGMOH7UEGUX7B\",\"s3_secret\":\"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\",\"s3_region\":\"ap-southeast-1\",\"s3_bucket\":\"gen-bucket-s3\"}', '1', '1', NULL, NULL),
(51, NULL, 'ftp', '{\"host\":\"#\",\"port\":\"#\",\"user_name\":\"#\",\"password\":\"#\",\"root\":\"\\/\"}', '1', '1', NULL, NULL),
(52, NULL, 'pusher_settings', '{\"app_id\":\"1597392\",\"app_key\":\"4b046732261529561fc6\",\"app_secret\":\"f54234d02634e67d10a5\",\"app_cluster\":\"ap2\",\"chanel\":\"My-Channel\",\"event\":\"My-Event\"}', '1', '1', NULL, NULL),
(53, NULL, 'database_notifications', '1', '1', '1', NULL, '2023-07-19 12:21:21'),
(54, NULL, 'cookie', '1', '1', '1', NULL, '2023-07-19 12:21:23'),
(55, NULL, 'cookie_text', 'demo cookie_text', '1', '1', NULL, NULL),
(56, NULL, 'google_map_key', '#', '1', '1', NULL, NULL),
(57, NULL, 'geo_location', 'map_base', '1', '1', NULL, NULL),
(58, NULL, 'sentry_dns', '#', '1', '1', NULL, NULL),
(59, NULL, 'loggin_attempt_validation', '1', '1', '1', NULL, '2023-08-01 06:13:13'),
(60, NULL, 'max_login_attemtps', '5', '1', '1', NULL, NULL),
(61, NULL, 'otp_expired_in', '2', '1', '1', NULL, NULL),
(62, NULL, 'api_route_rate_limit', '1000', '1', '1', NULL, NULL),
(63, NULL, 'web_route_rate_limit', '1000', '1', '1', NULL, NULL),
(64, NULL, 'primary_color', '#673ab7', '1', '1', NULL, NULL),
(65, NULL, 'secondary_color', '#ba6cff', '1', '1', NULL, NULL),
(66, NULL, 'text_primary', '#26152e', '1', '1', NULL, NULL),
(67, NULL, 'text_secondary', '#777777', '1', '1', NULL, NULL),
(68, NULL, 'user_registration_settings', '[{\"labels\":\"Name\",\"order\":\"1\",\"width\":\"50\",\"status\":\"1\",\"type\":\"text\",\"required\":\"1\",\"placeholder\":\"Name\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"name\"},{\"labels\":\"Email\",\"order\":\"2\",\"width\":\"50\",\"status\":\"1\",\"type\":\"email\",\"required\":\"1\",\"placeholder\":\"Email\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"email\"},{\"labels\":\"Username\",\"order\":\"3\",\"width\":\"50\",\"status\":\"1\",\"type\":\"text\",\"required\":\"1\",\"placeholder\":\"Enter Your User Name\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"user_name\"},{\"labels\":\"phone\",\"order\":\"7\",\"width\":\"50\",\"status\":\"1\",\"type\":\"text\",\"required\":\"1\",\"placeholder\":\"Enter Your Phone Number\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"phone\"},{\"labels\":\"Country Code\",\"order\":\"6\",\"width\":\"50\",\"status\":\"0\",\"type\":\"select\",\"required\":\"1\",\"placeholder\":\"Enter Your Phone Number\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"country_code\"},{\"labels\":\"Password\",\"order\":\"8\",\"width\":\"50\",\"status\":\"1\",\"type\":\"password\",\"required\":\"1\",\"placeholder\":\"Enter Password\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"password\"},{\"labels\":\"Confirm Password\",\"order\":\"9\",\"width\":\"50\",\"status\":\"1\",\"type\":\"password\",\"required\":\"1\",\"placeholder\":\"Enter Confirm password\",\"default\":\"1\",\"multiple\":\"0\",\"name\":\"password_confirmation\"}]', '1', '1', NULL, '2023-07-13 10:58:11'),
(69, NULL, 'registration_otp_verification', '1', '1', '1', NULL, '2023-07-12 05:52:16'),
(70, NULL, 'otp_expired_status', '1', '1', '1', NULL, NULL),
(71, NULL, 'site_description', 'demo descriptionasdsadas', '1', '1', NULL, NULL),
(72, NULL, 'fb_page_url', 'https://www.facebook.com/username', '1', '1', NULL, NULL),
(73, NULL, 'twiter_username', 'username', '1', '1', NULL, NULL),
(74, NULL, 'telegram_page_url', 'username', '1', '1', NULL, NULL),
(75, NULL, 'time_before_redirection', '10', '1', '1', NULL, NULL),
(76, NULL, 'google_adsense_publisher_id', '3946581831511788', '1', '1', NULL, NULL),
(77, NULL, 'google_analytics_tracking_id', 'GTM-K8HWMJ4S', '1', '1', NULL, NULL),
(78, NULL, 'history_feature', '1', '1', '1', NULL, '2023-07-19 12:38:56'),
(79, NULL, 'link_review', '1', '1', '1', NULL, '2023-07-22 10:28:12'),
(80, NULL, 'show_qr_code', '1', '1', '1', NULL, '2023-07-19 12:38:57'),
(81, NULL, 'random_link_icon', '1', '1', '1', NULL, '2023-07-19 12:38:58'),
(82, NULL, 'link_report', '1', '1', '1', NULL, '2023-07-19 12:38:58'),
(83, NULL, 'show_pages_in_header', '1', '1', '1', NULL, '2023-08-01 05:29:13'),
(84, NULL, 'breadcrumbs', '1', '1', '1', NULL, '2023-07-20 11:48:06'),
(85, NULL, 'pre_loader', '1', '1', '1', NULL, NULL),
(86, NULL, 'backend_pre_loader', '1', '1', '1', NULL, NULL),
(87, NULL, 'ip_base_view_count', '1', '1', '1', NULL, '2023-07-26 07:27:02'),
(88, NULL, 'social_sharing', '1', '1', '1', NULL, NULL),
(89, NULL, 'google_ads', '0', '1', '1', NULL, '2023-08-02 07:40:52'),
(90, NULL, 'vistors', '10000', '1', '1', NULL, NULL),
(91, NULL, 'expired_data_delete', '1', '1', '1', NULL, '2023-08-03 10:09:47'),
(92, NULL, 'expired_data_delete_after', '10', '1', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_gateways`
--

CREATE TABLE `sms_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credential` longtext COLLATE utf8mb4_unicode_ci,
  `default` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Yes : 1,No : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_gateways`
--

INSERT INTO `sms_gateways` (`id`, `uid`, `created_by`, `updated_by`, `code`, `name`, `credential`, `default`, `created_at`, `updated_at`) VALUES
(5, '9lTy-FjvfYq1N-FmN3', 1, 1, '101NEX', 'Nexmo', '{\"api_key\":\"#xx\",\"api_secret\":\"#xx\",\"sender_id\":\"#xx\"}', '0', '2023-07-10 11:45:34', '2023-07-15 11:23:30'),
(6, 'xlUE-aRuvlipA-iVI0', 1, 1, '104INFO', 'InfoBip', '{\"sender_id\":\"igen\",\"infobip_api_key\":\"cf92d0da252958d69dc19f6d8bf4efc4-58719726-9d3d-4f43-a0c0-e1d50ea0a7b6\",\"infobip_base_url\":\"ejr1q3.api.infobip.com\"}', '1', '2023-07-10 11:45:34', '2023-07-13 09:35:38'),
(7, '5FW0-3yP6UYfO-7fks', 1, 1, '102TWI', 'Twilio', '{\"account_sid\":\"#\",\"auth_token\":\"#\",\"from_number\":\"#\"}', '0', '2023-07-10 11:45:34', '2023-07-10 11:45:51'),
(8, 'JMJ2-eZHZcEbd-KdG2', 1, 1, '103BIRD', 'Message Bird', '{\"access_key\":\"#\"}', '0', '2023-07-10 11:45:34', '2023-07-10 11:45:51');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `uid`, `email`, `created_at`, `updated_at`) VALUES
(1, 'da8T-Zud2OF08-Drf9', 'sad@gmail.com', '2023-07-23 07:46:59', '2023-07-23 07:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `package_id` bigint UNSIGNED DEFAULT NULL,
  `payment_amount` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx_id` text COLLATE utf8mb4_unicode_ci,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Expired : 0,Running : 1,Inactive: 2',
  `expired_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `admin_id`, `package_id`, `payment_amount`, `trx_id`, `remarks`, `status`, `expired_at`, `created_at`, `updated_at`) VALUES
(7, 1, NULL, 2, '0', '3OYOSCNSFN5O', 'Free Packages', '2', '2023-08-04', '2023-07-28 13:12:22', '2023-08-03 11:45:03'),
(11, 1, NULL, 3, '26', 'XR336JVHEQOA', 'adasd', '2', NULL, '2023-07-30 08:09:54', '2023-08-03 11:45:03'),
(12, 1, NULL, 3, '2', 'Q7MXD4QGWR7T', 'Payment Via stripe', '2', NULL, '2023-07-30 17:15:08', '2023-08-03 11:45:03'),
(13, 1, NULL, 3, '2', 'A9KO6ZWX4ND4', 'Payment Via stripe', '2', NULL, '2023-07-30 17:16:18', '2023-08-03 11:45:03'),
(14, 1, NULL, 3, '2', 'VMNSTCMOEKOW', 'Payment Via flutterwave', '2', NULL, '2023-07-31 07:51:02', '2023-08-03 11:45:03'),
(15, 1, NULL, 3, '2', 'NEKR968SO54T', 'Payment Via stripe', '2', NULL, '2023-07-31 08:56:47', '2023-08-03 11:45:03'),
(16, 1, NULL, 3, '2', 'JPBDNAKW95QB', 'Payment Via razorpay', '2', NULL, '2023-07-31 10:00:32', '2023-08-03 11:45:03'),
(17, 1, NULL, 3, '2', 'JZGWR95W3WNT', 'Payment Via stripe', '2', NULL, '2023-08-02 11:23:16', '2023-08-03 11:45:03'),
(18, 1, NULL, 3, '2', 'PRNQVZ5J2YG2', 'Payment Via flutterwave', '2', NULL, '2023-08-02 11:35:08', '2023-08-03 11:45:03'),
(19, 1, NULL, 3, '2', 'Y2CF8QFE4KFD', 'Success', '2', NULL, '2023-08-03 05:27:52', '2023-08-03 11:45:03'),
(20, 1, NULL, 3, '2', 'M6CMVFHJM6F7', 'sadasdsad', '2', NULL, '2023-08-03 05:43:39', '2023-08-03 11:45:03'),
(21, 1, NULL, 4, '243880', 'TTSCCK6ENGGB', 'Test', '2', '2023-09-02', '2023-08-03 08:43:32', '2023-08-03 11:45:03'),
(22, 1, NULL, 3, '2', '357ECOX59KSJ', 'DemO Remarks', '2', NULL, '2023-08-03 08:48:19', '2023-08-03 11:45:03'),
(23, 1, NULL, 3, '300', 'G7DFS3TBG7W4', 'ssa', '2', '2023-08-02', '2023-08-03 08:53:32', '2023-08-03 11:45:03'),
(24, 1, NULL, 3, '2', '4QZWZD3KENNJ', 'Payment Via stripe', '1', NULL, '2023-08-03 11:45:03', '2023-08-03 11:45:03'),
(25, 37, NULL, 2, '0', 'FSH8JSDTKFUA', 'Free Packages', '1', '2023-08-10', '2023-08-03 12:08:41', '2023-08-03 12:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `sms_body` longtext COLLATE utf8mb4_unicode_ci,
  `sort_code` json DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `uid`, `created_by`, `updated_by`, `name`, `slug`, `subject`, `body`, `sms_body`, `sort_code`, `status`, `created_at`, `updated_at`) VALUES
(1, '4dz9-nd6R0Li7-UxPm', 1, 1, 'Password Reset', 'PASSWORD_RESET', 'Password Reset', 'We have received a request to reset the password for your account on {{code}} and Request time {{time}}', '', '{\"code\": \"Password Reset Code\", \"time\": \"Password Reset Time\"}', '1', '2023-07-09 18:16:01', '2023-07-09 18:16:01'),
(2, '5jPk-m651ktiy-DsnL', 1, 1, 'Password Reset Confirm', 'PASSWORD_RESET_CONFIRM', 'Password Reset Confirm', '<p>We have received a request to reset the password for your account on {{code}} and Request time {{time}}</p>', '', '{\"code\": \"Password Reset Code\", \"time\": \"Password Reset Time\"}', '1', '2023-07-09 18:16:01', '2023-07-10 11:46:16'),
(3, 'wXzb-27IMnHwQ-wDq9', 1, 1, 'Registration Verify', 'REGISTRATION_VERIFY', 'Registration Verify', '<p> We have received a request to create an account, you need to verify your email first, your    verification code is {{code}} and request time {{time}} !!<br><br></p>', NULL, '{\"code\": \"Verification Code\", \"time\": \"Time\"}', '1', '2023-07-09 18:16:02', '2023-07-12 07:08:01'),
(4, '4C11-IEOYjIsR-IYO7', 1, 1, 'Support Ticket', 'SUPPORT_TICKET_REPLY', 'Support Ticket Reply', '<p>Hello Dear ! To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket &nbsp;<a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>', 'Hello Dear ! To get a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}', '{\"link\": \"Ticket URL For relpy\", \"ticket_number\": \"Support Ticket Number\"}', '1', '2023-07-09 18:16:02', '2023-07-09 18:16:02'),
(5, 'jCOJ-mQTvHk8L-oib9', 1, 1, 'Mail Configuration Test', 'TEST_MAIL', 'Test Mail', '<h5>This is testing mail for mail configuration.</h5><h5>Request time<span style=\"background-color: rgb(255, 255, 0);\"> {{time}}</span></h5>', '', '{\"time\": \"Time\"}', '1', '2023-07-09 18:16:02', '2023-07-09 18:16:02'),
(6, '40N5-qWsaxZQl-WIT3', 1, 1, 'Ticket Replay', 'TICKET_REPLY', 'Support Ticket Reply', '<p>Hello Dear! ({{role}}) {{name}}!! Just Replied To A Ticket..  To provide a response to Ticket ID {{ticket_number}},&nbsp;<br>kindly click the link provided below in order to reply to the ticket. <a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>', 'Hello Dear! ({{role}}) {{name}}!! Just Replied To A Ticket.. \r\n            To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}', '{\"link\": \"Ticket URL For relpy\", \"name\": \"Admin/Agent/User Name\", \"role\": \"Admin Role\", \"ticket_number\": \"Support Ticket Number\"}', '1', '2023-07-09 18:16:02', '2023-07-09 18:16:02'),
(7, 'FuR2-jeAVmduS-O7A9', 1, 1, 'Contact Message', 'CONTACT_REPLY', 'Contact Message reply', '<p>Hello Dear! {{email}} {{message}}<br></p>', 'xxxx', '{\"email\": \"email\", \"message\": \"message\"}', '1', '2023-07-09 18:16:57', '2023-07-23 08:56:09'),
(8, '2zQ1-EU4iwmwX-rza4', 1, 1, 'OTP Verificaton', 'OTP_VERIFY', 'OTP Verificaton', NULL, 'Your Otp {{otp}} and request time {{time}}', '{\"otp\": \"otp\", \"time\": \"Time\"}', '1', '2023-07-13 05:41:09', '2023-07-15 10:49:56'),
(10, '6LrX-AeqwLtxl-Ztot', 1, 1, 'Subscription Expired', 'SUBSCRIPTION_EXPIRED', 'Subscription Expired', 'Your {{name}} Package Subscription Has Been Expired!! at time {{time}}', '', '{\"name\": \"Package Name\", \"time\": \"Time\"}', '1', '2023-07-28 12:33:01', '2023-07-28 12:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ticket_data` text COLLATE utf8mb4_unicode_ci,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT 'Open: 1, Pending: 2, Processing: 3, Closed: 4 ,Solved: 5 ,On-Hold: 6',
  `priority` tinyint DEFAULT NULL COMMENT 'Urgent: 1, High: 2, Low: 3, Medium: 4',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `uid`, `ticket_number`, `user_id`, `ticket_data`, `subject`, `message`, `status`, `priority`, `created_at`, `updated_at`) VALUES
(9, '2HzB-1eL0129g-FROn', '64C8DBF6', 1, '{\"subject\":\"sadsa\",\"description\":\"<p>fasfasf<\\/p>\"}', 'sadsa', '<p>fasfasf</p>', 2, 1, '2023-08-01 10:18:30', '2023-08-01 10:18:30'),
(10, '7A3Z-cbZLud4H-GKeI', '64C8E390', 1, '{\"subject\":\"Demo Subject\",\"description\":\"<p>Demo SubjectDemo SubjectDemo SubjectDemo Subject<br><\\/p>\"}', 'Demo Subject', '<p>Demo SubjectDemo SubjectDemo SubjectDemo Subject<br></p>', 1, 1, '2023-08-01 10:50:56', '2023-08-01 10:50:56'),
(11, '6JzK-7N1kA1qp-enio', '64C8E853', 1, '{\"subject\":\"asdsadasd\",\"description\":\"<p>asd<\\/p>\"}', 'asdsadasd', '<p>asd</p>', 2, 1, '2023-08-01 11:11:15', '2023-08-01 11:11:15'),
(12, 'Jxmz-q346U90r-Gg55', '64C8E860', 1, '{\"subject\":\"asdsadasd\",\"description\":\"<p>asd<\\/p>\"}', 'asdsadasd', '<p>asd</p>', 2, 1, '2023-08-01 11:11:28', '2023-08-01 11:11:28'),
(14, 'IRd7-SEoRyrVN-oKF4', '64C8E9EC', 1, '{\"subject\":\"Tempore dolorem quo\",\"description\":\"asdsadsad\"}', 'Tempore dolorem quo', 'asdsadsad', 3, 3, '2023-08-01 11:18:04', '2023-08-02 08:32:56'),
(15, 'i4oP-lYcZLpPw-36w5', '64CB9BC9', 37, '{\"subject\":\"Test\",\"description\":\"<p>This is a test<\\/p>\"}', 'Test', '<p>This is a test</p>', 2, 3, '2023-08-03 12:21:29', '2023-08-03 12:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `method_id` bigint UNSIGNED DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `charge` double(8,2) DEFAULT NULL,
  `final_amount` double(8,2) DEFAULT NULL,
  `trx_id` text COLLATE utf8mb4_unicode_ci,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `admin_id`, `method_id`, `amount`, `charge`, `final_amount`, `trx_id`, `remarks`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, NULL, 0.00, 0.00, 0.00, 'MBCBTQKEDZ83', NULL, '2023-07-28 12:47:07', '2023-07-28 12:47:07'),
(3, 1, NULL, NULL, 0.00, 0.00, 0.00, '3OYOSCNSFN5O', NULL, '2023-07-28 13:12:22', '2023-07-28 13:12:22'),
(4, 1, NULL, NULL, 0.00, 0.00, 0.00, 'QZX8JJBA79VR', NULL, '2023-07-30 08:00:09', '2023-07-30 08:00:09'),
(5, 1, NULL, 26, 25.00, 1.00, 26.00, 'XR336JVHEQOA', 'adasd', '2023-07-30 08:09:54', '2023-07-30 08:09:54'),
(6, 1, NULL, 4, 1.00, 1.00, 2.00, 'Q7MXD4QGWR7T', 'Payment Via stripe', '2023-07-30 17:15:08', '2023-07-30 17:15:08'),
(7, 1, NULL, 4, 1.00, 1.00, 2.00, 'A9KO6ZWX4ND4', 'Payment Via stripe', '2023-07-30 17:16:18', '2023-07-30 17:16:18'),
(8, 1, NULL, 9, 1.00, 1.00, 2.00, 'VMNSTCMOEKOW', 'Payment Via flutterwave', '2023-07-31 07:51:02', '2023-07-31 07:51:02'),
(9, 1, NULL, 4, 1.00, 1.00, 2.00, 'NEKR968SO54T', 'Payment Via stripe', '2023-07-31 08:56:47', '2023-07-31 08:56:47'),
(10, 1, NULL, 10, 1.00, 1.00, 2.00, 'JPBDNAKW95QB', 'Payment Via razorpay', '2023-07-31 10:00:32', '2023-07-31 10:00:32'),
(11, 1, NULL, 4, 1.00, 1.00, 2.00, 'JZGWR95W3WNT', 'Payment Via stripe', '2023-08-02 11:23:15', '2023-08-02 11:23:15'),
(12, 1, NULL, 9, 1.00, 1.00, 2.00, 'PRNQVZ5J2YG2', 'Payment Via flutterwave', '2023-08-02 11:35:08', '2023-08-02 11:35:08'),
(13, 1, NULL, 26, 1.00, 1.00, 2.00, 'Y2CF8QFE4KFD', 'Success', '2023-08-03 05:27:52', '2023-08-03 05:27:52'),
(14, 1, NULL, 26, 1.00, 1.00, 2.00, 'M6CMVFHJM6F7', 'sadasdsad', '2023-08-03 05:43:39', '2023-08-03 05:43:39'),
(15, 1, NULL, 3, 23900.00, 488.00, 243880.00, 'TTSCCK6ENGGB', 'Test', '2023-08-03 08:43:32', '2023-08-03 08:43:32'),
(16, 1, NULL, 4, 1.00, 1.00, 2.00, '357ECOX59KSJ', 'DemO Remarks', '2023-08-03 08:48:19', '2023-08-03 08:48:19'),
(17, 1, NULL, 1, 1.00, 2.00, 300.00, 'G7DFS3TBG7W4', 'ssa', '2023-08-03 08:53:32', '2023-08-03 08:53:32'),
(18, 1, NULL, 4, 1.00, 1.00, 2.00, '4QZWZD3KENNJ', 'Payment Via stripe', '2023-08-03 11:45:03', '2023-08-03 11:45:03'),
(19, 37, NULL, NULL, 0.00, 0.00, 0.00, 'FSH8JSDTKFUA', NULL, '2023-08-03 12:08:41', '2023-08-03 12:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `uid`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'nHbj-2L47Xxvs-MZo8', 'en', 'cache_cleared_successfully', 'Cache Cleared Successfully', '2023-08-02 10:51:52', '2023-08-02 10:51:52'),
(2, '1L0d-KtOlr2Zf-IbgR', 'en', 'email_notification', 'Email Notification', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(3, '0aaY-MKMQUdXM-yDOA', 'en', 'when_enabled_this_module_sends_necessary_emails_to_users_if_disabled_no_emails_will_be_sent_prior_to_disabling_ensure_there_are_no_pending_emails', 'When enabled, this module sends necessary emails to users. If disabled, no emails will be sent. Prior to disabling, ensure there are no pending emails.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(4, 'J6MV-F19ILp4c-Pp86', 'en', 'demo_mode', 'Demo Mode', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(5, '3OjK-0yn3uAbg-XoSk', 'en', 'enable_site_demo_mode_to_showcase_your_website_with_restricted_access_to_certain_features_disable_it_to_restore_full_functionality', 'Enable Site Demo Mode to showcase your website with restricted access to certain features. Disable it to restore full functionality.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(6, 'scHl-np689LqY-zZm2', 'en', 'database_notifications', 'Database Notifications', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(7, '4syV-UHQhriIx-hZa4', 'en', 'enable_this_module_for_notifications_on_database_events_eg_new_ticket_generation_new_messages_to_users_agents_and_administrators', 'Enable this module for notifications on database events (e.g., New Ticket Generation, New Messages) to users, agents, and administrators.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(8, '3I8i-EEoiuUVk-1nZ1', 'en', 'cookie_activation', 'Cookie Activation', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(9, 'wK2R-8oF4zuz6-sBX5', 'en', 'enabling_this_module_activates_the_accept_cookie_prompt_allowing_personalized_user_tracking_with_small_files_on_their_computer', 'Enabling this module activates the Accept Cookie prompt, allowing personalized user tracking with small files on their computer', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(10, 'rA9V-pkI3doIT-JuR1', 'en', 'app_debug', 'App Debug', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(11, '6WoB-2yYq3UtV-zAeY', 'en', 'enabling_this_module_activates_system_debugging_mode_aiding_in_troubleshooting_by_providing_detailed_error_messages_to_identify_code_issues', 'Enabling this module activates system debugging mode, aiding in troubleshooting by providing detailed error messages to identify code issues.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(12, '7ktq-h7I3ACRL-xEBy', 'en', 'user_registration', 'User Registration', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(13, '35wl-56weq3db-LFh2', 'en', 'enabling_the_module_activates_the_user_register_module_indicating_their_interdependency_for_proper_functioning', 'Enabling the module activates the User Register Module, indicating their interdependency for proper functioning.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(14, '1ebx-yXJ1BEkN-qBda', 'en', 'social_auth', 'Social Auth', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(15, 'xb5c-V5GJGqbd-QMp8', 'en', 'it_allows_users_to_sign_in_or_register_using_their_social_media_accounts', 'It allows users to sign in or register using their social media accounts', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(16, '0pEp-rVMAuDSM-PoxR', 'en', 'email_verfications', 'Email Verfications', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(17, 'pHH7-NMhYf7Zu-yIm7', 'en', 'when_enabled_this_module_prompts_users_to_verify_their_email_addresses_during_registration_by_clicking_a_link_or_entering_a_code_sent_to_their_email', 'When enabled, this module prompts users to verify their email addresses during registration by clicking a link or entering a code sent to their email.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(18, 'fw4H-ayLW2KDX-NL96', 'en', 'link_visit_history_feature', 'Link Visit History Feature', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(19, '6SG2-aeScb31g-tNvr', 'en', 'this_feature_provides_a_record_of_users_visited_links_enabling_them_to_review_their_browsing_history', 'This feature provides a record of users visited links, enabling them to review their browsing history.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(20, '5EK8-y7APYTXH-X6J4', 'en', 'link__article_review_feature', 'Link & Article Review Feature', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(21, '1Ugl-aVX1up7q-MEYA', 'en', 'this_feature_allows_users_to_provide_reviews_and_feedback_on_links_and_articles_they_have_accessed_enhancing_user_engagement_and_content_assessment', 'This feature allows users to provide reviews and feedback on links and articles they have accessed, enhancing user engagement and content assessment.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(22, '8bd2-YICPwzsV-GMIa', 'en', 'google_ads', 'Google Ads', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(23, '8k5g-3tWuMjAT-TofZ', 'en', 'it_allows_showcasing_targeted_advertisements_based_on_the_user_visiting_the_webpage', 'It allows showcasing targeted advertisements based on the user visiting the webpage', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(24, 'dRha-uGr5uhm4-O9Q7', 'en', 'show_random_link_icon_in_header', 'Show Random Link Icon In Header', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(25, 'KQz6-oe0dFXrr-oxF4', 'en', 'adds_a_dynamic_icon_that_redirects_users_to_random_links_for_an_engaging_and_surprising_experience', 'Adds a dynamic icon that redirects users to random links for an engaging and surprising experience.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(26, '1qbx-PRid8I1m-fUzi', 'en', 'view_count_by_ip', 'View Count By Ip', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(27, 'iE0L-L3fqtPFj-HxT5', 'en', 'tracks_the_number_of_views_from_unique_ip_addresses_providing_valuable_insights_into_user_engagement_and_traffic_patterns_on_your_website', 'Tracks the number of views from unique IP addresses, providing valuable insights into user engagement and traffic patterns on your website.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(28, 'majq-dfmQxzVc-6gy4', 'en', 'social_sharing', 'Social Sharing', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(29, '2fz4-QmQQPVZm-vfKX', 'en', 'enables_users_to_easily_share_content_from_your_website_on_various_social_media_platforms_boosting_visibility_and_user_engagement', 'Enables users to easily share content from your website on various social media platforms, boosting visibility and user engagement.', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(30, '0P6I-OHLs9l6R-TbB6', 'en', 'show_pages_in_header', 'Show Pages In Header', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(31, 'JGwj-BmUNJZ0p-Nas2', 'en', 'enables_a_pages_section_inside_the_website_header', 'Enables a \'Pages\' section inside the website header', '2023-08-02 10:51:53', '2023-08-02 10:51:53'),
(32, 'dvNG-FLAx9Tye-Eoa3', 'en', 'system_configuration', 'System Configuration', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(33, '8TkS-84Gm9B39-JMtT', 'en', 'notification', 'Notification', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(34, 'OaNc-PNT8oBv3-ilm6', 'en', 'new', 'New', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(35, '7XKo-I9jx0jtn-dOs3', 'en', 'view_all', 'View All', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(36, '8GWo-Eaa64HkE-QeQs', 'en', 'welcome', 'Welcome', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(37, '9Ou2-ZDGNdAkc-drBZ', 'en', 'setting', 'Setting', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(38, 'KWVh-2TvTQI9T-2ml6', 'en', 'do_you_really_want_to_sign_out__', 'Do You Really Want To Sign out ?? ', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(39, 'AHUZ-4K7HggMw-dPV6', 'en', 'logout', 'logout', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(40, 'tHsq-XYTGTCM0-IF74', 'en', 'are_you_sure', 'Are You Sure!!', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(41, 'HLzX-62f8z8tt-Xo49', 'en', 'no', 'No', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(42, '3Vhp-4Ie670cQ-Dvey', 'en', 'yes', 'Yes', '2023-08-02 10:51:54', '2023-08-02 10:51:54'),
(43, '2MIb-V8hSFgk1-dupX', 'en', 'home', 'Home', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(44, 'I48s-7AsBtsG7-WIF1', 'en', 'dashboard', 'Dashboard', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(45, 'SA5c-F8Ibk9UY-UzC6', 'en', 'pending_link', 'Pending Link', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(46, 'ztWj-0fNHgNTi-7r28', 'en', 'pending_logs', 'Pending Logs', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(47, 'N3xh-uJVPPHJJ-JRt9', 'en', 'manage_staff', 'Manage Staff', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(48, 'y3BW-V4crT68T-qpx1', 'en', 'staffs__permissions', 'Staffs & Permissions', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(49, 'lSfs-0dJw7BHE-fJP2', 'en', 'roles__permissions', 'Roles & Permissions', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(50, 'tj8O-6oVGhzb0-QSB6', 'en', 'staffs', 'Staffs', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(51, '6mff-xReiL42B-A0WY', 'en', 'language__localizations', 'Language / Localizations', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(52, '0Tpy-kGrVZvl9-UCGd', 'en', 'language', 'Language', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(53, '5qVu-wgPIlx8w-9bCs', 'en', 'plan__package', 'Plan / Package', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(54, 'kDKk-C7UQLju3-fRo3', 'en', 'package', 'Package', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(55, 'm8JK-4KmY8gy3-7kC1', 'en', 'packages', 'Packages', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(56, '437w-EgOsigNy-RY5o', 'en', 'add_new', 'Add New', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(57, 'cMW0-yw8gFnkY-BlB7', 'en', 'link_settings', 'Link Settings', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(58, '0DRb-slcBpQtq-hxDs', 'en', 'links', 'Links', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(59, 'P7pn-ZROdnIE7-FmS8', 'en', 'user_panel', 'User Panel', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(60, '5O4K-LQezVdou-olAO', 'en', 'user', 'User', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(61, '7Vm9-7CUHFm4U-O57S', 'en', 'category', 'Category', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(62, 'zEud-JztHSSq8-wdq4', 'en', 'categories', 'Categories', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(63, 'WFog-yApMPUKR-Jda2', 'en', 'log__report', 'Log & Report', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(64, 'IWI2-mUBgeOpg-aNx2', 'en', 'reports', 'Reports', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(65, 'GmBm-IzMZnI3V-7KP3', 'en', 'subscription_log', 'Subscription Log', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(66, '8r3C-9OwIayPB-dpwp', 'en', 'payment_log', 'Payment Log', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(67, '4pQc-WBDvjjHK-OcIr', 'en', 'transaction_log', 'Transaction Log', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(68, 'ocfv-7mdMKkBa-COH0', 'en', 'website_control', 'Website Control', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(69, '4X6c-5Kuftq6W-mbtb', 'en', 'manage_frontend', 'Manage Frontend', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(70, 'SiDd-Mb7KpADs-3jl5', 'en', 'frontend_section', 'Frontend Section', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(71, '046a-JJsAIMJY-wL74', 'en', 'seo', 'Seo', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(72, '562t-aX9rAYzB-b70p', 'en', 'visitors', 'Visitors', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(73, '4usi-9hoMrLEo-UQJl', 'en', 'client_review', 'Client Review', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(74, '7FRL-ygniQN1a-l4VY', 'en', 'cta', 'Cta', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(75, 'tL3s-EAHds2Ej-3C30', 'en', 'faq', 'Faq', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(76, '2ow7-iDEGyQyj-fN46', 'en', 'menu', 'Menu', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(77, '9JtA-TGSZlhvU-9ydw', 'en', 'pages', 'Pages', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(78, '6buR-T1NhkEjg-4sjr', 'en', 'article', 'Article', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(79, '4cnD-gYPPNraS-eALQ', 'en', 'articles', 'Articles', '2023-08-02 10:51:55', '2023-08-02 10:51:55'),
(80, '017q-VtK2bvrW-0nxY', 'en', 'marketing__promotion', 'Marketing & Promotion', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(81, '3DTj-j9l6x36N-hQ9Z', 'en', 'marketing__promotions', 'Marketing & Promotions', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(82, 'wheW-zC9a4dG7-YIj5', 'en', 'ads', 'Ads', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(83, 'gxsY-ATbcquBK-sdU5', 'en', 'contacts', 'Contacts', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(84, 'F9nM-sDbdyQWH-1xO4', 'en', 'subscriber', 'Subscriber', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(85, 'ogaX-n7WyOAib-2Vo5', 'en', 'notifications_template', 'Notifications Template', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(86, '9PSi-LfP2bEcE-nxST', 'en', 'templates', 'Templates', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(87, '8nil-i6ST5Hmi-Nyv3', 'en', 'notification_template', 'Notification Template', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(88, '1IOB-YjiiZoV1-LH4g', 'en', 'global_template', 'Global Template', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(89, '06j2-5e4mltdG-Lc93', 'en', 'help__support', 'Help & Support', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(90, '6lmX-J1Pqmr2p-FcGp', 'en', 'support_tickets', 'Support Tickets', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(91, '58ga-o2e0ng84-DF54', 'en', 'mail__sms_settings', 'Mail & Sms Settings', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(92, '4D1n-DyoMUz2b-gQVi', 'en', 'mail_gateway', 'Mail Gateway', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(93, '4Zxq-5AWuQGWo-279v', 'en', 'sms_gateway', 'Sms Gateway', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(94, 'U1Ua-aO241T2l-RHu2', 'en', 'payment_settings', 'Payment Settings', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(95, 'n72E-LCOHl8wO-SD23', 'en', 'payment_gateway', 'Payment Gateway', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(96, 'A0hI-meNKh3Oy-UyW5', 'en', 'automatic_method', 'Automatic Method', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(97, '0Cup-v1W9m9rd-9y36', 'en', 'manual__method', 'Manual  Method', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(98, 'XAfz-U2QmDxJx-W9H8', 'en', 'adminstrator__business', 'Adminstrator / Business', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(99, '9V60-FF7AoqvN-Sen1', 'en', 'applications_settings', 'Applications Settings', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(100, 'AILq-zCmogy9V-ZNB9', 'en', 'app_settings', 'App Settings', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(101, 'evjC-PzRVsjgA-jCW5', 'en', 'system_preferences', 'System Preferences', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(102, 'MaGR-KDN04KEA-q2u4', 'en', 'softwae_info', 'Softwae Info', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(103, '5NZP-W8juiev0-r7ZQ', 'en', 'software_info', 'Software Info', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(104, '16Kl-EUEsz6tQ-mLSP', 'en', 'configuration', 'Configuration', '2023-08-02 10:51:56', '2023-08-02 10:51:56'),
(105, 'SEyV-h2XHxglZ-T961', 'en', 'search_by_title', 'Search By Title', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(106, '1prG-5KgT5ulL-gq6i', 'en', 'title', 'Title', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(107, '8FyR-35akdGWr-w4JJ', 'en', 'created_by', 'Created By', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(108, '1Oim-FpilSJUk-ubGj', 'en', 'status', 'Status', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(109, '6cnA-23iEecr7-yfWx', 'en', 'show_in_header', 'Show In Header', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(110, 'pTUW-quOyBfMl-5730', 'en', 'show_in_footer', 'Show In Footer', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(111, '1agI-4AnXHN8b-TpK4', 'en', 'options', 'Options', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(112, '1etK-i1iuch8s-vyQ3', 'en', 'action', 'Action', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(113, '0zpY-DDDqExLh-ZCRG', 'en', 'manage_page', 'Manage Page', '2023-08-02 10:56:20', '2023-08-02 10:56:20'),
(114, '4Vub-gOk7Pz06-Us21', 'en', 'search_by_name', 'Search By Name', '2023-08-02 10:56:25', '2023-08-02 10:56:25'),
(115, '3j0A-Gvym7dJH-nooP', 'en', 'name', 'Name', '2023-08-02 10:56:25', '2023-08-02 10:56:25'),
(116, 'Grbk-8oerXTgg-1dI7', 'en', 'url', 'Url', '2023-08-02 10:56:25', '2023-08-02 10:56:25'),
(117, '1Anf-cbRSDAcO-jrXV', 'en', 'add_menu', 'Add Menu', '2023-08-02 10:56:25', '2023-08-02 10:56:25'),
(118, '44wH-fwiUe1cf-K7ZR', 'en', 'enter_name', 'Enter name', '2023-08-02 10:56:26', '2023-08-02 10:56:26'),
(119, '8ihy-OdAtSRH8-Srm1', 'en', 'serial_id', 'Serial Id', '2023-08-02 10:56:26', '2023-08-02 10:56:26'),
(120, 'z2NF-7jrh8aXF-gVH3', 'en', 'enter_serial_id', 'Enter Serial Id', '2023-08-02 10:56:26', '2023-08-02 10:56:26'),
(121, 'U3om-SjjmSw4d-Ws23', 'en', 'enter_url', 'Enter url', '2023-08-02 10:56:26', '2023-08-02 10:56:26'),
(122, '3TMk-iJyrxxJi-6ejq', 'en', 'close', 'Close', '2023-08-02 10:56:26', '2023-08-02 10:56:26'),
(123, '0ZPL-c3jFjxOe-LUTd', 'en', 'submit', 'Submit', '2023-08-02 10:56:26', '2023-08-02 10:56:26'),
(124, '50OP-Gjc54TT1-1Ne7', 'en', 'manage_menu', 'Manage Menu', '2023-08-02 10:56:26', '2023-08-02 10:56:26'),
(125, '7m9i-0a57hQaO-hBp9', 'en', 'search_by_question', 'Search By Question', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(126, '0PHm-gFYOtTXE-Kd1C', 'en', 'icon', 'icon', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(127, '4KLO-xhk3xnBb-VSL9', 'en', 'question', 'Question', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(128, '5A7j-5eviRNiU-yc6S', 'en', 'answer', 'Answer', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(129, '5J3I-kpdtFyi5-vbG7', 'en', 'add_faq', 'Add faq', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(130, '2H2C-YbsBlA2G-lNt2', 'en', 'enter_question', 'Enter question', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(131, 'LTMi-LVMPniNL-MBO2', 'en', 'enter_icon', 'Enter icon', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(132, 'wzF7-IBbJ5gV4-vS33', 'en', 'type_here', 'Type Here', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(133, 'ISRT-WX7cf8O9-shl0', 'en', 'update_faq', 'Update faq', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(134, '2Odc-HqLTac8o-FNW0', 'en', 'search_here_', 'Search Here !!', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(135, '1jAa-c4PUEAge-X4od', 'en', 'manage_faq', 'Manage Faq', '2023-08-02 10:56:31', '2023-08-02 10:56:31'),
(136, '4y4D-seJhVy51-Zm7r', 'en', 'add_cta', 'Add Cta', '2023-08-02 10:56:35', '2023-08-02 10:56:35'),
(137, 'QU9J-8VcmmKsX-D6p3', 'en', 'enter_title', 'Enter title', '2023-08-02 10:56:35', '2023-08-02 10:56:35'),
(138, '6Uy8-if6gB5qc-3ziT', 'en', 'image', 'Image', '2023-08-02 10:56:35', '2023-08-02 10:56:35'),
(139, 'hCC8-gCjLAoCQ-33c4', 'en', 'description', 'Description', '2023-08-02 10:56:35', '2023-08-02 10:56:35'),
(140, 'bDyW-6IWp7Jhy-iS07', 'en', 'update_cta', 'Update Cta', '2023-08-02 10:56:35', '2023-08-02 10:56:35'),
(141, '6eQ5-0amsSTc2-QfWK', 'en', 'profile_image', 'Profile Image', '2023-08-02 10:56:35', '2023-08-02 10:56:35'),
(142, '1w80-QfK6SMw3-OQHw', 'en', 'manage_cta', 'Manage Cta', '2023-08-02 10:56:35', '2023-08-02 10:56:35'),
(143, 'PJUt-9yuBU5G0-GBB6', 'en', 'rating', 'Rating', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(144, '584I-NEQ5oXZL-Y0ZQ', 'en', 'ratting', 'Ratting', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(145, '77Mk-O5s0SoHr-55DX', 'en', 'add_client', 'Add client', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(146, '54SI-qUIhvzca-t9mo', 'en', 'address', 'Address', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(147, '7RYn-XgR9jNpR-ktMm', 'en', 'enter_address', 'Enter address', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(148, '1xGR-gjWMezIt-LQui', 'en', 'enter_rating', 'Enter rating', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(149, '7Gwc-ruVF1TmR-I4wA', 'en', 'review', 'Review', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(150, '0JPH-fVTH27Hs-0bC4', 'en', 'update_client', 'Update client', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(151, '9wsA-wLtCntkU-xEM0', 'en', 'manage_clients', 'Manage Clients', '2023-08-02 10:56:39', '2023-08-02 10:56:39'),
(152, '0gTI-VZax4XDa-9OL7', 'en', 'clients', 'Clients', '2023-08-02 10:56:40', '2023-08-02 10:56:40'),
(153, 'DEfz-htmvdap9-qMc8', 'en', 'visitor_list', 'Visitor List', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(154, 'Y3GZ-Nv81unts-lD20', 'en', 'search_by_ip', 'Search By Ip', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(155, 'oWWy-SEDDJUJI-dT20', 'en', 'ip', 'Ip', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(156, '1jyf-ApN5ubEZ-nqDI', 'en', 'last_visitsed_at', 'Last Visitsed At', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(157, '7Irm-X51AOBXO-NGzp', 'en', 'blocked', 'Blocked', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(158, 'gBVY-fB3wMJBi-AqW9', 'en', 'updated_by', 'Updated By', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(159, 'bMmr-z7pjzrnv-kaO3', 'en', 'subscribe_at', 'Subscribe At', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(160, 'D1RX-vrz0Dks2-iZI1', 'en', 'manage_visitor', 'Manage Visitor', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(161, 'U2jW-n9aK7ppi-9ZB0', 'en', 'visitor', 'Visitor', '2023-08-02 10:56:46', '2023-08-02 10:56:46'),
(162, '1fyy-WelHFIV7-k8Yk', 'en', 'seo_items', 'Seo Items', '2023-08-02 10:56:50', '2023-08-02 10:56:50'),
(163, 'HMj4-S6Wl5aSq-OBz9', 'en', 'page_title', 'Page Title', '2023-08-02 10:56:50', '2023-08-02 10:56:50'),
(164, '2p1u-Vu6IGufr-V9E1', 'en', 'url_slug', 'Url Slug', '2023-08-02 10:56:50', '2023-08-02 10:56:50'),
(165, '4vGO-ykh4iUdT-kIYh', 'en', 'meta_title', 'Meta Title', '2023-08-02 10:56:50', '2023-08-02 10:56:50'),
(166, '7biL-SL45hLnU-kr62', 'en', 'manage_seo', 'Manage Seo', '2023-08-02 10:56:50', '2023-08-02 10:56:50'),
(167, '2xmU-ijZc7i35-42jV', 'en', 'seos', 'Seos', '2023-08-02 10:56:50', '2023-08-02 10:56:50'),
(168, '9S3H-cuxaE7A0-5Y23', 'en', 'basic_information', 'Basic Information', '2023-08-02 10:56:59', '2023-08-02 10:56:59'),
(169, '3kPc-NtZR0sDt-T1bV', 'en', 'meta_description', 'Meta Description', '2023-08-02 10:56:59', '2023-08-02 10:56:59'),
(170, 'gmRV-hDXAG5ZT-fAO1', 'en', 'enter_description', 'Enter Description', '2023-08-02 10:56:59', '2023-08-02 10:56:59'),
(171, 'PtPo-l43TuXzR-tt45', 'en', 'meta_keywords', 'Meta Keywords', '2023-08-02 10:56:59', '2023-08-02 10:56:59'),
(172, 'pTI9-sFnNIaYb-rS03', 'en', 'enter_keywords', 'Enter Keywords', '2023-08-02 10:56:59', '2023-08-02 10:56:59'),
(173, 'itoH-HIAaES3c-4zq6', 'en', 'update_seo', 'Update Seo', '2023-08-02 10:56:59', '2023-08-02 10:56:59'),
(174, 'cag0-6XrO1Gap-u4B9', 'en', 'edit', 'Edit', '2023-08-02 10:57:00', '2023-08-02 10:57:00'),
(175, '55o2-1KbbN175-CCuZ', 'en', 'frontend_section_list', 'Frontend Section List', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(176, 'TKFM-1XS4Tzhg-ioA0', 'en', 'heading', 'Heading', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(177, 'IEhg-SIp4kAWS-Y294', 'en', 'motion_heading', 'Motion heading', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(178, '59j6-Z5DPs2EG-gKaq', 'en', 'short_description', 'Short description', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(179, '6UpO-AKWVOlwd-Zlwb', 'en', 'banner_image', 'Banner image', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(180, 'HM7Q-lcoAgiKC-DF68', 'en', 'sub_heading', 'Sub heading', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(181, 'Lsgx-oVnSO88R-75U7', 'en', 'btn_name', 'Btn name', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(182, 'ptfM-2YMqlGQ4-J606', 'en', 'see_icon', 'See Icon', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(183, 'fmCA-tZ5Y6Wel-fcA3', 'en', 'select_status', 'Select Status', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(184, '78rb-ageGOuGx-65LK', 'en', 'frontends', 'Frontends', '2023-08-02 10:57:04', '2023-08-02 10:57:04'),
(185, '7iIu-ANTe0hcP-3ZYN', 'en', 'feature_link', 'Feature Link', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(186, 'sxr6-DQizfTQ6-le70', 'en', 'total_review', 'Total Review', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(187, 'nI2e-BOGtoIen-JGC5', 'en', 'pending_review', 'Pending Review', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(188, '0DMi-OoQOcbHw-Hb0o', 'en', 'link_list', 'Link List', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(189, '1Oa0-KVeqnDum-VhiF', 'en', 'select_user', 'Select User', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(190, '142r-BDP8NrtG-WgWx', 'en', 'expired_at', 'Expired At', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(191, '0u9h-FarlmNA6-xmXg', 'en', 'views', 'Views', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(192, '3UQe-98uPETwl-QAup', 'en', 'likes', 'Likes', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(193, '6xhT-9fiR5uLh-ZsfJ', 'en', 'feature_on_home', 'Feature On Home', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(194, 'AP9r-98hlE2qF-A4a4', 'en', 'total_users', 'Total Users', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(195, 'xWkM-EuKIf3su-MLv7', 'en', 'total_links', 'Total Links', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(196, 'sRHu-UrX3cGB1-vHE4', 'en', 'verified', 'Verified', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(197, 'Q7QG-Mt9f2IDX-5UR1', 'en', 'pending_links', 'Pending Links', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(198, 'm71J-0ao6NQFy-Lr72', 'en', 'total_package', 'Total Package', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(199, '3E76-PxY41nsb-QKzP', 'en', 'expired_date', 'Expired Date', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(200, '5gr5-yQbi5pRU-XvT3', 'en', 'total_visitors', 'Total Visitors', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(201, 'E28k-Oa5kOJSq-KRJ2', 'en', 'view', 'View', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(202, 'ucIZ-g3syQ7o8-Ijp9', 'en', 'total_article', 'Total Article', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(203, '7VhK-HZIFfuqF-BEoq', 'en', 'total_earning', 'Total Earning', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(204, 'Oute-Pd8g6W2M-k3a6', 'en', 'total_category', 'Total Category', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(205, '4xX1-bEXMxM97-Qyu1', 'en', 'links_submission_in', 'Links Submission In', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(206, 'Tzgg-7UdRDG28-KdI4', 'en', 'visitors_by_month_in', 'Visitors By Month In', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(207, '6X0A-uu2O8ATE-nkFv', 'en', 'manage_links', 'Manage Links', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(208, '4IDo-0Z5qVbtB-oREt', 'en', 'earnings_per_month_in', 'Earnings Per Month In', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(209, '3JiI-SNLCensH-PDzm', 'en', 'links_by_user', 'Links By User', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(210, 'FuXd-ez3WWz4z-n086', 'en', 'latest_payment_log', 'Latest Payment Log', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(211, 'Ryx8-C2OLf0LD-1NS7', 'en', 'transaction_id', 'Transaction Id', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(212, 'LyBq-pdGiV8f6-nNJ9', 'en', 'method', 'Method', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(213, 'iPfm-fuCLemwc-EUS5', 'en', 'created_date', 'Created Date', '2023-08-02 11:01:23', '2023-08-02 11:01:23'),
(214, 'tAh9-FP7FDrju-PNm2', 'en', 'amount', 'Amount', '2023-08-02 11:01:24', '2023-08-02 11:01:24'),
(215, 'CABA-BzWo7Z73-cnX3', 'en', 'date', 'Date', '2023-08-02 11:01:24', '2023-08-02 11:01:24'),
(216, '0jUK-Xxu3hTYB-1fcf', 'en', 'pending', 'Pending', '2023-08-02 11:01:24', '2023-08-02 11:01:24'),
(217, 'MLI6-IAyPBoR7-JPh3', 'en', 'visitors_per_months', 'Visitors Per Months', '2023-08-02 11:01:24', '2023-08-02 11:01:24'),
(218, '7mNz-WPpzYKSY-86cW', 'en', 'create_link', 'Create Link', '2023-08-02 11:10:39', '2023-08-02 11:10:39'),
(219, '8tIK-Bzm7iP8i-Nv3R', 'en', 'my_profile', 'My Profile', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(220, 'IVh4-xTUcORfw-Zfu8', 'en', 'my_links', 'My Links', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(221, 'tVBD-XF5uQRDd-YRX6', 'en', 'favourite_links', 'Favourite Links', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(222, '49rv-K8R3bsbR-Od3f', 'en', 'link_browsing_history', 'Link Browsing History', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(223, 'euBN-biu5MhdM-QSn1', 'en', 'pricing_plan', 'Pricing Plan', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(224, '8PfG-4gSGERKm-BjqU', 'en', 'subscription', 'Subscription', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(225, 'PEVr-qnJrqeIS-Sji4', 'en', 'transaction', 'Transaction', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(226, '8S7M-MgOCewto-KFS2', 'en', 'support_ticket', 'Support Ticket', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(227, 't7VN-W3yxoXY0-ne27', 'en', 'visible_url', 'Visible Url', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(228, 'lWrh-wWpJQaMX-YAC3', 'en', 'enter_visible_url', 'Enter Visible Url', '2023-08-02 11:10:40', '2023-08-02 11:10:40'),
(229, 'BWsj-Vvt9OpDe-t0H9', 'en', 'must_be_unique', 'Must Be Unique', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(230, 'M5BK-5t5bFTQg-Zn46', 'en', 'slug', 'Slug', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(231, '4Y1I-fox5DlzN-nNgb', 'en', 'enter_slug', 'Enter Slug', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(232, 'aVQr-SKNK4do2-cQG6', 'en', 'phone', 'Phone', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(233, '4EYa-bjhTTboq-ssYT', 'en', 'enter_phone', 'Enter Phone', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(234, '4PY0-1QQ3RfJg-3qUA', 'en', 'email', 'Email', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(235, '2HI1-mrdccWqv-btY0', 'en', 'enter_email', 'Enter Email', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(236, '1tty-GQHUZwCb-q1wn', 'en', 'link__attribute', 'Link  Attribute', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(237, '4I8o-5RxX7xq0-wuc7', 'en', 'select_category', 'Select Category', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(238, 'MZoW-WIWXJNYu-swS5', 'en', 'tags', 'Tags', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(239, 'bxug-95kpRtjf-QQF2', 'en', 'thumbnail_image', 'Thumbnail Image', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(240, 'wDvC-a7oEiPN6-PAN3', 'en', 'gallary_image', 'Gallary Image', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(241, '8fxN-8irEwQ7U-7PQf', 'en', 'max_4_files', 'Max 4 Files', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(242, '1kJv-RR3Z4ITm-PSjQ', 'en', 'deep_links', 'Deep Links', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(243, 'lQPF-KjyuqA7e-BD54', 'en', 'social_media', 'Social Media', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(244, 'KtZA-FftdsT42-BcQ2', 'en', 'facebook_url', 'Facebook Url', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(245, 'VI8P-RBAdws51-jsq2', 'en', 'twitter_url', 'Twitter URL', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(246, '3a8q-LEBqgClL-coUa', 'en', 'instagram_url', 'Instagram URL', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(247, '6OoG-kd8BeUEB-K3l6', 'en', 'linkedin_url', 'LinkedIn URL', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(248, 'Kslh-ZsRPQ0Gr-1kx9', 'en', 'whatsapp_number', 'WhatsApp Number', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(249, 'RmDj-CJ9MvQSG-47o0', 'en', 'enter_number', 'Enter Number', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(250, 'YpRD-hGuGAlMd-8GT1', 'en', 'telegram__url', 'Telegram  URL', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(251, '6Dym-mWXjM4pn-ZKfH', 'en', 'other_settings', 'Other Settings', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(252, '4Fuj-iXalT74j-wzR2', 'en', 'feature_on__home', 'Feature On  Home', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(253, '2V5k-TLECeGk7-ml1X', 'en', 'enable_qr_code', 'Enable Qr Code', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(254, '9EJC-GRPjWV0q-FX6s', 'en', 'bypass_details_page', 'Bypass Details Page', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(255, 'ubfF-NT45ANvK-N449', 'en', 'seo_settings', 'Seo Settings', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(256, '7yQA-2SLJ12td-uM4x', 'en', 'select_item', 'Select Item', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(257, 'oLbT-8gmbDhjr-mzw4', 'en', 'enter_tags', 'Enter Tags', '2023-08-02 11:10:41', '2023-08-02 11:10:41'),
(258, '731k-hr6XfrpH-jLAq', 'en', 'feedback', 'Feedback', '2023-08-02 11:10:42', '2023-08-02 11:10:42'),
(259, '9jsT-tgLo4CPy-TpkY', 'en', 'favourite_link', 'Favourite Link', '2023-08-02 11:11:04', '2023-08-02 11:11:04'),
(260, '0wxK-NwLWb3yb-MDFC', 'en', 'link', 'Link', '2023-08-02 11:11:04', '2023-08-02 11:11:04'),
(261, 'Z9YR-vbYZCncF-jbY6', 'en', 'expire_date', 'Expire Date', '2023-08-02 11:11:05', '2023-08-02 11:11:05'),
(262, 'cC5v-JidKQGtk-D7f5', 'en', 'breaking_news_latest_news_and_videos__cnn', 'Breaking News, Latest News and Videos | CNN', '2023-08-02 11:11:05', '2023-08-02 11:11:05'),
(263, 'UkG0-6CWZZYHG-FnB7', 'en', 'na', 'N/A', '2023-08-02 11:11:05', '2023-08-02 11:11:05'),
(264, '1c9M-WOyeuKyQ-3tkh', 'en', 'option', 'Option', '2023-08-02 11:11:05', '2023-08-02 11:11:05'),
(265, 'NUrV-bCmtxmRC-pJD2', 'en', 'starlink', 'Starlink', '2023-08-02 11:11:05', '2023-08-02 11:11:05'),
(266, 'IwSM-cLnIUGyS-Y487', 'en', 'official_international_cricket_council_website', 'Official International Cricket Council Website', '2023-08-02 11:11:05', '2023-08-02 11:11:05'),
(267, '1YBp-nsk3jptS-BDXq', 'en', 'spacex', 'SpaceX', '2023-08-02 11:11:05', '2023-08-02 11:11:05'),
(268, '7U74-1U5sGep7-HOVP', 'en', 'adobe_creative_marketing_and_document_management_solutions', 'Adobe: Creative, marketing and document management solutions', '2023-08-02 11:11:05', '2023-08-02 11:11:05'),
(269, 'MPAT-yc9awjsB-wDw5', 'en', 'linkbrowsing', 'Link-Browsing', '2023-08-02 11:11:11', '2023-08-02 11:11:11'),
(270, '0QGN-KySW8nwh-4aky', 'en', 'visited_links', 'Visited Links', '2023-08-02 11:11:12', '2023-08-02 11:11:12'),
(271, '0yEg-Li8llvaa-iJo9', 'en', 'clear', 'Clear', '2023-08-02 11:11:12', '2023-08-02 11:11:12'),
(272, 'dhiF-c3o2UpE2-bae8', 'en', 'fox_sports_news_scores_schedules_odds_shows_streams__videos__fox_sports', 'FOX Sports News, Scores, Schedules, Odds, Shows, Streams & Videos | FOX Sports', '2023-08-02 11:11:12', '2023-08-02 11:11:12'),
(273, 'wBRK-c51uzaON-Kfw6', 'en', 'rockstar_games', 'Rockstar Games', '2023-08-02 11:11:12', '2023-08-02 11:11:12'),
(274, 'ia3N-cV9bYFEQ-YHG1', 'en', 'recommended', 'Recommended', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(275, 'bJcD-Jwzz0Teu-caa4', 'en', 'get_started', 'Get Started', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(276, 'I5ok-vSoMyxqR-E6Y3', 'en', 'includes', 'includes', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(277, '8rfr-tPfJ5Uaf-Se2b', 'en', 'allow_contact', 'Allow Contact', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(278, '5pVq-KHL13N5T-LCvL', 'en', 'allow_adrress', 'Allow Adrress', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(279, 'c0nT-IWyF0biH-55x6', 'en', 'qr_code_feature', 'Qr Code Feature', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(280, '6B6Z-VCe9YGlC-GrEv', 'en', 'changin_visible_url', 'Changin Visible URL', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(281, '2S1v-hAdwd2tP-wJbr', 'en', 'show_verified_badges', 'Show Verified Badges', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(282, '2WM6-NNBVOq5Z-xS09', 'en', 'allow_link_attribue', 'Allow Link Attribue', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(283, 'Wf60-heuyuvYK-EQk6', 'en', 'deep_link', 'Deep Link', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(284, 'CrZ7-gdArRXHR-Pwf0', 'en', 'link_submission_per_day', 'Link Submission Per Day', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(285, '8anR-TcojUAPv-0pQb', 'en', 'link_expires_in', 'link_expires_in', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(286, 'qjwx-6FbSkrwp-TfF5', 'en', 'current_plan', 'Current Plan', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(287, 'wVP8-2UmJAzbC-0Zt1', 'en', 'select_gateway', 'Select Gateway', '2023-08-02 11:11:15', '2023-08-02 11:11:15'),
(288, 'VvJt-6A2NdgDw-VhQ3', 'en', 'pay', 'Pay', '2023-08-02 11:11:16', '2023-08-02 11:11:16'),
(289, '7uoh-Oj38GXQz-hixy', 'en', 'make_payment', 'Make Payment', '2023-08-02 11:11:16', '2023-08-02 11:11:16'),
(290, '5OvI-zMVxM76S-c4H7', 'en', 'pay_now', 'Pay Now', '2023-08-02 11:11:16', '2023-08-02 11:11:16'),
(291, 'B5jQ-y8eNOOtj-oQz9', 'en', 'latest', 'Latest', '2023-08-02 11:13:04', '2023-08-02 11:13:04'),
(292, '4Jn5-5gGQn3HI-MRge', 'en', 'feature', 'Feature', '2023-08-02 11:13:04', '2023-08-02 11:13:04'),
(293, '7JzO-vcgkBmMA-DHVw', 'en', 'most_viewed', 'Most Viewed', '2023-08-02 11:13:04', '2023-08-02 11:13:04'),
(294, 'sj4y-utjfoiL9-v8l5', 'en', 'least_viewed', 'Least Viewed', '2023-08-02 11:13:04', '2023-08-02 11:13:04'),
(295, 'Qgi4-uZVLceXR-NYW8', 'en', 'important_links', 'Important Links', '2023-08-02 11:13:05', '2023-08-02 11:13:05'),
(296, '1j6l-s0WRy9cz-iJUG', 'en', 'quick_link', 'Quick link', '2023-08-02 11:13:05', '2023-08-02 11:13:05'),
(297, 'cTZ9-XHsP9f0P-xh76', 'en', 'enter_your_email', 'Enter Your Email', '2023-08-02 11:13:06', '2023-08-02 11:13:06'),
(298, '1WRI-AJOFmIqj-AIxq', 'en', 'socail_icon', 'Socail Icon', '2023-08-02 11:13:06', '2023-08-02 11:13:06'),
(299, '7vU9-f6ky76YW-LDnr', 'en', 'search_links', 'Search Links', '2023-08-02 11:13:08', '2023-08-02 11:13:08'),
(300, 'kF81-yz33Q342-P5B1', 'en', 'search_now', 'Search Now', '2023-08-02 11:13:08', '2023-08-02 11:13:08'),
(301, '17Dj-mk1LqnRl-Lp6M', 'en', 'links_available', 'Links available', '2023-08-02 11:13:08', '2023-08-02 11:13:08'),
(302, '6AUa-B6sizLmn-A6Eu', 'en', 'total_articles', 'Total Articles', '2023-08-02 11:13:09', '2023-08-02 11:13:09'),
(303, 'ogU6-bmK2KKXc-MOm9', 'en', 'total_user', 'Total User', '2023-08-02 11:13:09', '2023-08-02 11:13:09'),
(304, '9PNA-rteYa4rA-OVTd', 'en', 'sub_categories', 'Sub Categories', '2023-08-02 11:13:23', '2023-08-02 11:13:23'),
(305, 'ab5Y-8JIzce5a-A3l2', 'en', 'manage_category', 'Manage Category', '2023-08-02 11:13:23', '2023-08-02 11:13:23'),
(306, '7Aw2-IbJkD6ZJ-1EV3', 'en', 'parent_category', 'Parent Category', '2023-08-02 11:13:28', '2023-08-02 11:13:28'),
(307, 'w8vp-PU4m7FiQ-nY16', 'en', 'select_parent_category', 'Select Parent Category', '2023-08-02 11:13:28', '2023-08-02 11:13:28'),
(308, '2rR8-l6a0pDBP-aIdi', 'en', 'feature_on_banner', 'Feature On Banner', '2023-08-02 11:13:28', '2023-08-02 11:13:28'),
(309, '7mmR-Fsg7I5Ui-MPzE', 'en', 'edit_category', 'Edit Category', '2023-08-02 11:13:28', '2023-08-02 11:13:28'),
(310, 'EWir-ABTIrhVp-raK8', 'en', 'category_updated_successfully', 'Category Updated Successfully', '2023-08-02 11:13:54', '2023-08-02 11:13:54'),
(311, 'Y1Xv-vXuO0SFM-dtP6', 'en', 'subcategories', 'SubCategories', '2023-08-02 11:13:59', '2023-08-02 11:13:59'),
(312, '5H4H-Ejr7qH7w-miKs', 'en', 'subcategory', 'SubCategory', '2023-08-02 11:13:59', '2023-08-02 11:13:59'),
(313, 'y40w-veeOYNmR-F6L2', 'en', 'overview', 'Overview', '2023-08-02 11:17:47', '2023-08-02 11:17:47'),
(314, '7Crt-cgxD2vva-n9ip', 'en', 'total_link', 'Total Link', '2023-08-02 11:17:47', '2023-08-02 11:17:47'),
(315, 'ndYQ-JLkLZqjx-hjE4', 'en', 'total_subscription', 'Total Subscription', '2023-08-02 11:17:47', '2023-08-02 11:17:47'),
(316, '0hs5-3SF9k7UV-4Mjo', 'en', 'total_transaction', 'Total Transaction', '2023-08-02 11:17:47', '2023-08-02 11:17:47'),
(317, 'zxfw-L1Qs6onP-T3s4', 'en', 'payment_method', 'Payment Method', '2023-08-02 11:17:47', '2023-08-02 11:17:47'),
(318, 'XleK-fcwZ2cOR-lCW3', 'en', 'payment_type', 'Payment type', '2023-08-02 11:17:47', '2023-08-02 11:17:47'),
(319, 'gByX-0ct1mZqX-JPX7', 'en', 'please_pay', 'Please Pay', '2023-08-02 11:22:28', '2023-08-02 11:22:28'),
(320, '04gq-e2ACxJmi-1LhH', 'en', 'transaction_was_successful', 'Transaction was successful.', '2023-08-02 11:23:16', '2023-08-02 11:23:16'),
(321, '8l4x-ZCEOd53j-19m7', 'en', 'payment_request_successfully_processed', 'Payment Request Successfully Processed', '2023-08-02 11:23:16', '2023-08-02 11:23:16'),
(322, 'mQWU-naXury6Q-0Ey5', 'en', 'completed', 'Completed', '2023-08-02 11:23:17', '2023-08-02 11:23:17'),
(323, 'Jp97-mksLe8JG-w6J2', 'en', 'payment_information', 'Payment Information', '2023-08-02 11:23:22', '2023-08-02 11:23:22'),
(324, '1hMp-LgYWsTrL-q2vL', 'en', 'charage', 'Charage', '2023-08-02 11:23:22', '2023-08-02 11:23:22'),
(325, '5AEt-z8QGYVtb-XouR', 'en', 'rate', 'Rate', '2023-08-02 11:23:22', '2023-08-02 11:23:22'),
(326, '7moJ-nzYpZCG7-IpZm', 'en', 'final_amount', 'Final Amount', '2023-08-02 11:23:22', '2023-08-02 11:23:22'),
(327, '0YCv-Iv6wNPDU-PhTM', 'en', 'file_uploaded_successfully', 'File Uploaded Successfully', '2023-08-02 11:41:30', '2023-08-02 11:41:30'),
(328, '4V9Q-umoonAFK-RTPU', 'en', 'frontend_section_updated_successfully', 'Frontend Section Updated Successfully', '2023-08-02 11:41:31', '2023-08-02 11:41:31'),
(329, '7lYd-YZKN5RMj-9nrZ', 'en', 'updated_successfully', 'Updated Successfully', '2023-08-02 11:43:05', '2023-08-02 11:43:05'),
(330, 'rYgb-inX9xysZ-Oe90', 'en', 'superadmin_just_approved_your_link', 'SuperAdmin Just Approved Your Link', '2023-08-02 11:43:26', '2023-08-02 11:43:26'),
(331, '6JED-tdtg31T6-fdtX', 'en', 'reviews', 'Reviews', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(332, '4xN7-ir0lnAxt-vbAX', 'en', 'trusted_site', 'Trusted Site', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(333, '7czJ-cdAF3KEb-hk7D', 'en', 'share_on', 'Share On', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(334, '3e5y-guTGMH6M-3Qua', 'en', 'galleries', 'Galleries', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(335, '3ivP-yYPOaJwz-hClw', 'en', 'add_review', 'Add Review', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(336, 'lhZ9-JxUC5bLr-Ylt0', 'no_result_found', 'no_data_found_', 'No Data Found !!', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(337, '2JmH-1q8xtrhB-q6ET', 'en', 'contact_info', 'Contact Info', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(338, 'Ywt5-413hBdzN-LRJ6', 'en', 'add_your_review', 'Add your Review', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(339, '9Grp-Y3kgwld8-VRy2', 'en', 'rating_here', 'Rating Here', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(340, 'leML-Hkn6tVX0-mjP4', 'en', 'your_review', 'Your Review', '2023-08-02 11:43:42', '2023-08-02 11:43:42'),
(341, '0YyO-BBFCK8uK-fmcN', 'en', 'retrive_details', 'Retrive Details', '2023-08-02 11:43:58', '2023-08-02 11:43:58'),
(342, 'bMyr-oGAhyvSN-Aki1', 'en', 'map_location', 'Map Location', '2023-08-02 11:43:58', '2023-08-02 11:43:58'),
(343, 's6Qw-HDijvFH7-xpL5', 'en', 'latitude', 'Latitude', '2023-08-02 11:43:58', '2023-08-02 11:43:58'),
(344, '64gA-VdWL2T7x-v8J9', 'en', 'longitude', 'Longitude', '2023-08-02 11:43:58', '2023-08-02 11:43:58'),
(345, 'KjI1-52rgWoI5-aHG3', 'en', 'zoom_level', 'Zoom Level', '2023-08-02 11:43:58', '2023-08-02 11:43:58'),
(346, '3SKq-HKItVsaW-tChS', 'en', 'country', 'Country', '2023-08-02 11:43:58', '2023-08-02 11:43:58'),
(347, '22VG-RoXFH4MI-rzRA', 'en', 'select_country', 'Select Country', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(348, '2Ri3-hjt59Z4T-qURy', 'en', 'enter_view', 'Enter View', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(349, 'zRJx-KHasNxVk-KjK2', 'en', 'enter_likes', 'Enter Likes', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(350, 'AvHU-tEVwGcqN-dHf7', 'en', 'owner', 'Owner', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(351, 'vqQM-KcPk19lA-cfA2', 'en', 'select_owner', 'Select Owner', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(352, 'WasP-BDmPg2nw-LQu3', 'en', 'expired_time', 'Expired Time', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(353, '8YPp-GkzbvOGV-qtz0', 'en', 'select_date', 'Select Date', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(354, '5pKa-BqhJA5Iu-a9zt', 'en', 'url_feild_is_empty', 'Url Feild Is Empty', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(355, '6Id4-aRYR1ZK4-dkE5', 'en', 'could_not_retrieve_details', 'Could Not Retrieve Details', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(356, '70tE-ab4UCs63-Mlv7', 'en', 'update_links', 'Update Links', '2023-08-02 11:43:59', '2023-08-02 11:43:59'),
(357, 'OpgI-KLw8vXiP-l1R7', 'en', 'image_not_found', 'Image Not Found', '2023-08-02 11:44:05', '2023-08-02 11:44:05'),
(358, '6QI0-xm79K1bU-zSf1', 'en', 'image_deleted', 'Image Deleted!!', '2023-08-02 11:44:05', '2023-08-02 11:44:05'),
(359, '3frL-N0OW5M9M-T4lT', 'en', 'link_updated_successfully', 'Link Updated Successfully', '2023-08-02 11:44:26', '2023-08-02 11:44:26'),
(360, 'PD8e-1YDD6nCw-5n58', 'en', '___title', '   Title', '2023-08-02 11:44:57', '2023-08-02 11:44:57'),
(361, '8Fr8-O68UeFWI-Vkm3', 'en', 'create_links', 'Create Links', '2023-08-02 11:44:57', '2023-08-02 11:44:57'),
(362, '3wVM-rTSTayOL-mXo2', 'en', 'create', 'Create', '2023-08-02 11:44:57', '2023-08-02 11:44:57'),
(363, '6KUB-etnrVkm3-4Eyo', 'en', 'link_created_successfully', 'Link Created Successfully', '2023-08-02 11:47:09', '2023-08-02 11:47:09'),
(364, '0qfb-CFTJROdv-vzKW', 'en', 'live_cricket_score_schedule_latest_news_stats__videos__cricbuzzcom', 'Live Cricket Score, Schedule, Latest News, Stats & Videos | Cricbuzz.com', '2023-08-02 11:47:16', '2023-08-02 11:47:16'),
(365, '7ao8-IX7cm7Xg-Psig', 'en', 'image_must_be_gif_jpeg_jpg_pdf_png_xlsx_format', 'image Must be gif, jpeg, jpg, pdf, png, xlsx Format', '2023-08-02 11:50:48', '2023-08-02 11:50:48'),
(366, '3lkq-m4bhQtzf-1sZj', 'en', 'image_size_must_be_80x80', 'Image size must be 80X80', '2023-08-02 11:50:48', '2023-08-02 11:50:48'),
(367, 'JA6K-Xtzp1JEj-phN3', 'en', 'add_user', 'Add User', '2023-08-02 12:03:09', '2023-08-02 12:03:09'),
(368, '1Bmp-CJCcvJSV-bhq2', 'en', 'user_name', 'User Name', '2023-08-02 12:03:09', '2023-08-02 12:03:09'),
(369, 'pGyD-IenffPfc-KO70', 'en', 'enter_user_name', 'Enter User Name', '2023-08-02 12:03:09', '2023-08-02 12:03:09'),
(370, 'ZKoD-Fd4qUg1Y-GSR0', 'en', 'password', 'Password', '2023-08-02 12:03:09', '2023-08-02 12:03:09'),
(371, 'mPAV-epqTeXzR-43z6', 'en', 'minimum_5_characters', 'Minimum 5 Characters', '2023-08-02 12:03:09', '2023-08-02 12:03:09'),
(372, 'snUh-uxMct9Z2-wW38', 'en', 'enter_password', 'Enter Password', '2023-08-02 12:03:10', '2023-08-02 12:03:10'),
(373, '1CwB-bFuV4RqI-BCBu', 'en', 'enter_address_here', 'Enter Address Here', '2023-08-02 12:03:10', '2023-08-02 12:03:10'),
(374, '8otq-F5vtiNyV-9fq5', 'en', 'update_user', 'Update User', '2023-08-02 12:03:10', '2023-08-02 12:03:10'),
(375, '7BoK-4n0MxP75-v1DM', 'en', 'update_password', 'Update Password', '2023-08-02 12:03:10', '2023-08-02 12:03:10'),
(376, 'D1cf-3xcmVaVF-aZV9', 'en', 'confirm_password', 'Confirm Password', '2023-08-02 12:03:10', '2023-08-02 12:03:10'),
(377, 'O3M5-75PNJSUL-a0b0', 'en', 'enter_confrim_password', 'Enter Confrim Password', '2023-08-02 12:03:10', '2023-08-02 12:03:10'),
(378, '5tQm-OufGapHW-JFj3', 'en', 'manage_users', 'Manage Users', '2023-08-02 12:03:10', '2023-08-02 12:03:10'),
(379, 'M1lh-BW4k4Mv5-XwE8', 'en', 'users', 'Users', '2023-08-02 12:03:10', '2023-08-02 12:03:10'),
(380, '0EvI-2hpKCbsR-JtLc', 'en', 'successfully_logged_in_as_a_user', 'Successfully logged In As a User', '2023-08-02 12:03:14', '2023-08-02 12:03:14'),
(381, 'Y42V-cFDeBsfw-IyJ7', 'en', 'arts', 'Arts', '2023-08-02 12:12:15', '2023-08-02 12:12:15'),
(382, 'BnQG-XOboSQn9-KCd0', 'en', 'most_like', 'Most Like', '2023-08-02 12:12:15', '2023-08-02 12:12:15'),
(383, 'wEoY-njKJmhYf-Pct5', 'en', 'least_like', 'Least Like', '2023-08-02 12:12:15', '2023-08-02 12:12:15'),
(384, '48vh-BGc6HhDm-HSNB', 'en', 'notification_not_found', 'Notification Not Found', '2023-08-02 12:20:05', '2023-08-02 12:20:05'),
(385, 'ulmN-2pa09pJv-6Wp6', 'en', 'notification_readed', 'Notification Readed', '2023-08-02 12:20:05', '2023-08-02 12:20:05'),
(386, 'D0qR-7mLxlnde-gQd7', 'en', 'faq_updated_successfully', 'Faq Updated Successfully', '2023-08-02 12:27:22', '2023-08-02 12:27:22'),
(387, '4vfI-EOXqsnin-mU32', 'en', 'faq_created_successfully', 'Faq Created Successfully', '2023-08-02 12:29:04', '2023-08-02 12:29:04'),
(388, '3cpc-Dvde8JWq-RvUT', 'en', 'position', 'Position', '2023-08-02 12:33:44', '2023-08-02 12:33:44'),
(389, 'JXug-f2rexHij-0WP0', 'en', 'manage_ads', 'Manage Ads', '2023-08-02 12:33:44', '2023-08-02 12:33:44'),
(390, 'XsOX-02HLJD7t-H8L1', 'en', 'edit_ads', 'Edit Ads', '2023-08-02 12:33:47', '2023-08-02 12:33:47'),
(391, '41ga-zwnSPEPR-ReMY', 'en', 'terms__condition', 'Terms & Condition', '2023-08-02 12:35:19', '2023-08-02 12:35:19'),
(392, 'Zk8r-7SvO6QkC-xia4', 'en', 'cta_updated_successfully', 'Cta Updated Successfully', '2023-08-02 12:53:28', '2023-08-02 12:53:28'),
(393, 'q7BZ-D5bifBOh-h9P5', 'en', 'cta_review_created_successfully', 'Cta Review Created Successfully', '2023-08-02 12:53:51', '2023-08-02 12:53:51'),
(394, '2lb7-Y4bK70XX-eTVq', 'en', 'update_menu', 'Update Menu', '2023-08-02 12:55:50', '2023-08-02 12:55:50'),
(395, '869h-FXqcGCRn-8oY2', 'en', 'edit_menu', 'Edit Menu', '2023-08-02 12:55:50', '2023-08-02 12:55:50'),
(396, '50oI-Yt08tI92-sFyU', 'en', 'menu_updated_successfully', 'Menu Updated Successfully', '2023-08-02 12:56:00', '2023-08-02 12:56:00'),
(397, '31fZ-HmcU0ubs-PTIb', 'en', 'menu_created_successfully', 'Menu Created Successfully', '2023-08-02 12:56:27', '2023-08-02 12:56:27'),
(398, '9FPh-Brgd4ZVg-64b9', 'en', 'client_review_created_successfully', 'Client Review Created Successfully', '2023-08-02 12:56:54', '2023-08-02 12:56:54'),
(399, 'lx5a-cMZmcf3V-VKM4', 'en', 'client_review_updated_successfully', 'Client Review Updated Successfully', '2023-08-02 12:57:03', '2023-08-02 12:57:03'),
(400, '5VXe-Y3Oq6oXw-lvDj', 'en', 'user_not_found', 'User Not Found', '2023-08-02 12:57:30', '2023-08-02 12:57:30'),
(401, 'OMtO-zCwFPJ1q-7g80', 'en', 'deleted_successfully', 'Deleted Successfully', '2023-08-02 12:57:31', '2023-08-02 12:57:31'),
(402, 'py2z-Isj7WbSV-di42', 'en', 'select_role', 'Select Role', '2023-08-02 13:06:43', '2023-08-02 13:06:43'),
(403, 'IbtF-oK0QtptZ-Nz36', 'en', 'add_staff', 'Add Staff', '2023-08-02 13:06:43', '2023-08-02 13:06:43'),
(404, 'OaxR-TORDgHZ1-4tM6', 'en', 'role', 'Role', '2023-08-02 13:06:43', '2023-08-02 13:06:43'),
(405, 'O0B0-IaxW1Plu-SfV3', 'en', 'update_staff', 'Update Staff', '2023-08-02 13:06:43', '2023-08-02 13:06:43'),
(406, '7Gx4-nStpIxXh-AGgi', 'en', 'successfully_logged_in_as_a_staff', 'Successfully logged In As a Staff', '2023-08-02 13:06:48', '2023-08-02 13:06:48'),
(407, '5gmm-82Yvrm0t-XiJs', 'en', 'unauthorized_access', 'Unauthorized access', '2023-08-02 13:07:01', '2023-08-02 13:07:01'),
(408, '93zO-Zr6hIQ9E-AQo7', 'en', 'adminlogin', 'Admin-Login', '2023-08-02 13:07:22', '2023-08-02 13:07:22'),
(409, '1z6B-sJoWlEbj-9ouh', 'en', 'usernameemail', 'Username/Email', '2023-08-02 13:07:22', '2023-08-02 13:07:22'),
(410, 'ruWA-uCiFuRma-Kgk5', 'en', 'enter_username__or_email', 'Enter Username  or Email', '2023-08-02 13:07:22', '2023-08-02 13:07:22'),
(411, 'FQpU-0x03FNFK-LdP4', 'en', 'remember_me', 'Remember me', '2023-08-02 13:07:22', '2023-08-02 13:07:22'),
(412, '6kLF-x72Gl2yv-NmF5', 'en', 'forgot_password', 'Forgot password', '2023-08-02 13:07:22', '2023-08-02 13:07:22');
INSERT INTO `translations` (`id`, `uid`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(413, 'Dwqj-d7v9AE8k-mSJ4', 'en', 'sign_in', 'Sign In', '2023-08-02 13:07:22', '2023-08-02 13:07:22'),
(414, '888Y-DJbOqE03-1sy6', 'en', 'server_error_please_reload_then_try_again_', 'Server Error!! Please Reload Then Try Again ', '2023-08-02 13:07:25', '2023-08-02 13:07:25'),
(415, 'pIaq-26ncAfCu-wPz9', 'en', '_feild_is_required', ' Feild Is Required', '2023-08-02 13:07:25', '2023-08-02 13:07:25'),
(416, '0JNE-uhAAXAT3-AWnm', 'en', 'password_feild_is_required', 'Password Feild Is Required', '2023-08-02 13:07:25', '2023-08-02 13:07:25'),
(417, 'Ycvs-imQjMLk3-dgF0', 'en', 'successfully_loggedin', 'Successfully Loggedin', '2023-08-02 13:07:25', '2023-08-02 13:07:25'),
(418, 'GHEj-WscjR2Au-vmR3', 'en', 'contact', 'Contact', '2023-08-02 13:20:17', '2023-08-02 13:20:17'),
(419, 'ADeH-N8cZidMT-ooe2', 'en', 'get_in_touch', 'Get In Touch', '2023-08-02 13:20:17', '2023-08-02 13:20:17'),
(420, '5EPd-YQQDJGIm-R9f1', 'en', 'enter_your_name', 'Enter Your Name', '2023-08-02 13:20:17', '2023-08-02 13:20:17'),
(421, 'BbLl-oQSWln8t-Tve4', 'en', 'your_address', 'Your Address', '2023-08-02 13:20:17', '2023-08-02 13:20:17'),
(422, 'GQgv-mOZzKsWB-Z0x4', 'en', 'your_message', 'Your Message', '2023-08-02 13:20:17', '2023-08-02 13:20:17'),
(423, '8R3Z-ZmvmrwGe-kMrE', 'en', 'basic_settings', 'Basic Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(424, 'eNPa-e7lQMKQu-RVL8', 'en', 'logging', 'Logging', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(425, 'PE9B-IwaZdKBs-YOm0', 'en', 'rate_limiting', 'Rate Limiting', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(426, '4kMk-mmkj9hvJ-73Hs', 'en', 'theme_settings', 'Theme Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(427, 'nonu-Jf2LoJdq-pvU8', 'en', 'ticket_settings', 'Ticket Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(428, '7C7A-mwyz86uo-KfEe', 'en', 'storage_settings', 'Storage Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(429, 'o2Mk-YYRxOYRo-MYB5', 'en', 'recaptcha_settings', 'Recaptcha Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(430, 'cqVC-OVuCaRZo-LT00', 'en', 'social_login_settings', 'Social Login Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(431, 'VGTA-KrIgzNkM-7AO8', 'en', 'registration_settings', 'Registration Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(432, 'LEK3-s4RPWu5z-fx61', 'en', 'login_settings', 'Login Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(433, '4JUW-j615pD3m-IPrP', 'en', 'logo_settings', 'Logo Settings', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(434, '7Y0a-5sCsWOwP-qd40', 'en', 'setup_cron_jobs', 'Setup Cron Jobs', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(435, 'mMNu-8TCFwR5o-cB81', 'en', 'use_same_site_name', 'Use Same Site Name', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(436, 'ikqW-VJWWX2iO-1eT1', 'en', 'site_name', 'Site Name', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(437, '51na-Wlxxrcg2-uDQq', 'en', 'user_site_name', 'User Site Name', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(438, '3zHX-iVmddlqC-DWwz', 'en', 'twitter_username', 'Twitter Username', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(439, '6665-Iy7QM07o-hTrE', 'en', 'time_zone', 'Time Zone', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(440, '5prH-V9AsF3H1-1gHh', 'en', 'currency', 'Currency', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(441, '7pJN-gTDDUl67-Baab', 'en', 'currency_symbol', 'Currency Symbol', '2023-08-02 13:20:58', '2023-08-02 13:20:58'),
(442, 'Fry2-1oQHqjaX-TX84', 'en', 'copy_right_text', 'Copy Right Text', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(443, '6U3m-e3nEpsyr-znlh', 'en', 'data_per_page', 'Data Per Page', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(444, '0X7M-339MGQyL-Ewc1', 'en', 'web_visitors', 'Web Visitors', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(445, '5pWj-la0Idzib-mots', 'en', 'cookie_text', 'Cookie Text', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(446, '0dSF-UOECcAPt-FeRp', 'en', 'enter_cookie_text', 'Enter Cookie Text', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(447, '604H-mDKrONjE-j6EY', 'en', 'google_adsense_publisher_id', 'Google Adsense Publisher Id', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(448, '5RYa-2lk36DTk-Vjj6', 'en', 'enter_id', 'Enter Id', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(449, '15RG-AnryIbFw-lFW0', 'en', 'google_analytics_tracking_id', 'Google Analytics Tracking Id', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(450, '9gMQ-oSVVKCP6-dvqi', 'en', 'time_before_redirection', 'Time Before Redirection', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(451, '3NaF-srVbm9aQ-EnG1', 'en', 'in_second', 'In Second', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(452, '6Bvt-hbsWsz3D-oFSu', 'en', 'enter_time', 'Enter Time', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(453, 'DE3n-wuAEMSjk-Xmq3', 'en', 'site_description', 'Site Description', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(454, '37mn-TCsqGCBm-48hu', 'en', 'sentry_dns', 'Sentry Dns', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(455, '4p15-R2jwYoPW-ikbz', 'en', 'information', 'Information', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(456, 'xGal-8FilYrvb-PfP4', 'en', 'sentry', 'Sentry', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(457, 'zdW6-t13hBASR-VoD3', 'en', 'rate_limitting', 'Rate Limitting', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(458, 'ZRW1-Z0HQtlDb-R3M2', 'en', 'api_hit_limit', 'Api Hit limit', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(459, 'tkcX-67kQZ6iV-eC26', 'en', 'per_minute', 'Per Minute', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(460, 'rJoZ-clh7evM3-c6G0', 'en', 'web_route_limit', 'Web Route limit', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(461, 'IQ2h-fE23v0yM-32u4', 'en', 'frontend_themecolor_settings', 'Frontend Theme/Color Settings', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(462, '1G3K-K2rlXtjX-Agfe', 'en', 'primary_color', 'Primary Color', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(463, '0gDD-WQoSJvfR-KKF6', 'en', 'secondary_color', 'Secondary Color', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(464, 'pCPS-XaywlvR3-aF76', 'en', 'text_primary_color', 'Text Primary Color', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(465, 'MJwt-fx9InTbg-Hlx9', 'en', 'text_secondary_color', 'Text Secondary Color', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(466, '1BLt-hRCxrep6-1H5g', 'en', 'add_more', 'Add More', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(467, 'lexK-6RI9Kb8M-ro49', 'en', 'labels', 'Labels', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(468, 'Pi70-Dvry1TYG-qzC0', 'en', 'type', 'Type', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(469, '70Lx-II610v2q-TD9l', 'en', 'mandatoryrequired', 'Mandatory/Required', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(470, 'lFqn-j4sBfufg-Blx4', 'en', 'placeholder', 'Placeholder', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(471, 'vloM-0VX26b0B-ByR8', 'en', 'label', 'Label', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(472, '0iGO-qgnj1hgd-7Ze2', 'en', 'required', 'Required', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(473, 'mZL0-R1Nx5i5B-8gV7', 'en', 'local', 'local', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(474, 'ju6s-cp38SBEK-UqA6', 'en', 'aws_s3', 'Aws S3', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(475, '56Xi-hliyoZ7r-HGJp', 'en', 'ftp', 'Ftp', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(476, '7RRL-1pj8UBrO-83eN', 'en', 'local_storage_settings', 'Local Storage Settings', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(477, 'JRXM-yiRxtwKv-7nA3', 'en', 'supported_file_types', 'Supported File Types', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(478, '6LCE-ZrnujqCb-WWzK', 'en', 'maximum_file_upload', 'Maximum File Upload', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(479, 'D642-7xuq2dfd-yVG0', 'en', 'you_can_not_upload_more_than_that_at_a_time_', 'You Can Not Upload More Than That At a Time ', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(480, '3bLq-VYkj0q71-aejg', 'en', 'max_file_upload_size', 'Max File Upload size', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(481, 'taeH-HFjK04Ce-B699', 'en', 'in_kilobyte', 'In Kilobyte', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(482, 'nFaL-NFEIJwIn-bsB6', 'en', 's3_storage_settings', 'S3 Storage Settings', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(483, 'lYBr-fYCKjbzi-1bV6', 'en', 'ftp_settings', 'Ftp Settings', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(484, '2ul8-m8wy6hkt-x2Im', 'en', 'use_default_captcha', 'Use Default Captcha', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(485, '7Zgu-XcDRaZGi-mjJZ', 'en', 'captcha_with_registration', 'Captcha With Registration', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(486, '3vqf-8XkUrrJP-0lTm', 'en', 'captcha_with_login', 'Captcha With Login', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(487, 'f7NG-3HPwOgpC-rdK6', 'en', 'google_recaptcha_v3', 'Google Recaptcha (V3)', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(488, '4orO-nFKMT2Ke-CU56', 'en', 'socail_login_setup', 'Socail Login Setup', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(489, '5te3-EVqrhvOf-VhMl', 'en', 'active', 'Active', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(490, 'Lt73-Sh6FPguU-uJH1', 'en', 'inactive', 'Inactive', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(491, '77Px-nkeZpiuX-5XVP', 'en', 'callback_url', 'Callback Url', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(492, 'X67H-SCDn6FQc-q4S8', 'en', 'register_form_settings', 'Register Form Settings', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(493, '5oH3-NI4scoUT-6sYh', 'en', 'email_verification', 'Email Verification', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(494, 'tAoO-WGTPkeOY-RXv9', 'en', 'order', 'Order', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(495, 'aRLM-3UYJNJ50-d3J7', 'en', 'width', 'Width', '2023-08-02 13:20:59', '2023-08-02 13:20:59'),
(496, 'B2aL-KuJRbFS8-dKv8', 'en', 'user_login_settings', 'User Login Settings', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(497, 'P3oq-VoQ31M4P-xyc9', 'en', 'max_login_attempt_validation', 'Max Login Attempt Validation', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(498, 'oPre-n88N2fIu-tYa8', 'en', 'maximum_login_attempts', 'Maximum Login Attempts', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(499, 'nCch-1FV24D8L-ywc6', 'en', 'otp_expired_time', 'Otp Expired Time', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(500, '7QEr-fQS7lyBf-EIJ2', 'en', 'minute', 'Minute', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(501, '8F0y-JmMtz5ZE-m4ua', 'en', 'login_with', 'Login With', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(502, '2Jr5-DF6ul4gn-fg7a', 'en', 'sms_otp_verification', 'Sms Otp Verification', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(503, 'wJeK-KYxvFv7y-0mF8', 'en', 'site_logo', 'Site Logo', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(504, '6GNT-rCDNGGXV-nUbR', 'en', 'frontend_logo', 'Frontend Logo', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(505, '6YKx-bfLit1my-nF6d', 'en', 'favicon', 'Favicon', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(506, '5VdF-IOd6ldfg-f4Oz', 'en', 'cron_job_setup', 'Cron Job Setup', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(507, '26p5-UOjWtjVd-7CJ8', 'en', 'queue', 'Queue', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(508, 'cwqU-0nIgQZeo-xBV0', 'en', 'set_time_for_1_minute', 'Set time for 1 minute', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(509, '8ZHv-i5BZVaaR-fu9t', 'en', 'cron_job_', 'Cron Job ', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(510, '8i7O-W0cEdGF2-gAlJ', 'en', 'enter_label', 'Enter Label', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(511, '73bo-EhY94BwG-AQyv', 'en', 'enter_placeholder', 'Enter Placeholder', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(512, 'QBxg-gOqOlypF-4WS6', 'en', 'select_option', 'Select Option', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(513, 'S1gO-hMO54wF3-waA2', 'en', 'successfully_reseted_to_base_color', 'Successfully Reseted To Base Color', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(514, 'eCEB-7EAxFjdY-r2Z4', 'en', 'settings', 'Settings', '2023-08-02 13:21:00', '2023-08-02 13:21:00'),
(515, '7Pv2-X4BDl88X-05B9', 'en', 'log_list', 'Log List', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(516, 'ext3-XNS0Vn8K-sel3', 'en', 'search_by_transaction_id', 'Search By Transaction Id', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(517, 'ZvY4-MR2VjUKP-KyN7', 'en', 'enter_date', 'Enter Date', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(518, 'LBH3-WNT823gT-eUQ0', 'en', 'running', 'Running', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(519, '63l4-5BFe0tK6-RJb4', 'en', 'update_subscription', 'Update Subscription', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(520, 'Dpbs-L263Tz4d-Lfg2', 'en', 'expired', 'Expired', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(521, '7UJp-7CKbfJ49-vUav', 'en', 'remarks', 'Remarks', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(522, 'o6mI-m4t43u0o-IKN3', 'en', 'type_here_', 'Type Here ...', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(523, 'wUrw-lFFO1bZj-asB8', 'en', 'subscriptions', 'Subscriptions', '2023-08-02 13:21:18', '2023-08-02 13:21:18'),
(524, '4ChG-MszfQJXo-hVcl', 'en', 'payment_amount', 'Payment Amount', '2023-08-02 13:21:23', '2023-08-02 13:21:23'),
(525, 'GFIv-dDChSOxL-jwB3', 'en', 'paymentlog', 'PaymentLog', '2023-08-02 13:21:23', '2023-08-02 13:21:23'),
(526, 'qbNY-1NrOJzFc-AIq8', 'en', 'link_not_found', 'Link Not Found', '2023-08-02 13:23:13', '2023-08-02 13:23:13'),
(527, '8SAI-LYJyhOWD-pIeZ', 'en', 'you_liked_it_', 'You Liked It !!', '2023-08-02 13:23:13', '2023-08-02 13:23:13'),
(528, '7pBF-lzUBYfgV-Oz67', 'en', 'ticket_list', 'Ticket List', '2023-08-02 13:24:29', '2023-08-02 13:24:29'),
(529, 'cYRS-PfEdme93-mtB7', 'en', 'pending_ticket', 'Pending Ticket', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(530, 'm3Cf-uEvFCJ5n-0fK3', 'en', 'closed_ticket', 'Closed Ticket', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(531, 'P61o-sxLv7TnZ-tn46', 'en', 'holds_ticket', 'Holds Ticket', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(532, '8knh-QFEQ4Xn9-EUW4', 'en', 'solved_ticket', 'Solved Ticket', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(533, '2cKc-QvFZvrYY-KCnK', 'en', 'tickets', 'Tickets', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(534, '2LVT-Qr6RRXzu-BJ3G', 'en', 'enter_ticket_number', 'Enter Ticket Number', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(535, '4yyl-yAgLtqDt-MiA8', 'en', 'ticket_number', 'Ticket Number', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(536, 'lSpx-VnxaKaJl-gn11', 'en', 'subject', 'Subject', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(537, 'b9WS-Kcsb3vQ3-drB5', 'en', 'priority', 'Priority', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(538, 'BbHf-LszQxyp0-GX91', 'en', 'creation_time', 'Creation Time', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(539, '5uwU-DzBjyGyv-dvJF', 'en', 'processing', 'Processing', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(540, 'IIFO-WcM0NGL1-AGE5', 'en', 'low', 'Low', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(541, '8r8a-iw6ZpNob-Adh3', 'en', 'urgent', 'Urgent', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(542, '3rzH-g2EatBZI-wONj', 'en', 'open', 'Open', '2023-08-02 13:24:30', '2023-08-02 13:24:30'),
(543, 'HQ9I-oGgmNoEc-Ax81', 'en', 'ticket_details', 'Ticket Details', '2023-08-02 13:24:38', '2023-08-02 13:24:38'),
(544, 'UWU4-RUD6MlR5-57N6', 'en', 'reply_ticket', 'Reply Ticket', '2023-08-02 13:24:39', '2023-08-02 13:24:39'),
(545, '2reP-kRXTfRsR-FpbN', 'en', 'reply_here_', 'Reply Here ....', '2023-08-02 13:24:39', '2023-08-02 13:24:39'),
(546, 'a0FV-O7iUmWoE-ajC3', 'en', 'ticket_message', 'Ticket Message', '2023-08-02 13:24:39', '2023-08-02 13:24:39'),
(547, '9kPy-zNhcp2Kc-NsHk', 'en', 'delete', 'Delete', '2023-08-02 13:24:39', '2023-08-02 13:24:39'),
(548, '1NZs-KU9KKeyw-NM7C', 'en', 'ticket_id', 'Ticket Id', '2023-08-02 13:24:39', '2023-08-02 13:24:39'),
(549, '3hTA-9WXsNzJu-LjBH', 'en', 'custom_data', 'Custom Data', '2023-08-02 13:24:39', '2023-08-02 13:24:39'),
(550, '08Hl-Yb4l0flC-rAnT', 'en', 'reply', 'Reply', '2023-08-02 13:24:39', '2023-08-02 13:24:39'),
(551, '5aD2-OeQhxAzl-VyKd', 'en', 'login', 'Login', '2023-08-03 04:24:05', '2023-08-03 04:24:05'),
(552, 'coi6-RO6cWUX9-Pk88', 'en', 'select_method', 'Select Method', '2023-08-03 04:25:36', '2023-08-03 04:25:36'),
(553, 'IPjf-Y1oSn2Qw-ErN5', 'en', 'charge', 'Charge', '2023-08-03 04:25:36', '2023-08-03 04:25:36'),
(554, '4E3B-wBE97vkf-BBV0', 'en', 'total_amount', 'Total Amount', '2023-08-03 04:25:36', '2023-08-03 04:25:36'),
(555, 'iHri-1VyE2Cjw-aiT5', 'en', 'total', 'Total', '2023-08-03 04:25:36', '2023-08-03 04:25:36'),
(556, '3yAG-00nuBQF9-Hp6E', 'en', 'payment_methods_list', 'Payment Methods List', '2023-08-03 04:38:01', '2023-08-03 04:38:01'),
(557, 'jjo6-qxZy9Ldi-QWj0', 'en', 'manage_payment_methods', 'Manage Payment Methods', '2023-08-03 04:38:01', '2023-08-03 04:38:01'),
(558, '49S0-GAXTI5zn-M6IE', 'en', 'convertion_rate', 'Convertion Rate', '2023-08-03 04:38:06', '2023-08-03 04:38:06'),
(559, 'tC5r-EbLOIOHX-hKn9', 'en', 'percentage_charge________________________________', 'Percentage Charge                                ', '2023-08-03 04:38:06', '2023-08-03 04:38:06'),
(560, 'TKHN-XbUdrIjr-foh4', 'en', 'fixed_charge________________________________', 'Fixed Charge                                ', '2023-08-03 04:38:06', '2023-08-03 04:38:06'),
(561, '9eOj-buMIXHNf-sTKt', 'en', 'update_flutterwave', 'Update flutterwave', '2023-08-03 04:38:06', '2023-08-03 04:38:06'),
(562, '5FJd-hgOIlnva-hn4Q', 'en', 'methods', 'Methods', '2023-08-03 04:38:06', '2023-08-03 04:38:06'),
(563, '2Yjx-Kp6WN4EK-XXP4', 'en', 'details', 'Details', '2023-08-03 04:54:48', '2023-08-03 04:54:48'),
(564, '7OEa-GHwPReSH-yVOb', 'en', 'comments', 'Comments', '2023-08-03 04:54:48', '2023-08-03 04:54:48'),
(565, '5DH5-Hu4zmRB0-vuut', 'en', 'this_comment_is_under_review', 'This Comment Is Under Review', '2023-08-03 04:54:48', '2023-08-03 04:54:48'),
(566, '2dRl-3uybKJs7-qIwt', 'en', 'realted_post', 'Realted Post', '2023-08-03 04:54:48', '2023-08-03 04:54:48'),
(567, 'Id3w-L7IxKW4s-0Ip7', 'en', 'you_need_to_login_first', 'You Need To Login First!!', '2023-08-03 04:55:19', '2023-08-03 04:55:19'),
(568, '7EtN-UNWB2NAl-pPVq', 'en', 'add_comment', 'Add Comment', '2023-08-03 04:55:51', '2023-08-03 04:55:51'),
(569, '833h-bjegJ6Ul-NXT1', 'en', 'article_or_comment_not_found', 'Article Or Comment Not Found', '2023-08-03 04:56:01', '2023-08-03 04:56:01'),
(570, 'UfL3-miH0owU0-z3u9', 'en', 'you_unlike_it_', 'You Unlike It !!', '2023-08-03 04:56:01', '2023-08-03 04:56:01'),
(571, 'lpdj-p80QOtEf-mnU1', 'en', 'superadmin', 'SuperAdmin', '2023-08-03 05:00:49', '2023-08-03 05:00:49'),
(572, 'ugd8-d1wPrC6A-i4U9', 'en', 'profile_info', 'Profile Info', '2023-08-03 05:00:49', '2023-08-03 05:00:49'),
(573, 'MYRz-Xhw1Dh9g-IMU1', 'en', 'profileinfo', 'Profile						Info', '2023-08-03 05:00:49', '2023-08-03 05:00:49'),
(574, '8tE4-0KsR0WqU-sDkk', 'en', 'current_password', 'Current Password', '2023-08-03 05:00:49', '2023-08-03 05:00:49'),
(575, '8J6V-JmZmNZTy-6whm', 'en', 'enter_current_pasdsword', 'Enter Current Pasdsword', '2023-08-03 05:00:49', '2023-08-03 05:00:49'),
(576, '1wJb-NjEf0lzu-akK1', 'en', 'new_password', 'New Password', '2023-08-03 05:00:49', '2023-08-03 05:00:49'),
(577, '0vc5-ra7L6kxC-6CE6', 'en', 'enter_new_password', 'Enter New Password', '2023-08-03 05:00:49', '2023-08-03 05:00:49'),
(578, '9u60-FYgSJNBP-jbuR', 'en', 'profile', 'Profile', '2023-08-03 05:00:49', '2023-08-03 05:00:49'),
(579, 'crU7-ufe5hhSR-KFp8', 'en', 'profile_updated', 'Profile Updated', '2023-08-03 05:00:53', '2023-08-03 05:00:53'),
(580, '6xVU-5NYWFP9k-34dD', 'en', 'please_follow_the_instruction_below', 'Please follow the instruction below', '2023-08-03 05:07:53', '2023-08-03 05:07:53'),
(581, 'BaWR-LflQBFBo-ak22', 'en', 'you_have_requested_for_a_subscription', 'You have requested for a subscription', '2023-08-03 05:07:53', '2023-08-03 05:07:53'),
(582, '9DmG-wlnIhXbY-6bsY', 'en', 'for_successful_payment', 'for successful payment', '2023-08-03 05:07:53', '2023-08-03 05:07:53'),
(583, '2BZU-2hAbnAti-AvZK', 'en', 'nid_image', 'nid image', '2023-08-03 05:07:53', '2023-08-03 05:07:53'),
(584, 'KT5B-K8SFqUWS-9hb1', 'en', 'your_subscription_request_is_pending_now_please_wait_for_confirmation', 'Your Subscription Request Is Pending Now!! Please Wait For Confirmation', '2023-08-03 05:26:43', '2023-08-03 05:26:43'),
(585, 'Lsup-GuMp26yN-ShW7', 'en', 'custom__information', 'Custom  Information', '2023-08-03 05:27:13', '2023-08-03 05:27:13'),
(586, '9ypc-JnBO42zk-vN6Z', 'en', 'nidimage', 'Nidimage', '2023-08-03 05:27:13', '2023-08-03 05:27:13'),
(587, '3r6t-JtRwuk5T-ooz0', 'en', 'update', 'Update', '2023-08-03 05:27:13', '2023-08-03 05:27:13'),
(588, 'SZg5-KmQIhMej-QBN5', 'en', 'success', 'Success', '2023-08-03 05:27:13', '2023-08-03 05:27:13'),
(589, '3BQN-unpGdMMP-vUdO', 'en', 'cancel', 'Cancel', '2023-08-03 05:27:14', '2023-08-03 05:27:14'),
(590, 'QCb0-CioA6lDH-qza1', 'en', 'payment_details', 'Payment Details', '2023-08-03 05:27:14', '2023-08-03 05:27:14'),
(591, 's1M3-l6YOrf41-DTK6', 'en', 'enter_transaction_id', 'Enter Transaction Id', '2023-08-03 05:28:18', '2023-08-03 05:28:18'),
(592, '9KDb-sCi23b2r-5BO8', 'en', 'filter', 'Filter', '2023-08-03 05:28:19', '2023-08-03 05:28:19'),
(593, 'rZvd-bbbWdsaR-MZz0', 'en', 'reset', 'Reset', '2023-08-03 05:28:19', '2023-08-03 05:28:19'),
(594, 'XZMS-EEhFRqiu-F487', 'en', 'payment_logs', 'Payment Logs', '2023-08-03 05:33:48', '2023-08-03 05:33:48'),
(595, 'mF7d-rdyvHyC5-AKu9', 'en', 'transactions', 'Transactions', '2023-08-03 05:33:54', '2023-08-03 05:33:54'),
(596, 'ozTi-bDeMI4DU-2Bq1', 'en', 'nafiz_khan_just_request_for_a_subscription', 'Nafiz Khan Just Request For A Subscription', '2023-08-03 05:43:11', '2023-08-03 05:43:11'),
(597, '3NbA-qoVtsCYT-pYLf', 'en', 'edit_page', 'Edit page', '2023-08-03 05:47:25', '2023-08-03 05:47:25'),
(598, '5NXP-i7ZGaD0y-xw6N', 'en', 'page', 'Page', '2023-08-03 05:47:25', '2023-08-03 05:47:25'),
(599, 'GSnB-p9aVYXfd-DW59', 'en', 'manage_language', 'Manage Language', '2023-08-03 05:49:04', '2023-08-03 05:49:04'),
(600, 'zPZ6-wG5joREC-fqu2', 'en', 'languages', 'Languages', '2023-08-03 05:49:04', '2023-08-03 05:49:04'),
(601, 'XG53-8fGG1wxM-xWI4', 'en', 'code', 'Code', '2023-08-03 05:49:05', '2023-08-03 05:49:05'),
(602, '2Fx1-yFLfPFlv-thrg', 'en', 'default', 'Default', '2023-08-03 05:49:05', '2023-08-03 05:49:05'),
(603, '9Y7j-YODPdHK7-qSpO', 'en', 'add_new_language', 'Add New Language', '2023-08-03 05:49:05', '2023-08-03 05:49:05'),
(604, '41Ve-bPsroJYb-3XkO', 'en', 'users__reports', 'Users & Reports', '2023-08-03 05:52:55', '2023-08-03 05:52:55'),
(605, '6lEP-DHLlYBry-suuf', 'en', 'users__reports__supports', 'Users , Reports & Supports', '2023-08-03 05:55:25', '2023-08-03 05:55:25'),
(606, '6bmw-1QDWHiDN-ILhU', 'en', 'ratings', 'Ratings', '2023-08-03 05:58:31', '2023-08-03 05:58:31'),
(607, '8Eib-H5hPkgrw-oKoA', 'en', 'review_list', 'Review List', '2023-08-03 05:58:31', '2023-08-03 05:58:31'),
(608, '6uFo-ERXVm8Nw-02zi', 'en', 'files', 'Files', '2023-08-03 05:58:34', '2023-08-03 05:58:34'),
(609, 'qili-mfDoJsfU-k9i7', 'en', 'file', 'File-', '2023-08-03 05:58:34', '2023-08-03 05:58:34'),
(610, 'DzDH-Z5M1ikOH-SiO6', 'en', 'download', 'Download', '2023-08-03 05:58:34', '2023-08-03 05:58:34'),
(611, '5TCl-3JChThdr-1hOy', 'en', 'show_users', 'Show Users', '2023-08-03 06:06:07', '2023-08-03 06:06:07'),
(612, 'xXM0-NjlgBf1q-QP18', 'en', 'show', 'Show', '2023-08-03 06:06:07', '2023-08-03 06:06:07'),
(613, 'fFnG-AH3aAGbm-ZJJ6', 'en', 'total_ticktes', 'Total Ticktes', '2023-08-03 06:12:48', '2023-08-03 06:12:48'),
(614, '8UtL-jL4BxCXt-wWF1', 'en', 'you_can_not_upload_more_than_', 'You Can Not Upload More Than ', '2023-08-03 06:25:47', '2023-08-03 06:25:47'),
(615, '0sfJ-zLr5kZlW-dMFY', 'en', '_file_at_a_time', ' File At a Time', '2023-08-03 06:25:47', '2023-08-03 06:25:47'),
(616, '9zgX-z0ad2zEj-bD47', 'en', 'manage_review', 'Manage Review', '2023-08-03 06:28:07', '2023-08-03 06:28:07'),
(617, '6ZS3-x89xHejw-JPI0', 'en', 'username', 'Username', '2023-08-03 06:32:58', '2023-08-03 06:32:58'),
(618, 'Ehxw-p0GSAZfP-vMm5', 'en', 'user_details', 'User Details', '2023-08-03 06:34:05', '2023-08-03 06:34:05'),
(619, '4B3J-pdKCAlzH-QWK3', 'en', 'running_subscription', 'Running Subscription', '2023-08-03 06:51:24', '2023-08-03 06:51:24'),
(620, 'RV0T-wByUdXn1-nq32', 'en', 'select_package', 'Select Package', '2023-08-03 06:51:24', '2023-08-03 06:51:24'),
(621, 'Uwdb-VvbvIT75-dEP6', 'en', 'update_subscriptions', 'Update Subscriptions', '2023-08-03 06:51:40', '2023-08-03 06:51:40'),
(622, '9fnd-Y7zAOnfD-prY2', 'en', 'contact_list', 'Contact List', '2023-08-03 07:40:57', '2023-08-03 07:40:57'),
(623, 'ZFxw-5UOxJsxf-QAe2', 'en', 'send_email', 'Send Email', '2023-08-03 07:40:57', '2023-08-03 07:40:57'),
(624, 'Z7H7-XfaHHA0u-6Xw6', 'en', 'message', 'Message', '2023-08-03 07:40:57', '2023-08-03 07:40:57'),
(625, '2a0E-ySoNKkwe-W7QC', 'en', 'manage_contacts', 'Manage Contacts', '2023-08-03 07:40:57', '2023-08-03 07:40:57'),
(626, 'K4rQ-0XKw84zi-tc99', 'en', 'payment_methods', 'Payment Methods', '2023-08-03 07:41:46', '2023-08-03 07:41:46'),
(627, 'hJEV-kJb96fsc-4Hv3', 'en', 'select_payment_method', 'Select Payment Method', '2023-08-03 07:41:46', '2023-08-03 07:41:46'),
(628, 'ClQt-iBAFBsGH-PZF1', 'en', 'document_root_folder', 'Document Root Folder', '2023-08-03 07:47:12', '2023-08-03 07:47:12'),
(629, '7QNQ-9m66Oiwx-nXTB', 'en', 'system_laravel_version', 'System Laravel Version', '2023-08-03 07:47:12', '2023-08-03 07:47:12'),
(630, 'o6DP-zgI2YiCE-qJe6', 'en', 'php_version', 'PHP Version', '2023-08-03 07:47:12', '2023-08-03 07:47:12'),
(631, '1IFz-1awGMFDN-xxA5', 'en', 'ip_address', 'IP Address', '2023-08-03 07:47:12', '2023-08-03 07:47:12'),
(632, '2k4R-uEfQYebI-rgq2', 'en', 'system_server_host', 'System Server host', '2023-08-03 07:47:12', '2023-08-03 07:47:12'),
(633, '2Fyk-yqo33KqO-FMDW', 'en', 'database_port_number', 'Database Port Number', '2023-08-03 07:47:12', '2023-08-03 07:47:12'),
(634, '7BxW-IWSYDKkk-0IGM', 'en', 'system_information', 'System Information', '2023-08-03 07:47:12', '2023-08-03 07:47:12'),
(635, 'AUuD-l2lQBGHi-P5p9', 'en', 'systeminfo', 'SystemInfo', '2023-08-03 07:47:12', '2023-08-03 07:47:12'),
(636, '3UOr-rJ9GqPi3-LN8a', 'en', 'feild_is_required', 'Feild is Required', '2023-08-03 07:48:01', '2023-08-03 07:48:01'),
(637, 'jZwa-zZ1QUy96-0ao5', 'en', 'subscription_updated', 'Subscription Updated', '2023-08-03 08:43:32', '2023-08-03 08:43:32'),
(638, '83Lp-16KUkDbD-lhmf', 'en', 'all_notifications', 'All Notifications', '2023-08-03 08:44:37', '2023-08-03 08:44:37'),
(639, '76EM-QxWpEb8k-XFgJ', 'en', 'notifications', 'Notifications', '2023-08-03 08:44:37', '2023-08-03 08:44:37'),
(640, '4tXA-ehQmeBks-BC9h', 'en', 'nothing_found_', 'Nothing Found !!', '2023-08-03 08:44:37', '2023-08-03 08:44:37'),
(641, '1aaN-uOSGk93I-fuZX', 'en', 'nafiz_khan_just_purchase_a_new_plan', 'Nafiz Khan Just Purchase A New Plan', '2023-08-03 08:53:32', '2023-08-03 08:53:32'),
(642, 'xOFy-11DJYrzo-xdp5', 'en', 'user_created_successfully', 'User Created Successfully', '2023-08-03 08:59:39', '2023-08-03 08:59:39'),
(643, 'LvUb-w0PV9Ct4-gek0', 'en', 'manage_roles', 'Manage Roles', '2023-08-03 09:04:46', '2023-08-03 09:04:46'),
(644, '5Rr3-IxZMifF7-GGr0', 'en', 'roles', 'Roles', '2023-08-03 09:04:46', '2023-08-03 09:04:46'),
(645, 'P5M4-vShIUM3j-Ydl2', 'en', 'enter_role_name', 'Enter Role Name', '2023-08-03 09:04:53', '2023-08-03 09:04:53'),
(646, '0ICk-7o6h2pQB-2L0Y', 'en', 'permissions', 'Permissions', '2023-08-03 09:04:53', '2023-08-03 09:04:53'),
(647, '7YKz-zEodhU6o-spT0', 'en', 'create_role', 'Create Role', '2023-08-03 09:04:53', '2023-08-03 09:04:53'),
(648, '36cO-3KEQe8EW-aPli', 'en', 'mail_gateway_lists', 'Mail Gateway Lists', '2023-08-03 09:06:18', '2023-08-03 09:06:18'),
(649, '79pH-TRgkoFW0-4kO8', 'en', 'manage_gateway', 'Manage Gateway', '2023-08-03 09:06:18', '2023-08-03 09:06:18'),
(650, 'ahgl-tdkkbyNT-qBA0', 'en', 'gateway', 'Gateway', '2023-08-03 09:06:18', '2023-08-03 09:06:18'),
(651, '9QME-ZnzkHHss-sXBM', 'en', 'secure_encryption_ssl', 'Secure encryption (SSL)', '2023-08-03 09:06:29', '2023-08-03 09:06:29'),
(652, 'LQZn-2ucucxXU-Y722', 'en', 'standard_encryption_tls', 'Standard encryption (TLS)', '2023-08-03 09:06:29', '2023-08-03 09:06:29'),
(653, 'X5nd-PRrqetmH-hjB2', 'en', 'test', 'Test', '2023-08-03 09:06:29', '2023-08-03 09:06:29'),
(654, '8NRu-yM3sFIp5-ilTb', 'en', 'test_gateway', 'Test Gateway', '2023-08-03 09:06:29', '2023-08-03 09:06:29'),
(655, '8JN4-FyWNcaJR-Ud62', 'en', 'select_security', 'Select Security', '2023-08-03 09:06:29', '2023-08-03 09:06:29'),
(656, 'gQME-Kkf0eboL-TQu2', 'en', 'update_smtp', 'Update SMTP', '2023-08-03 09:06:29', '2023-08-03 09:06:29'),
(657, 'QdwV-sAKlmeG8-8Sg7', 'en', 'enter_currency_symbol', 'Enter Currency Symbol', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(658, '5mWc-QxFiSjn2-uBF9', 'en', 'convention_rate', 'Convention Rate', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(659, '3PHJ-YQNNEPoF-QD8K', 'en', 'enter_convention_charge', 'Enter Convention Charge', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(660, '9p0g-2lVNMeNW-rdUE', 'en', 'enter_percentage_charge', 'Enter Percentage Charge', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(661, '7uhp-D0fOONdI-1NGI', 'en', 'enter_fixed_charge', 'Enter Fixed Charge', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(662, '54eB-9hK8Hho4-A8F4', 'en', 'payment_notes', 'Payment Notes', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(663, '4wJh-OtqwONz9-hrbX', 'en', 'enter_payment_notes', 'Enter Payment Notes', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(664, 'XRP0-VmCQF5uU-EiD9', 'en', 'add_new_field', 'Add New Field', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(665, '5gI0-WAdf13kH-7fPY', 'en', 'field_name', 'Field Name', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(666, '1aZN-Oqjfm7Ty-qnz4', 'en', 'input_text', 'Input Text', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(667, '5MKb-BQrjosxq-NypW', 'en', 'textarea', 'Textarea', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(668, '9Sg9-4O6rljXT-Zr4R', 'en', 'file_upload', 'File upload', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(669, '9ezb-rwi9xWIv-MVF6', 'en', 'optional', 'Optional', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(670, '3mJI-DuO34of2-YAuJ', 'en', 'select_code', 'Select Code', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(671, '4mVN-nnKuM9C1-KEV6', 'en', 'update_payment_methods', 'Update Payment Methods', '2023-08-03 09:21:49', '2023-08-03 09:21:49'),
(672, 'rrYl-zemcKHj0-PCp2', 'en', 'redirect', 'Redirect', '2023-08-03 09:55:14', '2023-08-03 09:55:14'),
(673, '8S0s-ZXhsbKLP-iGK4', 'en', 'please_wait_while_you_are_redirecting__', 'Please wait while you are redirecting .... ', '2023-08-03 09:55:14', '2023-08-03 09:55:14'),
(674, 'xdMj-ab4eL0mq-YHV0', 'en', 'article_not_found', 'Article Not Found', '2023-08-03 09:56:18', '2023-08-03 09:56:18'),
(675, 'ahP6-AGYooI9l-62C8', 'en', 'buisness', 'Buisness', '2023-08-03 09:56:51', '2023-08-03 09:56:51'),
(676, 'Oiiw-Xb87mpnD-rXO9', 'en', 'expired_link__subscription', 'Expired Link & Subscription', '2023-08-03 10:04:18', '2023-08-03 10:04:18'),
(677, '6Z7B-szeecUyy-oqTq', 'en', 'some_thing_went_wrong', 'Some thing Went Wrong', '2023-08-03 10:04:23', '2023-08-03 10:04:23'),
(678, 'fRZF-NbwjPdDL-ZfU2', 'en', 'status_updated_successfully', 'Status Updated Successfully', '2023-08-03 10:04:23', '2023-08-03 10:04:23'),
(679, '5390-nt7haktK-4dzh', 'en', 'expired_link__subscription_delete', 'Expired Link & Subscription Delete', '2023-08-03 10:04:56', '2023-08-03 10:04:56'),
(680, '9LgN-0NcpgRAb-2S0r', 'en', 'expired_links__subscription_delete_after', 'Expired Links & Subscription Delete After', '2023-08-03 10:07:32', '2023-08-03 10:07:32'),
(681, '3Io6-gcXGbr1U-tHq3', 'en', 'in_days', 'In Days', '2023-08-03 10:07:32', '2023-08-03 10:07:32'),
(682, '50lD-8UxbXwEv-ZD0t', 'en', 'last_cron_run', 'Last Cron Run', '2023-08-03 10:53:57', '2023-08-03 10:53:57'),
(683, '3t9N-p1vq9krF-QMR3', 'en', 'your_running_subscription_is_expired_', 'Your Running Subscription Is Expired !!', '2023-08-03 10:54:15', '2023-08-03 10:54:15'),
(684, '7oC3-8ZvPYwuX-F1YC', 'en', 'price', 'Price', '2023-08-03 10:59:41', '2023-08-03 10:59:41'),
(685, 'ogQW-zS6coVaL-HaP1', 'en', 'discount_price', 'Discount Price', '2023-08-03 10:59:41', '2023-08-03 10:59:41'),
(686, '2Fx8-hx3UBUAz-4BGk', 'en', 'manage_package', 'Manage Package', '2023-08-03 10:59:41', '2023-08-03 10:59:41'),
(687, '148U-3lt2DAv5-Tnps', 'en', 'duration', 'Duration', '2023-08-03 10:59:44', '2023-08-03 10:59:44'),
(688, 'O5GT-ssZccEah-nM84', 'en', 'enter_price', 'Enter Price', '2023-08-03 10:59:44', '2023-08-03 10:59:44'),
(689, 'qjcp-DlTdVcMe-hXQ6', 'en', '_discount_price', ' Discount Price', '2023-08-03 10:59:44', '2023-08-03 10:59:44'),
(690, 't6Ap-uRSiBFiP-zDK1', 'en', 'enter_discount_price', 'Enter Discount Price', '2023-08-03 10:59:44', '2023-08-03 10:59:44'),
(691, '3aaB-7YTD7Vez-hcrQ', 'en', 'total_link_submission', 'Total Link Submission', '2023-08-03 10:59:44', '2023-08-03 10:59:44'),
(692, '2QAn-ci5YHpEb-Fn2j', 'en', 'per_day', 'Per Day', '2023-08-03 10:59:44', '2023-08-03 10:59:44'),
(693, '7rgs-6lz1QPid-EFxq', 'en', 'max_5', 'Max 5', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(694, 's3M5-FfIHl9tr-xD92', 'en', 'maximum_deep_links', 'Maximum Deep Links', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(695, '1K6F-2rHJ14ov-HlPE', 'en', 'link_expire_in', 'Link Expire In', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(696, 'TR1q-2bzbBlPg-P7B3', 'en', 'allow_contacts', 'Allow Contacts', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(697, '2QoK-SD59X70J-zcFl', 'en', 'show_verified_badge', 'Show Verified Badge', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(698, 'kpWT-Ho0NmSvH-Hru9', 'en', 'allow_link_attribute', 'Allow Link Attribute', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(699, 'HEtF-sjSKpy2K-krR4', 'en', 'feature_on_home_page', 'Feature On Home Page', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(700, 'GvB6-4vqiZgg5-bMe8', 'en', 'allow_address', 'Allow Address', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(701, '13hh-VpTpAPMA-FIi2', 'en', 'select_duration', 'Select Duration', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(702, 'Ceio-ZsYKFP5n-UTP1', 'en', 'create_package', 'Create Package', '2023-08-03 10:59:45', '2023-08-03 10:59:45'),
(703, 'l9dX-gLdbRLZU-ao17', 'en', 'update_package', 'Update Package', '2023-08-03 11:04:12', '2023-08-03 11:04:12'),
(704, 'AKK3-7Dr1aEzP-KGx5', 'en', 'package_updated_successfully', 'Package Updated Successfully', '2023-08-03 11:06:31', '2023-08-03 11:06:31'),
(705, 'FANe-djd9N2Iv-Ot90', 'en', 'update_article', 'Update Article', '2023-08-03 11:18:16', '2023-08-03 11:18:16'),
(706, '2cQK-WuFGZRGz-2C2m', 'en', 'social_icon', 'Social Icon', '2023-08-03 11:19:26', '2023-08-03 11:19:26'),
(707, 'wMYa-njbPbgUj-Gaz3', 'en', 'fifa__the_home_of_football', 'FIFA | The Home of Football', '2023-08-03 11:27:46', '2023-08-03 11:27:46'),
(708, '0KeW-kEe4dIX3-dCH9', 'en', 'staff_created_successfully', 'Staff Created Successfully', '2023-08-03 11:33:02', '2023-08-03 11:33:02'),
(709, 'L6pJ-pe455zT0-M3B7', 'en', 'password_updated', 'Password Updated', '2023-08-03 11:33:16', '2023-08-03 11:33:16'),
(710, '4HpA-GeEZEru0-7kRt', 'en', 'role_created_successfully', 'Role Created Successfully', '2023-08-03 11:34:32', '2023-08-03 11:34:32'),
(711, 'Hxtm-swgNoH3f-tvQ1', 'en', 'invalid_transaction', 'Invalid Transaction', '2023-08-03 11:35:19', '2023-08-03 11:35:19'),
(712, 'JBCN-SqucCug1-gfq2', 'en', 'you_can_not_purchase_free_package_more_than_one_time', 'You Can Not Purchase Free Package More Than One Time!!', '2023-08-03 11:36:17', '2023-08-03 11:36:17'),
(713, 'RAXp-tuIE8HJ7-8Ms8', 'en', 'staff_updated_successfully', 'Staff Updated Successfully', '2023-08-03 11:36:33', '2023-08-03 11:36:33'),
(714, '3fPN-nf7zpiJb-Tbyu', 'en', 'experiment_just_approved_your_link', 'Experiment Just Approved Your Link', '2023-08-03 11:39:59', '2023-08-03 11:39:59'),
(715, '5eE2-3PDvMmY8-CaRZ', 'en', 'staff_not_found', 'Staff Not Found', '2023-08-03 11:41:55', '2023-08-03 11:41:55'),
(716, '8fsG-LIk4osLS-ppJ1', 'en', 'role_not_found', 'Role Not Found', '2023-08-03 11:42:03', '2023-08-03 11:42:03'),
(717, '20CA-FvFd07VT-TS7M', 'en', 'role_has_staff_under_it', 'Role Has Staff Under It!!', '2023-08-03 11:42:04', '2023-08-03 11:42:04'),
(718, 'Uqzd-b2Q7UqXZ-bFk9', 'en', 'deletd_successfully', 'Deletd Successfully', '2023-08-03 11:42:04', '2023-08-03 11:42:04'),
(719, '0moH-7vCXIBNj-OTn2', 'en', 'plan_amount', 'Plan Amount', '2023-08-03 11:43:13', '2023-08-03 11:43:13'),
(720, 'nMN3-K8Kxu6n6-oCR1', 'en', 'charge_included_for_successful_payment', '(charge included) for successful payment', '2023-08-03 11:43:13', '2023-08-03 11:43:13'),
(721, 'ZtFz-OfHYvlea-ptU0', 'en', 'phone_number', 'Phone Number', '2023-08-03 11:43:14', '2023-08-03 11:43:14'),
(722, 'L96h-zeCmM4e1-rMr3', 'en', 'payment_processing_time', 'Payment Processing Time', '2023-08-03 11:43:14', '2023-08-03 11:43:14'),
(723, 'arsq-CcnoEyrb-m5n9', 'en', 'create_category', 'Create Category', '2023-08-03 11:44:57', '2023-08-03 11:44:57'),
(724, '7kRn-PZByvXOi-M3IK', 'en', 'feature_articles', 'Feature Articles', '2023-08-03 12:02:23', '2023-08-03 12:02:23'),
(725, 'p2fg-nQWbfmnh-BBc9', 'en', 'total_comments', 'Total Comments', '2023-08-03 12:02:23', '2023-08-03 12:02:23'),
(726, 'e4kX-7ZaIQqLU-vG58', 'en', 'approved_comments', 'Approved Comments', '2023-08-03 12:02:23', '2023-08-03 12:02:23'),
(727, 'ssq3-BgyNnF8L-MrB9', 'en', 'pending_comments', 'Pending Comments', '2023-08-03 12:02:23', '2023-08-03 12:02:23'),
(728, '6icd-6kyyfCb2-qRB7', 'en', 'article_list', 'Article List', '2023-08-03 12:02:23', '2023-08-03 12:02:23'),
(729, '110N-SVlhfRJj-WGL1', 'en', 'total_likes', 'Total Likes', '2023-08-03 12:02:23', '2023-08-03 12:02:23'),
(730, '5oNd-e7sJQ3IU-cYFw', 'en', 'manage_article', 'Manage Article', '2023-08-03 12:02:23', '2023-08-03 12:02:23'),
(731, 'lF3K-SkxLu4hg-i3a1', 'en', 'create_article', 'Create Article', '2023-08-03 12:02:32', '2023-08-03 12:02:32'),
(732, '7Qmi-BjiPzacs-KMyc', 'en', 'image_size_must_be_960x480', 'Image size must be 960X480', '2023-08-03 12:02:50', '2023-08-03 12:02:50'),
(733, '43z5-DLLrE4xg-grTm', 'en', 'article_created_successfully', 'Article Created Successfully', '2023-08-03 12:03:11', '2023-08-03 12:03:11'),
(734, '6auy-IhAGg9wH-xKCA', 'en', 'manage_comments', 'Manage Comments', '2023-08-03 12:03:23', '2023-08-03 12:03:23'),
(735, 'ArvB-PZmekui7-lhy0', 'en', 'articles_not_found', 'Articles Not Found', '2023-08-03 12:03:31', '2023-08-03 12:03:31'),
(736, 'fXIe-CgVFDq6B-iZu9', 'en', 'subscriber_list', 'Subscriber List', '2023-08-03 12:03:50', '2023-08-03 12:03:50'),
(737, 'mMdh-9tMqly7U-b371', 'en', 'search_by_email', 'Search By Email', '2023-08-03 12:03:50', '2023-08-03 12:03:50'),
(738, 'Je85-97PPPaB2-GhX2', 'en', 'send_mail', 'Send Mail', '2023-08-03 12:03:50', '2023-08-03 12:03:50'),
(739, '2dMu-bGvf8rPJ-NBO3', 'en', 'manage_subscribers', 'Manage Subscribers', '2023-08-03 12:03:50', '2023-08-03 12:03:50'),
(740, 'gYEY-J9AknR1B-DO08', 'en', 'subscribers', 'Subscribers', '2023-08-03 12:03:50', '2023-08-03 12:03:50'),
(741, 'QJSP-Qn0dhYY1-Tn18', 'en', 'template_list', 'Template List', '2023-08-03 12:03:55', '2023-08-03 12:03:55'),
(742, 'E1ty-Emj7rRBo-SP03', 'en', 'manage_template', 'Manage Template', '2023-08-03 12:03:55', '2023-08-03 12:03:55'),
(743, 'QkGU-EWgvWjNG-8Cq2', 'en', 'email_body', 'Email Body', '2023-08-03 12:04:02', '2023-08-03 12:04:02'),
(744, 'jWEp-UgzAL544-bX62', 'en', 'sms_body', 'Sms Body', '2023-08-03 12:04:02', '2023-08-03 12:04:02'),
(745, '4NF3-pFl8taDv-sLUq', 'en', 'template_key', 'Template Key', '2023-08-03 12:04:02', '2023-08-03 12:04:02'),
(746, 'iNoc-NGNFhHW4-DUT8', 'en', 'manage_global_template', 'Manage Global Template', '2023-08-03 12:04:02', '2023-08-03 12:04:02'),
(747, '0F5s-Aen83zf4-Vi40', 'en', 'sms_gateway_list', 'Sms Gateway List', '2023-08-03 12:04:08', '2023-08-03 12:04:08'),
(748, '78SS-zQwAQDGL-EOB3', 'en', 'the_name_feild_is_required', 'The Name Feild is Required', '2023-08-03 12:06:09', '2023-08-03 12:06:09'),
(749, '5QmR-otpuLmRl-IoU1', 'en', 'the_name_must_be_unique', 'The Name Must Be Unique', '2023-08-03 12:06:09', '2023-08-03 12:06:09'),
(1498, 'hham-246I8Ye2-qiu3', 'en', 'language_created_succesfully', 'Language Created Succesfully', '2023-08-03 12:06:10', '2023-08-03 12:06:10'),
(1499, 'Rmn6-GYY8kxxa-VLI0', 'en', 'account_details', 'Account Details', '2023-08-03 12:08:17', '2023-08-03 12:08:17'),
(1500, '0YYQ-s1XUkhSQ-eNww', 'en', 'enter_username', 'Enter Username', '2023-08-03 12:08:17', '2023-08-03 12:08:17'),
(1501, '2F0A-W0qxlsBu-SU5z', 'en', 'enter_phone_number', 'Enter Phone Number', '2023-08-03 12:08:17', '2023-08-03 12:08:17'),
(1502, 'MYYo-lrAgUu4Y-3UN4', 'en', 'enter_pasdsword', 'Enter Pasdsword', '2023-08-03 12:08:17', '2023-08-03 12:08:17'),
(1503, '7Tvv-WVhsUc36-4Iwt', 'en', 'confrim_password', 'Confrim Password', '2023-08-03 12:08:17', '2023-08-03 12:08:17'),
(1504, '6OSw-LIEqbclV-t1v5', 'en', 'enterconfirm__pasdsword', 'EnterConfirm  Pasdsword', '2023-08-03 12:08:17', '2023-08-03 12:08:17'),
(1505, '8rHQ-bh31lP7U-BTft', 'en', 'you_dont_have_any_running_subscription__please_purchase_a_new_package', 'You Dont Have Any Running Subscription !! Please Purchase A New Package', '2023-08-03 12:08:37', '2023-08-03 12:08:37'),
(1506, '4mIU-U6NSuDM8-2CKn', 'en', 'experiment_just_purchase_a_new_plan', 'Experiment Just Purchase A New Plan', '2023-08-03 12:08:41', '2023-08-03 12:08:41'),
(1507, 'A7q6-7yRnapJN-NZ80', 'en', 'new_subscription_added', 'New Subscription Added!!', '2023-08-03 12:08:41', '2023-08-03 12:08:41'),
(1508, 'mGlG-cr2itBBW-6on2', 'en', 'experiment_just_had_a_new_subscription_plan', 'Experiment Just Had A New Subscription Plan', '2023-08-03 12:08:41', '2023-08-03 12:08:41'),
(1509, 'ju09-mi9xpevB-cIS0', 'en', 'you_dont_have_any_subscription_running', 'You Dont Have Any Subscription Running!!', '2023-08-03 12:11:38', '2023-08-03 12:11:38'),
(1510, 'rr4v-txvppYYW-Mcz3', 'en', 'invalid_subscription', 'Invalid Subscription', '2023-08-03 12:11:38', '2023-08-03 12:11:38'),
(1511, '37pt-nMJ0pgp2-q0nt', 'en', 'link_submission_limit_reached_please_try_again_tomorrow', 'Link submission limit reached. Please try again tomorrow.', '2023-08-03 12:11:38', '2023-08-03 12:11:38'),
(1512, '9G5G-RQHSjBNz-r9U8', 'en', 'link_created_successfully_please_wait_for_confirmation', 'Link Created Successfully!! Please Wait For Confirmation', '2023-08-03 12:11:39', '2023-08-03 12:11:39'),
(1513, '8Bst-Z3gGCbFb-OV73', 'en', 'experiment_just_created_a_link', 'Experiment Just Created A Link', '2023-08-03 12:11:39', '2023-08-03 12:11:39'),
(1514, 'ukbG-FrbBJUfX-ykS6', 'en', 'all_links', 'All Links', '2023-08-03 12:12:15', '2023-08-03 12:12:15'),
(1515, 'Dh8q-ufuJs9lg-nWQ2', 'en', 'link_title', 'Link Title', '2023-08-03 12:12:15', '2023-08-03 12:12:15'),
(1516, '4CNO-JYuzgAes-f2Jg', 'en', 'approved', 'Approved', '2023-08-03 12:12:15', '2023-08-03 12:12:15'),
(1517, '83Bp-JSdurkTa-Zquj', 'en', 'one', 'one', '2023-08-03 12:12:15', '2023-08-03 12:12:15'),
(1518, 'uXVP-NiuI0lKd-2cu8', 'en', 'jokes', 'Jokes', '2023-08-03 12:12:19', '2023-08-03 12:12:19'),
(1519, '0eMk-CrNBgkqx-XHkg', 'en', 'already_added_in_your_list', 'Already Added In Your List', '2023-08-03 12:15:05', '2023-08-03 12:15:05'),
(1520, 'jN2E-1N8LrgB9-88M7', 'en', 'link_added_in_your_favorite_list', 'Link Added In Your Favorite List', '2023-08-03 12:15:05', '2023-08-03 12:15:05'),
(1521, 'HuzW-8LkoalTC-yh18', 'en', 'this_link_has_lot_of_items_under_it', 'This Link Has Lot Of Items Under It!!', '2023-08-03 12:18:20', '2023-08-03 12:18:20'),
(1522, 'JGy9-dDt9bvfh-tKa1', 'en', 'link_deleted', 'Link Deleted!!', '2023-08-03 12:18:21', '2023-08-03 12:18:21'),
(1523, 'R37W-1gZrKF8Y-qT06', 'en', 'asfaffsa', 'asfaffsa', '2023-08-03 12:19:14', '2023-08-03 12:19:14'),
(1524, '40xK-cckodRn4-mX6m', 'en', 'create_ticket', 'Create Ticket', '2023-08-03 12:19:20', '2023-08-03 12:19:20'),
(1525, '9RdU-Lr4nCtM5-TkNZ', 'en', 'id', 'Id', '2023-08-03 12:19:20', '2023-08-03 12:19:20'),
(1526, '9HiL-LkLkA17q-Qjpw', 'en', 'give_us_feedback', 'Give Us Feedback', '2023-08-03 12:20:48', '2023-08-03 12:20:48'),
(1527, '6IOz-E7fzUEIS-Qenv', 'en', 'max', 'Max-', '2023-08-03 12:20:53', '2023-08-03 12:20:53'),
(1528, '10zn-IBsTt38n-ZVmm', 'en', 'select_priority', 'Select Priority', '2023-08-03 12:20:53', '2023-08-03 12:20:53'),
(1529, '9CLv-sYL2LVCg-RkJ6', 'en', 'experiment_just_create_a_', 'Experiment Just Create A ', '2023-08-03 12:21:29', '2023-08-03 12:21:29'),
(1530, '4x0B-RdkcmIvQ-B1u0', 'en', 'ticket_successfully_created', 'Ticket Successfully Created', '2023-08-03 12:21:29', '2023-08-03 12:21:29'),
(1531, '1r9K-NBeSvWPw-us7R', 'en', 'ticket_reply', 'Ticket Reply', '2023-08-03 12:21:30', '2023-08-03 12:21:30'),
(1532, '4Q1V-FZF0o8fJ-8gCN', 'en', 'reply_here', 'Reply Here', '2023-08-03 12:21:30', '2023-08-03 12:21:30'),
(1533, 'wTl7-S39lUI1m-sF14', 'en', 'messages', 'Messages', '2023-08-03 12:21:30', '2023-08-03 12:21:30'),
(1534, '1kBF-YM5isx8x-nfpW', 'en', 'ticket_detail', 'Ticket Detail', '2023-08-03 12:21:30', '2023-08-03 12:21:30'),
(1535, 'nFqS-LbV8IVNJ-KIz8', 'en', 'files_attachment', 'Files Attachment', '2023-08-03 12:21:31', '2023-08-03 12:21:31'),
(1536, 'G14X-DHA8jObE-dgy0', 'en', 'experiment_just_replied_to_a_ticket', 'Experiment Just Replied To a Ticket', '2023-08-03 12:21:47', '2023-08-03 12:21:47'),
(1537, 'eLBi-C863BFNw-bZ21', 'en', 'replied_successfully', 'Replied Successfully', '2023-08-03 12:21:47', '2023-08-03 12:21:47'),
(1538, '4gQt-PSE6JWpr-VylX', 'en', 'superadmin_just_replied_to_a_ticket', 'SuperAdmin Just Replied To A Ticket', '2023-08-03 12:22:11', '2023-08-03 12:22:11'),
(1539, '6SIB-v1UCqBMu-mOzR', 'en', 'media', 'Media', '2023-08-03 12:27:56', '2023-08-03 12:27:56'),
(1540, '9DpU-ynEkVxD3-Mchy', 'en', 'language_switched_successfully', 'Language Switched Successfully', '2023-08-03 12:28:22', '2023-08-03 12:28:22'),
(1541, 'pXxR-Mz9nlevl-W2p0', 'al', 'language_switched_successfully', 'Language Switched Successfully', '2023-08-03 12:28:22', '2023-08-03 12:28:22'),
(1542, 'R2BH-9wnJgtSr-i4Y4', 'al', 'home', 'Home', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1543, '7G6h-1rxaTW8L-XtM8', 'al', 'media', 'Media', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1544, '0Cq0-LjDK5R4u-cDiq', 'al', 'search_links', 'Search Links', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1545, '9yIY-IvZAxt8a-WC5v', 'al', 'latest', 'Latest', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1546, '1ktP-FpnFY4g9-XGvc', 'al', 'feature', 'Feature', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1547, '1nJk-rkJ4xj6s-m8Y3', 'al', 'most_viewed', 'Most Viewed', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1548, 'vPQE-zNH5s1gU-ZuL2', 'al', 'least_viewed', 'Least Viewed', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1549, '53H8-YQqPWat6-RUTm', 'al', 'most_like', 'Most Like', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1550, '3FHb-F5lSHCiY-Zk6Q', 'al', 'least_like', 'Least Like', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1551, 'MyoO-cSgddRod-3Zz7', 'al', 'category', 'Category', '2023-08-03 12:28:24', '2023-08-03 12:28:24'),
(1552, '7faP-UiRYeWhW-LzWh', 'al', 'dashboard', 'Dashboard', '2023-08-03 12:28:26', '2023-08-03 12:28:26'),
(1553, 'H4mF-MB5SesVt-S1o1', 'al', 'logout', 'Logout', '2023-08-03 12:28:26', '2023-08-03 12:28:26'),
(1554, 'M6EG-21rIX1FW-5Da2', 'al', 'pages', 'Pages', '2023-08-03 12:28:26', '2023-08-03 12:28:26'),
(1555, '47Fl-4ncJnDRv-xVes', 'al', 'welcome', 'Welcome', '2023-08-03 12:28:26', '2023-08-03 12:28:26'),
(1556, '7y9q-MqRgTsGm-rpkp', 'al', 'important_links', 'Important Links', '2023-08-03 12:28:27', '2023-08-03 12:28:27'),
(1557, '88qu-lMJKDugD-0HLl', 'al', 'quick_link', 'Quick link', '2023-08-03 12:28:27', '2023-08-03 12:28:27'),
(1558, 'WYOu-HGJkd8L8-I186', 'al', 'enter_your_email', 'Enter Your Email', '2023-08-03 12:28:27', '2023-08-03 12:28:27'),
(1559, '6KL0-7ti9WilM-iR9j', 'al', 'social_icon', 'Social Icon', '2023-08-03 12:28:27', '2023-08-03 12:28:27'),
(1560, '41ac-YeQwr9s3-LdI2', 'al', 'search_now', 'Search Now', '2023-08-03 12:30:46', '2023-08-03 12:30:46'),
(1561, '9BwO-wYFP0v1d-dX86', 'al', 'links_available', 'Links available', '2023-08-03 12:30:46', '2023-08-03 12:30:46'),
(1562, 'xBBO-3wATP8qT-Faf4', 'al', 'total_links', 'Total links', '2023-08-03 12:30:47', '2023-08-03 12:30:47'),
(1563, '28LR-4KrO072A-rUOr', 'al', 'total_articles', 'Total Articles', '2023-08-03 12:30:47', '2023-08-03 12:30:47'),
(1564, 'yr7k-By97OyQ0-YSO1', 'al', 'total_user', 'Total User', '2023-08-03 12:30:47', '2023-08-03 12:30:47'),
(1565, 'oCLh-iPmHPS2H-yPD2', 'al', 'total_visitors', 'Total Visitors', '2023-08-03 12:30:47', '2023-08-03 12:30:47'),
(1566, '03YT-IbpQH6Lf-KQxB', 'al', 'pending_link', 'Pending Link', '2023-08-03 12:31:31', '2023-08-03 12:31:31'),
(1567, '28cD-crR8zYU7-8iD4', 'al', 'view_all', 'View All', '2023-08-03 12:31:31', '2023-08-03 12:31:31'),
(1568, '74ff-C0UXEg7d-WImq', 'al', 'feature_link', 'Feature Link', '2023-08-03 12:31:31', '2023-08-03 12:31:31'),
(1569, '48dn-V2u8Yr8N-xlDo', 'al', 'total_review', 'Total Review', '2023-08-03 12:31:31', '2023-08-03 12:31:31'),
(1570, '0r7j-ZPd4uI3T-bAz1', 'al', 'pending_review', 'Pending Review', '2023-08-03 12:31:31', '2023-08-03 12:31:31'),
(1571, '4iQP-vNpclfrL-T7QL', 'al', 'link_list', 'Link List', '2023-08-03 12:31:31', '2023-08-03 12:31:31'),
(1572, 'I7Fu-Y5A5Pqqg-1tr4', 'al', 'add_new', 'Add New', '2023-08-03 12:31:31', '2023-08-03 12:31:31'),
(1573, '3SIs-tTtMLH1j-zYJ2', 'al', 'select_user', 'Select User', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1574, '55hD-tF0qsOHT-7YR0', 'al', 'search_by_title', 'Search By Title', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1575, 'SkeF-FGYocZQ2-y9b0', 'al', 'title', 'Title', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1576, 'AznG-zDXPmHQq-YMI7', 'al', 'expired_at', 'Expired At', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1577, '4Wbl-dqEYFaWF-g5a2', 'al', 'views', 'Views', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1578, 'hDCF-T5Faveoc-dqY3', 'al', 'likes', 'Likes', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1579, 'oe7h-EfnaDyWc-ohy3', 'al', 'user', 'User', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1580, '9cjf-FewMV7TT-PTXL', 'al', 'feature_on_home', 'Feature On Home', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1581, 'dcER-ZkdwhycL-jka6', 'al', 'verified', 'Verified', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1582, 'zEaF-QG5tAJIq-ccF1', 'al', 'status', 'Status', '2023-08-03 12:31:32', '2023-08-03 12:31:32');
INSERT INTO `translations` (`id`, `uid`, `code`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1583, '9f8h-Q1UOsejq-lATU', 'al', 'options', 'Options', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1584, '6OjJ-DMdYnGe2-TBTO', 'al', 'expired_date', 'Expired Date', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1585, 'ZrM0-cXG1RL9Q-EfE2', 'al', 'view', 'View', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1586, '9Pgj-fuRxv60x-lEiU', 'al', 'na', 'N/A', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1587, 'zRxY-ff4C1K2X-xBi2', 'al', 'manage_links', 'Manage Links', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1588, '90Pb-qUWq3BOx-TMXP', 'al', 'notification', 'Notification', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1589, '5OIJ-0EzUw8ES-v1hM', 'al', 'new', 'New', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1590, 'qNaH-a6zo4aYS-CGU4', 'al', 'setting', 'Setting', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1591, '0XyZ-PICVD92L-unbr', 'al', 'do_you_really_want_to_sign_out__', 'Do You Really Want To Sign out ?? ', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1592, '6LB4-ZUJPFeq4-Zxh3', 'al', 'are_you_sure', 'Are You Sure!!', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1593, '2YRe-YHUvT0zL-EBU6', 'al', 'no', 'No', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1594, 'gXl5-alpHbBoT-kDZ3', 'al', 'yes', 'Yes', '2023-08-03 12:31:32', '2023-08-03 12:31:32'),
(1595, 'jlxX-xbIDSjbp-w0R0', 'al', 'pending_logs', 'Pending Logs', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1596, 'BQDr-4SX4igPx-b0J5', 'al', 'manage_staff', 'Manage Staff', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1597, '9Ahn-3NWOAZbo-tdtH', 'al', 'staffs__permissions', 'Staffs & Permissions', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1598, 'LRbt-WEnCmfMj-9jm1', 'al', 'roles__permissions', 'Roles & Permissions', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1599, '57yM-99eJBE4A-I2Nd', 'al', 'staffs', 'Staffs', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1600, '72D0-hPeGmURs-tjVN', 'al', 'link_settings', 'Link Settings', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1601, 'lGDH-PPCiJDTy-KHS9', 'al', 'links', 'Links', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1602, '2WWP-QLyD2nso-9Ecd', 'al', 'categories', 'Categories', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1603, 'Xxlh-Dh2MAZoj-nmS2', 'al', 'package', 'Package', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1604, '2Du0-Y793IUTL-w50V', 'al', 'packages', 'Packages', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1605, '68t0-myRx5BSP-bl9B', 'al', 'users__reports__supports', 'Users , Reports & Supports', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1606, '7MSN-b7TePhgN-Kb94', 'al', 'support_tickets', 'Support Tickets', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1607, '5HCD-YnWpkEsq-oqC6', 'al', 'reports', 'Reports', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1608, '2Lxv-fDafoajA-BVX5', 'al', 'subscription_log', 'Subscription Log', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1609, 'XYPo-uXYtVmJw-Our8', 'al', 'payment_log', 'Payment Log', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1610, '1dT8-qYxszpPo-EE6o', 'al', 'transaction_log', 'Transaction Log', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1611, 'CgS1-av9vdtvv-Q388', 'al', 'website_control', 'Website Control', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1612, '6C7G-0LAwNof1-hZQb', 'al', 'manage_frontend', 'Manage Frontend', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1613, '7RN3-Kwco7Zzk-ag7v', 'al', 'frontend_section', 'Frontend Section', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1614, '9ox5-x2qnvVYt-AjDf', 'al', 'seo', 'Seo', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1615, 'xvM1-1ox38Irb-o7b3', 'al', 'visitors', 'Visitors', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1616, '75RL-aLbLo6dl-7Zfa', 'al', 'client_review', 'Client Review', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1617, 'Bsls-psXmEyKW-F445', 'al', 'cta', 'Cta', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1618, '0NFw-WVCGg3pY-lP0I', 'al', 'faq', 'Faq', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1619, 'e9A0-FHaBGH3T-PJM0', 'al', 'menu', 'Menu', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1620, '0EQ9-9dH6H51M-GLaC', 'al', 'article', 'Article', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1621, 'Yy8O-5obrnRBZ-fjS5', 'al', 'articles', 'Articles', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1622, 'fTKR-oEE2xJYe-8qE0', 'al', 'marketing__promotions', 'Marketing & Promotions', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1623, '6cjS-V5Gt9TVM-lz7z', 'al', 'ads', 'Ads', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1624, '2enh-jdhc0VNJ-uGO8', 'al', 'contacts', 'Contacts', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1625, 'sxkc-Vq2Yacn2-ABu7', 'al', 'subscriber', 'Subscriber', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1626, '9C2R-YGzZZwjT-NJ8M', 'al', 'notifications_template', 'Notifications Template', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1627, 'gj8j-jYgeBcWM-u7G7', 'al', 'templates', 'Templates', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1628, '2AJn-j0ntRo7h-qs5P', 'al', 'notification_template', 'Notification Template', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1629, 'Rtor-0ToGCfJJ-hGp0', 'al', 'global_template', 'Global Template', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1630, 'LEdm-krwuuVla-lET5', 'al', 'mail__sms_settings', 'Mail & Sms Settings', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1631, '9Saq-xP3zbT4r-XPBY', 'al', 'mail_gateway', 'Mail Gateway', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1632, '8CPM-wmRF11eH-myqd', 'al', 'sms_gateway', 'Sms Gateway', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1633, 'SyfV-Wf3DJyd8-oCC2', 'al', 'payment_settings', 'Payment Settings', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1634, 'OLVS-pKgLfEIG-b1J4', 'al', 'payment_gateway', 'Payment Gateway', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1635, '07sn-8ctx3bLq-WZeD', 'al', 'automatic_method', 'Automatic Method', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1636, '5s5s-szfaQ0Uu-7xU3', 'al', 'manual__method', 'Manual  Method', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1637, 'TX7Z-R4yNn7Vf-MIM8', 'al', 'language__localizations', 'Language / Localizations', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1638, 'EDbF-oi4OU0jS-ZEj4', 'al', 'language', 'Language', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1639, '7A8L-5iEkYPYn-nKSy', 'al', 'adminstrator__business', 'Adminstrator / Business', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1640, '0yeQ-LZGilEXH-dEF2', 'al', 'applications_settings', 'Applications Settings', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1641, '4E9h-nQcmvG4e-G0Ab', 'al', 'app_settings', 'App Settings', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1642, '8uZN-g0nGAUId-JZbN', 'al', 'system_preferences', 'System Preferences', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1643, 'dh1H-tnN0cSMs-mA86', 'al', 'softwae_info', 'Softwae Info', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1644, 'wzBW-63cthhGP-blt1', 'al', 'software_info', 'Software Info', '2023-08-03 12:31:33', '2023-08-03 12:31:33'),
(1645, '0iLN-Z5ih9ljL-6c2Q', 'al', 'updated_successfully', 'Updated Successfully', '2023-08-03 12:31:39', '2023-08-03 12:31:39'),
(1646, '6iLY-lLZ3IHi2-2Dld', 'al', 'subscriber_list', 'Subscriber List', '2023-08-03 12:33:20', '2023-08-03 12:33:20'),
(1647, '8VuK-TJHg6ZoY-JjNa', 'al', 'search_by_email', 'Search By Email', '2023-08-03 12:33:20', '2023-08-03 12:33:20'),
(1648, '05it-HEFduGsd-gC2v', 'al', 'email', 'Email', '2023-08-03 12:33:20', '2023-08-03 12:33:20'),
(1649, '2QeV-pmB18qV3-Hf63', 'al', 'subscribe_at', 'Subscribe At', '2023-08-03 12:33:20', '2023-08-03 12:33:20'),
(1650, '4eII-JExN8c1k-nNyn', 'al', 'send_mail', 'Send Mail', '2023-08-03 12:33:20', '2023-08-03 12:33:20'),
(1651, '5PsW-6qvHGEKy-SW3l', 'al', 'message', 'Message', '2023-08-03 12:33:20', '2023-08-03 12:33:20'),
(1652, '2CuL-7IsVJU4g-ziyR', 'al', 'type_here', 'Type Here', '2023-08-03 12:33:20', '2023-08-03 12:33:20'),
(1653, '8EaW-QUVs54Zk-FQ19', 'al', 'close', 'Close', '2023-08-03 12:33:20', '2023-08-03 12:33:20'),
(1654, '4S9X-KlLIZ4bT-ZF0e', 'al', 'submit', 'Submit', '2023-08-03 12:33:21', '2023-08-03 12:33:21'),
(1655, '1AAt-Mpn1T6t7-L1x3', 'al', 'manage_subscribers', 'Manage Subscribers', '2023-08-03 12:33:21', '2023-08-03 12:33:21'),
(1656, '4GBj-ypIRcT0I-beNy', 'al', 'subscribers', 'Subscribers', '2023-08-03 12:33:21', '2023-08-03 12:33:21'),
(1657, 'Uw1m-dSBzTf5s-kQ86', 'al', 'search_by_name', 'Search By Name', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1658, '6ZxG-R60bxYW0-UpIL', 'al', 'name', 'Name', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1659, '6lpv-lFbdOYh0-R781', 'al', 'url', 'Url', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1660, 'wep0-gFdd1HGs-h5r4', 'al', 'created_by', 'Created By', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1661, 'cAG2-yRcjHiHY-MpI3', 'al', 'show_in_header', 'Show In Header', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1662, '5dAp-unbjhPyD-8Cxj', 'al', 'show_in_footer', 'Show In Footer', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1663, 'kjWi-KllDHzm1-uOp9', 'al', 'action', 'Action', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1664, 'HqwN-2KXK3lmL-8266', 'al', 'add_menu', 'Add Menu', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1665, '3YFI-5voqgK9T-AJC5', 'al', 'enter_name', 'Enter name', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1666, '9qfC-zWBQES8C-1W7z', 'al', 'serial_id', 'Serial Id', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1667, '3mD1-CqeCDIft-9O6L', 'al', 'enter_serial_id', 'Enter Serial Id', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1668, '1NLL-qc6ihX1n-ZOPQ', 'al', 'enter_url', 'Enter url', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1669, '6vrF-RW4LBITB-cx3C', 'al', 'manage_menu', 'Manage Menu', '2023-08-03 12:33:26', '2023-08-03 12:33:26'),
(1670, 'cKBq-8ZXHl4fh-Zzb8', 'al', 'menu_not_found', 'Menu Not Found', '2023-08-03 12:33:34', '2023-08-03 12:33:34'),
(1671, '7Ekj-MtN5fyUq-qZZ1', 'al', 'menu_deleted', 'Menu Deleted!!', '2023-08-03 12:33:34', '2023-08-03 12:33:34'),
(1672, '60YY-0ns6H4N9-IZRN', 'al', 'update_menu', 'Update Menu', '2023-08-03 12:33:44', '2023-08-03 12:33:44'),
(1673, '5jwt-EeHkLAlj-dTG2', 'al', 'edit_menu', 'Edit Menu', '2023-08-03 12:33:44', '2023-08-03 12:33:44'),
(1674, '2Hfp-CehoQI1I-2FbX', 'al', 'edit', 'Edit', '2023-08-03 12:33:44', '2023-08-03 12:33:44'),
(1675, '4qhK-Qd1pLcjS-jORz', 'en', 'menu_not_found', 'Menu Not Found', '2023-08-03 12:35:08', '2023-08-03 12:35:08'),
(1676, 'ddR6-fv0vN3wG-DR77', 'en', 'menu_deleted', 'Menu Deleted!!', '2023-08-03 12:35:08', '2023-08-03 12:35:08'),
(1677, '4kvj-i6Bj47i8-RlIl', 'en', 'experiment_has_just_commented_on_an_article', 'Experiment has just commented on an article', '2023-08-03 12:38:51', '2023-08-03 12:38:51'),
(1678, '4qeR-GScUM6q6-WkDH', 'en', 'your_comment_is_under_review_thank_you_for_your_contribution', 'Your comment is under review. Thank you for your contribution!', '2023-08-03 12:38:51', '2023-08-03 12:38:51'),
(1679, '76cb-Ounf7Loe-qzYU', 'en', 'seo_settings_updated', 'Seo Settings Updated', '2023-08-03 12:49:59', '2023-08-03 12:49:59'),
(1680, '1Sd2-5DGLLVz7-H4Yi', 'en', 'users_panel', 'Users Panel', '2023-08-03 12:54:53', '2023-08-03 12:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `uid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `o_auth_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_settings` longtext COLLATE utf8mb4_unicode_ci,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'Active : 1,Deactive : 0',
  `custom_data` longtext COLLATE utf8mb4_unicode_ci,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created_by`, `updated_by`, `uid`, `o_auth_id`, `name`, `user_name`, `country_code`, `phone`, `email`, `notification_settings`, `address`, `email_verified_at`, `status`, `custom_data`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'OtzD-OLjaTl26-Tvp6', '3423663367918287', 'Nafiz Khan', 'Nafiz Khan', NULL, '01616243666', 'nafiz0khan1@gmail.com', NULL, NULL, '2023-08-03 12:13:54', '1', NULL, '$2y$10$o/8penk/2Imd9Q/j3Wo6fOB5G6jdcZLKOM.f./kIEGtLFxsRCyEAS', NULL, '2023-07-11 10:18:06', '2023-08-03 12:13:54'),
(26, NULL, 1, '4Y3Y-Ib7QqHs9-VeWw', NULL, 'demo_user@gmail.com', 'demo_user', '+880', '8801616243666', 'demo_user@gmail.com', NULL, '', '2023-07-04 11:23:59', '1', '{\"name\":\"jifa@mailinator.com\",\"email\":\"jifa@mailinator.com\",\"user_name\":\"gizowinu\",\"country_code\":\"+500\",\"phone\":\"+500\",\"password\":\"jifa@mailinator.com\",\"password_confirmation\":\"jifa@mailinator.com\"}', '$2y$10$LAnsY5b6XJtKX13o/M3YMOGu1kHB/1ClREd8JZnIysjC3diwnXN0W', NULL, '2023-07-13 04:42:32', '2023-07-15 10:03:35'),
(27, NULL, 1, '7wrB-nqCiajTQ-vEwk', NULL, 'Xavier Peck', 'cuvepez', '', '+1 (984) 905-4831', 'cicikiqof@mailinator.com', NULL, '', '2023-08-02 12:03:14', '1', '{\"name\":\"Xavier Peck\",\"email\":\"cicikiqof@mailinator.com\",\"user_name\":\"cuvepez\",\"phone\":\"+1 (984) 905-4831\",\"password\":\"Pa$$w0rd!\",\"password_confirmation\":\"Pa$$w0rd!\"}', '$2y$10$/rQ4M5EgIWNjkd0uTH8m.O0TGmhbstANmbmJl5pnUjlFoZX1wXXb.', NULL, '2023-07-13 11:00:13', '2023-08-02 12:03:14'),
(28, 1, 1, 'dovE-6h2nc5LL-K2B9', NULL, 'Reese Tatexxxxx', 'gusyxic', NULL, '+1 (984) 342-5101', 'zehi@mailinator.com', NULL, 'Recusandae Autem vexxxx', '2023-07-12 11:24:16', '1', NULL, '$2y$10$pP6N6yRBgR9ITQR8g/IaVOc5hQArca8HRDDnkWyVo2OpwXum51VVe', NULL, '2023-07-15 10:02:58', '2023-07-15 10:10:00'),
(30, NULL, NULL, '8tuO-pjLb3VMH-UROZ', NULL, 'Venus Craft', 'wedutyfi', '', '+1 (266) 563-4309', 'pytojaj@mailinator.com', NULL, '', '2023-07-23 12:01:05', '1', '{\"name\":\"Venus Craft\",\"email\":\"pytojaj@mailinator.com\",\"user_name\":\"wedutyfi\",\"phone\":\"+1 (266) 563-4309\",\"password\":\"Pa$$w0rd!\",\"password_confirmation\":\"Pa$$w0rd!\"}', '$2y$10$fnFf/zcTXYhoHCdeVq0u5ORLttvPtjc/ifyapsIaFbV1vBmTe2BhG', NULL, '2023-07-23 11:56:12', '2023-07-23 12:01:05'),
(31, NULL, NULL, '0Y4V-IcSbeAd0-vbfW', NULL, 'Graham Walker', 'dusupan', '', '+1 (827) 847-4589', 'jywoly@mailinator.com', NULL, '', NULL, '1', '{\"name\":\"Graham Walker\",\"email\":\"jywoly@mailinator.com\",\"user_name\":\"dusupan\",\"phone\":\"+1 (827) 847-4589\",\"password\":\"Pa$$w0rd!\",\"password_confirmation\":\"Pa$$w0rd!\"}', '$2y$10$UKIesCP3Pn9hfTwCZzW8w.jvHEGimccUprydV.nhZJFz/oZEKsFUy', NULL, '2023-07-23 12:32:04', '2023-07-23 12:32:04'),
(33, 1, NULL, '5umt-a6d6gQZO-ZsJW', NULL, 'Nathaniel Briggs', 'vaxizuj', NULL, '+1 (646) 118-5123', 'kavu@mailinator.com', NULL, 'Fugiat laboris recus', NULL, '1', NULL, NULL, NULL, '2023-07-26 05:57:48', '2023-07-26 05:57:48'),
(34, 1, NULL, '9uyF-p8sf2vUM-pTCW', NULL, 'Winter Bond', 'fyral', NULL, '+1 (956) 617-9845', 'pavynuse@mailinator.com', NULL, 'Sed natus aliquam do', '2023-08-03 12:07:02', '1', NULL, NULL, NULL, '2023-07-26 05:58:33', '2023-08-03 12:07:02'),
(36, 1, NULL, '9kPY-inIyyG0h-6df4', NULL, NULL, 'adminsafasfasfasf', NULL, 'sadsad', 'xczvzdv', NULL, 'asfasfsaf', NULL, '1', NULL, NULL, NULL, '2023-08-03 08:59:39', '2023-08-03 08:59:39'),
(37, 1, NULL, 'WTgL-Jjo8pNtG-0fA8', NULL, 'Experiment', 'Experiment User', NULL, '1645', 'experiment@gmail.com', NULL, 'asfffascsf', '2023-08-03 12:14:52', '1', NULL, NULL, NULL, '2023-08-03 12:08:01', '2023-08-03 12:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_blocked` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Yes : 1,No : 0',
  `agent_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `updated_by`, `ip_address`, `is_blocked`, `agent_info`, `created_at`, `updated_at`) VALUES
(27, 1, '::1', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"::1\",\"time\":\"03-08-2023 06:41:55 PM\"}', '2023-07-20 13:31:29', '2023-08-03 12:41:55'),
(28, NULL, '127.0.0.1', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"127.0.0.1\",\"time\":\"21-07-2023 08:33:20 PM\"}', '2023-07-21 14:33:20', '2023-07-21 14:33:20'),
(30, NULL, '192.168.0.122', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.122\",\"time\":\"30-07-2023 06:32:32 PM\"}', '2023-07-30 12:32:32', '2023-07-30 12:32:32'),
(31, NULL, '192.168.0.117', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.117\",\"time\":\"01-08-2023 05:21:20 PM\"}', '2023-07-31 04:22:11', '2023-08-01 11:21:20'),
(32, NULL, '192.168.0.107', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Firefox\",\"ip\":\"192.168.0.107\",\"time\":\"01-08-2023 11:22:01 AM\"}', '2023-08-01 05:18:21', '2023-08-01 05:22:01'),
(33, NULL, '192.168.0.111', '0', '{\"country\":[],\"city\":[],\"area\":[],\"code\":[],\"long\":[],\"lat\":[],\"os_platform\":\"Windows 10\",\"browser\":\"Chrome\",\"ip\":\"192.168.0.111\",\"time\":\"03-08-2023 06:56:28 PM\"}', '2023-08-03 11:17:47', '2023-08-03 12:56:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_user_name_unique` (`user_name`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_uid_index` (`uid`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ads_position_unique` (`position`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_title_unique` (`title`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_uid_index` (`uid`);

--
-- Indexes for table `article_comments`
--
ALTER TABLE `article_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_uid_index` (`uid`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_name_unique` (`name`),
  ADD KEY `clients_uid_index` (`uid`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_uid_index` (`uid`);

--
-- Indexes for table `ctas`
--
ALTER TABLE `ctas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ctas_uid_index` (`uid`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_uid_index` (`uid`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `frontends_uid_index` (`uid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_imageable_type_imageable_id_index` (`imageable_type`,`imageable_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD KEY `languages_uid_index` (`uid`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `links_slug_unique` (`slug`),
  ADD KEY `links_uid_index` (`uid`);

--
-- Indexes for table `link_browsers`
--
ALTER TABLE `link_browsers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_reviews`
--
ALTER TABLE `link_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_reviews_uid_index` (`uid`);

--
-- Indexes for table `mail_gateways`
--
ALTER TABLE `mail_gateways`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mail_gateways_uid_index` (`uid`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_uid_index` (`uid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_uid_index` (`uid`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otps_otpable_type_otpable_id_index` (`otpable_type`,`otpable_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_title_unique` (`title`),
  ADD KEY `packages_uid_index` (`uid`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_uid_index` (`uid`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_name_unique` (`name`),
  ADD UNIQUE KEY `payment_methods_code_unique` (`code`),
  ADD KEY `payment_methods_uid_index` (`uid`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD KEY `roles_uid_index` (`uid`);

--
-- Indexes for table `seos`
--
ALTER TABLE `seos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seos_uid_index` (`uid`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_uid_index` (`uid`);

--
-- Indexes for table `sms_gateways`
--
ALTER TABLE `sms_gateways`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_gateways_uid_index` (`uid`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscribers_uid_index` (`uid`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `templates_uid_index` (`uid`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_uid_index` (`uid`),
  ADD KEY `tickets_ticket_number_index` (`ticket_number`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_uid_index` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_user_name_unique` (`user_name`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_uid_index` (`uid`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `article_comments`
--
ALTER TABLE `article_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ctas`
--
ALTER TABLE `ctas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `link_browsers`
--
ALTER TABLE `link_browsers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `link_reviews`
--
ALTER TABLE `link_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mail_gateways`
--
ALTER TABLE `mail_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seos`
--
ALTER TABLE `seos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `sms_gateways`
--
ALTER TABLE `sms_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1681;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
