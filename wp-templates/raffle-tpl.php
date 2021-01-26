<?php

/*
Template Name: RG-Raffle-template
*/
get_header();
$href = '#buy_ticket_sec';
// echo '<link rel="stylesheet" type="text/css" href=" '.plugins_url( '../assets/css/bootstrap.min.css', __FILE__ ).' ">';
echo '<link rel="stylesheet" type="text/css" href=" '.plugins_url( '../assets/css/text-animation.css', __FILE__ ).' ">';

include plugin_dir_path( __FILE__ )."../templates/front/raffle.php";
if ($game) {
	include plugin_dir_path( __FILE__ )."../templates/front/buy-ticket-sec.php";
}else{
?>
	<div class="row">
	<div class="col">
		<h1 style="text-align: center; font-size: 35px;">No Game Available Now</h1>
	</div>
	</div>
	<div class="row justify-content-center p-5" style="height: 500px; padding-left: 50px;">
		<div class="col" style="height: 800px;">
			<img src="<?php echo plugin_dir_url( __FILE__ ).'../assets/img/not-found.png'; ?>" style="width: 100%; height: 600px;">
		</div>
	</div>
<?php
}
get_footer();
?>