<?php
/**
Plugin Name: [ram108] Facebook Photo Album
Plugin URI: http://www.ram108.ru/plugins/ram108-fbalbum
Description: Easy way to add Facebook photo albums to your site. Includes widget, shortcode and Facebook slider.
Version: 0.5.1
Author: ram108
Author URI: http://profiles.wordpress.org/ram108
Author Email: mail@ram108.ru
Text Domain: ram108-fbalbum
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
======================================================================================
Copyright 2013 Kirill Borodin mail@ram108.ru
You are free to use the plugin on personal and non-profit websites. 
Donation is required for commercial projects and to have plugin credits removal.
Please contact plugin author for information on plugin usage.
======================================================================================
*/

// PHP VERSION CHECK

if ( version_compare( PHP_VERSION, '5.2.0', '<' ) ) {

	add_action( 'admin_notices', 'ram108_php_warning' );

	function ram108_php_warning(){ ?>
		<div class="error">
			<p><b>[ram108] Facebook Photo Album</b>: 
			The plugin require <strong>PHP 5.2</strong> or higher to run. Sorry...
			</p>
		</div>
	<?php }

	return;
}

// INIT

define( '_RAM108_FBALBUM', __FILE__ );
define( '_RAM108_FBALBUM_VER', '0.5.1' );

require( 'functions.php' );

// PLUGIN CLASS

$ram108_fbalbum_plugin = new ram108_fbalbum_plugin;

class ram108_fbalbum_plugin {

	protected $options;

	public function __construct(){

		// SETTINGS
		require( 'includes/plugin_settings/plugin_settings.php' );
		$this->options = &$GLOBALS['ram108_fbalbum_settings']; 

		// MODULES
		require( 'includes/functions.php' );
		require( 'includes/fbalbum_shortcode/fbalbum_shortcode.php' );
		require( 'includes/fbalbum_slider/fbalbum_slider.php' );
		require( 'includes/fbalbum_widget/fbalbum_widget.php' );
		if ( $this->options->fancybox ) require( 'includes/fancybox/fancybox.php' );

		// ADMIN
		if ( is_admin() ) {
		require( 'includes/plugin_admin/plugin_admin.php' );
		require( 'includes/fbalbum_button/fbalbum_button.php' );
		} 

		// OTHER
		add_action( 'wp_enqueue_scripts', array( $this, '_register_scripts' ) );
		add_action( 'plugins_loaded', array( $this, '_textdomain' ) );

		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'the_excerpt', 'do_shortcode' );
	}

	public function _register_scripts(){

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'ram108-fbalbum', plugins_url('style.css', __FILE__) );
	}

	public function _textdomain(){

		load_plugin_textdomain( 'ram108-fbalbum', false, dirname( plugin_basename( _RAM108_FBALBUM ) ) . '/languages/' );
	}
}