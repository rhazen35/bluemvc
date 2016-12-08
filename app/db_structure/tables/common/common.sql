CREATE TABLE `role`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `role` INT(11) NOT NULL,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `group`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `group` INT(11) NOT NULL,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;