<?php
	$vendormap = $verified_vendor = $verified_vendor_label = $wcfreephone = $wcfreeadress = $vacation_mode = $vacation_msg =''; 	
	$shop_name 	       =  get_user_meta( $vendor_id, 'pv_shop_name', true ); 
	$shop_url = WCV_Vendors::get_vendor_shop_page( $vendor_id );
	$has_html          = get_user_meta( $vendor_id, 'pv_shop_html_enabled', true );
	$global_html       = WC_Vendors::$pv_options->get_option( 'shop_html_enabled' );
	$description       = do_shortcode( get_user_meta( $vendor_id, 'pv_shop_description', true ) );
	$shop_description  = ( $global_html || $has_html ) ? wpautop( wptexturize( wp_kses_post( $description ) ) ) : sanitize_text_field( $description );
	$shop_description_short = esc_html($description);
	$seller_info       = ( $global_html || $has_html ) ? wpautop( get_user_meta( $vendor_id, 'pv_seller_info', true ) ) : sanitize_text_field( get_user_meta( $vendor_id, 'pv_seller_info', true ) );
	$vendor	           = get_userdata( $vendor_id );
	$vendor_email      = $vendor->user_email;
	$vendor_login      = $vendor->user_login;
	$vendor_name      = $vendor->display_name;
	$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
	$mycredrank = ( function_exists( 'mycred_get_users_rank' ) ) ? mycred_get_users_rank($vendor_id) : '';
	$mycredpoint = ( function_exists( 'mycred_get_users_fcred' ) ) ? mycred_get_users_fcred($vendor_id ) : '';	
	$count_likes = ( get_user_meta( $vendor_id, 'overall_post_likes', true) ) ? get_user_meta( $vendor_id, 'overall_post_likes', true) : '0';
	if ( class_exists( 'WCVendors_Pro' ) ) {
		$vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta($vendor_id ) );
		$verified_vendor 	= ( array_key_exists( '_wcv_verified_vendor', $vendor_meta ) ) ? $vendor_meta[ '_wcv_verified_vendor' ] : false; 
		$verified_vendor_label 	= WCVendors_Pro::get_option( 'verified_vendor_label' );	
		$vacation_mode 		= get_user_meta( $vendor_id , '_wcv_vacation_mode', true ); 
		$vacation_msg 		= ( $vacation_mode ) ? get_user_meta( $vendor_id , '_wcv_vacation_mode_msg', true ) : '';			
	}	
	else{
		$wcfreephone	= get_user_meta( $vendor_id, 'rh_vendor_free_phone', true );
		$wcfreeadress	= get_user_meta( $vendor_id, 'rh_vendor_free_address', true );
	}
	if (function_exists('gmw_get_member_info_from_db')){
		$gmw_member_info = gmw_get_member_info_from_db($vendor_id);
		if ( isset( $gmw_member_info ) && $gmw_member_info != false ){
			$vendormap = true;
		}
	}
	
