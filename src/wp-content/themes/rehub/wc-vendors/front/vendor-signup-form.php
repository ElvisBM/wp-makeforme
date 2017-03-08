<?php
/**
 * The template for displaying the vendor application form 
 *
 * Override this template by copying it to yourtheme/wc-vendors/front
 *
 * @package    WCVendors_Pro
 * @version    1.3.2
 */
?>
<!-- Modal -->
<form method="post" action="" class="wcv-form wcv-formvalidator signupmaker"> 

	<h3><?php _e( 'Vendor Application', 'wcvendors-pro'); ?></h3>
	<p>Preencha todos os campos abaixo, para que possamos validar sua loja e possa se tornar um Maker. </p>
	<p>Caso tenha alguma dúvida <a href="#" data-toggle="modal" data-target="#modal">clique aqui</a> e saiba um pouco mais sobre esse processo.</p>

	<?php WCVendors_Pro_Store_Form::sign_up_form_data(); ?>

	

	<div class="wcv-signupnotice"> 
		<?php echo $vendor_signup_notice; ?>
	</div>

	<br />
<?php WCVendors_Pro_Store_Form::form_data(); ?>

<div class="wcv-tabs top" data-prevent-url-change="true">

	<?php WCVendors_Pro_Store_Form::store_form_tabs( ); ?>

	<!-- Store Settings Form -->
	
	<div class="tabs-content" id="store">
		<h3>Dados da Loja</h3>

		<div class="wcv-cols-group">
			<div class="all-70 tiny-100">
				<!-- Store Name -->
				<?php WCVendors_Pro_Store_Form::store_name( $store_name ); ?>
				<?php do_action( 'wcvendors_settings_after_paypalr_shop_name' ); ?>
				
				<!-- Company URL -->
				<?php do_action( 'wcvendors_settings_before_company_url' ); ?>
				<?php WCVendors_Pro_Store_Form::company_url( ); ?>
				<?php do_action(  'wcvendors_settings_after_company_url' ); ?>	

				<!-- Store Phone -->
				<?php do_action( 'wcvendors_settings_before_store_phone' ); ?>
				<?php WCVendors_Pro_Store_Form::store_phone( ); ?>
				<?php do_action(  'wcvendors_settings_after_store_phone' ); ?>

				<!-- Store Description -->
				<?php WCVendors_Pro_Store_Form::store_description( $store_description ); ?>	
				<?php do_action( 'wcvendors_settings_after_shop_description' ); ?>
				<br />
				<div class="termos-contrato">
						<!-- Terms and Conditions -->
						<?php WCVendors_Pro_Store_Form::vendor_terms(); ?> 
				</div>
			</div>
			<div class="all-30 tiny-100">
				<div class="">
					<p>Por favor, anexe os documentos pois é necessário para a ativação da loja, fiquem tranquilo pois nenhum documento será divulgado, servirá apenas para segurança e conforto dos Makers e nosso usúarios Compradores.</p>
				</div>
				<div class="control-group uploads-files">
					<label>Imagem do CPF ou CNPJ<small>Obrigátorio</small></label>
					<div class="control">
						<p>Formato: JPEG ou PNG, Tamanho: Até 4mb</p>
						<?php upload_cpf_cnpj_maker(); ?>
					</div>
				</div>

				<div class="control-group uploads-files">
					<label>Imagem do Comprovante de Residência<small>Obrigátorio</small></label>
					<div class="control">
						<p>Formato: JPEG ou PNG, Tamanho: Até 4mb</p>
						<?php upload_comprovante_residencia_maker(); ?>
					</div>
				</div>
				<div class="logo">
					<!-- Store Icon -->
					<?php WCVendors_Pro_Store_Form::store_icon( ); ?>	
					<p>Clique na imagem para altera-la<br />
						Largura, Altura: 180x180<br />
						Formato: JPEG ou PNG<br />
						Tamanho:  Até 4mb
					</p>
				</div>
			</div>
		</div>
		
		<a class="btn btn-avancar js-avancar" href="#branding">Avançar</a>
	</div>

	<div class="tabs-content" id="payment">
		<!-- Paypal address -->
		<?php do_action( 'wcvendors_settings_before_paypal' ); ?>

		<?php //WCVendors_Pro_Store_Form::paypal_address( ); ?>

		<?php do_action( 'wcvendors_settings_after_paypal' ); ?>
		<a class="btn btn-avancar js-avancar" href="#social">Avançar</a>
	</div>

	<div class="tabs-content" id="branding">
		<div class="wcv-cols-group">
			<div class="all-30 tiny-100">
				<h3>Banner da Loja</h3>
				<p>Use sua criatividade para criar um banner com a cara da sua loja</p><br ><br >
				<p>Especificações<br>
				Largura, Altura: 1200x260<br>
				Tamanho: até 4mb<br>
				Formato: JPEG ou PNG </p><br ><br >
			</div>
			<div class="all-70 tiny-100">
					<?php do_action( 'wcvendors_settings_before_branding' ); ?>
					<!-- Store Banner -->
					<?php WCVendors_Pro_Store_Form::store_banner( ); ?>	
					<?php do_action( 'wcvendors_settings_after_branding' ); ?>
			</div>
		</div>
		<a class="btn btn-avancar js-avancar" href="#adress">Avançar</a>
	</div>

	<div class="tabs-content" id="shipping">
		<h3> Entrega</h3>
		<p>
			Defina a taxa de entrega para as localidades que atende. Se o "For Me/Comprador" estiver em uma localidade não definida por suas regras de entrega, ele terá a opção de retirar em sua loja.<br />
			Campos obrigátorios: Estado, Cidade e Taxa de Entrega. <br />
			Caso atenda apenas um bairro específico, verifique nós correio o nome exato dele e preencha o campo bairro.<br />
			<span>Exemplo de preenchimento da taxa: digite 12.50 para R$12,50 de taxa de entrega.</span>
		</p>	

		
		<div id="adress_base" class="wcv-cols-group">
			<!-- Store Address -->	
			<?php do_action( 'wcvendors_settings_before_address' ); ?>
			<div class="cep">
				<?php WCVendors_Pro_Store_Form::store_address_postcode(); ?>
			</div>
			<div class="endereco">
			<?php WCVendors_Pro_Store_Form::store_address1( ); ?>
			</div>
			<div class="cidade all-50 tiny-100">
				<?php WCVendors_Pro_Store_Form::store_address_city( ); ?>
			</div>
			<div class="estado all-50 tiny-100">
				<?php WCVendors_Pro_Store_Form::store_address_state( ); ?>
			</div>
			<?php do_action(  'wcvendors_settings_after_address' ); ?>
		</div>

	
		
		<h4>Locais de entrega:</h4>
		<?php //do_action( 'wcvendors_settings_before_shipping' ); ?>

		<!-- Shipping Rates -->
		<?php WCVendors_Pro_Store_Form::shipping_rates( ); ?>

		<?php //do_action( 'wcvendors_settings_after_shipping' ); ?>

		<!-- Shiping Information  -->

		<?php //WCVendors_Pro_Store_Form::product_handling_fee( $shipping_details ); ?>
		<?php //WCVendors_Pro_Store_Form::shipping_policy( $shipping_details ); ?>
		<?php //WCVendors_Pro_Store_Form::return_policy( $shipping_details ); ?>
		<?php //WCVendors_Pro_Store_Form::shipping_from( $shipping_details ); ?>
		<?php //WCVendors_Pro_Store_Form::shipping_address( $shipping_details ); ?>
		<a class="btn btn-avancar js-avancar" href="#payment">Avançar</a>
		
	</div>


	<div class="tabs-content" id="social">
		<h3>Redes Sociais da Loja</h3>
		<?php do_action( 'wcvendors_settings_before_social' ); ?>
		<!-- Twitter -->
		<?php WCVendors_Pro_Store_Form::twitter_username( ); ?>
		<!-- Instagram -->
		<?php WCVendors_Pro_Store_Form::instagram_username( ); ?>
		<!-- Facebook -->
		<?php WCVendors_Pro_Store_Form::facebook_url( ); ?>
		<!-- Linked in -->
		<?php WCVendors_Pro_Store_Form::linkedin_url( ); ?>
		<!-- Youtube URL -->
		<?php WCVendors_Pro_Store_Form::youtube_url( ); ?>
		<!-- Pinterest URL -->
		<?php WCVendors_Pro_Store_Form::pinterest_url( ); ?>
		<!-- Google+ URL -->
		<?php WCVendors_Pro_Store_Form::googleplus_url( ); ?>
		<!-- Snapchat -->
		<?php WCVendors_Pro_Store_Form::snapchat_username( ); ?>
		<?php do_action(  'wcvendors_settings_after_social' ); ?>

			<!-- Submit Button -->
			<!-- DO NOT REMOVE THE FOLLOWING TWO LINES -->
			<?php WCVendors_Pro_Store_Form::save_button( __( 'Apply to be Vendor', 'wcvendors-pro') ); ?>

	</div>
	


	</form>

	<div class="tabs-content" id="adress">
		<h3>Endereço</h3>
		<p>Clique em "Editar localização" para preencher o formulário ou preencher no mapa seu endereço.</p>

		<?php if ( class_exists( 'GMW_Members_Locator_Component' ) ) {echo do_shortcode('[rh_add_map_gmw]');echo '<div class="mb25"></div>';}?>
		<a class="btn btn-avancar js-avancar" href="#shipping">Avançar</a>
	</div>

</div>
<?php 
	//Get Post Quero ser um Maker;
	$post = get_post( 5890 ); 
	$title = $title = $post->post_title;
	$content = apply_filters('the_content', $post->post_content); 

?>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
      </div>
      <div class="modal-body">
			<?php echo $content; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


