CREATE TABLE `archive_files` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NULL DEFAULT NULL COMMENT 'file name',
	`path` VARCHAR(500) NULL DEFAULT NULL COMMENT 'file source',
	`storage` VARCHAR(255) NULL DEFAULT NULL COMMENT 'storage',
	`comment` VARCHAR(255) NULL DEFAULT 'n' COMMENT 'y/n yes -> language + separate Audiochannel y/n, no',
	`comment_lang` VARCHAR(255) NULL DEFAULT 'n',
	`comment_audio_channel` VARCHAR(255) NULL DEFAULT 'n',
	`moderator` CHAR(1) NULL DEFAULT 'n' COMMENT 'y/n Moderator (yes -> language, no)',
	`moderator_lang` VARCHAR(255) NULL DEFAULT 'n',
	`interview` CHAR(1) NULL DEFAULT 'n' COMMENT 'y/n Interviews (yes -> who + language + translation, no) – Mehrere möglich? ja',
	`atmosphere` CHAR(1) NULL DEFAULT 'n' COMMENT 'y/n',
	`resolution` VARCHAR(255) NULL DEFAULT NULL COMMENT '1920x1080, 1280x720, 1024x576, 720x576',
	`resolution_input` VARCHAR(255) NULL DEFAULT NULL,
	`scale` VARCHAR(255) NULL DEFAULT NULL COMMENT '4:3 oder 16:9',
	`graphic` CHAR(1) NULL DEFAULT 'n' COMMENT 'y/n',
	`graphic_input` VARCHAR(255) NULL DEFAULT NULL,
	`graphicstyle` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Graphicstyle (yes -> sauerland, ard, neutral- Feste Auswahl? nein, no)',
	`graphic_broadcast_station` VARCHAR(355) NULL DEFAULT 'n' COMMENT 'Grapic broadcast station (yes -> which, no)',
	`quality` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Quality (a=good, b=medium, c=bad – Feste Auswahl? ja)',
	`legalaffiars_from` DATE NULL DEFAULT NULL,
	`legalaffiars_to` DATE NULL DEFAULT NULL,
	`fight_date` DATE NULL DEFAULT NULL,
	`fight_where` VARCHAR(355) NULL DEFAULT NULL,
	`fighter_a` INT(11) NULL DEFAULT NULL,
	`fighter_b` INT(11) NULL DEFAULT NULL,
	`nationality_fighter_a` VARCHAR(255) NULL DEFAULT NULL,
	`nationality_fighter_b` VARCHAR(255) NULL DEFAULT NULL,
	`fight_type` VARCHAR(255) NULL DEFAULT NULL,
	`gender` VARCHAR(50) NULL DEFAULT NULL,
	`weight_class` VARCHAR(50) NULL DEFAULT NULL,
	`rounds` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Rounds (Feste Auswahl?) ja (1 bis 12 ?); jeweils andere abhängig von "Type of Fight"',
	`fight_title` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Titlefight (Feste Auswahl?) ja (welche ???); jeweils andere abhängig von "Type of Fight"',
	`tags` VARCHAR(350) NULL DEFAULT NULL,
	`winner` VARCHAR(50) NULL DEFAULT NULL,
	`result` VARCHAR(50) NULL DEFAULT NULL COMMENT 'SD, UD, KO -> Round + TC, TKO->Round + TC',
	`result_round` VARCHAR(50) NULL DEFAULT NULL,
	`source` VARCHAR(50) NULL DEFAULT NULL,
	`tc_start` VARCHAR(50) NULL DEFAULT NULL,
	`tc_end` VARCHAR(50) NULL DEFAULT NULL,
	`length` VARCHAR(50) NULL DEFAULT NULL,
	`sound` VARCHAR(50) NULL DEFAULT NULL,
	`legal_runtime` VARCHAR(50) NULL DEFAULT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `fighter` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`firstname` VARCHAR(255) NULL DEFAULT '0',
	`lastname` VARCHAR(255) NOT NULL DEFAULT '0',
	`lastname_shortcut` VARCHAR(255) NULL DEFAULT '0',
	`fullname` VARCHAR(255) NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `file_index` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`fk_id` INT(11) NOT NULL DEFAULT '0',
	`type` VARCHAR(50) NULL DEFAULT NULL,
	`status` VARCHAR(50) NULL DEFAULT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;


CREATE TABLE `file_marker` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`fk_id` INT(11) NOT NULL DEFAULT '0',
	`action` VARCHAR(255) NULL DEFAULT '0',
	`action_from` VARCHAR(50) NULL DEFAULT '00:00:00',
	`comment` TEXT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

CREATE TABLE `interview` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`archivefile_id` INT(11) NOT NULL DEFAULT '0',
	`fighter` VARCHAR(255) NULL DEFAULT '0',
	`action_in` VARCHAR(255) NULL DEFAULT '0',
	`action_out` VARCHAR(255) NULL DEFAULT '0',
	`language` VARCHAR(255) NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;


CREATE TABLE `sende_files` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`fk_id` INT(11) NOT NULL DEFAULT '0',
	`genre` VARCHAR(255) NULL DEFAULT NULL,
	`storage` VARCHAR(255) NULL DEFAULT NULL,
	`name` VARCHAR(255) NULL DEFAULT NULL,
	`hidden` TINYINT(4) NOT NULL DEFAULT '0',
	`title` VARCHAR(255) NULL DEFAULT NULL,
	`product_year` VARCHAR(255) NULL DEFAULT NULL,
	`sport_type` VARCHAR(255) NULL DEFAULT NULL,
	`content_tags` TEXT NULL,
	`run_time` VARCHAR(50) NULL DEFAULT NULL,
	`country` VARCHAR(50) NULL DEFAULT NULL,
	`licensors` VARCHAR(255) NULL DEFAULT NULL,
	`copyright` VARCHAR(255) NULL DEFAULT NULL,
	`license_start` DATE NULL DEFAULT NULL,
	`license_end` DATE NULL DEFAULT NULL,
	`legal_runtime` VARCHAR(255) NULL DEFAULT NULL,
	`rating` VARCHAR(255) NULL DEFAULT NULL,
	`duration` VARCHAR(50) NULL DEFAULT NULL,
	`updated_at` DATETIME NULL DEFAULT NULL,
	`created_at` DATETIME NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name` (`name`),
	INDEX `fk_id` (`fk_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `sf_artwork` (
	`upload_file_id` INT(11) NOT NULL,
	`sf_id` INT(11) NOT NULL,
	PRIMARY KEY (`upload_file_id`, `sf_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `sf_descriptions` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`sf_file_id` INT(11) NOT NULL,
	`type` VARCHAR(255) NOT NULL,
	`language` VARCHAR(255) NOT NULL,
	`short_description` TEXT NULL,
	`long_description` TEXT NULL,
	PRIMARY KEY (`id`),
	INDEX `sf_file_id` (`sf_file_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `upload_files` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`file_name` VARCHAR(255) NOT NULL,
	`file_path` VARCHAR(300) NULL DEFAULT NULL,
	`rel_path` VARCHAR(300) NULL DEFAULT NULL,
	`file_type` VARCHAR(255) NOT NULL,
	`hidden` TINYINT(4) NOT NULL DEFAULT '0',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