?>
<div class="wcvendor_store_wrap_bg">
	<style scoped>#wcvendor_image_bg{<?php echo rh_show_vendor_bg($vendor_id);?>}</style>
	<div id="wcvendor_image_bg">	
		<div id="wcvendor_profile_wrap">
			<div class="content">
	    		<div id="wcvendor_profile_logo" class="">
	    			<a href="<?php echo $shop_url;?>"><img src="<?php echo rh_show_vendor_avatar($vendor_id, 150, 150);?>" class="vendor_store_image_single" width=150 height=150 /></a>	        
	    		</div>
	    		<div id="wcvendor_profile_act_desc" class="">
	    			<div class="wcvendor_store_name">    			
	    				<h1><?php echo esc_html($shop_name);?></h1> 	    				
	    			</div>
	    			<div class="wcvendor_store_desc">
	    				<?php echo $shop_description; ?>				
					</div>
	    		</div>	        			        		
	    		<div id="wcvendor_profile_act_btns" class="">
	    			<span class="wpsm-button medium red"><?php echo getShopLikeButton($vendor_id);?></span>	    			
				    <?php if ( class_exists( 'BuddyPress' ) ) :?>
				    	<?php if ( bp_loggedin_user_id() && bp_loggedin_user_id() != $vendor_id ) :?>
							<?php 
								if ( function_exists( 'bp_follow_add_follow_button' ) ) {
							        bp_follow_add_follow_button( array(
							            'leader_id'   => $vendor_id,
							            'follower_id' => bp_loggedin_user_id(),
							            'link_class'  => 'wpsm-button medium green'
							        ) );
							    }
							?>				    		
					    <?php endif;?>
					<?php endif;?>

					<span class="product_total"><?php echo $store_report->total_products_sold; ?></span>
	    		</div>
	    		<div id="wcvendor_profile_infos">
	    			<?php if ( class_exists( 'WCVendors_Pro' ) ) :?>   
	    				<?php 
	    					$address1 			= ( array_key_exists( '_wcv_store_address1', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_address1' ] : '';
						    $address2 			= ( array_key_exists( '_wcv_store_address2', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_address2' ] : '';
						    $city	 			= ( array_key_exists( '_wcv_store_city', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_city' ]  : '';
						    $state	 			= ( array_key_exists( '_wcv_store_state', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_state' ] : '';
						    $address 			= ( $address1 != '') ?  $city .'/' . $address2 : '';

						    $twitter_username 	= get_user_meta( $vendor_id , '_wcv_twitter_username', true );
						    $instagram_username = get_user_meta( $vendor_id , '_wcv_instagram_username', true );
						    $facebook_url 		= get_user_meta( $vendor_id , '_wcv_facebook_url', true );
						    $youtube_url 		= get_user_meta( $vendor_id , '_wcv_youtube_url', true );
						    $googleplus_url 	= get_user_meta( $vendor_id , '_wcv_googleplus_url', true );
	    				?> 	
					<?php endif;?>
					<?php if(!empty( $facebook_url )) : ?>
						<span class="social facebook"><a href="<?php echo $facebook_url ?>" target="_blank" ><i class="fa fa-facebook" aria-hidden="true"></i></a></span>
					<?php endif;?>
					<?php if(!empty( $googleplus_url )) : ?>
						<span class="social googleplus"><a href="<?php echo $googleplus_url ?>" target="_blank" ><i class="fa fa-google-plus" aria-hidden="true"></i></a></span>
					<?php endif;?>
					<?php if(!empty( $instagram_username )) : ?>
						<span class="social instagram"><a href="https://www.instagram.com/<?php echo $instagram_username ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></span>
					<?php endif;?>
					<?php if(!empty( $youtube_url )) : ?>
						<span class="social youtube"><a href="<?php echo $youtube_url ?>" target="_blank" ><i class="fa fa-youtube" aria-hidden="true"></i></a></span>
					<?php endif;?>
					<?php if(!empty( $twitter_username )) : ?>
						<span class="social twitter"><a href="https://twitter.com/<?php echo $twitter_username ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></span>
					<?php endif;?>
					<?php if(!empty( $address )) : ?>
						<span class="endereco"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $address; ?></span>
					<?php endif;?>	
	    		</div>	        			
			</div>
		</div>
	</div>
</div>


<!-- CONTENT -->
<div class="content no_shadow wcvcontent"> 
	<div class="clearfix">
	    <!-- Main Side -->
	    <div class="vcwendor_profile_content woocommerce page clearfix">
	        <article class="post" id="page-<?php the_ID(); ?>">
	        	<?php if ($vacation_msg) :?>
	        		<div class="wpsm_box green_type nonefloat_box">
	        			<div>
	        				<?php echo $vacation_msg; ?>
						</div>
					</div>
	        	<?php endif;?>
	        	<div role="tabvendor" class="tab-pane active" id="vendor-items">
				<?php if ( have_posts() ) : ?>
					<?php
						/**
						 * woocommerce_before_shop_loop hook
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
					?>
					<?php woocommerce_product_loop_start(); ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php 
								$custom_col = 'yes'; 
								$custom_img_height = 284; 
								$custom_img_width = 284; 
							?>
							<?php include(locate_template('inc/parts/woocolumnpart.php')); ?>
						<?php endwhile; // end of the loop. ?>
					<?php woocommerce_product_loop_end(); ?>
					<?php
						/**
						 * woocommerce_after_shop_loop hook
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?>
				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
					<?php wc_get_template( 'loop/no-products-found.php' ); ?>
				<?php endif; ?>
				</div>		
			</article>
		</div>
		<!-- /Main Side --> 
    </div>
</div>
<!-- /CONTENT -->


<?php get_footer(); ?>