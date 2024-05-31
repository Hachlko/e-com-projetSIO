-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 31 mai 2024 à 21:43
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_pooltime_maris`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCateg` smallint NOT NULL AUTO_INCREMENT,
  `nomCateg` varchar(50) NOT NULL,
  PRIMARY KEY (`idCateg`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf32;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCateg`, `nomCateg`) VALUES
(1, 'Filtre-Cartouche'),
(2, 'Piscine');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `numCmd` smallint NOT NULL AUTO_INCREMENT,
  `dateCmd` date NOT NULL,
  `userId` smallint NOT NULL,
  `montantCmd` double NOT NULL,
  PRIMARY KEY (`numCmd`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`numCmd`, `dateCmd`, `userId`, `montantCmd`) VALUES
(2, '2024-05-31', 6, 18.99);

-- --------------------------------------------------------

--
-- Structure de la table `detailscmd`
--

DROP TABLE IF EXISTS `detailscmd`;
CREATE TABLE IF NOT EXISTS `detailscmd` (
  `numCmd` smallint NOT NULL,
  `idProduit` smallint NOT NULL,
  `qteCmd` smallint NOT NULL,
  PRIMARY KEY (`numCmd`,`idProduit`),
  KEY `idProduit` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Déchargement des données de la table `detailscmd`
--

INSERT INTO `detailscmd` (`numCmd`, `idProduit`, `qteCmd`) VALUES
(2, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `idProduit` smallint NOT NULL AUTO_INCREMENT,
  `nomProduit` varchar(50) NOT NULL,
  `codeCateg` smallint NOT NULL,
  `prixUnit` decimal(10,2) NOT NULL,
  `qteStock` smallint NOT NULL,
  `descProduit` varchar(300) NOT NULL,
  `pathImg` varchar(50) NOT NULL,
  PRIMARY KEY (`idProduit`),
  KEY `codeCateg` (`codeCateg`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf32;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`idProduit`, `nomProduit`, `codeCateg`, `prixUnit`, `qteStock`, `descProduit`, `pathImg`) VALUES
(1, 'Tuyau 6m', 1, 18.99, 20, 'Tuyau pour piscine, Tuyau piscine bleu, Ø 38 mm, Idéal pour filtres à sables, aspirateurs de piscine,\r\n pour grandes piscines, Divisible tous les 158 cm, longueur 6,3 m, Adaptable et stable sous pression, résistent aux UV', 'tuyauPiscine.jpg'),
(2, 'Nettoyant Filtre Piscine', 1, 19.90, 30, 'Bidon de 5L, Nettoie et détartre les filtres à sable, les cartouches, les toiles à diatomées et les cellules d\'électrolyseurs au sels', 'nettoyantFP5L.jpg'),
(3, 'Média Filtrant Cartouche FX', 1, 220.30, 50, 'Filtre de rechange pour cartouche FX (FX30, FX40 ou FX50) à partir de 2005', 'mediaFCartouche.jpg'),
(4, 'Cartouche FX', 1, 130.30, 50, 'La cartouche FX sans papier et sans média comprend : un rivet jupe cartouche, \r\nun opercule imperdable, un clapet, une entretroise', 'cartoucheP.jpg'),
(5, 'Pré-filtre pour cartouche', 1, 18.50, 50, 'Le sachet de 2 chaussettes FX est adaptable sur la cartouche de filtration FX. \r\nCe produit est vendu par lot de 2 exemplaires.', 'chaussettes.jpg'),
(6, 'Crépine d\'aspiration cartouche FX', 1, 30.50, 50, 'La crépine d\'aspiration permet de retenir les éventuelles impuretés et débris afin d\'empêcher que ces derniers remontent au niveau du \r\nsystème hydraulique de filtration et occasionnent des dommages. Attention, ce modèle ne convient pas pour les piscines FX50 dont la crépine est plus grande.\r\n', 'crepine.jpg'),
(7, 'Panier skimmer', 1, 7.50, 150, 'Panier avec anse pour le skimmer PRESTIGE', 'panieranse.jpg'),
(8, 'Cartouche filtrante pour spas ', 1, 87.50, 150, 'Cartouche Filtrante pour SPA', 'cartoucheFil.jpg'),
(9, 'Couvercle panier cartouche NFX', 1, 146.50, 150, 'Couvercle de panier convertible FX', 'couvPanier.jpg'),
(10, 'Cartouche P-Filtre consommable', 1, 190.00, 150, 'Gardez une eau propre et saine avec la cartouche Perfect Filtre de Piscines Magiline.\r\n\r\nCe produit est un média filtrant de rechange adapté pour le système de filtration Perfect Filtre, exclusivité Piscines Magiline.', 'cartouchePFiltre.jpg'),
(11, 'Cartouche filtrante balai aspirateur', 1, 221.50, 150, 'Cartouche filtrante pour balai Magiline Magi\'sweep. Pour les piscines équipées d\'un surpresseur.', 'cartoucheBalais.jpg'),
(12, 'Extracteur manuel de cartouche NFX', 1, 186.50, 150, 'Votre piscine dispose du nouveau bloc de filtration NFX (piscine à partir de 2021) ? Ce produit vous permettra d\'extraire les différents composants de vos cartouches et vous évitera les tensions au niveau du bras ou du dos, sans avoir à se baisser.', 'extracteur.jpg'),
(13, 'Panier cartouche FX', 1, 246.50, 150, 'Panier \"pré-filtre\", pour une capacité élevée de rétention des particules de votre bassin.', 'cartFXassemble.jpg'),
(14, 'Cartouche FX (ensemble complet)', 1, 446.50, 150, 'Cet ensemble est adapté pour les filtrations FX30, FX40 et auxiliaires FX50.\r\nIl se compose d\'une cartouche FX (forme nid d\'abeille), d\'un panier skimmer (avec anse et volet), d\'un média filtrant FX et d\'un MAGIskim.', 'pack.jpg'),
(15, 'Modèle Biarritz', 2, 1249.49, 5, 'Vous cherchez un modèle de piscine design ? Avec des lignes droites et l’escalier arrondi, Piscines Magiline vous présente la piscine design modèle Biarritz, très élégante.', 'piscine-biarritz.jpg'),
(16, 'Modèle Miami', 2, 1299.49, 5, 'La piscine MIAMI est sans doute l\'une des formes les plus traditionnelles, elle apportera à votre jardin une touche d\'exotisme.', 'piscine-miami.jpg'),
(17, 'Modèle Horizon', 2, 1399.49, 5, 'Vous cherchez une piscine qui s’intègre parfaitement dans le paysage ? Magiline vous propose la piscine à débordement Horizon, un modèle qui donnera une note distinctive à votre jardin.', 'piscine-horizon.jpg'),
(18, 'Modèle Olympique', 2, 1399.49, 5, 'Enchaînez des longueurs de bassin jusqu\'a 20 m grâce à la piscine OLYMPIQUE, le couloir de nage de PoolTime', 'piscine-olympic.jpg'),
(19, 'Modèle Intérieure', 2, 1299.49, 5, 'PoolTime utilise son savoir-faire technique dans le domaine des piscines intérieures pour créer des bassins de maison en accord avec tout style : piscine rustique en bois, piscine de luxe, piscine contemporaine…', 'piscine-interieure.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUser` smallint NOT NULL AUTO_INCREMENT,
  `uNom` varchar(30) NOT NULL,
  `uPrenom` varchar(30) NOT NULL,
  `uAdr` varchar(110) NOT NULL,
  `uVille` varchar(50) NOT NULL,
  `uCp` smallint NOT NULL,
  `uMail` varchar(50) NOT NULL,
  `uPassword` varchar(75) CHARACTER SET utf32 COLLATE utf32_general_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `uMail` (`uMail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf32;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUser`, `uNom`, `uPrenom`, `uAdr`, `uVille`, `uCp`, `uMail`, `uPassword`, `isAdmin`) VALUES
(1, 'Menvussat', 'Gerard', '66 rue de la Tramontane', 'Font-Romeu', 32767, 'gegemenvussat@gmail.com', 'gegegevu', 1),
(6, 'Kuri', 'Kori', '5 rue des pochtrons', 'Montpellier', 32767, 'kurikori@gmail.com', '9cf95dacd226dcf43da376cdb6cbba7035218921', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `utilisateur` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
