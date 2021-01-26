<?php
/*
Template Name: RG-After-purchase
*/
global $wpdb;
$prefix = $wpdb->prefix;

if ($_GET['oid']) {
	$order_id = $_GET['oid'];
	$order = wc_get_order( $order_id );
	$items = $order->get_items();
	// print_r($items);
	$order_post = get_post($order_id);
	$user_id = $order->get_user_id();

	foreach ( $items as $item ) {
	    $product_name = $item->get_name();
	    $product_id = $item->get_product_id();

	    $sql = "SELECT * FROM {$prefix}posts WHERE post_excerpt = 'RG_ticket' ";
	    $res = $wpdb->get_results($sql);
	    $num_row = $wpdb->num_rows;

	    foreach($res as $ti => $row){
	    	if ($row->ID == $product_id) {
	    		$sql_1 = "INSERT INTO `{$prefix}rg_ticket_buy` (`id`, `user_id`, `ticket_id`) VALUES (NULL, '{$user_id}', '{$product_id}')";
	    		if ($wpdb->query($sql_1)) {
	    			echo "success";
	    		}
	    	}
	    }
	}
	header("Location: ".get_site_url()."/rg-thank-you");
}