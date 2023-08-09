DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id_settings` int(11) NOT NULL AUTO_INCREMENT,
  `system_name` varchar(30) NOT NULL,
  `session_time` time NOT NULL,
  `generate_reports` varchar(3) NOT NULL,
  `scheduling_time` time NOT NULL,
  `generate_certificate` varchar(3) NOT NULL,
  `print_recipe` varchar(3) NOT NULL,
  PRIMARY KEY (`id_settings`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;