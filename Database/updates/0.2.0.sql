INSERT INTO `settings` (`key_name`, `key_value`)
VALUES ('db_version', '0.2.0') ON DUPLICATE KEY
UPDATE  `key_value` = '0.2.0';

CREATE TABLE IF NOT EXISTS `jsoncache` (
  `url` varchar(255) NOT NULL,
  `date_saved` datetime NOT NULL,
  `time_to_live` int(9) NOT NULL,
  `json` blob NOT NULL,
  PRIMARY KEY (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;