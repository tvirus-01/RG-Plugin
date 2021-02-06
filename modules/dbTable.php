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
  `is_active` tinyint(1) NOT NULL,
  `ticket_id` INT(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$wpdb->query("CREATE TABLE IF NOT EXISTS `{$prefix}rg_ticket_buy` ( 
  `id` INT(100) NOT NULL AUTO_INCREMENT , 
  `user_id` INT(100) NOT NULL , 
  `ticket_id` INT(100) NOT NULL , 
  PRIMARY KEY (`id`)) ENGINE = InnoDB");

$wpdb->query("CREATE TABLE IF NOT EXISTS `{$prefix}rg_game_winner` ( 
  `id` INT(100) NOT NULL AUTO_INCREMENT , 
  `user_id` INT(100) NOT NULL , 
  `game_id` INT(100) NOT NULL , 
  PRIMARY KEY (`id`)) ENGINE = InnoDB");


$rg_pages = array('raffle', 'rg thank you', 'rg-after');
$rg_templates = array('wp-templates/raffle-tpl.php', 'wp-templates/rg-thanks-tpl.php', 'wp-templates/ap-tpl.php');

$rgN = 0;
foreach ($rg_pages as $key) {
  $post_id = wp_insert_post( array(
    "post_title" => $key,
    "post_name" => $key,
    "post_type" => "page",
    "post_status" => "publish",
    "post_content" => "Raffle Game Custom Page"
  ));

  add_post_meta( $post_id, '_wp_page_template', $rg_templates[$rgN] );
  $rgN++;
}