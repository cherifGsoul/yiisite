SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `yiisite` DEFAULT CHARACTER SET utf8 ;
USE `yiisite` ;

-- -----------------------------------------------------
-- Table `yiisite`.`tbl_user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(60) NOT NULL ,
  `password` VARCHAR(40) NOT NULL ,
  `full_name` TEXT NOT NULL ,
  `email` VARCHAR(128) NOT NULL ,
  `create_time` DATETIME NOT NULL ,
  `update_time` DATETIME NOT NULL ,
  `create_user_id` INT(11) NOT NULL ,
  `update_user_id` INT(11) NOT NULL ,
  `status` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `yiisite`.`tbl_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_content` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(128) NOT NULL ,
  `type` VARCHAR(20) NOT NULL DEFAULT 'post' ,
  `content` TEXT NULL DEFAULT NULL ,
  `excerpt` TEXT NULL DEFAULT NULL ,
  `slug` VARCHAR(128) NOT NULL ,
  `parent_id` INT(11) NULL DEFAULT NULL ,
  `lft` INT(3) NULL DEFAULT NULL ,
  `rgt` INT(3) NULL DEFAULT NULL ,
  `level` INT(3) NULL DEFAULT NULL ,
  `status` TINYINT(1) NOT NULL ,
  `create_time` DATETIME NOT NULL ,
  `update_time` DATETIME NOT NULL ,
  `update_user_id` INT(11) NOT NULL ,
  `meta_description` TEXT NULL DEFAULT NULL ,
  `meta_keys` TEXT NULL DEFAULT NULL ,
  `meta_robots` VARCHAR(128) NULL DEFAULT NULL ,
  `user_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tbl_content_tbl_user1` (`user_id` ASC) ,
  CONSTRAINT `fk_tbl_content_tbl_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `yiisite`.`tbl_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `yiisite`.`tbl_comment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_comment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `status` INT(11) NOT NULL ,
  `create_time` INT(11) NULL DEFAULT NULL ,
  `author` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `email` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `url` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
  `content_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_content_id` (`content_id` ASC) ,
  CONSTRAINT `fk_content_id`
    FOREIGN KEY (`content_id` )
    REFERENCES `yiisite`.`tbl_content` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `yiisite`.`tbl_taxonomy`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_taxonomy` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(128) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `slug` VARCHAR(128) NOT NULL ,
  `lft` INT(3) NOT NULL ,
  `rgt` INT(3) NOT NULL ,
  `level` INT(3) NOT NULL ,
  `parent_id` INT(10) NULL DEFAULT NULL ,
  `create_time` DATETIME NOT NULL ,
  `update_time` DATETIME NOT NULL ,
  `update_user_id` INT(11) NULL DEFAULT NULL ,
  `` INT(11) NOT NULL ,
  `tbl_user_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `parent_id` (`parent_id` ASC) ,
  INDEX `fk_tbl_category_tbl_user1` (`` ASC) ,
  INDEX `fk_tbl_taxonomy_tbl_user1` (`tbl_user_id` ASC) ,
  CONSTRAINT `fk_tbl_taxonomy_tbl_user1`
    FOREIGN KEY (`tbl_user_id` )
    REFERENCES `yiisite`.`tbl_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `yiisite`.`tbl_content_taxonomy`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_content_taxonomy` (
  `tbl_content_id` INT(11) NOT NULL ,
  `tbl_taxonomy_id` INT(11) NOT NULL ,
  PRIMARY KEY (`tbl_content_id`, `tbl_taxonomy_id`) ,
  INDEX `fk_tbl_content_has_tbl_taxonomy_tbl_taxonomy1` (`tbl_taxonomy_id` ASC) ,
  INDEX `fk_tbl_content_has_tbl_taxonomy_tbl_content1` (`tbl_content_id` ASC) ,
  CONSTRAINT `fk_tbl_content_has_tbl_taxonomy_tbl_content1`
    FOREIGN KEY (`tbl_content_id` )
    REFERENCES `yiisite`.`tbl_content` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_content_has_tbl_taxonomy_tbl_taxonomy1`
    FOREIGN KEY (`tbl_taxonomy_id` )
    REFERENCES `yiisite`.`tbl_taxonomy` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
