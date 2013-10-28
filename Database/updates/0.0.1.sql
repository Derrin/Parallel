CREATE TABLE IF NOT EXISTS `settings` (
  `key_name` varchar(50) NOT NULL,
  `key_value` varchar(255) NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`key_name`, `key_value`)
VALUES ('db_version', '0.0.1') ON DUPLICATE KEY
UPDATE  `key_value` = '0.0.1';