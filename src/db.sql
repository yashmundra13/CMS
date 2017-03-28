CREATE TABLE `assignments` (
 `id` smallint(5) NOT NULL AUTO_INCREMENT,
 `dueDate` date NOT NULL,
 `title` varchar(255) NOT NULL,
 `content` mediumtext NOT NULL,
 `teacherName` varchar(255) NOT NULL,
 `subject` varchar(255) NOT NULL,
 `class` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1

CREATE TABLE `comments` (
 `user` varchar(255) NOT NULL,
 `content` mediumtext NOT NULL,
 `postID` int(11) NOT NULL,
 `id` int(11) NOT NULL AUTO_INCREMENT,
 UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1

CREATE TABLE `tbl_tusers` (
 `tuserID` int(11) NOT NULL AUTO_INCREMENT,
 `tuserName` varchar(100) NOT NULL,
 `tuserEmail` varchar(100) NOT NULL,
 `tuserPass` varchar(100) NOT NULL,
 PRIMARY KEY (`tuserID`),
 UNIQUE KEY `userEmail` (`tuserEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1

CREATE TABLE `tbl_users` (
 `userID` int(11) NOT NULL AUTO_INCREMENT,
 `userName` varchar(100) NOT NULL,
 `userEmail` varchar(100) NOT NULL,
 `userPass` varchar(100) NOT NULL,
 `userStatus` enum('Y','N') NOT NULL DEFAULT 'N',
 `tokenCode` varchar(100) NOT NULL,
 `class` int(11) DEFAULT NULL,
 PRIMARY KEY (`userID`),
 UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1