<?php
namespace OWC;

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
		// $actions['my_action'] => 'my_action';
		
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

}