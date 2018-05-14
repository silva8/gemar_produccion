-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema gemar
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `gemar` ;

-- -----------------------------------------------------
-- Schema gemar
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `gemar` DEFAULT CHARACTER SET latin1 ;
USE `gemar` ;

-- -----------------------------------------------------
-- Table `gemar`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`users` ;

CREATE TABLE IF NOT EXISTS `gemar`.`users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` VARCHAR(64) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL COMMENT 'user\'s name, unique',
  `user_password_hash` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL COMMENT 'user\'s password in salted and hashed format',
  `user_email` VARCHAR(64) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL COMMENT 'user\'s email, unique',
  `user_role` TINYINT(1) NOT NULL COMMENT 'user\'s role, unique',
  `user_phone` VARCHAR(45) NULL,
  `user_region` VARCHAR(45) NULL,
  `user_title` VARCHAR(100) NULL,
  `user_discipline` VARCHAR(100) NULL,
  `user_image_path` VARCHAR(200) NULL,
  `user_color_tag` VARCHAR(45) NULL DEFAULT '#00bcd4',
  `user_first_name` VARCHAR(45) NULL,
  `user_last_name` VARCHAR(45) NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_name` (`user_name` ASC),
  UNIQUE INDEX `user_email` (`user_email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci
COMMENT = 'user data';


