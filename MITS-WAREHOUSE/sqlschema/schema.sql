CREATE DATABASE IF NOT EXISTS mitswarehouse;

USE mitswarehouse;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `mitswarehouse`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appuse`
--

CREATE TABLE IF NOT EXISTS `appusers` (
  `id_mitsuser` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `genderLastLetter` varchar(1) NOT NULL,  
  PRIMARY KEY (`id_mitsuser`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(11) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `id_location` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sample_link` varchar(2000) DEFAULT NULL,
  `loanable` tinyint(1) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_provider` int(11),
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `assets_files`
--

CREATE TABLE IF NOT EXISTS `assets_files` (
  `id_asset` int(11) NOT NULL,
  `folder_photo` varchar(2000) DEFAULT NULL,
  `folder_documents` varchar(2000) DEFAULT NULL,
  `folder_3d` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id_asset`),
  KEY `id_asset` (`id_asset`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `assets_responsibles`
--

CREATE TABLE IF NOT EXISTS `assets_responsibles` (
  `id_asset` int(11) NOT NULL,
  `id_mitsuser` int(11) NOT NULL,
  PRIMARY KEY (`id_asset`,`id_mitsuser`),
  KEY `id_asset` (`id_asset`,`id_mitsuser`),
  KEY `id_mitsuser` (`id_mitsuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `loans`
--

CREATE TABLE IF NOT EXISTS `loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `id_appuser_opening` int(11) NOT NULL,
  `id_mitsuser_loaner` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_appuser_opening` (`id_appuser_opening`),
  KEY `id_mitsuser_loaner` (`id_mitsuser_loaner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `assets_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `help_desk_name` varchar(300) DEFAULT NULL,
  `help_desk_mail` varchar(300) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `website` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_provider_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

--
-- Struttura della tabella `mitsusers`
--

CREATE TABLE IF NOT EXISTS `mitsusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `subloans`
--

CREATE TABLE IF NOT EXISTS `subloans` (
  `id_loan` int(11) NOT NULL,
  `id_asset` int(11) NOT NULL,
  `end_date` date NOT NULL,
  `id_responsible` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_loan`,`id_asset`),
  KEY `id_asset` (`id_asset`),
  KEY `id_responsible` (`id_responsible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `assets_details` (
  `id_asset` int(11) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(200) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `dimensions_whd` varchar(100) DEFAULT NULL,
  `weight` decimal(10,4) DEFAULT NULL,
  `power` decimal(10,4) DEFAULT NULL,
  PRIMARY KEY (`id_asset`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `maintenance_kinds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `maintenances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `id_asset` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `duration_min` int(11) DEFAULT NULL,
  `id_internal_maintainer` int(11) DEFAULT NULL,
  `is_internal_maintainer` tinyint(1) NOT NULL DEFAULT 1,
  `notes` varchar(1000) DEFAULT NULL,
  `id_maintenance_kind` int(11) NOT NULL,
  `folder_img_path` varchar(300) DEFAULT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_maintainer` (`id_internal_maintainer`),
  KEY `idx_maintenance_kind` (`id_maintenance_kind`),
  KEY  `idx_maintenance_asset` (`id_asset`),
  KEY `idx_maintenance_closed` (`closed`);
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Limiti per le tabelle scaricate
--


--
-- CHIAVI ESTERNE
--

ALTER TABLE appusers
ADD FOREIGN KEY (id_mitsuser)
REFERENCES mitsusers(id);

ALTER TABLE assets 
ADD FOREIGN KEY (id_location)
REFERENCES locations(id);

ALTER TABLE assets 
ADD FOREIGN KEY (id_category)
REFERENCES assets_categories(id);

ALTER TABLE assets 
ADD FOREIGN KEY (id_provider)
REFERENCES providers(id);

ALTER TABLE assets_files 
ADD FOREIGN KEY (id_asset)
REFERENCES assets(id);

ALTER TABLE assets_responsibles 
ADD FOREIGN KEY (id_asset)
REFERENCES assets(id);

ALTER TABLE assets_responsibles 
ADD FOREIGN KEY (id_mitsuser)
REFERENCES mitsusers(id);

ALTER TABLE loans 
ADD FOREIGN KEY (id_appuser_opening)
REFERENCES appusers(id_mitsuser);

ALTER TABLE loans 
ADD FOREIGN KEY (id_mitsuser_loaner)
REFERENCES mitsusers(id);

ALTER TABLE subloans 
ADD FOREIGN KEY (id_asset)
REFERENCES assets(id);

ALTER TABLE subloans 
ADD FOREIGN KEY (id_loan)
REFERENCES loans(id);

ALTER TABLE subloans 
ADD FOREIGN KEY (id_responsible)
REFERENCES mitsusers(id);

ALTER TABLE mitsusers 
ADD FOREIGN KEY (id_role)
REFERENCES roles(id);


ALTER TABLE maintenances
ADD FOREIGN KEY (id_asset)
REFERENCES assets(id);

ALTER TABLE maintenances
ADD FOREIGN KEY (id_maintenance_kind)
REFERENCES maintenance_kinds(id);

--
-- DATI DI DEFAULT
--
INSERT INTO `roles` (`id`, `description`) VALUES
(1, 'segreteria'),
(2, 'formatore'),
(3, 'corsista'),
(4, 'coordinatore'),
(5, 'esterno');

INSERT INTO `mitsusers` (`id`, `name`, `surname`, `email`, `phone`, `id_role`) VALUES ('1', 'tmpname', 'tmpsurname', 'tmpemail', NULL, '1');

INSERT INTO `appusers` (`id_mitsuser`, `username`, `password`, `genderLastLetter`) VALUES ('1', 'tmpuser', '$2y$10$g2vE0hi2875/SzGAxkZKwOzrfxaBKbCFejhlA6FaDonwiHPDxfXiu', 'o');