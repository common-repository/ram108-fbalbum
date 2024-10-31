<?php

$ram108_fbalbum_shortcode = new ram108_fbalbum_shortcode;

class ram108_fbalbum_shortcode {

	protected 
		$args,
		$options;

	protected 
		$limit = 100;

	public
		$ratio = 0.666;

	public function __construct(){

		require( 'fbalbum_data.php' );
		$this->options = &$GLOBALS['ram108_fbalbum_settings']; 
		add_shortcode('fbalbum', array( $this, 'fbalbum_shortcode' ) );
	}

	public function fbalbum_shortcode( $args ){

		// SLIDER
		if ( @$args['slider'] ) return $GLOBALS['ram108_fbalbum_slider']->fbalbum_slider( $args );

		// ARGS
		extract( $this->args = $args = shortcode_atts( array(
			'url'			=> '',
			'limit'			=> $this->limit,
			'desc'			=> 0,
			'random'		=> 0,
			'size'			=> $this->options->thumb_size,
			'shape'			=> $this->options->thumb_shape,
			'hidden'		=> 0,

			// private
			'compact'		=> 0,
			'nofblike'		=> 0,
		), $args ));

		// DATA
		$limit = $args['limit'] = (int)$limit ? (int)$limit : $this->limit;
		$data = new ram108_fbalbum_data( $args ); if ( $data->error ) return $data->error;

		$album = $data->album;
		$width = $size; $height = $shape == 0 ? intval( $this->ratio*$size ) : $size;

		ob_start(); ?>

		<!-- [ram108] Facebook Photo Album v.<?php echo _RAM108_FBALBUM_VER?> -->

		<div class="ram108_fbalbum">

			<?php if ( $desc ): ?>
			<h2 class="ram108_fbtitle"><?php echo $album['name']?></h2>
			<p class="ram108_fbdesc"><?php echo $album['description']?></p>
			<?php endif; ?>

			<div class="ram108_fbwrapper">
				<?php foreach( $data->image as $i => $image ):?>
				<div class="ram108_fbimage<?php if ( $shape == 2 ):?> ram108_fbcircle<?php endif;?><?php if ( $i >= $limit ):?> ram108_fbhidden<?php endif; ?>">
					<div class="ram108_fbthumb" style="background-image:url('<?php echo $image['thumb']?>'); width:<?php echo $width?>px; height:<?php echo $height?>px;">
						<a rel="gallery-<?php echo $album['id']?> nofollow" href="<?php echo $image['url']?>" title="<?php echo $image['name']?>" target="_blank"></a>
						<img src="<?php echo $image['thumb']?>" alt="<?php echo $image['name']?>" />
						<?php if ( $image['name'] != $album['name'] ):?><p class="caption"><?php echo $image['name']?></p><?php endif;?>
					</div>
				</div>
				<?php endforeach; ?>
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
}