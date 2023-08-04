DROP TABLE IF EXISTS `recipe`;
CREATE TABLE IF NOT EXISTS `recipe` (
  `id_recipe` int(11) NOT NULL AUTO_INCREMENT,
  `medication` text NOT NULL,
  `indication` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_recipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `medicalcontrol`;
CREATE TABLE IF NOT EXISTS `medicalcontrol` (
  `id_medicalcontrol` int(11) NOT NULL AUTO_INCREMENT,
  `appointment` int(11) NOT NULL,
  `recipe` int(11) NOT NULL,
  `months_age` int(11) NOT NULL,
  `weight_kg` decimal(5, 2) NOT NULL,
  `weight_pounds` decimal(5, 2) NOT NULL,
  `height_cm` decimal(5, 2) NOT NULL,
  `bmi_quant` decimal(5, 2) NOT NULL,
  `bmi_quali` varchar(15) NOT NULL,
  `temperature` decimal(5, 2) DEFAULT NULL,
  `observation` varchar(100) DEFAULT '-',
  PRIMARY KEY (`id_medicalcontrol`),
  FOREIGN KEY (`appointment`) REFERENCES `appointment` (`id_appointment`),
  FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id_recipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;