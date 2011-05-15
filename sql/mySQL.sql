-- Adminer 3.2.2 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET @adminer_alter = '';

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `auth` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `user` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`, ADD `pass` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `user`, ADD `auth` int(11) NOT NULL AFTER `pass`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'admin' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'user' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `user` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `user` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'pass' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `pass` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `user`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'user' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `pass` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `user`');
					END IF;
				WHEN 'auth' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `auth` int(11) NOT NULL AFTER `pass`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'pass' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `auth` int(11) NOT NULL AFTER `pass`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `admin`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `diskuse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `parent` int(11) NOT NULL,
  `writer` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `text` text COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `parent` int(11) NOT NULL AFTER `text`, ADD `writer` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `parent`, ADD `datetime` datetime NOT NULL AFTER `writer`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'diskuse' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'text' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `text` text COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `text` text COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `text`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'text' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `text`');
					END IF;
				WHEN 'writer' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `writer` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(100)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `writer` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `parent`');
					END IF;
				WHEN 'datetime' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `datetime` datetime NOT NULL AFTER `writer`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'datetime' OR _extra != '' OR _column_comment != '' OR after != 'writer' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `datetime` datetime NOT NULL AFTER `writer`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `diskuse`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `galerie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `parent` int(11) NOT NULL,
  `show` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `title` text COLLATE utf8_general_ci NOT NULL AFTER `name`, ADD `parent` int(11) NOT NULL AFTER `title`, ADD `show` int(11) NOT NULL AFTER `parent`, ADD `order` int(11) NOT NULL AFTER `show`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'galerie' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'name' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'title' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `title` text COLLATE utf8_general_ci NOT NULL AFTER `name`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'name' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `title` text COLLATE utf8_general_ci NOT NULL AFTER `name`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `title`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'title' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `title`');
					END IF;
				WHEN 'show' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `show` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `show` int(11) NOT NULL AFTER `parent`');
					END IF;
				WHEN 'order' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `order` int(11) NOT NULL AFTER `show`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'show' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `order` int(11) NOT NULL AFTER `show`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `galerie`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `href` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `pocet_zobrazeni` int(11) NOT NULL,
  `pocet_odkazu` int(11) NOT NULL,
  `last_change_date` datetime NOT NULL,
  `change_period` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `domain` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `domain`, ADD `text` text COLLATE utf8_general_ci NOT NULL AFTER `name`, ADD `pocet_zobrazeni` int(11) NOT NULL AFTER `text`, ADD `pocet_odkazu` int(11) NOT NULL AFTER `pocet_zobrazeni`, ADD `last_change_date` datetime NOT NULL AFTER `pocet_odkazu`, ADD `change_period` int(11) NOT NULL AFTER `last_change_date`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'href' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'domain' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `domain` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `domain` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'name' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `domain`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'domain' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `domain`');
					END IF;
				WHEN 'text' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `text` text COLLATE utf8_general_ci NOT NULL AFTER `name`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'name' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `text` text COLLATE utf8_general_ci NOT NULL AFTER `name`');
					END IF;
				WHEN 'pocet_zobrazeni' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `pocet_zobrazeni` int(11) NOT NULL AFTER `text`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'text' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `pocet_zobrazeni` int(11) NOT NULL AFTER `text`');
					END IF;
				WHEN 'pocet_odkazu' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `pocet_odkazu` int(11) NOT NULL AFTER `pocet_zobrazeni`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'pocet_zobrazeni' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `pocet_odkazu` int(11) NOT NULL AFTER `pocet_zobrazeni`');
					END IF;
				WHEN 'last_change_date' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `last_change_date` datetime NOT NULL AFTER `pocet_odkazu`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'datetime' OR _extra != '' OR _column_comment != '' OR after != 'pocet_odkazu' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `last_change_date` datetime NOT NULL AFTER `pocet_odkazu`');
					END IF;
				WHEN 'change_period' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `change_period` int(11) NOT NULL AFTER `last_change_date`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'last_change_date' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `change_period` int(11) NOT NULL AFTER `last_change_date`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `href`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `href_covcem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_vcem` int(11) NOT NULL,
  `id_co` int(11) NOT NULL,
  `pocet_kliku` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `id_vcem` int(11) NOT NULL AFTER `id`, ADD `id_co` int(11) NOT NULL AFTER `id_vcem`, ADD `pocet_kliku` int(11) NOT NULL AFTER `id_co`, ADD `priority` int(11) NOT NULL AFTER `pocet_kliku`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'href_covcem' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'id_vcem' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_vcem` int(11) NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_vcem` int(11) NOT NULL AFTER `id`');
					END IF;
				WHEN 'id_co' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_co` int(11) NOT NULL AFTER `id_vcem`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_vcem' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_co` int(11) NOT NULL AFTER `id_vcem`');
					END IF;
				WHEN 'pocet_kliku' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `pocet_kliku` int(11) NOT NULL AFTER `id_co`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_co' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `pocet_kliku` int(11) NOT NULL AFTER `id_co`');
					END IF;
				WHEN 'priority' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `priority` int(11) NOT NULL AFTER `pocet_kliku`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'pocet_kliku' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `priority` int(11) NOT NULL AFTER `pocet_kliku`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `href_covcem`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `html` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `parent` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `style` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `content` text COLLATE latin2_general_ci NOT NULL AFTER `id`, ADD `parent` int(11) NOT NULL AFTER `content`, ADD `sort` int(11) NOT NULL AFTER `parent`, ADD `style` int(11) NOT NULL AFTER `sort`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'html' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'content' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `content` text COLLATE latin2_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `content` text COLLATE latin2_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `content`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'content' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `content`');
					END IF;
				WHEN 'sort' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `sort` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `sort` int(11) NOT NULL AFTER `parent`');
					END IF;
				WHEN 'style' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `style` int(11) NOT NULL AFTER `sort`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'sort' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `style` int(11) NOT NULL AFTER `sort`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `html`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `html_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `css` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `css` text COLLATE utf8_general_ci NOT NULL AFTER `name`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'html_style' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'name' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'css' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `css` text COLLATE utf8_general_ci NOT NULL AFTER `name`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'name' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `css` text COLLATE utf8_general_ci NOT NULL AFTER `name`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `html_style`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` text NOT NULL COMMENT 'název',
  `parent` int(11) NOT NULL COMMENT 'rodič menu',
  `order` int(11) NOT NULL COMMENT 'třídění',
  `link` varchar(50) NOT NULL,
  `visible` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment COMMENT \'id\' FIRST, ADD `name` text COLLATE latin2_general_ci NOT NULL COMMENT \'název\' AFTER `id`, ADD `parent` int(11) NOT NULL COMMENT \'rodič menu\' AFTER `name`, ADD `order` int(11) NOT NULL COMMENT \'třídění\' AFTER `parent`, ADD `link` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `order`, ADD `visible` int(11) NOT NULL AFTER `link`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'menu' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment COMMENT \'id\' FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != 'id' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment COMMENT \'id\' FIRST');
					END IF;
				WHEN 'name' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `name` text COLLATE latin2_general_ci NOT NULL COMMENT \'název\' AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != 'název' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `name` text COLLATE latin2_general_ci NOT NULL COMMENT \'název\' AFTER `id`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL COMMENT \'rodič menu\' AFTER `name`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != 'rodič menu' OR after != 'name' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL COMMENT \'rodič menu\' AFTER `name`');
					END IF;
				WHEN 'order' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `order` int(11) NOT NULL COMMENT \'třídění\' AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != 'třídění' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `order` int(11) NOT NULL COMMENT \'třídění\' AFTER `parent`');
					END IF;
				WHEN 'link' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `link` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `order`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'order' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `link` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `order`');
					END IF;
				WHEN 'visible' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `visible` int(11) NOT NULL AFTER `link`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'link' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `visible` int(11) NOT NULL AFTER `link`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `menu`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `menu_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `target` int(11) NOT NULL,
  `href` varchar(50) NOT NULL,
  `parent` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `link` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `name` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`, ADD `target` int(11) NOT NULL AFTER `name`, ADD `href` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `target`, ADD `parent` int(11) NOT NULL AFTER `href`, ADD `order` int(11) NOT NULL AFTER `parent`, ADD `link` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `order`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'menu_in' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'name' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `name` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `name` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'target' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `target` int(11) NOT NULL AFTER `name`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'name' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `target` int(11) NOT NULL AFTER `name`');
					END IF;
				WHEN 'href' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `href` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `target`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'target' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `href` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `target`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `href`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'href' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `href`');
					END IF;
				WHEN 'order' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `order` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `order` int(11) NOT NULL AFTER `parent`');
					END IF;
				WHEN 'link' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `link` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `order`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'order' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `link` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `order`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `menu_in`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(4) NOT NULL,
  `text` varchar(50) NOT NULL,
  `parent` int(11) NOT NULL,
  `zapnut` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `type` varchar(4) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `text` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `type`, ADD `parent` int(11) NOT NULL AFTER `text`, ADD `zapnut` int(11) NOT NULL AFTER `parent`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'modules' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'type' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `type` varchar(4) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(4)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `type` varchar(4) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'text' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `text` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `type`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'type' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `text` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `type`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `text`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'text' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `text`');
					END IF;
				WHEN 'zapnut' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `zapnut` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `zapnut` int(11) NOT NULL AFTER `parent`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `modules`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `novinky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `parent` int(11) NOT NULL,
  `writer` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `visible` int(11) NOT NULL,
  `link` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `nazev` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `text` text COLLATE utf8_general_ci NOT NULL AFTER `nazev`, ADD `parent` int(11) NOT NULL AFTER `text`, ADD `writer` int(11) NOT NULL AFTER `parent`, ADD `datetime` datetime NOT NULL AFTER `writer`, ADD `visible` int(11) NOT NULL AFTER `datetime`, ADD `link` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `visible`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'novinky' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'nazev' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `nazev` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(100)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `nazev` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'text' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `text` text COLLATE utf8_general_ci NOT NULL AFTER `nazev`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'nazev' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `text` text COLLATE utf8_general_ci NOT NULL AFTER `nazev`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `text`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'text' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `text`');
					END IF;
				WHEN 'writer' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `writer` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `writer` int(11) NOT NULL AFTER `parent`');
					END IF;
				WHEN 'datetime' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `datetime` datetime NOT NULL AFTER `writer`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'datetime' OR _extra != '' OR _column_comment != '' OR after != 'writer' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `datetime` datetime NOT NULL AFTER `writer`');
					END IF;
				WHEN 'visible' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `visible` int(11) NOT NULL AFTER `datetime`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'datetime' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `visible` int(11) NOT NULL AFTER `datetime`');
					END IF;
				WHEN 'link' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `link` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `visible`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(100)' OR _extra != '' OR _column_comment != '' OR after != 'visible' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `link` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `visible`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `novinky`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first` int(50) NOT NULL,
  `width` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `first` int(50) NOT NULL AFTER `id`, ADD `width` int(11) NOT NULL AFTER `first`, ADD `parent` int(11) NOT NULL AFTER `width`, ADD `order` int(11) NOT NULL AFTER `parent`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'page' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'first' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `first` int(50) NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `first` int(50) NOT NULL AFTER `id`');
					END IF;
				WHEN 'width' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `width` int(11) NOT NULL AFTER `first`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'first' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `width` int(11) NOT NULL AFTER `first`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `width`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'width' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `width`');
					END IF;
				WHEN 'order' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `order` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `order` int(11) NOT NULL AFTER `parent`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `page`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `page_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `type` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'page_parts' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'type' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `type` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'latin2_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `type` varchar(50) COLLATE latin2_general_ci NOT NULL AFTER `id`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `page_parts`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `plan_akci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `kdy` date NOT NULL,
  `do` date NOT NULL,
  `kde` varchar(50) NOT NULL,
  `co` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `time` datetime NOT NULL,
  `parent` int(11) NOT NULL,
  `limit_lidi` int(11) NOT NULL,
  `cena` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `kdy` date NOT NULL AFTER `name`, ADD `do` date NOT NULL AFTER `kdy`, ADD `kde` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `do`, ADD `co` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `kde`, ADD `text` text COLLATE utf8_general_ci NOT NULL AFTER `co`, ADD `time` datetime NOT NULL AFTER `text`, ADD `parent` int(11) NOT NULL AFTER `time`, ADD `limit_lidi` int(11) NOT NULL AFTER `parent`, ADD `cena` int(11) NOT NULL AFTER `limit_lidi`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'plan_akci' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'name' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'kdy' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `kdy` date NOT NULL AFTER `name`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'date' OR _extra != '' OR _column_comment != '' OR after != 'name' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `kdy` date NOT NULL AFTER `name`');
					END IF;
				WHEN 'do' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `do` date NOT NULL AFTER `kdy`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'date' OR _extra != '' OR _column_comment != '' OR after != 'kdy' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `do` date NOT NULL AFTER `kdy`');
					END IF;
				WHEN 'kde' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `kde` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `do`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'do' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `kde` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `do`');
					END IF;
				WHEN 'co' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `co` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `kde`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'kde' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `co` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `kde`');
					END IF;
				WHEN 'text' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `text` text COLLATE utf8_general_ci NOT NULL AFTER `co`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'co' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `text` text COLLATE utf8_general_ci NOT NULL AFTER `co`');
					END IF;
				WHEN 'time' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `time` datetime NOT NULL AFTER `text`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'datetime' OR _extra != '' OR _column_comment != '' OR after != 'text' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `time` datetime NOT NULL AFTER `text`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `time`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'time' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `time`');
					END IF;
				WHEN 'limit_lidi' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `limit_lidi` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `limit_lidi` int(11) NOT NULL AFTER `parent`');
					END IF;
				WHEN 'cena' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `cena` int(11) NOT NULL AFTER `limit_lidi`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'limit_lidi' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `cena` int(11) NOT NULL AFTER `limit_lidi`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `plan_akci`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `plan_akci_prihlaseni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `akce` int(11) NOT NULL,
  `vs` varchar(50) NOT NULL,
  `zaplatil` int(11) NOT NULL,
  `telefonni_cislo` varchar(13) NOT NULL,
  `adresa` text NOT NULL,
  `poznamka` text NOT NULL,
  `mailed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`, ADD `email` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`, ADD `akce` int(11) NOT NULL AFTER `email`, ADD `vs` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `akce`, ADD `zaplatil` int(11) NOT NULL AFTER `vs`, ADD `telefonni_cislo` varchar(13) COLLATE utf8_general_ci NOT NULL AFTER `zaplatil`, ADD `adresa` text COLLATE utf8_general_ci NOT NULL AFTER `telefonni_cislo`, ADD `poznamka` text COLLATE utf8_general_ci NOT NULL AFTER `adresa`, ADD `mailed` int(11) NOT NULL AFTER `poznamka`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'plan_akci_prihlaseni' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'jmeno' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'prijmeni' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'jmeno' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`');
					END IF;
				WHEN 'email' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `email` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(100)' OR _extra != '' OR _column_comment != '' OR after != 'prijmeni' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `email` varchar(100) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`');
					END IF;
				WHEN 'akce' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `akce` int(11) NOT NULL AFTER `email`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'email' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `akce` int(11) NOT NULL AFTER `email`');
					END IF;
				WHEN 'vs' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `vs` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `akce`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'akce' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `vs` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `akce`');
					END IF;
				WHEN 'zaplatil' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `zaplatil` int(11) NOT NULL AFTER `vs`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'vs' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `zaplatil` int(11) NOT NULL AFTER `vs`');
					END IF;
				WHEN 'telefonni_cislo' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `telefonni_cislo` varchar(13) COLLATE utf8_general_ci NOT NULL AFTER `zaplatil`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(13)' OR _extra != '' OR _column_comment != '' OR after != 'zaplatil' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `telefonni_cislo` varchar(13) COLLATE utf8_general_ci NOT NULL AFTER `zaplatil`');
					END IF;
				WHEN 'adresa' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `adresa` text COLLATE utf8_general_ci NOT NULL AFTER `telefonni_cislo`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'telefonni_cislo' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `adresa` text COLLATE utf8_general_ci NOT NULL AFTER `telefonni_cislo`');
					END IF;
				WHEN 'poznamka' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `poznamka` text COLLATE utf8_general_ci NOT NULL AFTER `adresa`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'adresa' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `poznamka` text COLLATE utf8_general_ci NOT NULL AFTER `adresa`');
					END IF;
				WHEN 'mailed' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `mailed` int(11) NOT NULL AFTER `poznamka`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'poznamka' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `mailed` int(11) NOT NULL AFTER `poznamka`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `plan_akci_prihlaseni`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `seting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `value` text COLLATE utf8_general_ci NOT NULL AFTER `name`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'seting' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'name' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `name` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'value' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `value` text COLLATE utf8_general_ci NOT NULL AFTER `name`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'name' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `value` text COLLATE utf8_general_ci NOT NULL AFTER `name`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `seting`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) NOT NULL,
  `popis` text NOT NULL,
  `anot` text NOT NULL,
  `cena` double NOT NULL,
  `dph` double NOT NULL,
  `skladem` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `vyrobce` varchar(50) NOT NULL,
  `doporucujeme` int(11) NOT NULL,
  `show` int(11) NOT NULL,
  `link` varchar(50) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `popis` text COLLATE utf8_general_ci NOT NULL AFTER `nazev`, ADD `anot` text COLLATE utf8_general_ci NOT NULL AFTER `popis`, ADD `cena` double NOT NULL AFTER `anot`, ADD `dph` double NOT NULL AFTER `cena`, ADD `skladem` int(11) NOT NULL AFTER `dph`, ADD `parent` int(11) NOT NULL AFTER `skladem`, ADD `code` varchar(20) COLLATE utf8_general_ci NOT NULL AFTER `parent`, ADD `vyrobce` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `code`, ADD `doporucujeme` int(11) NOT NULL AFTER `vyrobce`, ADD `show` int(11) NOT NULL AFTER `doporucujeme`, ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `show`, ADD `order` int(11) NOT NULL AFTER `link`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'shop' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'nazev' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'popis' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `popis` text COLLATE utf8_general_ci NOT NULL AFTER `nazev`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'nazev' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `popis` text COLLATE utf8_general_ci NOT NULL AFTER `nazev`');
					END IF;
				WHEN 'anot' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `anot` text COLLATE utf8_general_ci NOT NULL AFTER `popis`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'popis' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `anot` text COLLATE utf8_general_ci NOT NULL AFTER `popis`');
					END IF;
				WHEN 'cena' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `cena` double NOT NULL AFTER `anot`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'double' OR _extra != '' OR _column_comment != '' OR after != 'anot' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `cena` double NOT NULL AFTER `anot`');
					END IF;
				WHEN 'dph' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `dph` double NOT NULL AFTER `cena`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'double' OR _extra != '' OR _column_comment != '' OR after != 'cena' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `dph` double NOT NULL AFTER `cena`');
					END IF;
				WHEN 'skladem' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `skladem` int(11) NOT NULL AFTER `dph`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'dph' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `skladem` int(11) NOT NULL AFTER `dph`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `skladem`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'skladem' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `skladem`');
					END IF;
				WHEN 'code' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `code` varchar(20) COLLATE utf8_general_ci NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(20)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `code` varchar(20) COLLATE utf8_general_ci NOT NULL AFTER `parent`');
					END IF;
				WHEN 'vyrobce' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `vyrobce` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `code`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'code' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `vyrobce` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `code`');
					END IF;
				WHEN 'doporucujeme' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `doporucujeme` int(11) NOT NULL AFTER `vyrobce`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'vyrobce' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `doporucujeme` int(11) NOT NULL AFTER `vyrobce`');
					END IF;
				WHEN 'show' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `show` int(11) NOT NULL AFTER `doporucujeme`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'doporucujeme' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `show` int(11) NOT NULL AFTER `doporucujeme`');
					END IF;
				WHEN 'link' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `show`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'show' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `show`');
					END IF;
				WHEN 'order' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `order` int(11) NOT NULL AFTER `link`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'link' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `order` int(11) NOT NULL AFTER `link`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `shop`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `shop_kosik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produkt` int(11) NOT NULL,
  `pocet` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `id_produkt` int(11) NOT NULL AFTER `id`, ADD `pocet` int(11) NOT NULL AFTER `id_produkt`, ADD `user` int(11) NOT NULL AFTER `pocet`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'shop_kosik' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'id_produkt' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_produkt` int(11) NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_produkt` int(11) NOT NULL AFTER `id`');
					END IF;
				WHEN 'pocet' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `pocet` int(11) NOT NULL AFTER `id_produkt`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_produkt' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `pocet` int(11) NOT NULL AFTER `id_produkt`');
					END IF;
				WHEN 'user' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `user` int(11) NOT NULL AFTER `pocet`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'pocet' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `user` int(11) NOT NULL AFTER `pocet`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `shop_kosik`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `shop_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `parent` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `nazev`, ADD `parent` int(11) NOT NULL AFTER `link`, ADD `sort` int(11) NOT NULL AFTER `parent`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'shop_menu' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'nazev' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'link' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `nazev`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'nazev' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `nazev`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `link`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'link' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `link`');
					END IF;
				WHEN 'sort' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `sort` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `sort` int(11) NOT NULL AFTER `parent`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `shop_menu`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `shop_objednavky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cislo` int(11) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `ulice` varchar(50) NOT NULL,
  `obec` varchar(50) NOT NULL,
  `psc` varchar(50) NOT NULL,
  `stat` varchar(50) NOT NULL,
  `poznamka` text NOT NULL,
  `doprava` varchar(50) NOT NULL,
  `cena_bez_dph` double NOT NULL,
  `cena_s_dph` double NOT NULL,
  `datetime` datetime NOT NULL,
  `vyrizeno` int(11) NOT NULL,
  `sended` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `cislo` int(11) NOT NULL AFTER `id`, ADD `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `cislo`, ADD `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`, ADD `mail` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`, ADD `telefon` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `mail`, ADD `ulice` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `telefon`, ADD `obec` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `ulice`, ADD `psc` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obec`, ADD `stat` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `psc`, ADD `poznamka` text COLLATE utf8_general_ci NOT NULL AFTER `stat`, ADD `doprava` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `poznamka`, ADD `cena_bez_dph` double NOT NULL AFTER `doprava`, ADD `cena_s_dph` double NOT NULL AFTER `cena_bez_dph`, ADD `datetime` datetime NOT NULL AFTER `cena_s_dph`, ADD `vyrizeno` int(11) NOT NULL AFTER `datetime`, ADD `sended` int(11) NOT NULL AFTER `vyrizeno`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'shop_objednavky' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'cislo' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `cislo` int(11) NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `cislo` int(11) NOT NULL AFTER `id`');
					END IF;
				WHEN 'jmeno' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `cislo`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'cislo' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `cislo`');
					END IF;
				WHEN 'prijmeni' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'jmeno' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`');
					END IF;
				WHEN 'mail' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `mail` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'prijmeni' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `mail` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`');
					END IF;
				WHEN 'telefon' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `telefon` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `mail`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'mail' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `telefon` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `mail`');
					END IF;
				WHEN 'ulice' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `ulice` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `telefon`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'telefon' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `ulice` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `telefon`');
					END IF;
				WHEN 'obec' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `obec` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `ulice`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'ulice' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `obec` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `ulice`');
					END IF;
				WHEN 'psc' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `psc` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obec`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'obec' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `psc` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obec`');
					END IF;
				WHEN 'stat' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `stat` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `psc`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'psc' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `stat` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `psc`');
					END IF;
				WHEN 'poznamka' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `poznamka` text COLLATE utf8_general_ci NOT NULL AFTER `stat`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'stat' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `poznamka` text COLLATE utf8_general_ci NOT NULL AFTER `stat`');
					END IF;
				WHEN 'doprava' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `doprava` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `poznamka`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'poznamka' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `doprava` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `poznamka`');
					END IF;
				WHEN 'cena_bez_dph' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `cena_bez_dph` double NOT NULL AFTER `doprava`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'double' OR _extra != '' OR _column_comment != '' OR after != 'doprava' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `cena_bez_dph` double NOT NULL AFTER `doprava`');
					END IF;
				WHEN 'cena_s_dph' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `cena_s_dph` double NOT NULL AFTER `cena_bez_dph`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'double' OR _extra != '' OR _column_comment != '' OR after != 'cena_bez_dph' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `cena_s_dph` double NOT NULL AFTER `cena_bez_dph`');
					END IF;
				WHEN 'datetime' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `datetime` datetime NOT NULL AFTER `cena_s_dph`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'datetime' OR _extra != '' OR _column_comment != '' OR after != 'cena_s_dph' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `datetime` datetime NOT NULL AFTER `cena_s_dph`');
					END IF;
				WHEN 'vyrizeno' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `vyrizeno` int(11) NOT NULL AFTER `datetime`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'datetime' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `vyrizeno` int(11) NOT NULL AFTER `datetime`');
					END IF;
				WHEN 'sended' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `sended` int(11) NOT NULL AFTER `vyrizeno`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'vyrizeno' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `sended` int(11) NOT NULL AFTER `vyrizeno`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `shop_objednavky`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `spravce_souboru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modul` varchar(50) NOT NULL,
  `cesta` text NOT NULL,
  `popis` text NOT NULL,
  `parent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `modul` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `cesta` text COLLATE utf8_general_ci NOT NULL AFTER `modul`, ADD `popis` text COLLATE utf8_general_ci NOT NULL AFTER `cesta`, ADD `parent` int(11) NOT NULL AFTER `popis`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'spravce_souboru' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'modul' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `modul` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `modul` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'cesta' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `cesta` text COLLATE utf8_general_ci NOT NULL AFTER `modul`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'modul' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `cesta` text COLLATE utf8_general_ci NOT NULL AFTER `modul`');
					END IF;
				WHEN 'popis' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `popis` text COLLATE utf8_general_ci NOT NULL AFTER `cesta`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'cesta' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `popis` text COLLATE utf8_general_ci NOT NULL AFTER `cesta`');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `popis`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'popis' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `popis`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `spravce_souboru`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(50) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `ulice` varchar(50) NOT NULL,
  `obec` varchar(50) NOT NULL,
  `psc` varchar(50) NOT NULL,
  `stat` varchar(50) NOT NULL,
  `last` datetime NOT NULL,
  `useragent` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `heslo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `hash` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`, ADD `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `hash`, ADD `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`, ADD `mail` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`, ADD `telefon` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `mail`, ADD `ulice` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `telefon`, ADD `obec` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `ulice`, ADD `psc` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obec`, ADD `stat` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `psc`, ADD `last` datetime NOT NULL AFTER `stat`, ADD `useragent` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `last`, ADD `ip` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `useragent`, ADD `heslo` varchar(50) COLLATE utf8_general_ci AFTER `ip`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'hash' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `hash` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `hash` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id`');
					END IF;
				WHEN 'jmeno' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `hash`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'hash' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `hash`');
					END IF;
				WHEN 'prijmeni' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'jmeno' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `prijmeni` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `jmeno`');
					END IF;
				WHEN 'mail' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `mail` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'prijmeni' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `mail` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `prijmeni`');
					END IF;
				WHEN 'telefon' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `telefon` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `mail`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'mail' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `telefon` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `mail`');
					END IF;
				WHEN 'ulice' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `ulice` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `telefon`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'telefon' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `ulice` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `telefon`');
					END IF;
				WHEN 'obec' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `obec` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `ulice`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'ulice' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `obec` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `ulice`');
					END IF;
				WHEN 'psc' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `psc` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obec`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'obec' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `psc` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obec`');
					END IF;
				WHEN 'stat' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `stat` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `psc`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'psc' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `stat` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `psc`');
					END IF;
				WHEN 'last' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `last` datetime NOT NULL AFTER `stat`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'datetime' OR _extra != '' OR _column_comment != '' OR after != 'stat' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `last` datetime NOT NULL AFTER `stat`');
					END IF;
				WHEN 'useragent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `useragent` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `last`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'last' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `useragent` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `last`');
					END IF;
				WHEN 'ip' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `ip` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `useragent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'useragent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `ip` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `useragent`');
					END IF;
				WHEN 'heslo' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `heslo` varchar(50) COLLATE utf8_general_ci AFTER `ip`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'ip' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `heslo` varchar(50) COLLATE utf8_general_ci AFTER `ip`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `users`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `soutez` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id` int(11) NOT NULL auto_increment FIRST, ADD `parent` int(11) NOT NULL AFTER `id`, ADD `soutez` int(11) NOT NULL AFTER `parent`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'parent' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `parent` int(11) NOT NULL AFTER `id`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `parent` int(11) NOT NULL AFTER `id`');
					END IF;
				WHEN 'soutez' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `soutez` int(11) NOT NULL AFTER `parent`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'parent' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `soutez` int(11) NOT NULL AFTER `parent`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_hrac` (
  `id_hrace` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_tymu` int(11) DEFAULT NULL,
  `jmeno` varchar(50) NOT NULL,
  `rozhodci` int(11) NOT NULL,
  `obrazek` varchar(50) DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  PRIMARY KEY (`id_hrace`),
  KEY `FK_hraje_za` (`id_tymu`),
  KEY `FK_spojen` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_hrace` int(11) NOT NULL auto_increment FIRST, ADD `id_user` int(11) AFTER `id_hrace`, ADD `id_tymu` int(11) AFTER `id_user`, ADD `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_tymu`, ADD `rozhodci` int(11) NOT NULL AFTER `jmeno`, ADD `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `rozhodci`, ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_hrac' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_hrace' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_hrace` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_hrace` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'id_user' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_user` int(11) AFTER `id_hrace`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_hrace' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_user` int(11) AFTER `id_hrace`');
					END IF;
				WHEN 'id_tymu' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_tymu` int(11) AFTER `id_user`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_user' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_tymu` int(11) AFTER `id_user`');
					END IF;
				WHEN 'jmeno' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_tymu`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id_tymu' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `jmeno` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_tymu`');
					END IF;
				WHEN 'rozhodci' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `rozhodci` int(11) NOT NULL AFTER `jmeno`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'jmeno' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `rozhodci` int(11) NOT NULL AFTER `jmeno`');
					END IF;
				WHEN 'obrazek' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `rozhodci`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'rozhodci' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `rozhodci`');
					END IF;
				WHEN 'link' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'obrazek' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_hrac`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_hrac_hraje` (
  `id_hrace` int(11) NOT NULL,
  `id_zapasu` int(11) NOT NULL,
  `typ` char(3) NOT NULL,
  PRIMARY KEY (`id_hrace`,`id_zapasu`),
  KEY `FK_vysledky_hrac_hraje2` (`id_zapasu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_hrace` int(11) NOT NULL FIRST, ADD `id_zapasu` int(11) NOT NULL AFTER `id_hrace`, ADD `typ` char(3) COLLATE utf8_general_ci NOT NULL AFTER `id_zapasu`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_hrac_hraje' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_hrace' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_hrace` int(11) NOT NULL FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_hrace` int(11) NOT NULL FIRST');
					END IF;
				WHEN 'id_zapasu' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_zapasu` int(11) NOT NULL AFTER `id_hrace`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_hrace' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_zapasu` int(11) NOT NULL AFTER `id_hrace`');
					END IF;
				WHEN 'typ' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `typ` char(3) COLLATE utf8_general_ci NOT NULL AFTER `id_zapasu`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'char(3)' OR _extra != '' OR _column_comment != '' OR after != 'id_zapasu' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `typ` char(3) COLLATE utf8_general_ci NOT NULL AFTER `id_zapasu`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_hrac_hraje`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_hriste` (
  `id_hriste` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) DEFAULT NULL,
  `adresa` varchar(100) DEFAULT NULL,
  `popis` text,
  `obrazek` varchar(50) DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  PRIMARY KEY (`id_hriste`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_hriste` int(11) NOT NULL auto_increment FIRST, ADD `nazev` varchar(50) COLLATE utf8_general_ci AFTER `id_hriste`, ADD `adresa` varchar(100) COLLATE utf8_general_ci AFTER `nazev`, ADD `popis` text COLLATE utf8_general_ci AFTER `adresa`, ADD `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `popis`, ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_hriste' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_hriste' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_hriste` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_hriste` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'nazev' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `nazev` varchar(50) COLLATE utf8_general_ci AFTER `id_hriste`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id_hriste' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `nazev` varchar(50) COLLATE utf8_general_ci AFTER `id_hriste`');
					END IF;
				WHEN 'adresa' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `adresa` varchar(100) COLLATE utf8_general_ci AFTER `nazev`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(100)' OR _extra != '' OR _column_comment != '' OR after != 'nazev' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `adresa` varchar(100) COLLATE utf8_general_ci AFTER `nazev`');
					END IF;
				WHEN 'popis' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `popis` text COLLATE utf8_general_ci AFTER `adresa`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'text' OR _extra != '' OR _column_comment != '' OR after != 'adresa' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `popis` text COLLATE utf8_general_ci AFTER `adresa`');
					END IF;
				WHEN 'obrazek' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `popis`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'popis' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `popis`');
					END IF;
				WHEN 'link' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'obrazek' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_hriste`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_kolo` (
  `id_kola` int(11) NOT NULL AUTO_INCREMENT,
  `id_souteze` int(11) NOT NULL,
  `poradi` int(11) NOT NULL,
  `nazev` varchar(50) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `sezona` varchar(20) NOT NULL,
  PRIMARY KEY (`id_kola`),
  KEY `FK_patri` (`id_souteze`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_kola` int(11) NOT NULL auto_increment FIRST, ADD `id_souteze` int(11) NOT NULL AFTER `id_kola`, ADD `poradi` int(11) NOT NULL AFTER `id_souteze`, ADD `nazev` varchar(50) COLLATE utf8_general_ci AFTER `poradi`, ADD `datetime` datetime NOT NULL AFTER `nazev`, ADD `sezona` varchar(20) COLLATE utf8_general_ci NOT NULL AFTER `datetime`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_kolo' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_kola' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_kola` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_kola` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'id_souteze' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_souteze` int(11) NOT NULL AFTER `id_kola`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_kola' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_souteze` int(11) NOT NULL AFTER `id_kola`');
					END IF;
				WHEN 'poradi' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `poradi` int(11) NOT NULL AFTER `id_souteze`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_souteze' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `poradi` int(11) NOT NULL AFTER `id_souteze`');
					END IF;
				WHEN 'nazev' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `nazev` varchar(50) COLLATE utf8_general_ci AFTER `poradi`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'poradi' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `nazev` varchar(50) COLLATE utf8_general_ci AFTER `poradi`');
					END IF;
				WHEN 'datetime' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `datetime` datetime NOT NULL AFTER `nazev`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'datetime' OR _extra != '' OR _column_comment != '' OR after != 'nazev' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `datetime` datetime NOT NULL AFTER `nazev`');
					END IF;
				WHEN 'sezona' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `sezona` varchar(20) COLLATE utf8_general_ci NOT NULL AFTER `datetime`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(20)' OR _extra != '' OR _column_comment != '' OR after != 'datetime' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `sezona` varchar(20) COLLATE utf8_general_ci NOT NULL AFTER `datetime`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_kolo`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_rozhodci` (
  `id_utkani` int(11) NOT NULL,
  `id_hrace` int(11) NOT NULL,
  PRIMARY KEY (`id_utkani`,`id_hrace`),
  KEY `FK_rozhodci2` (`id_hrace`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_utkani` int(11) NOT NULL FIRST, ADD `id_hrace` int(11) NOT NULL AFTER `id_utkani`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_rozhodci' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_utkani' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_utkani` int(11) NOT NULL FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_utkani` int(11) NOT NULL FIRST');
					END IF;
				WHEN 'id_hrace' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_hrace` int(11) NOT NULL AFTER `id_utkani`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_utkani' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_hrace` int(11) NOT NULL AFTER `id_utkani`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_rozhodci`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_soutez` (
  `id_souteze` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) NOT NULL,
  PRIMARY KEY (`id_souteze`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_souteze` int(11) NOT NULL auto_increment FIRST, ADD `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_souteze`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_soutez' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_souteze' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_souteze` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_souteze` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'nazev' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_souteze`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id_souteze' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_souteze`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_soutez`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_tym` (
  `id_tymu` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) NOT NULL,
  `kategorie` varchar(50) NOT NULL,
  `web` varchar(50) DEFAULT NULL,
  `obrazek` varchar(50) DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tymu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_tymu` int(11) NOT NULL auto_increment FIRST, ADD `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_tymu`, ADD `kategorie` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `nazev`, ADD `web` varchar(50) COLLATE utf8_general_ci AFTER `kategorie`, ADD `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `web`, ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_tym' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_tymu' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_tymu` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_tymu` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'nazev' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_tymu`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'id_tymu' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `nazev` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `id_tymu`');
					END IF;
				WHEN 'kategorie' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `kategorie` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `nazev`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'nazev' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `kategorie` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `nazev`');
					END IF;
				WHEN 'web' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `web` varchar(50) COLLATE utf8_general_ci AFTER `kategorie`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'kategorie' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `web` varchar(50) COLLATE utf8_general_ci AFTER `kategorie`');
					END IF;
				WHEN 'obrazek' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `web`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'web' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `obrazek` varchar(50) COLLATE utf8_general_ci AFTER `web`');
					END IF;
				WHEN 'link' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'varchar(50)' OR _extra != '' OR _column_comment != '' OR after != 'obrazek' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `link` varchar(50) COLLATE utf8_general_ci NOT NULL AFTER `obrazek`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_tym`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_utkani` (
  `id_utkani` int(11) NOT NULL AUTO_INCREMENT,
  `id_kola` int(11) NOT NULL,
  `id_host` int(11) DEFAULT NULL,
  `id_hriste` int(11) DEFAULT NULL,
  `id_domaci` int(11) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `divaci` int(11) DEFAULT NULL,
  `overeno` int(11) NOT NULL,
  `kontumace` char(1) NOT NULL,
  PRIMARY KEY (`id_utkani`),
  KEY `FK_domaci` (`id_domaci`),
  KEY `FK_hoste` (`id_host`),
  KEY `FK_hraje` (`id_kola`),
  KEY `FK_hraje_na` (`id_hriste`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_utkani` int(11) NOT NULL auto_increment FIRST, ADD `id_kola` int(11) NOT NULL AFTER `id_utkani`, ADD `id_host` int(11) AFTER `id_kola`, ADD `id_hriste` int(11) AFTER `id_host`, ADD `id_domaci` int(11) AFTER `id_hriste`, ADD `datetime` datetime NOT NULL AFTER `id_domaci`, ADD `divaci` int(11) AFTER `datetime`, ADD `overeno` int(11) NOT NULL AFTER `divaci`, ADD `kontumace` char(1) COLLATE utf8_general_ci NOT NULL AFTER `overeno`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_utkani' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_utkani' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_utkani` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_utkani` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'id_kola' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_kola` int(11) NOT NULL AFTER `id_utkani`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_utkani' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_kola` int(11) NOT NULL AFTER `id_utkani`');
					END IF;
				WHEN 'id_host' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_host` int(11) AFTER `id_kola`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_kola' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_host` int(11) AFTER `id_kola`');
					END IF;
				WHEN 'id_hriste' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_hriste` int(11) AFTER `id_host`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_host' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_hriste` int(11) AFTER `id_host`');
					END IF;
				WHEN 'id_domaci' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_domaci` int(11) AFTER `id_hriste`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_hriste' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_domaci` int(11) AFTER `id_hriste`');
					END IF;
				WHEN 'datetime' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `datetime` datetime NOT NULL AFTER `id_domaci`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'datetime' OR _extra != '' OR _column_comment != '' OR after != 'id_domaci' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `datetime` datetime NOT NULL AFTER `id_domaci`');
					END IF;
				WHEN 'divaci' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `divaci` int(11) AFTER `datetime`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'YES' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'datetime' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `divaci` int(11) AFTER `datetime`');
					END IF;
				WHEN 'overeno' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `overeno` int(11) NOT NULL AFTER `divaci`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'divaci' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `overeno` int(11) NOT NULL AFTER `divaci`');
					END IF;
				WHEN 'kontumace' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `kontumace` char(1) COLLATE utf8_general_ci NOT NULL AFTER `overeno`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'char(1)' OR _extra != '' OR _column_comment != '' OR after != 'overeno' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `kontumace` char(1) COLLATE utf8_general_ci NOT NULL AFTER `overeno`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_utkani`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_vysledek` (
  `id_vysledku` int(11) NOT NULL AUTO_INCREMENT,
  `id_zapasu` int(11) NOT NULL,
  `domaci` int(11) NOT NULL,
  `hoste` int(11) NOT NULL,
  PRIMARY KEY (`id_vysledku`),
  KEY `FK_skoncil` (`id_zapasu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_vysledku` int(11) NOT NULL auto_increment FIRST, ADD `id_zapasu` int(11) NOT NULL AFTER `id_vysledku`, ADD `domaci` int(11) NOT NULL AFTER `id_zapasu`, ADD `hoste` int(11) NOT NULL AFTER `domaci`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_vysledek' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_vysledku' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_vysledku` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_vysledku` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'id_zapasu' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_zapasu` int(11) NOT NULL AFTER `id_vysledku`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_vysledku' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_zapasu` int(11) NOT NULL AFTER `id_vysledku`');
					END IF;
				WHEN 'domaci' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `domaci` int(11) NOT NULL AFTER `id_zapasu`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_zapasu' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `domaci` int(11) NOT NULL AFTER `id_zapasu`');
					END IF;
				WHEN 'hoste' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `hoste` int(11) NOT NULL AFTER `domaci`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'domaci' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `hoste` int(11) NOT NULL AFTER `domaci`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_vysledek`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


CREATE TABLE IF NOT EXISTS `vysledky_zapas` (
  `id_zapasu` int(11) NOT NULL AUTO_INCREMENT,
  `id_utkani` int(11) NOT NULL,
  `typ` char(20) NOT NULL,
  PRIMARY KEY (`id_zapasu`),
  KEY `FK_patri_do` (`id_utkani`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DELIMITER ;;
CREATE PROCEDURE adminer_alter (INOUT alter_command text) BEGIN
	DECLARE _column_name, _collation_name, after varchar(64) DEFAULT '';
	DECLARE _column_type, _column_default text;
	DECLARE _is_nullable char(3);
	DECLARE _extra varchar(30);
	DECLARE _column_comment varchar(255);
	DECLARE done, set_after bool DEFAULT 0;
	DECLARE add_columns text DEFAULT ', ADD `id_zapasu` int(11) NOT NULL auto_increment FIRST, ADD `id_utkani` int(11) NOT NULL AFTER `id_zapasu`, ADD `typ` char(20) COLLATE utf8_general_ci NOT NULL AFTER `id_utkani`';
	DECLARE columns CURSOR FOR SELECT COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, COLLATION_NAME, COLUMN_TYPE, EXTRA, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'vysledky_zapas' ORDER BY ORDINAL_POSITION;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	SET @alter_table = '';
	OPEN columns;
	REPEAT
		FETCH columns INTO _column_name, _column_default, _is_nullable, _collation_name, _column_type, _extra, _column_comment;
		IF NOT done THEN
			SET set_after = 1;
			CASE _column_name
				WHEN 'id_zapasu' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_zapasu` int(11) NOT NULL auto_increment FIRST', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != 'auto_increment' OR _column_comment != '' OR after != '' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_zapasu` int(11) NOT NULL auto_increment FIRST');
					END IF;
				WHEN 'id_utkani' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `id_utkani` int(11) NOT NULL AFTER `id_zapasu`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != '' OR _column_type != 'int(11)' OR _extra != '' OR _column_comment != '' OR after != 'id_zapasu' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `id_utkani` int(11) NOT NULL AFTER `id_zapasu`');
					END IF;
				WHEN 'typ' THEN
					SET add_columns = REPLACE(add_columns, ', ADD `typ` char(20) COLLATE utf8_general_ci NOT NULL AFTER `id_utkani`', '');
					IF NOT (_column_default <=> NULL) OR _is_nullable != 'NO' OR _collation_name != 'utf8_general_ci' OR _column_type != 'char(20)' OR _extra != '' OR _column_comment != '' OR after != 'id_utkani' THEN
						SET @alter_table = CONCAT(@alter_table, ', MODIFY `typ` char(20) COLLATE utf8_general_ci NOT NULL AFTER `id_utkani`');
					END IF;
				ELSE
					SET @alter_table = CONCAT(@alter_table, ', DROP ', _column_name);
					SET set_after = 0;
			END CASE;
			IF set_after THEN
				SET after = _column_name;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE columns;
	IF @alter_table != '' OR add_columns != '' THEN
		SET alter_command = CONCAT(alter_command, 'ALTER TABLE `vysledky_zapas`', SUBSTR(CONCAT(add_columns, @alter_table), 2), ';\n');
	END IF;
END;;
DELIMITER ;
CALL adminer_alter(@adminer_alter);
DROP PROCEDURE adminer_alter;


SELECT @adminer_alter;
-- 2011-05-15 13:54:44