<div class="wrap">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" id="contactform">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( "contact_nonce" ); ?>"/>
        <?php wp_nonce_field( 'nonce', 'contact_nonce' ); ?>

        <input type="hidden" name="action" value="contact_form_action" />

        <label>Name:</label>
        <input type="text" name="name" placeholder="Your name">

        <label>Mail:</label>
        <input type="mail" name="mail" placeholder="Your mail">

        <label>Message:</label>
        <textarea cols="50" rows="4" name="message" placeholder="The message"></textarea>

        <button name="contact_form" id="save-btn">Send</button>
    </form>
</div>

<div class="success"></div>