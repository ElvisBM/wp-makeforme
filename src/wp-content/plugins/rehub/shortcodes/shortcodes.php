<?php

if (rehub_option('shortcode_enable') == '1') {
	require_once ( get_template_directory() . '/shortcodes/tinyMCE/tinyMCE.php'); 
}

//////////////////////////////////////////////////////////////////
// Buttons
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_button') ) {
function wpsm_shortcode_button( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'color' => 'orange',
				'size' => 'medium',
				'icon' => '',
				'link' => '',
				'target' => '',
				'border_radius' => '',
				'class' => '',
				'rel' => ''
			), $atts);
    $icon_show = (!empty($atts['icon'])) ? '<i class="fa fa-'.$atts['icon'].'"></i>' : ''; 
    $class_show = (!empty($atts['class'])) ? ' '.$atts['class'].'' : '';
    $border_show = (!empty($atts['border_radius'])) ? ' style="border-radius:'.$atts['border_radius'].'"' : '';
	$out = '<a href="'.esc_url($atts['link']).'"';
    if ($atts['target'] !='') :
    	$out .=' target="'.$atts['target'].'"';
    endif;
    if ($atts['rel'] !='') :
    	$out .=' rel="'.$atts['rel'].'"';
    endif;    
    $out .=''.$border_show.' class="wpsm-button '.$atts['color'].' '.$atts['size'].''.$class_show.'">'.$icon_show.'' .do_shortcode($content). '</a>';
    return $out;
}
add_shortcode('wpsm_button', 'wpsm_shortcode_button');
}

//////////////////////////////////////////////////////////////////
// Column
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_column_shortcode') ) {
	function wpsm_column_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'size' => 'one-half',
			'position' =>'first'
		  ), $atts ) );
		  $out = '';
		  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		  $content = do_shortcode($content);
		  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		  $Old     = array( '<br />', '<br>' );
		  $New     = array( '','' );
		  $content = str_replace( $Old, $New, $content );		  
		  $out .= '<div class="wpsm-' . $size . ' wpsm-column-'.$position.'">' . $content . '</div>';
		  if($position == 'last') {
			$out .= '<div class="clearfix"></div>';
		      }
		  return $out;	  
	}
	add_shortcode('wpsm_column', 'wpsm_column_shortcode');
}


//////////////////////////////////////////////////////////////////
// Highlight
//////////////////////////////////////////////////////////////////

if ( !function_exists( 'wpsm_highlight_shortcode' ) ) {
	function wpsm_highlight_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'yellow',
		  ),
		  $atts ) );
		  return '<span class="wpsm-highlight wpsm-highlight-'. $color .'">' . do_shortcode( $content ) . '</span>';
	
	}
	add_shortcode('wpsm_highlight', 'wpsm_highlight_shortcode');
}

//////////////////////////////////////////////////////////////////
// Color table
//////////////////////////////////////////////////////////////////
if ( !function_exists( 'wpsm_colortable_shortcode' ) ) {
	function wpsm_colortable_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'black',
		  ),
		  $atts ) );
		  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		  $content = do_shortcode($content);
		  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		  $Old     = array( '<br />', '<br>' );
		  $New     = array( '','' );
		  $content = str_replace( $Old, $New, $content );		  
		  return '<div class="wpsm-table wpsm-table-'. $color .'">' . do_shortcode( $content ) . '</div>';
	
	}
	add_shortcode('wpsm_colortable', 'wpsm_colortable_shortcode');
}

//////////////////////////////////////////////////////////////////
// Quote
//////////////////////////////////////////////////////////////////	
if(!function_exists('wpsm_quote_shortcode')) {
	function wpsm_quote_shortcode($atts, $content) {   
		$out = '';
		$out .= '<blockquote class="wpsm-quote';
		if(!empty($atts['float']) && $atts['float']):
	      $out .= ' align'.$atts['float'].'';
	    endif;  
		$out .= '"';
		if(!empty($atts['width']) && $atts['width']):
	      $out .= 'style="width:'.$atts['width'].'"';
	    endif;
		$out .= '><p>'.$content.'</p>';
		if(!empty($atts['author']) && $atts['author']):
	      $out .= '<cite>'.$atts['author'].'</cite>';
	    endif;
		$out .='</blockquote>';
		return $out;
	} 
	// add the shortcode to system
	add_shortcode('wpsm_quote', 'wpsm_quote_shortcode');
}

//////////////////////////////////////////////////////////////////
// Dropcap
//////////////////////////////////////////////////////////////////	
if(!function_exists('wpsm_dropcap_shortcode')) {
function wpsm_dropcap_shortcode( $atts, $content = null ) { 
    return '<span class="wpsm_dropcap">'.$content.'</span>';  
}  
add_shortcode("wpsm_dropcap", "wpsm_dropcap_shortcode");  
}	

//////////////////////////////////////////////////////////////////
// Video
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_AddVideo')) {
function wpsm_shortcode_AddVideo( $atts, $content = null ) {
	$schema = $width = $height = $title = $description = '';
    @extract($atts);
    if ($schema =='yes') {
		$width  = ($width)  ? $width  :'703' ;
		$height = ($height) ? $height : '395';
    }
    else {
 		$width  = ($width)  ? $width  :'765' ;
		$height = ($height) ? $height : '430';   	
    }
	$title = ($title) ? $title : get_the_title();
	$description = ($description) ? $description : get_the_title();

		if ($schema =='yes') {
			$out = '<div class="media_video clearfix" itemscope itemtype="http://schema.org/VideoObject"><meta content="'.$title.'" itemprop="name"><meta itemprop="thumbnail" content="'.parse_video_url($content, "hqthumb").'"><div class="clearfix inner"><div class="video-container">'.parse_video_url($content, "embed", "$width", "$height").'</div><h4 itemprop="name">'.$title.'</h4><p itemprop="description">'.$description.'</p></div></div>';
		}
		else {	
		$out ='<div class="video-container">'.parse_video_url($content, "embed", "$width", "$height").'</div>';
		}
		
    return $out;
}
add_shortcode('wpsm_video', 'wpsm_shortcode_AddVideo');
}

//////////////////////////////////////////////////////////////////
// Lightbox
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_lightbox')) {
function wpsm_shortcode_lightbox( $atts, $content = null ) {
	wp_enqueue_script('prettyphoto');
	wp_enqueue_script('custom_pretty');
    @extract($atts);
	if(!isset($title)) {
		$title = '';
	}
	$out = '<a rel="prettyPhoto" href="'.$full.'" title="'.$title.'">' .do_shortcode($content). '</a>';
    return $out;
}
add_shortcode('wpsm_lightbox', 'wpsm_shortcode_lightbox');
}



//////////////////////////////////////////////////////////////////
// Boxes
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_box')) {
function wpsm_shortcode_box( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'type' => 'info',
				'float' => 'none',
				'textalign' => 'left',
				'width' => 'auto',
			), $atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );

	$out = '<div class="wpsm_box '.$atts['type'].'_type '.$atts['float'].'float_box" style="text-align:'.$atts['textalign'].'; width:'.$atts['width'].'"><i></i><div>
			' .do_shortcode($content). '
			</div></div>';
    return $out;
}
add_shortcode('wpsm_box', 'wpsm_shortcode_box');
}


