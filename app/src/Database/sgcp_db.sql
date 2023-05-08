-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-05-2023 a las 21:21:16
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sgcp_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module`
--

CREATE TABLE `module` (
  `id_module` int(11) NOT NULL,
  `module` varchar(25) NOT NULL,
  `description` varchar(150) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `module`
--

INSERT INTO `module` (`id_module`, `module`, `description`, `status`) VALUES
(1, 'Dashboard', 'Dashboard', 1),
(2, 'Personal area', 'Personal area', 1),
(3, 'Users', 'Users', 1),
(4, 'Roles', 'Roles', 1),
(5, 'Patients', 'Patients', 1),
(6, 'Control patients', 'Control patients', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id_permissions` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  `module` int(11) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id_permissions`, `rol`, `module`, `r`, `w`, `u`, `d`) VALUES
(98, 4, 1, 0, 0, 0, 0),
(99, 4, 2, 1, 0, 0, 0),
(102, 2, 1, 1, 1, 1, 1),
(103, 2, 2, 1, 1, 1, 1),
(104, 3, 1, 1, 0, 0, 0),
(105, 3, 2, 0, 0, 0, 0),
(231, 1, 1, 1, 1, 1, 1),
(232, 1, 2, 1, 1, 1, 1),
(233, 1, 3, 1, 1, 1, 1),
(234, 1, 4, 1, 1, 1, 1),
(235, 1, 5, 1, 1, 1, 1),
(236, 1, 6, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(25) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol`, `description`, `status`) VALUES
(1, 'Super admin', 'Super admin', 1),
(2, 'Administrator', 'Administrator', 1),
(3, 'Secretary', 'Secretary', 1),
(4, 'Patient', 'patient', 1),
(41, 'Caja', 'Caja', 0),
(42, 'cajero', 'aswq', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(120) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `name`, `lastname`, `username`, `password`, `email`, `token`, `status`) VALUES
(1, 'J', 'H', 'Admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'admin@info.com', '', 1),
(8, 'Cristian', 'Bravo', 'cbravo2023', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'bravo@gmail.com', NULL, 1),
(11, 'Jose Manuel', 'Zambrano', 'jzambrano2023', '76d83d856f8e6dd213fbc67769b9b35ed2ad592ae6913a0944029ca507499fe5', 'josezam0921@gmail.com', NULL, 0),
(12, 'Jose Manuel', 'Zambrano', 'jzambrano2023', 'a452ecd87e07567c1620ce4a6734aa56e60b3192b9740a57298a1d118ff57d8b', 'josezam1@gmail.com', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `id_user_roles` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_roles`
--

INSERT INTO `user_roles` (`id_user_roles`, `user`, `rol`, `status`) VALUES
(104, 1, 1, 1),
(105, 1, 2, 0),
(106, 1, 3, 0),
(107, 1, 4, 0),
(128, 11, 1, 0),
(129, 11, 2, 0),
(130, 11, 3, 0),
(131, 11, 4, 1),
(152, 12, 1, 0),
(153, 12, 2, 0),
(154, 12, 3, 0),
(155, 12, 4, 1),
(172, 8, 1, 0),
(173, 8, 2, 0),
(174, 8, 3, 0),
(175, 8, 4, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id_module`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id_permissions`),
  ADD KEY `rol` (`rol`),
  ADD KEY `module` (`module`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id_user_roles`),
  ADD KEY `user` (`user`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `module`
--
ALTER TABLE `module`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id_permissions` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id_user_roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`module`) REFERENCES `module` (`id_module`);

--
-- Filtros para la tabla `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
