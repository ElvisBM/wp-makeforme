<?php
/*
  Name: Slider
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php  wp_enqueue_script('flexslider'); ?>

<div class="post_slider media_slider blog_slider egg_cart_slider loading">
    <ul class="slides">        
        <?php foreach ($items as $item): ?>
        <?php $afflink = $item['url'] ;?>
        <?php $aff_thumb = $item['img'] ;?>
        <?php $offer_title = wp_trim_words( $item['title'], 20, '...' ); ?>
        <?php $time_left = TemplateHelper::getTimeLeft($item['extra']['listingInfo']['endTimeGmt']); ?>  
        <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy this item', 'rehub_framework') ;?><?php endif ;?>   
        <li>
            <div class="col_wrap_two">
                <div class="product_egg">

                    <div class="image col_item">
                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($afflink) ?>">
                            <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $aff_thumb, 'width'=> 500, 'title' => $offer_title, 'no_thumb_url' => get_template_directory_uri().'/images/default/noim_gray.png'));?> 
                            <?php if(!empty($item['percentageSaved'])) : ?>
                                <span class="sale_a_proc">
                                    <?php    
                                        echo '-'; echo $item['percentageSaved']; echo '%';
                                    ;?>
                                </span>
                            <?php endif ;?>                                   
                        </a>               
                    </div>

                    <div class="product-summary col_item">
                    
                        <h2 class="product_title entry-title">
                            <?php echo esc_attr($offer_title); ?> 
                            <?php if ($item['extra']['listingInfo']['bestOfferEnabled'] == true): ?>
                                <span class="best_offer_badge"><?php _e('Best offer', 'rehub_framework') ?></span> 
                            <?php endif; ?>
                        </h2>  
                        <?php if ($item['extra']['sellingStatus']['bidCount'] !== ''): ?>
                            <div class="bids_ce"><?php _e('Bids:', 'rehub_framework'); ?> <?php echo $item['extra']['sellingStatus']['bidCount'] ?></div>
                        <?php endif; ?>                
                        <small class="small_size"> 
                            <?php if ($time_left): ?>
                                <span class="time_left_ce yes_available">
                                    <i class="fa fa-clock-o"></i> <?php _e('Time left:', 'rehub_framework'); ?>
                                    <span <?php if (strstr($time_left, __('m', 'content-egg-tpl'))) echo 'class="text-danger"'; ?>><?php echo $time_left; ?></span>
                                </span>
                                <br />
                            <?php else: ?>
                                <span class="time_left_ce">
                                    <span class='text-warning'>
                                        <?php _e('Ended:', 'rehub_framework'); ?>
                                        <?php echo date('M j, H:i', strtotime($item['extra']['listingInfo']['endTime'])); ?> <?php echo $item['extra']['listingInfo']['timeZone']; ?>
                                    </span>
                                </span>
                                <br />
                            <?php endif; ?>                               
                            <?php if ($item['extra']['conditionDisplayName']): ?>
                                <?php _e('Condition: ', 'rehub_framework') ;?><span><?php echo $item['extra']['conditionDisplayName'] ;?></span>
                                <br />
                            <?php endif; ?>  
                            <?php if ($item['extra']['eekStatus']): ?>
                                <span class="muted"><?php _e('EEK:', 'content-egg-tpl'); ?> <?php _p($item['extra']['eekStatus']); ?></span>
                            <?php endif; ?>                                                                                  
                        </small>                                   

                        <?php if(!empty($item['price'])) : ?>
                            <div class="deal-box-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                <sup class="cur_sign"><?php echo $item['currency']; ?></sup><?php echo TemplateHelper::price_format_i18n($item['price']); ?>
                                <?php if(!empty($item['priceOld'])) : ?>
                                <span class="retail-old">
                                  <strike><span class="value"><?php echo TemplateHelper::price_format_i18n($item['priceOld']); ?></span></strike>
                                </span>
                                <?php endif ;?>                
                                <meta itemprop="price" content="<?php echo $item['price'] ?>">
                                <meta itemprop="priceCurrency" content="<?php echo $item['currencyCode']; ?>">                       
                            </div>                
                        <?php endif ;?>
                        <div class="buttons_col">
                            <div class="priced_block clearfix">
                                <div>
                                    <a class="re_track_btn btn_offer_block" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
                                        <?php echo $btn_txt ; ?>
                                        <span class="aff_tag mtinside"><?php echo rehub_get_site_favicon('http://ebay.com'); ?></span>
                                    </a>                                                
                                </div>
                            </div>
                        </div>                
                        <?php if ($item['description']): ?>
                            <p><?php echo $item['description']; ?></p>                     
                        <?php endif; ?>              
                    </div>           
                </div>
            </div>  
        </li>
        <?php endforeach; ?>                   
    </ul>
</div>