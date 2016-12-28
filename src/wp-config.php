<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'pegadacultural');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');	

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ' &l+rWoqcXie#o@Rqc4]wgq@u}shNO:8$JMQhKmG~vtO-M21}ayAo1sM~,>8GIMl');
define('SECURE_AUTH_KEY',  '|O,`<[vxXh]*F4[SM9PN.up(;!(M^#uikeq0Uxy}Lw#T#xP4(:8}*s?zn`,Ds]ZJ');
define('LOGGED_IN_KEY',    '1+8:/X6,|.Yk>qIhuuNJ4?*)H9j,7/8nCE6sJRHfwCu-)l!=0@4lU^mtOh<I+VeC');
define('NONCE_KEY',        'SUtalnF%,Q:}i:P5O5^o81:qPkx:B=&?I3{in6C>`kS]_X)M};?dYk}QQyu)<UPZ');
define('AUTH_SALT',        'r#%*WYLqwULCZxr(*-K0bd`X;C]}H;oSN}ilFUJMk2jAc(z}T7tF}=r])<J}o3r(');
define('SECURE_AUTH_SALT', 'a>]7T^^**I`|{R@5{^|X/g 0ud:(@89`wrFAW{>98}P6.Hv2hQ6b&zD;PG(QP*60');
define('LOGGED_IN_SALT',   'hU3.KMc-.{A&BGyF4:oj|CU9@jlPf/Z`Vkq+TfKR-v`|>7Ib+>iH!3hI[=M8hb@X');
define('NONCE_SALT',       'H8Ft<w.5D&d)#J1LPp)~iD4%3)d_M8{%&#%zy KX`RWRs[w {tCpLRpr( ND<]{v');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

define('FS_METHOD','direct');

// Habilita modo de debug
define('WP_DEBUG', true);
 
// Guarda os logs em /wp-content/debug.log
define('WP_DEBUG_LOG', true);


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');

