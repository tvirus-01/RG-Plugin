<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url( '../../assets/css/countdown.css', __FILE__ ); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url( '../../assets/css/style.css', __FILE__ ); ?>">
<link rel="stylesheet" type="text/css" href="<?php //echo plugins_url( '../../assets/css/bootstrap.min.css', __FILE__ ); ?>">

<!-- game content start -->
<div class="row">
	<div class="col">
		<h2 id="game_title"><?php echo $game_name; ?></h2>
		<div class="overlay"></div>
	</div>
</div>
<br>
<div class="row justify-content-center p-5" style="height: 500px;">
	<div class="col">
		<div id="chart" class="p-2" plugin_path="<?php echo plugin_dir_url( __FILE__ ) ?>"></div>
		<div id="tooltip" class="hidden"></div>
		<div id="question">
			<h1>Join our prizepoll only limited ticket left</h1>
			<h4 style="margin-top: 5%;"><span class="sale_tag">Only <?php echo $crr_sym.$tk_price; ?> per ticket</span> <button class="btn btn-primary btn-lg" logged_in="<?php echo $logged_in; ?>"  link="<?php echo $href; ?>" id="buy_ticket">Buy Now</button></h4>
		</div>
		<!-- <span class="np_yet"></span> -->
	</div>
</div>
<div class="row data">
	<input type="hidden" id="img_url" value="<?php echo plugins_url( '../../assets/img/upload/'.$item_image, __FILE__ ); ?>">
	<input type="hidden" id="ticket_id" value="<?php echo $ticket_id; ?>">
	<input type="hidden" id="percipient_limit" value="<?php echo $percipient_limit; ?>">
	<input type="hidden" id="itm_name" value="<?php echo $item_title; ?>">
	<input type="hidden" id="tk_price" value="<?php echo $tk_price; ?>">
	<input type="hidden" id="duration" value="<?php echo $duration; ?>">
	<input type="hidden" id="declartion_text" value="<?php echo $declartion_text; ?>">
    <input type="hidden" id="set-time" value="<?php echo $tx; ?>"/>
    <input type="hidden" id="demo" value="<?php echo $demo; ?>"/>
	<?php
		if ( is_front_page() ){ 
			echo '<input type="hidden" id="is_home" value="1"/>';
		}else{
			echo '<input type="hidden" id="is_home" value="0"/>';
		}
	?>
</div>
<div class="row">
  <div class="col">
    <div id="countdown">
      
      <div id='tiles' class="color-full"></div>
      <div class="countdown-label">Time Remaining</div>
    </div>
  </div>
</div>
<!-- game content end -->


<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<script src="<?php echo plugins_url( '../../assets/js/jquery.min.js', __FILE__ ); ?>" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js" integrity="sha512-IQLehpLoVS4fNzl7IfH8Iowfm5+RiMGtHykgZJl9AWMgqx0AmJ6cRWcB+GaGVtIsnC4voMfm8f2vwtY+6oPjpQ==" crossorigin="anonymous"></script>
<script src="<?php echo plugins_url( '../../assets/js/countdown.js', __FILE__ ); ?>" charset="utf-8"></script>
<script src="<?php echo plugins_url( '../../assets/js/main.js', __FILE__ ); ?>" charset="utf-8"></script>
<script src="<?php echo plugins_url( '../../assets/js/bootstrap.min.js', __FILE__ ); ?>" charset="utf-8"></script>