//////////////////////////////////////////////////////////////////
// Promoboxes
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_promobox_shortcode') ) {
function wpsm_promobox_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'background' => '#f8f8f8',
			'border_size' => '',
			'border_color' => '',
			'highligh_color' => '',
			'highlight_position' => '',
			'title' => '',
			'description' => ''
		), $atts));	

	$out = '<div class="wpsm_promobox" style="background-color:'.$background.' !important;';
	if((isset($atts['border_size']) && $atts['border_size']) && (isset($atts['border_color']) && $atts['border_color'])):
		$out .= ' border-width:'.$border_size.';border-color:'.$border_color.'!important; border-style:solid;';
	endif;
	if((isset($atts['highligh_color']) && $atts['highligh_color']) && (isset($atts['highlight_position']) && $atts['highlight_position'])):
		$out .= ' border-'.$highlight_position.'-width:3px !important;border-'.$highlight_position.'-color:'.$highligh_color.'!important;border-'.$highlight_position.'-style:solid';
	endif;
	$out .= '">';
	if((isset($atts['button_link']) && $atts['button_link']) && (isset($atts['button_text']) && $atts['button_text'])):
		$out .= '<a href="'.$atts['button_link'].'" class="wpsm-button rehub_main_btn" target="_blank" rel="nofollow"><span>'.$atts['button_text'].'</span></a>';
	endif;
	if(isset($atts['title']) && $atts['title']):
		$out .= '<div class="title_promobox">'.$atts['title'].'</div>';
	endif;
	if(isset($atts['description']) && $atts['description']):
		$out.= '<p>'.$atts['description'].'</p>';
	endif;
	$out .= '</div>';
    return $out;
}
add_shortcode('wpsm_promobox', 'wpsm_promobox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Number box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numbox_shortcode')) {
		function wpsm_numbox_shortcode($atts, $content) {  
			// get the optional style value
			extract(shortcode_atts( array('num' => '1', 'style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );
			$styledot = ($style=='5' || $style=='6') ? '.' : '';			
			// return output
		    return "<div class=\"wpsm-numbox wpsm-style$style\"><span class=\"num\">" . $num . $styledot ."</span>" . $content . "</div>";  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_numbox', 'wpsm_numbox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Numbered heading
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numhead_shortcode')) {
		function wpsm_numhead_shortcode($atts, $content) {  
			// get the optional style value
			extract(shortcode_atts( array('num' => '1', 'style' => '1', 'heading' => '2'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return output
		    return "<div class=\"wpsm-numhead wpsm-style$style\"><span>" . $num . "</span><h$heading>" . $content . "</h$heading></div>";  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_numhead', 'wpsm_numhead_shortcode');
}

//////////////////////////////////////////////////////////////////
// Numbered circle
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numcircle_shortcode')) {
	function wpsm_numcircle_shortcode($atts, $content) {  
		// get the optional style value
		extract(shortcode_atts( array('num' => '1', 'style' => '1'), $atts));	
		// return output
	    return "<span class=\"wpsm-numcircle wpsm-style$style\">" . $num . "</span>";  
	} 
	// add the shortcode to system
	add_shortcode('wpsm_numcircle', 'wpsm_numcircle_shortcode');
}

//////////////////////////////////////////////////////////////////
// Titled box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_titlebox_shortcode')) {
		function wpsm_titlebox_shortcode($atts, $content) {   
			// get the optional style value
			extract(shortcode_atts( array('title' => 'Sample title', 'style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return the url
		    return '<div class="wpsm-titlebox wpsm_style_' . $style . '"><strong>' . $title . '</strong><div>'.$content.'</div></div>';  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_titlebox', 'wpsm_titlebox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Code box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_code_shortcode')) {
		function wpsm_code_shortcode($atts, $content) {   
			// get the optional style value
			extract(shortcode_atts( array('style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return the element
		    return '<pre class="wpsm-code wpsm_code_' . $style . '"><code>'. trim($content) .'</code></pre>'; 
			 
		} 
		// add the shortcode to system
		add_shortcode('wpsm_codebox', 'wpsm_code_shortcode');
}

//////////////////////////////////////////////////////////////////
// Accordition
//////////////////////////////////////////////////////////////////

// Main
if( !function_exists('wpsm_accordion_main_shortcode') ) {
	function wpsm_accordion_main_shortcode( $atts, $content = null  ) {	
		// Enque scripts
		wp_enqueue_script('jquery-ui-accordion');	
        
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		// Display the accordion	
		return '<div class="wpsm-accordion">' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'wpsm_accordion', 'wpsm_accordion_main_shortcode' );
}

// Section
if( !function_exists('wpsm_accordion_section_shortcode') ) {
	function wpsm_accordion_section_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
		  'title' => 'Title',
		), $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		  
	   return '<h3 class="wpsm-accordion-trigger"><a href="#">'. $title .'</a></h3><div>' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'wpsm_accordion_section', 'wpsm_accordion_section_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Testimonial
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_testimonial_shortcode') ) { 
	function wpsm_testimonial_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'by' => '',
			'image' => '',
		  ), $atts ) );
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
				  
		$out = '';
		$out .= '<div class="wpsm-testimonial"><div class="wpsm-testimonial-content">';
		$out .= $content;
		$out .= '</div><div class="wpsm-testimonial-author">';
		if (isset($image) && !empty($image)) {
			$out .= '<img src="'. $image .'" alt="'. $by .'" class="author_image">';
		}
		$out .= $by .'</div></div>';	
		return $out;
	}
	add_shortcode( 'wpsm_testimonial', 'wpsm_testimonial_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Slider (DEPRECATED)
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_slider') ) {

	function wpsm_shortcode_slider($atts, $content = null) {
		wp_enqueue_script('flexslider');
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
				
		$str = '';
		$str .= '<div class="post_slider media_slider blog_slider loading">';
		$str .= do_shortcode($content);
		$str .= '</div>';

		return $str;
	}
	add_shortcode('wpsm_slider', 'wpsm_shortcode_slider');
}

//////////////////////////////////////////////////////////////////
// Slider
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_quick_slider') ) {
	function wpsm_shortcode_quick_slider($atts, $content = null) {
		extract(shortcode_atts(array(
				"ids" => '',
		), $atts));
		wp_enqueue_script('flexslider');
		return wpsm_get_post_slide($ids);
	}
	add_shortcode('wpsm_quick_slider', 'wpsm_shortcode_quick_slider');
}

//////////////////////////////////////////////////////////////////
// Post image attachment slider
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_post_slide') ) {
function wpsm_post_slide( $atts, $content = null ) {
		wp_enqueue_script('flexslider');
	return wpsm_get_post_slide();
}
add_shortcode('wpsm_post_images_slider', 'wpsm_post_slide');
function wpsm_get_post_slide($ids='') {
		$out = '';
		if (!empty($ids)) {
			$attachments = array_map( 'trim', explode( ",", $ids ) );
		}
		else {
			$attachments = get_posts( array(
            	'post_type' => 'attachment',
				'post_mime_type' => 'image',
            	'posts_per_page' => -1,
            	'post_parent' => get_the_ID(),
            	'exclude'     => get_post_thumbnail_id()
        	));
		}

        if ( $attachments ) {

            $out = '<div class="post_slider media_slider blog_slider loading"><ul class="slides">';
            foreach ( $attachments as $attachment ) {
            	if (!empty($ids)) {
            		$thumbimg = wp_get_attachment_image($attachment, 'post-thumbnail', false);
            	}
            	else {
            		$thumbimg = wp_get_attachment_image($attachment->ID, 'post-thumbnail', false);
            	}                      
                $out .= '<li>' . $thumbimg . '</li>';
            }
            $out .='</ul></div>';
            
        }
        return $out;
    }
}


//////////////////////////////////////////////////////////////////
// Map
//////////////////////////////////////////////////////////////////
if (! function_exists( 'wpsm_shortcode_googlemaps' ) ) :
	function wpsm_shortcode_googlemaps($atts, $content = null) {	
		extract(shortcode_atts(array(
				"title" => '',
				"location" => '',
				"height" => '300px',
				"zoom" => 10,
				"align" => '',
				"lat"=>'',
				"lng"=>''
		), $atts));
		
		// load scripts
		wp_enqueue_script('wpsm_googlemap');
		wp_enqueue_script('wpsm_googlemap_api');
		$output = '';
		
		if ($location){
			$output .= '<div id="map_canvas_'.uniqid().'" class="wpsm_googlemap wpsm_gmap_loc" style="height:'.$height.';width:100%">';
				$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
				$output .= '<input class="location" type="hidden" value="'.$location.'" />';
				$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
				$output .= '<div class="map_canvas"></div>';
			$output .= '</div>';			
		}		
		elseif ($lat && $lng){
			$output .= '<div id="map_canvas_'.uniqid().'" class="wpsm_googlemap wpsm_gmap_pos" style="height:'.$height.';width:100%">';
				//$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
				$output .= '<input class="lat" type="hidden" value="'.$lat.'" />';
				$output .= '<input class="lng" type="hidden" value="'.$lng.'" />';				
				$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
				$output .= '<div class="map_canvas"></div>';
			$output .= '</div>';			
		}
		
		return $output;
	   
	}
	add_shortcode("wpsm_googlemap", "wpsm_shortcode_googlemaps");
endif;


//////////////////////////////////////////////////////////////////
// Dividers
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_divider_shortcode') ) {
	function wpsm_divider_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'style' => 'solid',
			'top' => '20px',
			'bottom' => '20px',
		  ),
		  $atts ) );
		$style_attr = '';
		if ( $top && $bottom ) {  
			$style_attr = 'style="margin-top: '. $top .';margin-bottom: '. $bottom .';"';
		} elseif( $bottom ) {
			$style_attr = 'style="margin-bottom: '. $bottom .';"';
		} elseif ( $top ) {
			$style_attr = 'style="margin-top: '. $top .';"';
		} else {
			$style_attr = NULL;
		}
	 return '<hr class="wpsm-divider '. $style .'_divider" '.$style_attr.' />';
	}
	add_shortcode( 'wpsm_divider', 'wpsm_divider_shortcode' );
}


//////////////////////////////////////////////////////////////////
// Price Table shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_price_shortcode') ) {
	function wpsm_price_shortcode( $atts, $content = null  ) {
	  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	  $content = do_shortcode($content);
	  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	  $Old     = array( '<br />', '<br>' );
	  $New     = array( '','' );
	  $content = str_replace( $Old, $New, $content );		
	   return '<ul class="wpsm-price clear">' . $content . '</ul><br class="clear" />';
	}
	add_shortcode( 'wpsm_price_table', 'wpsm_price_shortcode' );
}
/* Column of price*/
if( !function_exists('wpsm_price_column_shortcode') ) {
	function wpsm_price_column_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'size' => '3',
			'featured' => '',
			'name' => 'Sample Name',
			'price' => '',
			'per' => '',
			'button_url' => '',
			'button_text' => 'Buy Now',
			'button_color' => 'orange',
		), $atts ) );
		
	  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	  $content = do_shortcode($content);
	  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	  $Old     = array( '<br />', '<br>' );
	  $New     = array( '','' );
	  $content = str_replace( $Old, $New, $content );		
		
		if($size == '2') $column_size = 'one-half';
		if($size == '3') $column_size = 'one-third';
		if($size =='4') $column_size = 'one-fourth';
		if($size =='5') $column_size = 'one-fifth';
	
		if($featured =='yes') $featured_price = 'wpsm-featured-price';
		else $featured_price = NULL;
			
		//fetch content  
		$out_price ='';
		$out_price .= '<li class="wpsm-price-column wpsm-'. $column_size .' '. $featured .' '. $featured_price .'">';
		$out_price .= '<div class="wpsm-price-header"><h4>'. $name. '</h4></div>';
		$out_price .= '<div class="wpsm-price-content"><div class="wpsm-price-cell"><span class="wpsm-price-value">'. $price .'</span>';
		if (!empty($per)) :
			$out_price .= ' /'.$per.'';
		endif;
		$out_price .='</div>';
		$out_price .= $content;
		if ($button_url){
			$out_price .= '<div class="wpsm-price-button"><a href="'. $button_url .'" class="wpsm-button '. $button_color .'"><span class="wpsm-button-inner">'. $button_text .'</span></a></div>';
		}
		$out_price .= '</div></li>';
		  
	   return $out_price;
	}
	add_shortcode( 'wpsm_price_column', 'wpsm_price_column_shortcode' );
}

//////////////////////////////////////////////////////////////////
// tab shortcode
//////////////////////////////////////////////////////////////////

if (!function_exists('wpsm_tabgroup_shortcode')) {
	function wpsm_tabgroup_shortcode( $atts, $content = null ) {
		
		//Enque scripts
		wp_enqueue_script('jquery-ui-tabs');
		
		// Display Tabs
		
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ){
		    $output .= '<div id="wpsm-tab-'. rand(1, 100) .'" class="wpsm-tabs">';
			$output .= '<ul class="ui-tabs-nav wpsm-clearfix">';
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#wpsm-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
	add_shortcode( 'wpsm_tabgroup', 'wpsm_tabgroup_shortcode' );
}
if (!function_exists('wpsm_tab_shortcode')) {
	function wpsm_tab_shortcode( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		return '<div id="wpsm-tab-'. sanitize_title( $title ) .'" class="tab-content">'. do_shortcode( $content ) .'</div>';
	}
	add_shortcode( 'wpsm_tab', 'wpsm_tab_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Toggle
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toggle_shortcode') ) {
	function wpsm_toggle_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array( 'title' => 'Toggle Title', 'class' => ''), $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		// Display the Toggle

		$opens = '';
		if ( $class == 'active' ) {  
			$opens = 'style="display:block"';
		} else {
			$opens = NULL;
		}

		return '<div class="wpsm-toggle"><h3 class="wpsm-toggle-trigger '.$class.'">'. $title .'</h3><div class="wpsm-toggle-container"'.$opens.'>' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('wpsm_toggle', 'wpsm_toggle_shortcode');
}

//////////////////////////////////////////////////////////////////
// Get feeds
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_shortcode_feeds') ) {
function wpsm_shortcode_feeds( $atts, $content = null ) {
    @extract($atts);
	$number  = ($number)  ? $number  : '5' ;
	return wpsm_get_feeds( $url , $number );
}
add_shortcode('wpsm_feed', 'wpsm_shortcode_feeds');
}

function wpsm_get_feeds( $feed , $number ){
	include_once(ABSPATH . WPINC . '/feed.php');

	$rss = @fetch_feed( $feed );
	if (!is_wp_error( $rss ) ){
		$maxitems = $rss->get_item_quantity($number); 
		$rss_items = $rss->get_items(0, $maxitems); 
	}
	if ($maxitems == 0) {
		$out = "<ul><li>No items</li></ul>";
	}else{
		$out = "<ul>";
		
		foreach ( $rss_items as $item ) : 
			$out .= '<li><a href="'. esc_url( $item->get_permalink() ) .'" title="Posted '.$item->get_date("j F Y | g:i a").'">'. esc_html( $item->get_title() ) .'</a></li>';
		endforeach;
		$out .='</ul>';
	}
	
	return $out;
}

//////////////////////////////////////////////////////////////////
// Percent bars
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_bar_shortcode') ) {
	function wpsm_bar_shortcode( $atts  ) {		
		extract( shortcode_atts( array(
			'title' => '',
			'percentage' => '100%',
			'color' => '#6adcfa'
		), $atts ) );		

		$output = '<div class="wpsm-bar wpsm-clearfix" data-percent="'. $percentage .'%">';
			if ( $title !== '' ) $output .= '<div class="wpsm-bar-title" style="background: '. $color .';"><span>'. $title .'</span></div>';
			$output .= '<div class="wpsm-bar-bar" style="background: '. $color .';"></div>';
			$output .= '<div class="wpsm-bar-percent">'.$percentage.' %</div>';
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'wpsm_bar', 'wpsm_bar_shortcode' );
}

//////////////////////////////////////////////////////////////////
// List
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_list_shortcode') ) {
function wpsm_list_shortcode( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'type' => 'arrow'
		), $atts ) ); 
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );		
    return '<div class="wpsm_'.$type.'list">'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_list", "wpsm_list_shortcode");
}

//////////////////////////////////////////////////////////////////
// Pros
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_pros_shortcode') ) {
function wpsm_pros_shortcode( $atts, $content = null ) {

		@extract($atts);
		if( empty($title) ) $title = 'Positives';
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );		 	
    return '<div class="wpsm_pros"><div class="title_pros">'.$title.'</div>'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_pros", "wpsm_pros_shortcode");
}

//////////////////////////////////////////////////////////////////
// Cons
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_cons_shortcode') ) {
function wpsm_cons_shortcode( $atts, $content = null ) {

		@extract($atts);
		if( empty($title) ) $title = 'Negatives'; 	
    return '<div class="wpsm_cons"><div class="title_cons">'.$title.'</div>'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_cons", "wpsm_cons_shortcode");
}

//////////////////////////////////////////////////////////////////
// Tooltip
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_tooltip') ) {
function wpsm_shortcode_tooltip( $atts, $content = null ) {
	wp_enqueue_script('tipsy');

    @extract($atts);
	if( empty($gravity) ) $gravity = 'sw';
	$content_true = do_shortcode($content);
	if( empty($content_true) ) return;
	$out = '';
	$out .= '<span class="wpsm-tooltip wpsm-tooltip-sw" original-title="'.$content_true.'">'.$text.'</span>';
   return $out;
}
add_shortcode('wpsm_tooltip', 'wpsm_shortcode_tooltip');
}


