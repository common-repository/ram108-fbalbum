<?php

$ram108_fbalbum_admin = new ram108_fbalbum_admin;

class ram108_fbalbum_admin{

	protected $options;

	public function __construct(){

		$this->options = &$GLOBALS['ram108_fbalbum_settings']; 

		add_action('admin_init', array( $this, '_admin_init' ) );
		add_action('admin_menu', array( $this, '_admin_menu' ) );
		add_filter('plugin_action_links_'.plugin_basename( _RAM108_FBALBUM ), array( $this, '_admin_link' ) );
	}

	public function admin_page(){ ?>
		<div class="wrap">

			<?php screen_icon(); ?>
			
			<h2>[ram108] Facebook Photo Album</h2>

			<div style="width: 65%; float: left; margin-right: 20px;">

				<form method="post" action="options.php">

					<?php settings_fields( $this->options->id ); ?><?php do_settings_sections( $this->options->id ); ?>
					
					<input type="hidden" name="<?php echo $this->options->id?>[ver]" value="<?php echo $this->options->ver?>" />

					<h3><?php _e('Default album settings', $this->options->id );?></h3>

					<table class="form-table">
						<tr valign="top"><th scope="row"><?php _e('Thumbnail size', $this->options->id );?></th><td>
							<input type="number" step="5" min="5" class="small-text" name="<?php echo $this->options->id?>[thumb_size]" value="<?php echo esc_attr( $this->options->thumb_size )?>" />
						</td></tr>
						<tr valign="top"><th scope="row"><?php _e('Thumbnail shape', $this->options->id );?></th><td>
							<fieldset>
							<label><input name="<?php echo $this->options->id?>[thumb_shape]" type="radio" value="0" <?php checked( 0, $this->options->thumb_shape );?>> <?php _e('Rectangular', $this->options->id );?></label><br/>
							<label><input name="<?php echo $this->options->id?>[thumb_shape]" type="radio" value="1" <?php checked( 1, $this->options->thumb_shape );?>> <?php _e('Square', $this->options->id );?></label><br/>
							<label><input name="<?php echo $this->options->id?>[thumb_shape]" type="radio" value="2" <?php checked( 2, $this->options->thumb_shape );?>> <?php _e('Circle', $this->options->id );?></label>
							</fieldset>
						</td></tr>
					</table>

					<h3><?php _e('Other', $this->options->id );?></h3>

					<table class="form-table">
						<tr valign="top"><th scope="row"><?php _e('Builtin Fancybox', $this->options->id );?></th><td>
							<label><input name="<?php echo $this->options->id?>[fancybox]" type="checkbox" value="1" <?php checked( 1, @$this->options->fancybox );?>> <?php _e('Popup image appearing and gallery navigation', $this->options->id );?></label>
						</td></tr>
						<tr valign="top"><th scope="row"><?php _e('Facebook Like button', $this->options->id );?></th><td>
							<label><input name="<?php echo $this->options->id?>[fblike]" type="checkbox" value="1" <?php checked( 1, @$this->options->fblike );?>> <?php _e('Show Facebook Like button under each album', $this->options->id );?></label>
						</td></tr>
						<tr valign="top"><th scope="row"><?php _e('Hours to refresh albums', $this->options->id );?></th><td>
							<input type="number" step="1" min="1" class="small-text" name="<?php echo $this->options->id?>[album_expire]" value="<?php echo esc_attr( $this->options->album_expire )?>" />
						</td></tr>
					</table>

					<?php $this->facebook_connect(); ?>

					<?php $this->credits_removal(); ?>

					<?php submit_button(); ?>
					
				</form>

				<?php ram108_fbalbum_registration_notice(); ?>

			</div>

			<?php $this->widget_area(); ?>

		</div>

		<?php
	}

	// WIDGET AREA

