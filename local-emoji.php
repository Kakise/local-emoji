<?php
/*
 * Plugin Name: Local Emoji
 * Plugin URI: https://kakise.me/2017/07/26/local-emoji-premiere-extension-wordpress/
 * Description: Serve emojis from wordpress' server
 * Version: 2.0.0
 * Author: Kakise
 * Author URI: https://kakise.me/
 * License: GPLv3 or later
 * Text Domain: local-emoji
 * Domain Path: /languages/
*/


if( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, don\'t call me plz.';
	exit;
}

add_action( 'init', array( 'Local_Emoji', 'init' ) );

class Local_Emoji {
	static $instance;

	const VERSION = '2.0.0';

	static function init() {
		if( ! self::$instance ) {
			if( did_action( 'plugins_loaded' ) ) {
				self::plugin_textdomain();
			} else {
				add_action( 'plugins_loaded', array( __CLASS__, 'plugin_textdomain' ) );
			}

			self::$instance = new Local_Emoji;
		}
		return self::$instance;
	}

	private function __construct() {
		add_filter( 'emoji_url',     array( &$this, 'emoji_url'     ), 10, 2 );
		add_filter( 'emoji_svg_url', array( &$this, 'emoji_svg_url' ), 10, 2 );
	}

	function emoji_url( $emoji_url ) {
		return plugins_url( '72x72/', __FILE__ );
	}

	function emoji_svg_url( $emoji_svg_url ) {
		return plugins_url( 'svg/', __FILE__ );
	}

	static function plugin_textdomain() {
		load_plugin_textdomain( 'local-emoji', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}
