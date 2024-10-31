<?php

// DEFINITIONS

define( 'CURL_AVAILABLE', function_exists('curl_init') );

function ram108_remote_get( $url ){

	$data = wp_remote_get( $url, array(
		'user-agent'	=> 'Mozilla/5.0 (X11; Linux x86_64; rv:25.0) Gecko/20100101 Firefox/25.0',
		'timeout' 		=> 15,
		'sslverify'		=> false,
	));

	// return error, data or decode JSON
	return @is_wp_error( $data ) ? array( 'error', 'cURL error response: '.@$data->get_error_message() ) : ( ( $decode = json_decode( $data['body'], true ) ) ? $decode : $data['body'] );
}

function ram108_str_exists( $str, $findme ){

	return !( FALSE === mb_strpos( $str, $findme ) );
}