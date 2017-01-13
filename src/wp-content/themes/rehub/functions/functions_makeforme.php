<?php 



//Header Top Widget
function makeforme_register_sidebars() {

	register_sidebar(array(
		'id' => 'header-top',
		'name' => __('Sidebar Top Header', ''),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));

	register_sidebar(array(
		'id' => 'filters-header',
		'name' => __('Filters  Header', ''),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));
}

add_action( 'widgets_init', 'makeforme_register_sidebars' );



//
function request_receiver_pagarme( $receiver_id ){

	$api_url = "https://api.pagar.me/1/recipients/".$receiver_id."/balance";

	$api_key = "ak_test_Oq6uuxxWJB4WFCbWC5cFOaM6sjYvvx";

	$data = array( 'api_key' => $api_key );

	$params = array(
		'method'  => 'GET',
		'timeout' => 60,
	);

	if ( ! empty( $data ) ) {
		$params['body'] = $data;
	}

	if ( ! empty( $headers ) ) {
		$params['headers'] = $headers;
	}

	$response = wp_safe_remote_post( $api_url, $params );
	$response = json_decode( $response['body'] );

	return $response;
}



