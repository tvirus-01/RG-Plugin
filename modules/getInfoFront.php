<?php

require_once 'dbh.php';

if (isset($_POST['get_id'])) {
	$sql = "SELECT * FROM {$prefix}rg_game_info";
	$res = $conn->query($sql);

	$prd_ids = array();

	foreach ($res as $key) {
		$ticket_id = $key['ticket_id'];
		array_push($prd_ids, $ticket_id);
	}

	echo json_encode($prd_ids);
}