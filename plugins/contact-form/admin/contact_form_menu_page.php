<h1>Your recieved forms</h1>

<?php

/* Creates a custom wp query to be able to select our custom post type */
$form_query = new WP_Query
([
	'post_type' => 'contactforms'
]);

/* Checks if it have posts to then loop through and show each one seperately */
if ( $form_query->have_posts() ) :
    while ( $form_query->have_posts() ) : $form_query->the_post(); ?>
	<div class="cont">
        <h4 class="name">Name: <?php the_title() ?></h4>
		<p class="message"><?php the_content() ?></p>
    </div>
<?php endwhile; endif; wp_reset_postdata(); ?>

<style>
.cont
{
    width: 20%;
    margin: 2rem 1rem;
    padding-left: 1rem;
    background-color: rgba(250, 235, 215, 0.527);
    border-radius: 15px;
    border: 1px solid rgb(32, 32, 32);
}
</style>