	function widget_area(){
		?>
		<div style="width: 30%; float: right">

 			<h3><?php _e('Requirements check', $this->options->id );?></h3>
			<p><?php _e('The following extensions should be installed for proper work of plugin', $this->options->id );?>.</p>
			<p><?php $this->_check_val( CURL_AVAILABLE, 'cURL extension '.__('available', $this->options->id ), '<a href="https://www.google.com/search?q=how+to+enable+curl+extension">cURL extension</a> '.__('should be installed', $this->options->id ) ); ?></p>

			<h3><?php _e('Plugin usage', $this->options->id );?></h3>
			<p>
				<?php printf( __('Visit plugin %1$shome page%2$s for examples on plugin usage', $this->options->id ), '<a href="http://www.ram108.ru/plugins/ram108-fbalbum">', '</a>');?>.
				<?php printf( __('Read %1$stips & tricks%2$s with useful advises', $this->options->id ), '<a href="http://www.ram108.ru/post/59">', '</a>');?>.
			</p>

			<h3><?php _e('Thanks', $this->options->id );?></h3>
			<p><?php printf( __('Your feedback is very appreciated. %1$sRate plugin%2$s in Wordpress Plugin Directory or write review on your blog', $this->options->id ), '<a href="http://wordpress.org/support/view/plugin-reviews/ram108-fbalbum">', '</a>' );?>.</p>

			<h3><?php _e('Plugin news', $this->options->id );?></h3>
			<div class="news_widget">
			<?php
				wp_widget_rss_output( array(
					'link' => 'http://www.ram108.ru',
					'url' => 'http://www.ram108.ru/plugins/ram108-fbalbum/feed/',
					'title' => 'Plugin News',
					'items' => 4,
					'show_summary' => 0,
					'show_author' => 0,
					'show_date' => 0
				) );
			?>
			</div>
			<style type="text/css">
				.news_widget a{
					font-size: 100%;
					line-height: 1.2;
					font-family: inherit;
				}
			</style>
		</div>
		<?php
	}

	// CREDITS

	function credits_removal(){	
		?>
		<div id="credits" style="display:<?php echo @$this->options->nocredits || @$this->options->nofblink ? 'block' : 'none';?>">

		<h3>Credits removal</h3>

		<table class="form-table">
			<tr valign="top"><th scope="row">Hide plugin credits</th><td>
				<input name="<?php echo $this->options->id?>[nocredits]" type="checkbox" value="1" <?php checked( 1, @$this->options->nocredits );?>> Available on <a href="http://www.ram108.ru/donate">donations only</a>
			</td></tr>
			<tr valign="top"><th scope="row">Hide Facebook link</th><td>
				<input name="<?php echo $this->options->id?>[nofblink]" type="checkbox" value="1" <?php checked( 1, @$this->options->nofblink );?>> Available on <a href="http://www.ram108.ru/donate">donations only</a>
			</td></tr>
		</table>

		</div>

		<script type="text/javascript">jQuery(document).ready(function($){
			$(document).keydown(function(e) { 
				if ( e.which == 75 && e.ctrlKey && e.shiftKey ) $('#credits').show();
			});
		});</script>
		<?php
	}

	// FACEBOOK CONNECT

