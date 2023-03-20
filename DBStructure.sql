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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE `pesi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE `orari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controlFlag` bit NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE `utenti` (
  `email` VARCHAR(50) PRIMARY KEY,
  `nome` VARCHAR(50) NOT NULL,
  `pwd` VARCHAR(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `schede` (
  `id` int(11) PRIMARY KEY,
  `nome` VARCHAR(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;

CREATE TABLE `utenti_schede` (
  `scheda` int(11) NOT NULL,
  `utente` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`utente`, `scheda`),
  FOREIGN KEY (`utente`) REFERENCES utenti(`email`),
  FOREIGN KEY (`scheda`) REFERENCES schede(`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;


