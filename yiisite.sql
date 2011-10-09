SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `yiisite` DEFAULT CHARACTER SET utf8 ;
USE `yiisite` ;

-- -----------------------------------------------------
-- Table `yiisite`.`tbl_category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_category` (
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
  `meta_keys` TEXT NULL ,
  `meta_description` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `parent_id` (`parent_id` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


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
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `yiisite`.`tbl_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_content` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(128) NOT NULL ,
  `type` TEXT NOT NULL ,
  `content` TEXT NOT NULL ,
  `excerpt` TEXT NULL DEFAULT NULL ,
  `slug` VARCHAR(128) NOT NULL ,
  `parent_id` INT(11) NULL DEFAULT NULL ,
  `lft` INT(3) NOT NULL ,
  `rgt` INT(3) NOT NULL ,
  `level` INT(3) NOT NULL ,
  `status` TINYINT(1) NOT NULL ,
  `create_time` DATETIME NOT NULL ,
  `update_time` DATETIME NOT NULL ,
  `update_user_id` INT(11) NOT NULL ,
  `meta_description` TEXT NULL DEFAULT NULL ,
  `meta_keys` TEXT NULL DEFAULT NULL ,
  `meta_robots` VARCHAR(128) NULL DEFAULT NULL ,
  `user_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_id` (`user_id` ASC) ,
  CONSTRAINT `fk_user_id`
    FOREIGN KEY (`user_id` )
    REFERENCES `yiisite`.`tbl_user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
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
-- Table `yiisite`.`tbl_tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_tag` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
  `slug` VARCHAR(45) NULL ,
  `frequency` INT(11) NULL DEFAULT '1' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `yiisite`.`tbl_category_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_category_content` (
  `category_id` INT(11) NOT NULL ,
  `content_id` INT(11) NOT NULL ,
  PRIMARY KEY (`category_id`, `content_id`) ,
  INDEX `fk_content_id` (`content_id` ASC) ,
  INDEX `fk_category_id` (`category_id` ASC) ,
  CONSTRAINT `fk_category_id`
    FOREIGN KEY (`category_id` )
    REFERENCES `yiisite`.`tbl_category` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_content_id`
    FOREIGN KEY (`content_id` )
    REFERENCES `yiisite`.`tbl_content` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `yiisite`.`tbl_content_tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `yiisite`.`tbl_content_tag` (
  `content_id` INT(11) NOT NULL ,
  `tag_id` INT(11) NOT NULL ,
  PRIMARY KEY (`content_id`, `tag_id`) ,
  INDEX `fk_tag_id` (`tag_id` ASC) ,
  INDEX `fk_content_id` (`content_id` ASC) ,
  CONSTRAINT `fk_content_id`
    FOREIGN KEY (`content_id` )
    REFERENCES `yiisite`.`tbl_content` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tag_id`
    FOREIGN KEY (`tag_id` )
    REFERENCES `yiisite`.`tbl_tag` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
