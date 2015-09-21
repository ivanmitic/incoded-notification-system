SET foreign_key_checks = 0;

--
-- create table `user`
--
DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_type_id` int(10) unsigned NOT NULL,
    `username` varchar(50) NOT NULL,
    `password` varchar(50) NOT NULL,
    `is_active` int(4) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_u_m` (`username`),
    CONSTRAINT `fk_u_ut` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `user_type`
--
DROP TABLE IF EXISTS `user_type`;

CREATE TABLE `user_type` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_ut_n` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `post`
--
DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `title` varchar(50) NOT NULL,
    `body` text NOT NULL,
    `status` int(4) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_pu_u` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `post_comment`
--
DROP TABLE IF EXISTS `post_comment`;

CREATE TABLE `post_comment` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `post_id` int(10) unsigned NOT NULL,
    `body` varchar(50) NOT NULL,
    `is_published` int(4) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_puc_u` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_puc_p` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `entity_model`
--
DROP TABLE IF EXISTS `entity_model`;

CREATE TABLE `entity_model` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `code` varchar(255) NOT NULL,
    `model` varchar(255) NOT NULL,
    `type` enum('data', 'service') NOT NULL DEFAULT 'data',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_em_c` (`code`),
    UNIQUE KEY `uk_em_m` (`model`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `notification`
--
DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `entity_model_id` int(10) unsigned NOT NULL,
    `code` varchar(255) NOT NULL,
    `title` varchar(255) NULL DEFAULT NULL,
    `body` text NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_n_c` (`code`),
    CONSTRAINT `fk_n_em` FOREIGN KEY (`entity_model_id`) REFERENCES `entity_model` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `notification_service`
--
DROP TABLE IF EXISTS `notification_service`;