//////////////////////////////////////////////////////////////////
// Member block
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_member_shortcode') ) {
function wpsm_member_shortcode( $atts, $content = null ) {
	@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if($guest_text == '') $guest_text = ' This content visible only for members. You can login <a href="/wp-login.php" class="act-rehub-login-popup">here</a>.';
	if (is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return '<div class="wpsm-members"><strong>'.__("Members only", "rehub_framework").'</strong>' . do_shortcode( $content ) . '</div>';
	}
	else { 

		return '<div class="wpsm-members not-logined"><strong>'.__("Members only", "rehub_framework").'</strong> '.$guest_text.'</div>';	
		 }

	}	
add_shortcode('wpsm_member', 'wpsm_member_shortcode');
}

//////////////////////////////////////////////////////////////////
// Member content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_logged_in') ) {
function wpsm_shortcode_is_logged_in( $atts, $content = null ) {
	@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if (is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return $content;
	}
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_user', 'wpsm_shortcode_is_logged_in');
}

//////////////////////////////////////////////////////////////////
// Guest content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_guest') ) {
function wpsm_shortcode_is_guest( $atts, $content = null ) {
	@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if (!is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return $content;
	}
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_guest', 'wpsm_shortcode_is_guest');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_vendor') ) {
function wpsm_shortcode_is_vendor( $atts, $content = null ) {
	@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();
	if ( in_array( 'vendor', (array) $user->roles )  && !is_null( $content ) && !is_feed()) {
		return $content;
	}		
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_vendor', 'wpsm_shortcode_is_vendor');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_not_vendor_logged') ) {
function wpsm_shortcode_not_vendor_logged( $atts, $content = null ) {
	@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();
	if ( is_user_logged_in() && !in_array( 'vendor', (array) $user->roles )  && !is_null( $content ) && !is_feed()) {
		return $content;
	}		
	else { 
		return;	
	}

}	
add_shortcode('wpsm_not_vendor_logged', 'wpsm_shortcode_not_vendor_logged');
}


//////////////////////////////////////////////////////////////////
// Gallery carousel
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_gallery_carousel') ) {
function wpsm_gallery_carousel( $atts, $content = null ) {
	wp_enqueue_script('owlcarousel');
	$title='';
    @extract($atts);
    $pretty_id = rand(5, 150) ;
    $everul =''; 
	$gals = explode(',', $ids);
	$everul .='<div class="media_owl_carousel carousel-style-2 pretty_photo_'.$pretty_id.' clearfix"><h3>'.$title.'</h3><div class="re_carousel" data-showrow="4" data-auto="">';
	foreach ($gals as $gal){
		$urlgal =  wp_get_attachment_url( $gal);
		$params = array( 'width' => 200, 'crop' => false  );
		$everul .='<div class="photo-item"><a href="'.$urlgal.'"><img src="'.bfi_thumb($urlgal, $params).'" alt="" /></a></div>';
	}
	$everul .='</div></div>';
    if (isset ($prettyphoto) && $prettyphoto == 'true'){
    	wp_enqueue_script('prettyphoto');
    	$everul .='<script>jQuery(function($){$(document).ready(function($){
     		$(".pretty_photo_'.$pretty_id.' a").attr("rel","prettyPhoto[gallery_'.$pretty_id.']").prettyPhoto({social_tools:false});
      	});});</script>';	
    } 			
	 return $everul;
}
add_shortcode('wpsm_minigallery', 'wpsm_gallery_carousel');
}

//////////////////////////////////////////////////////////////////
// Woo Box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woobox_shortcode') ) {
function wpsm_woobox_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'wooid'=> '',
		), $atts));
		
	if(!empty($id)):
		ob_start(); 
		rehub_get_woo_offer(esc_attr($id));
		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	endif;	

}
add_shortcode('wpsm_woobox', 'wpsm_woobox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Woo Compare box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woocompare_shortcode') ) {
function wpsm_woocompare_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'ids' => '',
			'show_vendor'=>''
		), $atts));
		
	if(!empty($ids)):
		$ids = array_map( 'trim', explode( ",", $ids ) );
		$args = array(
	        'post__in' => $ids,
	        'numberposts' => '-1',
	        'orderby' => 'meta_value_num', 
	        'post_type' => 'product',  
	        'meta_key' => '_price',         
	    );
		ob_start(); 
		?>

			<?php $wp_query = new WP_Query( $args ); if ( $wp_query->have_posts() ) : ?> 
			<?php wp_enqueue_style('eggrehub'); ?>
			<div class="egg_sort_list re_sort_list simple_sort_list mb20">
			    <div class="aff_offer_links">			
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  global $product;  ?>
					<?php $woolink = ($product->product_type =='external' && $product->add_to_cart_url() !='') ? $product->add_to_cart_url() : get_post_permalink($product->id) ;?>  
		            <div class="rehub_feat_block table_view_block">               
		                <div class="logo_offer_thumb offer_thumb<?php if(!empty($logo)) {echo ' nologo_thumb';}?>">  
						<?php if ($show_vendor==1 && defined('wcv_plugin_dir')) :?>
							<?php $vendor_id = get_the_author_meta( 'ID' );?>
							<a href="<?php echo WCV_Vendors::get_vendor_shop_page( $vendor_id );?>">
								<img src="<?php echo rh_show_vendor_avatar($vendor_id, 70, 70);?>" class="vendor_store_image_single" width="70" height="70" />
							</a>
						<?php else:?>
							<?php 
								$brand_url = get_post_meta($product->id, 'rehub_woo_coupon_logo_url', true );
						        $term_ids =  wp_get_post_terms($product->id, 'store', array("fields" => "ids"));
						        if (!empty($term_ids) && ! is_wp_error($term_ids)) {
						        	$term_id = $term_ids[0];
						        	$storeobj = get_term_by('id', $term_id, 'store');
						        	$store = $storeobj->name;
						        }
						        if (!empty ($brand_url)) {
						            $logo = esc_url($brand_url);
						        }  
						        else { 
						        	if (!empty($term_id)) {			        		
						        		$brand_url = get_term_meta( $term_id, 'brandimage', true );
						        	}
							        if (!empty ($brand_url)) {
							            $logo = esc_url($brand_url);
							        }  
						        }							

						    ?>						
		                    <a rel="nofollow" target="_blank" href="<?php echo esc_url($woolink) ?>" class="re_track_btn">
		                        <?php if(!empty($logo)) :?>
		                            <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $logo, 'lazy'=>false, 'height'=> 50, 'title' => get_the_title(), 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>
		                        <?php elseif (!empty($store)) :?>
		                            <div class="aff_logo_text"><?php echo $store; ?></div>                          
		                        <?php endif ;?>                                                           
		                    </a>						
						<?php endif;?>
		                </div>
		                <div class="desc_col desc_simple_col">
		                    <div class="simple_title">
		                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($woolink) ?>">
		                            <?php the_title(); ?>
		                        </a>
		                        <?php do_action( 'rehub_vendor_show_action' ); ?>
		                    </div>                                
		                </div>                    
		                <div class="desc_col price_simple_col"> 
		                	<p><span class="price_count"><?php echo $product->get_price_html(); ?></span></p>                       
		                </div>
		                <div class="buttons_col">
		                    <div class="priced_block clearfix">
			                    <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
			                        <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			                            sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn woo_loop_btn btn_offer_block %s %s product_type_%s"%s%s>%s</a>',
			                            esc_url( $product->add_to_cart_url() ),
			                            esc_attr( $product->id ),
			                            esc_attr( $product->get_sku() ),
			                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			                            $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			                            esc_attr( $product->product_type ),
			                            $product->product_type =='external' ? ' target="_blank"' : '',
			                            $product->product_type =='external' ? ' rel="nofollow"' : '',
			                            esc_html( $product->add_to_cart_text() )
			                            ),
			                        $product );?>
			                    <?php endif; ?>
		                    </div>
		                </div>                                                                         
		            </div>               					

				<?php endwhile; ?>
				</div>    
			</div>
			<?php endif; wp_reset_query(); ?> 

		<?php

		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	endif;	

}
add_shortcode('wpsm_woocompare', 'wpsm_woocompare_shortcode');
}

//////////////////////////////////////////////////////////////////
// POPUP BUTTON
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_button_popup_funtion') ) {
function wpsm_button_popup_funtion( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'color' => 'orange',
		'size' => 'medium',
		'icon' => 'none',
		'btn_text' => 'Show me popup',
		'max_width' => '500',
		'enable_icon' => ''    
    ), $atts));	
    $rand = rand(1, 100) ;
    $iconshow = ($enable_icon !='') ? '<span class="'.$icon.'"></span>' : '';
	$out = '<div id="popup_cont_'.$rand.'" class="popup_cont_div"><div class="popup_cont_inside">'.do_shortcode($content).'</div></div>';
	$out .= '<a href="javascript:void(0)" class="popup_btn'.$rand.' wpsm-button wpsm-flat-btn '.$color.' '.$size.'"><span class="wpsm-button-inner">'.$iconshow.$btn_text.'</span></a>';
	$out .= '<script>jQuery(document).ready(function($) {
     			$(".popup_btn'.$rand.'").click(function(){
     				$.pgwModal({target: "#popup_cont_'.$rand.'",maxWidth: '.$max_width.',titleBar: false});
     			});
     		});</script>';
    return $out;
}
add_shortcode('wpsm_button_popup', 'wpsm_button_popup_funtion');
}

//////////////////////////////////////////////////////////////////
// Countdown
//////////////////////////////////////////////////////////////////
if (! function_exists( 'wpsm_countdown' ) ) :
	function wpsm_countdown($atts, $content = null) {	
		extract(shortcode_atts(array(
				"year" => '',
				"month" => '',
				"day" => '',
				"hour" => '00',
		), $atts));
		
		// load scripts
		wp_enqueue_script('lwtCountdown');
		$rand_id = rand(1, 100);
		ob_start(); 		
		?>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#countdown_dashboard<?php echo $rand_id;?>').show();
			  	$('#countdown_dashboard<?php echo $rand_id;?>').countDown({
				  	targetDate: {
					  'day': 	<?php echo $day ?>,
					  'month': 	<?php echo $month ?>,
					  'year': 	<?php echo $year ?>,
					  'hour': 	<?php echo $hour ?>,
					  'min': 		0,
					  'sec': 		0
				  	},
				  	omitWeeks: true,
				  	onComplete: function() { $('#countdown_dashboard<?php echo $rand_id;?>').hide() }
			  	});
			});
		</script>
		<div id="countdown_dashboard<?php echo $rand_id;?>" class="countdown_dashboard"> 			  
			<div class="dash days_dash"> <span class="dash_title">days</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash hours_dash"> <span class="dash_title">hours</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash minutes_dash"> <span class="dash_title">minutes</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash seconds_dash"> <span class="dash_title">seconds</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
		</div>
		<!-- Countdown dashboard end -->
		<div class="clearfix"></div>		

		<?php		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	   
	}
	add_shortcode("wpsm_countdown", "wpsm_countdown");
endif;


//////////////////////////////////////////////////////////////////
// TITLE
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_title_function') ) {
function rehub_title_function( $atts, $content = null ) {  
    extract(shortcode_atts(array(
		'link' => '',				   
    ), $atts));
    $out = '';
    if(!empty($link)) :
	    $link_source = ($link =='affiliate') ? rehub_create_affiliate_link() : get_the_permalink() ;
		$link_target = ($link =='affiliate') ? ' target="_blank" rel="nofollow"' : '' ;
		$out .='<a href="'.$link_source.'"'.$link_target.'>';
	endif;
	$out .= get_the_title();
    if(!empty($link)) :
		$out .='</a>';
	endif;	
    return $out;
}
add_shortcode('rehub_title', 'rehub_title_function');
}

