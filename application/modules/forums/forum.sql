CREATE TABLE `ForumCategories` (
  `categoryID` int(11) NOT NULL auto_increment,
  `category_name` varchar(100) NOT NULL default '',
  `permission` mediumint(2) NOT NULL default '0',
  PRIMARY KEY  (`categoryID`)
) ENGINE=MyISAM  COMMENT='Splits forums into categories';

-- --------------------------------------------------------

-- 
-- Table structure for table `Forums`
-- 

CREATE TABLE `Forums` (
  `forumID` int(11) NOT NULL auto_increment,
  `forum_name` varchar(100) NOT NULL default '',
  `forum_description` varchar(255) NOT NULL default '',
  `categoryID` int(11) NOT NULL default '0',
  `permission` int(2) NOT NULL default '0',
  PRIMARY KEY  (`forumID`)
) ENGINE=MyISAM  COMMENT='Forums are the containers for threads and topics.';

-- --------------------------------------------------------

-- 
-- Table structure for table `ForumPosts`
-- 

CREATE TABLE `ForumPosts` (
  `postID` int(11) NOT NULL auto_increment,
  `forumID` int(11) NOT NULL default '0',
  `authorID` int(11) NOT NULL default '0',
  `parentID` int(11) NOT NULL default '0',
  `post_title` varchar(100) character set latin1 NOT NULL default '',
  `post_text` text character set latin1 NOT NULL,
  `post_type` tinyint(1) NOT NULL default '0',
  `post_locked` tinyint(1) NOT NULL default '0',
  `post_hidden` tinyint(1) NOT NULL default '0',
  `post_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_viewcount` int(11) NOT NULL default '0',
  `smileys` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`postID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `ForumSubscriptions`
-- 

CREATE TABLE `ForumSubscriptions` (
  `id` int(11) NOT NULL auto_increment,
  `topicID` int(11) NOT NULL default '0',
  `userID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
