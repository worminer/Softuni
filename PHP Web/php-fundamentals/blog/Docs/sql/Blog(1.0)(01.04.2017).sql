/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` char(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` (`article_id`, `author_id`, `title`, `content`, `created_at`) VALUES
	(1, 2, 'Tesla Model S', '<h1 class="section-title section-title--hed">Performance and safety refined</h1>\r\n<p class="section-description section-description--dek">Model&nbsp;S is designed from the ground up to be the safest, most exhilarating sedan on the road. With unparalleled performance delivered through Tesla\'s unique, all-electric powertrain, Model&nbsp;S accelerates from 0 to 60 mph in as little as 2.5 seconds. Model&nbsp;S comes with Autopilot capabilities designed to make your highway driving not only safer, but stress&nbsp;free.</p>\r\n<div class="section--features">\r\n<div class="feature--adaptive-headlights">\r\n<h4 class="section-sub-title">Adaptive Lighting</h4>\r\n<p class="section-description">Model&nbsp;S now features full LED adaptive headlamps. Besides enhancing the already great styling, they also boost safety: 14 three-position LED dynamic turning lights improve visibility at night, especially on winding roads.</p>\r\n</div>\r\n<div class="feature--pollution-free">\r\n<h4 class="section-sub-title">Bio-Weapon Defense Mode</h4>\r\n<p class="section-description">Model&nbsp;S now features a Medical grade HEPA air filtration system, which removes at least 99.97% of particulate exhaust pollution and effectively all allergens, bacteria and other contaminants from cabin air. The bioweapon defense mode creates positive pressure inside the cabin to protect occupants</p>\r\n</div>\r\n</div>', '2017-03-18 14:42:12'),
	(2, 2, 'Tesla Model X', '<section id="autopilot-announcement" class="section-container banner-autopilot">\r\n<div class="container">\r\n<h1 class="section-title">Full Self-Driving Hardware on your Model&nbsp;</h1>\r\n<p class="section-description">All Tesla vehicles produced in our factory, including Model&nbsp;3,</p>\r\n<p class="section-description">have the hardware needed for full self-driving capability at a safety level substantially greater than that of a human driver.</p>\r\n<div class="btn-group"><a class="btn-secondary" title="Order your Model X now" href="https://www.tesla.com/modelx/design">ORDER NOW</a> <a class="btn-secondary" title="Learn more about Autopilot" href="https://www.tesla.com/autopilot">LEARN MORE</a></div>\r\n</div>\r\n</section>\r\n<section class="section-profile hide-on-mobile"></section>\r\n<section id="safety-first" class="section-safety">\r\n<div class="container">\r\n<div class="section-intro">\r\n<h1 class="section-title section-title--hed">Safety First Design</h1>\r\n</div>\r\n</div>\r\n</section>', '2017-03-18 14:43:13'),
	(4, 3, 'asdasd', '<p>asdasd</p>', '2017-03-18 15:10:54');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;

DROP TABLE IF EXISTS `article_categories`;
CREATE TABLE IF NOT EXISTS `article_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Article` (`article_id`),
  KEY `category` (`category_id`),
  CONSTRAINT `Article` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`),
  CONSTRAINT `category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `article_categories` DISABLE KEYS */;
INSERT INTO `article_categories` (`id`, `article_id`, `category_id`) VALUES
	(1, 1, 3),
	(2, 1, 4),
	(3, 2, 3),
	(4, 2, 4),
	(9, 4, 3);
/*!40000 ALTER TABLE `article_categories` ENABLE KEYS */;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`) VALUES
	(1, 'Movies'),
	(2, 'Games'),
	(3, 'Cars'),
	(4, 'Tesla');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `role_name`) VALUES
	(1, 'user'),
	(2, 'admin');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `sessid` varchar(32) NOT NULL,
  `sess_data` text NOT NULL,
  `valid_untill` int(11) NOT NULL,
  UNIQUE KEY `sessid` (`sessid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass_hash` varchar(75) NOT NULL,
  `pass_salt` varchar(60) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `session_token` varchar(255) DEFAULT NULL,
  `session_token_expire` int(11) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `real_name`, `email`, `pass_hash`, `pass_salt`, `creation_date`, `session_token`, `session_token_expire`, `profile_pic`) VALUES
	(2, 'worminer@gmail.com', 'Martin Dimitrov', 'worminer@gmail.com', '$2y$10$cba349b4e21e03c3baaafuzg9TsHqPZ6OK906Xgf43ffl3oS49h1u', 'cba349b4e21e03c3baaaf6aa9affabe6', '2017-03-18 14:37:41', 'b70021206f8e412fecbc034cac31d3cf642c33cf28c70a68b01dbc951d910d96', 1490920089, '/resources/images/users/profile_images/7243878c45b6821dfcfda436277bd6d5.png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `roles_id` (`role_id`),
  CONSTRAINT `roles_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
	(1, 2, 1),
	(2, 2, 2);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
