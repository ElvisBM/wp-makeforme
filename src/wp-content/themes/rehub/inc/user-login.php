<?php


# 	
# 	USER REGISTRATION/LOGIN MODAL
# 	========================================================================================
#   Attach this function to the footer if the user isn't logged in
# 	========================================================================================
# 		
if( !function_exists('rehub_login_register_modal') ) {
function rehub_login_register_modal() {
	// only show the registration/login form to non-logged-in members
	if(!is_user_logged_in()){ 

		if(rehub_option('userlogin_captcha_enable') =='1' && rehub_option('userlogin_gapi_sitekey') !='' && rehub_option('userlogin_gapi_secretkey') !='') {
			$captcha_enabled = '1';
			//wp_enqueue_script( 're-recaptcha', 'https://www.google.com/recaptcha/api.js');
		}
		else {$captcha_enabled = '';}
		$show_terms_conditions = rehub_option('userlogin_terms_enable');
		?>
						
		<?php if(get_option('users_can_register')){ ?>
			<div id="rehub-login-popup-block">
				<?php if (rehub_option('custom_register_link') ==''):?>
					<!-- Register form -->
					<div id="rehub-register-popup">
					<div class="rehub-register-popup">	 
						<div class="re_title_inmodal"><?php _e('Criar conta', 'rehub_framework'); ?></div>
						<div class="description">
							
							<p>Cadastre-se e conheça o mundo de Gostosuras do MakerMe!<br />Para montar sua loja e se tornar um Maker, marque a opção "Quero ser um Maker/Vendedor".<br />
							Caso tenha alguma dúvida sobre o processo, <a href="<?php echo get_page_link(5890); ?>">acesse aqui</a>.</p><br />
						</div>
						<?php if (rehub_option('custom_msg_popup') !='') {
							echo '<div class="mb15 mt15 rh_custom_msg_popup">';
							echo do_shortcode(rehub_option('custom_msg_popup'));
							echo '</div>';
							} ?>
						<form id="rehub_registration_form_modal" action="<?php echo home_url( '/' ); ?>" method="POST">
							<?php do_action( 'wordpress_social_login' ); ?>
							<div class="re-form-group mb20">
								<label><?php _e('Usuário', 'rehub_framework'); ?></label>
								<input class="re-form-input required" name="rehub_user_login" type="text"/>
							</div>
							<div class="re-form-group mb20">
								<label for="rehub_user_email"><?php _e('Email', 'rehub_framework'); ?></label>
								<input class="re-form-input required" name="rehub_user_email" id="rehub_user_email" type="email"/>
							</div>
							<div class="re-form-group mb20">
								<label for="rehub_user_signonpassword"><?php _e('Senha', 'rehub_framework'); ?><span class="alignright font90"><?php _e('Mínimo 6 caracteres', 'rehub_framework');  ?></span></label>
								<input class="re-form-input required" name="rehub_user_signonpassword" id="rehub_user_signonpassword" type="password"/>
							</div>
							<div class="re-form-group mb20">
								<label for="rehub_user_confirmpassword"><?php _e('Confirmar senha', 'rehub_framework'); ?></label>
								<input class="re-form-input required" name="rehub_user_confirmpassword" id="rehub_user_confirmpassword" type="password"/>
							</div>	
							<?php if ( class_exists( 'BuddyPress' ) && rehub_option('userpopup_xprofile') == 1):?>
								<?php if ( bp_is_active( 'xprofile' ) ) : ?>
									<div id="xp-woo-profile-details-section"<?php if(rehub_option('userpopup_xprofile_hidename') == 1){echo ' class="xprofile_hidename"';}?>>
										<?php if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
											<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
												<div<?php bp_field_css_class( 'editfield re-form-group mb20' ); ?>>
													<?php
														$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
														$field_type->edit_field_html();
													?>
													<p class="xp-woo-description"><?php bp_the_profile_field_description(); ?></p>
												</div>
											<?php endwhile; ?>
											<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />
										<?php endwhile; endif; ?>
										<?php do_action( 'bp_signup_profile_fields' ); ?>
									</div><!-- #profile-details-section -->
									<?php do_action( 'bp_after_signup_profile_fields' ); ?>
								<?php endif; ?>
							<?php endif; ?>										
							<?php

							if($captcha_enabled =='1'){ ?>
								<div class="re-form-group mb20">
								    <script type="text/javascript">
								      var onloadCaptchamodail = function() {
								        grecaptcha.render('recaptchamodail', {
								          'sitekey' : '<?php echo rehub_option("userlogin_gapi_sitekey") ?>'
								        });
								      };
								    </script>
									<div class="recaptchamodail"></div>
								    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCaptchamodail&render=explicit" async defer></script>
								</div><?php
							}

							if($show_terms_conditions){ ?>
								<div class="re-form-group mb20">
									<div class="checkbox">
										<label><input name="rehub_terms" type="checkbox"> <?php echo sprintf( __( 'Aceite os <a target="_blank" href="%s"> Termos e Condições </a>', 'rehub_framework' ), esc_url(get_the_permalink(rehub_option('userlogin_term_page'))) ) ?></label>
									</div>
								</div><?php
							}

							if (defined('wcv_plugin_dir')) { ?>
								<?php do_action( 'wcvendors_apply_for_vendor_before' ); ?>
								<div class="re-form-group mb20">
									<div class="checkbox">
										<label><input name="wcv_apply_as_vendor" type="checkbox"> <?php _e('Quero ser um maker/vendedor?', 'rehub_framework'); ?></label>
									</div>
								</div>
								<?php do_action( 'wcvendors_apply_for_vendor_after' ); ?>
								<?php
							}

							 ?>

							<div class="re-form-group mb20">
								<input type="hidden" name="action" value="rehub_register_member_popup_function"/>
								<button class="wpsm-button rehub_main_btn" type="submit"><?php _e('Cadastrar-se', 'rehub_framework'); ?></button>
							</div>
							<?php wp_nonce_field( 'ajax-login-nonce', 'register-security' ); ?>
						</form>
						<div class="rehub-errors"></div>
						<div class="rehub-login-popup-footer"><?php _e('Já tem uma conta?', 'rehub_framework'); ?> <span class="act-rehub-login-popup color_link" data-type="login"><?php _e('Logar', 'rehub_framework'); ?></span></div>
					</div>
					</div>
				<?php endif;?>

				<!-- Login form -->
				<div id="rehub-login-popup">
			 	<div class="rehub-login-popup">
					<div class="re_title_inmodal"><?php _e('Logar', 'rehub_framework'); ?></div>
					<form id="rehub_login_form_modal" action="<?php echo home_url( '/' ); ?>" method="post">
						<?php do_action( 'wordpress_social_login' ); ?>
						<div class="re-form-group mb20">
							<label><?php _e('Usuário', 'rehub_framework') ?></label>
							<input class="re-form-input required" name="rehub_user_login" type="text"/>
						</div>
						<div class="re-form-group mb20">
							<label for="rehub_user_pass"><?php _e('Senha', 'rehub_framework')?></label>
							<input class="re-form-input required" name="rehub_user_pass" id="rehub_user_pass" type="password"/>
							<?php if(function_exists('um_get_core_page')) :?>
								<a href="<?php echo um_get_core_page('password-reset'); ?>" class="alignright"><?php _e('Perdeu sua senha?', 'rehub_framework'); ?></a>
							<?php else: ?>
								<span class="act-rehub-login-popup color_link alignright" data-type="resetpass"><?php _e('Perdeu sua senha?', 'rehub_framework');  ?></span>
							<?php endif;?>							
						</div>
						<div class="re-form-group mb20">
							<label for="rehub_remember"><input name="rehub_remember" id="rehub_remember" type="checkbox" value="forever" />
							<?php _e('Lembrar-me', 'rehub_framework'); ?></label>
						</div>						
						<div class="re-form-group mb20">
							<input type="hidden" name="action" value="rehub_login_member_popup_function"/>
							<button class="wpsm-button rehub_main_btn" type="submit"><?php _e('Entrar', 'rehub_framework'); ?></button>
						</div>
						<?php wp_nonce_field( 'ajax-login-nonce', 'loginsecurity' ); ?>
					</form>
					<div class="rehub-errors"></div>
					<div class="rehub-login-popup-footer"><?php _e('Não tem uma conta?', 'rehub_framework'); ?> 
					<?php if (rehub_option('custom_register_link') !=''):?>
						<span class="act-rehub-login-popup color_link crie-conta" data-type="url" data-customurl="<?php echo esc_html(rehub_option('custom_register_link'));?>"><?php _e('Crie agora', 'rehub_framework'); ?></span>						
					<?php else:?>
						<span class="act-rehub-login-popup color_link crie-conta" data-type="register"><?php _e('Crie agora', 'rehub_framework'); ?></span>
					<?php endif;?>
					</div>
				</div>
				</div>

				<!-- Lost Password form -->
				<div id="rehub-reset-popup">
			 	<div class="rehub-reset-popup">
					<div class="re_title_inmodal"><?php _e('Resetar Senha', 'rehub_framework'); ?></div>
					<form id="rehub_reset_password_form_modal" action="<?php echo home_url( '/' ); ?>" method="post">
						<div class="re-form-group mb20">
							<label for="rehub_user_or_email"><?php _e('Usuário ou Email', 'rehub_framework') ?></label>
							<input class="re-form-input required" name="rehub_user_or_email" id="rehub_user_or_email" type="text"/>
						</div>
						<div class="re-form-group mb20">
							<input type="hidden" name="action" value="rehub_reset_password_popup_function"/>
							<button class="wpsm-button rehub_main_btn" type="submit"><?php _e('Nova senha', 'rehub_framework'); ?></button>
						</div>
						<?php wp_nonce_field( 'ajax-login-nonce', 'password-security' ); ?>
					</form>
					<div class="rehub-errors"></div>
					<div class="rehub-login-popup-footer"><?php _e('Já tem uma conta?', 'rehub_framework'); ?> <span class="act-rehub-login-popup color_link" data-type="login"><?php _e('Logar', 'rehub_framework'); ?></span></div>
				</div>
				</div>
			</div>
			<?php

		}else{
			echo '<div id="rehub-restrict-login-popup"><div class="rehub-restrict-login-popup">'.__('Login/Register access is temporary disabled', 'rehub_framework').'</div></div>';
		} ?>

		<?php
	}
}
add_action('wp_footer', 'rehub_login_register_modal');
}

