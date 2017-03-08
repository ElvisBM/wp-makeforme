<?php

/*
 * Add Form de Busca Maker Me
 */
function add_busca_makerme($atts) {

	$layout .= '<div class="busca_maker">';
	$layout .= '<form id="searchform" name="busca_makerme" action="" method="get">';
	$layout .= '<div class="cep">';
	$layout .= '<label for="cep">Cep</label>';
	$layout .= '<input type="text" id="cep" name="cep" value="" />';
	$layout .= '</div>';
	$layout .= '<div class="product_maker">';
	$layout .= '<input type="radio" name="product_maker" value="gostosura">Gostosura<br>';
	$layout .= '<input type="radio" name="product_maker" value="maker"> Maker<br>';
	$layout .= '</div>';
	$layout .= '<div class="search_makerme">';
	$layout .= '<input type="text" id="bmm_makerme" name="s" placeholder="Ex: Bolos, Coxinhas, Doces">';
	$layout .= '</div>';
	$layout .= '<input type="submit" value="buscar">';
	$layout .= '</form>';
	$layout .= '</div>';

	echo $layout;
}
add_shortcode('busca_makerme', 'add_busca_makerme');

/*
 * Redirect Page Search
 */
function product_maker_search_redirect()
{
	$procut_maker = $_GET['product_maker'];

	//valid url
	if( !empty( $_GET['s'] ) && !empty( $_GET['cep'] ) ){
		$url = "?cep=" . $_GET['cep'] . "&busca=" . $_GET['s'];
	}
	else if( !empty( $_GET['s'] ) ){
		$url = "?busca=" . $_GET['s'];
	}
	else if( !empty( $_GET['cep'] ) ){
		$url = "?cep=" . $_GET['cep'];
	};

	//Redirect
    if( $procut_maker == "maker" )
    {
        wp_redirect( home_url( '/makers/' . $url ) );
        exit();
    }

    if( $procut_maker == "gostosura" ){
    	wp_redirect( home_url( '/gostosuras/' . $url  ) );
        exit();
    }
}
add_action( 'template_redirect', 'product_maker_search_redirect' );

/*
 *  Search Cep
 */
function get_adress_viacep( $cep ){

	$url_viacep = "viacep.com.br/ws/" . $cep .  "/json/";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url_viacep );

	$result = curl_exec($ch);

	curl_close($ch);

	$endereco = json_decode($result);

	return $endereco;
}


/*
 *  List Vendors Filter
 */
