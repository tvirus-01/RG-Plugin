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

if (isset($_POST['get_usr_buy'])) {
	$t_id = $_POST['t_id'];

	$sql = "SELECT * FROM {$prefix}rg_ticket_buy WHERE ticket_id = '{$t_id}'";
	$res = $conn->query($sql);

	$users_arr = array();
	foreach ($res as $key => $row) {
		$user_id = $row['user_id'];

		$sql_1 = "SELECT * FROM {$prefix}users WHERE ID = {$user_id}";
		$res_1 = $conn->query($sql_1);

		$users = $res_1->fetch_row();

		$user_name = $users[9];
		// array_push($users_arr, $user_name => $user_id);
		$users_arr[$user_id] = $user_name;
	}

	echo json_encode($users_arr);
}

if (isset($_POST['get_winner'])) {
	$t_id = $_POST['t_id'];

	$sql = "SELECT * FROM {$prefix}rg_game_info WHERE ticket_id = '{$t_id}'";
	$res = $conn->query($sql);

	foreach ($res as $key => $row) {
		$game_id = $row['id'];
	}

	$winner = "no_winner";

	if ($res->num_rows == 1) {
		$sql_1 = "SELECT * FROM `{$prefix}rg_game_winner` WHERE `game_id` = {$game_id}";
		$res_1 = $conn->query($sql_1);

		if ($res_1->num_rows > 0) {
			foreach ($res_1 as $key => $row) {
				$winner = $row['user_id'];
			}
		}
	}

	echo $winner;
}

if (isset($_POST['set_winner'])) {
	$t_id = $_POST['t_id'];
	$winner_id = $_POST['winner_id'];

	$sql = "SELECT * FROM {$prefix}rg_game_info WHERE ticket_id = '{$t_id}'";
	$res = $conn->query($sql);

	foreach ($res as $key => $row) {
		$game_id = $row['id'];
	}

	if ($res->num_rows == 1) {
		$sql_1 = "SELECT * FROM `{$prefix}rg_game_winner` WHERE `game_id` = {$game_id}";
		$res_1 = $conn->query($sql_1);

		if ($res_1->num_rows > 0) {
			//pass
		}else{
			$sql_2 = "INSERT INTO `wp_rg_game_winner` (`id`, `user_id`, `game_id`) VALUES (NULL, {$winner_id}, '{$game_id}')";

			if ($conn->query($sql_2)) {
				echo "success";
			}
		}
	}
}