<?php get_header(); ?>

<div class="single">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
				<?php
				if( get_the_post_thumbnail() ) : ?>
					<div id="our-post-image">
						<?php the_post_thumbnail(); ?>
					</div>
				<?php
				endif; the_content(); ?>
			</article>
		<?php
		endwhile;

        echo do_shortcode('[review_form]');

		if ( is_single() ) :
			echo previous_post_link() . " ";
			next_post_link();
		endif;
	else :
		_e( 'Oj hoppsan, här var det tomt.', 'textdomain' );
	endif;
	?>

</div>

<?php get_footer(); ?>