CREATE TABLE `notification_service` (
    `notification_id` int(10) unsigned NOT NULL,
    `entity_model_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`notification_id`, `entity_model_id`),
    CONSTRAINT `fk_ns_n` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_ns_em` FOREIGN KEY (`entity_model_id`) REFERENCES `entity_model` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `notification_user_type`
--
DROP TABLE IF EXISTS `notification_user_type`;

CREATE TABLE `notification_user_type` (
    `notification_id` int(10) unsigned NOT NULL,
    `user_type_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`notification_id`, `user_type_id`),
    CONSTRAINT `fk_nut_n` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_nut_ut` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `user_notification_service`
--
DROP TABLE IF EXISTS `user_notification_service`;

CREATE TABLE `user_notification_service` (
    `user_id` int(10) unsigned NOT NULL,
    `notification_id` int(10) unsigned NOT NULL,
    `entity_model_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`user_id`, `notification_id`, `entity_model_id`),
    CONSTRAINT `fk_uns_u` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_uns_n` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_uns_em` FOREIGN KEY (`entity_model_id`) REFERENCES `entity_model` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- create table `user_notification`
--
DROP TABLE IF EXISTS `user_notification`;

CREATE TABLE `user_notification` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(10) unsigned NOT NULL,
    `notification_id` int(10) unsigned NOT NULL,
    `entity_id` int(10) unsigned NOT NULL,
    `title` varchar(255) NULL DEFAULT NULL,
    `body` text NULL DEFAULT NULL,
    `is_read` int(4) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_un_u` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_un_n` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- test data
--

--
-- Truncate table before insert `entity_model`
--

TRUNCATE TABLE `entity_model`;
--
-- Dumping data for table `entity_model`
--

INSERT INTO `entity_model` (`id`, `code`, `model`, `type`, `created_at`, `updated_at`) VALUES(1, 'user', 'User', 'data', '2015-09-20 00:36:18', NULL);
INSERT INTO `entity_model` (`id`, `code`, `model`, `type`, `created_at`, `updated_at`) VALUES(2, 'post', 'Post', 'data', '2015-09-20 00:36:18', NULL);
INSERT INTO `entity_model` (`id`, `code`, `model`, `type`, `created_at`, `updated_at`) VALUES(3, 'post_comment', 'PostComment', 'data', '2015-09-20 00:36:18', NULL);
INSERT INTO `entity_model` (`id`, `code`, `model`, `type`, `created_at`, `updated_at`) VALUES(4, 'notification_email', 'EmailService', 'service', '2015-09-20 00:36:18', NULL);
INSERT INTO `entity_model` (`id`, `code`, `model`, `type`, `created_at`, `updated_at`) VALUES(5, 'notification_push', 'PushService', 'service', '2015-09-20 00:36:18', NULL);
INSERT INTO `entity_model` (`id`, `code`, `model`, `type`, `created_at`, `updated_at`) VALUES(6, 'notification_sms', 'SmsService', 'service', '2015-09-20 00:36:18', NULL);

--
-- Truncate table before insert `notification`
--

TRUNCATE TABLE `notification`;
--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `entity_model_id`, `code`, `title`, `body`, `created_at`, `updated_at`) VALUES(1, 2, 'post_created', 'New post has been created', 'Dear |user.username|,\r\n\r\nNew post "|post.title|" has been created.', '2015-09-19 22:25:52', NULL);
INSERT INTO `notification` (`id`, `entity_model_id`, `code`, `title`, `body`, `created_at`, `updated_at`) VALUES(2, 3, 'post_commented', 'New comment has been posted', 'Dear |user.username|,\r\n\r\nNew comment has been posted on your site on page “|post.title|”. Go to comments panel and moderate it.', '2015-09-19 22:25:52', NULL);

--
-- Truncate table before insert `notification_service`
--

TRUNCATE TABLE `notification_service`;
--
-- Dumping data for table `notification_service`
--

INSERT INTO `notification_service` (`notification_id`, `entity_model_id`) VALUES(1, 4);
INSERT INTO `notification_service` (`notification_id`, `entity_model_id`) VALUES(2, 4);
INSERT INTO `notification_service` (`notification_id`, `entity_model_id`) VALUES(1, 5);

--
-- Truncate table before insert `notification_user_type`
--

TRUNCATE TABLE `notification_user_type`;
--
-- Dumping data for table `notification_user_type`
--

INSERT INTO `notification_user_type` (`notification_id`, `user_type_id`) VALUES(1, 1);
INSERT INTO `notification_user_type` (`notification_id`, `user_type_id`) VALUES(1, 2);
INSERT INTO `notification_user_type` (`notification_id`, `user_type_id`) VALUES(2, 2);

--
-- Truncate table before insert `post`
--

TRUNCATE TABLE `post`;
--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `body`, `status`, `created_at`, `updated_at`) VALUES(1, 2, 'This is a sample post', 'Lorem ipsum dolor sit amet.', 1, '2015-09-21 11:08:51', NULL);

--
-- Truncate table before insert `post_comment`
--

TRUNCATE TABLE `post_comment`;
--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type_id`, `username`, `password`, `is_active`, `created_at`, `updated_at`) VALUES(1, 1, 'admin@example.org', '21232f297a57a5a743894a0e4a801fc3', 1, '2015-09-19 02:12:38', NULL);
INSERT INTO `user` (`id`, `user_type_id`, `username`, `password`, `is_active`, `created_at`, `updated_at`) VALUES(2, 2, 'member@example.org', 'aa08769cdcb26674c6706093503ff0a3', 1, '2015-09-19 02:12:38', NULL);

--
-- Truncate table before insert `user_notification`
--

TRUNCATE TABLE `user_notification`;
--
-- Truncate table before insert `user_notification_service`
--

TRUNCATE TABLE `user_notification_service`;
--
-- Dumping data for table `user_notification_service`
--

INSERT INTO `user_notification_service` (`user_id`, `notification_id`, `entity_model_id`) VALUES(1, 1, 4);
INSERT INTO `user_notification_service` (`user_id`, `notification_id`, `entity_model_id`) VALUES(1, 1, 5);
INSERT INTO `user_notification_service` (`user_id`, `notification_id`, `entity_model_id`) VALUES(1, 1, 6);

--
-- Truncate table before insert `user_type`
--

TRUNCATE TABLE `user_type`;
--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`, `created_at`, `updated_at`) VALUES(1, 'admin', '2015-09-20 00:36:18', NULL);
INSERT INTO `user_type` (`id`, `name`, `created_at`, `updated_at`) VALUES(2, 'member', '2015-09-20 00:36:18', NULL);

SET foreign_key_checks = 1;
