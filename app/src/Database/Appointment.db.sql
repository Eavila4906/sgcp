DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `id_appointment` int(11) NOT NULL AUTO_INCREMENT,
  `doctor` int(11) NOT NULL,
  `patient` int(11) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `description` varchar(45) DEFAULT '-',
  `photo` varchar(100) DEFAULT 'default-photo.ico',
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_appointment`),
  FOREIGN KEY (`doctor`) REFERENCES `doctor` (`id_doctor`),
  FOREIGN KEY (`patient`) REFERENCES `patient` (`id_patient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;