<?php

$GLOBALS['ram108_fbalbum_slider'] = new ram108_fbalbum_slider;

class ram108_fbalbum_slider {

	protected 
		$args,
		$options;

	protected 
		$limit = 60,
		$size = 700,
		$speed = 600;

	public
		$ratio = 0.666;

	public function __construct(){

		$this->options = &$GLOBALS['ram108_fbalbum_settings']; 
		add_action( 'wp_enqueue_scripts', array( $this, '_register_scripts') );
	}

	public function fbalbum_slider( $args ){

		wp_enqueue_style( 'ram108-fbslider' );
		wp_enqueue_script( 'ram108-fbslider' ); 
		add_action( 'wp_footer', array( $this, '_add_scripts' ) );

		// ARGS
		extract( $this->args = $args = shortcode_atts( array(
			'url'			=> '',
			'limit'			=> $this->limit,
			'desc'			=> 0,
			'random'		=> 0,

			// slider
			'slider_start'	=> 1,
			'slider_size'	=> $this->size,
			'slider_pager'	=> 1,

			// private
			'compact'		=> 0,
			'nofblike'		=> 0,
		), $args ));

		// DATA
		$limit = $args['limit'] = (int)$limit ? (int)$limit : $this->limit;
		$size = $args['size'] = $args['slider_size'];
		$data = new ram108_fbalbum_data( $args ); if ( $data->error ) return $data->error;

		$album = $data->album;
		$width = $size; $height = intval( $this->ratio * $size );

		ob_start(); ?>

		<!-- [ram108] Facebook Photo Album v.<?php echo _RAM108_FBALBUM_VER?> -->

		<div class="ram108_fbalbum ram108_fbslider">

			<?php if ( $desc ): ?>
			<h2 class="ram108_fbtitle"><?php echo $album['name']?></h2>
			<p class="ram108_fbdesc"><?php echo $album['description']?></p>
			<?php endif; ?>

			<div class="ram108_fbwrapper">
				<div class="rslides_container">
					<div class="rslides rslides-<?php echo $album['id']?>">
						<?php foreach( $data->image as $i => $image ):?>
						<div class="ram108_fbthumb" style="background-image:url('<?php echo $image['thumb']?>')">
							<img src="<?php echo $image['thumb']?>" alt="<?php echo $image['name']?>" />
							<p class="caption"><?php echo $image['name']?></p>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<?php 
			// **************************************************************************
			// Credits removal available on donations. Please respect the developer
			// and his work spent to have this plugin available for public.
			// http://www.ram108.ru/donate
			// **************************************************************************
			?>
			<p class="ram108_fblink"><span><a href="<?php echo $url?>" title="<?php echo $album['name']?>" target="_blank" rel="nofollow"><?php _e('View on Facebook', $this->options->id);?></a> </span><span>by [ram108] Facebook Photo Album plugin</span></p>
			<?php 
			// **************************************************************************
			// Credits removal available on donations. Please respect the developer
			// and his work spent to have this plugin available for public.
			// http://www.ram108.ru/donate
			// **************************************************************************
			?>

			<?php $this->_show_fblike(); ?>

			<!-- [ram108] slider script -->
			<script type="text/javascript">jQuery(document).ready(function($){
				$('.rslides-<?php echo $album['id']?>').responsiveSlides({'nav':true,'pause':true,
					'auto': <?php echo $slider_start ? 'true' : 'false'; ?>,
					'maxwidth': <?php echo $slider_size?>,
					'pager': <?php echo $slider_pager ? 'true' : 'false'; ?>,
					'speed': <?php echo $this->speed?>
				});
			});</script>

		</div>

		<!-- /ram108_fbalbum -->

		<?php 
		return ob_get_clean();
	}

	// HELPERS

	function _show_fblike(){ if ( $this->options->fblike && !$this->args['nofblike'] ){?>
		<div class="ram108_fblike">
			<?php $fblink = $this->args['compact'] ? get_home_url() : get_permalink(); ?>
			<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode( $fblink ); ?>&amp;layout=<?php echo $this->args['compact'] ? 'button_count' : 'standard'; ?>&amp;action=like&amp;show_faces=false&amp;share=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:30px; width:100%; max-width:700px;" allowTransparency="true"></iframe>
		</div>
	<?php }}

	// OTHER

	public function _register_scripts(){

		wp_register_style( 'ram108-fbslider', plugins_url('style.css', __FILE__) );
		wp_register_script( 'ram108-fbslider', plugins_url('responsiveslides/responsiveslides.min.js', __FILE__), array('jquery') ); 
	}

	function _add_scripts(){?>
		<!-- [ram108] dynamic w/h for slider -->
		<script type="text/javascript">jQuery(function($){
			// resize image on change
			$(document).ready(function(){rslides_height();});$(window).load(function(){rslides_height();});$(window).resize(function(){rslides_height();});
			function rslides_height(){
				$('.rslides').each(function(){
					var e = $(this); var w = e.width(); var h = <?php echo $this->ratio?>*w;
					e.children('div').css({'width':w,'height':h});
				});
			}
			// container max width fix
			$(document).ready(function(){
				$('.rslides_container').each(function(){
					var e = $(this);
					e.css('max-width', e.find('.rslides').css('max-width'));
				});
			});
		});</script>
	<?php }
}