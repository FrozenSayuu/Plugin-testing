<?php get_header(); 

$shop = new WP_Query([
	'post_type' => 'wp_shop'
]);

?>

<div class="index">
	<?php
	if ( $shop->have_posts() ) : ?>
		<div>
		<?php
		while ( $shop->have_posts() ) : $shop->the_post(); ?>
				<div>
					<h3><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h3>
				<?php if( the_post_thumbnail() ) : ?>
					<div id="our-post-image">
						<?php the_post_thumbnail('gallery'); ?>
					</div>
				<?php
				endif;
					the_content(); ?>
				</div>
		<?php
		endwhile; ?>
			</div>

		<?php
		if ( is_single() ) :
			previous_post_link();
			next_post_link();
		endif;
	else :
		_e( 'Oj hoppsan, här var det tomt.', 'textdomain' );
	endif;
	?>

</div>

<?php get_footer(); ?>
