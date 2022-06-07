<?php 
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting (E_ALL);

?>
<div class="wrap">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" id="commentform">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( "test_nonce" ); ?>"/>
        <?php wp_nonce_field( 'nonce', 'test_nonce' ); ?>
        
        <input type="hidden" name="action" value="test_save_comment_action" />
        
        <label>Name:</label>
        <input type="text" name="name" placeholder="First Lastname">

        <label>Comment:</label>
        <input type="text" name="comment" placeholder="Your comment">

        <button name="save_comment" id="save-btn">Send</button>
    </form>
</div>

<div class="wrap comments">
<?php

/* Creates a custom wp query to be able to select our custom post type */
$comment_query = new WP_Query
([
	'post_type' => 'comments'
]);

/* Checks if it have posts to then loop through and show each one seperately */
if ( $comment_query->have_posts() ) :
    while ( $comment_query->have_posts() ) : $comment_query->the_post(); ?>
	<article class="c-cont">
        <h5 class="c-name"><?php the_title() ?></h5>
		<p class="c-comment"><?php the_content() ?></p>
    </article>
    <br>
<?php endwhile; endif; wp_reset_postdata(); ?>

</div>