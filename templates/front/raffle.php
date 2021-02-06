<?php

global $wpdb;
$prefix = $wpdb->prefix;
$current_user = wp_get_current_user();

$game = $wpdb->get_row( "SELECT * FROM {$prefix}rg_game_info WHERE is_active = 1 " );

if ($game) {
	$game_name = $game->game_name;
	$percipient_limit = $game->percipient_limit;
	$tk_price = $game->tk_price;
	$duration = $game->duration;
	$item_title = $game->item_title;
	$item_image = $game->item_image;
	$declartion_text = $game->declartion_text;
	$created_date = $game->created_date;
	$is_active = $game->is_active;
  $ticket_id = $game->ticket_id;

  $sales = $wpdb->get_row( "SELECT * FROM {$prefix}postmeta WHERE post_id = {$ticket_id} ANd meta_key = '_stock' " );
  if ($sales) {
    $total_left = $sales->meta_value;
  }else{
    $total_left = $percipient_limit;
  }

	$now = new DateTime();
    $future_date = new DateTime($duration);
    $interval = $future_date->diff($now);

    if($future_date <= $now){
      $tx = 0;
    }else{
      // print_r($interval);
      $months = $interval->m;
      $days = $interval->d;
      $hours = $interval->h;
      $min = $interval->i;
      $sec = $interval->s;

      // echo "Months {$months}: days {$days}: Hours {$hours}: min {$min}: sec {$sec} ";
      $month_to_min = $months * 43800;
      $day_to_min = $days * 1440;
      $hour_to_min = $hours * 60;
      $sec_to_min = $sec * 0.016;

      $tx = $month_to_min+$day_to_min+$hour_to_min+$min+$sec_to_min;
    }

    if (is_user_logged_in()) {
    	$logged_in = 1;
    }else{
    	$logged_in = 0;
    }

    if (isset($href)) {
    	# code...
    }else{
    	$href = 'raffle';
    }
    // echo $tx;

    global  $woocommerce;
   	$crr_sym = get_woocommerce_currency_symbol();

	if (isset($_POST['buy_ticket_submit'])) {
		$woocommerce->cart->add_to_cart( $ticket_id );
		echo '<input type="hidden" id="tic_buy" value="'.wc_get_checkout_url().'">';
	}else{
		echo '<input type="hidden" id="tic_buy" value="0">';
	}

  if ( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $ticket_id ) ){
    $already_purchased = 1;
  }else{
    $already_purchased = 0;
  }

  $pos = strpos($game_name, "demo");
  if ($pos !== false) {
    $demo = 1;
  }else{
    $demo = 0;
  }

	include plugin_dir_path( __FILE__ ).'/raffle-ui.php';
}