<?php

$ram108_fbalbum_button = new ram108_fbalbum_button;

class ram108_fbalbum_button {

	protected $options;

	public function __construct(){

		$this->options = &$GLOBALS['ram108_fbalbum_settings']; 

		add_action('media_buttons_context', array( $this, '_add_button' ) );
		add_action('admin_footer',  array( $this, '_add_button_dialog'));
	}

	public function _add_button_dialog() { ?>

		<div id="ram108-fbalbum-window" style="display:none;">

			<div class="wrap" style="padding: 10px;">

				<form id="ram108-fbalbum-form">

				<h2>[ram108] Facebook Photo Album</h2>

				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e('Album URL', $this->options->id );?></th><td>
						<input class="widefat" name="url" type="text" value="" /><br/>
						<small><?php printf( __('How to find %1$sAlbum URL%2$s', $this->options->id ), '<a href="http://wordpress.org/plugins/ram108-fbalbum/faq/" target="_blank">', '</a>' );?></small>
					</td></tr>
					<tr valign="top"><th scope="row"><?php _e('Number of images to show', $this->options->id );?></th><td>
						<input class="widefat" name="limit" type="text" value="" />
						<br/><small><?php _e('Leave blank to get all', $this->options->id );?></small>
					</td></tr>
					<tr valign="top"><th scope="row"><?php _e('Display style', $this->options->id );?></th><td>
						<fieldset>
							<label><input name="slider" type="radio" value="" checked="checked"> <?php _e('Album', $this->options->id );?>&nbsp;&nbsp;&nbsp;</label>
							<label><input name="slider" type="radio" value="1"> <?php _e('Slider', $this->options->id );?>&nbsp;&nbsp;&nbsp;</label>
						</fieldset>
					</td></tr>
					<tr valign="top"><th scope="row"><?php _e('Options', $this->options->id );?></th><td>
						<label><input class="checkbox" type="checkbox" name="desc" value="1" /> <?php _e('Add album title and description from Facebook', $this->options->id );?></label><br/>
						<label><input class="checkbox" type="checkbox" name="random" value="1" /> <?php _e('Random pick', $this->options->id );?></label>
					</td></tr>
				</table>

				<table class="form-table">
					<tr valign="top"><th scope="row">&nbsp;</th><td>
						<input id="ram108-fbalbum-submit" type="button" class="button-primary" value="<?php _e('Insert into post'); ?>" />&nbsp;&nbsp;&nbsp;<a class="button" href="#" onclick="tb_remove(); return false;"><?php _e('Cancel'); ?></a>
					</td></tr>
				</table>

				<hr style="margin-top: 30px; border: 0; border-top: 1px solid #CCC"/>

				<h3><?php _e('Additional options', $this->options->id );?></h3>

				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e('Thumbnail shape', $this->options->id );?></th><td>
						<select name="shape">
							<option value=""> <?php _e('Default', $this->options->id );?></option>
							<option value="0"> <?php _e('Rectangular', $this->options->id );?></option>
							<option value="1"> <?php _e('Square', $this->options->id );?></option>
							<option value="2"> <?php _e('Circle', $this->options->id );?></option>
						</select>
					</td></tr>
					<tr valign="top"><th scope="row"><?php _e('Thumbnail size', $this->options->id );?></th><td>
						<input class="widefat" name="size" type="text" value="" />
						<br/><small><?php _e('Leave blank to use default', $this->options->id );?></small>
					</td></tr>
				</table>

				</form>

				<br />
				<?php ram108_fbalbum_registration_notice(); ?>

				<?php ram108_fbalbum_stats(); ?>

				<style type="text/css">
					#TB_ajaxContent{
						overflow: hidden;
					}
				</style>

			</div><!-- wrap -->

		</div><!-- #ram108-fbalbum-window -->

		<!-- [ram108] create shortcode script -->
		<script type="text/javascript">jQuery(document).ready(function($){
			$('#ram108-fbalbum-submit').click(function(){
				var shortcode = '';
				$('#ram108-fbalbum-form :input').each(function(){
					var elm = $(this);
					if ( elm.val() && elm.attr('name') && ( ( elm.attr('type') != 'checkbox' && elm.attr('type') != 'radio' ) || elm.prop('checked') ) ) shortcode += ' ' + elm.attr('name') + '="' + elm.val() + '"';
				});
				if ( shortcode ) window.send_to_editor('[fbalbum' + shortcode + ']'); else window.tb_remove();
			});
		});</script>

	<?php 
	}

	public function _add_button( $text ) {

		return $text . '<a class="thickbox button" style="padding-left: 3px;" href="#TB_inline?width=600&height=600&inlineId=ram108-fbalbum-window" title="[ram108] Facebook Photo Album"><img style="vertical-align:middle" src="' . plugins_url('button.png', __FILE__) . '" alt />'.__( 'Album', $this->options->id ).'</a>';
	}
}
