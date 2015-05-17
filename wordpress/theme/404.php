<?php get_header(); ?>

<section>

	<article>
		<h1><?php _e( 'Page not found', PRE ); ?></h1>
		<p><?php _e( 'Sorry, we could not find the page you were looking for.', PRE ); ?></p>
		<p><?php printf( __( 'Go to the <a href="%s">startpage &raquo;</a>', PRE ), home_url() ); ?></p>
	</article>

</section>

<?php get_footer(); ?>