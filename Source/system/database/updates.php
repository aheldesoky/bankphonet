<?php

/**
 * Please take care of array order !
 */
$updates = array();
$updates[1] = "ALTER TABLE `withdrawl_requests` ADD `accepted` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `id`";
$updates[2] = "CREATE TABLE  `bankphonet`.`cobones` (
`id` INT NOT NULL AUTO_INCREMENT ,
`code` VARCHAR( 16 ) NOT NULL ,
`amount` INT NOT NULL ,
`owner_id` INT NOT NULL ,
`charger_id` INT NOT NULL ,
`cobone_time` VARCHAR( 10 ) NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = INNODB;";
$updates[3] = "CREATE TABLE  `bankphonet`.`deposit_requests` (
`id` INT NOT NULL AUTO_INCREMENT ,
`account_id` INT NOT NULL ,
`amount` DECIMAL( 11, 2 ) NOT NULL ,
`depositor_name` VARCHAR( 100 ) NOT NULL ,
`deposit_date` VARCHAR( 50 ) NOT NULL ,
`tel` VARCHAR( 50 ) NOT NULL ,
`image` VARCHAR( 100 ) NOT NULL ,
`deposit_time` VARCHAR( 10 ) NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = INNODB;
";


$updates[4] ="ALTER TABLE  `accounts` ADD  `resend_activation` TINYINT( 1 ) NOT NULL DEFAULT  '0'
";

//Mobile charge
$updates[5] = "CREATE TABLE  `bankphonet`.`mobile_charge` (
`id` INT NOT NULL ,
`account_id` INT NOT NULL ,
`amount` DECIMAL( 11, 2 ) NOT NULL ,
`card_number` VARCHAR( 100 ) NOT NULL ,
`service_provider` ENUM(  'vodafone',  'mobinil',  'etisalat' ) NOT NULL ,
`datetime1` DATETIME NOT NULL ,
`accepted` TINYINT NOT NULL
) ENGINE = INNODB;";

$updates[6] = "ALTER TABLE  `mobile_charge` ADD INDEX (  `id` )";

$updates[7] = "ALTER TABLE  `mobile_charge` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT";
?>
