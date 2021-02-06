<?php
require_once 'dbh.php';

function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['get_data'])) {
	$game_id = $_POST['game_id'];

	$sql = "SELECT * FROM {$prefix}rg_game_info WHERE id = {$game_id}";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$dt = array();
		while($key = $result->fetch_assoc()) {
			$dt["game_name"] = $key['game_name'];
			$dt["percipient_limit"] = $key['percipient_limit'];
			$dt["tk_price"] = $key['tk_price'];
			$dt["duration"] = $key['duration'];
			$dt["item_title"] = $key['item_title'];
			$dt["item_image"] = $key['item_image'];
			$dt["declartion_text"] = $key['declartion_text'];
		}

		echo json_encode($dt);
	}else{
		echo "No data";
	}
}
elseif (isset($_POST['update'])) {
	$g_name = $_POST['g_name'];
	$p_limit = $_POST['p_limit'];
	$due = $_POST['due'];
	$i_name = $_POST['i_name'];
	$tk_price = $_POST['tk_price'];
	$wd_text = $_POST['wd_text'];
	$game_id = $_POST['game_id'];

	if (isset($_POST['i_img'])) {
		// echo "No Img";
	}else{
		$filename = $_FILES['i_img']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$new_filename = generateRandomString().'.'.$ext;

		$location = "../assets/img/upload/".$new_filename;
		move_uploaded_file($_FILES['i_img']['tmp_name'],$location);

		$sql_1 = "UPDATE {$prefix}rg_game_info SET item_image='{$new_filename}' WHERE id = {$game_id} ";
		$conn->query($sql_1);
	}

	$sql = "UPDATE {$prefix}rg_game_info SET game_name='{$g_name}', percipient_limit='{$p_limit}', tk_price='{$tk_price}', duration='{$due}', declartion_text='{$wd_text}', item_title='{$i_name}' WHERE id = {$game_id} ";
	// echo $sql;
	if ($conn->query($sql) === TRUE) {
	  echo "success";
	} else {
	  echo $conn->error;
	}
}
elseif (isset($_POST['check_active'])) {
	$sql = "SELECT * FROM {$prefix}rg_game_info WHERE is_active = '1' ";
	$res = $conn->query($sql);

	if ($res->num_rows > 0) {
		echo "has_active";
	}else{
		$game_id = $_POST['game_id'];

		$sql = "SELECT * FROM {$prefix}rg_game_winner WHERE game_id = {$game_id} ";
		$res = $conn->query($sql);

		if ($res->num_rows > 0) {
			echo "has_winner";
		}else{
			echo "activate_this";
		}
	}
}
elseif (isset($_POST['ac'])) {
	$ac = $_POST['ac'];
	$game_id = $_POST['game_id'];
	if ($ac == 'true') {
		$new_ac = 1;
	}else{
		$new_ac = 0;
	}
	$sql_1 = "UPDATE {$prefix}rg_game_info SET is_active='{$new_ac}' WHERE id = {$game_id} ";
	if ($conn->query($sql_1) === TRUE) {
	  echo "success";
	} else {
	  echo $conn->error;
	}
}
elseif (isset($_GET['test']) && $_GET['test'] == 'jj') {
	echo 'STATUS: '.$conn->stat();
	echo '</br>';
	echo 'PING: '.$conn->ping();
}
elseif (isset($_POST['del'])) {
	$game_id = $_POST['game_id'];

	$sql = "SELECT * FROM {$prefix}rg_game_info WHERE id = '{$game_id}'";
	$res = $conn->query($sql);

	foreach ($res as $key => $row) {
		$ticket_id = $row['ticket_id'];
	}

	$sql_00 = "DELETE FROM {$prefix}postmeta WHERE post_id = {$ticket_id} ";
	$conn->query($sql_00);
	$sql_0 = "DELETE FROM {$prefix}posts WHERE ID = {$ticket_id} ";
	$conn->query($sql_0);

	$sql_1 = "DELETE FROM {$prefix}rg_game_info WHERE id = {$game_id} ";
	if ($conn->query($sql_1) === TRUE) {
	  echo "success";
	} else {
	  echo $conn->error;
	}
}
else{
	echo "string";
}