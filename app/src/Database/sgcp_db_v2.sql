-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-07-2023 a las 04:59:44
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
-- Estructura de tabla para la tabla `appointment`
--

CREATE TABLE `appointment` (
  `id_appointment` int(11) NOT NULL,
  `doctor` int(11) NOT NULL,
  `patient` int(11) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `description` varchar(45) DEFAULT '-',
  `photo` varchar(100) NOT NULL DEFAULT 'default_photo.ico',
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `appointment`
--

INSERT INTO `appointment` (`id_appointment`, `doctor`, `patient`, `date`, `hour`, `description`, `photo`, `status`) VALUES
(25, 3, 1, '2023-07-06', '08:00:00', '', 'img_ce759a1d9fde084e6455472a866685ac.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar`
--

CREATE TABLE `calendar` (
  `id_calendar` int(11) NOT NULL,
  `doctor` int(11) NOT NULL,
  `week_number` varchar(20) NOT NULL,
  `week_range` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `final_time` time NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `calendar`
--

INSERT INTO `calendar` (`id_calendar`, `doctor`, `week_number`, `week_range`, `date`, `start_time`, `final_time`, `status`) VALUES
(6, 3, 'Week 26 year 2023', '2023-06-26 - 2023-07-02', '2023-06-26', '10:00:00', '12:00:00', 1),
(7, 3, 'Week 25 year 2023', '2023-06-19 - 2023-06-25', '2023-06-21', '10:00:00', '12:00:00', 1),
(8, 3, 'Week 25 year 2023', '2023-06-19 - 2023-06-25', '2023-06-22', '10:00:00', '12:00:00', 1),
(9, 3, 'Week 25 year 2023', '2023-06-19 - 2023-06-25', '2023-06-22', '13:00:00', '18:00:00', 1),
(10, 3, 'Week 25 year 2023', '2023-06-19 - 2023-06-25', '2023-06-23', '13:00:00', '18:00:00', 1),
(11, 3, 'Week 26 year 2023', '2023-06-26 - 2023-07-02', '2023-06-27', '08:30:00', '12:00:00', 2),
(12, 3, 'Week 27 year 2023', '2023-07-03 - 2023-07-09', '2023-07-03', '08:30:00', '12:00:00', 1),
(13, 3, 'Week 27 year 2023', '2023-07-03 - 2023-07-09', '2023-07-04', '08:30:00', '12:00:00', 1),
(14, 3, 'Week 27 year 2023', '2023-07-03 - 2023-07-09', '2023-07-04', '13:30:00', '18:00:00', 1),
(15, 3, 'Week 27 year 2023', '2023-07-03 - 2023-07-09', '2023-07-05', '08:00:00', '10:00:00', 1),
(16, 3, 'Week 27 year 2023', '2023-07-03 - 2023-07-09', '2023-07-06', '08:00:00', '10:00:00', 1),
(17, 3, 'Week 27 year 2023', '2023-07-03 - 2023-07-09', '2023-07-07', '08:00:00', '10:00:00', 1),
(19, 3, 'Week 27 year 2023', '2023-07-03 - 2023-07-09', '2023-07-07', '13:00:00', '18:00:00', 1),
(20, 5, 'Week 25 year 2023', '2023-06-19 - 2023-06-25', '2023-06-24', '08:30:00', '12:00:00', 1),
(21, 5, 'Week 25 year 2023', '2023-06-19 - 2023-06-25', '2023-06-24', '13:30:00', '17:30:00', 2),
(22, 3, 'Week 26 year 2023', '2023-06-26 - 2023-07-02', '2023-06-27', '08:00:00', '12:00:00', 0),
(23, 3, 'Week 22 year 2023', '2023-05-29 - 2023-06-04', '2023-06-02', '08:00:00', '12:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `id_doctor` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `specialty` varchar(45) NOT NULL,
  `cell_phone` varchar(10) NOT NULL,
  `home_address` varchar(25) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`id_doctor`, `user`, `specialty`, `cell_phone`, `home_address`, `status`) VALUES
(3, 20, 'Neonatologo', '0988552212', 'Portoviejo', 1),
(4, 21, 'Pediatra', '096521546', 'Portoviejo', 0),
(5, 22, 'Pediatra', '0985642257', 'Portoviejo', 1),
(6, 23, 'Pediatra', '0985465421', 'Jipijapa', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicalcontrol`
--

CREATE TABLE `medicalcontrol` (
  `id_medicalcontrol` int(11) NOT NULL,
  `appointment` int(11) NOT NULL,
  `recipe` int(11) NOT NULL,
  `age_days` int(11) NOT NULL,
  `weight_kg` decimal(5,2) NOT NULL,
  `weight_pounds` decimal(5,2) NOT NULL,
  `height_cm` decimal(5,2) NOT NULL,
  `bmi_quant` decimal(5,2) NOT NULL,
  `bmi_quali` varchar(15) NOT NULL,
  `temperature` decimal(5,2) DEFAULT NULL,
  `observation` varchar(100) DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(2, 'Área personal', 'Personal area', 1),
(3, 'Usuarios', 'Users', 1),
(4, 'Roles', 'Roles', 1),
(5, 'Pacientes', 'Patients', 1),
(6, 'Control pacientes', 'Control patients', 1),
(7, 'Familiares', 'Familiares', 1),
(8, 'Doctores', 'Doctores', 1),
(9, 'Horarios', 'Horarios de atención ', 1),
(10, 'Citas', 'Agenda-miento de citas', 1),
(11, 'Notificaciones', 'Notificaciones', 1),
(12, 'Consultorio', 'Consultorio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification`
--

CREATE TABLE `notification` (
  `id_notification` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `notification`
--

INSERT INTO `notification` (`id_notification`, `type`, `description`, `status`) VALUES
(13, 'Pre-cita', 'Solicitud de cita para control médico', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification_details`
--

CREATE TABLE `notification_details` (
  `id_notification_details` int(11) NOT NULL,
  `sending_user` int(11) NOT NULL,
  `recipient_user` int(11) NOT NULL,
  `notification` int(11) NOT NULL,
  `appointment` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `notification_details`
--

INSERT INTO `notification_details` (`id_notification_details`, `sending_user`, `recipient_user`, `notification`, `appointment`, `date`) VALUES
(7, 17, 8, 13, 25, '2023-07-06 00:53:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parents`
--

CREATE TABLE `parents` (
  `id_parents` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `father_name` varchar(25) NOT NULL,
  `father_lastname` varchar(25) NOT NULL,
  `mother_name` varchar(25) NOT NULL,
  `mother_lastname` varchar(25) NOT NULL,
  `home_phone` varchar(10) NOT NULL,
  `cell_phone` varchar(10) NOT NULL,
  `home_address` varchar(25) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `parents`
--

INSERT INTO `parents` (`id_parents`, `user`, `father_name`, `father_lastname`, `mother_name`, `mother_lastname`, `home_phone`, `cell_phone`, `home_address`, `status`) VALUES
(1, 17, 'Jose Manuel', 'Vera', 'Fernanda Maria', 'Moreira', '5235852', '0956231578', 'Portoviejo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patient`
--

CREATE TABLE `patient` (
  `id_patient` int(11) NOT NULL,
  `parents` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(1) NOT NULL,
  `weight` double(5,2) NOT NULL,
  `height` double(5,2) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `family_obs` varchar(25) NOT NULL,
  `personal_obs` varchar(25) NOT NULL,
  `general_obs` varchar(25) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `patient`
--

INSERT INTO `patient` (`id_patient`, `parents`, `dni`, `name`, `lastname`, `birthdate`, `sex`, `weight`, `height`, `blood_type`, `family_obs`, `personal_obs`, `general_obs`, `reg_date`, `status`) VALUES
(1, 1, '1314521254', 'Miguel Jose', 'Vera Moreira', '2023-02-02', 'M', 0.00, 0.00, 'O+', 'Ninguno', 'Ninguno', 'Ninguno', '2023-05-29 16:45:12', 1),
(2, 1, '1314652496', 'Rosa Flor', 'Vera Moreira', '2023-06-08', 'F', 0.00, 0.00, 'O+', '', '', '', '2023-07-04 01:19:32', 1);

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
(237, 2, 1, 1, 1, 1, 1),
(238, 2, 2, 1, 1, 1, 1),
(239, 2, 3, 1, 1, 1, 1),
(240, 2, 4, 0, 0, 0, 0),
(241, 2, 5, 0, 0, 0, 0),
(242, 2, 6, 0, 0, 0, 0),
(472, 4, 1, 0, 0, 0, 0),
(473, 4, 2, 1, 0, 0, 0),
(474, 4, 3, 0, 0, 0, 0),
(475, 4, 4, 0, 0, 0, 0),
(476, 4, 5, 0, 0, 0, 0),
(477, 4, 6, 0, 0, 0, 0),
(478, 4, 7, 0, 0, 0, 0),
(479, 4, 8, 0, 0, 0, 0),
(480, 4, 9, 1, 1, 1, 1),
(481, 4, 10, 0, 0, 0, 0),
(482, 4, 11, 0, 0, 0, 0),
(527, 1, 1, 1, 1, 1, 1),
(528, 1, 2, 1, 1, 1, 1),
(529, 1, 3, 1, 1, 1, 1),
(530, 1, 4, 1, 1, 1, 1),
(531, 1, 5, 1, 1, 1, 1),
(532, 1, 6, 1, 1, 1, 1),
(533, 1, 7, 1, 1, 1, 1),
(534, 1, 8, 1, 1, 1, 1),
(535, 1, 9, 1, 1, 1, 1),
(536, 1, 10, 1, 1, 1, 1),
(537, 1, 11, 1, 1, 1, 1),
(538, 1, 12, 1, 1, 1, 1),
(539, 5, 1, 0, 0, 0, 0),
(540, 5, 2, 1, 0, 0, 0),
(541, 5, 3, 0, 0, 0, 0),
(542, 5, 4, 0, 0, 0, 0),
(543, 5, 5, 0, 0, 0, 0),
(544, 5, 6, 0, 0, 0, 0),
(545, 5, 7, 0, 0, 0, 0),
(546, 5, 8, 0, 0, 0, 0),
(547, 5, 9, 0, 0, 0, 0),
(548, 5, 10, 0, 0, 0, 0),
(549, 5, 11, 0, 0, 0, 0),
(550, 5, 12, 1, 1, 1, 1),
(551, 3, 1, 1, 0, 0, 0),
(552, 3, 2, 0, 0, 0, 0),
(553, 3, 3, 0, 0, 0, 0),
(554, 3, 4, 0, 0, 0, 0),
(555, 3, 5, 0, 0, 0, 0),
(556, 3, 6, 0, 0, 0, 0),
(557, 3, 7, 0, 0, 0, 0),
(558, 3, 8, 0, 0, 0, 0),
(559, 3, 9, 0, 0, 0, 0),
(560, 3, 10, 0, 0, 0, 0),
(561, 3, 11, 1, 1, 1, 1),
(562, 3, 12, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recipe`
--

CREATE TABLE `recipe` (
  `id_recipe` int(11) NOT NULL,
  `medication` varchar(300) NOT NULL,
  `indication` varchar(300) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(3, 'Secretaria', 'Secretaria', 1),
(4, 'Doctor/a', 'Doctor/a', 1),
(5, 'Representante', 'Representante legal de pacientes', 1),
(42, 'cajero', 'aswq', 0),
(44, 'cajeroassda', 'asdasd', 0),
(45, 'Super As', 'AS', 0),
(46, 'cajero', 'asasas', 0),
(47, 'cajeroadsda', 'asdasd', 0);

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
(1, 'JH', 'Admin', 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'admin@info.com', '', 1),
(8, 'Cristian', 'Bravo', 'cbravo2023', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'bravo@gmail.com', NULL, 1),
(12, 'Jose Manuel', 'Zambrano', 'jzambrano2023', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'josezam1@gmail.com', '', 1),
(13, 'Maria', 'Veles', 'mveles2023', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'josx0921@gmail.com', NULL, 0),
(17, 'Fernanda Maria', 'Moreira Gutierrez', 'fmoreira2023', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'joma@gmail.com', NULL, 1),
(20, 'Jhonny', 'Hidalgo', 'jhidalgo2023', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'hidalgo@gmail.com', NULL, 1),
(21, 'Mirian', 'Perez', 'mperez2023', '11a4ff66d6fb6ac10c3f0c037ffa637e517aa15f711632b06f72dc15f76dc7a9', 'hida@gmail.com', NULL, 0),
(22, 'Gisella', 'Zambrano', 'gzambrano2023', 'e5b07bfb4512d3d768442f8410f85801e2b91cca5dab038a6c4e488c510dd11c', 'gisella@gmail.com', NULL, 1),
(23, 'Leonela Maria', 'Bravo', 'lbravo2023', '60550b607444f324b0f9db2e36b6e88bc957643dc005af3741a45d038a009024', 'leo@gmail.com', NULL, 1);

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
(200, 13, 1, 0),
(201, 13, 2, 0),
(202, 13, 3, 0),
(203, 13, 4, 1),
(240, 20, 1, 0),
(241, 20, 2, 0),
(242, 20, 3, 0),
(243, 20, 4, 1),
(244, 21, 1, 0),
(245, 21, 2, 0),
(246, 21, 3, 0),
(247, 21, 4, 1),
(248, 12, 1, 0),
(249, 12, 2, 0),
(250, 12, 3, 0),
(251, 12, 4, 0),
(252, 12, 5, 1),
(253, 22, 1, 0),
(254, 22, 2, 0),
(255, 22, 3, 0),
(256, 22, 4, 1),
(257, 22, 5, 0),
(258, 23, 1, 0),
(259, 23, 2, 0),
(260, 23, 3, 0),
(261, 23, 4, 1),
(262, 23, 5, 0),
(283, 1, 1, 1),
(284, 1, 2, 0),
(285, 1, 3, 0),
(286, 1, 4, 0),
(287, 1, 5, 0),
(328, 8, 1, 0),
(329, 8, 2, 1),
(330, 8, 3, 1),
(331, 8, 4, 0),
(332, 8, 5, 0),
(333, 17, 1, 0),
(334, 17, 2, 0),
(335, 17, 3, 0),
(336, 17, 4, 0),
(337, 17, 5, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id_appointment`),
  ADD KEY `doctor` (`doctor`),
  ADD KEY `patient` (`patient`);

--
-- Indices de la tabla `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id_calendar`),
  ADD KEY `doctor` (`doctor`);

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id_doctor`),
  ADD KEY `user` (`user`);

--
-- Indices de la tabla `medicalcontrol`
--
ALTER TABLE `medicalcontrol`
  ADD PRIMARY KEY (`id_medicalcontrol`),
  ADD KEY `appointment` (`appointment`),
  ADD KEY `recipe` (`recipe`);

--
-- Indices de la tabla `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id_module`);

--
-- Indices de la tabla `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indices de la tabla `notification_details`
--
ALTER TABLE `notification_details`
  ADD PRIMARY KEY (`id_notification_details`),
  ADD KEY `sending_user` (`sending_user`),
  ADD KEY `recipient_user` (`recipient_user`),
  ADD KEY `notification` (`notification`),
  ADD KEY `appointment` (`appointment`);

--
-- Indices de la tabla `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id_parents`),
  ADD KEY `user` (`user`);

--
-- Indices de la tabla `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD KEY `parents` (`parents`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id_permissions`),
  ADD KEY `rol` (`rol`),
  ADD KEY `module` (`module`);

--
-- Indices de la tabla `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id_recipe`);

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
-- AUTO_INCREMENT de la tabla `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id_appointment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id_doctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `medicalcontrol`
--
ALTER TABLE `medicalcontrol`
  MODIFY `id_medicalcontrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `module`
--
ALTER TABLE `module`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `notification`
--
ALTER TABLE `notification`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `notification_details`
--
ALTER TABLE `notification_details`
  MODIFY `id_notification_details` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `parents`
--
ALTER TABLE `parents`
  MODIFY `id_parents` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `patient`
--
ALTER TABLE `patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id_permissions` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=563;

--
-- AUTO_INCREMENT de la tabla `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id_recipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id_user_roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`doctor`) REFERENCES `doctor` (`id_doctor`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`patient`) REFERENCES `patient` (`id_patient`);

--
-- Filtros para la tabla `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`doctor`) REFERENCES `doctor` (`id_doctor`);

--
-- Filtros para la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`);

--
-- Filtros para la tabla `medicalcontrol`
--
ALTER TABLE `medicalcontrol`
  ADD CONSTRAINT `medicalcontrol_ibfk_1` FOREIGN KEY (`appointment`) REFERENCES `appointment` (`id_appointment`),
  ADD CONSTRAINT `medicalcontrol_ibfk_2` FOREIGN KEY (`recipe`) REFERENCES `recipe` (`id_recipe`);

--
-- Filtros para la tabla `notification_details`
--
ALTER TABLE `notification_details`
  ADD CONSTRAINT `notification_details_ibfk_1` FOREIGN KEY (`sending_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `notification_details_ibfk_2` FOREIGN KEY (`recipient_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `notification_details_ibfk_3` FOREIGN KEY (`notification`) REFERENCES `notification` (`id_notification`),
  ADD CONSTRAINT `notification_details_ibfk_4` FOREIGN KEY (`appointment`) REFERENCES `appointment` (`id_appointment`);

--
-- Filtros para la tabla `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id_user`);

--
-- Filtros para la tabla `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`parents`) REFERENCES `parents` (`id_parents`);

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