//////////////////////////////////////////////////////////////////
// AFF BUTTON
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_affbtn_function') ) {
function rehub_affbtn_function( $atts, $content = null ) { 
    extract(shortcode_atts(array(
		'btn_text' => '',
		'btn_url' => '',
		'btn_price' => '',
		'meta_btn_url' => '',
		'meta_btn_price' => '',
		'button_from_review' => '',				   
    ), $atts));
    if ($button_from_review =='1') :
    	ob_start();
    	rehub_create_btn(''); 
		$out = ob_get_contents();
		ob_end_clean();
	else :	
	    $button_url = (!empty($meta_btn_url)) ? get_post_meta( get_the_ID(), esc_html($meta_btn_url), true ) : $btn_url;
		if (empty ($button_url)) {$button_url = get_the_permalink();}
		$button_price = (!empty($meta_btn_price)) ? get_post_meta( get_the_ID(), esc_html($meta_btn_price), true ) : $btn_price;    
		$out = 	'<div class="priced_block clearfix">';
		if (!empty($button_price)) :
			$out .= '<p><span class="price_count">'.esc_html($button_price).'</span></p>'; 
		endif;
		$out .='<div><a href="'.esc_url($button_url).'" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow">';
		if (!empty($btn_text)) :         
			$out .= $btn_text;
		elseif (rehub_option('rehub_btn_text') !='') :
			$out .= rehub_option("rehub_btn_text");
		else :
			$out .= __("Buy this item", "rehub_framework");	
		endif;
		$out .='</a></div></div>';
	endif;            
    return $out;
}
add_shortcode('rehub_affbtn', 'rehub_affbtn_function');
}

//////////////////////////////////////////////////////////////////
// EXCERPT
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_exerpt_function') ) {
function rehub_exerpt_function( $atts, $content = null ) { 
    extract(shortcode_atts(array(
		'length' => '120',
		'reviewtext' => '',   
    ), $atts));
    ob_start();
    if ($reviewtext =='1') :
    	echo vp_metabox('rehub_post.review_post.0.review_post_summary_text');
    else :
		kama_excerpt('maxchar='.$length.'');
	endif;
	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
}
add_shortcode('rehub_exerpt', 'rehub_exerpt_function');
}

//////////////////////////////////////////////////////////////////
// Review and ads shortcode and functions
//////////////////////////////////////////////////////////////////

if( !function_exists('rehub_shortcode_review') ) {
function rehub_shortcode_review( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_post_product_shortcode') == '1') {	
		ob_start();
		rehub_get_review();
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
}
add_shortcode('review', 'rehub_shortcode_review');

if( !function_exists('rehub_shortcode_offer') ) {
function rehub_shortcode_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_offer_shortcode') == '1') {
		ob_start(); 
		rehub_get_offer();
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
}
add_shortcode('offer_product', 'rehub_shortcode_offer');

if( !function_exists('rehub_shortcode_aff_offer') ) {
function rehub_shortcode_aff_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_offer_shortcode') == '1') {
		ob_start(); 
		rehub_get_aff_offer();
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
}
add_shortcode('aff_offer_product', 'rehub_shortcode_aff_offer');

if( !function_exists('rehub_shortcode_woo_offer') ) {
function rehub_shortcode_woo_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_offer_shortcode') == '1') {
		if (vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') {
			$review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');
			ob_start(); 
			rehub_get_woo_offer($review_woo_link);
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		} 
	}
}
}
add_shortcode('woo_offer_product', 'rehub_shortcode_woo_offer');

if( !function_exists('rehub_shortcode_woolist_offer') ) {
function rehub_shortcode_woolist_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_shortcode') == '1') {
		if (vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') {
			$review_woo_list_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
			if (is_array($review_woo_list_links)) { $review_woo_list_links = implode(',', $review_woo_list_links); }
			ob_start(); 
			echo do_shortcode('[wpsm_woolist data_source="ids" ids="'.$review_woo_list_links.'"]');
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		} 
	}
}
}
add_shortcode('woo_offer_list', 'rehub_shortcode_woolist_offer');

if( !function_exists('rehub_shortcode_quick_offer') ) {
function rehub_shortcode_quick_offer( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'id' => '',
			), $atts);	
		$offer_shortcode = get_post_meta( get_the_ID(), 'rehub_offer_shortcode', true );
		if (empty($offer_shortcode) && empty($atts['id'])) return false;
		ob_start(); 
		rehub_quick_offer($atts['id']);
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
}
}
add_shortcode('quick_offer', 'rehub_shortcode_quick_offer');

if(!function_exists('wpsm_shortcode_boxad')) {
function wpsm_shortcode_boxad( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'float' => 'none',
			), $atts);

	$out = '<div class="wpsm_boxad mediad align'.$atts['float'].'">
			' .rehub_option("rehub_shortcode_ads"). '
			</div>';
    return $out;
}
add_shortcode('wpsm_ads1', 'wpsm_shortcode_boxad');
}

if(!function_exists('wpsm_shortcode_boxad2')) {
function wpsm_shortcode_boxad2( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'float' => 'none',
			), $atts);

	$out = '<div class="wpsm_boxad mediad align'.$atts['float'].'">
			' .rehub_option("rehub_shortcode_ads_2"). '
			</div>';
    return $out;
}
add_shortcode('wpsm_ads2', 'wpsm_shortcode_boxad2');
}

//////////////////////////////////////////////////////////////////
// Specification for meta filter plugin
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_specification_shortcode') ) {
function wpsm_specification_shortcode($atts, $content = null ) {
extract(shortcode_atts(array(
	'id' => '',
	'title' => '',
), $atts));
if(class_exists('MetaDataFilter')):
	global $post;
	if(!isset($atts['id']) || $atts['id'] =='') {
		$id = get_the_ID();
	}
	$title_label = (!empty($atts['title'])) ? $atts['title'] : __('Specification', 'rehub_framework');

	ob_start();
	echo '<div class="rehub_specification"><div class="title_specification">'.$title_label.'</div>';
	MetaDataFilterPage::draw_single_page_items($id, false);
	echo '</div>';
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
endif;
}
add_shortcode('wpsm_specification', 'wpsm_specification_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top rating shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toprating_shortcode') ) {
function wpsm_toprating_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'full_width' => '0',
		), $atts));
		
	if(isset($atts['id']) && $atts['id']):

		$toppost = get_post($atts['id']);
		$module_cats = get_post_meta( $toppost->ID, 'top_review_cat', true ); 
    	$module_tag = get_post_meta( $toppost->ID, 'top_review_tag', true ); 
    	$module_fetch = get_post_meta( $toppost->ID, 'top_review_fetch', true ); 
    	$module_ids = get_post_meta( $toppost->ID, 'manual_ids', true ); 
    	$order_choose = get_post_meta( $toppost->ID, 'top_review_choose', true ); 
    	$module_desc = get_post_meta( $toppost->ID, 'top_review_desc', true );
    	$module_desc_fields = get_post_meta( $toppost->ID, 'top_review_custom_fields', true );
    	$rating_circle = get_post_meta( $toppost->ID, 'top_review_circle', true );
    	$module_field_sorting = get_post_meta( $toppost->ID, 'top_review_field_sort', true );
    	$module_order = get_post_meta( $toppost->ID, 'top_review_order', true );    	
    	if ($module_fetch ==''){$module_fetch = '10';}; 
    	if ($module_desc ==''){$module_desc = 'post';};
    	if ($rating_circle ==''){$rating_circle = '1';};		
		
		ob_start(); 

    	?>
                <div class="clearfix"></div>

                <?php if ($order_choose == 'cat_choose') :?>
	                <?php $query = array( 
	                    'cat' => $module_cats, 
	                    'tag' => $module_tag, 
	                    'posts_per_page' => $module_fetch, 
	                    'nopaging' => 0, 
	                    'post_status' => 'publish', 
	                    'ignore_sticky_posts' => 1, 
	                    'meta_key' => 'rehub_review_overall_score', 
	                    'orderby' => 'meta_value_num',
	                    'meta_query' => array(
	                            array(
	                            'key' => 'rehub_framework_post_type',
	                            'value' => 'review',
	                            'compare' => 'LIKE',
	                            )
	                    )
	                );
	                ?> 
                    <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting;} ?>
                    <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                
            	<?php elseif ($order_choose == 'manual_choose' && $module_ids !='') :?>
	                <?php $query = array( 
	                    'post_status' => 'publish', 
	                    'ignore_sticky_posts' => 1,
	                    'posts_per_page'=> -1, 
	                    'orderby' => 'post__in',
	                    'post__in' => $module_ids

	                );
	                ?>
            	<?php else :?>
	                <?php $query = array( 
	                    'posts_per_page' => $module_fetch, 
	                    'nopaging' => 0, 
	                    'post_status' => 'publish', 
	                    'ignore_sticky_posts' => 1, 
	                    'meta_key' => 'rehub_review_overall_score', 
	                    'orderby' => 'meta_value_num',
	                    'meta_query' => array(
	                            array(
	                            'key' => 'rehub_framework_post_type',
	                            'value' => 'review',
	                            'compare' => 'LIKE',
	                            )
	                    )
	                );
	                ?>
                    <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting;} ?>
                    <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                             		
            	<?php endif ;?>	


                <?php $loop = new WP_Query($query); $i=0; if ($loop->have_posts()) :?>
                <div class="top_rating_block<?php if(isset($atts['full_width']) && $atts['full_width']=='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> list_style_rating">
                <?php while ($loop->have_posts()) : $loop->the_post(); $i ++?>     
                    <div class="top_rating_item" id='rank_<?php echo $i?>'>                    
                        <div class="product_image_col">                        	
                            <figure><?php echo re_badge_create('ribbon'); ?>
                            	<span class="rank_count"><?php if (($i) == '1') :?><i class="fa fa-trophy"></i><?php else:?><?php echo $i?><?php endif ?></span>
                            	<a href="<?php the_permalink();?>">
                                    <?php 
                                    $showimg = new WPSM_image_resizer();
                                    $showimg->use_thumb = true;
                                    $width_figure_rating = apply_filters( 'wpsm_top_rating_figure_width', 120 );
                                    $height_figure_rating = apply_filters( 'wpsm_top_rating_figure_height', 120 );
                                    if( rehub_option( 'aq_resize_crop') == '1') {
                                        $showimg->width = $width_figure_rating;
                                    } 
                                    else {
                                        $showimg->width = $width_figure_rating;
                                        $showimg->height = $height_figure_rating;
                                        $showimg->crop = true;
                                    }
                                    $showimg->show_resized_image();                                    
                                    ?>
                            	</a>
                            </figure>
                        </div>                            
                    <div class="desc_col">
                        <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                        <p>
                        	<?php if ($module_desc =='post') :?>
                        		<?php kama_excerpt('maxchar=120'); ?>
                        	<?php elseif ($module_desc =='review') :?>
                        		<?php echo wp_kses_post(vp_metabox('rehub_post.review_post.0.review_post_summary_text')); ?>
                            <?php elseif ($module_desc =='field') :?>
                                <?php if ( get_post_meta(get_the_ID(), $module_desc_fields, true) ) : ?>
                                    <?php echo get_post_meta(get_the_ID(), $module_desc_fields, true) ?>
                                <?php endif; ?>                        		
                        	<?php elseif ($module_desc =='none') :?>
                        	<?php else :?>	
                        		<?php kama_excerpt('maxchar=120'); ?>
                    		<?php endif;?>
                        </p>
                        <div class="star"><?php rehub_get_user_results('small', 'yes') ?></div>
                    </div>
                    <div class="rating_col">
                    <?php if ($rating_circle =='1'):?>
                        <?php $rating_score_clean = rehub_get_overall_score(); ?>
                        <div class="top-rating-item-circle-view">
	                        <div class="radial-progress" data-rating="<?php echo $rating_score_clean?>">
	                            <div class="circle">
	                                <div class="mask full">
	                                    <div class="fill"></div>
	                                </div>
	                                <div class="mask half">
	                                    <div class="fill"></div>
	                                    <div class="fill fix"></div>
	                                </div>
	                                
	                            </div>
	                            <div class="inset">
	                                <div class="percentage"><?php echo $rating_score_clean?></div>
	                            </div>
	                        </div>
                        </div>
                    <?php elseif ($rating_circle =='2') :?> 
                        <div class="score square_score"> <span class="it_score"><?php echo rehub_get_overall_score() ?></span></div>       
                    <?php else :?>
                        <div class="score"> <span class="it_score"><?php echo rehub_get_overall_score() ?></span></div>    
                    <?php endif ;?>
                    </div>
                    <div class="buttons_col">
                    	<?php rehub_create_btn('') ;?>
                        <a href="<?php the_permalink();?>" class="read_full"><?php if(rehub_option('rehub_review_text') !='') :?><?php echo rehub_option('rehub_review_text') ; ?><?php else :?><?php _e('Read full review', 'rehub_framework'); ?><?php endif ;?></a>
                    </div>
                    </div>
                <?php endwhile; ?>
                </div>
                <?php wp_reset_query(); ?>
                <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
                <?php endif; ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_top', 'wpsm_toprating_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top table shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toptable_shortcode') ) {
