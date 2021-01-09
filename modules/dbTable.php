<?php

global $wpdb;
$prefix = $wpdb->prefix;

$wpdb->query("CREATE TABLE IF NOT EXISTS `{$prefix}rg_game_info` (
  `id` int(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `game_name` varchar(150) NOT NULL,
  `percipient_limit` int(100) NOT NULL,
  `tk_price` int(30) NOT NULL,
  `duration` datetime NOT NULL,
  `item_title` varchar(100) NOT NULL,
  `item_image` varchar(100) NOT NULL,
  `declartion_text` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");



