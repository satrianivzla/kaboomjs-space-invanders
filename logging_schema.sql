--
-- Table structure for table `audit_log`
--
CREATE TABLE `audit_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `details` text,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `visitor_stats`
--
CREATE TABLE `visitor_stats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address_hash` varchar(64) NOT NULL,
  `page_visited` varchar(255) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_visitor_page` (`ip_address_hash`,`page_visited`,`visit_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
