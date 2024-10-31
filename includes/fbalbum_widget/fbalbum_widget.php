<?php

add_action('widgets_init', create_function('', "register_widget('ram108_fbalbum_widget');" ) );

class ram108_fbalbum_widget extends WP_Widget {

	private
		$options;

	private 
		$limit = 50,
		$size = 75,
		$shape = 1,
		$slider_size = 400;

	public function __construct() {

		$this->options = &$GLOBALS['ram108_fbalbum_settings']; 

		$this->WP_Widget('ram108-fbwidget', '[ram108] Facebook Photo Album', array(

			'classname'     => 'ram108_fbwidget',
			'description'   => __('Add Facebook photos to your site. Album or slider style.', $this->options->id ),
		));
	}

	public function form( $data ){

		extract( wp_parse_args( (array) $data, array( 'title' => '', 'url' => '', 'limit' => '', 'random' => '', 'hidden' => '', 'slider' => '', 'nofblike' => '' ) ) ); 
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' );?>"><?php _e( 'Title' ); ?>:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' );?>" name="<?php echo $this->get_field_name( 'title' );?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' );?>"><?php _e( 'Album URL', $this->options->id ); ?> (<a href="http://wordpress.org/plugins/ram108-fbalbum/faq/" target="_blank"><?php _e( 'how to find', $this->options->id ); ?></a>):</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Number of images to show', $this->options->id ); ?>:</label> 
			<input id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" size="3" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'random' );?>" name="<?php echo $this->get_field_name( 'random' );?>" value="1" <?php checked( '1', $random );?> />
			<label for="<?php echo $this->get_field_id( 'random' );?>"><?php _e( 'Random pick', $this->options->id  );?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'hidden' );?>" name="<?php echo $this->get_field_name( 'hidden' );?>" value="1" <?php checked( '1', $hidden );?> />
			<label for="<?php echo $this->get_field_id( 'hidden' );?>"><?php _e( 'Add hidden images', $this->options->id  );?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'slider' );?>" name="<?php echo $this->get_field_name( 'slider' );?>" value="1" <?php checked( '1', $slider );?> />
			<label for="<?php echo $this->get_field_id( 'slider' );?>"><?php _e( 'Slider style', $this->options->id  );?></label>
		</p>
		<?php if ( $this->options->fblike ): ?>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'nofblike' );?>" name="<?php echo $this->get_field_name( 'nofblike' );?>" value="1" <?php checked( '1', $nofblike );?> />
			<label for="<?php echo $this->get_field_id( 'nofblike' );?>"><?php _e( 'Hide Facebook button', $this->options->id  );?></label>
		</p>
		<?php endif; ?>
		<?php 
	}

	public function update( $data, $old_data ) {

		$data['title'] = strip_tags( $data['title'] );
		$data['url'] = strip_tags( $data['url'] );
		$data['limit'] = (int) $data['limit'] ? (int) $data['limit'] : '';

		return $data;
	}

	public function widget( $args, $data ) {

		extract( $args );

		// WIDGET
		$text = '';
		$text .= $data['title'] ? $before_title . apply_filters( 'widget_title', $data['title'] ) . $after_title : '';

		// DATA
		if ( empty( $data['limit'] ) ) $data['limit'] = $this->size;
		$data['size'] = $this->size;
		$data['shape'] = $this->shape;
		$data['slider_size'] = $this->slider_size;
		$data['compact'] = 1; // use compact style

		// SHORTCODE
		$shortcode = '';
		foreach( $data as $k => $v ) $shortcode .= " $k=\"$v\"";
		$shortcode = "[fbalbum$shortcode]";

		$text .= do_shortcode( $shortcode );

		// RESULT
		echo $before_widget . $text . $after_widget;
	}
}
