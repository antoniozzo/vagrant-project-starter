<?php get_header(); ?>

<section>
	<?php while( have_posts() ) : the_post(); ?>

		<article>
			<?php the_post_thumbnail( 'full' ); ?>

			<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<span><?php the_author(); ?> - <?php the_time( 'j F Y' ); ?></span>
			
			<?php the_content(); ?>
		</article>

	<?php endwhile; ?>
</section>

<?php get_footer(); ?>