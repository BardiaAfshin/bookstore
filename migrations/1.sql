CREATE DATABASE bookstore;
USE bookstore;
CREATE TABLE `bookstore`.`books` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `isbn` INT NULL,
  `title` VARCHAR(255) NULL,
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `index_isbn` (`isbn` ASC),
  INDEX `index_title` (`title` ASC),
  INDEX `index_description` (`description` ASC));

INSERT INTO `bookstore`.`books` (`title`) VALUES ('Every Dog Has His Day');
INSERT INTO `bookstore`.`books` (`title`) VALUES ('Mississippi Blues');
INSERT INTO `bookstore`.`books` (`title`) VALUES ('Moby Dick');
INSERT INTO `bookstore`.`books` (`title`) VALUES ('Mug Shot');
INSERT INTO `bookstore`.`books` (`title`) VALUES ('Sample Book Title');
INSERT INTO `bookstore`.`books` (`title`) VALUES ('Show me the way');

