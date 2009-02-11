<?

$sql[] = "CREATE TABLE `${db_prefix}client` (
  `clientid` mediumint(8) unsigned NOT NULL default '0',
  `parentclientid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(50) NOT NULL default '',
  `passwd` varchar(50) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `address` text NOT NULL,
  `def_tax` float(4,3) unsigned default NULL,
  `def_tax2` float(4,3) unsigned default NULL,
  `ref` varchar(50) NOT NULL default '',
  `company` varchar(100) NOT NULL default '',
  `firstname` varchar(20) NOT NULL default '',
  `lastname` varchar(20) NOT NULL default '',
  `contacttitle` varchar(20) NOT NULL default '',
  `phonenumber` varchar(12) NOT NULL default '',
  `faxnumber` varchar(12) NOT NULL default '',
  `url` varchar(50) NOT NULL default '',
  `logo` varchar(255) default NULL,
  `term_days` smallint(5) default NULL,
  `def_terms` varchar(255) NOT NULL default '',
  `def_comments` varchar(255) NOT NULL default '',
  `account_num` varchar(32) NOT NULL default '',
  `template` varchar(20) NOT NULL default 'default',
  `language` varchar(32) NOT NULL default '',
  `access` enum('client','staff','admin') NOT NULL default 'client',
  `visible` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`clientid`),
  KEY `clientid` (`clientid`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `${db_prefix}client_seq` (`id` int(10) unsigned NOT NULL auto_increment,PRIMARY KEY  (`id`)) TYPE=MyISAM AUTO_INCREMENT=0;";

$sql[] = "CREATE TABLE `${db_prefix}emailsend` (
  `emailsendid` int(10) unsigned NOT NULL default '0',
  `clientid` smallint(8) unsigned NOT NULL default '0',
  `invoiceid` int(8) unsigned default NULL,
  `emailaddress` varchar(50) NOT NULL default '',
  `sendtype` tinyint(1) unsigned NOT NULL default '0',
  `datesent` datetime default NULL,
  `opencount` tinyint(3) unsigned NOT NULL default '0',
  `firstopened` datetime default NULL,
  `lastopened` datetime default NULL,
  PRIMARY KEY  (`emailSendID`),
  KEY `emailSend_clientID` (`clientID`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `${db_prefix}invoice` (
  `invoiceid` int(8) unsigned NOT NULL default '0',
  `clientid` mediumint(8) NOT NULL default '0',
  `due_date` date NOT NULL default '0000-00-00',
  `issue_date` date NOT NULL default '0000-00-00',
  `comments` text NOT NULL,
  `terms` varchar(255) NOT NULL default '',
  `cost` float(6,2) NOT NULL default '0.00',
  `tax` float(4,3) NOT NULL default '0.000',
  `tax2` float(4,3) NOT NULL default '0.000',
  `shipping` float(5,2) NOT NULL default '0.00',
  `curr_status` varchar(20) NOT NULL default 'pending',
  `visible` enum('0','1') NOT NULL default '1',
  `invoice_num` int(10) unsigned default NULL,
  PRIMARY KEY  (`invoiceID`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `${db_prefix}invoice_seq` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=0;";

$sql[] = "CREATE TABLE `${db_prefix}invoice_num_seq` (
  `id` int(10) unsigned NOT NULL auto_increment, 
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=${inum_start};";

$sql[] = "CREATE TABLE `${db_prefix}invoiceitem_seq` (
  `id` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=0;";

$sql[] = "CREATE TABLE `${db_prefix}invoiceitem` (
  `invoiceitemid` int(8) unsigned NOT NULL default '0',
  `details` varchar(100) NOT NULL default '',
  `cost` float(6,2) NOT NULL default '0.00',
  PRIMARY KEY  (`invoiceItemID`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `${db_prefix}invoice_invoiceitem` (
  `invoiceid` int(10) unsigned NOT NULL default '0',
  `invoiceitemid` int(10) unsigned NOT NULL default '0',
  `qty` mediumint(9) NOT NULL default '1',
  PRIMARY KEY  (`invoiceid`,`invoiceitemid`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `${db_prefix}log` (
  `logid` int(10) unsigned NOT NULL auto_increment,
  `creator` mediumint(8) unsigned NOT NULL default '0',
  `targetid` int(8) unsigned NOT NULL default '0',
  `targettype` enum('1','2') NOT NULL default '1',
  `eventid` tinyint(3) unsigned NOT NULL default '0',
  `occured` timestamp(14) NOT NULL,
  `details` text,
  PRIMARY KEY  (`logID`),
  KEY `logID` (`logID`),
  KEY `invoiceID` (`targetID`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `${db_prefix}note` (
  `noteid` int(10) unsigned NOT NULL auto_increment,
  `s_clientid` mediumint(8) unsigned NOT NULL default '0',
  `r_clientid` mediumint(8) unsigned NOT NULL default '0',
  `content` varchar(255) NOT NULL default '',
  `posted` datetime NOT NULL default '0000-00-00 00:00:00',
  `isprivate` enum('yes','no') NOT NULL default 'yes',
  PRIMARY KEY  (`noteID`),
  KEY `s_clientID` (`s_clientID`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `${db_prefix}paygate` (
  `paygateid` tinyint(3) unsigned NOT NULL auto_increment,
  `company` varchar(30) NOT NULL default '',
  `homepage` varchar(100) default NULL,
  `variables` varchar(255) NOT NULL default '',
  `tplfile` varchar(20) NOT NULL default '',
  `enabled` enum('yes','no') NOT NULL default 'yes',
  PRIMARY KEY  (`paygateid`)
) TYPE=MyISAM;";


$sql[] = "CREATE TABLE `${db_prefix}payment` (
  `paymentid` int(10) unsigned NOT NULL auto_increment,
  `clientid` mediumint(8) unsigned NOT NULL default '0',
  `invoiceid` int(8) unsigned NOT NULL default '0',
  `amount` float(6,2) NOT NULL default '0.00',
  `method` varchar(20) NOT NULL default '',
  `made_on` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`paymentID`)
) TYPE=MyISAM;";

$sql[] = "CREATE TABLE `${db_prefix}recurrance` (
  `recurranceid` int(10) unsigned NOT NULL auto_increment,
  `invoiceid` int(10) unsigned NOT NULL default '0',
  `days` varchar(61) NOT NULL default '',
  `months` varchar(23) NOT NULL default '',
  `until` date NOT NULL default '0000-00-00',
  `action` enum('create','mail','notice') NOT NULL default 'create',
  PRIMARY KEY  (`recurranceid`)
) TYPE=MyISAM;"

?>