function wpsm_toptable_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'full_width' => '0',
		), $atts));
		
	if(isset($atts['id']) && $atts['id']):

		$toppost = get_post($atts['id']);
		$module_cats = get_post_meta( $toppost->ID, 'top_review_cat', true ); 
    	$module_tag = get_post_meta( $toppost->ID, 'top_review_tag', true ); 
    	$module_fetch = intval(get_post_meta( $toppost->ID, 'top_review_fetch', true ));  
    	$module_ids = get_post_meta( $toppost->ID, 'manual_ids', true ); 
    	$order_choose = get_post_meta( $toppost->ID, 'top_review_choose', true ); 
	    $module_custom_post = get_post_meta( $toppost->ID, 'top_review_custompost', true );
	    $catalog_tax = get_post_meta( $toppost->ID, 'catalog_tax', true );
	    $catalog_tax_slug = get_post_meta( $toppost->ID, 'catalog_tax_slug', true );    	
    	$module_field_sorting = get_post_meta( $toppost->ID, 'top_review_field_sort', true );
    	$module_order = get_post_meta( $toppost->ID, 'top_review_order', true );
	    $first_column_enable = get_post_meta( $toppost->ID, 'first_column_enable', true );
	    $first_column_rank = get_post_meta( $toppost->ID, 'first_column_rank', true ); 
	    $last_column_enable = get_post_meta( $toppost->ID, 'last_column_enable', true );
	    $first_column_name = (get_post_meta( $toppost->ID, 'first_column_name', true ) !='') ? esc_html(get_post_meta( $toppost->ID, 'first_column_name', true )) : __('Product', 'rehub_framework') ;
	    $last_column_name = (get_post_meta( $toppost->ID, 'last_column_name', true ) !='') ? esc_html(get_post_meta( $toppost->ID, 'last_column_name', true )) : '' ;
	    $affiliate_link = get_post_meta( $toppost->ID, 'first_column_link', true );
	    $rows = get_post_meta( $toppost->ID, 'columncontents', true ); //Get the rows     	    	
    	if ($module_fetch ==''){$module_fetch = '10';}; 
		
		ob_start(); 
    	?>
        <div class="clearfix"></div>
        <?php 
            if ( get_query_var('paged') ) { 
                $paged = get_query_var('paged'); 
            } 
            else if ( get_query_var('page') ) {
                $paged = get_query_var('page'); 
            } 
            else {
                $paged = 1; 
            }        
        ?>        
        <?php if ($order_choose == 'cat_choose') :?>
            <?php $query = array( 
                'cat' => $module_cats, 
                'tag' => $module_tag, 
                'posts_per_page' => $module_fetch, 
                'paged' => $paged,  
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
            );
            ?> 
            <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting; $query['orderby'] = 'meta_value_num';} ?>
            <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                
    	<?php elseif ($order_choose == 'manual_choose' && $module_ids !='') :?>
            <?php $query = array( 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1,
                'posts_per_page'=> -1, 
                'orderby' => 'post__in',
                'post__in' => $module_ids

            );
            ?>
	    <?php elseif ($order_choose == 'custom_post') :?>
	        <?php $query = array(  
	            'posts_per_page' => $module_fetch,  
	            'post_status' => 'publish', 
	            'ignore_sticky_posts' => 1,
	            'paged' => $paged, 
	            'post_type' => $module_custom_post, 
	        );
	        ?> 
	        <?php if (!empty ($catalog_tax_slug) && !empty ($catalog_tax)) : ?>
	            <?php $query['tax_query'] = array (
	                array(
	                    'taxonomy' => $catalog_tax,
	                    'field'    => 'slug',
	                    'terms'    => $catalog_tax_slug,
	                ),
	            );?>
	        <?php endif ?> 
            <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting; $query['orderby'] = 'meta_value_num';} ?>
            <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                    
    	<?php else :?>
            <?php $query = array( 
                'posts_per_page' => $module_fetch, 
                'paged' => $paged,
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
            );
            ?>
            <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting; $query['orderby'] = 'meta_value_num';} ?>
            <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                             		
    	<?php endif ;?>	


        <?php $loop = new WP_Query($query); $i=0; if ($loop->have_posts()) :?>
        <?php wp_enqueue_script('tablesorter'); wp_enqueue_style('tabletoggle'); ?>
        <table data-tablesaw-sortable data-tablesaw-sortable-switch class="tablesaw top_table_block<?php if ($full_width =='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> tablesorter" cellspacing="0">
            <thead> 
            <tr class="top_rating_heading">
                <?php if ($first_column_enable):?><th class="product_col_name" data-tablesaw-priority="persist"><?php echo $first_column_name; ?></th><?php endif;?>
                <?php if (!empty ($rows)) {
                    $nameid=0;                       
                    foreach ($rows as $row) {                       
                    $col_name = $row['column_name'];
                    echo '<th class="col_name" data-tablesaw-sortable-col data-tablesaw-priority="1">'.esc_html($col_name).'</th>';
                    $nameid++;
                    } 
                }
                ?>
                <?php if ($last_column_enable):?><th class="buttons_col_name" data-tablesaw-sortable-col data-tablesaw-priority="1"><?php echo $last_column_name; ?></th><?php endif;?>                      
            </tr>
            </thead>
            <tbody>
        <?php while ($loop->have_posts()) : $loop->the_post(); $i ++?>     
            <tr class="top_rating_item" id='rank_<?php echo $i?>'>
                <?php if ($first_column_enable):?>
                    <td class="product_image_col"><?php echo re_badge_create('tablelabel'); ?>
                        <figure>
                            <?php if (!is_paged() && $first_column_rank) :?><span class="rank_count"><?php if (($i) == '1') :?><i class="fa fa-trophy"></i><?php else:?><?php echo $i?><?php endif ?></span><?php endif ?>                        
                            <?php $link_on_thumb = ($affiliate_link =='1') ? rehub_create_affiliate_link() : get_the_permalink(); ?>
                            <?php $link_on_thumb_target = ($affiliate_link =='1') ? ' class="btn_offer_block" target="_blank" rel="nofollow"' : '' ; ?>
                            <a href="<?php echo $link_on_thumb;?>" <?php echo $link_on_thumb_target;?>>
                            <?php 
                            $showimg = new WPSM_image_resizer();
                            $showimg->use_thumb = true;
                            $width_figure_table = apply_filters( 'wpsm_top_table_figure_width', 120 );
                            $height_figure_table = apply_filters( 'wpsm_top_table_figure_height', 120 );                            
                            if( rehub_option( 'aq_resize_crop') == '1') {
                                $showimg->width = $width_figure_table;
                            } 
                            else {
                                $showimg->width = $width_figure_table;
                                $showimg->height = $height_figure_table;
                                $showimg->crop = true;
                            }
                            $showimg->show_resized_image();                                    
                            ?> 
                            </a>
                        </figure>
                    </td>
                <?php endif;?>
                <?php 
                if (!empty ($rows)) {
                    $pbid=0;                       
                    foreach ($rows as $row) {
                    $centered = ($row['column_center']== '1') ? ' centered_content' : '' ;
                    echo '<td class="column_'.$pbid.' column_content'.$centered.'">';
                    echo do_shortcode(wp_kses_post($row['column_html']));                       
                    $element = $row['column_type'];
                        if ($element == 'meta_value') {
                            include(locate_template('inc/top/metacolumn.php'));
                        } else if ($element == 'review_function') {
                            include(locate_template('inc/top/reviewcolumn.php'));
                        } else if ($element == 'taxonomy_value') {
                            include(locate_template('inc/top/taxonomyrow.php'));                            
                        } else if ($element == 'user_review_function') {
                            include(locate_template('inc/top/userreviewcolumn.php')); 
                        } else if ($element == 'static_user_review_function') {
                            include(locate_template('inc/top/staticuserreviewcolumn.php'));                                                                       
                        } else {
                            
                        };
                    echo '</td>';
                    $pbid++;
                    } 
                }
                ?>
                <?php if ($last_column_enable):?>
                    <td class="buttons_col">
                    	<?php rehub_create_btn('') ;?>                                
                    </td>
                <?php endif ;?>
            </tr>
        <?php endwhile; ?>
	        </tbody>
	    </table>
        <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
        <?php endif; ?>
        <?php wp_reset_query(); ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_toptable', 'wpsm_toptable_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top charts shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_topcharts_shortcode') ) {
function wpsm_topcharts_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
		), $atts));
		
	if(isset($atts['id']) && $atts['id']):
		$topchart = get_post($atts['id']);
	    $type_chart = get_post_meta( $topchart->ID, 'top_chart_type', true );
	    $ids_chart = get_post_meta( $topchart->ID, 'top_chart_ids', true );
	    if($ids_chart) {$module_ids = explode(',', $ids_chart);}
	    $module_width = get_post_meta( $topchart->ID, 'top_chart_width', true );     
	    $rows = get_post_meta( $topchart->ID, 'columncontents', true ); //Get the rows 
	    $compareids = (get_query_var('compareids')) ? explode(',', get_query_var('compareids')) : '';    		
		ob_start(); 
    	?>
        <?php if ($compareids !='') :?>
            <?php $query = array( 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
                'orderby' => 'post__in',
                'post__in' => $compareids,
                'posts_per_page'=> -1,

            );
            ?>
    	<?php elseif (!empty($module_ids)) :?>
            <?php $query = array( 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
                'orderby' => 'post__in',
                'post__in' => $module_ids,
                'posts_per_page'=> -1,

            );
            ?>
    	<?php else :?>
            <?php $query = array( 
                'posts_per_page' => 5,  
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
            );
            ?>                                		
    	<?php endif ;?>
        <?php if (post_type_exists( $type_chart )) {$query['post_type'] = $type_chart;} ?>	

        <?php 
        if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){

            $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
            $_REQUEST['mdf_get_query_args_only'] = true;
            do_shortcode('[meta_data_filter_results]');
            $args = $_REQUEST['meta_data_filter_args'];
            global $wp_query;
            $wp_query=new WP_Query($args);
            $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
        }
        else { $wp_query = new WP_Query($query); }    
        $i=0; if ($wp_query->have_posts()) :?>
        <?php wp_enqueue_script('carouFredSel'); wp_enqueue_script('touchswipe'); ?>                                       
        <div class="top_chart table_view_charts loading">
            <div class="top_chart_controls">
                <a href="/" class="controls prev"></a>
                <div class="top_chart_pagination"></div>
                <a href="/" class="controls next"></a>
            </div>
            <div class="top_chart_first">
                <ul>
                    <?php if (!empty ($rows)) {
                        $nameid=0;                       
                        foreach ($rows as $row) {   
                        $element_type = $row['column_type']; 
                        $first_col_value = '<div';  
                        if (isset ($row['sticky_header']) && $row['sticky_header'] == 1) {$first_col_value .= ' class="sticky-cell"';} 
                        $first_col_value .= '>'.esc_html($row["column_name"]).'';
                        if (isset ($row['enable_diff']) && $row['enable_diff'] == 1) {$first_col_value .= '<label class="diff-label"><input class="re-compare-show-diff" name="re-compare-show-diff" type="checkbox" />'.__('Show only differences', 'rehub_framework').'</label>';}                                                              
                        $first_col_value .= '</div>';                
                        echo '<li class="row_chart_'.$nameid.' '.$element_type.'_row_chart">'.$first_col_value.'</li>';
                        $nameid++;
                        } 
                    }
                    ?>
                </ul>
            </div>
        	<div class="top_chart_wrap"><div class="top_chart_carousel">
		        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i ++?>     
		            <div class="<?php echo re_badge_create('class'); ?> top_rating_item top_chart_item compare-item-<?php echo get_the_ID();?>" id='rank_<?php echo $i?>' data-compareid="<?php echo get_the_ID();?>">
		                <ul>
		                <?php 
		                if (!empty ($rows)) {
		                    $pbid=0;                       
		                    foreach ($rows as $row) {                                                     
		                    $element = $row['column_type'];
		                        echo '<li class="row_chart_'.$pbid.' '.$element.'_row_chart">';
		                        if ($element == 'meta_value') {                                
		                            include(locate_template('inc/top/metarow.php'));
		                        } else if ($element == 'image') {
		                            include(locate_template('inc/top/imagerow.php'));
		                        } else if ($element == 'title') {
		                            include(locate_template('inc/top/titlerow.php'));   
		                        } else if ($element == 'taxonomy_value') {
		                            include(locate_template('inc/top/taxonomyrow.php'));     
		                        } else if ($element == 'affiliate_btn') {
		                            include(locate_template('inc/top/btnrow.php'));
		                        } else if ($element == 'review_link') {
		                            include(locate_template('inc/top/reviewlinkrow.php'));
		                        } else if ($element == 'review_function') {
		                            include(locate_template('inc/top/reviewrow.php'));                                    
		                        } else if ($element == 'user_review_function') {
		                            include(locate_template('inc/top/userreviewcolumn.php'));
                                } else if ($element == 'static_user_review_function') {
                                    include(locate_template('inc/top/staticuserreviewcolumn.php'));
                                } else if ($element == 'shortcode') {
                                    $shortcodevalue = (isset($row['shortcode_value'])) ? $row['shortcode_value'] : '';
                                    echo do_shortcode(wp_kses_post($shortcodevalue));                                     
		                        } else {   
		                        };
		                        echo '</li>';
		                    $pbid++;
		                    } 
		                }
		                ?>
		            </ul>
		            </div>
		        <?php endwhile; ?>
        	</div></div>
        	<span class="top_chart_row_found" data-rowcount="<?php echo $pbid;?>"></span>
        </div>
        <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
        <?php endif; ?>
        <?php wp_reset_query(); ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_charts', 'wpsm_topcharts_shortcode');
}


