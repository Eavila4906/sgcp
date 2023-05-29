DROP TABLE IF EXISTS `parents`;
CREATE TABLE IF NOT EXISTS `parents` (
  `id_parents` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `father_name` varchar(25) NOT NULL,
  `father_latsname` varchar(25) NOT NULL,
  `mother_name` varchar(25) NOT NULL,
  `mother_latsname` varchar(25) NOT NULL,
  `home_phone` varchar(10) NOT NULL,
  `cell_phone` varchar(10) NOT NULL,
  `home_address` varchar(25) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_parents`),
  FOREIGN KEY (`user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id_patient` int(11) NOT NULL AUTO_INCREMENT,
  `parents` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(1) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `family_obs` varchar(25) NOT NULL,
  `personal_obs` varchar(25) NOT NULL,
  `general_obs` varchar(25) NOT NULL,
  `reg_date` timestamp default current_timestamp,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_patient`),
  FOREIGN KEY (`parents`) REFERENCES `parents` (`id_parents`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
