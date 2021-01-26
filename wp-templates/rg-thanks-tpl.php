<?php
/*
Template Name: RG-Thank-You
*/
get_header();
?>
<style type="text/css">
	.container{
		
	}.rg-thanks-wrap{
		background-image: url(<?php echo get_site_url().'/wp-content/plugins/raffle-game/assets/img/rg-thanks-bg.png'; ?>);
		height: 500px;
		background-repeat: no-repeat;
	}
	h1{
		text-align: center;
	    font-size: 40px;
	    margin-top: 15px;
	}
	p{
		float: right;
		text-align: center;
		font-size: 20px;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col rg-thanks-wrap">
			<h1 class="display-3">Thank You For Your Purchase!</h1>
		    <!-- <p class="lead"><strong>Please check your email</strong> for further instructions on how to complete your account setup.</p> -->
		    <hr>
		   <p>
		      Having trouble? <a href="contact">Contact us</a>
		   <br>
		      <button class="btn">
		      	<a href="<?php echo get_site_url(); ?>" role="button">Continue to homepage</a>
		      </button>
		    </p>
		</div>
	</div>
</div>

<?php
get_footer();