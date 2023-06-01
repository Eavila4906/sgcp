DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `id_doctor` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `specialty` varchar(15) NOT NULL,
  `cell_phone` varchar(10) NOT NULL,
  `home_address` varchar(25) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_doctor`),
  FOREIGN KEY (`user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE IF NOT EXISTS `calendar` (
  `id_calendar` int(11) NOT NULL AUTO_INCREMENT,
  `doctor` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `final_time` time NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_calendar`),
  FOREIGN KEY (`doctor`) REFERENCES `doctor` (`id_doctor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

