<div class="wrap">
    <form action="<?php echo admin_url('admin-ajax.php') ?>" method="post" class="review_form">
        
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( "review_form_nonce" ); ?>"/>

        <input type="hidden" name="action" value="shop_review_handle_form"/>

        <input type='hidden' name='product_item' value='<?php the_id(); ?>'>

        <label>Title:</label>
        <input type='text' name='title' placeholder='Amazing item!'>

        <label>Author:</label>
        <input type='text' name='author' placeholder='First Lastname'>

        <label>Rating:</label>
        <input type='rating' name='rating' placeholder='5'>

        <label>Review:</label>
        <input type='text' name='review' placeholder='Loved it!'>

        <button type="submit">Submit</button>
    </form>
    <p id="success"></p>
</div>

<?php

$reviews = new WP_Query([
    'post_type' => 'review_post'
]);

if( $reviews->have_posts() ) : ?>
    <div>
    <?php
    while( $reviews->have_posts() ) : $reviews->the_post(); ?>
            <div style="background-color: beige; padding: 10px;">
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
            </div>
            <br>
    <?php
    endwhile; ?>
    </div>
    <?php endif; ?>