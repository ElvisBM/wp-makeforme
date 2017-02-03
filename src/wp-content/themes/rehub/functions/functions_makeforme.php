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



//Request Receiver Pagarme
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



/**
 * Adicionando Script 
 */
function loadScriptsTemplate(){

    if (is_page( 'minha-loja' )){
       wp_enqueue_script('cidade-estados', get_template_directory_uri().'/js/cidades-estados-1.4-utf8.js');
       wp_enqueue_script('makeforme-cidade-estados', get_template_directory_uri().'/js/makeforme_cidade_estado.js');
    }
    wp_enqueue_script('makeformejs', get_template_directory_uri().'/js/makeforme.js');
}
add_action('wp_enqueue_scripts','loadScriptsTemplate');

/**
 * Add Field for product wc_tempo_de_preparado
 */

add_action('woocommerce_product_meta_start', 'wc_producao', 2);
function wc_producao() {
    $output = get_post_meta( get_the_ID(), 'wcv_custom_product_producao', true ); // Change wcv_custom_product_ingredients to your meta key
    echo 'Tempo para a produção: ' . $output . '<br>';
}