//////////////////////////////////////////////////////////////////
// Categorizator
//////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_multi_cat', 'ajax_action_multi_cat' );
add_action( 'wp_ajax_nopriv_multi_cat', 'ajax_action_multi_cat' );
if( !function_exists('ajax_action_multi_cat') ) {
function ajax_action_multi_cat() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajaxed-nonce' ) )
        die ( 'Nope!' );   
		$data = $_POST;

		$page = intval($data['page']);
		$paged = ($page) ? $page : 1;
		ob_start();
		$query_args = array(
			'paged' => $paged,
			'post_type' => 'post',
			'posts_per_page' => 5,
			'tax_query' => array(
				array(
					'taxonomy' => $data['tax'],
					'field' => 'id',
					'terms' => $data['term']
				)
			),
		);
		$query = new WP_Query($query_args);
		$response = '';
		if ( $query->have_posts() ) {
			while ($query->have_posts() ) {
				$query->the_post();
				ob_start();
				get_template_part( 'content', 'multi_category' );
				$response .= ob_get_clean();
			}
			wp_reset_postdata();
		} else {
			$response = 'fail';
		}

		echo $response ;
		exit;
}
}

if( !function_exists('wpsm_categorizator_shortcode') ) {
function wpsm_categorizator_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'tax' => 'category',
			'exclude' => '',
			'include' => '',
			'col' => '3'
		), $atts));
        
    $args = array(
    	'taxonomy'=> $tax,
        'orderby' => 'name',
		'exclude' => explode(',', $exclude),
		'include' => explode(',', $include),
    );
    $terms = get_terms($args );

	ob_start(); 
    ?>

    <?php
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            if ($col == '4') {
            	echo '<div class="col_wrap_fourth">';
            }
            elseif ($col == '2') {
            	echo '<div class="col_wrap_two">';
            }  
            elseif ($col == '1') {
            	echo '<div class="alignleft multicatleft">';
            }                       
            else {echo '<div class="col_wrap_three">'; }
            $i = 1;
            foreach ($terms as $term) {
                $query_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $term->taxonomy,
                            'field' => 'id',
                            'terms' => $term->term_id
                        )
                    ),
                );

                $query = new WP_Query($query_args);

                if ( $query->have_posts() ) :
                    ?>

                    <div id="directory-<?php echo $term->term_id; ?>" class="multi_cat col_item"
                         data-tax="<?php echo $term->taxonomy; ?>"
                         data-term="<?php echo $term->term_id; ?>">
                        <div class="multi_cat_header">
							<div class="multi_cat_lable">
								<?php echo $term->name; ?>
							</div>
                        </div>
                        <div class="multi_cat_wrap eq_height_post">

                            <?php while ($query->have_posts() ) :
                                $query->the_post();
                                get_template_part( 'content', 'multi_category' );
                            endwhile; wp_reset_postdata(); ?>

                        </div>
                        <div class="cat-pagination multi_cat_header clearfix">

                            <?php for ($j = 1, $max_count = $query->max_num_pages; $j<= $max_count;  $j++) : ?>
                                <?php $active = ($j ===1) ? 'active' : '' ;?>
                                <a class="styled <?php echo $active; ?>" data-paginated="<?php echo $j; ?>"><?php echo $j;?></a>
                            <?php endfor; ?>

                        </div>
                    </div>

                    <?php $i++;
                    
                endif;
            }
            echo '</div>';
        }   
    ?>

	<?php 
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('wpsm_categorizator', 'wpsm_categorizator_shortcode');
}

//////////////////////////////////////////////////////////////////
// Cartbox
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_cartbox_shortcode') ) {
function wpsm_cartbox_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'title' => '',
			'link' => '',
			'description' => '',
			'image' => '',
			'bg_contain' =>'',
			'revert_image' =>''
		), $atts));

	if (is_numeric($image)) {$image = wp_get_attachment_url( $image);}
	$bg_contain = ($bg_contain) ? 'background-size: contain;' : '';
	$output = '<div class="categoriesbox">';
	if ($revert_image) :
		if ($image) :
			$output .= '<div class="categoriesbox-bg" style="background-image: url('.$image.');'.$bg_contain.'">';	
			if ($link) : 
				$output .= '<a href="'.esc_url($link).'"></a>';
			endif;
			$output .= '</div>';	
		endif;		
	endif;
	$output .='<div class="categoriesbox-content">';
	if ($title) :
		$output .= '<h3>';
		if ($link) : 
			$output .= '<a href="'.esc_url($link).'">';
		endif;
			$output .= $title;	
		if ($link) : 
			$output .= '</a>';
		endif;
		$output .= '</h3>';		
	endif;
	if ($description) :
		$output .= '<p>'.$description.'</p>';		
	endif;	
	$output .= '</div>';
	if ($revert_image =='' || $revert_image =='0') :
		if ($image) :
			$output .= '<div class="categoriesbox-bg" style="background-image: url('.$image.');'.$bg_contain.'">';	
			if ($link) : 
				$output .= '<a href="'.esc_url($link).'"></a>';
			endif;
			$output .= '</div>';	
		endif;
	endif;
	$output .= '</div>';
	return $output;
}
add_shortcode('wpsm_cartbox', 'wpsm_cartbox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Score box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_scorebox_shortcode') ) {
function wpsm_scorebox_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'criterias' => 'editor',
			'simplestar' => '',
			'offerbtn' => 'yes',
			'id' => '',
			'title'=> '',
		), $atts));

	ob_start(); 
    ?>

	<?php if(isset($atts['id']) && $atts['id']) :?>		
		<?php $revid = $atts['id'];?>
	<?php else :?>   
		<?php if (!is_single() || is_front_page()) {return; } ?>
    	<?php $revid = get_the_ID();?>
    <?php endif ;?>  
	<?php if(isset($atts['title']) && $atts['title']) :?>		
		<?php $title = $atts['title'];?>
	<?php else :?>   
    	<?php $title = __('Total Score', 'rehub_framework');?>
    <?php endif ;?>


    <?php $args = array('no_found_rows' => 1,'p' => $revid); $query = new WP_Query($args);?>
    <?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>    
		<?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review') :?>
	    	<?php $overal_score = rehub_get_overall_score(); 
	    	if($overal_score !='0') :?>

	    	<div class="wpsm_score_box">

	    		<div class="wpsm_score_title">
	    			<span class="overall-text"><?php echo $title; ?></span>
	    			<span class="overall-score"><?php echo round($overal_score, 1) ?></span>
	    		</div>
	    		<div class="wpsm_inside_scorebox">
	    			<?php if ($simplestar == 'yes') :?><div class="rating_bar"><?php echo rehub_get_user_rate() ; ?></div><?php endif ;?>
		    		<?php if ($criterias == 'editor') :?>
		    			<?php $thecriteria = vp_metabox('rehub_post.review_post.0.review_post_criteria'); $firstcriteria = $thecriteria[0]['review_post_name']; ?>
			    		<?php if($firstcriteria) : ?>
			    		<div class="rate_bar_wrap">
							<div class="review-criteria">
								<?php foreach ($thecriteria as $criteria) { ?>
									<?php $perc_criteria = $criteria['review_post_score']*10; ?>
									<div class="rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
										<div class="rate-bar-title"><span><?php echo $criteria['review_post_name']; ?></span></div>
										<div class="rate-bar-bar r_score_<?php echo round($criteria['review_post_score']); ?>"></div>
										<div class="rate-bar-percent"><?php echo $criteria['review_post_score']; ?></div>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php endif; ?>
		    		<?php endif ;?>	
		    		<?php if ($criterias == 'user') :?>
		    			<?php $postAverage = get_post_meta(get_the_ID(), 'post_user_average', true); ?>
			    		<?php if($postAverage !='0' && $postAverage !='') : ?>
						<div class="rate_bar_wrap">	
							<?php $user_rates = get_post_meta(get_the_ID(), 'post_user_raitings', true); $usercriterias = $user_rates['criteria'];  ?>
							<div class="review-criteria user-review-criteria">
								<div class="r_criteria">
									<?php foreach ($usercriterias as $usercriteria) { ?>
									<?php $perc_criteria = $usercriteria['average']*10; ?>
									<div class="rate-bar user-rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
										<div class="rate-bar-title"><span><?php echo $usercriteria['name']; ?></span></div>
										<div class="rate-bar-bar r_score_<?php echo round($usercriteria['average']); ?>"></div>
										<div class="rate-bar-percent"><?php echo $usercriteria['average']; ?></div>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<?php endif; ?>
		    		<?php endif ;?>	    		
		    		<?php if ($offerbtn == 'yes') :?><div class="btn_score_btm"><?php rehub_create_btn('no')?></div><?php endif ;?>
	    		</div>
	    	</div>
	    	<?php endif;?>
	    <?php endif;?>
    <?php endwhile; endif; wp_reset_postdata(); ?>

    <?php 
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('wpsm_scorebox', 'wpsm_scorebox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Reveal shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_reveal_shortcode') ) {
function wpsm_reveal_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
		'textcode' => '',
		'btntext' => '',
		'url' => '',
	), $atts));
wp_enqueue_script('affegg_coupons');
wp_enqueue_script('zeroclipboard');

$output = '<div class="rehub_offer_coupon free_coupon_width masked_coupon" data-clipboard-text="'.rawurlencode(esc_html($textcode)).'" data-codetext="'.rawurlencode(esc_html($textcode)).'" data-dest="'.esc_url($url).'">';
if($btntext !='') :
	$output .=esc_html($btntext);
else :
	$output .= __('Reveal', 'rehub_framework');
endif;
	$output .='<i class="fa fa-external-link-square"></i></div>';
return $output;
}
add_shortcode('wpsm_reveal', 'wpsm_reveal_shortcode');
} 