	public function facebook_connect(){

		$this->facebook_process_request();
		?>
		<h3><?php _e('Facebook connect', $this->options->id );?></h3>

		<input type="hidden" name="<?php echo $this->options->id?>[facebook_app]" value="<?php echo $this->options->facebook_app?>" />
		<input type="hidden" name="<?php echo $this->options->id?>[facebook_secret]" value="<?php echo esc_attr( $this->options->facebook_secret )?>" />
		<input type="hidden" name="<?php echo $this->options->id?>[facebook_app_name]" value="<?php echo $this->options->facebook_app_name?>" />
		<input type="hidden" name="<?php echo $this->options->id?>[facebook_token]" value="<?php echo $this->options->facebook_token?>" />
		<input type="hidden" name="<?php echo $this->options->id?>[facebook_expire]" value="<?php echo $this->options->facebook_expire?>" />
		<input type="hidden" name="<?php echo $this->options->id?>[facebook_user]" value="<?php echo $this->options->facebook_user?>" />
		<input type="hidden" name="<?php echo $this->options->id?>[facebook_user_url]" value="<?php echo $this->options->facebook_user_url?>" />

		<table class="form-table">

		<?php if ( !( $this->options->facebook_app && $this->options->facebook_secret ) ): ?>
			<p><?php printf( __('This step is not necessary if you plan to share photos from Facebook public pages. %1$sRead here%2$s how to access to your personal timeline photos.', $this->options->id), '<a href="http://www.ram108.ru/post/41" target="_blank">', '</a>' );?></p>
			<tr valign="top"><th scope="row"><?php _e('Facebook App ID', $this->options->id );?></th><td>
				<input type="text" name="<?php echo $this->options->id?>[facebook_app]" value="<?php echo esc_attr( $this->options->facebook_app )?>" />
			</td></tr>
			<tr valign="top"><th scope="row"><?php _e('Facebook App Secret', $this->options->id );?></th><td>
				<input type="text" name="<?php echo $this->options->id?>[facebook_secret]" value="<?php echo esc_attr( $this->options->facebook_secret )?>" />
			</td></tr>
		<?php endif; ?>

		<?php if ( $this->options->facebook_app && $this->options->facebook_secret ): ?>
			<tr valign="top"><th scope="row"><?php _e('Facebook App', $this->options->id );?></th><td>
				<a class="fbapp" href="https://developers.facebook.com/apps/<?php echo $this->options->facebook_app; ?>/summary/"><?php echo $this->options->facebook_app_name; ?></a>&nbsp;
				<a class="red" href="<?php echo admin_url( 'options-general.php?page='.$this->options->id.'&delete_app'); ?>" onclick="return showNotice.warn();">[<?php _e('Delete');?>]</a>
			</td></tr>
		<?php endif; ?>

		<?php if ( ( $this->options->facebook_app && $this->options->facebook_secret ) && !$this->options->facebook_token ): ?>
			<tr valign="top"><th scope="row"><?php _e('Connect Profile', $this->options->id );?></th><td>
				<a class="ram108_facebook_login" href="#" onClick="return false"><img src="<?php echo plugins_url( 'facebook-login-button.png', __FILE__ );?>" alt/></a>
			</td></tr>
		<?php endif; ?>

		<?php if ( $this->options->facebook_token ): ?>
			<tr valign="top"><th scope="row"><?php _e('Facebook Profile', $this->options->id );?></th><td>
				<a class="fbuser" href="<?php echo $this->options->facebook_user_url;?>"><?php echo $this->options->facebook_user;?></a>&nbsp;
				<a class="red" href="<?php echo admin_url( 'options-general.php?page='.$this->options->id.'&delete_user'); ?>" onclick="return showNotice.warn();">[<?php _e('Delete');?>]</a>
			</td></tr>
			<tr valign="top"><th scope="row"><?php _e('Facebook Profile privacy', $this->options->id );?></th><td>
				<?php $this->_check_val( @$this->facebook_access, __('Profile albums accessible', $this->options->id), sprintf( __('%1$sNo access%2$s to profile albums', $this->options->id), '<a href="http://www.ram108.ru/post/41#privacy">', '</a>') ); ?>
			</td></tr>
			<tr valign="top"><th scope="row"><?php _e('Session expiry', $this->options->id );?></th><td>
				<?php echo date( get_option('date_format'), $this->options->facebook_expire ); ?>&nbsp;
				<a class="ram108_facebook_login green" href="#" onClick="return false">[<?php _e('Refresh');?>]</a>
			</td></tr>
		<?php endif; ?>

		</table>

		<style type="text/css">
			.red{
				color: red;
			}
			.green{
				color: green;
			}
		</style>

		<?php if ( $this->options->facebook_app && $this->options->facebook_secret ): ?>
		<!-- [ram108] Facebook connect -->
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script type="text/javascript">jQuery(document).ready(function($){

			var appId = '<?php echo $this->options->facebook_app?>';
			var redirectUrl = '<?php echo admin_url( 'options-general.php?page='.$this->options->id );?>';

			// init
			FB.init({ appId: appId, status: true, cookie: true, oauth: true });

			// login
			$('.ram108_facebook_login').click(function(){
				FB.login(function(r) {
					if (r.authResponse) FB.api('/me', function(r) {
						window.location.replace( redirectUrl + '&token=' + FB.getAuthResponse()['accessToken'] + '&name=' + r.name + '&link=' + r.link );
					});
				}, { scope: 'user_about_me,user_photos,friends_photos' });
			});

		});</script>
		<?php endif; ?>

		<?php
	}

