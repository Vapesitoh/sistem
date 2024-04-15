-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2024 at 04:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webturist`
--

-- --------------------------------------------------------

--
-- Table structure for table `comida`
--

CREATE TABLE `comida` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `imagenes` text NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comida`
--

INSERT INTO `comida` (`id`, `titulo`, `imagenes`, `descripcion`, `precio`, `categoria`) VALUES
(26, 'Pollo', 'uploads/65a54c93bbcad_100-platos-que-deberias-comer-antes-de-morir.jpg', 'Costillas a la braza con picante', 5.23, 'Almuerzos'),
(27, 'Pan', 'uploads/65a54cb5d0847_descarga.jpg', 'Pan de desayuno con huevos estrellados', 3.00, 'Desayunos'),
(28, 'Carne', 'uploads/65a54cd4d4b54__105055265_bandejapaisa.jpg', 'Bandeja paisa', 5.10, 'Merienda');

-- --------------------------------------------------------

--
-- Table structure for table `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id` int(11) NOT NULL,
  `imagenes` text NOT NULL,
  `descripcion` text NOT NULL,
  `mascotas` int(11) NOT NULL,
  `banos` int(11) NOT NULL,
  `camas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `habitaciones`
--

INSERT INTO `habitaciones` (`id`, `imagenes`, `descripcion`, `mascotas`, `banos`, `camas`) VALUES
(12, 'uploads/65a54bb7e46fd_WhatsApp Image 2024-01-12 at 10.17.56 AM (1).jpeg', 'Bienvenido a tu santuario de descanso, donde la elegancia se fusiona con la comodidad en esta habitación de hospitalidad única.', 1, 1, 1),
(13, 'uploads/65a54bc89f4f3_WhatsApp Image 2024-01-12 at 10.17.56 AM (2).jpeg', 'Descubre la serenidad en cada rincón de esta acogedora habitación, diseñada para brindarte una experiencia de alojamiento inolvidable.', 1, 1, 2),
(14, 'uploads/65a54be418481_WhatsApp Image 2024-01-12 at 10.17.56 AM.jpeg', 'Un oasis de tranquilidad te espera en esta habitación, donde el confort moderno se encuentra con toques de encanto local para una estancia perfecta.', 1, 2, 3),
(15, 'uploads/65a54bf841f71_WhatsApp Image 2024-01-12 at 10.17.57 AM (1).jpeg', 'Entra en un mundo de lujo discreto en esta habitación, donde la atención a los detalles y la calidez te envuelven desde el momento en que cruzas la puerta.', 1, 1, 1),
(16, 'uploads/65a54c134f6d1_WhatsApp Image 2024-01-12 at 10.17.57 AM (2).jpeg', 'Disfruta de la privacidad y la elegancia en esta habitación, un refugio acogedor donde cada elemento se combina para crear un ambiente único y relajante.', 1, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `informacion`
--

CREATE TABLE `informacion` (
  `id` int(11) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informacion`
--

INSERT INTO `informacion` (`id`, `celular`, `correo`, `direccion`) VALUES
(4, '0993715242', 'bakner@gmail.com', '1'),
(6, '0993715242', 'bakner@gmail.com', 'Provincia Bolivar sector las naves Centro turisco Las Naves');

-- --------------------------------------------------------

--
-- Table structure for table `inicio`
--

CREATE TABLE `inicio` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inicio`
--

INSERT INTO `inicio` (`id`, `titulo`, `texto`, `imagen`, `descripcion`) VALUES
(41, 'Portada del centro turistico', '¡Bienvenidos al Centro Turisitico Las Naves!', 'uploads/65a54de4d0b90_WhatsApp Image 2024-01-12 at 10.34.44 AM (2).jpeg', 'Ven a visitar nuestras instalaciones amigables con el ambiente y con paisajes increibles');

-- --------------------------------------------------------

--
-- Table structure for table `lugares`
--

CREATE TABLE `lugares` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `imagenes` text NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lugares`
--

