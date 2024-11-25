-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-09-2024 a las 03:48:58
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sgpi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos_integradores`
--

DROP TABLE IF EXISTS `proyectos_integradores`;
CREATE TABLE IF NOT EXISTS `proyectos_integradores` (
  `id_proyecto` int NOT NULL AUTO_INCREMENT,
  `codigo_sis` varchar(20) NOT NULL,
  `nombre_proyecto` varchar(255) NOT NULL,
  `descripcion` text,
  `palabras_clave` varchar(255) DEFAULT NULL,
  `area_enfoque` varchar(100) DEFAULT NULL,
  `integrador` enum('I','II','III','Final') NOT NULL,
  `estado` enum('aprobado','propuesto','rechazado','cancelado','en_progreso') NOT NULL,
  `semestre` enum('1','2','3','4','5','6','7','8','9') NOT NULL,
  `sede` enum('CBBA','La Paz','El Alto','Santa Cruz') NOT NULL,
  `documento_proyecto` varchar(255) DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_proyecto`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proyectos_integradores`
--

INSERT INTO `proyectos_integradores` (`id_proyecto`, `codigo_sis`, `nombre_proyecto`, `descripcion`, `palabras_clave`, `area_enfoque`, `integrador`, `estado`, `semestre`, `sede`, `documento_proyecto`, `id_usuario`) VALUES
(1, 'SIS1355244', 'Telemedicina', 'xxxx xxxx', 'salud, ia', 'Salud', 'I', 'aprobado', '5', 'CBBA', '', NULL),
(2, 'SIS1324565', 'Chapes', 'nnnnnnnnn', 'peces, automatización', 'IOT', 'II', 'rechazado', '6', 'La Paz', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `tipo_usuario` enum('administrativo','estudiante') DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `contrasena`, `tipo_usuario`) VALUES
(3, 'Carola', 'carolagarcia@gmail.com', '$2y$10$Cc/mDDEY/wTVtCwpT5uP7.ckuVWbHN3aNg1JoxXQDDx.lJ2/jDaAe', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
