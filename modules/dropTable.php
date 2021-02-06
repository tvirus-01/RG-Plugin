<?php

global $wpdb;
$prefix = $wpdb->prefix;

$wpdb->query("DROP TABLE `{$prefix}rg_game_info`");
$wpdb->query("DROP TABLE `{$prefix}rg_game_winner`");
$wpdb->query("DROP TABLE `{$prefix}rg_ticket_buy`");