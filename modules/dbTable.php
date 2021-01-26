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

// $post_id = wp_insert_post( array(
//     "post_title" => "Ticket",
//     "post_name" => "Ticket",
//     "post_type" => "product",
//     "post_status" => "Private",
//     "post_content" => "Ticket for raffle draw",
//     "post_title" => "Ticket",
// ));

// // set product is simple/variable/grouped
// wp_set_object_terms( $post_id, 'simple', 'product_type' );
// update_post_meta( $post_id, '_stock_status', 'instock');
// update_post_meta( $post_id, 'total_sales', '0' );
// update_post_meta( $post_id, '_downloadable', 'no' );
// update_post_meta( $post_id, '_virtual', 'yes' );
// update_post_meta( $post_id, '_regular_price', '' );
// update_post_meta( $post_id, '_sale_price', '' );
// update_post_meta( $post_id, '_purchase_note', '' );
// update_post_meta( $post_id, '_featured', 'no' );
// update_post_meta( $post_id, '_price', '10' );
// update_post_meta( $post_id, '_stock', '10' );
// update_post_meta( $post_id, '_sold_individually', '' );
// update_post_meta( $post_id, '_manage_stock', 'yes' );
// wc_update_product_stock($post_id, $single['qty'], 'set');
// update_post_meta( $post_id, '_backorders', 'no' );
// update_post_meta( $post_id, '_stock', $single['qty'] );
