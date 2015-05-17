<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class OWC_Admin {
	function __construct() {
		add_action( 'admin_init', array( $this, 'prevent_admin' ) );

		add_action( 'admin_menu', array( $this, 'dashboard' ) );

		add_filter( 'tiny_mce_before_init', array( $this, 'tiny_mce_before_init' ) );
		add_filter( 'mce_buttons', array( $this, 'mce_buttons' ) );
	}

	function prevent_admin() {
		if ( ! defined( 'DOING_AJAX' ) && is_admin() && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( home_url() );
			exit;
		}
	}

	function dashboard() {
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
	}

	function tiny_mce_before_init( $settings ) {
		$settings['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|scrolling|src|width]";
		$settings['style_formats']           = '[
			{title: "Preamble", inline: "span", classes: "preamble"}
		]';
	}

	function mce_buttons( $settings ) {
		$settings[] = 'styleselect';

		return $settings;
	}
}
$owc_admin = new OWC_Admin();
?>