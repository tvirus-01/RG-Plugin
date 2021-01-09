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

	function register(){
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );

		add_action( 'admin_menu', array($this, 'add_admin_pages') );
	}

	public function add_admin_pages(){
		add_menu_page( 'Raffle Game', "raffle_game", 'manage_options', 'rg_plugin', array($this, 'rg_index'), '', 45 );
	}

	public function rg_index(){
		//
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

	function enqueue(){
		wp_enqueue_style('rgpluginstyle', plugins_url( '/assets/css/rgStyle.css', __FILE__ ));
		wp_enqueue_script('rgpluginscript', plugins_url( '/assets/js/rgScript.js', __FILE__ ));
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