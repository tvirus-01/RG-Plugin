<?php

global $wpdb;
$prefix = $wpdb->prefix;

$wpdb->query("DROP TABLE `{$prefix}rg_game_info`");