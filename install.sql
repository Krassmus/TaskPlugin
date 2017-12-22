CREATE TABLE `tp_tasks` (
  `task_id` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(150) NOT NULL DEFAULT '',
  `description` text,
  `range_id` varchar(32) NOT NULL DEFAULT '',
  `range_type` varchar(20) NOT NULL DEFAULT '',
  `parent_id` varchar(32) DEFAULT NULL,
  `deadline` int(11) DEFAULT NULL,
  `finished` int(11) NOT NULL DEFAULT '0',
  `created_by_user` varchar(32) NOT NULL DEFAULT '',
  `assigned_to_user` varchar(32) DEFAULT NULL,
  `mkdate` int(11) DEFAULT NULL,
  `chdate` int(11) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB