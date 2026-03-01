-- MySQL dump 10.13  Distrib 5.7.43, for Linux (x86_64)
--
-- Host: localhost    Database: yuotoob
-- ------------------------------------------------------
-- Server version	5.7.43-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` varchar(15) NOT NULL,
  `title` text,
  `posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `author` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `c_guidelines`
--

DROP TABLE IF EXISTS `c_guidelines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `c_guidelines` (
  `number` int(11) NOT NULL AUTO_INCREMENT,
  `guideline` text NOT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `channelcomments`
--

DROP TABLE IF EXISTS `channelcomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channelcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `orderid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `cid` varchar(14) NOT NULL COMMENT 'comment id',
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vidon` varchar(14) NOT NULL COMMENT 'Vid it was commented on',
  `vid` varchar(14) DEFAULT NULL COMMENT 'Vid attached to it',
  `body` varchar(100) NOT NULL COMMENT 'body of comment',
  `uid` varchar(20) NOT NULL COMMENT 'user who posted it',
  `is_reply` int(11) NOT NULL,
  `reply_to` varchar(14) NOT NULL,
  `master_comment` varchar(14) NOT NULL,
  `removed` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `epiktubenotice`
--

DROP TABLE IF EXISTS `yuotoobnotice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epiktubenotice` (
  `version` varchar(59) NOT NULL,
  `logo` varchar(100) NOT NULL DEFAULT 'logo_sm.gif',
  `slogan` varchar(52) NOT NULL DEFAULT 'Upload, tag and share your videos worldwide!',
  `notice` varchar(99) NOT NULL,
  `maintenance` int(11) NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Website configuration';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `fid` varchar(12) NOT NULL COMMENT 'favorite id',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` varchar(12) NOT NULL,
  `vid` varchar(12) NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='lol the whole table is ids';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invite_keys`
--

DROP TABLE IF EXISTS `invite_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invite_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invite_key` varchar(50) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `invite_key` (`invite_key`)
) ENGINE=InnoDB AUTO_INCREMENT=5555 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invite_keys`
--

LOCK TABLES `invite_keys` WRITE;
/*!40000 ALTER TABLE `invite_keys` DISABLE KEYS */;
INSERT INTO `invite_keys` VALUES (1,'epikkey67',1),(100,'key',1),(999,'9PQPqG0Kc7',1),(2024,'g',0),(2025,'h',0);
/*!40000 ALTER TABLE `invite_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ip_bans`
--

DROP TABLE IF EXISTS `ip_bans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip_bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` text NOT NULL,
  `banned` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `sender` varchar(12) NOT NULL COMMENT 'uid of whom is sending the message',
  `receiver` varchar(12) NOT NULL COMMENT 'uid of the recipient',
  `subject` text NOT NULL COMMENT '(up to 75 characters) the title of the message, encrypted',
  `attached` varchar(15) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `body` text NOT NULL COMMENT '(up to 50,000 characters) the text of the message encrypted',
  `pmid` varchar(12) NOT NULL COMMENT 'id of the private message',
  `isRead` int(11) NOT NULL COMMENT 'If receiver saw it, mark 1',
  PRIMARY KEY (`pmid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='private messages';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `picks`
--

DROP TABLE IF EXISTS `picks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `picks` (
  `video` varchar(12) NOT NULL,
  `featured` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `special` int(11) NOT NULL,
  PRIMARY KEY (`video`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlists` (
  `id` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `vid` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `pid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `questions_and_answers`
--

DROP TABLE IF EXISTS `questions_and_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions_and_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratings` (
  `rating_id` varchar(15) NOT NULL,
  `rating` int(11) NOT NULL,
  `user` varchar(16) NOT NULL,
  `video` varchar(16) NOT NULL,
  `done` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rating_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rejections`
--

DROP TABLE IF EXISTS `rejections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rejections` (
  `uid` varchar(20) NOT NULL COMMENT 'id of video poster',
  `vid` varchar(20) NOT NULL COMMENT 'video id',
  `cdn` int(11) NOT NULL,
  `uploaded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tags` varchar(900) NOT NULL,
  `ch1` int(11) NOT NULL DEFAULT '5',
  `ch2` int(11) DEFAULT NULL,
  `ch3` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `file` text NOT NULL,
  `time` int(11) NOT NULL,
  `converted` int(11) NOT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `priva_group` int(11) DEFAULT NULL,
  `recorddate` datetime DEFAULT NULL,
  `address` text,
  `addrcountry` text,
  `comms_allow` int(11) NOT NULL DEFAULT '1',
  `allow_votes` int(11) NOT NULL DEFAULT '1',
  `views` int(11) NOT NULL,
  `comm_count` int(11) NOT NULL,
  `fav_count` int(11) NOT NULL,
  `ratings` int(11) NOT NULL,
  `age_restrict` int(11) NOT NULL,
  `reason` int(11) NOT NULL DEFAULT '1',
  `copyright_holder` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `relationships`
--

DROP TABLE IF EXISTS `relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relationships` (
  `relationship` varchar(16) NOT NULL COMMENT 'id of the relationship',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 equals normal friend 2 equals familia',
  `sender` varchar(18) NOT NULL,
  `respondent` varchar(18) NOT NULL,
  `accepted` int(11) NOT NULL,
  `sent` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`relationship`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `who` varchar(20) NOT NULL,
  `what` text NOT NULL,
  `where` varchar(3) NOT NULL DEFAULT 'I',
  `when` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `subscription_id` varchar(256) NOT NULL,
  `subscriber` text NOT NULL,
  `subscribed_to` text NOT NULL,
  `subscribed_type` varchar(1000) NOT NULL DEFAULT 'user_uploads',
  `subscribed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `subscription_id` (`subscription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `ticket` int(11) NOT NULL AUTO_INCREMENT,
  `sender` text NOT NULL,
  `subject` int(11) NOT NULL,
  `message` text NOT NULL,
  `submitted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resolved` int(11) NOT NULL,
  PRIMARY KEY (`ticket`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` longtext NOT NULL,
  `old_pass` longtext,
  `email` varchar(100) NOT NULL,
  `confirm_id` text NOT NULL,
  `confirm_expire` datetime DEFAULT NULL,
  `joined` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `em_confirmation` varchar(1000) NOT NULL DEFAULT 'false',
  `emailprefs_vdocomments` int(11) NOT NULL DEFAULT '1',
  `emailprefs_wklytape` int(11) NOT NULL,
  `emailprefs_privatem` int(11) NOT NULL DEFAULT '1',
  `lastlogin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_act` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `failed_login` datetime DEFAULT NULL,
  `termination` int(11) NOT NULL COMMENT 'if equals 1 then theyre terminated',
  `birthday` date DEFAULT NULL,
  `name` varchar(500) NOT NULL,
  `relationship` int(11) NOT NULL,
  `gender` int(11) NOT NULL,
  `about` varchar(2500) NOT NULL,
  `website` varchar(255) NOT NULL,
  `hometown` varchar(500) NOT NULL,
  `city` varchar(500) NOT NULL,
  `country` varchar(500) NOT NULL,
  `occupations` varchar(500) NOT NULL,
  `companies` varchar(500) NOT NULL,
  `schools` varchar(500) NOT NULL,
  `hobbies` varchar(500) NOT NULL,
  `fav_media` varchar(500) NOT NULL,
  `playlists` int(11) NOT NULL,
  `subscriptions` int(11) NOT NULL,
  `subscribers` int(11) NOT NULL,
  `profile_views` int(11) NOT NULL,
  `fav_count` int(11) NOT NULL,
  `pub_vids` int(11) NOT NULL,
  `priv_vids` int(11) NOT NULL,
  `friends_count` int(11) NOT NULL,
  `vids_watched` int(11) NOT NULL,
  `music` varchar(500) NOT NULL,
  `books` varchar(500) NOT NULL,
  `staff` int(11) NOT NULL,
  `sysadmin` int(11) NOT NULL,
  `ip` varchar(500) DEFAULT NULL,
  `priv_id` varchar(35) DEFAULT NULL COMMENT 'non-public version of the user id used for things like email verif',
  `blazing` int(11) NOT NULL COMMENT '1 sets the cooldown limit to just 1',
  `retelimit` varchar(255) DEFAULT NULL,
  `profileColor` varchar(255) DEFAULT 'classic',
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `uid` varchar(20) NOT NULL COMMENT 'id of video poster',
  `vid` varchar(20) NOT NULL COMMENT 'video id',
  `cdn` int(11) NOT NULL,
  `uploaded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tags` varchar(900) NOT NULL,
  `ch1` int(11) NOT NULL DEFAULT '5',
  `ch2` int(11) DEFAULT NULL,
  `ch3` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `file` text NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `converted` int(11) NOT NULL DEFAULT '0',
  `privacy` int(11) NOT NULL DEFAULT '1',
  `priva_group` int(11) DEFAULT NULL,
  `recorddate` varchar(255) DEFAULT NULL,
  `address` text,
  `addrcountry` text,
  `comms_allow` int(11) NOT NULL DEFAULT '1',
  `allow_votes` int(11) NOT NULL DEFAULT '1',
  `age_restrict` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `comm_count` int(11) NOT NULL DEFAULT '0',
  `fav_count` int(11) NOT NULL DEFAULT '0',
  `ratings` int(11) NOT NULL DEFAULT '0',
  `rejected` int(11) NOT NULL DEFAULT '0',
  `reason` int(11) NOT NULL DEFAULT '0',
  `copyright_holder` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `views`
--

DROP TABLE IF EXISTS `views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `views` (
  `view_id` varchar(35) NOT NULL,
  `viewed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when it got viewed',
  `location` varchar(5) DEFAULT 'US',
  `ip` varchar(45) NOT NULL DEFAULT 'generic',
  `vid` varchar(12) NOT NULL COMMENT 'the video that was viewed',
  `uid` varchar(12) DEFAULT NULL COMMENT 'user who viewed the video',
  `referer` text NOT NULL COMMENT 'HTTP referer',
  `sid` text NOT NULL COMMENT 'session id',
  PRIMARY KEY (`view_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `yuotoob_web`
--

DROP TABLE IF EXISTS `yuotoob_web`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yuotoob_web` (
  `version` varchar(59) NOT NULL,
  `logo_sm` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL DEFAULT 'logo_sm.gif',
  `slogan` varchar(52) NOT NULL DEFAULT 'Upload, tag and share your videos worldwide!',
  `notice` varchar(99) NOT NULL,
  `maintenance` int(11) NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Website configuration';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yuotoob_web`
--

LOCK TABLES `yuotoob_web` WRITE;
/*!40000 ALTER TABLE `yuotoob_web` DISABLE KEYS */;
INSERT INTO `yuotoob_web` VALUES ('yuotoob','logo_sm.gif','logo.gif','Your Digital Video Repository','',0),('yuotoob_april_fools','logo_flashing_sm.gif','logo_flashing.gif','ApRiL FoOlS!!!1','HaPpY ApRiL FoOlS To yUoToObIaNs!!!!!1',0),('yuotoob_christmas','logo_christ_sm.gif','logo_christ.gif','Merry Christmas!','Merry Christmas!!!',0);
/*!40000 ALTER TABLE `yuotoob_web` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'yuotoob'
--

--
-- Dumping routines for database 'yuotoob'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
