<?php 

$ram108_fbalbum_functions = new ram108_fbalbum_functions;

class ram108_fbalbum_functions {

	protected $options;

	public function __construct(){

		$this->options = &$GLOBALS['ram108_fbalbum_settings']; 

		add_action('wp_head', array( $this, '_activate_lightbox') );
		add_action('wp_head', array( $this, '_admin_functions_settings') );
		add_action('wp_enqueue_scripts', array( $this, '_admin_functions') );
	}

	public function _activate_lightbox(){ 
		if ( $this->options->fancybox ) return;
		?>
		<!-- [ram108] makeup for lightbox -->
		<script type="text/javascript">jQuery(document).ready(function($){
			$('.ram108_fbimage a[rel*="gallery"]').each(function(){
				var e = $(this);
				var id = e.attr('rel').match(/gallery-(\d+)/i)[1]; 
				e.attr('rel', 'gallery-'+id+' lightbox['+id+'] prettyPhoto nofollow' );
				e.attr('class', 'lightbox colorbox cboxElement thickbox fancybox');
			});
		});</script>
		<?php 
	}

	public function _admin_functions_settings(){
		if ( $this->options->nofblink && $this->options->nocredits ) return;
		$text = ''; if ( $this->options->nofblink ) $text.= 'var rnf=1;'; if ( $this->options->nocredits ) $text.= 'var rnc=1;'; if ( $text ) echo '<script>'.$text.'</script>';
	}
	
	public function _admin_functions(){
		if ( $this->options->nofblink && $this->options->nocredits ) return;
		wp_enqueue_script( 'ram108-fbalbum-functions', plugins_url('plugin_admin/functions.min.js', __FILE__), array('jquery') );
	}
}

// function ram108_fbalbum_stats(){ 
// 	$options = &$GLOBALS['ram108_fbalbum_settings']; preg_match('|(?:\d+\.?)+|', PHP_VERSION, $php ); $php = @$php[0];
// 	echo '<img src="http://www.ram108.ru/plugin.gif?plugin=ram108-fbalbum&v='. _RAM108_FBALBUM_VER .'&r='.(bool)$options->nocredits.'&f='.(bool)$options->facebook_token.'&p='.$php.'" width=1 height=1 border=0 alt />';
// }

function ram108_fbalbum_registration_notice(){ 
	$options = &$GLOBALS['ram108_fbalbum_settings']; if ( $options->nocredits || $options->nofblink ) return;
	?>
	<div class="register_notice">
		<h3><?php _e('Register your copy of plugin', $options->id );?></h3>
		<p>
			<a href="http://www.ram108.ru/donate" target="_blank"><?php _e('Support the developer with donation', $options->id );?></a>. 
			<?php _e('It will allow to use registered version of plugin and to hide plugin attribution', $options->id );?> "by [ram108] Facebook Photo Album".
		</p>
	</div>
	<style type="text/css">
		.register_notice {
			border: 1px solid #CCC;
			padding: 10px 18px;
			margin: 0;
			background-color: #F5F5F5;
		}
		.register_notice h3, .register_notice p {
			margin: 3px 0 !important;
			padding: 0 !important;
		}
	</style>
	<?php 
}
