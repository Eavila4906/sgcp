DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_notification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `details_notification`;
CREATE TABLE `details_notification` (
  `id_details_notification` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `notification` int(11) NOT NULL,
  `date` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id_details_notification`),
  FOREIGN KEY (`user`) REFERENCES `user` (`id_user`),
  FOREIGN KEY (`notification`) REFERENCES `notification` (`id_notification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;