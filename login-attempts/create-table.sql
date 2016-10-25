-- login attempts table
CREATE TABLE `vb_failed_login_attempts` (
	`username` VARCHAR(64) NOT NULL,
	`count` INT(10) UNSIGNED NOT NULL,
	`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`username`),
	UNIQUE INDEX `username` (`username`)
)
COLLATE='utf8_general_ci' ENGINE=InnoDB;

-- users table
CREATE TABLE `vb_users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(64) NOT NULL DEFAULT '0',
	`password` VARCHAR(255) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `username` (`username`)
)
COLLATE='utf8_general_ci' ENGINE=InnoDB AUTO_INCREMENT=0;
