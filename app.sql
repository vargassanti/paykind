-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-12-2023 a las 06:27:43
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
-- Estructura de tabla para la tabla `tbl_calificacion`
--

CREATE TABLE `tbl_calificacion` (
  `id_calificacion` int(11) NOT NULL,
  `calificacion` varchar(30) NOT NULL,
  `texto` varchar(500) NOT NULL,
  `id_usuario` int(20) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_calificacion`
--

INSERT INTO `tbl_calificacion` (`id_calificacion`, `calificacion`, `texto`, `id_usuario`, `id_producto`) VALUES
(5, '5', '¡Este producto es increíble! Me encanta la calidad y el diseño.', 1234522, 21382),
(6, '4', 'Buena relación calidad-precio. Funciona bien para mis necesidades.', 431293892, 21382),
(7, '3', '¡Este producto es increíble! Me encanta la calidad y el diseño.', 1234522, 21382),
(8, '4', 'Buena relación calidad-precio. Funciona bien para mis necesidades.', 431293892, 21382),
(9, '1', 'Excelente, me encanta.', 431293892, 21382),
(12, '5', 'El sonido es excelente, el micrófono es muy bueno. Ideal para reuniones y trabajo de oficina. Estoy bastante satisfecho con el producto.', 1234522, 21382),
(14, '3', 'hhhhhhhhhhh', 1234522, 21381),
(15, '3', 'HOLAAAAAAAAAAAAAAAAAAAAAAAAAAA', 1234522, 21440),
(16, '2', 'ESTE ES UN COMENTARIO', 1234522, 21429),
(17, '3', 'hhhhhhhhhhh', 1234522, 21434),
(18, '1', 'llllllllll', 1234522, 21434);

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

--
-- Volcado de datos para la tabla `tbl_carrito`
--

INSERT INTO `tbl_carrito` (`id_carrito`, `id_producto`, `cantidad`, `id_stock`, `estado_carrito`, `id_usuario`) VALUES
(865, 21381, 1, '44', 'Pendiente', 1234522),
(866, 21384, 1, '51', 'Pendiente', 1234522),
(867, 21385, 2, '2', 'Pendiente', 1234522),
(868, 21380, 1, '41', 'Pendiente', 1234522),
(869, 21396, 1, '8', 'Pendiente', 1234522),
(870, 21443, 1, '79', 'Pendiente', 1234522),
(871, 21379, 1, '28', 'Pendiente', 1234522),
(872, 21381, 1, '81', 'Pendiente', 1234522),
(873, 21381, 1, '43', 'Pendiente', 1234522),
(874, 21381, 1, '83', 'Pendiente', 1234522),
(875, 21400, 2, '34', 'Pendiente', 1234522),
(876, 21429, 3, '59', 'Pendiente', 1234522),
(877, 21398, 1, '17', 'Pendiente', 1234522),
(878, 21381, 1, '84', 'Pendiente', 1234522),
(879, 21381, 1, '82', 'Pendiente', 1234522),
(880, 21392, 1, '38', 'Pendiente', 1234522);

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
  `imagen_tranferencia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_compra`
--

INSERT INTO `tbl_compra` (`id_compra`, `total_compra`, `direccion`, `costo_envio`, `metodo_pago`, `id_usuario`, `fecha_compra`, `imagen_tranferencia`) VALUES
(480, 8292760, 'Cra 33 #34-33 apto 43g', 20000, 'Efectivo', 1234522, '2023-12-13 10:08:18', ''),
(481, 2263340, 'Cra 33 #34-33 apto 43g', 20000, 'Efectivo', 1234522, '2023-12-13 10:44:58', ''),
(482, 12288600, 'Calle 34b 113 d 81', 20000, 'Efectivo', 8727361, '2023-12-13 14:03:39', ''),
(483, 5088420, 'Calle 34b 113 d 81', 20000, 'Transferencia Ahorros Bancolombia', 8727361, '2023-12-13 15:14:11', '1702498451_Brown Elegant Logo Lawyer Logo.png'),
(484, 3361918, 'Calle 34b 113 d 81', 20000, 'Efectivo', 8727361, '2023-12-13 15:31:35', ''),
(485, 139410, 'Calle 34b 113 d 81', 20000, 'Efectivo', 8727361, '2023-12-13 15:58:18', ''),
(486, 24667500, 'Carrera 133u ac', 20000, 'Efectivo', 4443442, '2023-12-14 11:25:15', ''),
(487, 23604300, 'Cra 33 #34-33 apto 43g', 20000, 'Efectivo', 1234522, '2023-12-14 11:26:09', ''),
(488, 36418500, 'Cra 33 #34-33 apto 43g', 20000, 'Transferencia Ahorros Bancolombia', 1234522, '2023-12-18 09:20:28', '1702909228_1605.m00.i124.n010.S.c12.324488348 Worker health and safety vector illustration.jpg'),
(489, 1589307, 'Cra 33 #34-33 apto 43g', 20000, 'Efectivo', 1234522, '2023-12-18 09:22:26', ''),
(490, 65550, 'Cra 33 #34-33 apto 43g', 20000, 'Transferencia Ahorros Bancolombia', 1234522, '2023-12-18 10:31:05', '1702913465_337430b2-85a9-4ef1-bbc5-cbc362cc3e81.jpg');

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
(480, 21381, 6, 1, 'Completado'),
(480, 21379, 28, 1, 'Completado'),
(480, 21380, 41, 1, 'Completado'),
(481, 21381, 35, 1, 'Completado'),
(482, 21382, 45, 2, 'Completado'),
(482, 21384, 50, 1, 'Completado'),
(482, 21387, 12, 7, 'Completado'),
(482, 21395, 5, 1, 'Completado'),
(482, 21438, 74, 1, 'Completado'),
(483, 21380, 41, 1, 'Completado'),
(483, 21384, 9, 1, 'Completado'),
(484, 21443, 79, 1, 'Cancelado'),
(485, 21441, 77, 1, 'Completado'),
(486, 21391, 29, 1, 'Completado'),
(486, 21398, 17, 7, 'Completado'),
(486, 21399, 16, 1, 'Completado'),
(486, 21439, 75, 1, 'Completado'),
(486, 21395, 5, 1, 'Completado'),
(487, 21399, 16, 3, 'Completado'),
(487, 21392, 38, 2, 'Completado'),
(487, 21440, 76, 2, 'Completado'),
(488, 21391, 29, 1, 'Completado'),
(488, 21386, 39, 2, 'Completado'),
(488, 21394, 7, 1, 'Completado'),
(488, 21395, 5, 1, 'Completado'),
(488, 21393, 4, 1, 'Completado'),
(488, 21396, 8, 1, 'Completado'),
(488, 21398, 17, 1, 'Completado'),
(488, 21399, 16, 2, 'Completado'),
(488, 21430, 61, 2, 'Completado'),
(489, 21429, 59, 1, 'Completado'),
(490, 21434, 67, 1, 'Completado'),
(480, 21381, 6, 1, 'Completado'),
(480, 21379, 28, 1, 'Completado'),
(480, 21380, 41, 1, 'Completado'),
(481, 21381, 35, 1, 'Completado'),
(482, 21382, 45, 2, 'Completado'),
(482, 21384, 50, 1, 'Completado'),
(482, 21387, 12, 7, 'Completado'),
(482, 21395, 5, 1, 'Completado'),
(482, 21438, 74, 1, 'Completado'),
(483, 21380, 41, 1, 'Completado'),
(483, 21384, 9, 1, 'Completado'),
(484, 21443, 79, 1, 'Cancelado'),
(485, 21441, 77, 1, 'Completado'),
(486, 21391, 29, 1, 'Completado'),
(486, 21398, 17, 7, 'Completado'),
(486, 21399, 16, 1, 'Completado'),
(486, 21439, 75, 1, 'Completado'),
(486, 21395, 5, 1, 'Completado'),
(487, 21399, 16, 3, 'Completado'),
(487, 21392, 38, 2, 'Completado'),
(487, 21440, 76, 2, 'Completado'),
(488, 21391, 29, 1, 'Completado'),
(488, 21386, 39, 2, 'Completado'),
(488, 21394, 7, 1, 'Completado'),
(488, 21395, 5, 1, 'Completado'),
(488, 21393, 4, 1, 'Completado'),
(488, 21396, 8, 1, 'Completado'),
(488, 21398, 17, 1, 'Completado'),
(488, 21399, 16, 2, 'Completado'),
(488, 21430, 61, 2, 'Completado'),
(489, 21429, 59, 1, 'Completado'),
(490, 21434, 67, 1, 'Completado');

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
-- Estructura de tabla para la tabla `tbl_factura`
--

CREATE TABLE `tbl_factura` (
  `id_factura` int(11) NOT NULL,
  `fecha_factura` date NOT NULL,
  `cantidad_p` int(5) NOT NULL,
  `precio_total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(21432, 'Camiseta Oversize Oso', 'El modelo mide 1.88 m y tiene una talla L', '89000', 2332321, '1700324009_matt1.png', '1700324009_matt2.png', '1700324009_matt3.png', '1700324009_matt4.png', '1700324009_matt3.png', '1700324009_matt1.png', '', 0, 'Inactivo', 40),
(21433, 'Camiseta Texto', 'La modelo mide 1.64m y tiene una talla S', '17500', 2332321, '1700324374_matt4.png', '1700324374_matt2.png', '1700324374_matt3.png', '1700324374_matt5.png', '1700324374_matt1.png', '1700324374_matt4.png', '', 0, 'Activo', 40),
(21434, 'Camiseta Oversize Ilustración', 'El modelo mide 1.88 m y tiene una talla L', '69000', 2332321, '1700324801_matt1.png', '1700324801_matt2.png', '1700324801_matt3.png', '1700324801_matt4.png', '1700324801_matt5.png', '1700324801_matt6.png', '', 5, 'Activo', 40),
(21435, 'Jeans Straight Fit Carpintero', 'El modelo mide 1.76m y tiene una talla S', '129000', 2332321, '1700325119_matt2.png', '1700325119_matt1.png', '1700325119_matt3.png', '1700325119_matt4.png', '1700325119_matt5.png', '1700325119_matt2.png', '', 0, 'Inactivo', 66),
(21438, 'Camiseta Regular Fit', 'Camiseta en punto de algodón ligero con cuello redondo de ribete acanalado y bajo recto. Corte estándar para una silueta clásica y cómoda.', '17900', 9282913, '1702309426_h&m4.png', '1702309426_h&m3.png', '1702309426_h&m1.png', '1702309426_h&m1.png', '1702309426_h&m4.png', '1702309426_h&m2.png', '', 0, 'Activo', 62),
(21439, 'Camiseta Loose Fit', 'Camiseta en punto de algodón. Modelo de corte holgado con cuello redondo con ribete acanalado.', '50000', 9282913, '1702309663_h&m7.png', '1702309663_h&m6.png', '1702309663_h&m5.png', '1702309663_h&m8.png', '1702309663_h&m6.png', '1702309663_h&m7.png', '', 0, 'Activo', 62),
(21440, 'Camiseta Loose Fit', 'Camiseta en punto de algodón. Modelo de corte holgado con cuello redondo de ribete acanalado.', '50000', 9282913, '1702309946_h&m13.png', '1702309946_h&m9.png', '1702309946_h&m10.png', '1702309946_h&m11.png', '1702309946_h&m12.png', '1702309946_h&m14.png', '', 10, 'Inactivo', 62),
(21441, 'Joggers', 'Joggers en denim rígido de algodón. Modelo de corte holgado de caderas a bajos con piernas redondeadas amplias y tiro bajo. Tiro medio con elástico revestido y cordón de ajuste oculto, cierre decorativo, bolsillos laterales, bolsillos de parche con tapa en las piernas y bolsillos traseros. Todo lo que necesitas para lucir un look denim impactante.', '154900', 9282913, '1702310248_h&m18.png', '1702310248_h&m15.png', '1702310248_h&m16.png', '1702310248_h&m17.png', '1702310248_h&m19.png', '1702310248_h&m16.png', '', 10, 'Activo', 66),
(21442, 'Joggers', 'Joggers en denim rígido de algodón. Modelo de corte holgado de caderas a bajos con piernas redondeadas amplias y tiro bajo. Tiro medio con elástico revestido y cordón de ajuste oculto, cierre decorativo, bolsillos laterales, bolsillos de parche con tapa en las piernas y bolsillos traseros. Todo lo que necesitas para lucir un look denim impactante.', '154900', 9282913, '1702310565_h&m22.png', '1702310565_h&m20.png', '1702310565_h&m21.png', '1702310565_h&m23.png', '1702310565_h&m24.png', '1702310565_h&m22.png', '', 0, 'Activo', 66),
(21443, 'Samsung Galaxy S23 Ultra ', 'Descubre infinitas posibilidades para tus fotos con las 4 cámaras principales de tu equipo. Pon a prueba tu creatividad y juega con la iluminación, diferentes planos y efectos para obtener grandes resultados.\r\n', '4099900', 76676, '1702311949_sm1.png', '1702311949_sm2.png', '1702311949_sm3.png', '1702311949_sm1.png', '1702311949_sm2.png', '1702311949_sm1.png', '', 18, 'Inactivo', 70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_restablecer_contraseña`
--

CREATE TABLE `tbl_restablecer_contraseña` (
  `id_restablecer` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expiration_time` datetime DEFAULT NULL,
  `used` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_restablecer_contraseña`
--

INSERT INTO `tbl_restablecer_contraseña` (`id_restablecer`, `id_usuario`, `token`, `expiration_time`, `used`) VALUES
(2, 1234522, 'c39404021c743650438526db72fdca8d', '2023-10-27 22:39:48', 0),
(3, 1234522, '552215876ff431eec573032cbc337d8a', '2023-10-27 22:40:46', 0),
(4, 1234522, 'a8aff678f55689b74c35739a7baabfae', '2023-10-27 22:48:25', 0),
(5, 1234522, '2362d4e26a4648f19c6d11b4ea205592', '2023-10-27 22:48:50', 0),
(6, 1234522, 'c3e7a8ea65e72b79f52467feaff2bde3', '2023-10-27 22:49:52', 0),
(7, 1234522, 'ee6e5b10d596289252d94e628b9e29e8', '2023-10-27 23:01:19', 1),
(8, 1234522, '4abe980ed6d9764550ddd32000bcc146', '2023-10-27 23:02:07', 1),
(9, 1234522, '33a29ae225c0f679ddfd87020368a33b', '2023-10-27 23:04:12', 1),
(10, 1234522, '6a507eee77f282321340f0d08521a4d4', '2023-10-27 23:29:40', 0),
(11, 1234522, 'df75d1abe90920a606b66ce4a5cd8c52', '2023-10-27 23:30:20', 0),
(12, 1234522, '4a57355de4165b9602132cd04116ab32', '2023-10-27 23:47:55', 0),
(13, 1234522, '7e868faf29189302de15dec7d9dcc4ac', '2023-10-27 23:48:05', 0),
(14, 1234522, 'a2cde3141a0dba349e5374f8c2a2cf2c', '2023-10-27 23:52:07', 0),
(15, 1234522, '89e37836956573b401d692f24f9c82aa', '2023-10-27 23:52:14', 0),
(16, 1234522, 'bfe81a790f968075e112ec86698e481f', '2023-10-27 23:52:39', 0),
(17, 1234522, '14ede7c6f0d36c9616a3dee5092bceed', '2023-10-27 23:53:11', 0),
(18, 1234522, '801ba2be12837e1beb6d3df7869d2de8', '2023-10-27 23:53:20', 0),
(19, 1234522, 'c5e7914c9fd98bcab3f252eb01e8a689', '2023-10-27 23:53:27', 0),
(20, 1234522, 'ad43e18cd31859f54144dba8988d601c', '2023-10-27 23:53:34', 0),
(21, 1234522, '0ea41a7e0542cf3e35aa673fab6e84d3', '2023-10-27 23:53:44', 0),
(22, 1234522, 'd610b976d697a726f0eb1f95cc865600', '2023-10-27 23:54:04', 1),
(23, 1234522, '568fbc7176f65d42f970e85c3e016eba', '2023-10-27 23:54:30', 1),
(24, 1234522, '13d8698dc995cf679435fb1acecdb153', '2023-10-27 23:58:05', 1),
(25, 1234522, '0c1b26dfa4e66c661de372e8776aeecb', '2023-10-27 23:59:04', 1),
(26, 1234522, '81e16a3fe694ac9c45ac5e4679020caf', '2023-10-28 00:00:50', 0),
(27, 1234522, '83fdbc3de926b2fd5c665c85159e8b21', '2023-10-28 00:09:12', 0),
(28, 1234522, '2b2e0ccefcd7ec89623cddf8f1797738', '2023-10-28 00:09:21', 0),
(29, 1234522, '745e76b460183e305081eed4b9d6b87a', '2023-10-28 00:09:34', 0),
(30, 1234522, '2e3e768fbe12ce4a13b250501afdae59', '2023-10-28 20:23:50', 0),
(31, 1234522, '1fa1a3fb7cb0973f13dbefa52471b1a0', '2023-10-28 20:23:56', 0),
(32, 1234522, '51016672e5b5b4ae007a99812be01896', '2023-10-28 20:27:52', 0),
(33, 1234522, '2efcb0e4f55a89474ef8d8cedc12fd91', '2023-10-28 20:30:50', 0),
(34, 1234522, '4708d4b8cf2170d5c0eca664e002abbf', '2023-10-28 20:33:28', 0),
(35, 1234522, '19ac8c4018e4eb29bc9051bc34f8cb49', '2023-10-28 20:36:52', 0),
(36, 1234522, 'f39e12149c69fc8a05e6fb0e8f3166b6', '2023-10-28 20:39:24', 0),
(37, 1234522, '3613829e7dac94c5df274ea8e81960e2', '2023-10-28 20:40:13', 0),
(38, 1234522, '1240e12f68b9901012e529941c7fad95', '2023-10-28 20:47:49', 0),
(39, 1234522, '32765cc79f7972470815e5e039162d37', '2023-10-28 20:49:45', 0),
(40, 1234522, 'd3f3848f6300b29d618fe059872eb208', '2023-10-28 20:50:19', 0),
(41, 1234522, 'dec15f8575c2a70e72b4015f5d2e5f45', '2023-10-28 20:50:53', 0),
(42, 1234522, '0caf1a4ac09ee22aac6218e5412a6305', '2023-10-28 20:53:48', 0),
(43, 1234522, '3466adf081444048c1b0c1a3905d57be', '2023-10-28 20:55:13', 0),
(44, 1234522, '8f0809836c0d0e9fe9669e339bd8ab7e', '2023-10-28 20:56:23', 0),
(45, 1234522, 'ac5a3457cb22e7456f19e3761fa0697f', '2023-10-28 20:58:45', 0),
(46, 1234522, '49c59835b3dc1f0ce5d576ecfaef3812', '2023-10-28 20:59:45', 0),
(47, 1234522, 'ec4edee0f1ef0a4cbdda1e01825025e7', '2023-10-28 21:01:13', 0),
(48, 1234522, '86fc8c4a8159bfa6ae4bac252c29a484', '2023-10-28 21:02:41', 0),
(49, 1234522, 'b6b13611e129414f5acecd2de0b56837', '2023-10-28 21:04:21', 0),
(50, 1234522, '45f03e205366e6d92f741a9f948a6a3f', '2023-10-28 21:04:50', 0),
(51, 1234522, 'dcae5393011940a788eb52bb7615f3a1', '2023-10-28 21:05:55', 0),
(52, 1234522, '145a9e5c6e0d1efc5604ee63a238831f', '2023-10-29 01:40:54', 0),
(53, 1234522, 'e80ae9578e78414b8837dcba9f59085a', '2023-10-29 01:42:06', 0),
(54, 1234522, '54bed3b7e8188c484bb075084a33efb8', '2023-10-29 01:42:44', 0),
(55, 1234522, '979e38e286ef5d17efc4089ebbef367d', '2023-10-29 01:43:26', 0),
(56, 1234522, '8051619a1d5621fefca62e3789951ae7', '2023-10-29 01:44:11', 0),
(57, 1234522, '6b4eab447faa896196d7913d468a91a5', '2023-10-29 01:45:45', 0),
(58, 1234522, '931588eb8b0062ea51c09dd3b71fe22a', '2023-10-29 01:47:55', 0),
(59, 1234522, '6aafac729c2aee93f14b9cb9200903f5', '2023-10-29 01:48:19', 0),
(60, 1234522, '519c7438982bdd5d0c764431e23f9edf', '2023-10-29 01:49:28', 0),
(61, 1234522, '4daffd22f777d3fadcab696797854774', '2023-10-29 01:49:43', 0),
(62, 1234522, '0114da3174e07c048ef49285dfa99400', '2023-10-29 01:58:55', 0),
(63, 1234522, '022581ae3f426855255feb9f35ba015d', '2023-10-29 01:59:38', 0),
(64, 1234522, '1bf2125f6511a44cb48a3f56422a38cc', '2023-10-29 02:00:20', 0),
(65, 1234522, '313bbc14a21e709618fa11544d45bd43', '2023-10-29 02:00:38', 0),
(66, 1234522, '8282047355ca0cf9836146b1747359b9', '2023-10-29 02:00:49', 0),
(67, 1234522, '4750dc44d9a9b8d1ca642ac2b911683f', '2023-10-29 02:01:28', 0),
(68, 1234522, '9236eb0b1e657a73e1332b3a144918df', '2023-10-29 02:01:57', 0),
(69, 1234522, 'beb514ccab8601b5139c35ba13fcb31e', '2023-10-29 02:02:28', 0),
(70, 1234522, 'd0fb93f648fb30270e9eb9f35dda054a', '2023-10-29 02:06:22', 0),
(71, 1234522, '8968cf76d9954ce5d0d4e1c829667fb1', '2023-10-29 02:06:58', 0),
(72, 1234522, 'c61a55e6b40aadf9c2917d4ab677f513', '2023-10-29 02:07:22', 1),
(73, 1234522, 'ba7aecdd35921f7f903cae58047ef2b9', '2023-10-29 02:16:43', 0),
(74, 1234522, '601e44babee21d809b2eaa0340bc3910', '2023-10-29 02:17:25', 0),
(75, 1234522, '112b2143dd3d1bc2ec4ca12cbacd63cc', '2023-10-29 02:17:58', 0),
(76, 1234522, '65d00282f84e2a19eea9c1b72fa28d8d', '2023-10-29 02:19:07', 0),
(77, 1234522, 'cb1c6e2f666dca6f2a06a8daf3eaf87f', '2023-10-29 02:20:08', 0),
(78, 1234522, '0eadacdfa093e88819500a70affb7c32', '2023-10-29 02:21:09', 0),
(79, 1234522, '567faff18113661b7e7792653d1bca24', '2023-10-29 02:24:11', 0),
(80, 1234522, 'd401c67ea0c1da7f4cfbb6ea46e821f2', '2023-10-29 02:25:13', 0),
(81, 1234522, '03c2d9588c7a891be02f84f9bd448bf0', '2023-10-29 02:25:24', 0),
(82, 1234522, '81a165f4e92397923db144412bc2e875', '2023-10-29 02:26:55', 0),
(83, 1234522, '535774cac7258e9eea9d3ec97a1ef9b8', '2023-10-29 02:27:50', 0),
(84, 1234522, '503b9340c9388d6b4a37d3b646068a62', '2023-10-29 02:30:15', 0),
(85, 1234522, 'ac7c838b756d294cf378d5b887f43a8f', '2023-10-29 02:31:40', 0),
(86, 1234522, '55cbd702724eccebbb1336fe999603fd', '2023-10-29 02:31:59', 0),
(87, 1234522, '6e1af3788ea772729a66e2a749319ee0', '2023-10-29 02:32:51', 0),
(88, 1234522, 'b68ef1abfd92b82014fc5fb7b9fec89f', '2023-10-29 02:35:31', 0),
(89, 1234522, '947418adc2aa1dde9e004ea1f4e5795c', '2023-10-29 02:37:51', 0),
(90, 1234522, '92e44c30d85ca886fdd6a3a298a9010c', '2023-10-29 02:38:11', 0),
(91, 1234522, 'e506cd31f6787dcfdfbf037660531af4', '2023-10-29 02:43:19', 0),
(92, 1234522, '16bc08372db02e063af96dd60eb88d12', '2023-10-29 02:46:21', 1),
(93, 1234522, '767dc815e1347f6775e7bb9ae754eb33', '2023-10-29 02:47:37', 0),
(94, 1234522, 'cfe3f1b69e1dcb31b76955352fad1a52', '2023-10-29 02:48:17', 1),
(95, 1234522, '7e5ab0bcf66bb8df2943c35562e22662', '2023-10-29 02:51:20', 0),
(96, 1234522, 'd8c983943c36b50cb71cb54eb154bf06', '2023-10-29 03:13:06', 0),
(97, 1234522, '20f81b4ebe413fbc04774a4a9a8ba717', '2023-10-29 03:14:55', 1),
(98, 1234522, '3e82556241bfc3ad1c83691de123cdce', '2023-10-29 03:26:13', 0),
(99, 1234522, 'abbc6d7ee0c6f4b38b1286b75e4dee74', '2023-10-29 03:30:09', 0),
(100, 1234522, '9a2c95b33eda688800664bdf8d9ae62e', '2023-10-29 03:31:14', 0),
(101, 1234522, '6ac0f849a5fbc2869918cdd063cb312b', '2023-10-29 03:33:42', 0),
(102, 1234522, 'b18518a908a55a480af4fe73597c162d', '2023-10-29 03:33:51', 0),
(103, 1234522, '551cfc8afbb27338edf203484e523691', '2023-10-29 03:34:07', 0),
(104, 1234522, 'cf3d26baddfa898070f607bad3b129ca', '2023-10-29 03:34:26', 0),
(105, 1234522, 'b2bec614259224678981328f9993d542', '2023-10-29 03:34:36', 0),
(106, 1234522, '58553c29c9d41cb8df624008cce50696', '2023-10-29 03:35:26', 0),
(107, 1234522, '4d8c750b59fdb7c75c83899279442661', '2023-10-29 03:37:49', 0),
(108, 1234522, '1c8e1b5014b5c8e3794523d9ff6ed6ad', '2023-10-29 03:39:36', 0),
(109, 1234522, '753ac6c0f0cfeaeb754cbffdddc68007', '2023-10-29 03:40:05', 0),
(110, 1234522, 'abbc86786f3687938413c5865edbd1ed', '2023-10-29 03:41:42', 0),
(111, 1234522, '48fc116867488d7be38102d7edcf5210', '2023-10-29 03:43:17', 0),
(112, 1234522, '669e42dc5cd634029a43a325ba85eaa9', '2023-10-29 03:43:20', 0),
(113, 1234522, 'af0b30a1c4ba1a0df130d11b04e98af3', '2023-10-29 03:44:15', 0),
(114, 1234522, '6cbac228f9af86f46ee84f31c2192fa1', '2023-10-29 03:44:27', 0),
(115, 1234522, '1ba4690c51c4a7330664521c02e4117e', '2023-10-29 03:45:46', 0),
(116, 1234522, 'a048e6116df7c0685ac7121bcec01d6f', '2023-10-29 03:46:50', 0),
(117, 1234522, 'e2fff2eb64afa991b4ed3ecc205ec254', '2023-10-29 03:47:00', 0),
(118, 1234522, 'b6326854e8690c5acd345f48860a2f36', '2023-10-29 03:47:11', 0),
(119, 1234522, '54ae37ebca4af3e8a5922ce4720e6358', '2023-10-29 03:15:04', 0),
(120, 1234522, '74d9e09de413da3e3926c5f4ef1eff33', '2023-10-29 03:15:29', 0),
(121, 1234522, 'c5bc729ffd1c8dcf387e3d3b2a577274', '2023-10-29 03:15:29', 1),
(122, 1234522, 'b4ed67d0bda6e3b136b72ab95be3b75b', '2023-10-29 06:10:14', 1),
(123, 1234522, 'c151effd14ba0af340c20117e4bed965', '2023-10-29 06:10:46', 1),
(124, 1234522, 'd5e7d1fd03b97d22ce66a05ec58a997a', '2023-10-29 06:12:30', 1),
(125, 1234522, '6e710947735eae2ea0b3b17ac38ee859', '2023-10-29 06:12:55', 1),
(126, 1234522, '62f8ffe227d72829ef538100dfc0ef1a', '2023-10-29 06:17:15', 1);

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
(2, 21385, 10, '2023-10-26 09:12:18', '#58ED4A'),
(3, 21382, 19, '2023-10-26 09:12:18', '#CE4AED'),
(4, 21393, 10, '2023-10-26 09:12:18', '#F53B56'),
(5, 21395, 12, '2023-10-26 09:12:18', '#76EFF4'),
(6, 21381, 12, '2023-10-26 09:12:18', 'blue'),
(7, 21394, 23, '2023-10-26 09:12:18', '#fc580c'),
(8, 21396, 33, '2023-10-26 09:12:18', '#3B60F5'),
(9, 21384, 40, '2023-10-26 09:12:18', '#D60006'),
(10, 21383, 100, '2023-10-26 09:12:18', '#3B60F5'),
(12, 21387, 50, '2023-10-26 09:12:18', '#3B60F5'),
(13, 21392, 5, '2023-10-26 09:12:18', '#F5DC0F'),
(14, 21400, 100, '2023-10-26 09:12:18', '#3B60F5'),
(15, 21380, 33, '2023-10-26 09:12:18', '#0032FF'),
(16, 21399, 12, '2023-10-26 09:12:18', '#3B60F5'),
(17, 21398, 21, '2023-10-26 09:12:18', '#000'),
(18, 21397, 43, '2023-10-26 09:12:18', 'black'),
(19, 21386, 351, '2023-10-26 09:12:18', '#0FB1F5'),
(20, 21379, 16, '2023-10-26 09:12:18', 'blue'),
(28, 21379, 30, '2023-10-26 09:12:18', 'green'),
(29, 21391, 21, '2023-10-26 08:59:19', 'red'),
(31, 21391, 30, '2023-10-26 08:59:19', 'green'),
(34, 21400, 222, '2023-11-09 19:59:45', 'red'),
(37, 21383, 100, '2023-10-26 09:12:18', '#F576D0'),
(38, 21392, 56, '2023-10-26 09:12:18', '#F42301'),
(39, 21386, 31, '2023-10-26 09:12:18', '#9C00FC'),
(40, 21380, 20, '2023-10-26 09:12:18', '#000000'),
(41, 21380, 7, '2023-10-26 09:12:18', '#00DDAE'),
(42, 21380, 20, '2023-10-26 09:12:18', '#DD0000'),
(43, 21381, 32, '2023-11-09 20:03:18', '#DD0000'),
(44, 21381, 89, '2023-11-09 20:03:18', '#FFD800'),
(45, 21382, 30, '2023-10-26 09:12:18', '#FFD800'),
(46, 21382, 20, '2023-10-26 09:12:18', '#0078FF'),
(47, 21383, 100, '2023-10-26 09:12:18', '#000000'),
(48, 21383, 99, '2023-10-26 09:12:18', '#D800FF'),
(49, 21383, 100, '2023-10-26 09:12:18', '#46FF00'),
(50, 21384, 40, '2023-10-26 09:12:18', '#000000'),
(51, 21384, 40, '2023-10-26 09:12:18', '#00FFCD'),
(59, 21429, 100, '2023-11-14 10:28:52', '#7fff00'),
(60, 21430, 100, '2023-11-14 10:37:37', '#ff6347'),
(61, 21430, 2, '2023-11-14 10:41:08', '#8a2be2'),
(62, 21430, 222, '2023-11-14 10:49:20', '#000000'),
(63, 21431, 208, '2023-11-14 11:09:36', '#8a2be2'),
(64, 21431, 33, '2023-11-14 11:16:36', '#888'),
(65, 21432, 99, '2023-11-18 10:13:29', '#000000'),
(66, 21433, 12, '2023-11-18 10:19:34', '#d2b48c'),
(67, 21434, 200, '2023-11-18 10:26:41', '#ff7f50'),
(68, 21435, 20, '2023-11-18 10:31:59', '#000000'),
(69, 21431, 2334, '2023-12-06 13:56:53', '#ff6347'),
(70, 21431, 4, '2023-12-06 13:57:46', '#adff2f'),
(71, 21431, 19, '2023-12-06 13:58:12', '#cd5c5c'),
(72, 21431, 23, '2023-12-06 13:58:25', '#d8bfd8'),
(73, 21431, 100, '2023-12-06 13:58:36', '#cd853f'),
(74, 21438, 19, '2023-12-11 10:43:46', '#1e90ff'),
(75, 21439, 109, '2023-12-11 10:47:43', '#000000'),
(76, 21440, 234, '2023-12-11 10:52:26', '#ffefd5'),
(77, 21441, 100, '2023-12-11 10:57:28', '#9370db'),
(78, 21442, 91, '2023-12-11 11:02:45', '#000000'),
(79, 21443, 32, '2023-12-11 11:25:49', '#000000'),
(81, 21381, 21212, '2023-12-15 14:40:17', '#8b4513'),
(82, 21381, 8, '2023-12-15 14:45:34', '#ff4500'),
(83, 21381, 69, '2023-12-15 14:47:27', '#cd853f'),
(84, 21381, 667, '2023-12-15 14:48:12', '#9370db'),
(88, 21397, 20, '2023-12-18 09:10:18', '#cd853f'),
(89, 21397, 32, '2023-12-18 09:11:03', '#7fffd4'),
(90, 21432, 100, '2023-12-18 09:31:33', '#008b8b'),
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
(1111, 'SantiagoV21', 'CC', 'Santiago ', 'Vargas Alvarez', 'admin21@gmail.com', '$2y$10$IO2jBBb2ecO5oM2E4pW6su5.TDNsvC2laDls2Bb9aF6OjlPQkbsQW', '2121', 'carrera 122c 34b 13', 211, '1701896424_md_5b321c98efaa6.jpg', 'Administrador'),
(10292, 'kaja', 'CC', 'jasjdjhajj', 'ssssssssssssssssss', 'santi123@gmail.com', '$2y$10$YwZ1hH9pob5xAxYaaRuXLubutg30mznnaQKhjYc/m6EY48xn9b5Yy', '882828', NULL, NULL, NULL, 'Administrador'),
(1234522, 'santi21', 'CC', 'Santiaguito', 'Vargas', 'santiagovargasalvarez8@gmail.com', '$2y$10$kyaQHY/7rFWjGsWTABX.NuvkEArv2UblEvc/UMmPSMbVs88gqQCZ2', '28128192', 'Cra 33 #34-33 apto 43g', 58, '1699160667_foto_perfil.png', 'Cliente'),
(4443442, 'esteban1', 'CC', 'esteban', 'lopere', 'santi1w23e@gmail.com', '$2y$10$SBc85A5f4QjxxTDpABaISeOwf6v2na5lf0c.zu1zfSAzWSlJYdRkW', '232323', 'Carrera 133u ac', 120, NULL, 'Cliente'),
(8727361, 'esteban1', 'CC', 'esteban', 'lopere', 'estebanlopere13@gmail.com', '$2y$10$b15QObPYoM.lxmGDCNvL.OtsQSURW1/0f5j/tOc47HJZ3Rz.iZ5vu', '232323', 'Calle 34b 113 d 81', 191, NULL, 'Cliente'),
(431293892, 'Mateito', 'CC', 'Mateo', 'Reyes ', 'mateoreyes15@gmail.com', '$2y$10$zi0qyRQy27vpdtlk1GCLHulzxFNOAJKMlbvqJRGbGZN0Z5REPeT.a', '3029301821', 'carrera q12', 356, NULL, 'Cliente'),
(1020550666, 'Jeronimo', 'CC', 'Jeronimo', 'Vargas', 'jerovargasalvarez21@gmail.com', '$2y$10$kAAxvsCO8pqCBTY6DjvR.e5UVrEUScbebTYvVwoELzCCD5GnDsJoe', '392829282', NULL, NULL, NULL, 'Cliente'),
(2147483647, 'sasasaw', 'CC', 'Esteban', 'Vargas', 'santi1223@gmail.com', '$2y$10$ztTJ/y5kRQ8k66AWIE/VBefnSDgyOqsB3zRtmZcGdsIlWXGkHb0Pi', '21132313', NULL, NULL, NULL, 'Cliente');

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
(112, '111', 'TI', '2sssssss', 'ss', 'lopreesteba22n@gmailcom', '$2y$10$04UK8N0a5ueyi2MUbuqwfu7a/1JgMrZV2ZD4Pw.knQjSmPJL0B0KW', '1', NULL, 1, NULL, 'Vendedor'),
(2221, 'Santiago21', 'CC', 'Santi', 'sss', 'santi1@gmail.com', '$2y$10$1JS097HYR/yfJepirF5dAeZwxo3cW.veXfHP4S81tKHBrApknlKEy', '2221', 'carrera w112c', 313, '1699160339_ab92edaadf5ced342055ac1ce79f6a2c.jpg', 'Vendedor'),
(12323, 'sad', 'TI', 'Esteban', 'Vargas', 'santi122212@gmail.com', '$2y$10$ILfbA6uudMU4yP9HrlyonuGUjAIhn5KdccHHDhbdxm8oYLWWsLaWq', '3123', NULL, NULL, NULL, 'Vendedor'),
(212121, 'qqq', 'TI', 'Santiago', 'ssssssssssssssssss', 'santi34@gmail.com', '$2y$10$/Cz0r9jYrCxtn00aqnQ/lu1hyjtkTAVdUkwa9vcZMLPOlykrRfh0S', 'qqqq', NULL, 1, NULL, 'Vendedor'),
(9891821, 'Esteb', 'CC', 'Esteban', 'Vargas', 'lopreesteban4323@gmail.com', '$2y$10$PB62JcA0fQZSuUdAUgHCROBZEk.k9q6Wbsq43UjkQGtpYMgBJYRR2', '28712922', NULL, NULL, NULL, 'Vendedor'),
(13214313, 'esteban1', 'TI', 'esteban', 'lopere', '4r41f@gmail.com', '$2y$10$b71fo3AxpETn3ioHlBrlpeiBDlpiG1HtJzyySMTP5Y747uDph1wH.', '232323', NULL, NULL, NULL, 'Vendedor'),
(22233323, 'santas', 'CC', 'Santiago', 'wwww', 'wwwwwwwwwwwww@gmail.com', '$2y$10$2DvbKKgVQ2IBdJZviRHo5.UvVFJFR4WYvr77ICahPqOyvxEOFCJWG', '22222222222', NULL, NULL, NULL, 'Vendedor'),
(1017122543, 'esteban1', 'CC', 'esteban', 'lopere', 'estebanlopere1@gmail.com', '$2y$10$.kXw/.rYN5npl19jGoYN2eyqJgBuvPjg8AR6HNaeb8ZYvWZuwoGIi', '232323', 'fsee', NULL, '1700746658_05.jpg', 'Vendedor'),
(1017122545, 'esteban', 'CC', 'Esteban', 'Lopera Olaya', 'lopreesteban@gmail.com', '$2y$10$ozcmVJIqtJKRNE3feu9cke5B2DgyclExRVurJyapEn7Emdie6AP/O', '3005458283', NULL, 1, NULL, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_venta`
--

CREATE TABLE `tbl_venta` (
  `id_venta` int(11) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_barrio`
--
ALTER TABLE `tbl_barrio`
  ADD PRIMARY KEY (`id_barrio`),
  ADD KEY `id_comuna` (`id_comuna`);

--
-- Indices de la tabla `tbl_calificacion`
--
ALTER TABLE `tbl_calificacion`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

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
-- Indices de la tabla `tbl_factura`
--
ALTER TABLE `tbl_factura`
  ADD PRIMARY KEY (`id_factura`);

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
-- Indices de la tabla `tbl_restablecer_contraseña`
--
ALTER TABLE `tbl_restablecer_contraseña`
  ADD PRIMARY KEY (`id_restablecer`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_compra` (`id_compra`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_calificacion`
--
ALTER TABLE `tbl_calificacion`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=881;

--
-- AUTO_INCREMENT de la tabla `tbl_categorias`
--
ALTER TABLE `tbl_categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `tbl_compra`
--
ALTER TABLE `tbl_compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;

--
-- AUTO_INCREMENT de la tabla `tbl_factura`
--
ALTER TABLE `tbl_factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_productos`
--
ALTER TABLE `tbl_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21444;

--
-- AUTO_INCREMENT de la tabla `tbl_restablecer_contraseña`
--
ALTER TABLE `tbl_restablecer_contraseña`
  MODIFY `id_restablecer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT de la tabla `tbl_stock`
--
ALTER TABLE `tbl_stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

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
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_barrio`
--
ALTER TABLE `tbl_barrio`
  ADD CONSTRAINT `tbl_barrio_ibfk_1` FOREIGN KEY (`id_comuna`) REFERENCES `tbl_comuna` (`id_comuna`);

--
-- Filtros para la tabla `tbl_calificacion`
--
ALTER TABLE `tbl_calificacion`
  ADD CONSTRAINT `fk_tbl_producto_id` FOREIGN KEY (`id_producto`) REFERENCES `tbl_productos` (`id_producto`) ON DELETE CASCADE;

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
-- Filtros para la tabla `tbl_restablecer_contraseña`
--
ALTER TABLE `tbl_restablecer_contraseña`
  ADD CONSTRAINT `tbl_restablecer_contraseña_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuario` (`id_usuario`);

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
  ADD CONSTRAINT `tbl_venta_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `tbl_factura` (`id_factura`),
  ADD CONSTRAINT `tbl_venta_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `tbl_compra` (`id_compra`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
