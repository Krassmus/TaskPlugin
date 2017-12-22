CREATE TABLE `tp_tasks` (
  `task_id` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(150) NOT NULL DEFAULT '',
  `description` text ,
  `for_all` tinyint(3) DEFAULT NULL,
  `range_id` varchar(32) NOT NULL DEFAULT '',
  `range_type` varchar(20) NOT NULL DEFAULT '',
  `parent_id` varchar(32) DEFAULT NULL,
  `statusgruppe_id` varchar(32) DEFAULT NULL,
  `work_as_group` tinyint(2) DEFAULT '1',
  `deadline` int(11) DEFAULT NULL,
  `finished` int(11) NOT NULL DEFAULT '0',
  `created_by_user` varchar(32) NOT NULL DEFAULT '',
  `mkdate` int(11) DEFAULT NULL,
  `chdate` int(11) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB

CREATE TABLE `tp_task_user` (
  `task_id` varchar(32) NOT NULL DEFAULT '',
  `user_id` varchar(32) NOT NULL,
  PRIMARY KEY (`task_id`,`user_id`)
) ENGINE=InnoDB