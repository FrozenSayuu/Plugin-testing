<?php
/**
    * Plugin Name: Search Plugin
    * Plugin URI: https://example.com/plugins/the-basics/
    * Description: Display your reviews easy with this plugin.
    * Version: 1.0.0
    * Requires at least: 5.9
    * Requires PHP: 7.4
    * Author: John Smith
    * Author URI: https://author.example.com/
    * License: GPL v2 or later
    * License URI: https://www.gnu.org/licenses/gpl-2.0.html
    * Text Domain: search-plugin
    * Domain Path: /languages
*/

register_activation_hook( __FILE__, 'search_plugin_activated' );

//register_deactivation_hook(__FILE__, 'plugin_deactivated');

function search_plugin_activated()
{
	// create custom post types 
	flush_rewrite_rules();
}

/**
 * Here we create a short code to be used on the website page according to: [search_hello]
 * The first name inside [] is the first parameter with add_shortcode().
 */
add_shortcode( 'search_bar_hello', 'search_bar_says_hello' );
function search_bar_says_hello( $atts = [], $content = null ) 
{
	$content .= "<h2>Lämna en recension</h2>";

	//$latestPosts = new WP_Query();

    search_bar_showSearch();

	return $content;
}

function search_bar_showSearch()
{
    include plugin_dir_path( __FILE__ ) . 'search_bar.php';
}

?>