<?php

$ram108_fancybox = new ram108_fancybox;

class ram108_fancybox{

	public function __construct(){

		add_action('wp_enqueue_scripts', array( $this, '_register_scripts') );
		add_action('wp_footer', array( $this, '_add_script') );
	}

	public function _register_scripts(){

		wp_enqueue_style( 'fancybox', plugins_url('fancybox/jquery.fancybox-1.3.6.css', __FILE__) ); 
		wp_enqueue_script( 'fancybox', plugins_url('fancybox/jquery.fancybox-1.3.6.min.js', __FILE__), array('jquery') ); 
		wp_enqueue_script( 'jquery-mousewheel', plugins_url('jquery.mousewheel.js', __FILE__), array('jquery') ); 
		wp_enqueue_script( 'jquery-easing', plugins_url('jquery.easing.js', __FILE__), array('jquery') ); 
	}

	public function _add_script(){ ?>
		<!-- [ram108] activate fancybox -->
		<script type="text/javascript">jQuery(document).ready(function($){
			// FIX: remove dublicate links
			$('.ram108_fbimage').each(function(){ var seen = {}; $('a', this).each(function(){ var href = $(this).attr('href'); if (seen[href]) $(this).remove(); else seen[href] = true; }) });
			// activate fancybox
			$('.ram108_fbimage a, .fancybox').fancybox({'transitionIn':'elastic','easingIn':'easeOutBack','transitionOut':'elastic','easingOut':'easeInBack','opacity':false,'hideOnContentClick':false,'titleShow':true,'titleFromAlt':true,'showNavArrows':true,'enableKeyboardNav':true,'titlePosition':'over','centerOnScroll':true,'cyclic':true});
		});</script>
	<?php }
}
