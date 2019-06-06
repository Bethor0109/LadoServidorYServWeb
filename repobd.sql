-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2019 a las 05:08:14
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repobd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE `contenido` (
  `id_contenido` int(11) NOT NULL,
  `url_archivo` varchar(254) NOT NULL,
  `add_fecha` date NOT NULL,
  `id_tipocontenido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`id_contenido`, `url_archivo`, `add_fecha`, `id_tipocontenido`) VALUES
(3, 'https://scontent.fmid2-1.fna.fbcdn.net/v/t1.0-9/62112403_1298411290307088_1724614911931187200_n.jpg?_nc_cat=104&_nc_ht=scontent.fmid2-1.fna&oh=4af223477453766e7c092eb2a7a1a6c0&oe=5D865A41', '2019-06-05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id_cuenta` int(11) NOT NULL,
  `correo` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id_cuenta`, `correo`, `password`, `id_usuario`, `estado`) VALUES
(1, 'german@gmail.com', '123', 1, 1),
(2, 'ita@gmail.com', '123', 6, 1),
(3, 'beto@gmail.com', '123', 7, 1),
(4, 'miguel@gmail.com', '123', 8, 1),
(5, 'jesus@gmail.com', '123', 9, 1),
(6, 'juan@gmail.com', '123', 10, 0),
(7, 'latina@gmail.com', '123', 11, 1),
(8, 'rodri@gmail.com', '123', 13, 1),
(9, 'root@root.access', 'rootaccess', 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositorio`
--

CREATE TABLE `repositorio` (
  `id_repositorio` int(11) NOT NULL,
  `id_cuenta` int(11) NOT NULL,
  `id_tiporepositorio` int(11) NOT NULL,
  `nombre_rep` varchar(30) NOT NULL,
  `fecha_ceacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `repositorio`
--

INSERT INTO `repositorio` (`id_repositorio`, `id_cuenta`, `id_tiporepositorio`, `nombre_rep`, `fecha_ceacion`) VALUES
(1, 9, 1, 'Entorno VR', '2019-05-31'),
(2, 1, 8, 'Sensor de temperatura', '2019-05-31'),
(3, 1, 4, 'Demo Efectos Visuales', '2019-05-31'),
(4, 2, 6, 'Ajedrez Interfaz', '2019-05-31'),
(5, 2, 8, 'Ajedrez Mecanico', '2019-05-31'),
(9, 9, 6, 'Repositorio de demostración', '2019-06-05'),
(10, 9, 4, '123123123', '2019-05-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositoriocontenido`
--

CREATE TABLE `repositoriocontenido` (
  `id_repositorio` int(11) NOT NULL,
  `id_contenido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `repositoriocontenido`
--

INSERT INTO `repositoriocontenido` (`id_repositorio`, `id_contenido`) VALUES
(2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontenido`
--

CREATE TABLE `tipocontenido` (
  `id_tipocontenido` int(11) NOT NULL,
  `categoria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipocontenido`
--

INSERT INTO `tipocontenido` (`id_tipocontenido`, `categoria`) VALUES
(1, 'Imagen'),
(2, 'Sonido'),
(3, 'Video'),
(4, 'Material'),
(5, 'Textura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiporepositorio`
--

CREATE TABLE `tiporepositorio` (
  `id_tiporepositorio` int(11) NOT NULL,
  `tipoproyecto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tiporepositorio`
--

INSERT INTO `tiporepositorio` (`id_tiporepositorio`, `tipoproyecto`) VALUES
(1, 'Realidad Virtual'),
(2, 'Realidad Aumentada'),
(3, 'Modelo 3D'),
(4, 'Shader'),
(5, 'Particulas'),
(6, 'Prefab'),
(7, 'UnityPackage'),
(8, 'Mecanica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `fecha_na` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `fecha_na`) VALUES
(1, 'German Alejandro', 'Pineda Uc', '2019-05-02'),
(6, 'Itandehui', 'Valdivieso', '1996-08-14'),
(7, 'Jose Roberto', 'Ramirez Marrufo', '2008-03-21'),
(8, 'Miguel Antonio', 'Cortes Arellano', '2017-07-20'),
(9, 'Jesus Alberto', 'Carrillo Angel', '2001-02-12'),
(10, 'Juan', 'Otako', '2019-05-03'),
(11, 'Lalatina', 'Courier', '2019-05-16'),
(13, 'Rodrigo', 'Cardenaz', '2019-05-31'),
(14, 'Root', 'Access', '0001-01-01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`id_contenido`),
  ADD KEY `fk_tipocontenido` (`id_tipocontenido`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id_cuenta`),
  ADD KEY `fk_usuario` (`id_usuario`);

--
-- Indices de la tabla `repositorio`
--
ALTER TABLE `repositorio`
  ADD PRIMARY KEY (`id_repositorio`),
  ADD KEY `fk_cuenta` (`id_cuenta`),
  ADD KEY `id_tiporepositorio` (`id_tiporepositorio`);

--
-- Indices de la tabla `repositoriocontenido`
--
ALTER TABLE `repositoriocontenido`
  ADD KEY `id_contenido` (`id_contenido`),
  ADD KEY `id_repositorio` (`id_repositorio`);

--
-- Indices de la tabla `tipocontenido`
--
ALTER TABLE `tipocontenido`
  ADD PRIMARY KEY (`id_tipocontenido`);

--
-- Indices de la tabla `tiporepositorio`
--
ALTER TABLE `tiporepositorio`
  ADD PRIMARY KEY (`id_tiporepositorio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contenido`
--
ALTER TABLE `contenido`
  MODIFY `id_contenido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `repositorio`
--
ALTER TABLE `repositorio`
  MODIFY `id_repositorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipocontenido`
--
ALTER TABLE `tipocontenido`
  MODIFY `id_tipocontenido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tiporepositorio`
--
ALTER TABLE `tiporepositorio`
  MODIFY `id_tiporepositorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD CONSTRAINT `fk_tipocontenido` FOREIGN KEY (`id_tipocontenido`) REFERENCES `tipocontenido` (`id_tipocontenido`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `repositorio`
--
ALTER TABLE `repositorio`
  ADD CONSTRAINT `fk_cuenta` FOREIGN KEY (`id_cuenta`) REFERENCES `cuenta` (`id_cuenta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `repositorio_ibfk_1` FOREIGN KEY (`id_tiporepositorio`) REFERENCES `tiporepositorio` (`id_tiporepositorio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `repositoriocontenido`
--
ALTER TABLE `repositoriocontenido`
  ADD CONSTRAINT `repositoriocontenido_ibfk_1` FOREIGN KEY (`id_contenido`) REFERENCES `contenido` (`id_contenido`) ON UPDATE CASCADE,
  ADD CONSTRAINT `repositoriocontenido_ibfk_2` FOREIGN KEY (`id_repositorio`) REFERENCES `repositorio` (`id_repositorio`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
