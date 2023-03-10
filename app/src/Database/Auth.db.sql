--
-- Estructura de tabla para la tabla `modulo`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id_module` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(25) NOT NULL,
  `description` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(25) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id_permissions` int NOT NULL AUTO_INCREMENT,
  `rol` int NOT NULL,
  `module` int NOT NULL,
  `r` int NOT NULL DEFAULT 0,
  `w` int NOT NULL DEFAULT 0,
  `u` int NOT NULL DEFAULT 0,
  `d` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_permissions`),
  FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`),
  FOREIGN KEY (`module`) REFERENCES `module` (`id_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(120) NOT NULL,
  `token` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id_user_roles` int(11) NOT NULL AUTO_INCREMENT,
  `user`int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  PRIMARY KEY (`id_user_roles`),
  FOREIGN KEY (`user`) REFERENCES `user` (`id_user`),
  FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;