# 	
# 	AJAX FUNCTION (HANDLE DATA FROM POPUP)
# 	========================================================================================	

// LOGIN
if( !function_exists('rehub_login_member_popup_function') ) {
function rehub_login_member_popup_function(){

	// Get variables
	$user_login		= sanitize_user($_POST['rehub_user_login']);	
	$user_pass		= sanitize_text_field($_POST['rehub_user_pass']);
	$remember 	= !empty($_POST['rehub_remember']) ? true : false;

	// Check CSRF token
	if( !check_ajax_referer( 'ajax-login-nonce', 'loginsecurity', false) ){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type"><i></i>'.__('A sessão expirou, conecte-se e tente novamente', 'rehub_framework').'</div>'));
	}
 	
 	// Check if input variables are empty
 	elseif(empty($user_login) or empty($user_pass)){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type"><i></i>'.__('Preencha todos os campos do formulário', 'rehub_framework').'</div>'));
 	}

 	else{
 		$secure_cookie = (!is_ssl()) ? false : '';
 		$user = wp_signon( array('user_login' => $user_login, 'user_password' => $user_pass, 'remember' => $remember ), $secure_cookie );
	    if(is_wp_error($user)){
			echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type"><i></i>'.$user->get_error_message().'</div>'));
		}
	    else{
			echo json_encode(array('error' => false, 'message'=> '<div class="wpsm_box green_type">'.__('Login bem sucedido, recarregando a página ...', 'rehub_framework').'</div>'));
		}
 	}
 	die();
}
add_action('wp_ajax_nopriv_rehub_login_member_popup_function', 'rehub_login_member_popup_function');
}

