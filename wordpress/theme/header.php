<!doctype html>  
<html <?php language_attributes(); ?>>
<head>

	<!--=== META TAGS ===-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!--=== LINK TAGS ===-->
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico">

	<!--=== TITLE ===-->
	<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>

	<!--=== WP_HEAD() ===-->
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

	<?php OWC\Theme::body_prepend(); ?>

	<header id="header">
		<nav class="navigation">
			<?php wp_nav_menu( array(
				'theme_location' => 'top_menu',
				'container'      => false
			) ); ?>
		</nav>
	</header>