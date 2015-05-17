<?php

$table_prefix = 'wp_';

if (! defined('ABSPATH'))
	define('ABSPATH', dirname(__FILE__) . '/');

define('AUTH_KEY', '');
define('SECURE_AUTH_KEY', '');
define('LOGGED_IN_KEY', '');
define('NONCE_KEY', '');
define('AUTH_SALT', '');
define('SECURE_AUTH_SALT', '');
define('LOGGED_IN_SALT', '');
define('NONCE_SALT', '');
define('OWC_ENVIRONMENT', getenv('ENV'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
define('WP_HOME', 'http://' . getenv('DOMAIN')); 
define('WP_SITEURL', WP_HOME . '/wp');
define('WP_CONTENT_URL', WP_HOME . '/wp-content');
define('WP_CONTENT_DIR', dirname(__FILE__) . '/wp-content');

if (OWC_ENVIRONMENT === 'local') {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	define('WP_DEBUG', true);
} else {
	define('WP_DEBUG', false);
}

require_once(dirname(__FILE__) . '/vendor/autoload.php');
require_once(ABSPATH . 'wp-settings.php');