<?php

/**
 * Stpre Tabs 
 *
 * This file is used to output the store tabs on settings and signup page  
 *
 * @link       http://www.wcvendors.com
 * @since      1.2.0
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/public/partials/product
 */ 
?>

<ul class="<?php echo $css_class; ?>" style="padding:0; margin:0;">
	<?php 
		/* foreach ( $store_tabs as $tab ) : 
	   	 <li><a class="tabs-tab <?php echo implode( ' ' , $tab[ 'class' ] ); ?> <?php echo $tab[ 'target' ]; ?>" href="#<?php echo $tab[ 'target' ]; ?>"><?php echo $tab[ 'label' ]; ?></a></li>
		endforeach; 
		*/ 
	?>  
	<li><a class="tabs-tab store" href="#store">Dados da loja</a></li>
	<li><a class="tabs-tab branding" href="#branding">Banner</a></li>
	<li><a class="tabs-tab adress" href="#adress">Endereço</a></li>
	<li><a class="tabs-tab shipping" href="#shipping">Entrega</a></li>
	<li><a class="tabs-tab payment" href="#payment">Dados Bancários</a></li>
	<li><a class="tabs-tab social" href="#social">Redes</a></li>
	<li><a class="gerenciar-loja-js" href="..">Gerenciar Loja</a></li>
</ul>

