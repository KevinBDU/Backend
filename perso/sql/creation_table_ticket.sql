USE `greengarden`;

DROP TABLE IF EXISTS `t_d_statut_ticket`;

CREATE TABLE `t_d_statut_ticket` (
  `Id_Statut` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle_Statut` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Statut`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `t_d_motif_ticket`;

CREATE TABLE `t_d_motif_ticket` (
  `Id_Motif` int(11) NOT NULL AUTO_INCREMENT,
  `Libelle_Statut` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Motif`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/*Table structure for table `t_d_ticket` */

DROP TABLE IF EXISTS `t_d_ticket`;

CREATE TABLE `t_d_ticket` (
  `Id_Ticket` int(11) NOT NULL AUTO_INCREMENT,
  `Num_Ticket` varchar(50) NOT NULL,
  `Num_Commande` varchar(50) NOT NULL,
  `Date_Ticket` datetime NOT NULL,
  `Titre_Ticket` varchar(50) NOT NULL,
  `Text_Ticket` varchar(255) NOT NULL,
  `Id_Statut` int(11) NOT NULL,
  `Id_Motif` int(11) NOT NULL,
  `Id_User` int(11) NOT NULL,
  PRIMARY KEY (`Id_Ticket`),
  KEY `Id_Statut` (`Id_Statut`),
  KEY `Id_Motif` (`Id_Motif`),
  KEY `Id_User` (`Id_User`),
  CONSTRAINT `t_d_ticket_ibfk_1` FOREIGN KEY (`Id_Statut`) REFERENCES `t_d_statut_ticket` (`Id_Statut`),
  CONSTRAINT `t_d_ticket_ibfk_2` FOREIGN KEY (`Id_Motif`) REFERENCES `t_d_motif_ticket` (`Id_Motif`),
  CONSTRAINT `t_d_ticket_ibfk_3` FOREIGN KEY (`Id_User`) REFERENCES `t_d_user` (`Id_User`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER $$
CREATE TRIGGER `tr_generate_num_ticket` BEFORE INSERT ON `t_d_ticket` FOR EACH ROW BEGIN
    DECLARE prefix CHAR(3) DEFAULT 'TKT';
    DECLARE num INT;

    SELECT COUNT(*) INTO num FROM t_d_ticket;
    SET num = num + 1;

    SET NEW.num_ticket = CONCAT(prefix, LPAD(num, 7, '0'));
END
$$
DELIMITER ;