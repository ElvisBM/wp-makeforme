<?php 


//Add Busca MakerMe
include (TEMPLATEPATH . '/functions/busca_makerme.php');


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


/**
 * Add Field upload CPF
 */
function upload_cpf_cnpj_maker( ){ 
	if ( class_exists( 'WCVendors_Pro' ) ){ 
		$key = '_wcv_custom_settings_cpf_cnpj_maker'; 
		$value = get_user_meta( get_current_user_id(), $key, true ); 
		WCVendors_Pro_Form_Helper::file_uploader(  array(  
			'header_text'		=> __('Enviar CPF ou CNPJ', 'wcvendors-pro' ), 
			'add_text' 			=> __('Adicionar Imagem', 'wcvendors-pro' ), 
			'remove_text'		=> __('Remover imagem', 'wcvendors-pro' ), 
			'image_meta_key' 	=> $key, 
			'save_button'		=> __('Salvar Imagem', 'wcvendors-pro' ), 
			'window_title'		=> __('Selecionar CPF ou CNPJ', 'wcvendors-pro' ), 
			'value'				=> $value, 
			'size'				=> 'thumbnail', 
			'class'				=> ''
			)
		);
	} 
}

add_action( 'wcvendors_admin_after_shop_name', 'wcv_cpf_cnpj_maker_admin' );
function wcv_cpf_cnpj_maker_admin( $user ) {
?>
  <tr>
    <th><label for="<!-- _wcv_custom_settings_cpf_cnpj_maker -->"><?php _e( 'CPF ou CNPJ', 'wcvendors-pro' ); ?></label></th>
    <td>
    	<?php 

    		$img_id = get_user_meta( $user->ID, '_wcv_custom_settings_cpf_cnpj_maker', true ); 
    		if( !empty( $img_id ) ){
    			echo wp_get_attachment_image( $img_id, array('350', '300'), "", array( "class" => "img-responsive" ) ); 
    		} 		
    	?>
    </td>
  </tr>
<?php
}

/**
 * Add Field upload Comprovante de Residência
 */
function upload_comprovante_residencia_maker( ){ 
	if ( class_exists( 'WCVendors_Pro' ) ){ 
		$key = '_wcv_custom_settings_comprovante_residencia_maker'; 
		$value = get_user_meta( get_current_user_id(), $key, true ); 
		WCVendors_Pro_Form_Helper::file_uploader( apply_filters( 'wcv_vendor_comprovante_residencia_maker', array(  
			'header_text'		=> __('Enviar Comprovante de Residência', 'wcvendors-pro' ), 
			'add_text' 			=> __('Adicionar Imagem', 'wcvendors-pro' ), 
			'remove_text'		=> __('Remover Imagem', 'wcvendors-pro' ), 
			'image_meta_key' 	=> $key, 
			'save_button'		=> __('Salvar Comprovante de Residência', 'wcvendors-pro' ), 
			'window_title'		=> __('Selecionar Comprovante de Residência', 'wcvendors-pro' ), 
			'value'				=> $value, 
			'size'				=> 'thumbnail', 
			'class'				=> ''
			)
		) );
	} 
}

add_action( 'wcvendors_admin_after_shop_name', 'wcv_comprovante_residencia_maker_admin' );
function wcv_comprovante_residencia_maker_admin( $user ) {
?>
  <tr>
    <th><label for="<!-- _wcv_custom_settings_comprovante_residencia_maker -->"><?php _e( 'Comprovante residência', 'wcvendors-pro' ); ?></label></th>
    <td>
    	<?php 

    		$img_id = get_user_meta( $user->ID, '_wcv_custom_settings_comprovante_residencia_maker', true ); 
    		if( !empty( $img_id ) ){
    			echo wp_get_attachment_image( $img_id, array('350', '300'), "", array( "class" => "img-responsive" ) ); 
    		} 		
    	?>
	</td>
  </tr>
<?php
}





