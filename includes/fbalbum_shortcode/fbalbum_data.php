<?php 

class ram108_fbalbum_data {

	// SETTINGS
	private 
		$limit = 100,
		$random_limit = 250,
		$hidden_ratio = 3;

	// RAW DATA
	private 
		$data_url = 'https://graph.facebook.com/{ALBUM_ID}?fields=id,name,description,photos.limit({LIMIT}).fields(name,source,link,images)';

	// DATA
	private 
		$options,
		$args,
		$data;

	public function __construct( $args ){

		$this->options = &$GLOBALS['ram108_fbalbum_settings']; 

		$this->args = $args;
		$this->_clean_args();
		$this->_get_data();
	}

	private function _clean_args(){

		extract( $this->args );

		// LIMIT
		$limit = (int)$limit ? (int)$limit : $this->limit;

		// ALBUM_ID
		preg_match(	'|\?set=a\.(\d+)|i', $url, $album_id );
		$album_id = @$album_id[1];

		// IF PRIVATE ADD TOKEN
		if ( $this->is_private() && $this->options->facebook_token ) $this->data_url .= '&access_token='.$this->options->facebook_token;

		// REQUEST
		$request = $this->data_url;
		$request = str_replace( '{ALBUM_ID}', $album_id, $request );
		$request = str_replace( '{LIMIT}', $random ? $this->random_limit : ( @$hidden ? $limit * $this->hidden_ratio : $limit ), $request );

		// SAVE
		$this->args['limit'] = $limit;
		$this->args['data_id'] = $album_id;
		$this->args['data_url'] = $request;
	}

	public function is_private(){

		// OPEN:	https://www.facebook.com/media/set/?set=a.548602058550020.1073741839.495358777207682&type=3
		// PRIVATE:	https://www.facebook.com/sairam108/media_set?set=a.106430042708226.11592.100000236917569&type=3
		return ram108_str_exists( $this->args['url'], 'media_set?' );
	}

	private function _get_data(){

		if ( false === ( $this->data = get_transient( $hash = 'fbalbum_'.hash( 'md5', json_encode( array( $this->args['data_url'], $this->args['size'], $this->options->album_expire ) ) ) ) ) ) {

			$this->_get_raw_data(); 
			if ( @$this->data['error'] ) return;
			$this->_get_clean_data();

			// save only if there are photos there
			if ( $this->data['album']['count'] > 0 ) set_transient( $hash, $this->data, ( $this->options->album_expire > 1 ? $this->options->album_expire : 1 ) * 3600 );
		}

		if ( $this->args['random'] ) $this->_data_shuffle();
	}

	private function _get_raw_data() {

		extract( $this->args );

		if ( empty( $url ) ) return $this->_error('Album URL is empty');
		if ( empty( $data_id ) ) return $this->_error('Album URL is wrong');

		$data = ram108_remote_get( $this->args['data_url'] );
		if ( is_array( $data ) && isset( $data['error'] ) ) return $this->_error( $data['error'] );

		$this->data = &$data;
	}

	private function _get_clean_data(){

		$data = array();

		// ALBUM

		$data['album'] = array(

			'id'				=> $this->data['id'],
			'url'				=> $this->args['url'],
			'name'				=> $this->_clean_str( @$this->data['name'] ),
			'description'		=> $this->_clean_str( @$this->data['description'], 0 ),
			'count'				=> count( $this->data['photos']['data'] ),
		);

		// IMAGE

		$data['image'] = array();
		$album = &$data['album'];

		foreach( $this->data['photos']['data'] as $id => $image ){

			$_image = array(
				'url'				=> $image['source'],
				'name'				=> $this->_clean_str( @$image['name'] ),
				'thumb'				=> $this->_get_thumb( $id ),
			);

			if ( $_image['name'] == '' && $album['name'] != 'Timeline Photos' ) $_image['name'] = $album['name'];

			if ( !ram108_str_exists( $_image['name'], '@hide@') ) $data['image'] []= $_image;
		}

		// RESULT

		$this->data = $data;
	}

	private function _data_shuffle(){

		shuffle( $this->data['image'] );

		$this->data['image'] = array_slice( $this->data['image'], 0, @$this->args['hidden'] ? $this->args['limit'] * $this->hidden_ratio : $this->args['limit'] );
	}

	private function _get_thumb( $id ){

		$image = $this->data['photos']['data'][$id]['images']; 
		$size = $this->args['size'];
		$count = count( $image ) - 1;

		if ( $count > 0 ) $count--; // FIX: STRANGE FACEBOOK BUG WITH WRONG W/H ON LAST IMAGE

		for( $i = $count; $i > 0; $i-- ) if ( min( $image[$i]['width'], $image[$i]['height'] ) >= $size ) break;

		return $image[$i]['source'];
	}

	private function _clean_str( $str, $len = 40 ){

		$str = strip_tags( $str );

		// remove Facebook meta data "@[165831197711:274:Morristown-Hamblen Library]"
		$str = preg_replace('|@\[.+:.+:(.+)\]|sU', '$1', $str);

		// escape #hide tag
		$str = preg_replace('|#hide\s*|s', '@hide@', $str);

		// remove #tags
		$str = preg_replace('|#[^\s]+\s*|s', '', $str);

		// trim
		$str = trim( preg_replace('|\s{2,}|s', ' ', $str ) );

		// cut
		if ( $len ) $str = wp_trim_words( $str, $len, '...' );
		if ( mb_strlen( $str ) < 4 ) $str = '';

		return htmlspecialchars( $str );
	}

	private function _error( $text ){

		// Error validating access token: Session has expired at unix time 1385344800. The current unix time is 1385390110.

		if ( is_array( $text ) && isset( $text['message'] ) ) $text = 'Facebook error response: '.$text['message'];
		if ( ram108_str_exists( $text, 'Unsupported get request' ) ) $text .= ' Access to personal profile requires Facebook authentication. Fill \'Facebook connect\' section at plugin settings page.';

		$this->data['error'] = '<br/><p class="ram108_fbalbum_error">[ram108] '.$text.' [<a href="'.$this->args['url'].'">check URL</a>] [<a href="http://wordpress.org/plugins/ram108-fbalbum/faq/">read FAQ</a>] [<a href="http://wordpress.org/support/plugin/ram108-fbalbum">Support forum</a>]</p>';
		if ( !current_user_can( 'edit_post' ) ) $this->data['error'] = '<!-- '. $this->data['error'] .' -->';
	}

	// MAGIC 

	public function __get( $name ) {

		return @$this->data[ $name ];
	}
}