<?php
/**
    * Plugin Name: Commenting Plugin
    * Plugin URI: https://example.com/plugins/the-basics/
    * Description: Display your reviews easy with this plugin.
    * Version: 1.0.0
    * Requires at least: 5.9
    * Requires PHP: 7.4
    * Author: John Smith
    * Author URI: https://author.example.com/
    * License: GPL v2 or later
    * License URI: https://www.gnu.org/licenses/gpl-2.0.html
    * Text Domain: comment-plugin
    * Domain Path: /languages
*/

register_activation_hook( __FILE__, 'comment_plugin_activated' );

ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting (E_ALL);
//register_deactivation_hook(__FILE__, 'plugin_deactivated');

function comment_plugin_activated()
{
	// create custom post types 
	flush_rewrite_rules();
}

/**
 * Here is where we put our javscript file for the plugin. We register it and ques it.
*/
add_action( 'init', 'scripts_loader' );
function scripts_loader() 
{
	/* registering the script */
	wp_register_script( 'script',
		plugins_url( '/js/script.js', __FILE__ ),
		['jquery'],
		'1.0.0',
		true );

	/* registering the script */
	wp_enqueue_script( 'script' );
}

/**
 * To be able to recieve our Ajax request, we must have a function that handles it.
 * You add it with these two add_actions,the first one is for logged in users,
 * and the other is for non-logged in users.
*/
add_action("wp_ajax_test_save_comment_action", "form_save_comments");
add_action("wp_ajax_nopriv_test_save_comment_action", "form_save_comments");
function form_save_comments()
{
	// nonce check for an extra layer of security, the function will exit if it fails
	if ( !wp_verify_nonce( $_REQUEST['nonce'], "test_nonce"))
    {
		exit("Woof Woof Woof");
	}

    createNewPost();

	echo json_encode( ['type' => 'success', 'message' => 'Comment saved'] );
	wp_die();
}

/**
 * Here we create a short code to be used on the website page according to: [search_hello]
 * The first name inside [] is the first parameter with add_shortcode().
*/
add_shortcode( 'comment_hello', 'comment_says_hello' );
function comment_says_hello( $atts = [], $content = null ) 
{
	//$latestPosts = new WP_Query();

    comment_showComment();
}

function comment_showComment()
{
    include plugin_dir_path( __FILE__ ) . 'comment.php';
}

/**
 * This is how we create a new post.
*/
function createNewPost()
{
    global $wpdb;
    $user_id = get_current_user_id();

    wp_insert_post(
	$thecomment = array(
		'post_title'   => wp_strip_all_tags($_POST['name']),
		'post_content' => $_POST['comment'],
		'post_status'  => 'pending', //You have to manually publish it
		'post_author'  => 1,
		'post_type'    => 'comments',

		'meta_input'    => [
			'commenter' => wp_strip_all_tags($_POST['name']),
			'post_author_id' => $user_id
		    ])
    );
    
}

?>