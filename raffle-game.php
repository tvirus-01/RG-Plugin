<?php

/**
* @package RaffleGamePlugin
*/
/*
Plugin Name: Raffle Game
Plugin URI: https://github.com/tvirus-01
Description: Wordpress plugin for creating raffle game with woocommerce
Version: 0.0.1
Author: SA SHAKI
Author URI: https://github.com/tvirus-01
Licence: MIT
*/

/*
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

defined('ABSPATH') or die('DIE BITCH');


class raffleGame{
	//methods
	public $templates;

	function register(){
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );
		add_action( 'wp_footer', array($this, 'rg_enqueue') );

		add_action( 'admin_menu', array($this, 'add_admin_pages') );

		add_action( 'wp_head', array( $this, 'add_auth_template' ) );

		add_action( 'template_redirect', array($this, 'redirect_non_logged_users_to_specific_page') );

		add_action( 'woocommerce_thankyou', array($this, 'rg_ap_redirectcustom'));

		// template custom
		$this->templates = array(
			'wp-templates/raffle-tpl.php' => 'RG-Raffle-template',
			'wp-templates/ap-tpl.php' => 'RG-After-purchase',
			'wp-templates/rg-thanks-tpl.php' => 'RG-Thank-You',
		);

		add_filter( 'theme_page_templates', array( $this, 'custom_template' ) );
		add_filter( 'template_include', array( $this, 'load_template' ) );
	}

	function rg_ap_redirectcustom( $order_id ){

	    $order = wc_get_order( $order_id );

	    $url = get_site_url().'/rg-after?oid='.$order_id;

	    if ( ! $order->has_status( 'failed' ) ) {

	        wp_safe_redirect( $url );

	        exit;

	    }

	}


	public function custom_template( $templates ){
		$templates = array_merge( $templates, $this->templates );

		return $templates;
	}

	public function load_template( $template ){
		global $post;

		if ( ! $post ) {
			return $template;
		}

		$template_name = get_post_meta( $post->ID, '_wp_page_template', true );

		if ( ! isset( $this->templates[$template_name] ) ) {
			return $template;
		}

		$file = plugin_dir_path( __FILE__ ) . $template_name;
		// echo $file;

		if ( file_exists( $file ) ) {
			return $file;
		}

		return $template;
	}

	public function add_admin_pages(){
		add_menu_page( 'Raffle Game', "raffle games", 'manage_options', 'rg_plugin', array($this, 'rg_index'), plugins_url( '/assets/img/rg-icon.png', __FILE__ ), 45 );
		add_submenu_page( 'rg_plugin', 'Create Game', 'create game', 'manage_options', 'rg_create_game', array($this, 'rg_create_game'));
		add_submenu_page( 'rg_plugin', 'Game Winner', 'Game Winner', 'manage_options', 'rg_game_winner', array($this, 'rg_game_winner'));
	}

	public function rg_index(){
		require_once plugin_dir_path( __FILE__ ).'/templates/admin.php';
	}

	public function rg_create_game(){
		require_once plugin_dir_path( __FILE__ ).'/templates/createGame.php';
	}

	public function rg_game_winner(){
		require_once plugin_dir_path( __FILE__ ).'/templates/gameWinner.php';
	}

	function activate(){
		$dbtbl = ABSPATH.'wp-content/plugins/raffle-game/modules/dbTable.php';
		require_once $dbtbl;
	}

	function deactivate(){
		
	}

	function uninstall(){
		$drptbl = ABSPATH.'wp-content/plugins/raffle-game/modules/dropTable.php';
		require_once $drptbl;
	}


	function rg_enqueue(){
		wp_enqueue_style('rgpluginstyle', plugins_url( '/assets/css/rgStyle.css', __FILE__ ));
		wp_enqueue_script('rgpluginscript_jq', plugins_url( '/assets/js/jquery.min.js', __FILE__ ));
		wp_enqueue_script('rgpluginscript', plugins_url( '/assets/js/rgScript.js', __FILE__ ));
	}

	function enqueue(){
		wp_enqueue_style('rgpluginstyle_1', plugins_url( '/assets/css/material-dashboard.css', __FILE__ ));
		wp_enqueue_style('rgpluginstyle_2', plugins_url( '/assets/css/admin.css', __FILE__ ));
	}

	function redirect_non_logged_users_to_specific_page() {

	if ( is_user_logged_in() && is_page('login') && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {

	wp_redirect( get_site_url('home') ); 
	    exit;
	   }
	}

	public function add_auth_template()
	{
		if ( is_user_logged_in() ) return;

		$file = plugins_url( 'templates/auth.php', __FILE__ );

		if ( file_exists( $file ) ) {
		load_template( $file, f );
		}
	}
}

if(class_exists('raffleGame')){
	$raffle_game = new raffleGame();
	$raffle_game->register();
}

//activation hock
register_activation_hook( __FILE__, array($raffle_game, 'activate') );

//deactivation hock
register_deactivation_hook( __FILE__, array($raffle_game, 'deactivate') );


//shortcode
function raffle_game_shortcode($atts){
	extract(shortcode_atts( array(
		'game_id' => 'NULL'
	),
	$atts));

	if ($game_id != 'NULL') {
		ob_start();
		include ABSPATH.'wp-content/plugins/raffle-game/templates/front/raffle.php';
		$content = ob_get_clean();
		return $content;
	}
}

add_shortcode( 'raffle_game', 'raffle_game_shortcode' );