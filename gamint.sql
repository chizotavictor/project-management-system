-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2021 at 03:25 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamint`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_04_20_150244_create_tasks_table', 2),
(5, '2021_04_21_080802_create_task_items_table', 3),
(6, '2021_04_21_120402_create_task_item_issues_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initiator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `designator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `start_date`, `delivery_date`, `initiator_id`, `designator_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Information We Collect Automatically from Our Services', '<p class=\"chakra-text css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\">When you access or use our Services, we automatically collect information about you as follows:</p><p><br class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"></p><p class=\"chakra-text css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\">Log Information: We log information about your use of our Services, including the type of browser you use, access times, pages viewed, your IP address and the page you visited before navigating to our Services.</p><p><br class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"></p><p class=\"chakra-text css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\">Device Information: We collect information about the computer or mobile device you use to access our Services, including the hardware model, operating system and version, unique device identifiers and mobile network information.</p><p><br class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"></p><p class=\"chakra-text css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\">Location Information: We may collect your location information from your mobile device with your prior consent. Also, we have incorporated Google Maps into our Services, and you may consent to the collection of location information by Google Maps in connection with your use of this maps’ service. Any information collected via your use of Google Maps will be transmitted directly to Google and is not collected by&nbsp;Us. Please refer to Google’s Privacy Policy for details about their collection, use and sharing of this information. If you initially consent to the collection of location information by Complete Farmer or Google Maps within our mobile application, you may be able to subsequently stop the collection of information through your device operating system settings or through your online account settings. If either of these opt-out options are not available to you, you may also disable location information by following the standard uninstall process to remove our mobile application from your device.</p>', '2021/21/04', '2021/28/04', 1, 3, 'In-Progress', '2021-04-21 16:33:14', '2021-04-22 22:41:25'),
(2, 'Protection of Personal Information', '<p class=\"chakra-text css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\">It collects Personal Information in a transparent way with the cooperation and knowledge of interested parties. Personal Information available to Us are protected in the following manner:</p><p class=\"chakra-text css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"><br></p><p class=\"chakra-text css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"><b>Our data is always:</b></p><ol role=\"list\" class=\"css-1dg6mvm\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; margin-inline-start: 1em; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"><li class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word;\">Accurate and kept up-to-date</li><li class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word;\">Collected fairly and for lawful purposes only</li><li class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word;\">Processed by Complete Farmer within its legal and moral boundaries</li><li class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word;\">Protected against any unauthorized or illegal access by internal or external parties</li></ol><p><br class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"></p><p class=\"chakra-text css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"><b>Our data will not be:</b></p><ol role=\"list\" class=\"css-1dg6mvm\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; margin-inline-start: 1em; color: rgb(26, 32, 44); font-family: CeraGR, sans-serif;\"><li class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word;\">Communicated informally</li><li class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word;\">Stored for more than a specified amount of time</li><li class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word;\">Transferred to organizations, states or countries that do not have adequate data protection policies</li><li class=\"css-0\" style=\"border-width: 0px; border-style: solid; border-color: var(--chakra-colors-gray-200); overflow-wrap: break-word;\">Distributed to any party other than the ones agreed upon by the data’s owner (exempting legitimate requests from law enforcement authorities) To protect our customers, only employees, agents and contractors who need your information to service your accounts have access to the information you provide Us. We also give you information that can help you keep your Personal Information safe.</li></ol>', '2021/03/05', '2021/07/05', 1, 3, 'In-Progress', '2021-04-21 16:35:08', '2021-04-22 22:57:15'),
(3, 'Design a Revenue Collection System for Benue Market Masters', '<p>A Robust &amp; Decentralized ERP System for revenue collection supervised by Benue State Goverment.</p>', '2021/03/05', '2021/31/05', 1, 3, 'Pending', '2021-04-22 18:08:28', '2021-04-22 18:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `task_items`
--

CREATE TABLE `task_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_indicator` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `designator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_items`
--

INSERT INTO `task_items` (`id`, `task_indicator`, `description`, `designator_id`, `task_id`, `status`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 'Login Page', '<p>Login page must accept:</p><ul><li>Email address</li><li>Password</li><li>Captcha</li></ul>', 3, 2, 'In-Progress', NULL, '2021-04-21 18:27:42', '2021-04-22 22:49:36'),
(2, 'Verification System', '<ol><li>Email &amp; Phone number verification System</li><li>2Factor Authentication System</li></ol>', 3, 2, 'Pending', NULL, '2021-04-22 07:53:54', '2021-04-22 07:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `task_item_issues`
--

CREATE TABLE `task_item_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_id` bigint(20) UNSIGNED DEFAULT NULL,
  `task_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `phone_number`, `github_link`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ebuka Chizota', 'chizotavictor@gmail.com', NULL, '$2y$10$YEj40lzIScPmGtjw0Inl1.B6Z.A2g35LVwGQSJ/.1usEisvYgUdqe', '1', NULL, NULL, NULL, '2021-04-20 14:00:21', '2021-04-20 14:00:21'),
(3, 'Ebuka Chizota', 'victorklozie@consultant.com', NULL, '$2y$10$sCMeT.CnnLPDMgcHflRIhuFYPYOUQBWguQ2GyG9BNb2jMEvbbX9B2', '0', '+2347041481364', NULL, NULL, '2021-04-21 06:19:51', '2021-04-21 06:19:51'),
(4, 'James Knoney', 'jameskonney@gmail.com', NULL, '$2y$10$w91JPf8xFS7dNFFSdoN3v.T3JZrgIBY1Ms5YrY5yOef9jwEt83hCG', '0', '+234810151766', NULL, NULL, '2021-04-22 17:30:50', '2021-04-22 17:30:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_initiator_id_foreign` (`initiator_id`),
  ADD KEY `tasks_designator_id_foreign` (`designator_id`);

--
-- Indexes for table `task_items`
--
ALTER TABLE `task_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_items_designator_id_foreign` (`designator_id`),
  ADD KEY `task_items_task_id_foreign` (`task_id`),
  ADD KEY `task_items_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `task_item_issues`
--
ALTER TABLE `task_item_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_item_issues_task_id_foreign` (`task_id`),
  ADD KEY `task_item_issues_task_item_id_foreign` (`task_item_id`),
  ADD KEY `task_item_issues_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `task_items`
--
ALTER TABLE `task_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task_item_issues`
--
ALTER TABLE `task_item_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_designator_id_foreign` FOREIGN KEY (`designator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_initiator_id_foreign` FOREIGN KEY (`initiator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `task_items`
--
ALTER TABLE `task_items`
  ADD CONSTRAINT `task_items_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `task_items_designator_id_foreign` FOREIGN KEY (`designator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `task_items_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

--
-- Constraints for table `task_item_issues`
--
ALTER TABLE `task_item_issues`
  ADD CONSTRAINT `task_item_issues_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `task_item_issues_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  ADD CONSTRAINT `task_item_issues_task_item_id_foreign` FOREIGN KEY (`task_item_id`) REFERENCES `task_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