-- -----------------------------------------------------
-- Table `gemar`.`company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`company` ;

CREATE TABLE IF NOT EXISTS `gemar`.`company` (
  `company_id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NULL,
  `rut` VARCHAR(45) NULL,
  `giro` VARCHAR(200) NULL,
  `direccion` VARCHAR(45) NULL,
  `comuna` VARCHAR(45) NULL,
  `ciudad` VARCHAR(45) NULL,
  `razonsocial` VARCHAR(45) NULL,
  `mail` VARCHAR(100) NULL,
  `logopath` VARCHAR(200) NULL,
  PRIMARY KEY (`company_id`),
  UNIQUE INDEX `rut_UNIQUE` (`rut` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`contacto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`contacto` ;

CREATE TABLE IF NOT EXISTS `gemar`.`contacto` (
  `contacto_id` INT NOT NULL AUTO_INCREMENT,
  `company_company_id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `telefono` VARCHAR(45) NULL,
  `cargo` VARCHAR(45) NULL,
  `departamento` VARCHAR(45) NULL,
  PRIMARY KEY (`contacto_id`),
  INDEX `fk_contacto_company1_idx` (`company_company_id` ASC),
  CONSTRAINT `fk_contacto_company1`
    FOREIGN KEY (`company_company_id`)
    REFERENCES `gemar`.`company` (`company_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`centro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`centro` ;

CREATE TABLE IF NOT EXISTS `gemar`.`centro` (
  `centro_id` INT NOT NULL AUTO_INCREMENT,
  `company_company_id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `contacto` VARCHAR(45) NULL,
  `telefono` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`centro_id`),
  INDEX `fk_centro_company1_idx` (`company_company_id` ASC),
  CONSTRAINT `fk_centro_company1`
    FOREIGN KEY (`company_company_id`)
    REFERENCES `gemar`.`company` (`company_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`evento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`evento` ;

CREATE TABLE IF NOT EXISTS `gemar`.`evento` (
  `evento_id` INT NOT NULL AUTO_INCREMENT,
  `users_user_id` INT(11) NOT NULL,
  `centro_centro_id` INT NOT NULL,
  `contacto_contacto_id` INT NOT NULL,
  `HoraInicio` DATETIME NOT NULL DEFAULT '2017-08-03 8:30:00',
  `HoraTermino` DATETIME NOT NULL DEFAULT '2017-08-03 12:30:00',
  `Lastmodified` DATETIME NOT NULL,
  `nombre_proyecto` VARCHAR(200) NULL,
  `descripcion` VARCHAR(200) NULL,
  `orden_compra` VARCHAR(45) NULL,
  `visitas_agendadas` INT(11) NULL,
  `criticidad` INT NULL,
  `color` VARCHAR(45) NULL,
  `proveedor` VARCHAR(255) NULL,
  `comprador` VARCHAR(255) NULL,
  `componente` VARCHAR(255) NULL,
  PRIMARY KEY (`evento_id`),
  INDEX `fk_evento_users1_idx` (`users_user_id` ASC),
  INDEX `fk_evento_centro1_idx` (`centro_centro_id` ASC),
  INDEX `fk_evento_contacto1_idx` (`contacto_contacto_id` ASC),
  CONSTRAINT `fk_evento_users1`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `gemar`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evento_centro1`
    FOREIGN KEY (`centro_centro_id`)
    REFERENCES `gemar`.`centro` (`centro_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evento_contacto1`
    FOREIGN KEY (`contacto_contacto_id`)
    REFERENCES `gemar`.`contacto` (`contacto_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`reporte`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`reporte` ;

CREATE TABLE IF NOT EXISTS `gemar`.`reporte` (
  `reporte_id` INT NOT NULL AUTO_INCREMENT,
  `evento_evento_id` INT NOT NULL,
  `version` INT NULL,
  `fecha` DATETIME NULL,
  `horario_trabajado` VARCHAR(45) NULL,
  `tipo_inspeccion` INT NULL,
  `avance` INT NULL,
  `fecha_estimada_cierre` DATETIME NULL,
  `comentarios` LONGTEXT NULL,
  `alertas` LONGTEXT NULL,
  `alcances` LONGTEXT NULL,
  `conclusiones` LONGTEXT NULL,
  `resumen` VARCHAR(200) NULL,
  `status` INT NULL,
  `subcontratista` VARCHAR(255) NULL,
  `numero_reporte` INT NULL,
  PRIMARY KEY (`reporte_id`),
  INDEX `fk_reporte_evento1_idx` (`evento_evento_id` ASC),
  CONSTRAINT `fk_reporte_evento1`
    FOREIGN KEY (`evento_evento_id`)
    REFERENCES `gemar`.`evento` (`evento_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`equipos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`equipos` ;

CREATE TABLE IF NOT EXISTS `gemar`.`equipos` (
  `equipos_id` INT NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(200) NULL,
  `descripcion` LONGTEXT NULL,
  `proveedor` VARCHAR(200) NULL,
  `comentario` LONGTEXT NULL,
  `reporte_reporte_id` INT NOT NULL,
  PRIMARY KEY (`equipos_id`),
  INDEX `fk_equipos_reporte1_idx` (`reporte_reporte_id` ASC),
  CONSTRAINT `fk_equipos_reporte1`
    FOREIGN KEY (`reporte_reporte_id`)
    REFERENCES `gemar`.`reporte` (`reporte_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`asistentes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`asistentes` ;

CREATE TABLE IF NOT EXISTS `gemar`.`asistentes` (
  `asistentes_id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NULL,
  `compañia` VARCHAR(200) NULL,
  `cargo` VARCHAR(200) NULL,
  `reporte_reporte_id` INT NOT NULL,
  PRIMARY KEY (`asistentes_id`),
  INDEX `fk_asistentes_reporte1_idx` (`reporte_reporte_id` ASC),
  CONSTRAINT `fk_asistentes_reporte1`
    FOREIGN KEY (`reporte_reporte_id`)
    REFERENCES `gemar`.`reporte` (`reporte_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`documentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`documentos` ;

CREATE TABLE IF NOT EXISTS `gemar`.`documentos` (
  `documentos_id` INT NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(200) NULL,
  `revision` VARCHAR(45) NULL,
  `nombre` VARCHAR(200) NULL,
  `status` VARCHAR(200) NULL,
  `reporte_reporte_id` INT NOT NULL,
  PRIMARY KEY (`documentos_id`),
  INDEX `fk_documentos_reporte1_idx` (`reporte_reporte_id` ASC),
  CONSTRAINT `fk_documentos_reporte1`
    FOREIGN KEY (`reporte_reporte_id`)
    REFERENCES `gemar`.`reporte` (`reporte_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`pendientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`pendientes` ;

CREATE TABLE IF NOT EXISTS `gemar`.`pendientes` (
  `pendientes_id` INT NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(200) NULL,
  `descripcion` LONGTEXT NULL,
  `pendientes` LONGTEXT NULL,
  `comentarios` LONGTEXT NULL,
  `reporte_reporte_id` INT NOT NULL,
  PRIMARY KEY (`pendientes_id`),
  INDEX `fk_pendientes_reporte1_idx` (`reporte_reporte_id` ASC),
  CONSTRAINT `fk_pendientes_reporte1`
    FOREIGN KEY (`reporte_reporte_id`)
    REFERENCES `gemar`.`reporte` (`reporte_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`fotografias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`fotografias` ;

CREATE TABLE IF NOT EXISTS `gemar`.`fotografias` (
  `fotografias_id` INT NOT NULL AUTO_INCREMENT,
  `imagen_path` VARCHAR(200) NULL,
  `elemento` VARCHAR(200) NULL,
  `observaciones` VARCHAR(200) NULL,
  `reporte_reporte_id` INT NOT NULL,
  PRIMARY KEY (`fotografias_id`),
  INDEX `fk_fotografias_reporte1_idx` (`reporte_reporte_id` ASC),
  CONSTRAINT `fk_fotografias_reporte1`
    FOREIGN KEY (`reporte_reporte_id`)
    REFERENCES `gemar`.`reporte` (`reporte_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`enviado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`enviado` ;

CREATE TABLE IF NOT EXISTS `gemar`.`enviado` (
  `enviado_id` INT NOT NULL,
  `users_user_id` INT(11) NOT NULL,
  `fecha` DATETIME NULL,
  `reporte_reporte_id` INT NOT NULL,
  PRIMARY KEY (`enviado_id`, `users_user_id`),
  INDEX `fk_enviado_reporte1_idx` (`reporte_reporte_id` ASC),
  INDEX `fk_enviado_users1_idx` (`users_user_id` ASC),
  CONSTRAINT `fk_enviado_reporte1`
    FOREIGN KEY (`reporte_reporte_id`)
    REFERENCES `gemar`.`reporte` (`reporte_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_enviado_users1`
    FOREIGN KEY (`users_user_id`)
    REFERENCES `gemar`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`inspeccion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`inspeccion` ;

CREATE TABLE IF NOT EXISTS `gemar`.`inspeccion` (
  `inspeccion_id` INT NOT NULL,
  `fecha` DATETIME NULL,
  `reporte_reporte_id` INT NOT NULL,
  PRIMARY KEY (`inspeccion_id`, `reporte_reporte_id`),
  INDEX `fk_inspeccion_reporte1_idx` (`reporte_reporte_id` ASC),
  CONSTRAINT `fk_inspeccion_reporte1`
    FOREIGN KEY (`reporte_reporte_id`)
    REFERENCES `gemar`.`reporte` (`reporte_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gemar`.`logs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gemar`.`logs` ;

CREATE TABLE IF NOT EXISTS `gemar`.`logs` (
  `logs_id` INT NOT NULL,
  `activador` VARCHAR(255) NULL,
  `informe` VARCHAR(255) NULL,
  `inspector` VARCHAR(255) NULL,
  `comprador` VARCHAR(255) NULL,
  `proyecto` VARCHAR(255) NULL,
  `po` VARCHAR(255) NULL,
  `descripcion` VARCHAR(255) NULL,
  `proveedor` VARCHAR(255) NULL,
  `inicio` TIMESTAMP NULL,
  `dias` INT NULL,
  `termino` TIMESTAMP NULL,
  `nivel` INT NULL,
  `avance` VARCHAR(45) NULL,
  `fecha` TIMESTAMP NULL,
  `comentario` LONGTEXT NULL,
  PRIMARY KEY (`logs_id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `gemar`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `gemar`;
INSERT INTO `gemar`.`users` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `user_role`, `user_phone`, `user_region`, `user_title`, `user_discipline`, `user_image_path`, `user_color_tag`, `user_first_name`, `user_last_name`) VALUES (1, 'admin', '$2y$10$uab8Rwow0PpYW4r18B/kCurIFiibqorPr4bX0eKVrlgHBgez4EI5K', 'admin@admin.cl', 1, '123123', 'asd', 'ads', 'asd', 'asd.jpg', NULL, 'Admin', 'admin');

COMMIT;

