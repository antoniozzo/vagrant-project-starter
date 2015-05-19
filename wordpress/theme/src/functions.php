<?php 
namespace OWC;

if ( ! defined( 'ABSPATH' ) ) exit;

function is_env( $env ) {
	return ( defined( 'OWC_ENVIRONMENT' ) && OWC_ENVIRONMENT === $env );
}

function get_theme_version() {
	return wp_get_theme()->get( 'Version' );
}

function theme_version() {
	echo get_theme_version();
}

function asset_rev( $filename ) {
	// see comments below
	$manifest_path = get_stylesheet_directory() . '/assets/dist/rev-manifest.json';

	if ( ! is_local_env() && file_exists( $manifest_path ) ) {
		// retrieve revisioned file for production server
		$manifest = json_decode( file_get_contents( $manifest_path ), true );

		if ( array_key_exists( $filename, $manifest ) )
			return $manifest[ $filename ];

	} else {
		// non-revisioned file for dev (needed for BrowserSync)
		return $filename;
	}
}

function svg( $id, $args = '' ) {
	$defaults = array(
		'title'  => '',
		'class'  => 'icon',
		'width'  => 100,
		'height' => 100
	);
	$args = (object) wp_parse_args( $args, $defaults );
	?>
		<svg class="<?php echo $args->class; ?>" viewBox="0 0 <?php echo $args->width; ?> <?php echo $args->height; ?>">
			<?php if ( $args->title ) echo '<title>' . $args->title . '</title>'; ?>
			<use xlink:href="<?php echo get_stylesheet_directory_uri(); ?>/assets/dist/img/sprite/main.svg#<?php echo $id; ?>"></use>
		</svg>
	<?php
}