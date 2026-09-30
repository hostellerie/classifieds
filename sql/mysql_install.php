<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Classifieds Plugin 1.4.0                                                    |
// +---------------------------------------------------------------------------+
// | mysql_install.php                                                         |
// |                                                                           |
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                              |
// |                                                                           |
// | Authors: ::Ben - cordiste AT free DOT fr                                  |
// +---------------------------------------------------------------------------+
// | Created with the Geeklog Plugin Toolkit.                                  |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

$_SQL[] = "
CREATE TABLE {$_TABLES['cl']} (
  clid int auto_increment,
  catid varchar(32) DEFAULT NULL,
  status tinyint(1) DEFAULT '0',
  type tinyint(1) DEFAULT '0',
  tel varchar(20) NOT NULL,
  hide_tel tinyint(1) DEFAULT '0',
  title varchar(96) DEFAULT NULL,
  text text DEFAULT NULL,
  price decimal(12,2) unsigned,
  postcode VARCHAR(20) NOT NULL,
  city VARCHAR(30) NOT NULL,
  siren varchar(20) DEFAULT NULL,
  enable tinyint(1) DEFAULT '1',
  created datetime DEFAULT NULL,
  modified datetime DEFAULT NULL,
  notification tinyint(1) DEFAULT '0',
  deleted tinyint(1) DEFAULT '0',
  hits int(11) NOT NULL DEFAULT '0',
  modif int(11) NOT NULL DEFAULT '0',
  owner_id mediumint(8) unsigned NOT NULL DEFAULT '1',
  group_id mediumint(8) unsigned NOT NULL DEFAULT '1',
  perm_owner tinyint(1) unsigned NOT NULL DEFAULT '3',
  perm_group tinyint(1) unsigned NOT NULL DEFAULT '2',
  perm_members tinyint(1) unsigned NOT NULL DEFAULT '2',
  perm_anon tinyint(1) unsigned NOT NULL DEFAULT '2',
  INDEX cl_cat(clid),
  INDEX cl_date(modified),
  PRIMARY KEY (clid)
) ENGINE=InnoDB
";

$_SQL[] = "CREATE TABLE {$_TABLES['cl_pic']} (
    pi_pid varchar(40) NOT NULL,
    pi_img_num tinyint(2) unsigned NOT NULL,
    pi_filename varchar(128) NOT NULL,
    PRIMARY KEY (pi_pid,pi_img_num)
) ENGINE=InnoDB
	";

$_SQL[] = "
CREATE TABLE {$_TABLES['cl_cat']} (
  cid int auto_increment,
  pid varchar(32) DEFAULT '0',
  category varchar(32) NOT NULL,
  catorder smallint(5) unsigned NOT NULL default '1',
  catdeleted tinyint(1) DEFAULT '0',
  owner_id mediumint(8) unsigned NOT NULL DEFAULT '2',
  group_id mediumint(8) unsigned NOT NULL DEFAULT '1',
  perm_owner tinyint(1) unsigned NOT NULL DEFAULT '3',
  perm_group tinyint(1) unsigned NOT NULL DEFAULT '2',
  perm_members tinyint(1) unsigned NOT NULL DEFAULT '2',
  perm_anon tinyint(1) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (cid),
  KEY cl_pid (pid)
) ENGINE=InnoDB
";

$_SQL[] = "CREATE TABLE {$_TABLES['cl_users']} (
  user_id mediumint(8) unsigned NOT NULL,
  tel varchar(20) NOT NULL,
  postcode VARCHAR(20) NOT NULL,
  city VARCHAR(30) NOT NULL,
  status tinyint(1) DEFAULT '0',
  siren varchar(20),
  PRIMARY KEY (user_id)
) ENGINE=InnoDB
";

?>
