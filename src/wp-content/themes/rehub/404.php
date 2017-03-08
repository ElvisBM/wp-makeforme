<?php get_header(); ?>
<!-- CONTENT -->
<div class="content"> 
    <div class="clearfix">
          <!-- Main Side -->
          <div class="main-side clearfix">
            <div class="post errorpage">				
                <span class="error-text"><?php _e('Desculpe, não encontramos o que procurava.', 'rehub_framework'); ?></span>
                <h2>404</h2>
                <span class="error-text"><?php _e('Use nosso campo de busca, que encontramos a gostosura que deseja :)', 'rehub_framework'); ?></span>
                <div class="clearfix"></div>
                <?php get_search_form(); ?>			
            </div>	
        </div>	
        <!-- /Main Side -->
        <!-- Sidebar -->
        <?php get_sidebar(); ?>
        <!-- /Sidebar --> 
    </div>
</div>
<!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>