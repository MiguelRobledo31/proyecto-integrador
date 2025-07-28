CREATE TABLE `accesos` (
  `id` int(11) NOT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`id`, `matricula`, `fecha`, `hora_entrada`, `hora_salida`) VALUES
(1, '221550038', '2025-05-13', '11:27:39', NULL),
(2, '221550038', '2025-04-21', '10:34:06', '10:34:29'),
(3, '221550038', '2025-04-21', '10:32:51', '10:33:13'),
(4, '221550038', '2025-04-21', '10:28:27', '10:32:02'),
(5, '221550038', '2025-04-21', '09:33:56', '09:34:04'),
(6, '221550038', '2025-04-20', '21:03:39', '21:05:24'),
(7, '221550008', '2025-04-20', '21:03:31', NULL),
(8, '221550038', '2025-07-20', '21:26:42', NULL),
(9, '221550008', '2025-07-22', '23:00:08', NULL),
(10, '221550008', '2025-07-24', '20:16:40', NULL),
(11, '221550038', '2025-07-25', '19:28:02', '19:41:01'),
(12, '221550008', '2025-07-25', '19:38:35', '20:10:12'),
(13, '221550038', '2025-07-25', '19:44:51', '19:45:03'),
(14, '221550038', '2025-07-25', '20:09:55', '21:07:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `matricula` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `carrera` varchar(100) DEFAULT NULL,
  `tipo` varchar(30) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`matricula`, `nombre`, `apellidos`, `carrera`, `tipo`, `estado`) VALUES
('221550008', 'Dulce Citlali', 'Hernandez Ramirez', 'Ing en Sistemas', 'Alumno', 1),
('221550038', 'Miguel Angel', 'Robledo Lopez', 'Ing en Sistemas', 'Alumno', 1),
('221550093', 'Fernanda Mariela', 'Espinoza Hernandez', 'Ing en Sistemas', 'Alumno', 0),
('221550100', 'Luis', 'González Pérez', NULL, 'Alumno', 1),
('221550101', 'Paola', 'Martínez Ruiz', NULL, 'Alumno', 1),
('221550102', 'Ricardo', 'Luna Castillo', NULL, 'Alumno', 1),
('221550200', 'Nancy', 'Ortiz Ramos', NULL, 'Administrativo', 1),
('221550201', 'Mauricio', 'Jiménez Paredes', NULL, 'Administrativo', 1),
('221550202', 'Claudia', 'Hernández Díaz', NULL, 'Administrativo', 1),
('231550110', 'Hugo', 'Vargas López', NULL, 'Profesor', 1),
('231550111', 'Erika', 'Gómez Silva', NULL, 'Profesor', 1),
('241550300', 'Brenda', 'Aguilar Peña', NULL, 'Personal Extra', 1),
('241550301', 'Luis', 'Santos Lara', NULL, 'Personal Extra', 1),
('241550302', 'Norma', 'Delgado Esquivel', NULL, 'Personal Extra', 1),
('241550303', 'Víctor', 'Solís Ayala', NULL, 'Personal Extra', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellidos`, `rol`) VALUES
(1, 'admin1', 'admin123', 'Laura', 'Vargas Rodríguez', 'administrador'),
(7, 'prueba_bien', '123', 'opr', 'dojeoj', 'administrador'),
(10, 'grfg', 'gfgf', 'gfgf', 'gf', 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`matricula`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `usuario_rol` (`usuario`,`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesos`
--
ALTER TABLE `accesos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `accesos_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `personal` (`matricula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