// REGISTER
if( !function_exists('rehub_register_member_popup_function') ) {
function rehub_register_member_popup_function(){

	// Get variables
	$user_login	= sanitize_user($_POST['rehub_user_login']);	
	$user_email	= sanitize_email($_POST['rehub_user_email']);
	$user_signonpassword = sanitize_text_field($_POST['rehub_user_signonpassword']);
	$user_confirmpassword	= sanitize_text_field($_POST['rehub_user_confirmpassword']);
	$wcv_apply_as_vendor = (!empty($_POST['wcv_apply_as_vendor'])) ? $_POST['wcv_apply_as_vendor'] : '';	

	$show_terms_conditions = rehub_option('userlogin_terms_enable');

	if(rehub_option('userlogin_captcha_enable') =='1'){
		require_once get_template_directory().'/inc/vendor/recaptcha/src/ReCaptcha/ReCaptcha.php';
		require_once get_template_directory().'/inc/vendor/recaptcha/src/ReCaptcha/RequestMethod.php';
		require_once get_template_directory().'/inc/vendor/recaptcha/src/ReCaptcha/RequestParameters.php';
		require_once get_template_directory().'/inc/vendor/recaptcha/src/ReCaptcha/Response.php';
		require_once get_template_directory().'/inc/vendor/recaptcha/src/ReCaptcha/RequestMethod/Post.php';
		require_once get_template_directory().'/inc/vendor/recaptcha/src/ReCaptcha/RequestMethod/Socket.php';
		require_once get_template_directory().'/inc/vendor/recaptcha/src/ReCaptcha/RequestMethod/SocketPost.php';

		$secret = rehub_option('userlogin_gapi_secretkey');

		$recaptcha = new \ReCaptcha\ReCaptcha($secret);

		$resp = $recaptcha->verify( $_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'] );

		if(!$resp->isSuccess()){
		    // $errors = $resp->getErrorCodes();
			echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Resposta errada do captcha, tente novamente.', 'rehub_framework').'</div>'));
			die();
		}
	}
	
	// Check CSRF token
	if( !check_ajax_referer( 'ajax-login-nonce', 'register-security', false) ){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Sessão expirada, conecte-se e tente novamente', 'rehub_framework').'</div>'));
		die();
	}
 	
 	// Check if input variables are empty
 	elseif(empty($user_login) or empty($user_email) or empty($user_signonpassword) or empty($user_confirmpassword)){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Preencha todos os campos do formulário', 'rehub_framework').'</div>'));
		die();
 	}

 	elseif($show_terms_conditions and !isset($_POST['rehub_terms'])){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Aceite os termos e condições antes de registrar', 'rehub_framework').'</div>'));
		die();
 	}

 	elseif($user_signonpassword != $user_confirmpassword){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Suas senhas não coincidem. Defina a mesma senha em ambos os campos', 'rehub_framework').'</div>'));
		die();
 	} 

 	elseif(mb_strlen($user_signonpassword) < 6){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Suas senhas devem ter no mínimo 6 caracteres.', 'rehub_framework').'</div>'));
		die();
 	}  		
	
	$errors = wp_create_user( $user_login, $user_signonpassword, $user_email );
	if(is_wp_error($errors)){
		$registration_error_messages = $errors->errors;
		$display_errors = '<div class="wpsm_box warning_type">';
			foreach($registration_error_messages as $error){
				$display_errors .= '<p>'.$error[0].'</p>';
			}
		$display_errors .= '</div>';
		echo json_encode(array('error' => true, 'message' => $display_errors));
	}else{
		if (!empty($_POST['signup_profile_field_ids'])){
			$signup_profile_field_ids = explode(',', $_POST['signup_profile_field_ids']);
			foreach ((array)$signup_profile_field_ids as $field_id) {
				if ( ! isset( $_POST['field_' . $field_id] ) ) {
					if ( ! empty( $_POST['field_' . $field_id . '_day'] ) && ! empty( $_POST['field_' . $field_id . '_month'] ) && ! empty( $_POST['field_' . $field_id . '_year'] ) ) {
						// Concatenate the values.
						$date_value = $_POST['field_' . $field_id . '_day'] . ' ' . $_POST['field_' . $field_id . '_month'] . ' ' . $_POST['field_' . $field_id . '_year'];

						// Turn the concatenated value into a timestamp.
						$_POST['field_' . $field_id] = date( 'Y-m-d H:i:s', strtotime( $date_value ) );
						
					}
				}
				if(!empty($_POST['field_' . $field_id])){
					$field_val = $_POST['field_' . $field_id];
					xprofile_set_field_data($field_id, $errors, $field_val);
				}			
			}
		}		
		if ($wcv_apply_as_vendor){
			$secure_cookie = (!is_ssl()) ? false : '';
			$manual = WC_Vendors::$pv_options->get_option( 'manual_vendor_registration' );
			$role   = apply_filters( 'wcvendors_pending_role', ( $manual ? 'pending_vendor' : 'vendor' ) );	
			if (class_exists('WCVendors_Pro') ) {
				if ($role == 'pending_vendor'){
					$role = 'customer';
				}
			}		
			$user_id = wp_update_user( array( 'ID' => $errors, 'role' => $role ));
			do_action( 'wcvendors_application_submited', $errors );
		    if (class_exists('WCVendors_Pro') ) {
		        $redirect_to = get_permalink(WCVendors_Pro::get_option( 'dashboard_page_id' ));
		    }
		    else {
		    	$redirect_to = get_permalink(WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ));
		    }
		    $errorshow = false;
			if ($role == 'vendor'){
				$status = 'approved';				
				$message = '<div class="wpsm_box green_type">'.__( 'Parabéns! Agora você é um Maker. Certifique-se de que configura as definições da loja antes de adicionar produtos.', 'rehub_framework').'</div>';				
			}
			elseif ($role == 'customer'){
				$status = 'customer';				
				$message = '<div class="wpsm_box green_type">'.__( 'Parabéns! Agora você deve adicionar as informações de sua loja para a ativação, enquanto atualizamos o Maker Me.', 'rehub_framework').'</div>';
			}			
			else{
                $status = 'pending';
				$message = '<div class="wpsm_box green_type">'.__( 'Sua solicitação foi recebida com sucesso. Você será notificado por e-mail dos resultados de sua loja Maker. Atualmente, você pode usar o site como Maker pendente.', 'rehub_framework').'</div>';
			}
			if ($status != 'customer' && $status != ''){
				global $woocommerce;
	            $mails = $woocommerce->mailer()->get_emails();
	            if (!empty( $mails ) ) {
	                $mails[ 'WC_Email_Approve_Vendor' ]->trigger($errors, $status );
	            }
			}			
			wp_signon( array('user_login' => $user_login, 'user_password' => $user_signonpassword), $secure_cookie );
			echo json_encode(array('error' => $errorshow, 'message' => $message, 'redirecturl' => $redirect_to));			
		}else{
			update_user_meta($errors, '_um_cool_but_hard_to_guess_plain_pw', $user_signonpassword);
			$secure_cookie = (!is_ssl()) ? false : '';
			wp_signon( array('user_login' => $user_login, 'user_password' => $user_signonpassword), $secure_cookie );
			echo json_encode(array('error' => false, 'message' => '<div class="wpsm_box green_type">'.__( 'Registro completo. Agora você pode usar sua conta. Recarregando a página ...', 'rehub_framework').'</div>'));			
		}

	}
 	die();
}
add_action('wp_ajax_nopriv_rehub_register_member_popup_function', 'rehub_register_member_popup_function');
}


