<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'OWC_PATH', dirname( __FILE__ ) );
define( 'OWC_INCLUDES', OWC_PATH . '/_includes' );
define( 'PRE', 'owc' );

// Load Classes
require_once( '_includes/classes/OWC.php' );
require_once( '_includes/classes/OWC_Cron.php' );

// Load Functions
require_once( '_includes/core.php' );
require_once( '_includes/filters.php' );

// Load Admin
if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) || is_admin() ) {
	require_once( '_includes/OWC_Admin.php' );
}

// Boot it up!
$owc = new OWC();