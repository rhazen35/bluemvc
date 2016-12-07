CREATE TABLE `user`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(150) NOT NULL,
  `hash` VARCHAR(256) NOT NULL,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY(id)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_role`(
  `user_id` INT(11) NOT NULL,
  `role_id` INT(11) NOT NULL,
  PRIMARY KEY(user_id, role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_group`(
  `user_id` INT(11) NOT NULL,
  `group_id` INT(11) NOT NULL,
  PRIMARY KEY(user_id, group_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_login`(
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `previous` TIMESTAMP,
  `current` TIMESTAMP,
  `first` TIMESTAMP,
  `count` INT(11),
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY(user_id) REFERENCES user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

$2y$10$bIJBr8Ej83xvVka/gn0n0OSRLuEmCtipPKCGRp4MY03u/JDt6XeYe