//////////////////////////////////////////////////////////////////
// User login/register link with popup
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_user_modal') ) {
function wpsm_user_modal_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'wrap' => 'span',
	'as_btn' => '',
	'class' => '',
	'loginurl' => '',		
), $atts));
$as_button = (!empty($as_btn)) ? ' wpsm-button white medium ' : '';
$class_show = (!empty($class)) ? ' '.$class.'' : '';
$output='';
if (is_user_logged_in()) {
	global $current_user;
	$notice_bp_number = $notification_bp_item = '';
	$user_id  = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url  = rehub_option('userlogin_profile_page');
	$sumbit_url = rehub_option('userlogin_submit_page');
	$edit_url = rehub_option('userlogin_edit_page');
	$mycredpoint = ( function_exists( 'mycred_get_users_fcred' ) ) ? mycred_get_users_fcred($user_id) : '';    
	if ( class_exists( 'BuddyPress' ) ) {
		$notifications = bp_notifications_get_notifications_for_user($user_id, 'object');
		$notification_bp_item .='<li class="bp-profile-edit-menu-item menu-item"><a href="'.bp_core_get_user_domain( $user_id ).'"><i class="fa fa-cogs"></i></i><span>'. __("Edit Profile", "rehub_framework") .'</span></a></li>';		
		if (!empty($notifications)){
			$notice_bp_number = count($notifications);
			$notice_number = 0;
			foreach ((array)$notifications as $notification) {
				$notice_number ++;
				$notification_bp_item .= '<li id="bp-profile-menu-note-'.$notification->id.'" class="bp-profile-menu-item menu-item bppmi_'.$notice_number.' bp-profile-menu-'.$notification->component_action.'"><a href="'.$notification->href.'">'.$notification->content.'</a></li>';
			}			
		}
	}	

	$output .= '<div class="user-dropdown-intop'.$class_show.'">';
	if (!empty($notice_bp_number)){
		$output .='<span class="rh_bp_notice_profile">'.$notice_bp_number.'</span>';
	}
    $output .= '<span class="user-ava-intop">'.get_avatar( $user_id, 22 ).'</span>';
    $output .= '<ul class="user-dropdown-intop-menu">';
        $output .= '<li class="user-name-and-badges-intop"><span class="user-image-in-name">'.get_avatar( $user_id, 35 ).'</span>';
        $output .=$current_user->display_name;
        if (!empty($mycredpoint)){
        	$output .='<br /><i class="fa fa-star-o"></i> '.$mycredpoint.'';
        }
        $output .= '</li>';
        if ($profile_url) :
        	$output .= '<li class="user-profile-link-intop menu-item"><a href="'. esc_url(get_the_permalink($profile_url)) .'"><i class="fa fa-user"></i><span>'. __("My profile", "rehub_framework") .'</span></a></li>';
        endif;
        if ($sumbit_url) :
        	$output .= '<li class="user-addsome-link-intop menu-item"><a href="'. esc_url(get_the_permalink($sumbit_url)) .'"><i class="fa fa-cloud-upload"></i><span>'. __("Submit a Post", "rehub_framework") .'</span></a></li>';
        endif; 
        if ($edit_url) :
        	$output .= '<li class="user-editposts-link-intop menu-item"><a href="'. esc_url(get_the_permalink($edit_url)) .'"><i class="fa fa-pencil"></i><span>'. __("Edit My Posts", "rehub_framework") .'</span></a></li>';
        endif;  
        if (defined('wcv_plugin_dir')) :
		    if (class_exists('WCV_Vendors') && class_exists('WCVendors_Pro') && WCV_Vendors::is_vendor($user_id) ) {
		        $redirect_to = get_permalink(WCVendors_Pro::get_option( 'dashboard_page_id' ));
		    }
		    elseif (class_exists('WCV_Vendors') && WCV_Vendors::is_vendor($user_id) ) {
		    	$redirect_to = get_permalink(WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ));
		    }
        	if (!empty($redirect_to)){
	        	$output .= '<li class="user-editshop-link-intop menu-item"><a href="'. esc_url($redirect_to) .'"><i class="fa fa-shopping-bag" aria-hidden="true"></i><span>'. __("Manage Your Shop", "rehub_framework") .'</span></a></li>';        	
        	}
        endif;                            
        if(has_nav_menu('user_logged_in_menu')):
        	$output .= wp_nav_menu( array( 'theme_location' => 'user_logged_in_menu','menu_class' => '','container' => false,'depth' => 1,'items_wrap'=> '%3$s', 'echo' => false ) );
        endif;
        $output .=$notification_bp_item;
        $output .= '<li class="user-logout-link-intop menu-item"><a href="'. wp_logout_url( home_url() ) .'"><i class="fa fa-lock"></i><span>'. __("Log out", "rehub_framework") .'</span></a></li>';
$output .= '</ul></div>';
} else {
	if(get_option('users_can_register')) :
		if (empty ($loginurl)):
			if ($wrap =='a'):
				$output .= '<a class="act-rehub-login-popup menu-item-one-line'.$as_button.$class_show.'" data-type="login" href="#"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></a>';
			else:
				$output .= '<span class="act-rehub-login-popup'.$as_button.$class_show.'" data-type="login"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></span>';
			endif;
		else:
			$output .= '<a class="act-rehub-login-popup menu-item-one-line'.$as_button.$class_show.'" data-type="url" href="'.esc_url($loginurl).'"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></a>';
		endif;
	else:
		$output .= '<a class="act-rehub-login-popup'.$as_button.$class_show.'" data-type="restrict" href="#"><i class="fa fa-sign-in"></i><span>'.__("Login / Register is disabled", "rehub_framework").'</span></a>';
	endif;	
	
}

return $output;

}
add_shortcode('wpsm_user_modal', 'wpsm_user_modal_shortcode');
}

//////////////////////////////////////////////////////////////////
// Search form
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_searchform') ) {
function wpsm_searchform_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'class' => '',		
), $atts));

return '<div class="'.$class.'">'.get_search_form(false).'</div>';

}
add_shortcode('wpsm_searchform', 'wpsm_searchform_shortcode');
}

//////////////////////////////////////////////////////////////////
// Link hide
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_hidelink_shortcode') ) {
function wpsm_hidelink_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'text' => 'Click here',
			'link' => '',
	), $atts));

	$output = '<span class="ext-source" data-dest="'.$link.'">'.$text.'</span>';
	return $output;
}
add_shortcode('wpsm_hidelink', 'wpsm_hidelink_shortcode');
}


//////////////////////////////////////////////////////////////////
// Compare Buttons
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_comparison_button') ) {
function wpsm_comparison_button( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'color' => 'white',
				'size' => 'small',
				'cats' => '',
				'class' => ''
			), $atts);
	$postid = get_the_ID();  
	if (isset ($atts['cats']) && !empty($atts['cats'])) : //Check if button is not in category
		$cats_array = explode (',', $atts['cats']);
		if (!in_category ($cats_array)) return;
	endif;     
    $class_show = (!empty($atts['class'])) ? ' '.$atts['class'].'' : '';
	$ip = rehub_get_ip();
	$userid = get_current_user_id();
	$userid = empty($userid) ? $ip : $userid;
	$option = get_transient('re_compare_' . $userid);
	$arr = '';
	if(!empty($option)) {
		$arr = explode(',',$option);
	}
	if( !is_array( $arr ) ) // make array just in case
		$arr = array();			
	$compare_active = ( in_array( $postid, $arr ) ) ? ' comparing' : ' not-incompare';
	$out = '<span';   
    $out .=' class="wpsm-button wpsm-button-compare addcompare-id-'.$postid.' '.$atts['color'].' '.$atts['size'].''.$compare_active.$class_show.'" data-addcompare-id="'.get_the_ID().'"><i class="fa re-icon-compare"></i>'.__("Add to compare", "rehub_framework").'</span>';
    return $out;
}
add_shortcode('wpsm_compare_button', 'wpsm_comparison_button');
}

//////////////////////////////////////////////////////////////////
// Icecat shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_icecat_shortcode') ) {
function wpsm_icecat_shortcode( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'ean' => '',
				'language' => '',
				'username' => 'openIcecat-xml',
				'password' => 'freeaccess'
			), $atts);
    $data = array();
    $data['language'] = (!empty($atts['language'])) ? $atts['language'] : substr(get_locale(), 0, 2);
    $data['username'] = (!empty($atts['username'])) ? $atts['username'] : 'openIcecat-xml';
    $data['password'] = (!empty($atts['password'])) ? $atts['password'] : 'freeaccess';    
    $out = '';

    if (isset($atts['ean']) && $atts['ean']!='') :
        $data['ean'] = $atts['ean'];
        include(locate_template('functions/icecat.php'));
        $data = icecat_to_array($data); 
    	if(!isset($data['id'])) :
            if(isset($data[1])) :
                $out .= '<div style="display:none">Error: '.$data[1].'</div>';
         
            elseif(isset($data[2])) :
                $out .= '<div style="display:none">Error: '.$data[2].'</div>';
            elseif(isset($data[3])) :
                $out .= '<div style="display:none">Error: '.$data[3].'</div>';
            endif;
    	else :
        	$out .='<div class="wpsm-table wpsm-icecat-spec">';       
	            $out .='<table>';
	                foreach($data['spec'] as $id=>$s):
	                    $out .='<tr class="heading-th-spec">';
	                        $out .='<th colspan="2">'.$s['name'].'</th>';
	                    $out .='</tr>';
	                    	$i = 0;
	                    	foreach($s['features'] as $id=>$f):
	                    	$i++; $odd = ($i % 2 == 1) ? ' class="odd"' : '';
	                        $out .='<tr'.$odd.'>';
	                            $out .='<td>'.$f['name'].'</td>';
	                            $out .='<td>'.$f['pres_value'].'</td>';
	                        $out .='</tr>';
	                    	endforeach;
	                endforeach;
	            $out .='</table>'; 
        	$out .='</div>';                    
    	endif;            
    endif;   
    return $out;
}
add_shortcode('wpsm_icecat', 'wpsm_icecat_shortcode');
}

//////////////////////////////////////////////////////////////////
// Login form shortcode
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_login_page')) {
function wpsm_login_page( $atts, $content = null ) {
	ob_start(); 
	rehub_login_form();
	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
}
add_shortcode('wpsm_login_form', 'wpsm_login_page');
}

//////////////////////////////////////////////////////////////////
// Get custom value shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_get_custom_value') ) {
function wpsm_get_custom_value($atts){
     extract(shortcode_atts(array(
                  'post_id' => NULL,
                  'field' => NULL,
               ), $atts));
  if(!isset($atts['field'])) return;
       $field = esc_attr($atts['field']);
       global $post;
       $post_id = (NULL === $post_id) ? $post->ID : $post_id;
       return get_post_meta($post_id, $field, true);
}
add_shortcode('wpsm_custom_meta', 'wpsm_get_custom_value');
}

//////////////////////////////////////////////////////////////////
// Alphabet Catalog Shortcode
//////////////////////////////////////////////////////////////////
function wpsm_tax_archive_shortcode( $atts, $content = null ) {

	// Attributes

	extract( shortcode_atts(
		array(
			'type' => 'alpha',
			'taxonomy' => 'store',
			'show_images' => 1,
		), $atts, 'wpsm_tax_archive' )
	);


		
	$args = array( 'hide_empty' => false, 'order' => 'ASC', 'taxonomy'=> $taxonomy);
	 
	$terms = get_terms($args );

	$letter_keyed_terms = array();

	$term_letter_links = '';
	$term_titles = '';

	if($type == 'alpha') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$first_letter = mb_substr( $term->name, 0, 1, 'UTF-8' );
				
				if( is_numeric( $first_letter ) ) {
					$first_letter = '0-9';
				} else {
					$first_letter = mb_strtoupper( $first_letter, 'UTF-8' );
				}
				
				if ( !array_key_exists( $first_letter, $letter_keyed_terms ) ) {
					$letter_keyed_terms[ $first_letter ] = array();
				}
				
				$letter_keyed_terms[ $first_letter ][] = $term;
			}
			
			foreach( $letter_keyed_terms as $letter => $terms ) {
				$term_letter_links .= '<li><a href="#'.$letter.'" class="rehub_scroll">'.$letter.'</a></li>';

				$term_titles .= '<div class="single-letter"><a href="#" name="'.$letter.'"></a><div class="letter_tag">'.$letter.'<div class="return_to_letters"><span class="rehub_scroll" data-scrollto="#top_ankor"><i class="fa fa-angle-up"></i></span></div></div></div> <!-- single-letter -->';
				$term_titles .= '<div class="tax-wrap">';
										
				foreach( $terms as $term ) {

					$thumbnail = $thumbnail_url = '';
					
					if ( $taxonomy == 'product_tag' && $show_images == 1 ) {
						  	$term_tag_array = get_option( 'taxonomy_term_'. $term->term_id ); 
						  	if (!empty ($term_tag_array['brand_image'])) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $term_tag_array['brand_image'];
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}
					elseif ( $taxonomy == 'store' && $show_images == 1 ) {
							$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
						  	if (!empty ($brandimage)) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $brandimage;
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}
					elseif ( $taxonomy == 'dealstore' && $show_images == 1 ) {
							$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
						  	if (!empty ($brandimage)) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $brandimage;
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}					
					
					$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="single-letter-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '">' . $thumbnail . '<h5>'. $term->name . '</h5></a></div>';
				}
				
				$term_titles .= '</div>';		
			}
		}
		
		return	'<div class="alphabet-filter">
						<div class="head-wrapper clearfix">
							<ul class="list-inline">
								'. $term_letter_links .'
							</ul>
						</div>
						<div class="body-wrapper clearfix">
								'. $term_titles .'
						</div>
					</div>';		
	}
	elseif ($type == 'compact') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="mini-tax-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '"><h5>'. $term->name . '</h5></a></div>';
			}
			return '<div class="alphabet-filter">'.$term_titles.'</div>';	
		}
	}
	elseif ($type == 'logo') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$thumbnail = $thumbnail_url = '';
				
				if ( $taxonomy == 'product_tag' && $show_images == 1 ) {
					  	$term_tag_array = get_option( 'taxonomy_term_'. $term->term_id ); 
					  	if (!empty ($term_tag_array['brand_image'])) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $term_tag_array['brand_image'];
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				elseif ( $taxonomy == 'store' && $show_images == 1 ) {
						$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
					  	if (!empty ($brandimage)) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $brandimage;
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				elseif ( $taxonomy == 'dealstore' && $show_images == 1 ) {
						$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
					  	if (!empty ($brandimage)) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $brandimage;
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				if ($thumbnail){
					$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="logo-tax-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '">'. $thumbnail . '</a></div>';					
				}
			}
			return '<div class="alphabet-filter">'.$term_titles.'</div>';	
		}
	}	

}
add_shortcode( 'wpsm_tax_archive', 'wpsm_tax_archive_shortcode' );


