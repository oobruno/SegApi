-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema gastospessoais
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema gastospessoais
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `gastospessoais` DEFAULT CHARACTER SET utf8 ;
USE `gastospessoais` ;

-- -----------------------------------------------------
-- Table `gastospessoais`.`Gasto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gastospessoais`.`Gasto` (
  `idGasto` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idTipoGasto` VARCHAR(45) NOT NULL,
  `idData` VARCHAR(45) NOT NULL,
  `qtGasto` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idGasto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gastospessoais`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gastospessoais`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `idEmail` VARCHAR(45) NOT NULL,
  `idSenha` VARCHAR(45) NOT NULL,
  `idNumero` VARCHAR(45) NOT NULL,
  `nomeUsuario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gastospessoais`.`Usuario_has_Gasto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gastospessoais`.`Usuario_has_Gasto` (
  `Usuario_idUsuario` INT NOT NULL,
  `Gasto_idGasto` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Usuario_idUsuario`, `Gasto_idGasto`),
  INDEX `fk_Usuario_has_Gasto_Gasto1_idx` (`Gasto_idGasto` ASC) VISIBLE,
  INDEX `fk_Usuario_has_Gasto_Usuario_idx` (`Usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_has_Gasto_Usuario`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `gastospessoais`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Gasto_Gasto1`
    FOREIGN KEY (`Gasto_idGasto`)
    REFERENCES `gastospessoais`.`Gasto` (`idGasto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
