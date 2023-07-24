DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id_notification` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_notification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `notification_details`;
CREATE TABLE `notification_details` (
  `id_notification_details` int(11) NOT NULL AUTO_INCREMENT,
  `sending_user` int(11) NOT NULL,
  `recipient_user` int(11) NOT NULL,
  `notification` int(11) NOT NULL,
  `appointment` int(11) NOT NULL,
  `date` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id_notification_details`),
  FOREIGN KEY (`sending_user`) REFERENCES `user` (`id_user`),
  FOREIGN KEY (`recipient_user`) REFERENCES `user` (`id_user`),
  FOREIGN KEY (`notification`) REFERENCES `notification` (`id_notification`),
  FOREIGN KEY (`appointment`) REFERENCES `appointment` (`id_appointment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;