// RESET PASSWORD
if( !function_exists('rehub_reset_password_popup_function') ) {
function rehub_reset_password_popup_function(){
	// Get variables
	$username_or_email = $_POST['rehub_user_or_email'];

	// Check CSRF token
	if( !check_ajax_referer( 'ajax-login-nonce', 'password-security', false) ){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('A sessão expirou, recarregue a página e tente novamente', 'rehub_framework').'</div>'));
	}		

 	// Check if input variables are empty
 	elseif(empty($username_or_email)){
		echo json_encode(array('error' => true, 'message'=> '<div class="wpsm_box warning_type">'.__('Preencha todos os campos do formulário', 'rehub_framework').'</div>'));
 	}

 	else{
		$username = is_email($username_or_email) ? sanitize_email($username_or_email) : sanitize_user($username_or_email);
		$user_forgotten = rehub_lostPassword_retrieve($username);	
		if(is_wp_error($user_forgotten)){	
			$lostpass_error_messages = $user_forgotten->errors;
			$display_errors = '<div class="wpsm_box warning_type">';
			foreach($lostpass_error_messages as $error){
				$display_errors .= '<p>'.$error[0].'</p>';
			}
			$display_errors .= '</div>';		
			echo json_encode(array('error' => true, 'message' => $display_errors));
		}else{
			echo json_encode(array('error' => false, 'message' => '<div class="wpsm_box green_type">'.__('A senha foi redefinida. Por favor verifique seu email. Recarregando a página ...', 'rehub_framework').'</div>'));
		}
 	}
 	die();
}	
add_action('wp_ajax_nopriv_rehub_reset_password_popup_function', 'rehub_reset_password_popup_function');
}

