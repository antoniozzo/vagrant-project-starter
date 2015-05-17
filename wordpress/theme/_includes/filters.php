<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Adds 'has-children' and/or 'is-child-item' classes to menu items
function owc_wp_nav_menu_objects( $items ) {
	$parents = wp_list_pluck( $items, 'menu_item_parent' );

	foreach ( $items as $item ) {
		in_array( $item->ID, $parents ) && $item->classes[] = 'has-children';
		$item->classes[] = $item->post_parent != 0 ? 'is-child-item' : '';
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'owc_wp_nav_menu_objects' );

// Custom excerpt ending
function owc_excerpt_more( $more ) {
	return ' ...';
}
add_filter( 'excerpt_more', 'owc_excerpt_more' );

// Read more link
function owc_the_content_more_link( $more_link, $more_link_text ) {
	return str_replace( $more_link_text, _x( 'Read more', PRE ), $more_link );
}
add_filter( 'the_content_more_link', 'owc_the_content_more_link', 10, 2 );

// Wraps videos with responsive video class
function owc_embed_oembed_html() {
	return '<div class="video-crop">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'owc_embed_oembed_html', 99, 3 );