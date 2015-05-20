<?php
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'OWC_PATH', dirname( __FILE__ ) );
define( 'OWC_SRC', OWC_PATH . '/src' );
define( 'PRE', 'owc' );

// Init post types
$book = new OWC\PostType\Book;

// Init taxonomies
$genre = new OWC\Taxonomy\Genre;

// Load Admin
if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) || is_admin() ) {
	$admin = new OWC\Admin;
}

// Run cron jobs
$cron = new OWC\Cron;

// Boot it up!
$theme = new OWC\Theme;
