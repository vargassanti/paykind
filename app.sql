-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2024 a las 18:18:55
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_administrador`
--

CREATE TABLE `tbl_administrador` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `tipo_documento_u` varchar(20) NOT NULL,
  `nombres_u` varchar(100) NOT NULL,
  `apellidos_u` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `celular` varchar(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `barrio` int(11) NOT NULL,
  `fotoPerfil` varchar(255) NOT NULL,
  `id_rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_administrador`
--

INSERT INTO `tbl_administrador` (`id_usuario`, `usuario`, `tipo_documento_u`, `nombres_u`, `apellidos_u`, `correo`, `password`, `celular`, `direccion`, `barrio`, `fotoPerfil`, `id_rol`) VALUES
(102940283, 'Admin', 'CC', 'Administrador', 'Prueba', 'administradorPaykind@gmail.com', '$2y$10$VbGsYospqdWvxjLulTiG1eFKlqgBFaqxIJi7K7jqfDyB.e2iElo4u', '829382', '', 0, '', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_barrio`
--

CREATE TABLE `tbl_barrio` (
  `id_barrio` int(11) NOT NULL,
  `nombre_barrio` varchar(50) NOT NULL,
  `id_comuna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_barrio`
--

INSERT INTO `tbl_barrio` (`id_barrio`, `nombre_barrio`, `id_comuna`) VALUES
(0, 'Asentamiento Girasoles', 17),
(1, 'Loreto', 9),
(2, 'Juan Pablo II', 9),
(3, 'Barrios de Jesús', 9),
(4, 'Bombona N°2', 9),
(5, 'Los cerros el vergel', 9),
(6, 'Alejandro Echavarría', 9),
(7, 'Caicedo', 9),
(8, 'Buenos aires', 9),
(9, 'Miraflores', 9),
(10, 'Cataluña', 9),
(11, 'La milagrosa', 9),
(12, 'Gerona', 9),
(13, 'El salvador', 9),
(14, 'Asomadera N°1', 9),
(15, 'Asomadera N°2', 9),
(16, 'Asomadera N°3', 9),
(17, 'Ocho de marzo', 9),
(19, 'Santo Domingo Savio N°1', 1),
(20, 'Popular', 1),
(21, 'Granizal', 1),
(22, 'Moscú N°1', 1),
(23, 'Villa guadalupe', 1),
(24, 'San Pablo', 1),
(25, 'Aldea Pablo VI', 1),
(26, 'La esperanza N°2', 1),
(27, 'El compromiso', 1),
(28, 'La avanzada', 1),
(29, 'Carpinelo', 1),
(30, 'La isla', 2),
(31, 'El playón de los comuneros', 2),
(32, 'Pablo VI', 2),
(33, 'La frontera', 2),
(34, 'La francia', 2),
(35, 'Andalucía', 2),
(36, 'Villa del socorro', 2),
(37, 'villa niza', 2),
(38, 'Moscú N°1', 2),
(39, 'Santa cruz', 2),
(40, 'La rosa', 2),
(41, 'La Salle', 3),
(42, 'La Granjas', 3),
(43, 'Campo Valdes Nº 2', 3),
(44, 'Santa Inés', 3),
(45, 'El Raizal', 3),
(46, 'El Pomar', 3),
(47, 'Manrique Central No. 2', 3),
(48, 'Manrique Oriental', 3),
(49, 'Versalles Nº 1', 3),
(50, 'Versalles Nº 2', 3),
(51, 'La Cruz', 3),
(52, 'Oriente', 3),
(53, 'Maria Cano – Carambolas', 3),
(54, 'San José La Cima Nº 1', 3),
(55, 'San José La Cima Nº 2', 3),
(56, 'Berlín', 4),
(57, 'San Isidro', 4),
(58, 'Palermo', 4),
(59, 'Bermejal – Los Álamos', 4),
(60, 'Moravia', 4),
(61, 'Sevilla', 4),
(62, 'San Pedro', 4),
(63, 'Manrique Central Nº 1', 4),
(64, 'Campo Valdes Nº 1', 4),
(65, 'Las Esmeraldas', 4),
(66, 'La Piñuela', 4),
(67, 'Aranjuez', 4),
(68, 'Brasilia', 4),
(69, 'Miranda', 4),
(70, 'Toscana', 5),
(71, 'Las Brisas', 5),
(72, 'Florencia', 5),
(73, 'Tejelo', 5),
(74, 'Boyacá', 5),
(75, 'Héctor Abad Gómez', 5),
(76, 'Belalcazar', 5),
(77, 'Girardot', 5),
(78, 'Tricentenario', 5),
(79, 'Castilla', 5),
(80, 'Francisco Antonio Zea', 5),
(81, 'Alfonso López', 5),
(82, 'Caribe', 5),
(83, 'El Progreso', 5),
(84, 'Santander', 6),
(85, 'Doce de Octubre Nº 1', 6),
(86, 'Doce de Octubre Nº 2', 6),
(87, 'Pedregal', 6),
(88, 'La Esperanza', 6),
(89, 'San Martín de Porres', 6),
(90, 'Kennedy', 6),
(91, 'Picacho', 6),
(92, 'Picachito', 6),
(93, 'Mirador del Doce', 6),
(94, 'Progreso Nº 2', 6),
(95, 'El Triunfo', 6),
(96, 'Cerro El Volador', 7),
(97, 'San Germán', 7),
(98, 'Barrio Facultad de Minas Universidad Nacional', 7),
(99, 'La Pilarica', 7),
(100, 'Bosques de San Pablo', 7),
(101, 'Altamira', 7),
(102, 'Córdoba', 7),
(103, 'López de Mesa', 7),
(104, 'El Diamante', 7),
(105, 'Aures Nº 1', 7),
(106, 'Aures Nº 2', 7),
(107, 'Bello Horizonte', 7),
(108, 'Villa Flora', 7),
(109, 'Palenque', 7),
(110, 'Robledo', 7),
(111, 'Cucaracho', 7),
(112, 'Fuente Clara', 7),
(113, 'Santa Margarita', 7),
(114, 'Olaya Herrera', 7),
(115, 'Pajarito', 7),
(116, 'Monteclaro', 7),
(117, 'Nueva Villa de La Iguaná', 7),
(118, 'Villa Hermosa', 8),
(119, 'La Mansión', 8),
(120, 'San Miguel', 8),
(121, 'La Ladera', 8),
(122, 'Batallón Girardot', 8),
(123, 'Llanaditas', 8),
(124, 'Los Mangos', 8),
(125, 'Enciso', 8),
(126, 'Sucre', 8),
(127, 'El Pinal', 8),
(128, 'Trece de Noviembre', 8),
(129, 'La Libertad', 8),
(130, 'Villatina', 8),
(131, 'San Antonio', 8),
(132, 'Las Estancias', 8),
(133, 'Villa Turbay', 8),
(134, 'La Sierra (Santa Lucía – Las Estancias)', 8),
(135, 'Villa Lilliam', 8),
(136, 'Prado', 10),
(137, 'Jesús Nazareno', 10),
(138, 'El Chagualo', 10),
(139, 'Estación Villa', 10),
(140, 'San Benito', 10),
(141, 'Guayaquil', 10),
(142, 'Corazón de Jesús', 10),
(143, 'Calle Nueva', 10),
(144, 'Perpetuo Socorro', 10),
(145, 'Barrio Colón', 10),
(146, 'Las Palmas', 10),
(147, 'Bomboná Nº 1', 10),
(148, 'Boston', 10),
(149, 'Los Ángeles', 10),
(150, 'Villa Nueva', 10),
(151, 'La Candelaria', 10),
(152, 'San Diego', 10),
(153, 'Carlos E. Restrepo', 11),
(154, 'Suramericana', 11),
(155, 'Naranjal', 11),
(156, 'San Joaquín', 11),
(157, 'Los Conquistadores', 11),
(158, 'Bolivariana', 11),
(159, 'Laureles', 11),
(160, 'Las Acacias', 11),
(161, 'La Castellana', 11),
(162, 'Lorena', 11),
(163, 'El Velódromo', 11),
(164, 'Estadio', 11),
(165, 'Los Colores', 11),
(166, 'Cuarta Brigada', 11),
(167, 'Florida Nueva', 11),
(168, 'Ferrini', 12),
(169, 'Calasanz', 12),
(170, 'Los Pinos', 12),
(171, 'La América', 12),
(172, 'La Floresta', 12),
(173, 'Santa Lucia', 12),
(174, 'El Danubio', 12),
(175, 'Campo Alegre', 12),
(176, 'Santa Mónica', 12),
(177, 'Barrio Cristóbal', 12),
(178, 'Simón Bolívar', 12),
(179, 'Santa Teresita', 12),
(180, 'Calasanz Parte Alta', 12),
(181, 'El Pesebre', 13),
(182, 'Blanquizal', 13),
(183, 'Santa Rosa de Lima', 13),
(184, 'Los Alcázares', 13),
(185, 'Metropolitano', 13),
(186, 'La Pradera', 13),
(187, 'Juan XIII – La Quiebra', 13),
(188, 'San Javier Nº 2', 13),
(189, 'San Javier Nº 1', 13),
(190, 'Veinte de Julio', 13),
(191, 'Belencito', 13),
(192, 'Betania', 13),
(193, 'El Corazón', 13),
(194, 'Las Independencias', 13),
(195, 'Nuevos Conquistadores', 13),
(196, 'El Salado', 13),
(197, 'Eduardo Santos', 13),
(198, 'Antonio Nariño', 13),
(199, 'El Socorro', 13),
(200, 'Barrio Colombia', 14),
(201, 'Simesa', 14),
(202, 'Villa Carlota', 14),
(203, 'Castropol', 14),
(204, 'Lalinde', 14),
(205, 'Las Lomas Nº 1', 14),
(206, 'Las Lomas Nº 2', 14),
(207, 'Altos del Poblado', 14),
(208, 'El Tesoro', 14),
(209, 'Los Naranjos', 14),
(210, 'Los Balsos Nº 1', 14),
(211, 'San Lucas', 14),
(212, 'El Diamante Nº 2', 14),
(213, 'El Castillo', 14),
(214, 'Los Balsos Nº 2', 14),
(215, 'Alejandría', 14),
(216, 'La Florida', 14),
(217, 'El Poblado', 14),
(218, 'Manila', 14),
(219, 'Astorga', 14),
(220, 'Patio Bonito', 14),
(221, 'La Aguacatala', 14),
(222, 'Santa María de Los Ángeles', 14),
(223, 'Tenche', 15),
(224, 'Trinidad', 15),
(225, 'Santa Fé', 15),
(226, 'Parque Juan Pablo II', 15),
(227, 'Campo Amor', 15),
(228, 'Noel', 15),
(229, 'Cristo Rey', 15),
(230, 'Guayabal', 15),
(231, 'La Colina', 15),
(232, 'El Rodeo', 15),
(233, 'Fátima', 16),
(234, 'Rosales', 16),
(235, 'Belén', 16),
(236, 'Granada', 16),
(237, 'San Bernardo', 16),
(238, 'Las Playas', 16),
(239, 'Diego Echevarria', 16),
(240, 'La Mota', 16),
(241, 'La Hondonada', 16),
(242, 'El Rincón', 16),
(243, 'La Loma de Los Bernal', 16),
(244, 'La Gloria', 16),
(245, 'Altavista', 16),
(246, 'La Palma', 16),
(247, 'Los Alpes', 16),
(248, 'Las Violetas', 16),
(249, 'Las Mercedes', 16),
(250, 'Nueva Villa de Aburrá', 16),
(251, 'Miravalle', 16),
(252, 'El Nogal – Los Almendros', 16),
(253, 'Cerro Nutibara', 16),
(255, 'Asentamiento Nueva Jerusalén', 17),
(256, 'Los Sauces', 17),
(257, 'El Cafetal', 17),
(258, 'La Pradera', 17),
(259, 'La Esmeralda', 17),
(300, 'París', 17),
(301, 'La Maruchenga', 17),
(302, 'José Antonio Galán', 17),
(303, 'Salvador Allende', 17),
(304, 'Barrio Nuevo', 18),
(305, 'La Cabañita', 18),
(306, 'La Cabaña', 18),
(307, 'La Madera', 18),
(308, 'La Florida', 18),
(309, 'Gran Avenida', 18),
(310, 'San José Obrero', 18),
(311, 'Zona Industrial #1', 18),
(312, 'Villas de Occidente', 19),
(313, 'Molinares', 19),
(314, 'San Simón', 19),
(315, 'Amazonía', 19),
(316, 'Santa Ana', 19),
(317, 'Los Búcaros', 19),
(318, 'Serramonte', 19),
(319, 'Salento', 19),
(320, 'Suárez', 20),
(321, 'Puerto Bello', 20),
(322, 'Rincón Santos', 20),
(323, 'Central', 20),
(324, 'Espíritu Santo', 20),
(325, 'Centro', 20),
(326, 'Pérez', 20),
(327, 'Nazareth', 20),
(328, 'La Meseta', 20),
(329, 'El Rosario', 20),
(330, 'Andalucía', 20),
(331, 'López de Mesa', 20),
(332, 'El Cairo', 20),
(333, 'La Milagrosa', 20),
(334, 'El Congolo', 20),
(335, 'Las Granjas', 20),
(336, 'Prado', 20),
(337, 'Mánchester', 20),
(338, 'La Estación', 20),
(339, 'Zona Industrial #3', 20),
(340, 'Altavista', 21),
(341, 'El Carmelo', 21),
(342, 'Hato Viejo', 21),
(343, 'El Porvenir', 21),
(344, 'Briceño', 21),
(345, 'Buenos Aires', 21),
(346, 'El Paraíso', 21),
(347, 'Riachuelos', 21),
(348, 'Valadares', 21),
(349, 'El Trapiche', 21),
(350, 'Aralias', 21),
(351, 'Urapanes', 21),
(352, 'La Primavera', 21),
(353, 'Villa María', 21),
(354, 'Villas de Comfenalco', 21),
(355, 'Bellavista', 22),
(356, 'El Ducado', 22),
(357, 'Girasoles', 22),
(358, 'La Aldea', 22),
(359, 'La Selva', 22),
(360, 'Las Araucarias (etapas I y II)', 22),
(361, 'Los Alpes', 22),
(362, 'Pachelly', 22),
(363, 'Playa Rica', 22),
(364, 'San Gabriel', 22),
(365, 'San Martín', 22),
(366, 'Vereda Tierradentro (Zona urbana)', 22),
(367, 'Villas del Sol', 22),
(368, 'Villa Linda (incluye urbanización Girasoles)', 22),
(369, 'Altos de Quitasol', 23),
(370, 'Altos de Niquía', 23),
(371, 'Asentamiento El Tanque', 23),
(372, 'Bifamiliares', 23),
(373, 'El Mirador', 23),
(374, 'La Selva', 23),
(375, 'Los Ángeles', 23),
(376, 'Ciudad Niquía', 24),
(377, 'Ciudadela del Norte', 24),
(378, 'Hermosa Provincia', 24),
(379, 'Panamericano', 24),
(380, 'Terranova', 24),
(381, 'La Navarra', 25),
(382, 'El Trébol', 25),
(383, 'Guasimalito', 25),
(384, 'Zona Industrial #5', 25),
(385, 'Fontidueño', 26),
(386, 'La Mina', 26),
(387, 'Alcalá', 26),
(388, 'Los Ciruelos', 26),
(389, 'Estación Primera', 26),
(390, 'Las Vegas', 26),
(391, 'La Camila', 26),
(392, 'Cinco Estrellas', 26),
(393, 'Marco Fidel Suárez', 26),
(394, 'Zona Industrial #6', 26),
(395, 'La Gabriela', 27),
(396, 'Belvedere', 27),
(397, 'Acevedo', 27),
(398, 'Zamora', 27),
(399, 'Santa Rita', 27),
(400, 'Alpes del Norte', 27),
(401, 'Zona Industrial # 7', 27),
(402, 'El Progreso', 28),
(403, 'El Rosario', 28),
(404, 'Girardot', 28),
(405, 'San Fernando', 28),
(406, 'Santa María', 28),
(407, 'Sucre', 28),
(408, 'Villa Nueva', 28),
(409, 'El Progreso', 29),
(410, 'La Aldea', 29),
(411, 'Santa María', 29),
(412, 'Villa Paula', 29),
(413, 'La Candelaria', 30),
(414, 'San Isidro', 30),
(415, 'San José', 30),
(416, 'Simón Bolívar', 30),
(417, 'San Pío', 31),
(418, 'El Rosario', 32),
(419, 'El Salado', 32),
(420, 'El Trapiche', 32),
(421, ' El Verlón', 32),
(422, 'San Antonio', 32),
(423, 'El Salado', 33),
(424, 'El Trapiche', 33),
(425, 'El Verlón', 33),
(426, 'San Antonio', 33),
(427, 'El Trapiche', 34),
(428, 'Villa Paula', 35),
(429, 'Santa Ana', 36),
(430, 'Ditaires', 37),
(431, 'San Fernando', 37),
(432, 'San Isidro', 37),
(433, 'San José', 37),
(434, 'El Dorado', 38),
(435, 'El Salado', 38),
(436, 'El Portal', 38),
(437, 'La Mina', 38),
(438, 'San Rafael', 38),
(439, 'El Rodeo', 38),
(440, 'San Marcos', 39),
(441, 'La Sebastiana', 39),
(442, ' La Magnolia', 39),
(443, 'La Paz', 39),
(444, ' Los Naranjos', 39),
(445, 'Los Alpes', 39),
(446, 'Zúñiga', 40),
(447, 'El Trianón', 40),
(448, 'La Inmaculada', 40),
(449, 'La Primavera', 40),
(450, 'La Pereira', 40),
(451, 'La Abadía', 40),
(452, 'El Dorado', 41),
(453, 'El Salado', 41),
(454, 'El Portal', 41),
(455, 'La Mina', 41),
(456, 'San Rafael', 41),
(457, 'El Rodeo', 41),
(458, 'Alcalá', 42),
(459, 'El Escobero', 42),
(460, 'Las Antillas', 42),
(461, 'La Calera', 42),
(462, 'El Diamante', 42),
(463, 'Las Palmas', 42),
(464, 'Jardines', 43),
(465, 'El Portal de la Frontera.', 43),
(466, 'Otraparte', 43),
(467, 'La Paz', 43),
(468, 'La Magnolia', 43),
(469, 'El Salado', 43),
(470, 'La Mesa', 44),
(471, 'El Dorado', 44),
(472, 'El Salado', 44),
(473, 'La Mina', 44),
(474, 'San Rafael', 44),
(475, 'El Rodeo', 44);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carrito`
--

CREATE TABLE `tbl_carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(50) NOT NULL,
  `id_stock` varchar(100) NOT NULL,
  `estado_carrito` varchar(30) NOT NULL DEFAULT 'Pendiente',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categorias`
--

CREATE TABLE `tbl_categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_categorias`
--

INSERT INTO `tbl_categorias` (`id_categoria`, `nombre_categoria`) VALUES
(49, 'Cuidado personal'),
(50, 'Oficina'),
(51, 'Deportes'),
(53, 'Accesorios'),
(54, 'Tecnología'),
(56, 'Audio'),
(98, 'Ropa'),
(99, 'Hombres'),
(100, 'Mujeres'),
(101, 'Antigüedades y Colecciones'),
(102, 'Arte, Papelería y Mercería');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_compra`
--

CREATE TABLE `tbl_compra` (
  `id_compra` int(11) NOT NULL,
  `total_compra` decimal(10,0) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `costo_envio` decimal(10,0) NOT NULL,
  `metodo_pago` varchar(45) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL DEFAULT current_timestamp(),
  `imagen_tranferencia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_compra`
--

INSERT INTO `tbl_compra` (`id_compra`, `total_compra`, `direccion`, `costo_envio`, `metodo_pago`, `id_usuario`, `fecha_compra`, `imagen_tranferencia`) VALUES
(518, 106500, 'Cra 33 #34-33 apto 43g', 20000, 'Transferencia Ahorros Bancolombia', 1234522, '2024-01-08 23:13:58', '1704777238_pngwing.com.png'),
(519, 1600000, 'Cra 33 #34-33 apto 43g', 20000, 'Efectivo', 1234522, '2024-01-11 12:15:43', ''),
(520, 32767080, 'Cra 33 #34-33 apto 43g', 20000, 'Efectivo', 1234522, '2024-01-11 12:46:38', ''),
(521, 7120660, 'carrera 112c', 20000, 'Efectivo', 87382731, '2024-01-12 00:24:15', ''),
(522, 14129540, 'Cra 33 #34-33 apto 43g', 20000, 'Efectivo', 1234522, '2024-05-08 18:47:08', ''),
(523, 4877320, 'Cra 33 #34-33 apto 43g', 20000, 'Efectivo', 1234522, '2024-05-08 18:51:47', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_compra_producto`
--

CREATE TABLE `tbl_compra_producto` (
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_stock` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado_carrito` varchar(100) NOT NULL DEFAULT 'En proceso'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_compra_producto`
--

INSERT INTO `tbl_compra_producto` (`id_compra`, `id_producto`, `id_stock`, `cantidad`, `estado_carrito`) VALUES
(518, 21433, 66, 1, 'Completado'),
(518, 21432, 90, 1, 'Completado'),
(519, 21379, 28, 1, 'Completado'),
(520, 21381, 44, 10, 'Completado'),
(520, 21381, 81, 2, 'Completado'),
(520, 21383, 47, 1, 'Completado'),
(520, 21383, 48, 2, 'Completado'),
(520, 21379, 28, 3, 'Completado'),
(521, 21381, 44, 1, 'Completado'),
(521, 21380, 41, 1, 'Completado'),
(521, 21383, 47, 1, 'Completado'),
(521, 21382, 45, 1, 'Completado'),
(522, 21382, 46, 18, 'Completado'),
(522, 21381, 44, 1, 'Completado'),
(522, 21396, 8, 1, 'Completado'),
(522, 21383, 47, 1, 'Completado'),
(522, 21384, 51, 1, 'Completado'),
(522, 21392, 38, 1, 'Completado'),
(523, 21382, 45, 1, 'Completado'),
(523, 21380, 40, 1, 'Completado'),
(523, 21383, 47, 1, 'Completado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_comuna`
--

CREATE TABLE `tbl_comuna` (
  `id_comuna` int(11) NOT NULL,
  `nombre_comuna` varchar(50) NOT NULL,
  `id_municipio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_comuna`
--

INSERT INTO `tbl_comuna` (`id_comuna`, `nombre_comuna`, `id_municipio`) VALUES
(1, 'Popular', 1),
(2, 'Santa cruz', 1),
(3, 'Manrique', 1),
(4, 'Aranjuez', 1),
(5, 'Castilla', 1),
(6, 'Doce de octubre', 1),
(7, 'Robledo', 1),
(8, 'Villa hermosa', 1),
(9, 'Buenos aires', 1),
(10, 'La candelaria', 1),
(11, 'Laureles - Estadio', 1),
(12, 'La america', 1),
(13, 'San Javier', 1),
(14, 'El poblado', 1),
(15, 'Guayabal', 1),
(16, 'Belén', 1),
(17, 'París', 2),
(18, 'La Madera', 2),
(19, 'Santa Ana', 2),
(20, 'Suárez', 2),
(21, 'La Cumbre', 2),
(22, 'Bellavista', 2),
(23, 'Altos de Niquía', 2),
(24, 'Niquía', 2),
(25, 'Guasimalito', 2),
(26, 'Fontidueño', 2),
(27, 'Zamora', 2),
(28, 'Zona Centro', 3),
(29, 'Santa María', 3),
(30, 'La Candelaria', 3),
(31, 'San Pío', 3),
(32, 'El Rosario', 3),
(33, ' El Salado', 3),
(34, 'El Trapiche', 3),
(35, 'Villa Paula', 3),
(36, 'Santa Ana', 3),
(37, ' Ditaires', 3),
(38, 'Centro', 4),
(39, 'San Marcos', 4),
(40, 'Zúñiga', 4),
(41, 'El Dorado', 4),
(42, 'Alcalá', 4),
(43, 'Jardines', 4),
(44, 'Mesa', 4),
(45, 'Pilsen', 5),
(46, 'La Florida', 5),
(47, 'San José', 5),
(48, ' El Carmelo', 5),
(49, 'Ciudadela Robledo', 5),
(50, 'La Estrella', 6),
(51, 'Loma Linda', 6),
(52, 'La Madera', 6),
(53, 'Altavista', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_municipio`
--

CREATE TABLE `tbl_municipio` (
  `id_municipio` int(11) NOT NULL,
  `nombre_municipio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_municipio`
--

INSERT INTO `tbl_municipio` (`id_municipio`, `nombre_municipio`) VALUES
(1, 'Medellín'),
(2, 'Bello'),
(3, 'Itagüí'),
(4, 'Envigado'),
(5, 'Sabaneta'),
(6, 'La Estrella');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_productos`
--

CREATE TABLE `tbl_productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `precio` varchar(255) NOT NULL,
  `nit_identificacion` int(20) NOT NULL,
  `img_producto` varchar(255) NOT NULL,
  `img_producto2` varchar(255) NOT NULL,
  `img_producto3` varchar(255) NOT NULL,
  `img_producto4` varchar(255) NOT NULL,
  `img_producto5` varchar(255) NOT NULL,
  `img_producto6` varchar(255) NOT NULL,
  `especificaciones_p` varchar(1000) DEFAULT NULL,
  `descuento_producto` int(100) DEFAULT NULL,
  `estado_producto` varchar(30) NOT NULL DEFAULT 'Activo',
  `id_sub_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_productos`
--

INSERT INTO `tbl_productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `nit_identificacion`, `img_producto`, `img_producto2`, `img_producto3`, `img_producto4`, `img_producto5`, `img_producto6`, `especificaciones_p`, `descuento_producto`, `estado_producto`, `id_sub_categoria`) VALUES
(21379, 'Xiaomi Pocophone Poco X5 Pro', 'Dispositivo desbloqueado para que elijas la compañía telefónica que prefieras.\r\nCompatible con redes 5G.\r\nPantalla AMOLED de 6.67\".\r\nTiene 3 cámaras traseras de 108Mpx/8Mpx/2Mpx.\r\n', '2000000', 12312423, '1696454100_xiaomi2.png', '1696454100_xiaomi5.png', '1696454100_xiaomi4.png', '1696454100_xiaomi3.png', '1696454100_xiaomi6.png', '1696454100_xiaomi5.png', 'hola', 20, 'Activo', 13),
(21380, 'iPhone 13 - 128GB', 'Una pantalla OLED más brillante que ahorra energía y se ve increíble incluso a pleno sol. Y un diseño duradero resistente al agua y al polvo.', '4479000', 829482, '1696563783_Captura de pantalla 2023-10-05 223504.png', '1696563783_Captura de pantalla 2023-10-05 223613.png', '1696563783_Captura de pantalla 2023-10-05 223548.png', '1696563783_Captura de pantalla 2023-10-05 223634.png', '1696563783_Captura de pantalla 2023-10-05 223722.png', '1696563783_Captura de pantalla 2023-10-05 223704.png', NULL, 2, 'Activo', 15),
(21381, 'Apple Watch Ultra', 'El Apple Watch Ultra es duro como una roca y está listo para todo. Con un GPS de una precisión inigualable, funcionalidades para llevar una vida saludable, segura y conectada, una batería que dura hasta 36 horas. Consultar los avisos legales, y tres correas optimizadas para quienes comen, viven y respiran aventura.', '3399000', 829482, '1696564467_Captura de pantalla 2023-10-05 225114.png', '1696564467_Captura de pantalla 2023-10-05 225126.png', '1696564467_Captura de pantalla 2023-10-05 225135.png', '1696564467_Captura de pantalla 2023-10-05 225201.png', '1696564467_Captura de pantalla 2023-10-05 225217.png', '1696564467_Captura de pantalla 2023-10-05 225146.png', NULL, 34, 'Activo', 16),
(21382, 'AirPods Pro (2da Generación)', 'Controlador de alta excursión diseñado por Apple\r\nAmplificador exclusivo con alto rango dinámico\r\nCancelación Activa de Ruido\r\nModo Ambiente adaptable\r\nEcualización de presión mediante un sistema de ventilación\r\nAudio espacial personalizado con seguimiento dinámico de la cabeza\r\nEcualización Adaptativa', '1389000', 829482, '1696565142_Captura de pantalla 2023-10-05 230101.png', '1696565142_Captura de pantalla 2023-10-05 230111.png', '1696565142_Captura de pantalla 2023-10-05 230121.png', '1696565142_Captura de pantalla 2023-10-05 230128.png', '1696565142_Captura de pantalla 2023-10-05 230137.png', '1696565142_Captura de pantalla 2023-10-05 230101.png', NULL, 90, 'Activo', 17),
(21383, 'Auriculares inalámbricos Beats Flex', 'En los oídos o alrededor del cuello, los audífonos Beats Flex son tan versátiles como tu vida. Ya sea que estés escuchando música, hablando por teléfono o navegando por tus redes sociales, siempre estarás alerta para lo que venga. ', '349000', 829482, '1696565679_Captura de pantalla 2023-10-05 231219.png', '1696565679_Captura de pantalla 2023-10-05 231229.png', '1696565679_Captura de pantalla 2023-10-05 231240.png', '1696565679_Captura de pantalla 2023-10-05 231250.png', '1696565679_Captura de pantalla 2023-10-05 231259.png', '1696565679_Captura de pantalla 2023-10-05 231307.png', NULL, 0, 'Activo', 18),
(21384, 'Auriculares Beats Studio Buds', 'La cancelación activa de ruido (ANC) bloquea el ruido externo para una escucha inmersiva\r\nEl modo de transparencia te permite escuchar el mundo que te rodea\r\nLa plataforma acústica personalizada ofrece un sonido potente y equilibrado\r\nEl audio espacial te sumerge en la música, las películas y los juegos', '699000', 829482, '1696565897_Captura de pantalla 2023-10-05 231603.png', '1696565897_Captura de pantalla 2023-10-05 231611.png', '1696565897_Captura de pantalla 2023-10-05 231619.png', '1696565897_Captura de pantalla 2023-10-05 231625.png', '1696565897_Captura de pantalla 2023-10-05 231632.png', '1696565897_Captura de pantalla 2023-10-05 231640.png', NULL, 0, 'Activo', 18),
(21385, 'AirPods Max', 'Combinando materiales premium y tecnología de audio avanzada, los audífonos supraaurales inalámbricos Apple AirPods Max verdes son una forma cómoda de sumergirse en su audio favorito. Están hechos para descansar ligeramente sobre la cabeza y las orejas con un dosel de malla tejida transpirable y orejeras de espuma viscoelástica envueltas en tela de malla.', '2799000', 829482, '1696566093_Captura de pantalla 2023-10-05 231935.png', '1696566093_Captura de pantalla 2023-10-05 231946.png', '1696566093_Captura de pantalla 2023-10-05 231955.png', '1696566093_Captura de pantalla 2023-10-05 231935.png', '1696566093_Captura de pantalla 2023-10-05 231946.png', '1696566093_Captura de pantalla 2023-10-05 231955.png', NULL, 1, 'Activo', 17),
(21386, 'Parlante Logitech UE Wonderboom 3', 'La bocina ultraportátil Wonderboom 3 te dará un sonido impresionante en un formato pequeño. Obtendrás una bocina con estilo y la mejor resistencia, para llevarla a todas tus aventuras. Disfruta de tu música y sonidos en interiores y exteriores. 31% hecho de plástico reciclado.', '459000', 829482, '1696566429_Captura de pantalla 2023-10-05 232334.png', '1696566429_Captura de pantalla 2023-10-05 232343.png', '1696566429_Captura de pantalla 2023-10-05 232352.png', '1696566429_Captura de pantalla 2023-10-05 232359.png', '1696566429_Captura de pantalla 2023-10-05 232409.png', '1696566429_Captura de pantalla 2023-10-05 232334.png', NULL, 0, 'Activo', 19),
(21387, 'iPad de 10.2 (9na Generación)', 'El chip A13 Bionic ofrece un rendimiento más rápido de CPU y gráficas, y viene con un Neural Engine más potente. Podrás crear, trabajar, jugar y mucho más gracias a una batería que te acompaña todo el día.', '2039000', 829482, '1697039517_ipad1.png', '1697039517_ipad2.png', '1697039517_ipad3.png', '1697039517_ipad4.png', '1697039517_ipad5.png', '1697039517_ipad6.png', NULL, 40, 'Activo', 20),
(21391, 'AirPods (3ra Generación)', 'Los AirPods no pesan nada y ofrecen un ajuste anatómico. Se colocan en el ángulo perfecto para darte un mayor confort y llevar el sonido directamente a tus oídos. Además, son un 33 % más cortos que los AirPods (2.ª generación) e incluyen un sensor de presión que te permite controlar la música y las llamadas fácilmente.', '999000', 829482, '1697043405_ai5.png', '1697043405_ai4.png', '1697043405_ai3.png', '1697043405_ai2.png', '1697043405_ai1.png', '1697043405_ai5.png', NULL, 0, 'Inactivo', 17),
(21392, 'iPad Mini 6 Wi-Fi', 'El iPad mini tiene un espectacular diseño de borde a borde con una pantalla Liquid Retina de 8,3 pulgadas que cabe perfectamente en la palma de tu mano. Y el Apple Pencil se adhiere magnéticamente al borde del dispositivo, para que lo tengas a la mano siempre que lo necesites.', '3969000', 829482, '1697043854_4.png', '1697043854_3.png', '1697043854_5.png', '1697043854_1.png', '1697043854_6.png', '1697043854_2.png', NULL, 0, 'Activo', 20),
(21393, 'Apple Pencil (1ra Gen)', 'El Apple Pencil lleva más allá la tecnología del iPad para que des rienda suelta a tu creatividad. Su increíble sensibilidad a la presión y la inclinación te permiten conseguir una enorme variedad de trazos y efectos, desde líneas ultrafinas hasta sombras sutiles. Es como un lápiz tradicional, pero con un nivel de precisión asombroso.', '739000', 829482, '1697044176_1.png', '1697044176_3.png', '1697044176_4.png', '1697044176_5.png', '1697044176_1.png', '1697044176_4.png', NULL, 0, 'Inactivo', 20),
(21394, 'Apple Watch Ultra 2 ', 'El Apple Watch más fuerte y equipado desafía los límites una vez más. Ahora con el flamante S9 SiP, una forma nueva y mágica de usar tu reloj sin siquiera tocar la pantalla, la más brillante de Apple hasta este momento. Además, ahora puedes elegir combinaciones de cajas y correas neutras en carbono.', '4369000', 829482, '1697047566_1.png', '1697047566_2.png', '1697047566_3.png', '1697047566_4.png', '1697047566_5.png', '1697047566_6.png', NULL, 10, 'Inactivo', 16),
(21395, 'Apple Watch Series 9', 'Un chip increíblemente potente, una forma mágica de interactuar con el Apple Watch sin siquiera tocarlo y una pantalla con el doble de brillo. Consultar los avisos legales Este es el Apple Watch Series 9. Ahora con combinaciones de cajas y correas neutras en carbono.', '2299000', 829482, '1697048582_2.png', '1697048582_1.png', '1697048582_3.png', '1697048582_4.png', '1697048582_5.png', '1697048582_6.png', NULL, 90, 'Inactivo', 16),
(21396, 'Apple Watch Ultra 3', 'Haz magia con los dedos. Interactúa con tu Apple Watch Ultra 3 de forma rápida y sencilla sin siquiera tocar la pantalla. Simplemente junta dos veces el dedo índice y el pulgar para contestar llamadas, pausar y reanudar un temporizador y mucho más. Este gesto facilita muchas acciones cotidianas, especialmente en esas ocasiones en las que traes demasiado entre manos.', '4369000', 829482, '1697049017_1.png', '1697049017_2.png', '1697049017_3.png', '1697049017_4.png', '1697049017_5.png', '1697049017_6.png', NULL, 0, 'Activo', 16),
(21397, 'MacBook Air 15 con Chip M2', 'El MacBook Air tiene un diseño ultradelgado y ofrece una velocidad fuera de serie. Y ahora viene en dos tamaños y cuatro colores. Elige el tuyo, y a volar.', '9699900', 829482, '1697049870_1.png', '1697049870_2.png', '1697049870_3.png', '1697049870_4.png', '1697049870_5.png', '1697049870_6.png', NULL, 0, 'Activo', 21),
(21398, 'iPhone 15 Plus', 'El nuevo e innovador diseño cuenta con una parte posterior de vidrio con infusión de color en todo el material. Y gracias a que el vidrio pasa por un proceso de intercambio iónico dual personalizado y a la carcasa de aluminio de calidad aeroespacial, el iPhone 15 tiene una resistencia increíble.', '5199000', 829482, '1697050425_1.png', '1697050425_2.png', '1697050425_3.png', '1697050425_4.png', '1697050425_5.png', '1697050425_6.png', NULL, 50, 'Activo', 15),
(21399, 'iPhone 14 Pro', 'Una manera mágica de interactuar con tu iPhone. Una funcionalidad de seguridad diseñada para salvar vidas. Una innovadora cámara gran angular de 48 MP. Y una pantalla hasta dos veces más brillante bajo el sol. Consultar los avisos legales Todo gracias a la potencia del ultrarrápido chip A16 Bionic.', '5769000', 829482, '1697051554_1.png', '1697051554_2.png', '1697051554_3.png', '1697051554_4.png', '1697051554_5.png', '1697051554_6.png', NULL, 10, 'Activo', 15),
(21400, 'iPhone 12', 'Diseño resistente con Ceramic Shield\r\nChip A14 Bionic\r\nSistema avanzado de dos cámaras de 12 MP (ultra gran angular y gran angular), modo Noche, Deep Fusion, HDR Inteligente 3 y grabación de video 4K HDR en Dolby Vision\r\nCámara frontal TrueDepth de 12 MP con modo Noche y grabación de video 4K HDR en Dolby Vision\r\nResistencia al agua IP68', '2999000', 829482, '1697051965_1.png', '1697051965_2.png', '1697051965_3.png', '1697051965_4.png', '1697051965_5.png', '1697051965_6.png', NULL, 10, 'Inactivo', 15),
(21429, 'iPhone 11', 'El iPhone 11 es un teléfono inteligente de gama alta con pantalla táctil producido por Apple, Inc. Fue presentado el 10 de septiembre de 2019 junto con el iPhone 11 Pro y el iPhone 11 Pro Max. El modelo cuenta con el chip Apple A13 Bionic y un nuevo sistema de cámara dual ultra ancho.', '2372100', 829482, '1699975732_iphone11-1.png', '1699975732_iphone11-2.png', '1699975732_iphone11-3.png', '1699975732_iphone11-4.png', '1699975732_iphone11-5.png', '1699975732_iphone11-6.png', 'Sistema de dos cámaras de 12 MP: ultra gran angular y gran angular', 33, 'Activo', 15),
(21430, 'Iphone 14 Pro Max', 'El iPhone 14 y el iPhone 14 Plus están equipados con el sistema SoC Apple A15, el mismo que se usa en el iPhone 13 Pro y 13 Pro Max de 2021. El iPhone 14 y 14 Plus cuentan con una CPU de 6 núcleos, una GPU de 5 núcleos y un motor neuronal de 16 núcleos.', '6123900', 829482, '1699976257_iphone14-1.png', '1699976257_iphone14-2.png', '1699976257_iphone14-3.png', '1699976257_iphone14-4.png', '1699976257_iphone14-1.png', '1699976257_iphone14-3.png', '', 0, 'Activo', 15),
(21431, 'Iphone 13 Pro Max 128', 'La pantalla del iPhone 13 tiene esquinas redondeadas que siguen el elegante diseño curvo del teléfono, y las esquinas se encuentran dentro de un rectángulo estándar. Si se mide en forma de rectángulo estándar, la pantalla tiene 6,06 pulgadas en diagonal (el área real de visualización es menor).', '3906800', 829482, '1699978176_iphone13p-1.png', '1699978176_iphone13p-2.png', '1699978176_iphone13p-3.png', '1699978176_iphone13p-4.png', '1699978176_iphone13p-1.png', '1699978176_iphone13p-2.png', '', 23, 'Activo', 15),
(21432, 'Camiseta Oversize Oso', 'El modelo mide 1.88 m y tiene una talla L', '89000', 2332321, '1700324009_matt1.png', '1700324009_matt2.png', '1700324009_matt3.png', '1700324009_matt4.png', '1700324009_matt3.png', '1700324009_matt1.png', '', 0, 'Activo', 40),
(21433, 'Camiseta Texto', 'La modelo mide 1.64m y tiene una talla S', '17500', 2332321, '1700324374_matt4.png', '1700324374_matt2.png', '1700324374_matt3.png', '1700324374_matt5.png', '1700324374_matt1.png', '1700324374_matt4.png', '', 0, 'Activo', 40),
(21434, 'Camiseta Oversize Ilustración', 'El modelo mide 1.88 m y tiene una talla L', '69000', 2332321, '1700324801_matt1.png', '1700324801_matt2.png', '1700324801_matt3.png', '1700324801_matt4.png', '1700324801_matt5.png', '1700324801_matt6.png', '', 5, 'Activo', 40),
(21435, 'Jeans Straight Fit Carpintero', 'El modelo mide 1.76m y tiene una talla S', '129000', 2332321, '1700325119_matt2.png', '1700325119_matt1.png', '1700325119_matt3.png', '1700325119_matt4.png', '1700325119_matt5.png', '1700325119_matt2.png', '', 0, 'Inactivo', 66),
(21438, 'Camiseta Regular Fit', 'Camiseta en punto de algodón ligero con cuello redondo de ribete acanalado y bajo recto. Corte estándar para una silueta clásica y cómoda.', '17900', 9282913, '1702309426_h&m4.png', '1702309426_h&m3.png', '1702309426_h&m1.png', '1702309426_h&m1.png', '1702309426_h&m4.png', '1702309426_h&m2.png', '', 0, 'Activo', 62),
(21439, 'Camiseta Loose Fit', 'Camiseta en punto de algodón. Modelo de corte holgado con cuello redondo con ribete acanalado.', '50000', 9282913, '1702309663_h&m7.png', '1702309663_h&m6.png', '1702309663_h&m5.png', '1702309663_h&m8.png', '1702309663_h&m6.png', '1702309663_h&m7.png', '', 0, 'Activo', 62),
(21440, 'Camiseta Loose Fit', 'Camiseta en punto de algodón. Modelo de corte holgado con cuello redondo de ribete acanalado.', '50000', 9282913, '1702309946_h&m13.png', '1702309946_h&m9.png', '1702309946_h&m10.png', '1702309946_h&m11.png', '1702309946_h&m12.png', '1702309946_h&m14.png', '', 10, 'Inactivo', 62),
(21441, 'Joggers', 'Joggers en denim rígido de algodón. Modelo de corte holgado de caderas a bajos con piernas redondeadas amplias y tiro bajo. Tiro medio con elástico revestido y cordón de ajuste oculto, cierre decorativo, bolsillos laterales, bolsillos de parche con tapa en las piernas y bolsillos traseros. Todo lo que necesitas para lucir un look denim impactante.', '154900', 9282913, '1702310248_h&m18.png', '1702310248_h&m15.png', '1702310248_h&m16.png', '1702310248_h&m17.png', '1702310248_h&m19.png', '1702310248_h&m16.png', '', 10, 'Activo', 66),
(21442, 'Joggers', 'Joggers en denim rígido de algodón. Modelo de corte holgado de caderas a bajos con piernas redondeadas amplias y tiro bajo. Tiro medio con elástico revestido y cordón de ajuste oculto, cierre decorativo, bolsillos laterales, bolsillos de parche con tapa en las piernas y bolsillos traseros. Todo lo que necesitas para lucir un look denim impactante.', '154900', 9282913, '1702310565_h&m22.png', '1702310565_h&m20.png', '1702310565_h&m21.png', '1702310565_h&m23.png', '1702310565_h&m24.png', '1702310565_h&m22.png', '', 0, 'Activo', 66),
(21443, 'Samsung Galaxy S23 Ultra ', 'Descubre infinitas posibilidades para tus fotos con las 4 cámaras principales de tu equipo. Pon a prueba tu creatividad y juega con la iluminación, diferentes planos y efectos para obtener grandes resultados.\r\n', '4099900', 76676, '1702311949_sm1.png', '1702311949_sm2.png', '1702311949_sm3.png', '1702311949_sm1.png', '1702311949_sm2.png', '1702311949_sm1.png', '', 18, 'Activo', 70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_stock`
--

CREATE TABLE `tbl_stock` (
  `id_stock` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_disponible` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `color_producto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_stock`
--

INSERT INTO `tbl_stock` (`id_stock`, `id_producto`, `cantidad_disponible`, `fecha_registro`, `color_producto`) VALUES
(1, 21391, 30, '2023-10-26 08:59:19', '#000000'),
(2, 21385, 5, '2023-10-26 09:12:18', '#58ED4A'),
(3, 21382, 17, '2023-10-26 09:12:18', '#CE4AED'),
(4, 21393, 10, '2023-10-26 09:12:18', '#F53B56'),
(5, 21395, 12, '2023-10-26 09:12:18', '#76EFF4'),
(6, 21381, 11, '2023-10-26 09:12:18', 'blue'),
(7, 21394, 23, '2023-10-26 09:12:18', '#fc580c'),
(8, 21396, 25, '2023-10-26 09:12:18', '#3B60F5'),
(9, 21384, 40, '2023-10-26 09:12:18', '#D60006'),
(10, 21383, 100, '2023-10-26 09:12:18', '#3B60F5'),
(12, 21387, 50, '2023-10-26 09:12:18', '#3B60F5'),
(13, 21392, 5, '2023-10-26 09:12:18', '#F5DC0F'),
(14, 21400, 100, '2023-10-26 09:12:18', '#3B60F5'),
(15, 21380, 32, '2023-10-26 09:12:18', '#0032FF'),
(16, 21399, 11, '2023-10-26 09:12:18', '#3B60F5'),
(17, 21398, 21, '2023-10-26 09:12:18', '#000'),
(18, 21397, 43, '2023-10-26 09:12:18', 'black'),
(19, 21386, 348, '2023-10-26 09:12:18', '#0FB1F5'),
(20, 21379, 4, '2023-10-26 09:12:18', 'blue'),
(28, 21379, 24, '2023-10-26 09:12:18', 'green'),
(29, 21391, 21, '2023-10-26 08:59:19', 'red'),
(31, 21391, 30, '2023-10-26 08:59:19', 'green'),
(34, 21400, 222, '2023-11-09 19:59:45', 'red'),
(37, 21383, 100, '2023-10-26 09:12:18', '#F576D0'),
(38, 21392, 54, '2023-10-26 09:12:18', '#F42301'),
(39, 21386, 31, '2023-10-26 09:12:18', '#9C00FC'),
(40, 21380, 9, '2023-10-26 09:12:18', '#000000'),
(41, 21380, 2, '2023-10-26 09:12:18', '#00DDAE'),
(42, 21380, 20, '2023-10-26 09:12:18', '#DD0000'),
(43, 21381, 28, '2023-11-09 20:03:18', '#DD0000'),
(44, 21381, 73, '2023-11-09 20:03:18', '#FFD800'),
(45, 21382, 24, '2023-10-26 09:12:18', '#FFD800'),
(46, 21382, 2, '2023-10-26 09:12:18', '#0078FF'),
(47, 21383, 96, '2023-10-26 09:12:18', '#000000'),
(48, 21383, 95, '2023-10-26 09:12:18', '#D800FF'),
(49, 21383, 100, '2023-10-26 09:12:18', '#46FF00'),
(50, 21384, 39, '2023-10-26 09:12:18', '#000000'),
(51, 21384, 39, '2023-10-26 09:12:18', '#00FFCD'),
(59, 21429, 98, '2023-11-14 10:28:52', '#7fff00'),
(60, 21430, 94, '2023-11-14 10:37:37', '#ff6347'),
(61, 21430, 1, '2023-11-14 10:41:08', '#8a2be2'),
(62, 21430, 222, '2023-11-14 10:49:20', '#000000'),
(63, 21431, 207, '2023-11-14 11:09:36', '#8a2be2'),
(64, 21431, 33, '2023-11-14 11:16:36', '#888'),
(65, 21432, 98, '2023-11-18 10:13:29', '#000000'),
(66, 21433, 9, '2023-11-18 10:19:34', '#d2b48c'),
(67, 21434, 196, '2023-11-18 10:26:41', '#ff7f50'),
(68, 21435, 20, '2023-11-18 10:31:59', '#000000'),
(69, 21431, 2334, '2023-12-06 13:56:53', '#ff6347'),
(70, 21431, 4, '2023-12-06 13:57:46', '#adff2f'),
(71, 21431, 17, '2023-12-06 13:58:12', '#cd5c5c'),
(72, 21431, 23, '2023-12-06 13:58:25', '#d8bfd8'),
(73, 21431, 100, '2023-12-06 13:58:36', '#cd853f'),
(74, 21438, 19, '2023-12-11 10:43:46', '#1e90ff'),
(75, 21439, 109, '2023-12-11 10:47:43', '#000000'),
(76, 21440, 234, '2023-12-11 10:52:26', '#ffefd5'),
(77, 21441, 100, '2023-12-11 10:57:28', '#9370db'),
(78, 21442, 85, '2023-12-11 11:02:45', '#000000'),
(79, 21443, 32, '2023-12-11 11:25:49', '#000000'),
(81, 21381, 21202, '2023-12-15 14:40:17', '#8b4513'),
(82, 21381, 7, '2023-12-15 14:45:34', '#ff4500'),
(83, 21381, 69, '2023-12-15 14:47:27', '#cd853f'),
(84, 21381, 666, '2023-12-15 14:48:12', '#9370db'),
(88, 21397, 19, '2023-12-18 09:10:18', '#cd853f'),
(89, 21397, 32, '2023-12-18 09:11:03', '#7fffd4'),
(90, 21432, 96, '2023-12-18 09:31:33', '#008b8b'),
(91, 21392, 100, '2023-12-18 13:55:50', '#7fff00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_sub_categorias`
--

CREATE TABLE `tbl_sub_categorias` (
  `id_sub_categoria` int(11) NOT NULL,
  `nombre_sub_categoria` varchar(500) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nit_identificacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_sub_categorias`
--

INSERT INTO `tbl_sub_categorias` (`id_sub_categoria`, `nombre_sub_categoria`, `id_categoria`, `nit_identificacion`) VALUES
(13, 'Redmi', 54, 12312423),
(14, 'Poco', 54, 12312423),
(15, 'Iphone', 54, 12312423),
(16, 'Watch', 54, 12312423),
(17, 'AirPods', 56, 12312423),
(18, 'Audífonos', 56, 12312423),
(19, 'Parlantes', 56, 12312423),
(20, 'iPad', 54, 829482),
(21, 'Mac', 54, 829482),
(22, 'Cuidado solar', 49, 123423452),
(23, 'Cuidado bucal', 49, 123423452),
(24, 'Repelentes', 49, 123423452),
(25, 'Desodorantes y antitranspirantes', 49, 123423452),
(26, 'Depilación y afeitado', 49, 123423452),
(27, 'Cuidado del cabello', 49, 123423452),
(28, 'Protección femenina', 49, 123423452),
(29, 'Cuidado de la piel', 49, 123423452),
(30, 'Accesorios deportivos multifuncionales', 51, 837423),
(31, 'Mochilas y maletas deportivas', 51, 837423),
(32, 'Hidratación Deportiva', 51, 837423),
(33, 'Protección deportiva', 51, 837423),
(34, 'Cascos deportivos', 51, 837423),
(35, 'Guantes y manoplas deportivas', 51, 837423),
(36, 'Gafas deportivas', 51, 837423),
(37, 'Accesorios para zapatos deportivos', 51, 837423),
(38, 'Equipo para Atletismo', 51, 837423),
(39, 'Arbitraje', 51, 837423),
(40, 'Ropa casual', 98, 2332321),
(41, 'Ropa formal', 98, 2332321),
(42, 'Ropa deportiva', 98, 2332321),
(43, 'Ropa de Playa', 98, 2332321),
(44, 'Ropa interior', 98, 2332321),
(45, 'Ropa de Dormir', 98, 2332321),
(46, 'Ropa de Trabajo', 98, 2332321),
(47, 'Escritorios', 50, 76676),
(48, 'Sillas de oficina', 50, 76676),
(49, 'Archivadores', 50, 76676),
(50, 'Estanterías', 50, 76676),
(51, 'Papelería ', 50, 76676),
(52, 'Material de escritura', 50, 76676),
(53, 'Material de archivo', 50, 76676),
(54, 'Accesorios para Cámaras', 53, 76676),
(55, 'Cables', 53, 76676),
(56, 'Cámaras', 53, 76676),
(57, 'Antigüedades', 101, 76676),
(58, 'Abrigos y chaquetas', 99, 9282913),
(59, 'Chalecos', 99, 9282913),
(60, 'Parkas y gabardinas', 99, 9282913),
(61, 'Chaquetas de cuero', 99, 9282913),
(62, 'Camisetas', 99, 9282913),
(63, 'Camisas', 99, 9282913),
(64, 'Sudaderas', 99, 9282913),
(65, 'Suéteres y cárdigans', 99, 9282913),
(66, 'Pantalones (jeans, chinos, pantalones formales)', 99, 9282913),
(67, 'Pantalones cortos', 99, 9282913),
(68, 'Pantalones deportivos', 99, 9282913),
(69, 'Celulares y Smartphones', 54, 989378),
(70, 'Samsung', 54, 76676);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tienda`
--

CREATE TABLE `tbl_tienda` (
  `nit_identificacion` int(20) NOT NULL,
  `nombre_tienda` varchar(100) NOT NULL,
  `logo_tienda` varchar(50) DEFAULT NULL,
  `descripcion` varchar(500) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_tienda`
--

INSERT INTO `tbl_tienda` (`nit_identificacion`, `nombre_tienda`, `logo_tienda`, `descripcion`, `id_usuario`) VALUES
(76676, 'Samsung', 'samsung-removebg-preview.png', 'Electrodomésticos, finanzas, entretenimiento y telefonía móvil.', 2221),
(96754, 'Lego', '1698778050_LEGO_logo.svg (2).png', 'Es una empresa danesa de juguetes. Su producto más conocido son los bloques de construcción pero también cuenta con series propias (Bionicle, Ninjago); una línea de productos preescolares (Lego Duplo) y una línea de juguetes de robótica (Lego Mindstorms) entre otros activos. Además presta su marca a la cadena de parques temáticos, Legoland.', 2221),
(212133, 'Nintendo', 'nintendo-switch-logo-0C3789E0D8-seeklogo.com.png', 'es una empresa de entretenimiento dedicada a la investigación, desarrollo y distribución de software y hardware de videojuegos, y juegos de cartas, con sede en Kioto, Japón.', 2221),
(827382, 'Motorola', '30f2e733784ec78311c04509f4a449c0.jpg', 'Es una empresa estadounidense de telecomunicaciones y electrónica de consumo, y filial del conglomerado tecnológico chino Lenovo. La empresa fabrica principalmente teléfonos inteligentes y otros dispositivos móviles que ejecutan el sistema operativo Android.', 2221),
(829482, 'Apple', 'apple-removebg-preview (2).png', 'Apple, Inc. es una empresa tecnológica multinacional estadounidense con sede en Cupertino, California.', 2221),
(837423, 'Adidas', 'adidas-removebg-preview.png', 'Adidas es una multinacional alemana fundada en 1949 que fabrica calzado, ropa y material deportivo. Con un equipo que supera los 57.000 empleados encargados de fabricar más de 900 millones de productos anuales', 2221),
(989378, 'HP', '2048px-HP_logo_2012.svg.png', 'Hewlett-Packard Company (NYSE: HPQ), más conocida como HP, es una empresa de tecnología estadounidense, con sede en Palo Alto, California, dedicada a la fabricación y comercialización de hardware y software además de brindar servicios de asistencia relacionados con la informática. La compañía fue fundada en 1939 por William Hewlett y David Packard, y se dedicaba a la fabricación de instrumentos de medida electrónica y de laboratorio.', 2221),
(2332321, 'Mattelsa', 'Logo-Mattelsa-2022-removebg-preview.png', 'MATTELSA exhibe a través de La Plataforma productos de consumo como ropa o complementos de vestuario, entre otros, y servicios como el envío de los productos; los cuales están a disposición de los Consumidores para su conocimiento general.', 2221),
(9282913, 'H&M', 'hm-symbol-logo-removebg-preview.png', 'Es una cadena multinacional sueca de tiendas de ropa con establecimientos en Europa, Oriente Próximo, África, Asia y Latinoamérica, cuya particularidad es que la ropa que venden, en vez de ser importada, es fabricada por la propia H&M. Cuenta con 4700 tiendas propias repartidas en 69 países y da empleo a aproximadamente 161 000 personas (2017). Asimismo, vende ropa por catálogo y a través de Internet en 44 países.', 2221),
(12312423, 'Xiaomi', 'Xiaomi_logo_(2021-).svg.png', 'Xiaomi Corporation (\"Xiaomi\") se fundó en abril de 2010 y se incorporó a la Junta principal de la bolsa de Hong Kong el 9 de julio de 2018 (1810.HK). Según Canalys, la cuota de mercado de la empresa en términos de envíos de smartphones alcanzó el puesto número 3 a nivel mundial en el segundo trimestre de 2022.', 2221),
(41111312, 'Nike', 'logo_nike_principal-removebg-preview.png', 'Es una empresa multinacional estadounidense dedicada al diseño, desarrollo, fabricación y comercialización de equipamiento deportivo: balones, calzado, ropa, equipo, accesorios y otros artículos deportivos.', 2221),
(123423452, 'Nivea', 'nivea-removebg-preview.png', 'Es una empresa de productos cosméticos, fundada en 1911 por el empresario Oskar Troplowitz, el químico Isaac Lifschütz y el dermatólogo Paul Gerson Unna, inventores de la primera crema hidratante de la historia. Es una gran marca mundialmente dedicada a la atención de la piel y el cuerpo. ', 2221);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `tipo_documento_u` varchar(20) NOT NULL,
  `nombres_u` varchar(100) NOT NULL,
  `apellidos_u` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `celular` varchar(11) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `barrio` int(11) DEFAULT NULL,
  `fotoPerfil` varchar(50) DEFAULT NULL,
  `id_rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`id_usuario`, `usuario`, `tipo_documento_u`, `nombres_u`, `apellidos_u`, `correo`, `password`, `celular`, `direccion`, `barrio`, `fotoPerfil`, `id_rol`) VALUES
(1234522, 'santi21', 'CC', 'Santiago', 'Vargas2', 'santiagovargasalvarez8@gmail.com', '$2y$10$kyaQHY/7rFWjGsWTABX.NuvkEArv2UblEvc/UMmPSMbVs88gqQCZ2', '12345', 'Cra 33 #34-33 apto 43g', 256, '1699160667_foto_perfil.png', 'Cliente'),
(19837263, 'Mateito', 'CC', 'Mateo', 'Reyes', 'mateoreyesuribe1@gmail.com', '$2y$10$.UGg5gf7Kfkh6SufVz52feYbK3hXJsWu891bjd6UzkJsFp6P1nqfu', '98374723', 'Carrera 112c8', 112, '1704604496_perfil2.png', 'Cliente'),
(87382731, 'UsuPrueba', 'CC', 'Usuario', 'Prueba', 'usuarioprueba1@gmail.com', '$2y$10$8MYqYzXJo/shMsT61j/.xO39b3VgfxLRzW15PWDcmAGcKpC3bRzkG', '333333', 'carrera 112c', 256, NULL, 'Cliente'),
(222333563, 'santas', 'CC', 'Santiago', 'sss', 'santi14@gmail.com', '$2y$10$6LEiM6E9miEIX5q6El5jUubphlbqf1LxGxcSX1BQqV.9D9Ot4.S5W', '22222222222', NULL, NULL, NULL, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_vendedor`
--

CREATE TABLE `tbl_vendedor` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `tipo_documento_u` varchar(20) NOT NULL,
  `nombres_u` varchar(100) NOT NULL,
  `apellidos_u` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `celular` varchar(11) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `barrio` int(50) DEFAULT NULL,
  `fotoPerfil` varchar(50) DEFAULT NULL,
  `id_rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_vendedor`
--

INSERT INTO `tbl_vendedor` (`id_usuario`, `usuario`, `tipo_documento_u`, `nombres_u`, `apellidos_u`, `correo`, `password`, `celular`, `direccion`, `barrio`, `fotoPerfil`, `id_rol`) VALUES
(2221, 'Santiago21', 'CC', 'Santi3', 'sss', 'santi1@gmail.com', '$2y$10$1JS097HYR/yfJepirF5dAeZwxo3cW.veXfHP4S81tKHBrApknlKEy', '2221', 'carrera w112c', 313, '1704826885_descarga.jpg', 'Vendedor'),
(2228273, 'Santiago21', 'CC', 'Santiago', 'Vargas', 'santi1656@gmail.com', '$2y$10$BX/LddqK7g/aNkrYRer1BODsy8veq.PTKFUZA45F1VcKhZ9fZlMGW', '2221', NULL, NULL, NULL, 'Vendedor'),
(18273827, 'santiago21', 'CC', 'santiago', 'vargas', 'santi2@gmail.com', '$2y$10$vc5X6dTkbh/grpndE9SaGuFdQIqov8pTjJFQk1QGCcH8sWC0fPasm', '2182738', NULL, NULL, NULL, 'Vendedor'),
(98273612, 'Santiago21', 'CC', 'Santiago', 'vargas', 'santiago2394@gmail.com', '$2y$10$YaCZ9Pw3zsdTKMm1eScDKu/J1FfRweIVA2Ttq2BvDFvKgMg8F8qZe', '2221', NULL, NULL, NULL, 'Vendedor'),
(123452234, 'vendedor', 'CC', 'usuario', 'vendedor', 'usuariovendedor1@gmail.com', '$2y$10$Shl.sVk9v9096Xt5Ta5T2OGg57VaMNty/gRQYm8ZBp2Y9kk4lBDEC', '2938293', NULL, NULL, NULL, 'Vendedor'),
(1034557234, 'Jordan123', 'CC', 'Andres', 'Alvarez', 'andressarrazolaa21@gmail.com', '$2y$10$VL53dpjwSmCep/tlCUb0luAgnpmbyWMfy4Ivyxho6VpElxcUsXWIS', '3245955603', 'carrera 112c', 305, '1704603347_perfil1.png', 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_venta`
--

CREATE TABLE `tbl_venta` (
  `id_venta` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `metodo_pago` varchar(45) NOT NULL,
  `total_compra` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombres_u` varchar(100) NOT NULL,
  `apellidos_u` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `costo_envio` varchar(100) NOT NULL,
  `fecha_compra` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_venta`
--

INSERT INTO `tbl_venta` (`id_venta`, `estado`, `id_compra`, `metodo_pago`, `total_compra`, `id_usuario`, `nombres_u`, `apellidos_u`, `correo`, `direccion`, `costo_envio`, `fecha_compra`) VALUES
(18, 'completado', 518, 'Transferencia Ahorros Bancolombia', '106500', 1234522, 'Santiago', 'Vargas2', 'santiagovargasalvarez8@gmail.com', 'Cra 33 #34-33 apto 43g', '20000', '2024-01-08 23:13:58'),
(19, 'completado', 521, 'Efectivo', '7120660', 87382731, 'Usuario', 'Prueba', 'usuarioprueba1@gmail.com', 'carrera 112c', '20000', '2024-01-12 00:24:15'),
(20, 'completado', 522, 'Efectivo', '14129540', 1234522, 'Santiago', 'Vargas2', 'santiagovargasalvarez8@gmail.com', 'Cra 33 #34-33 apto 43g', '20000', '2024-05-08 18:47:08'),
(21, 'completado', 519, 'Efectivo', '1600000', 1234522, 'Santiago', 'Vargas2', 'santiagovargasalvarez8@gmail.com', 'Cra 33 #34-33 apto 43g', '20000', '2024-01-11 12:15:43'),
(22, 'completado', 520, 'Efectivo', '32767080', 1234522, 'Santiago', 'Vargas2', 'santiagovargasalvarez8@gmail.com', 'Cra 33 #34-33 apto 43g', '20000', '2024-01-11 12:46:38'),
(23, 'completado', 523, 'Efectivo', '4877320', 1234522, 'Santiago', 'Vargas2', 'santiagovargasalvarez8@gmail.com', 'Cra 33 #34-33 apto 43g', '20000', '2024-05-08 18:51:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_administrador`
--
ALTER TABLE `tbl_administrador`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `barrio` (`barrio`);

--
-- Indices de la tabla `tbl_barrio`
--
ALTER TABLE `tbl_barrio`
  ADD PRIMARY KEY (`id_barrio`),
  ADD KEY `id_comuna` (`id_comuna`);

--
-- Indices de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbl_categorias`
--
ALTER TABLE `tbl_categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `tbl_compra`
--
ALTER TABLE `tbl_compra`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `tbl_compra_producto`
--
ALTER TABLE `tbl_compra_producto`
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_comuna`
--
ALTER TABLE `tbl_comuna`
  ADD PRIMARY KEY (`id_comuna`),
  ADD KEY `id_municipio` (`id_municipio`);

--
-- Indices de la tabla `tbl_municipio`
--
ALTER TABLE `tbl_municipio`
  ADD PRIMARY KEY (`id_municipio`);

--
-- Indices de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `nit_identificacion` (`nit_identificacion`),
  ADD KEY `id_sub_categoria` (`id_sub_categoria`);

--
-- Indices de la tabla `tbl_stock`
--
ALTER TABLE `tbl_stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `tbl_sub_categorias`
--
ALTER TABLE `tbl_sub_categorias`
  ADD PRIMARY KEY (`id_sub_categoria`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `nit_identificacion` (`nit_identificacion`);

--
-- Indices de la tabla `tbl_tienda`
--
ALTER TABLE `tbl_tienda`
  ADD PRIMARY KEY (`nit_identificacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `barrio` (`barrio`);

--
-- Indices de la tabla `tbl_vendedor`
--
ALTER TABLE `tbl_vendedor`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `barrio` (`barrio`);

--
-- Indices de la tabla `tbl_venta`
--
ALTER TABLE `tbl_venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_compra` (`id_compra`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=980;

--
-- AUTO_INCREMENT de la tabla `tbl_categorias`
--
ALTER TABLE `tbl_categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `tbl_compra`
--
ALTER TABLE `tbl_compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524;

--
-- AUTO_INCREMENT de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21448;

--
-- AUTO_INCREMENT de la tabla `tbl_stock`
--
ALTER TABLE `tbl_stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `tbl_sub_categorias`
--
ALTER TABLE `tbl_sub_categorias`
  MODIFY `id_sub_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `tbl_tienda`
--
ALTER TABLE `tbl_tienda`
  MODIFY `nit_identificacion` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT de la tabla `tbl_venta`
--
ALTER TABLE `tbl_venta`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_administrador`
--
ALTER TABLE `tbl_administrador`
  ADD CONSTRAINT `tbl_administrador_ibfk_1` FOREIGN KEY (`barrio`) REFERENCES `tbl_barrio` (`id_barrio`);

--
-- Filtros para la tabla `tbl_barrio`
--
ALTER TABLE `tbl_barrio`
  ADD CONSTRAINT `tbl_barrio_ibfk_1` FOREIGN KEY (`id_comuna`) REFERENCES `tbl_comuna` (`id_comuna`);

--
-- Filtros para la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  ADD CONSTRAINT `tbl_carrito_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`),
  ADD CONSTRAINT `tbl_carrito_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuario` (`id_usuario`);

--
-- Filtros para la tabla `tbl_compra_producto`
--
ALTER TABLE `tbl_compra_producto`
  ADD CONSTRAINT `tbl_compra_producto_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `tbl_compra` (`id_compra`),
  ADD CONSTRAINT `tbl_compra_producto_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`);

--
-- Filtros para la tabla `tbl_comuna`
--
ALTER TABLE `tbl_comuna`
  ADD CONSTRAINT `tbl_comuna_ibfk_1` FOREIGN KEY (`id_municipio`) REFERENCES `tbl_municipio` (`id_municipio`);

--
-- Filtros para la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  ADD CONSTRAINT `tbl_productos_ibfk_1` FOREIGN KEY (`nit_identificacion`) REFERENCES `tbl_tienda` (`nit_identificacion`),
  ADD CONSTRAINT `tbl_productos_ibfk_2` FOREIGN KEY (`id_sub_categoria`) REFERENCES `tbl_sub_categorias` (`id_sub_categoria`);

--
-- Filtros para la tabla `tbl_stock`
--
ALTER TABLE `tbl_stock`
  ADD CONSTRAINT `fk_tbl_stock` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_sub_categorias`
--
ALTER TABLE `tbl_sub_categorias`
  ADD CONSTRAINT `tbl_sub_categorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `tbl_categorias` (`id_categoria`),
  ADD CONSTRAINT `tbl_sub_categorias_ibfk_3` FOREIGN KEY (`nit_identificacion`) REFERENCES `tbl_tienda` (`nit_identificacion`);

--
-- Filtros para la tabla `tbl_tienda`
--
ALTER TABLE `tbl_tienda`
  ADD CONSTRAINT `tbl_tienda_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_vendedor` (`id_usuario`);

--
-- Filtros para la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD CONSTRAINT `tbl_usuario_ibfk_1` FOREIGN KEY (`barrio`) REFERENCES `tbl_barrio` (`id_barrio`);

--
-- Filtros para la tabla `tbl_vendedor`
--
ALTER TABLE `tbl_vendedor`
  ADD CONSTRAINT `tbl_vendedor_ibfk_1` FOREIGN KEY (`barrio`) REFERENCES `tbl_barrio` (`id_barrio`);

--
-- Filtros para la tabla `tbl_venta`
--
ALTER TABLE `tbl_venta`
  ADD CONSTRAINT `tbl_venta_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `tbl_compra` (`id_compra`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
