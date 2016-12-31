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
}

add_action( 'widgets_init', 'makeforme_register_sidebars' );