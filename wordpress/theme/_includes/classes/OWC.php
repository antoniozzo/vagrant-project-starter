<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class OWC {
	function __construct() {
		add_action( 'wp', array( $this, 'remove_header_tags' ) );
		add_action( 'wp_head', array( $this, 'open_graph' ) );

		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	function remove_header_tags() {
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	}

	function open_graph() {
		$title       = get_bloginfo( 'name' );
		$description = get_bloginfo( 'description' );
		$extra       = '';
		$image       = '';
		$type        = 'website';

		if ( is_single() ) {
			$title = get_the_title();
		}

		if ( is_single() && has_post_thumbnail() ) {
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
			
			if ( isset( $thumb[0] ) && ! empty( $thumb[0] ) )
				$image = $thumb[0];
		}

		echo "\n\n\t<!--=== OPEN GRAPH TAGS ===-->\n";

		if ( ! empty ( $title ) )
			echo "\t<meta property='og:title' content='" . esc_attr( $title ) . "'>\n";

		if ( ! empty ( $description ) )
			echo "\t<meta property='og:description' content='" . esc_attr( $description ) . "'>\n";

		if ( ! empty ( $image ) )
			echo "\t<meta property='og:image' content='" . esc_attr( $image ) . "'>\n";

		if ( ! empty ( $type ) )
			echo "\t<meta property='og:type' content='" . esc_attr( $type ) . "'>\n";

		echo "\t<meta property='og:site_name' content='" . get_bloginfo( 'name' ) . "'>\n";
	}

	function after_setup_theme() {
		add_theme_support( 'post-thumbnails' );

		if ( ! current_user_can( 'administrator' ) )
			show_admin_bar( false );
	}

	function enqueue_scripts() {
		wp_enqueue_style( 'main-css', get_stylesheet_directory_uri() . '/assets/dist/' . owc_asset_rev( 'css/main.css' ) );

		wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/assets/dist/' . owc_asset_rev( 'js/main.js' ), array( 'jquery' ), false, true );
	}

	function register_menus() {
		register_nav_menus( array(
			'top_menu'    => _x( 'Top Menu', 'admin', PRE ),
			'footer_menu' => _x( 'Footer Menu', 'admin', PRE )
		) );
	}

	function register_sidebars() {
		register_sidebar( array(
			'name' => _x( 'Standard', 'admin', PRE ),
			'id'   => 'standard'
		) );
	}

	function register_widgets() {
		unregister_widget( 'WP_Nav_Menu_Widget' );
		unregister_widget( 'WP_Widget_Calendar' );
		unregister_widget( 'WP_Widget_Links' );
		unregister_widget( 'WP_Widget_Pages' );
		unregister_widget( 'WP_Widget_Recent_Comments' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
		unregister_widget( 'WP_Widget_RSS' );
		unregister_widget( 'WP_Widget_Search' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );

		// Include all the widgets
		foreach ( glob( OWC_INCLUDES . '/widgets/*.php' ) as $filename ) {
			require_once( $filename );
			
			$widget = basename( $filename, '.php' );
			register_widget( $widget );
		}
	}

	function register_shortcodes() {
		// Include all the shortcodes
		foreach ( glob( OWC_INCLUDES . '/shortcodes/*.php' ) as $filename ) {
			require_once( $filename );

			// a shortcode file should "register itself"
		}
	}
}