INSERT INTO `lugares` (`id`, `titulo`, `imagenes`, `descripcion`) VALUES
(12, 'Cascada', 'uploads/65a549db5af1f_WhatsApp Image 2024-01-12 at 10.09.13 AM.jpeg', 'Embárcate en una aventura acuática rodeado de exuberante vegetación y cristalinas aguas en este paraíso de cascadas.'),
(13, 'Cascada 2', 'uploads/65a549fb58c99_WhatsApp Image 2024-01-12 at 10.09.14 AM (1).jpeg', 'La serenidad del entorno se refleja en cada caída de agua, creando un escenario natural que invita a la contemplación y relajación.'),
(14, 'Cascada 3', 'uploads/65a54a1686770_WhatsApp Image 2024-01-12 at 10.09.14 AM (2).jpeg', 'Descubre la magia escondida tras el rugir de las cascadas, un espectáculo visual que cautiva a los visitantes de este mágico rincón.'),
(15, 'Cascada 4', 'uploads/65a54a34c3fcb_WhatsApp Image 2024-01-12 at 10.09.14 AM.jpeg', 'Explora senderos serpenteantes que te conducirán a majestuosas cascadas, fusionando el misterio de la naturaleza con la emoción de la exploración.'),
(16, 'Cascada 5', 'uploads/65a54a47498fc_WhatsApp Image 2024-01-12 at 10.09.15 AM (1).jpeg', 'En este paraíso acuático, cada rincón ofrece una nueva perspectiva, un nuevo deleite visual que captura la esencia de la belleza natural.'),
(17, 'Cascada 6', 'uploads/65a54a6011e04_WhatsApp Image 2024-01-12 at 10.09.15 AM (2).jpeg', 'Sumérgete en la frescura de las aguas que fluyen desde altas cumbres, creando un ballet acuático que hipnotiza a quienes lo contemplan.'),
(18, 'Cascada 7', 'uploads/65a54a86541d6_WhatsApp Image 2024-01-12 at 10.09.15 AM (3).jpeg', 'La armonía entre el sonido relajante del agua y la maravilla visual de las cascadas convierten a este lugar en un oasis para el alma.'),
(19, 'Cascada 8', 'uploads/65a54a9d5d26b_WhatsApp Image 2024-01-12 at 10.09.15 AM (4).jpeg', 'Cascadas que desafían la gravedad, creando cascadas escalonadas que despiertan la admiración de quienes buscan la perfección en la naturaleza.'),
(20, 'Cascada 9', 'uploads/65a54aaf6e59b_WhatsApp Image 2024-01-12 at 10.09.15 AM (5).jpeg', 'Cada cascada cuenta una historia, una historia de tiempo y erosión que ha esculpido este paisaje único, convirtiéndolo en un tesoro natural.'),
(21, 'Cascada 10', 'uploads/65a54abfb7154_WhatsApp Image 2024-01-12 at 10.09.15 AM.jpeg', 'Desde miradores estratégicos, contempla la grandeza de la naturaleza en su máxima expresión, donde el agua y la tierra se abrazan en una danza eterna');

-- --------------------------------------------------------

--
-- Table structure for table `seccion`
--

CREATE TABLE `seccion` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seccion`
--

INSERT INTO `seccion` (`id`, `titulo`, `imagen`, `descripcion`) VALUES
(7, 'Cabaña', 'uploads/65a54d7e6d78a_WhatsApp Image 2024-01-12 at 10.34.42 AM (3).jpeg', 'Una escapada idílica aguarda en esta cabaña acogedora, donde el calor de la madera se combina con vistas panorámicas para una experiencia de retiro inolvidable.');

-- --------------------------------------------------------

--
-- Table structure for table `tarjetas`
--

CREATE TABLE `tarjetas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tarjetas`
--

INSERT INTO `tarjetas` (`id`, `titulo`, `imagen`, `descripcion`) VALUES
(9, '1', 'uploads/65a54d98bf2fe_WhatsApp Image 2024-01-12 at 10.34.43 AM.jpeg', 'Cabaña');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasena`) VALUES
(1, 'admin', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comida`
--
ALTER TABLE `comida`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `informacion`
--
ALTER TABLE `informacion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inicio`
--
ALTER TABLE `inicio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lugares`
--
ALTER TABLE `lugares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comida`
--
ALTER TABLE `comida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `informacion`
--
ALTER TABLE `informacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inicio`
--
ALTER TABLE `inicio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `lugares`
--
ALTER TABLE `lugares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tarjetas`
--
ALTER TABLE `tarjetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