function rehub_lostPassword_retrieve( $user_data ) {
	
	global $wpdb, $current_site, $wp_hasher;
	$errors = new WP_Error();

	if(empty($user_data)){
		$errors->add( 'empty_username', __( 'Digite um nome de usuário ou endereço de e-mail.', 'rehub_framework' ) );
	}elseif(strpos($user_data, '@')){
		$user_data = get_user_by( 'email', trim( $user_data ) );
		if(empty($user_data)){
			$errors->add( 'invalid_email', __( 'Não há nenhum usuário registrado com esse endereço de e-mail.', 'rehub_framework'  ) );
		}
	}else{
		$login = trim( $user_data );
		$user_data = get_user_by('login', $login);
	}
	if($errors->get_error_code()){
		return $errors;
	}
	if(!$user_data){
		$errors->add('invalidcombo', __('Nome de usuário ou e-mail inválido.', 'rehub_framework'));
		return $errors;
	}
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;
	do_action('retrieve_password', $user_login);
	$allow = apply_filters('allow_password_reset', true, $user_data->ID);
	if(!$allow){
		return new WP_Error( 'no_password_reset', __( 'A reposição de palavra-passe não é permitida para este utilizador', 'rehub_framework' ) );
	}
	elseif(is_wp_error($allow)){
		return $allow;
	}
	$key = wp_generate_password(20, false);
	do_action('retrieve_password_key', $user_login, $key);
	if(empty($wp_hasher)){
		require_once ABSPATH.'wp-includes/class-phpass.php';
		$wp_hasher = new PasswordHash(8, true);
	}
	$hashed = $wp_hasher->HashPassword($key);
	$wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));
	$message = __('Alguém solicitou a redefinição de senha para a seguinte conta:', 'rehub_framework' ) . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf( __( 'Usuário: %s', 'rehub_framework' ), $user_login ) . "\r\n\r\n";
	$message .= __('Se este foi um erro, basta ignorar este e-mail e nada vai acontecer.', 'rehub_framework' ) . "\r\n\r\n";
	$message .= __('Para redefinir sua senha, visite o seguinte endereço:', 'rehub_framework' ) . "\r\n\r\n";
	$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n\r\n";
	
	if ( is_multisite() ) {
		$blogname = $GLOBALS['current_site']->site_name;
	} else {
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}
	$title   = sprintf( __( '[%s] Resetar senha', 'rehub_framework' ), $blogname );
	$title   = apply_filters( 'retrieve_password_title', $title );
	$message = apply_filters( 'retrieve_password_message', $message, $key );
	if ( $message && ! wp_mail( $user_email, $title, $message ) ) {
		$errors->add( 'noemail', __( 'O e-mail não pôde ser enviado. <br /> Possível motivo: seu host pode ter desativado a função mail ().', 'rehub_framework' ) );
		return $errors;
		wp_die();
	}
	return true;
}	