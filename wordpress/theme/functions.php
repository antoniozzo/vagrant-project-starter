<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'OWC_PATH', dirname( __FILE__ ) );
define( 'OWC_SRC', OWC_PATH . '/src' );
define( 'PRE', 'owc' );

// Load Admin
if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) || is_admin() ) {
	$OWC_Admin = new OWC\Admin();
}

// Run cron jobs
$OWC_Cron = new OWC\Cron();

// Boot it up!
$OWC_Theme = new OWC\Theme();
