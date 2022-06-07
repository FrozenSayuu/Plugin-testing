<?php

if (!function_exists('testtheme_setup')) :
/**
* Sets up theme defaults and registers support for various WordPress features
*
*  It is important to set up these functions before the init hook so that none of these
*  features are lost.
*
*  @since TestTheme 1.0
*/
function testtheme_setup()
{
    register_nav_menus( array(
        'primary' => esc_html__( 'Main navigation', 'testtheme' ), /* Navigation menu for the header */
        'footer' => esc_html__( 'Footer navigation', 'testtheme' ), /* Navigation menu for the footer */
    ));
}

add_action('after_setup_theme', 'testtheme_setup');

function add_theme_scripts()
{
    wp_enqueue_style( 'style', get_stylesheet_uri() );
}

add_action('wp_enqueue_scripts', 'add_theme_scripts');

function comments() {
	register_post_type( 'comments', [
		'labels'      => [
			'name'          => __( 'Comment', 'testtheme' ),
			'singular_name' => __( 'Comment', 'testtheme' ),
		],
		'public'      => true,
		'has_archive' => true,
		'rewrite'     => ['slug' => 'comments'],
		'menu_icon'   => '',
		'supports'    => ['title', 'editor', 'thumbnail', 'custom-fields'],
	] );
}

add_action( 'init', 'comments', 5 );

endif;