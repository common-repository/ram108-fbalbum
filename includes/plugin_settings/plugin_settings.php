<?php

$GLOBALS['ram108_fbalbum_settings'] = new ram108_fbalbum_settings;

class ram108_fbalbum_settings {

	public $id = 'ram108-fbalbum';
	public $data = array();

	public function __construct(){

		register_activation_hook( _RAM108_FBALBUM, array( $this, '_create_data' ) );
		register_deactivation_hook( _RAM108_FBALBUM, array( $this, '_remove_data' ) );

		$this->_get_data();
	}

	public function save( $data = array() ){

		$this->data = array_merge( (array)$this->data, $data );
		update_option( $this->id, $this->data );
	}

	// PRIVATE

	private function _get_data(){

		$this->data = get_option( $this->id );
		if ( !$this->data ) $this->_create_data();
		if ( $this->data['ver'] != _RAM108_FBALBUM_VER ) $this->_upgrade_data();
	}

	public function _create_data(){

		$this->save( array(
			'ver'					=> _RAM108_FBALBUM_VER,
			'thumb_size'			=> '160',
			'thumb_shape'			=> '0',
			'fancybox'				=> '1',
			'fblike'				=> '1',
			'album_expire'			=> '6',	// hours
		));
	}

	public function _remove_data(){

		$this->data = array();
		delete_option( $this->id );
	}

	private function _upgrade_data(){

		if ( $this->data['ver'] < '0.5') $this->save( array(
			'album_expire'			=> '6',
		));

		if ( $this->data['ver'] < '0.4') $this->save( array(
			'fblike'				=> '1',
		));

		if ( $this->data['ver'] < '0.3.1') $this->save( array(
			'fancybox'				=> '1',
		));

		$this->save( array(
			'ver'			=> _RAM108_FBALBUM_VER,
		));
	}

	// MAGIC 

	public function __get( $name ) {

		return isset( $this->data[ $name ] ) ? $this->data[ $name ] : FALSE;
	}
}