	public function facebook_process_request(){

		$redirect_url = admin_url( 'options-general.php?page='.$this->options->id );

		// GET APP INFO
		if ( $this->options->facebook_app && $this->options->facebook_secret && !$this->options->facebook_app_name ) {

			$data = ram108_remote_get( 'https://graph.facebook.com/'.$this->options->facebook_app);
			$data = isset( $data['error'] ) ? 'Wrong Facebook App ID' : $data['name'];
			$this->options->save( array( 'facebook_app_name' => $data ) );
		}

		// CHECK ALBUMS ACCESS
		if ( $this->options->facebook_token ) {

			$data = ram108_remote_get( 'https://graph.facebook.com/me?fields=albums.limit(3).fields(id,photos.limit(1).fields(id))&access_token='.$this->options->facebook_token );
			$this->facebook_access = !isset( $data['error'] );
		}

		// SAVE FACEBOOK TOKEN
		if ( $token = @$_GET['token'] ) {

			// exchange token
			$data = ram108_remote_get( 'https://graph.facebook.com/oauth/access_token?&client_id='.$this->options->facebook_app.'&client_secret='.$this->options->facebook_secret.'&grant_type=fb_exchange_token'.'&fb_exchange_token='.$token);
			parse_str( $data, $data ); 

			// save
			$this->options->save( array( 'facebook_token' => $data['access_token'], 'facebook_expire' => time() + $data['expires'], 'facebook_user' => $_GET['name'], 'facebook_user_url' => $_GET['link'] ) );

			?><script type="text/javascript">window.location.replace( '<?php echo $redirect_url; ?>');</script><?php
			exit;
		}

		// DELETE FACEBOOK TOKEN
		if ( isset( $_GET['delete_user'] ) ) {

			$this->options->save( array( 'facebook_token' => '', 'facebook_expire' => '' ) );

			?><script type="text/javascript">window.location.replace( '<?php echo $redirect_url; ?>');</script><?php
			exit;
		}

		// DELETE FACEBOOK APP
		if ( isset( $_GET['delete_app'] ) ) {

			$this->options->save( array( 'facebook_app' => '', 'facebook_secret' => '', 'facebook_app_name' => '', 'facebook_token' => '' ) );

			?><script type="text/javascript">window.location.replace( '<?php echo $redirect_url; ?>');</script><?php
			exit;
		}
	}

	// OTHER

	public function _check_val( $value, $enable, $disable ) {

		echo '<img src="'.plugins_url( (int)(bool)$value.'.png', __FILE__ ).'" style="vertical-align: middle;" alt />&nbsp;&nbsp;'.( $value ? $enable : $disable );
	}

	public function _admin_init(){

		register_setting('ram108-fbalbum', 'ram108-fbalbum' );
	}

	public function _admin_menu(){

		add_options_page('Facebook Photo Album Settings', '[ram108] Facebook Photo Album', 'manage_options', $this->options->id, array( $this, 'admin_page' ) );
	}

	public function _admin_link( $text ){

		return array_merge( array(
			'<a href="'.admin_url( 'options-general.php?page='.$this->options->id ).'">'.__( 'Settings', $this->options->id ).'</a>'), 
		$text );
	}
}