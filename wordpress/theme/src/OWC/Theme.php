<?php
namespace OWC;

use Oakwood\AbstractTheme;

if ( ! defined( 'ABSPATH' ) ) exit;

class Theme extends AbstractTheme {

	/*
	|--------------------------------------------------------------------------
	| EXTENDS: AbstractTheme
	|--------------------------------------------------------------------------
	*/

	public function get_filters( $filters = array() ) {
		// $filters['my_filter'] => 'my_filter';
		
		return $filters;
	}

	public function get_actions( $actions = array() ) {
		$actions['body_prepend'] => 'svg_sprite';
		
		return $actions;
	}

	public function get_widgets( $widgets = array() ) {
		// $widgets['MyWidget'] => true;
		
		return $widgets;
	}

	public function get_styles( $styles = array() ) {
		// $styles['my_css'] => 'path/to/my/css';
		
		return $styles;
	}

	public function get_scripts( $scripts = array() ) {
		// $scripts['my_js'] => 'path/to/my/js';
		
		return $scripts;
	}

	/*
	|--------------------------------------------------------------------------
	| ACTIONS
	|--------------------------------------------------------------------------
	*/

	function svg_sprite() {
		include_once( get_stylesheet_directory_uri() . '/assets/dist/img/sprite/main.svg' );
	}

}