<?php

//////////////////////////////////////////////////////////////////
// Register sidebar and footer widgets
//////////////////////////////////////////////////////////////////


if( !function_exists('rehub_register_sidebars') ) {
function rehub_register_sidebars() {

	register_sidebar(array(
		'id' => 'sidebar-1',
		'name' => __('Sidebar Area', 'rehub_framework'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));
	register_sidebar(array(
		'id' => 'sidebar-2',
		'name' => __('Footer 1', 'rehub_framework'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));
	register_sidebar(array(
		'id' => 'sidebar-3',
		'name' => __('Footer 2', 'rehub_framework'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));
	register_sidebar(array(
		'id' => 'sidebar-4',
		'name' => __('Footer 3', 'rehub_framework'),
		'before_widget' => '<div id="%1$s" class="widget last %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));
	register_sidebar(array(
		'id' => 'sidebar-8',
		'name' => __('Footer 4', 'rehub_framework'),
		'before_widget' => '<div id="%1$s" class="widget last %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));
	register_sidebar(array(
		'id' => 'sidebar-5',
		'name' => __('Woocommerce sidebar', 'rehub_framework'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));	
	register_sidebar(array(
		'id' => 'sidebar-6',
		'name' => __('MDTF sidebar', 'rehub_framework'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));
	register_sidebar(array(
		'id' => 'sidebar-7',
		'name' => __('Custom widget 1', 'rehub_framework'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="title">',
		'after_title' => '</div>',
	));
	if(rehub_option('enable_brand_taxonomy') == 1 || REHUB_NAME_ACTIVE_THEME == 'RECASH'){
		register_sidebar(array(
			'id' => 'dealstore-sidebar',
			'name' => __('Deal store archive sidebar', 'rehub_framework'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="title">',
			'after_title' => '</div>',
		));	
	}
	if (class_exists('Woocommerce')) {
		register_sidebar(array(
			'id' => 'woostore-sidebar',
			'name' => __('Woo brand archive sidebar', 'rehub_framework'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="title">',
			'after_title' => '</div>',
		));	
	}				
}
}
add_action( 'widgets_init', 'rehub_register_sidebars' );
 
//////////////////////////////////////////////////////////////////
// Include widgets
//////////////////////////////////////////////////////////////////


include (TEMPLATEPATH . '/inc/widgets/tabs_widget.php');
include (TEMPLATEPATH . '/inc/widgets/tabsajax_widget.php');
include (TEMPLATEPATH . '/inc/widgets/posts_list.php');
include (TEMPLATEPATH . '/inc/widgets/featured_sidebar.php');
include (TEMPLATEPATH . '/inc/widgets/latest_video.php');
include (TEMPLATEPATH . '/inc/widgets/feedburner_widget.php');
include (TEMPLATEPATH . '/inc/widgets/login_widget.php');
include (TEMPLATEPATH . '/inc/widgets/facebook_widget.php');
include (TEMPLATEPATH . '/inc/widgets/social_link_widget.php');
include (TEMPLATEPATH . '/inc/widgets/sticky_scroll.php');
include (TEMPLATEPATH . '/inc/widgets/related_reviews.php');
include (TEMPLATEPATH . '/inc/widgets/top_offers.php');
include (TEMPLATEPATH . '/inc/widgets/outer_ads.php');
include (TEMPLATEPATH . '/inc/widgets/better_menu.php');
include (TEMPLATEPATH . '/inc/widgets/imagetrend_sidebar.php');
include (TEMPLATEPATH . '/inc/widgets/condition_widget.php');


//////////////////////////////////////////////////////////////////
// Sidebar widget functions
//////////////////////////////////////////////////////////////////

if( !function_exists('rehub_most_popular_widget_block') ) {
function rehub_most_popular_widget_block($basedby = 'comments', $sortby = '') { ?>

	<?php 
	if($sortby == 'this_week') {
	if( !function_exists('filter_where_week') ) {
		function filter_where_week($where = '') {
			//posts in the last 7 days
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
			return $where;
		}
	}
	add_filter('posts_where', 'filter_where_week');
	} elseif($sortby == 'this_month') {
	if( !function_exists('filter_where_month') ) {
		function filter_where_month($where = '') {
			//posts in the last 30 days
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
			return $where;
		}
	}
	add_filter('posts_where', 'filter_where_month');
	} elseif($sortby == 'three_month') {
	if( !function_exists('filter_where_t_month') ) {
		function filter_where_t_month($where = '') {
			//posts in the last 30 days
			$where .= " AND post_date > '" . date('Y-m-d', strtotime('-90 days')) . "'";
			return $where;
		}
	}
	add_filter('posts_where', 'filter_where_t_month');
	}
	else {}	
	global $post;
	if ($basedby == 'views') {$popular_posts = new WP_Query('showposts=5&meta_key=rehub_views&orderby=meta_value_num&order=DESC&ignore_sticky_posts=1');}
	else {$popular_posts = new WP_Query('showposts=5&orderby=comment_count&order=DESC&ignore_sticky_posts=1');}	
	if($popular_posts->have_posts()): ?>
	
	
		<?php  while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
		
			<div class="clearfix">
	            <figure><a href="<?php the_permalink();?>"><?php WPSM_image_resizer::show_static_resized_image(array('thumb'=> true, 'crop'=> false, 'width'=> 100, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_123_90.png'));?></a></figure>
	            <div class="detail">
		            <h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
	            	<div class="post-meta">
	              		<?php $category = get_the_category($post->ID); $first_cat = $category[0]->term_id;?>
	                	<?php if ($basedby == 'views') {meta_small( false, $first_cat, false, true );} else {meta_small( false, $first_cat, true, false );}  ?>
	                </div>
	                <?php rehub_format_score('small') ?>
	            </div>
            </div>
		
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php endif; 
		remove_filter('posts_where', 'filter_where_month'); 
		remove_filter('posts_where', 'filter_where_t_month'); 
		remove_filter('posts_where', 'filter_where_week');?>


<?php
}
}

if( !function_exists('rehub_latest_comment_widget_block') ) {
function rehub_latest_comment_widget_block() { ?>
<div class="last_comments_widget">

	<?php
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,78) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5";
	$comments = $wpdb->get_results($sql);
	foreach ($comments as $comment) { 
	?>
		<div class="lastcomm-item">
			<div class="side-item comment">	
				<div>
					<span><strong><?php echo strip_tags($comment->comment_author); ?></strong></span> 
					<?php echo strip_tags($comment->com_excerpt); ?>...
					<span class="lastcomm-cat">
						<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> - <?php echo $comment->post_title; ?>"><?php echo $comment->post_title; ?></a>
					</span>		
				</div>
			</div>
		</div>

	<?php } ?>

</div>
<?php
}
}

if( !function_exists('rehub_category_widget_block') ) {
function rehub_category_widget_block() { ?>

<div class="category_tab">
	<ul class="cat_widget_custom">
	<?php
		$variable = wp_list_categories('echo=0&show_count=1&title_li=');
		$variable = str_replace('</a> (', '</a> <span class="counts">', $variable);
  		$variable = str_replace(')', '</span>', $variable);
		echo $variable;
	?>
	</ul>
</div>

<?php
}
}

if( !function_exists('rehub_login_form') ) {
function rehub_login_form( $login_only  = 0 ) {
	global $user_ID, $user_identity, $user_level;
	
	if ( $user_ID ) : ?>
		<?php if( empty( $login_only ) ): ?>
		<div id="user-login">
			<p class="welcome-frase"><?php _e( 'Welcome' , 'rehub_framework' ) ?> <strong><?php echo $user_identity ?></strong></p>
			<span class="author-avatar"><?php echo get_avatar( $user_ID, $size = '60'); ?></span>
			<ul>
				<li><a href="<?php echo home_url() ?>/wp-admin/"><?php _e( 'Dashboard' , 'rehub_framework' ) ?> </a></li>
				<li><a href="<?php echo home_url() ?>/wp-admin/profile.php"><?php _e( 'Your Profile' , 'rehub_framework' ) ?> </a></li>
				<li><a href="<?php echo wp_logout_url(); ?>"><?php _e( 'Logout' , 'rehub_framework' ) ?> </a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<?php endif; ?>
	<?php else: ?>
		<div id="login-form">
			<form action="<?php echo home_url() ?>/wp-login.php" method="post">
				<p id="log-username"><input type="text" class="def_inp" name="log" id="log" value="<?php _e( 'Username' , 'rehub_framework' ) ?>" onfocus="if (this.value == '<?php _e( 'Username' , 'rehub_framework' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Username' , 'rehub_framework' ) ?>';}"  size="33" /></p>
				<p id="log-pass"><input type="password" class="def_inp" name="pwd" id="pwd" value="<?php _e( 'Password' , 'rehub_framework' ) ?>" onfocus="if (this.value == '<?php _e( 'Password' , 'rehub_framework' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Password' , 'rehub_framework' ) ?>';}" size="33" /></p>
				<input type="submit" name="submit" value="<?php _e( 'Log in' , 'rehub_framework' ) ?>" class="def_btn sys_btn" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php _e( 'Remember Me' , 'rehub_framework' ) ?></label>
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
			</form>
			<ul class="login-links">
				<?php if ( get_option('users_can_register') ) : ?><?php echo wp_register() ?><?php endif; ?>
				<li><a href="<?php echo home_url() ?>/wp-login.php?action=lostpassword"><?php _e( 'Lost your password?' , 'rehub_framework' ) ?></a></li>
			</ul>
		</div>
	<?php endif;
}
}

if( !function_exists('rehub_get_social_links') ) {
function rehub_get_social_links($icon_size='big'){
?>
	<div class="social_icon <?php echo $icon_size; ?>_i">
		

		<?php if ( rehub_option('rehub_facebook') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_facebook'); ?>" class="fb" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a>
		<?php endif;?>	

		<?php if ( rehub_option('rehub_twitter') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_twitter'); ?>" class="tw" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a>
		<?php endif;?>

		<?php if ( rehub_option('rehub_google') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_google'); ?>" class="gp" rel="nofollow" target="_blank"><i class="fa fa-google-plus"></i></a>
		<?php endif;?>

		<?php if ( rehub_option('rehub_instagram') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_instagram'); ?>" class="ins" rel="nofollow" target="_blank"><i class="fa fa-instagram"></i></a>
		<?php endif;?>

		<?php if ( rehub_option('rehub_wa') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_wa'); ?>" class="wa" rel="nofollow" target="_blank"><i class="fa fa-whatsapp"></i></a>
		<?php endif;?>	

		<?php if ( rehub_option('rehub_youtube') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_youtube'); ?>" class="yt" rel="nofollow" target="_blank"><i class="fa fa-youtube"></i></a>
		<?php endif;?>

		<?php if ( rehub_option('rehub_vimeo') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_vimeo'); ?>" class="vim" rel="nofollow" target="_blank"><i class="fa fa-vimeo-square"></i></a>
		<?php endif;?>			
		
		<?php if ( rehub_option('rehub_pinterest') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_pinterest'); ?>" class="pn" rel="nofollow" target="_blank"><i class="fa fa-pinterest"></i></a>
		<?php endif;?>

		<?php if ( rehub_option('rehub_linkedin') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_linkedin'); ?>" class="in" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a>
		<?php endif;?>

		<?php if ( rehub_option('rehub_soundcloud') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_soundcloud'); ?>" class="sc" rel="nofollow" target="_blank"><i class="fa fa-cloud"></i></a>
		<?php endif;?>

		<?php if ( rehub_option('rehub_dribbble') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_dribbble'); ?>" class="db" rel="nofollow" target="_blank"><i class="fa fa-dribbble"></i></a>
		<?php endif;?>

		<?php if ( rehub_option('rehub_vk') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_vk'); ?>" class="vk" rel="nofollow" target="_blank"><i class="fa fa-vk"></i></a>
		<?php endif;?>	

		<?php if ( rehub_option('rehub_rss') != '' ) :?>
			<a href="<?php echo rehub_option('rehub_rss'); ?>" class="rss" rel="nofollow" target="_blank"><i class="fa fa-rss"></i></a>
		<?php endif;?>																		

	</div>

<?php
}
}


if( !function_exists('rehub_top_offers_widget_block_post') ) {
function rehub_top_offers_widget_block_post($tags = '', $number = '5', $order = '', $random = '') { ?>

	<?php $args = array (
			'showposts' => $number,
			'tag' => $tags,
			'ignore_sticky_posts' => '1'
		);
		if (!empty ($random)) {
			$args ['orderby'] = 'rand';
		}	
		if (!empty ($order)) {
			$args ['meta_key'] = $order;
			$args ['orderby'] = 'meta_value_num';
			$args ['order'] = 'DESC';
		}
	$offers = new WP_Query($args);
	if($offers->have_posts()): ?>
	
	<div class="rh_deal_block">
		<?php  while ($offers->have_posts()) : $offers->the_post(); global $post; ?>	
			<?php $offer_coupon = get_post_meta( $post->ID, 'rehub_offer_product_coupon', true ) ?>
			<?php $offer_price_old = get_post_meta( $post->ID, 'rehub_offer_product_price_old', true );?>
			<?php $offer_price = get_post_meta( $post->ID, 'rehub_offer_product_price', true );?>
			<?php $offer_post_url = get_post_meta( $post->ID, 'rehub_offer_product_url', true );
				$offer_url = apply_filters('rh_post_offer_url_filter', $offer_post_url );
				$offer_btn_text = get_post_meta( $post->ID, 'rehub_offer_btn_text', true );
			?>
			<div class="deal_block_row">
				<div class="deal-pic-wrapper">
					<a href="<?php the_permalink();?>">
						<?php WPSM_image_resizer::show_static_resized_image(array('thumb'=> true, 'crop'=> false, 'width'=> 70, 'height'=> 70, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_70_70.png'));?>
	            	</a>				
				</div>
	            <div class="rh-deal-details">
					<div class="rh-deal-name"><h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5></div>	            					
					<?php if(!empty($offer_coupon)) : ?>
						<div class="redemptionText"><?php _e('Use Coupon Code:', 'rehub_framework');?><span class="code"><?php echo $offer_coupon ?></span></div>	
				  	<?php endif;?>
					<div class="rh-deal-pricetable">
						<div class="rh-deal-left">
							<?php if($offer_price):?>
								<div class="rh-deal-price">
									<span>
										<ins><?php echo esc_html($offer_price) ?></ins>
										<?php if($offer_price_old !='') :?>
											<del><?php echo esc_html($offer_price_old) ; ?></del>
										<?php endif ;?>
									</span>
								</div>
							<?php endif;?>												
							<div class="rh-deal-tag">
								<?php WPSM_Postfilters::re_show_brand_tax('list'); //show brand logo?>					
							</div>
						</div>
						<div class="rh-deal-right">						
							<?php if($offer_post_url):?>
								<div class="rh-deal-btn">
				                    <a href="<?php echo esc_url ($offer_url) ?>" class="re_track_btn rh-deal-compact-btn btn_offer_block" target="_blank" rel="nofollow">
				                        <?php if($offer_btn_text !='') :?>
				                            <?php echo $offer_btn_text ; ?>
				                        <?php elseif(rehub_option('rehub_btn_text') !='') :?>
				                            <?php echo rehub_option('rehub_btn_text') ; ?>
				                        <?php else :?>
				                            <?php _e('Buy this item', 'rehub_framework') ?>
				                        <?php endif ;?>
				                    </a>		            					
								</div>
							<?php endif;?>						
						</div>					
					</div>
	            </div>
            </div>
		
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php endif; ?>
	</div>

<?php
}
}

if( !function_exists('rehub_top_offers_widget_block_thirsty') ) {
function rehub_top_offers_widget_block_thirsty($tags = '', $number = '5', $order = '', $random = '') { ?>
	
	<?php $args = array (
			'showposts' => $number,
			'ignore_sticky_posts' => '1',
			'post_type' => 'thirstylink',
		);
		if (!empty ($random)) {
			$args ['orderby'] = 'rand';
		}	
		if (!empty ($order)) {
			$args ['meta_key'] = $order;
			$args ['orderby'] = 'meta_value_num';
			$args ['order'] = 'DESC';
		}
		else {
			$args ['meta_key'] = 'rehub_aff_sticky';
			$args ['meta_value'] = '1';
		}
        if (!empty ($tags)) {
            $args['tax_query'] = array(array('taxonomy' => 'thirstylink-category', 'terms' => array($tags), 'field' => 'slug'));            
        }		
	global $post;
	$wp_query = new WP_Query($args);
	if($wp_query->have_posts()): ?>
	<div class="rh_deal_block">
		<?php  while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
		
			<?php 	$attachments = get_posts( array(
	            'post_type' => 'attachment',
				'post_mime_type' => 'image',
	            'posts_per_page' => -1,
	            'post_parent' => $post->ID,
        	) );
			if (!empty($attachments)) {$aff_thumb_list = wp_get_attachment_url( $attachments[0]->ID );} else {$aff_thumb_list ='';}
			$term_list = wp_get_post_terms($post->ID, 'thirstylink-category', array("fields" => "names")); 
			$term_ids =  wp_get_post_terms($post->ID, 'thirstylink-category', array("fields" => "ids")); if (!empty($term_ids) && !is_wp_error($term_ids)) {$term_brand = $term_ids[0]; $term_brand_image = get_option("taxonomy_term_$term_ids[0]");} else {$term_brand_image ='';}
			?>
			<div class="deal_block_row">
				<div class="deal-pic-wrapper">
					<a href="<?php the_permalink();?>">
						<?php if (!empty($aff_thumb_list) ) :?>	
	            			<img src="<?php $params = array( 'width' => 100, 'height' => 100 ); echo bfi_thumb( $aff_thumb_list, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
	            		<?php elseif (!empty($term_brand_image['brand_image'])) :?>
	            			<img src="<?php $params = array( 'width' => 100, 'height' => 100 ); echo bfi_thumb( $term_brand_image['brand_image'], $params ); ?>" alt="<?php the_title_attribute(); ?>" />
	            		<?php else :?>
	            			<img src="<?php echo get_template_directory_uri(); ?>/images/default/noimage_100_70.png" alt="<?php the_title_attribute(); ?>" />
	            		<?php endif?>
	            	</a>				
				</div>
				<div class="rh-deal-details">
					<div class="rh-deal-text">
						<div class="rh-deal-name"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
						<p><?php echo get_post_meta( $post->ID, 'rehub_aff_desc', true );?></p>
					</div>
					<div class="rh-deal-pricetable">
						<div class="rh-deal-left">
							<div class="rh-deal-price">
								<?php $product_price = get_post_meta( $post->ID, 'rehub_aff_price', true );?>
								<?php echo $product_price ;?>
							</div>					
							<div class="wooaff_tag">
					            <?php if (!empty($term_list[0])) :?> 
					            	<?php echo $term_list[0]; ?>
					            <?php endif; ?> 							
							</div>
						</div>	
						<?php $offer_btn_text = get_post_meta( $post->ID, 'rehub_aff_btn_text', true ) ?>
						<div class="rh-deal-right">				
							<div class="woobuy_butt">
								<a class="re_track_btn rh-deal-compact-btn" href="<?php the_permalink();?>" target="_blank" rel="nofollow"><?php if($offer_btn_text !='') :?><?php echo $offer_btn_text ; ?><?php elseif(rehub_option('rehub_btn_text') !='') :?><?php echo rehub_option('rehub_btn_text') ; ?><?php else :?><?php _e('See it', 'rehub_framework') ?><?php endif ;?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php endif; ?>
	</div>

<?php
}
}

if( !function_exists('rehub_top_offers_widget_block_woo') ) {
function rehub_top_offers_widget_block_woo($tags = '', $number = '5', $order = '', $random = '') { ?>

	<?php $args = array (
			'showposts' => $number,
			'product_tag' => $tags,
			'ignore_sticky_posts' => '1',
			'post_type' => 'product'
		);
		if (!empty ($random)) {
			$args ['orderby'] = 'rand';
		}	
		if (!empty ($order)) {
			$args ['meta_key'] = $order;
			$args ['orderby'] = 'meta_value_num';
			$args ['order'] = 'DESC';
		}	
	    $args['meta_query'] = array(
	    	array(
	       		'key' => 're_post_expired',
	       		'value' => '1',
	       		'compare' => '!=',
	    	),	    	
		);


	$wp_query = new WP_Query($args);
	if($wp_query->have_posts()): ?>
	
	<div class="rh_deal_block">
		<?php  while ($wp_query->have_posts()) : $wp_query->the_post(); global $post; global $product; ?>	
			<?php $offer_coupon = get_post_meta( $post->ID, 'rehub_woo_coupon_code', true ) ?>
			<?php $offer_post_url = esc_url( $product->add_to_cart_url() );
				$offer_url = apply_filters('rh_woo_offer_url_filter', $offer_post_url );
			?>
			<div class="deal_block_row">
				<div class="deal-pic-wrapper">
					<a href="<?php the_permalink();?>">
						<?php WPSM_image_resizer::show_static_resized_image(array('thumb'=> true, 'crop'=> false, 'width'=> 70, 'height'=> 70, 'no_thumb_url' => get_template_directory_uri() . '/images/default/noimage_70_70.png'));?>
	            	</a>				
				</div>
	            <div class="rh-deal-details">
					<div class="rh-deal-name"><h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5></div>	            					
					<?php if(!empty($offer_coupon)) : ?>
						<div class="redemptionText">
							<span class="redemptionTextLabel"><?php _e('Use Coupon Code:', 'rehub_framework');?></span>
							<span class="code"><?php echo $offer_coupon ?></span></div>	
				  	<?php endif;?>
					<div class="rh-deal-pricetable">
						<div class="rh-deal-left">
								<div class="rh-deal-price">
									<?php if ( $price_html = $product->get_price_html() ) : ?>
										<span class="price"><?php echo $price_html; ?></span>
									<?php endif; ?>
								</div>												
							<div class="rh-deal-tag">
								<?php WPSM_Woohelper::re_show_brand_tax('list'); //show brand taxonomy?>					
							</div>
						</div>
						<div class="rh-deal-right">						
							<div class="rh-deal-btn">
					            <?php if ( $product->is_in_stock() ) : ?>
					             <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
					                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="re_track_btn rh-deal-compact-btn btn_offer_block %s %s product_type_%s"%s>%s</a>',
					                    esc_url( $product->add_to_cart_url() ),
					                    esc_attr( $product->id ),
					                    esc_attr( $product->get_sku() ),
									    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
									    $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
					                    esc_attr( $product->product_type ),
					                    $product->product_type =='external' ? ' target="_blank"' : '',
					                    esc_html( $product->add_to_cart_text() )
					                    ),
					            $product );?>
					            <?php endif; ?>			            					
							</div>						
						</div>					
					</div>
	            </div>
            </div>
		
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php endif; ?>
	</div>


<?php
}
}


?>