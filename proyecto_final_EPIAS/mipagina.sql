-- ============================================================
-- Base de datos: mipagina
-- Proyecto Final: EPIAS — Ecosistema Web
-- ============================================================

CREATE DATABASE IF NOT EXISTS `mipagina`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_spanish_ci;

USE `mipagina`;

-- ── Tabla: usuarios ──────────────────────────────────────────
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id`       INT          NOT NULL AUTO_INCREMENT,
  `nombre`   VARCHAR(100) NOT NULL,
  `correo`   VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `es_admin` TINYINT(1)   NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuarios de ejemplo (contraseña: 12345678)
INSERT INTO `usuarios` (`nombre`, `correo`, `password`, `es_admin`) VALUES
('Administrador', 'admin@epias.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
('Juan Pérez',    'juan@epias.mx',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0),
('María López',   'maria@epias.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0);

-- ── Tabla: clientes ──────────────────────────────────────────
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id`           INT          NOT NULL AUTO_INCREMENT,
  `nombre`       VARCHAR(150) NOT NULL,
  `domicilio`    VARCHAR(255) DEFAULT '',
  `giro`         VARCHAR(100) DEFAULT '',
  `razon_social` VARCHAR(200) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Clientes de ejemplo
INSERT INTO `clientes` (`nombre`, `domicilio`, `giro`, `razon_social`) VALUES
('Municipio de Tepatitlán', 'Av. Principal 100, Tepatitlán', 'Gobierno Municipal', 'H. Ayuntamiento de Tepatitlán de Morelos'),
('Rancho Los Altos S.A.',   'Carretera a Arandas Km 5',       'Ganadero/Agropecuario', 'Rancho Los Altos S.A. de C.V.'),
('Industrias del Agua SA',  'Blvd. Industrial 450, Gdl.',     'Industria Química',     'Industrias del Agua S.A. de C.V.');

-- ── Tabla: productos ─────────────────────────────────────────
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id`            INT            NOT NULL AUTO_INCREMENT,
  `codigo_prod`   VARCHAR(50)    NOT NULL,
  `desc_prod`     VARCHAR(255)   NOT NULL,
  `precio_prod`   DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
  `cantidad_prod` INT            NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Productos de ejemplo
INSERT INTO `productos` (`codigo_prod`, `desc_prod`, `precio_prod`, `cantidad_prod`) VALUES
('FILTR-001', 'Filtro de arena para agua potable',       15000.00, 8),
('BOMB-001',  'Bomba sumergible 1.5 HP',                  8500.00, 5),
('CLOR-001',  'Clorador automático dosificador',          12000.00, 3),
('OSMO-001',  'Sistema de ósmosis inversa industrial',   45000.00, 2),
('SENS-001',  'Sensor de pH digital',                     2800.00, 12),
('MANT-001',  'Kit de mantenimiento preventivo',          1500.00, 0);