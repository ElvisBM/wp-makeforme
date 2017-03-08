<?php

    /* Template Name: Page Gostosuras */

?>
<?php get_header(); ?>
    <!-- CONTENT -->
    <div class="content"> 
        <?php if(rehub_option('rehub_featured_toggle') && is_front_page() && !is_paged()) : ?>
            <?php get_template_part('inc/parts/featured'); ?>
        <?php endif; ?>
	    <?php if(rehub_option('rehub_homecarousel_toggle') && is_front_page() && !is_paged()) : ?>
	        <?php get_template_part('inc/parts/home_carousel'); ?>
	    <?php endif; ?> 
		<div class="clearfix">
		      <!-- Main Side -->
              <div class="main-side page clearfix full_width">
                <article class="post" id="page-<?php the_ID(); ?>">
                <h3 class="title"><?php the_title(); ?></h3>				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                  <?php the_content(); ?>
                  <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'rehub_framework' ), 'after' => '</div>' ) ); ?>
                <?php endwhile; endif; ?>                 
                </article>
			</div>	
            <!-- /Main Side -->  
        </div>
    </div>
    <!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>