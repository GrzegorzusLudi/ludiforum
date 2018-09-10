-- MySQL dump 10.13  Distrib 5.7.15, for Win64 (x86_64)
--
-- Host: localhost    Database: forum
-- ------------------------------------------------------
-- Server version	5.7.15-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dzial`
--

DROP TABLE IF EXISTS `dzial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dzial` (
  `ID` int(11) NOT NULL,
  `Nazwa` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `Opis` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
  `Zablokowany` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER usundzial AFTER DELETE on dzial
FOR EACH ROW
BEGIN
DELETE FROM temat
    WHERE temat.DzialID = old.ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;

--
-- Table structure for table `haslo`
--

DROP TABLE IF EXISTS `haslo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `haslo` (
  `UserID` int(11) DEFAULT NULL,
  `Haslo` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prywatnawiadomosc`
--

DROP TABLE IF EXISTS `prywatnawiadomosc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prywatnawiadomosc` (
  `ID` int(11) NOT NULL,
  `DataWyslania` date DEFAULT NULL,
  `NadawcaID` int(11) DEFAULT NULL,
  `OdbiorcaID` int(11) DEFAULT NULL,
  `Tresc` varchar(20000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `temat`
--

DROP TABLE IF EXISTS `temat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temat` (
  `ID` int(11) NOT NULL,
  `ZalozycielID` int(11) DEFAULT NULL,
  `DzialID` int(11) DEFAULT NULL,
  `DataWyslania` date DEFAULT NULL,
  `Tytul` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `Zablokowany` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER usuntemat AFTER DELETE on temat
FOR EACH ROW
BEGIN
DELETE FROM wiadomosc
    WHERE wiadomosc.TematID = old.ID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;

--
-- Table structure for table `uzytkownik`
--

DROP TABLE IF EXISTS `uzytkownik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uzytkownik` (
  `ID` int(11) NOT NULL,
  `Nazwa` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `DataDolaczenia` date DEFAULT NULL,
  `Uprawnienia` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `OstatniaWizyta` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Nazwa` (`Nazwa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wiadomosc`
--

DROP TABLE IF EXISTS `wiadomosc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiadomosc` (
  `ID` int(11) NOT NULL,
  `TematID` int(11) DEFAULT NULL,
  `AutorID` int(11) DEFAULT NULL,
  `tresc` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DataWyslania` date DEFAULT NULL,
  `IndeksWTemacie` int(11) DEFAULT NULL,
  `OdpowiedzDo` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'forum'
--
/*!50003 DROP FUNCTION IF EXISTS `login` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `login`(Inazwa varchar(20),Ihaslo varchar(50)) RETURNS int(11)
begin
	declare i int;
	set @i = (select count(uzytkownik.ID) from uzytkownik inner join haslo on uzytkownik.ID=haslo.UserID where Nazwa=Inazwa and Haslo=password(concat(Ihaslo,'zucc')));
    return @i;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP FUNCTION IF EXISTS `uzyt_stron` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `uzyt_stron`() RETURNS int(11)
begin
	declare i int;
	set @i = ((SELECT count(ID) from uzytkownik) div 20) + 1;
    return @i;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `dzialy` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `dzialy`()
BEGIN
SELECT dzial.ID,Nazwa,Opis,dzial.Zablokowany,count(distinct temat.ID) as tematy,count(wiadomosc.ID) as wiadomosci FROM dzial left outer join temat on dzial.ID=temat.DzialID left outer join wiadomosc on wiadomosc.TematID=temat.ID group by dzial.ID;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `nowydzial` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `nowydzial`(in Itytul varchar(30),in Iopis varchar(120))
BEGIN
	
    DECLARE i int;
    IF (SELECT count(ID) from dzial)>0 THEN
		SET @i = (SELECT max(ID) FROM dzial)+1;
    ELSE
		SET @i = 0;
	END IF;
    insert into dzial values(@i,Itytul,Iopis,false);
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `nowytemat` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `nowytemat`(in zalozyciel varchar(20),in dzialid int,in Itytul varchar(40),in Itresc varchar(20000))
BEGIN
	
    DECLARE i int;
    DECLARE j int;
    IF (SELECT count(ID) from temat)>0 THEN
		SET @i = (SELECT max(ID) FROM temat)+1;
    ELSE
		SET @i = 0;
	END IF;
    IF (SELECT count(ID) from wiadomosc)>0 THEN
		SET @j = (SELECT max(ID) FROM wiadomosc)+1;
    ELSE
		SET @j = 0;
	END IF;
    IF (SELECT count(ID) from uzytkownik where Nazwa=zalozyciel)>0 then
		
		insert into temat values(@i,(SELECT ID from uzytkownik where Nazwa=zalozyciel),dzialid,CURDATE(),Itytul,false);
        
		insert into wiadomosc values(@j,@i,(SELECT ID from uzytkownik where Nazwa=zalozyciel),Itresc,CURDATE(),0,0);
        
    end if;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `odpowiedz` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `odpowiedz`(in idtemat int,in autor varchar(20),in Itresc varchar(20000),in odpowiedz int)
BEGIN
	DECLARE j int;
	DECLARE k int;
	SET @k = (SELECT max(IndeksWTemacie) FROM wiadomosc where TematID=idtemat)+1;
    IF (SELECT count(ID) from wiadomosc)>0 THEN
		SET @j = (SELECT max(ID) FROM wiadomosc)+1;
    ELSE
		SET @j = 0;
	END IF;
    IF (SELECT count(ID) from uzytkownik where Nazwa=autor)>0 then
		insert into wiadomosc values(@j,idTemat,(SELECT ID from uzytkownik where Nazwa=autor),Itresc,CURDATE(),@k,odpowiedz);
        update temat set DataWyslania=CURDATE() where ID=idtemat;
	end if;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `pwiadomosc` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `pwiadomosc`(in Inadawca varchar(20),in Iodbiorca varchar(20),in Itresc varchar(20000))
BEGIN
	DECLARE j int;
    IF (SELECT count(ID) from prywatnawiadomosc)>0 THEN
		SET @j = (SELECT max(ID) FROM prywatnawiadomosc)+1;
    ELSE
		SET @j = 0;
	END IF;
    IF Inadawca!=Iodbiorca and (SELECT count(ID) from uzytkownik where Nazwa=Inadawca)>0 and (SELECT count(ID) from uzytkownik where Nazwa=Iodbiorca)>0 then
		insert into prywatnawiadomosc values(@j,CURDATE(),(SELECT ID from uzytkownik where Nazwa=Inadawca),(SELECT ID from uzytkownik where Nazwa=Iodbiorca),Itresc);
	end if;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `pwiadomosci` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `pwiadomosci`(in iodbiorca varchar(20))
BEGIN
SELECT prywatnawiadomosc.ID,DataWyslania,Tresc,nadawca.Nazwa as nad,odbiorca.Nazwa as odb from prywatnawiadomosc inner join uzytkownik as nadawca on prywatnawiadomosc.NadawcaID=nadawca.ID inner join uzytkownik as odbiorca on prywatnawiadomosc.OdbiorcaID=odbiorca.ID where odbiorca.Nazwa=iodbiorca order by id desc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `rejestruj` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `rejestruj`(in Inazwa varchar(20),in Ihaslo varchar(50))
BEGIN
	DECLARE i int;
	SET @i = (SELECT max(ID) FROM uzytkownik);
	insert into uzytkownik values(@i+1,Inazwa,CURDATE(),'Normalny',CURDATE());
	insert into haslo values(@i+1,password(concat(Ihaslo,'zucc')));
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `tematUp` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `tematUp`(in Inazwa varchar(20),in Ihaslo varchar(50),in tID int)
BEGIN
declare str int;
SELECT COUNT(*) FROM uzytkownik inner join haslo on uzytkownik.ID=haslo.UserID inner join temat on uzytkownik.ID=temat.ZalozycielID where Nazwa=Inazwa and Haslo=password(concat(Ihaslo,'zucc')) and temat.ID=tID;
UPDATE uzytkownik set OstatniaWizyta=CURDATE() where Nazwa=Inazwa;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `tematy` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `tematy`(in idzial int,in Inazwa varchar(20),in Ihaslo varchar(50))
BEGIN
SELECT temat.ID,Tytul,count(wiadomosc.ID)-1 as odp,(select Nazwa from uzytkownik where uzytkownik.ID=ZalozycielID) as uzyt,temat.DataWyslania,Zablokowany,(select count(*) from uzytkownik inner join haslo on uzytkownik.ID=haslo.UserID where uzytkownik.Nazwa=Inazwa and haslo.Haslo=password(concat(Ihaslo,'zucc')) and uzytkownik.ID=temat.ZalozycielID) as prawo FROM temat inner join wiadomosc on temat.ID=wiadomosc.TematID where temat.DzialID=idzial group by temat.ID order by DataWyslania desc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `uprawnienia` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `uprawnienia`(in Inazwa varchar(20),in Ihaslo varchar(50))
BEGIN
declare str int;
SELECT Uprawnienia FROM uzytkownik inner join haslo on uzytkownik.ID=haslo.UserID where Nazwa=Inazwa and Haslo=password(concat(Ihaslo,'zucc'));
UPDATE uzytkownik set OstatniaWizyta=CURDATE() where Nazwa=Inazwa;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `uzytkownicy` */;
ALTER DATABASE `forum` CHARACTER SET utf8 COLLATE utf8_general_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `uzytkownicy`(in strona int)
BEGIN
declare str int;
SET @str = (strona-1)*20;
SET @asd = CONCAT('SELECT uzytkownik.ID,Nazwa,COUNT(wiadomosc.ID) as wiad,DataDolaczenia,OstatniaWizyta,Uprawnienia FROM uzytkownik left outer join wiadomosc on uzytkownik.ID=wiadomosc.AutorID GROUP BY Nazwa ORDER BY uzytkownik.ID LIMIT ',@str,',20');
PREPARE zxc FROM @asd;
EXECUTE zxc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `forum` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ;
/*!50003 DROP PROCEDURE IF EXISTS `wiadomosci` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `wiadomosci`(in itemat int,in strona int)
BEGIN
#;

declare str int;
declare item int;
SET @item = itemat;
SET @str = (strona-1)*20;
SET @asd = CONCAT('SELECT wiadomosc.ID,IndeksWtemacie,uzytkownik.DataDolaczenia,uzytkownik.uprawnienia as upr,uzytkownik.Nazwa,DataWyslania,Tresc,OdpowiedzDo,uzytkownik.ID as userid from wiadomosc inner join uzytkownik on wiadomosc.AutorID=uzytkownik.ID where TematID=',@item,' order by IndeksWTemacie LIMIT ',@str,',20');
PREPARE zxc FROM @asd;
EXECUTE zxc;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-05 17:19:24

-- Stworzenie konta Admina
INSERT INTO uzytkownik values(0,'Admin',curdate(),'Administrator',curdate());
INSERT INTO haslo values(0,password(concat(<<<ENTER ADMIN PASSWORD HERE>>>,'zucc')));
