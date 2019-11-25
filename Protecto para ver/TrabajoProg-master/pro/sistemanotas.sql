-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 25, 2019 at 07:51 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemanotas`
--

-- --------------------------------------------------------

--
-- Table structure for table `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estados`
--

INSERT INTO `estados` (`id`, `estado`) VALUES
(1, 'Pendiente'),
(2, 'En Proceso'),
(3, 'Finalizada'),
(4, 'Cancelada');

-- --------------------------------------------------------

--
-- Table structure for table `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `texto` varchar(450) NOT NULL,
  `etiquetas` varchar(300) DEFAULT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_alarma` date DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `estados_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tareas`
--

INSERT INTO `tareas` (`id`, `texto`, `etiquetas`, `fecha_creacion`, `fecha_alarma`, `id_usuario`, `estados_id`) VALUES
(1, 'Salir a comer', 'Comida, Salida', '2019-10-25', '2019-10-29', 3, 1),
(3, 'TareaUno', 'a, c, d', '2019-10-25', NULL, 3, 1),
(4, 'TareaDos', 'a, b, c, d', '2019-10-25', NULL, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `mail` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ultimo_ingreso` date NOT NULL,
  `es_administrador` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `mail`, `clave`, `ultimo_ingreso`, `es_administrador`, `activo`) VALUES
(1, 'testuno', 'test1@test1.com', '$2y$10$QlraScWGfhVi/WcGhDyed.i9xqnzPk8hH2fmxdQhNexWf2FeIZO7.', '2019-10-25', 0, 1),
(2, 'TestDos', 'test2@test2.com', '$2y$10$GfLc4Cjo1BNJIPPF1CDzvu0SjFh4pPTZzrnPJno3u7FX8J0VqejGm', '2019-10-25', 0, 0),
(3, 'Admin', 'Admin@admin.com', '$2y$10$WRx42vP9zdbKqMIzQdHH9eE0JWtwoUPgzOCbDexpoOOFIUSuP5N1e', '2019-10-25', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `estados_id` (`estados_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`estados_id`) REFERENCES `estados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
