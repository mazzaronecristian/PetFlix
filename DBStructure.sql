--
-- DataBase: 'petflix'
--

--
-- Table structure for table `impostazioni`
--

CREATE TABLE `impostazioni` (
  `id` int(11) NOT NULL,
  `description` VARCHAR(11) NOT NULL,
  `state` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


CREATE TABLE `pesi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE `orari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controlFlag` bit NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

