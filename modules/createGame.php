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

if (isset($_POST['g_name'])) {
	$filename = $_FILES['i_img']['name'];
	$g_name = $_POST['g_name'];
	$p_limit = $_POST['p_limit'];
	$due = $_POST['due'];
	$i_name = $_POST['i_name'];
	$tk_price = $_POST['tk_price'];
	$wd_text = $_POST['wd_text'];

	$sql_prod = "INSERT INTO `{$prefix}posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', 'Ticket for raffle draw', 'Ticket-{$g_name}', 'RG_ticket', 'publish', 'open', 'open', '', 'Ticket-{$g_name}', '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', '', '0', '', '0', 'product', '', '0')";
	$conn->query($sql_prod);
	$last_id = $conn->insert_id;

	$sql_prod_meta = "INSERT INTO `{$prefix}postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES 
					(NULL, {$last_id}, '_stock_status', 'instock'), 
					(NULL, {$last_id}, 'total_sales', '0'), 
					(NULL, {$last_id}, '_downloadable', 'no'), 
					(NULL, {$last_id}, '_featured', 'no'),
					(NULL, {$last_id}, '_price', '{$tk_price}'),
					(NULL, {$last_id}, '_stock', '{$p_limit}')";
	$conn->query($sql_prod_meta);


	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$new_filename = generateRandomString().'.'.$ext;

	$location = "../assets/img/upload/".$new_filename;

	$sql_0 = "SELECT * FROM {$prefix}posts WHERE post_excerpt = 'RG_ticket' AND post_title = 'Ticket-{$g_name}' ";
	// echo $sql_0;
	$res = $conn->query($sql_0);
	if ($res->num_rows > 0) {
		$ticket_id = 0;
		foreach ($res as $key) {
			$ticket_id = $key['ID'];
		}

		if ($ticket_id != 0) {
			if(move_uploaded_file($_FILES['i_img']['tmp_name'],$location)){
		    	$sql = "INSERT INTO `{$prefix}rg_game_info` (`id`, `game_name`, `percipient_limit`, `tk_price`, `duration`, `item_title`, `item_image`, `declartion_text`, `created_date`, `is_active`, `ticket_id`) VALUES (NULL, '{$g_name}', '{$p_limit}', '{$tk_price}', '{$due}', '{$i_name}', '{$new_filename}', '{$wd_text}', now(), FALSE, {$ticket_id})";
			
				if ($conn->query($sql) === TRUE) {
				  echo "success";
				} else {
				  echo $conn->error;
				}
		  	}else{
		  		echo "error permission";
		  	}
		}else{
	  		echo "error ticket id";
	  	}
	}else{
  		echo "error no product";
  	}
}