//////////////////////////////////////////////////////////////////
// USER REVIEWS BASED ON FULL REVIEWS
//////////////////////////////////////////////////////////////////
if( !function_exists('re_user_rating_shortcode') ) {
function re_user_rating_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts(
	array(
		'size' => 'big',
	), $atts);

    $postAverage = get_post_meta(get_the_ID(), 'post_user_average', true);
    if(!empty($postAverage)){
    	$starscore = $postAverage*10 ;
    	$output = '<div class="star-'.$atts['size'].'"><span class="stars-rate"><span style="width: '.$starscore.'%;"></span></span></div>';
    	return $output;
    }
}
add_shortcode('wpsm_user_rating_stars', 're_user_rating_shortcode');
}

//////////////////////////////////////////////////////////////////
// UPDATE BLOCK
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_update_shortcode') ) {
function wpsm_update_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts(
	array(
		'date' => '',
		'label' => '',
	), $atts);
	$date = (!empty($atts['date'])) ? ' - '.$atts['date'].'' : '';
	$label = (!empty($atts['label'])) ? $atts['label'] : __('Update', 'rehub_framework');
	$content = do_shortcode($content);	
	$output = '<div class="wpsm_update"><span class="label-info">'.$label.$date.'</span>'.$content.'</div>';
	return $output;
}
add_shortcode('wpsm_update', 'wpsm_update_shortcode');
}


//////////////////////////////////////////////////////////////////
// SPECIFICATION BUILDER
//////////////////////////////////////////////////////////////////
if ( !function_exists( 'wpsm_spec_builders_shortcode' ) ) {
	function wpsm_spec_builders_shortcode( $atts, $content = null ) {
		
		extract(shortcode_atts( array(
				'id' => '',
				'postid' => '',
			), $atts));
			
		if( !empty($id) ) :

			$rows = get_post_meta( $id, '_wpsm_spec_line', true );
			if(empty($rows)) return;

			ob_start(); 
			?>

                <?php 
                	$postID = (!empty($postid)) ? $postid : get_the_ID();
                    $pbid=0;                       
                    foreach ($rows as $row) {
                    echo '<div class="wpsm_spec_row_'.$id.'_'.$pbid.'">';                       
                    $element = $row['column_type'];
                        if ($element == 'heading_line') {
                            include(locate_template('inc/specification/heading_line.php'));
                        } else if ($element == 'meta_line') {
                            include(locate_template('inc/specification/meta_line.php'));                          
                        } else if ($element == 'divider_line') {
                            include(locate_template('inc/specification/divider_line.php'));                            
                        } else if ($element == 'tax_line') {
                            include(locate_template('inc/specification/tax_line.php'));                            
                        } else if ($element == 'shortcode_line') {
                            include(locate_template('inc/specification/shortcode_line.php')); 
                        } else if ($element == 'photo_line') {
                            include(locate_template('inc/specification/photo_line.php'));
                        } else if ($element == 'video_line') {
                            include(locate_template('inc/specification/video_line.php'));
                        } else if ($element == 'mdtf_line') {
                            include(locate_template('inc/specification/mdtf_line.php'));   
                        } else if ($element == 'proscons_line') {
                            include(locate_template('inc/specification/proscons_line.php'));  
                        } else if ($element == 'map_line') {
                            include(locate_template('inc/specification/map_line.php'));
                        } else {
                            
                        };
                    echo '</div>';
                    $pbid++;
                    } 
                ?>

			<?php 
			$output = ob_get_contents();
			ob_end_clean();
			return $output;   
		endif;	

	}
add_shortcode( 'wpsm_specification_builder', 'wpsm_spec_builders_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Category box
//////////////////////////////////////////////////////////////////
if ( !function_exists('wpsm_catbox_shortcode') ) {
function wpsm_catbox_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
			'category' => '', // one ID
			'title' => '', // if empty - original title
			'link' => '0', // 1 or 0
			'image' => '', // URL or post_id in media library
			'size_img' => '' // % or px ('width' or 'width height')
		), $atts ) );

	if ( empty( $category ) || $category == 0 )
		return;

	$term = get_term( (int) $category );
	
 	if ( is_wp_error( $term ) ) {
		$error_string = $term->get_error_message();
		return '<div id="message" class="error"><p><b>Error</b>: Category ID '. $category .' - '. $error_string .'</p></div>';
 	}

	if ( is_numeric( $image ) ) 
		$image = wp_get_attachment_url( $image );
	
	$bg_size = ( $size_img ) ? ' background-size:'. $size_img .'; height:'. $size_img .'' : '';
	
	// HTML output
	$output = '<div class="rh-cartbox catbox mb20">';
		
	if ( $image )
		$output .= '<div class="categoriesbox-bg" style="background-image:url('. $image .');'. $bg_size .'">';	
			if ( $link == 1 )
				$output .= '<a href="'. get_term_link( $term->term_id ) .'" rel="nofollow"></a>';
		$output .= '</div>';	

		$output .='<div class="catbox-content r_offer_details">';
		
		$title = ( $title && $title !='' ) ? $title : $term->name;
			
			if ( $link == 1 ) {
				$output .= '<h3><a href="'. get_term_link( $term->term_id ) .'">'. $title .'</a></h3>';
			} else {
				$output .= '<h3>'. $title .'</h3>';
			}
			
			$termchildren = get_terms( array(
				'taxonomy' => $term->taxonomy,
				'orderby' => 'name',
				'hide_empty' => true,
				'child_of' => $term->term_id
			) );
			
			if ( is_wp_error( $termchildren ) ) {
				$error_string = $termchildren->get_error_message();
				return '<div id="message" class="error"><p><b>Error</b>: Category ID '. $category .' - '. $error_string .'</p></div>';
			}

			
			$term_count = count( $termchildren ); 
			if($term_count > 0) {
				$output .= '<ul class="catbox-child-list">';
				$i = 0;
				foreach ( $termchildren as $termchild ) {

					if ( $i == 5 )
						$output .= '<div class="open_dls_onclk">';
					$output .= '<li><a href="'. get_term_link( (int) $termchild->term_id ) .'">'. $termchild->name .'</a> ('. (int) $termchild->count .')</li>';
					
					if ( $i == $term_count )
						$output .= '</div>';
					$i++;
				}
				$output .= '</ul>';
			}

			
			if ( $term_count > 5 )
				$output .= '<span class="r_show_hide r_catbox_btn">'.__('See all', 'rehub_framework').'</span>';
			
		$output .= '</div>';

	$output .= '</div>';

	return $output;
}
add_shortcode('wpsm_catbox', 'wpsm_catbox_shortcode');
}

if (!function_exists('rh_wcv_vendorslist_flat')) {
function rh_wcv_vendorslist_flat( $atts ) {

		$html = ''; 
		
	  	extract( shortcode_atts( array(
	  			'orderby' 		=> 'registered',
	  			'order'			=> 'ASC',
				'per_page'      => '12',
				'show_products'	=> 'yes',
				'user_id'=>'' 
			), $atts ) );

	  	$paged      = ( get_query_var('paged') ) ? get_query_var('paged') : 1;   
	  	$offset     = ( $paged - 1 ) * $per_page;

	  	// Hook into the user query to modify the query to return users that have at least one product 
	  	if ($show_products == 'yes') add_action( 'pre_user_query', 'rh_vendors_with_products' );

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
	  	$all_vendors =$vendor_query->get_results(); 

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

	  	if ($user_id){
	  		$user_ids = array_map( 'trim', explode( ",", $user_id ) );
		  	$vendor_paged_args = array ( 
		  		'role' 				=> 'vendor', 
		  		'meta_key' 			=> 'pv_shop_slug', 
	  			'meta_value'   		=> '',
				'meta_compare' 		=> '>',
				'include' 			=> $user_ids,
		  	);	  		
	  	}	  	

	  	$vendor_paged_query = New WP_User_Query( $vendor_paged_args ); 
	  	$paged_vendors = $vendor_paged_query->get_results(); 

	  	// Pagination calcs 
		$total_vendors = count( $all_vendors );  
		$total_vendors_paged = count($paged_vendors);  
		$total_pages = ceil( $total_vendors / $per_page );
	    
	   	ob_start();

	    // Loop through all vendors and output a simple link to their vendor pages
	    foreach ($paged_vendors as $vendor) {
	    	$shop_link = WCV_Vendors::get_vendor_shop_page($vendor->ID);
	    	$shop_name = $vendor->pv_shop_name;
	    	$vendor_id= $vendor->ID;
	    	//$shop_description = $vendor->pv_shop_description;
	    	if ( class_exists( 'WCVendors_Pro' ) ) {
	    		$vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $vendor->ID ) );
	    	}
	    	include(locate_template('inc/wcvendor/vendorlist.php'));

	    } // End foreach 
	   	
	   	$html .= '<div class="rh_vendors_listflat">' . ob_get_clean() . '</div>';

	    if ($total_vendors > $total_vendors_paged) {  
			$html .= '<nav class="woocommerce-pagination">';  
			  $current_page = max( 1, get_query_var('paged') );  
			  $html .= paginate_links( 	array(  
			        'base' => get_pagenum_link( ) . '%_%',  
			        'format' => 'page/%#%/',  
			        'current' => $current_page,  
			        'total' => $total_pages,  
			        'prev_next'    => false,  
			        'type'         => 'list',  
			    ));  
			$html .= '</nav>'; 
		}

	    return $html; 
	}
add_shortcode('wpsm_vendorlist', 'rh_wcv_vendorslist_flat');
}

if (!function_exists('rh_vendors_with_products')) {
function rh_vendors_with_products( $query ) {
	global $wpdb; 
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
}

//GMW SHORTCODE MAP
function rh_add_map_gmw($atts, $content = null ) {
	extract( shortcode_atts( array(
			'user_id' => '', // one ID
		), $atts ) );	
	if ( class_exists( 'GMW_Members_Locator_Component' ) ) {
		include (locate_template( 'geo-my-wp/customform/gmw-fl-location-tab.php' ));
		$user_id = (!empty($user_id)) ? $user_id : get_current_user_id();
		if (is_user_logged_in()){
			ob_start(); 
			$mapform = new RH_GMW_FL_Location_Page($user_id);
			echo '<div id="buddypress">';
			$mapform->display_location_form( $mapform->location, $user_id );
			echo '</div>';
			$output = ob_get_contents();
			ob_end_clean();
			return $output; 
		}else{
			ob_start(); 
			_e('Please, login to set location', 'rehub_framework');
			$output = ob_get_contents();
			ob_end_clean();
			return $output;		
		}		
	}
}
add_shortcode('rh_add_map_gmw', 'rh_add_map_gmw');


//VC SHORTCODES
include ( get_template_directory() . '/shortcodes/module_shortcodes.php'); 