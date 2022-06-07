<?php
/**
    * Plugin Name: Contact Form Plugin
    * Plugin URI: https://example.com/plugins/the-basics/
    * Description: Display your reviews easy with this plugin.
    * Version: 1.0.0
    * Requires at least: 5.9
    * Requires PHP: 7.4
    * Author: John Smith
    * Author URI: https://author.example.com/
    * License: GPL v2 or later
    * License URI: https://www.gnu.org/licenses/gpl-2.0.html
    * Text Domain: contact-form-plugin
    * Domain Path: /languages
*/

register_activation_hook( __FILE__, 'contact_form_plugin_activated');

ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting (E_ALL);
//register_deactivation_hook(__FILE__, 'plugin_deactivated');

function contact_form_plugin_activated()
{
	// create custom post types 
	flush_rewrite_rules();
}

function addStyle()
{
    wp_register_style('contact-form', plugins_url('contact-form/css/form.css'));
    wp_enqueue_style('contact-form');
}
// Register style sheet.
add_action('wp_enqueue_scripts', 'addStyle');

/**
 * Here is where we put our javscript file for the plugin. We register it and ques it.
*/
add_action('init', 'scripts_loader');
function scripts_loader() 
{
	/* registering the script */
	wp_register_script('contact_script',
		plugins_url('/js/contact_script.js', __FILE__ ),
		['jquery'],
		'1.0.0',
		true );

	/* registering the script */
	wp_enqueue_script('contact_script');
}

/**
 * To be able to recieve our Ajax request, we must have a function that handles it.
 * You add it with these two add_actions,the first one is for logged in users,
 * and the other is for non-logged in users.
*/
add_action("wp_ajax_contact_form_action", "save_contact_form");
add_action("wp_ajax_nopriv_contact_form_action", "save_contact_form");
function save_contact_form()
{
	// nonce check for an extra layer of security, the function will exit if it fails
	if (!wp_verify_nonce( $_REQUEST['nonce'], "contact_nonce"))
    {
		exit("Woof Woof Woof");
	}

    createNewPost();
    
	echo json_encode(['type' => 'success', 'message' => 'Mail sent']);
	wp_die();
}

/**
 * Here we create a short code to be used on the website page according to: [search_hello]
 * The first name inside [] is the first parameter with add_shortcode().
*/
add_shortcode('contact_form_hello', 'contact_form_says_hello');
function contact_form_says_hello( $atts = [], $content = null ) 
{
	//$latestPosts = new WP_Query();

    contact_form_showForm();
}

function contact_form_showForm()
{
    include plugin_dir_path( __FILE__ ) . 'contact_form.php';
}


/**
 * Here we create a new menu for admin
 */
add_action( 'admin_menu', 'contact_form_admin_menu' );
function contact_form_admin_menu() {
	add_menu_page(
		'Forms Recieved',
		'Show forms recieved',
		'manage_options',
		'contact_form_menu',
		'contact_form_admin_menu_page',
		'dashicons-learn-more',
		20
	);
}

/* We have extracted view code for the menu page and included it here */
function contact_form_admin_menu_page() 
{
	include plugin_dir_path( __FILE__ ) . 'admin/contact_form_menu_page.php';
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
		'post_content' => 'Mail: ' . $_POST['mail'] . '<br> Message: ' . $_POST['message'],
		'post_status'  => 'pending', //You have to manually publish it
		'post_author'  => 1,
		'post_type'    => 'contactforms',

		'meta_input'    => [
			'Client' => wp_strip_all_tags($_POST['name']),
            'Client Mail' => $_POST['mail'],
			'post_author_id' => $user_id
		    ])
    );
    
}

?>