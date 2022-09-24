-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 24, 2022 at 08:56 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ejercicio`
--

-- --------------------------------------------------------

--
-- Table structure for table `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL COMMENT 'CONSECUTIVO DE TABLA',
  `tabla_id` int(11) DEFAULT NULL COMMENT 'CONSECUTIVO PARA OPERADORES (VERIFICACION)',
  `id_proveedor` int(11) NOT NULL COMMENT 'ID DEL PROVEEDOR CON EL QUE SE REALIZÓ LA COMPRA (FOREIGN KEY)',
  `id_producto` int(11) NOT NULL COMMENT 'ID DEL PRODUCTO ADQUIRIDO (FOREIGN KEY)',
  `fecha_pedido` datetime NOT NULL COMMENT 'FECHA DE PEDIDO',
  `fecha_factura` datetime DEFAULT NULL COMMENT 'FECHA DE FACTURACION',
  `importe` decimal(19,4) NOT NULL COMMENT 'IMPORTE DE LA COMPRA',
  `no_pedido` int(11) NOT NULL COMMENT 'NUMERO DE PEDIDO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `compras`
--

INSERT INTO `compras` (`id`, `tabla_id`, `id_proveedor`, `id_producto`, `fecha_pedido`, `fecha_factura`, `importe`, `no_pedido`) VALUES
(1, 1, 1, 1, '2022-09-23 01:41:43', '2022-09-23 01:41:43', '9990.0000', 1),
(5, 5, 2, 5, '2022-09-24 18:04:16', '2022-09-24 18:04:16', '4950.0000', 3);

-- --------------------------------------------------------

--
-- Table structure for table `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL COMMENT 'CONSECUTIVO DE TABLA',
  `tabla_id` int(11) DEFAULT NULL COMMENT 'CONSECUTIVO PARA OPERADORES (VERIFICACION)',
  `nombre` varchar(50) NOT NULL COMMENT 'NOMBRE DEL EMPLEADO',
  `apellidos` varchar(50) NOT NULL COMMENT 'APELLIDOS DEL EMPLEADO',
  `direccion` varchar(255) NOT NULL COMMENT 'DIRECCION DEL EMPLEADO',
  `telefono` varchar(10) NOT NULL COMMENT 'TELEFONO DEL EMPLEADO',
  `correo` varchar(50) NOT NULL COMMENT 'CORREO DEL EMPLEADO',
  `desactivado` tinyint(1) DEFAULT NULL COMMENT 'INDICA SI EL EMPLEADO ESTA DESACTIVADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `empleados`
--

INSERT INTO `empleados` (`id`, `tabla_id`, `nombre`, `apellidos`, `direccion`, `telefono`, `correo`, `desactivado`) VALUES
(1, 1, 'Humberto', 'Nieva', 'La dirección va aqui', '1234567890', 'admin@admin.com', NULL),
(8, 8, 'Juan', 'Perez', 'Calle 1', '1123113', 'empleado@empleado.com', 0),
(12, 12, 'MATEO', 'GARCIA MORA', 'Lomas de Anahuac 70C Morelia Michoacan 58210', '4432795470', 'mateo.gm@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL COMMENT 'CONSECUTIVO DE TABLA',
  `tabla_id` int(11) DEFAULT NULL COMMENT 'CONSECUTIVO PARA OPERADORES (VERIFICACION)',
  `codigo` varchar(255) NOT NULL COMMENT 'CÓDIGO DEL PRODUCTO',
  `marca` varchar(100) DEFAULT NULL COMMENT 'MARCA DEL PRODUCTO',
  `estado` enum('bueno','dañado','baja') NOT NULL COMMENT 'ESTADO DEL PRODUCTO',
  `categoria` varchar(30) DEFAULT NULL COMMENT 'CATEGORÍA DEL PRODUCTO',
  `precio` decimal(19,4) NOT NULL COMMENT 'PRECIO DEL PRODUCTO',
  `existencia` int(4) DEFAULT NULL COMMENT 'EXISTENCIA DEL PRODUCTO',
  `id_empleado` int(11) NOT NULL COMMENT 'ID DEL EMPLEADO AL QUE ESTÁ ASIGNADO EL PRODUCTO (FOREIGN KEY)',
  `id_proveedor` int(11) NOT NULL COMMENT 'ID DEL PROVEEDOR AL QUE SE LE COMPRÓ EL PRODUCTO (FOREIGN KEY)',
  `desactivado` tinyint(1) DEFAULT NULL COMMENT 'INDICA SI EL PRODUCTO ESTA DESACTIVADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `tabla_id`, `codigo`, `marca`, `estado`, `categoria`, `precio`, `existencia`, `id_empleado`, `id_proveedor`, `desactivado`) VALUES
(1, 1, 'B006TFWU8B', 'BIG ROOM', 'bueno', 'MUEBLES', '999.0000', 10, 1, 1, 0),
(4, 4, 'B07TX3SJ73', 'FURNITURER', 'bueno', 'MUEBLES', '1119.0000', 2, 1, 1, NULL),
(5, 5, 'B08LHG2W7Y', 'TP-LINK', 'dañado', 'ELECTRONICA', '990.0000', 5, 12, 2, NULL),
(6, 6, 'MUESTRA', 'MUESTRA', 'baja', 'MUESTRA', '123123.0000', 111, 8, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL COMMENT 'CONSECUTIVO DE TABLA',
  `tabla_id` int(11) DEFAULT NULL COMMENT 'CONSECUTIVO PARA OPERADORES (VERIFICACION)',
  `nombre` varchar(50) NOT NULL COMMENT 'NOMBRE DEL PROVEEDOR',
  `correo` varchar(50) NOT NULL COMMENT 'CORREO DEL PROVEEDOR',
  `direccion` varchar(255) NOT NULL COMMENT 'DIRECCION DEL PROVEEDOR',
  `desactivado` tinyint(1) DEFAULT NULL COMMENT 'INDICA SI EL PROVEEDOR ESTA DESACTIVADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`id`, `tabla_id`, `nombre`, `correo`, `direccion`, `desactivado`) VALUES
(1, 1, 'QUANTUM MOBILIARIO', 'ventas@quantummobiliario.mx', 'Parroquia 179 Benito Juarez CDMX 03100', NULL),
(2, 2, 'SOLUCIONES DE DATOS', 'ventas@solucionesdedatos.mx', 'Francisco I. Madero 702 Leon Guanajuato 37000', NULL),
(3, 3, 'COMPAÑIA MUESTRA SA DE CV', 'aaaa@bbb.com', 'Los Alpes 1000 Guadalajara Jalisco 44340', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `no_pedido` (`no_pedido`),
  ADD KEY `compras_FK_1` (`id_proveedor`);

--
-- Indexes for table `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apellidos` (`apellidos`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_FK_2` (`id_proveedor`),
  ADD KEY `productos_FK_1` (`id_empleado`) USING BTREE;

--
-- Indexes for table `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CONSECUTIVO DE TABLA', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CONSECUTIVO DE TABLA', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CONSECUTIVO DE TABLA', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CONSECUTIVO DE TABLA', AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_FK_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `compras_FK_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_FK_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `productos_FK_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
