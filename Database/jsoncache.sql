CREATE TABLE IF NOT EXISTS `jsoncache` (
  `url` varchar(255) NOT NULL,
  `date_saved` datetime NOT NULL,
  `time_to_live` int(9) NOT NULL,
  `json` blob NOT NULL,
  PRIMARY KEY (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;