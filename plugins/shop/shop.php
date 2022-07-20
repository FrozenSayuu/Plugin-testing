<?php
/**
    * Plugin Name: Shop Review Plugin
    * Description: A plugin to leave reviews on shop items
    * Version: 1.0.0
    * Author: Tova
    * Text Domain: shop-review-plugin
    * Domain Path: /languages
*/


register_activation_hook( __FILE__, 'shop_review_activated');

function shop_review_activated()
{
    flush_rewrite_rules();
}

ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting (E_ALL);

register_activation_hook(__FILE__, 'shop_review_deactivation');

function shop_review_deactivation()
{
    flush_rewrite_rules();
}

add_action('init', 'shop_script_loader');
function shop_script_loader()
{
    wp_register_script('shop_script',
    plugins_url('assets/shop_script.js', __FILE__), [], '1.0.0', true);

    wp_enqueue_script('shop_script');
}

add_action('wp_ajax_shop_review_handle_form', 'shop_review_form');
add_action('wp_ajax_nopriv_shop_review_handle_form', 'shop_review_form');
function shop_review_form()
{
    if(!wp_verify_nonce($_POST['nonce'], 'review_form_nonce'))
    {
        wp_send_json_error('An error occured, try again later!', 400);
        exit();
    }

    $review = wp_insert_post([
        'post_title' => $_POST['title'],
        'post_content' => 'Author: ' . $_POST['author'] . '<br>' . 'Rating: ' . $_POST['rating'] . '<br>' . 'Review: ' . $_POST['review'],
        'post_status' => 'publish',
        'post_type' => 'review_post',
        'meta_input' => [
            'review_author' => $_POST['author'],
            'rating' => $_POST['rating'],
            'description' => $_POST['review'],
            'product_id' => $_POST['product_item']
        ]
    ]);

    if(!is_wp_error($review))
    {
        wp_send_json_success([
            'status' => 'success',
            'message' => 'Your review is sent.'
        ]);
    }
    else
    {
        wp_send_json_error([
            'status' => 'error',
            'message' => 'Error, try again!'
        ]);
    }
}

add_shortcode('review_form', 'review_form_activate');
function review_form_activate($atts = [], $content = null)
{
    include plugin_dir_path(__FILE__) . '/assets/review_form.php';
}

function review_post()
{
    register_post_type('review_post', [
        'labels' => [
            'name' => 'Reviews',
            'singular' => 'Review'
            ],
        'public' => true,
        'rewrite' => ['slug' => 'review'],
        'supports' => ['title', 'editor', 'custom-fields']
    ]);
}
add_action('init', 'review_post', 5);

function wp_shop(){
    register_post_type('wp_shop', [
        'labels' => [
            'name' => __('Products', 'testtheme'),
            'singular' => __('Product', 'testtheme')
            ],
        'public' => true,
        'rewrite' => ['slug' => 'shop'],
        'taxonomies' => ['product_item'],
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields']
    ]);
}
add_action('init', 'wp_shop', 5);

function product_item()
{
    $labels = [
        'name'          => _x('Items', 'taxonomy general name'),
        'singular_name' => _x('Item', 'taxonomy singular name'),
    ];

    $args = [
        'hirerarchial' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_key' => true,
        'query_var' => true,
    ];
    register_taxonomy('Product', ['page'], $args);
}
add_action('init', 'product_item');

function addACF()
{
    include plugin_dir_path(__FILE__) . 'assets/shop_acf.php';
}

?>