function list_vendor_filter( $atts ) {

	$html 			= ''; 
	$orderby		= 'registered';
	$order			= 'ASC';
	$per_page      	= 12;
	$columns       	= '4';
	$show_products	= 'yes'; 

	//User Location
	$me_endereco =  get_adress_viacep( $_GET['cep'] );
	$me_estado   =  $me_endereco->uf;
	$me_cidade   =  $me_endereco->localidade;
	$me_bairro   =  $me_endereco->bairro;


  	$paged      = ( get_query_var('paged') ) ? get_query_var('paged') : 1;   
  	$offset     = ( $paged - 1 ) * $per_page;

  	// Hook into the user query to modify the query to return users that have at least one product 
  	if ($show_products == 'yes') add_action( 'pre_user_query', 'vendors_with_products' );

  	// Get all vendors 
  	$vendor_total_args = array ( 
  		'role' 				=> 'vendor', 
  		'meta_key' 			=> 'pv_shop_slug', 
		'meta_value'   		=> '',
		'meta_compare' 		=> '>',
		'orderby' 			=> $orderby,
		'order'				=> $order,
  	);

  	if ($show_products == 'yes') $vendor_total_args['query_id'] = 'vendors_with_products'; 

  	$vendor_query = New WP_User_Query( $vendor_total_args ); 
  	$all_vendors  = $vendor_query->get_results(); 

  	// Get the paged vendors 
  	$vendor_paged_args = array ( 
  		'role' 				=> 'vendor', 
  		'meta_key' 			=> 'pv_shop_slug', 
		'meta_value'   		=> '',
		'meta_compare' 		=> '>',
		'orderby' 			=> $orderby,
		'order'				=> $order,
  		'offset' 			=> $offset, 
  		'number' 			=> $per_page, 
  	);

  	if ($show_products == 'yes' ) $vendor_paged_args['query_id'] = 'vendors_with_products'; 

  	$vendor_paged_query = New WP_User_Query( $vendor_paged_args ); 
  	$paged_vendors = $vendor_paged_query->get_results(); 

  	$retired_id_makers = array();
  	$indices_remove_makers = array();
  	
  	// Verify vendor for endereco user
    foreach ($paged_vendors as $vendor) { 
    	
    	$maker_enderecos =  get_user_meta( $vendor->ID, '_wcv_shipping_rates', true );

    	$verify_district 	  = array_search( $me_bairro, array_column( $maker_enderecos, 'district' ) );
    	$verify_district_null = array_search( "", array_column( $maker_enderecos, 'district' ) );
    	$verify_city  		  = array_search( $me_cidade, array_column( $maker_enderecos, 'city' ) );

    	//Verifica se tem algum Bairro igual e se Existe algum campo bairro vazio
    	if ( $verify_district === false && $verify_district_null === false  ){
			$retired_id_makers[] = $vendor->ID;
		}//Se existir Bairro Vazio Verifica se a Cidade é Igual
		else if( $verify_city === false ){
			$retired_id_makers[] = $vendor->ID;
		}	
		/*
		 * E se eu entregar em alguns Bairros em uma Cidade e em outra cidade eu entregar em todos os Bairros?
		 */
		// 	$maker_estado = $entrega->state;
    } //endforeach $paged_vendors

  	//Verify indice remove vendors
    foreach ( $paged_vendors as $indice=>$vendor ) {
    	foreach ( $retired_id_makers as $id_maker ) {
    		if( $vendor->ID == $id_maker ){
	    		$indices_remove_makers[] = $indice;
	    	};
    	};
    };

    //Remove Vendors
    foreach ($indices_remove_makers as $indice ) {
    	unset( $paged_vendors[$indice] );
    }

  	// Pagination calcs 
	$total_vendors = count( $all_vendors );  
	$total_vendors_paged = count($paged_vendors);  
	$total_pages = ceil( $total_vendors / $per_page );
    
   	ob_start();

    // Loop through all vendors and output a simple link to their vendor pages
    foreach ($paged_vendors as $vendor) {
       wc_get_template( 'vendor-list.php', array(
      												'shop_link'			=> WCV_Vendors::get_vendor_shop_page($vendor->ID), 
													'shop_name'			=> $vendor->pv_shop_name, 
													'vendor_id' 		=> $vendor->ID, 
													'shop_description'	=> $vendor->pv_shop_description, 
											), 'wc-vendors/front/', wcv_plugin_dir . 'templates/front/' );
    } // End foreach 
   	
   	$html .= '<ul class="wcv_vendorslist">' . ob_get_clean() . '</ul>';

    if ($total_vendors > $total_vendors_paged) {  
		$html .= '<div class="wcv_pagination">';  
		  $current_page = max( 1, get_query_var('paged') );  
		  $html .= paginate_links( 	array(  
		        'base' => get_pagenum_link( ) . '%_%',  
		        'format' => 'page/%#%/',  
		        'current' => $current_page,  
		        'total' => $total_pages,  
		        'prev_next'    => false,  
		        'type'         => 'list',  
		    ));  
		$html .= '</div>'; 
	}

    return $html; 
}


/**
*	vendors_with_products - Get vendors with products pubilc or private 
*	@param array $query 	
*/
function vendors_with_products( $query ) {

	global $wpdb; 

	// $post_count = $products ? ' AND post_count  > 0 ' : ''; 

    if ( isset( $query->query_vars['query_id'] ) && 'vendors_with_products' == $query->query_vars['query_id'] ) {  
        $query->query_from = $query->query_from . ' LEFT OUTER JOIN (
                SELECT post_author, COUNT(*) as post_count
                FROM '.$wpdb->prefix.'posts
                WHERE post_type = "product" AND (post_status = "publish" OR post_status = "private")
                GROUP BY post_author
            ) p ON ('.$wpdb->prefix.'users.ID = p.post_author)';
        $query->query_where = $query->query_where . ' AND post_count  > 0 ' ;  
    } 
}



