<?php

// Define the version so we can easily replace it throughout the theme
define( 'SKELETON_VERSION', 1.0 );


/*  Set the maximum allowed width for any content in the theme */
if ( ! isset( $content_width ) ) $content_width = 900;

/* Add Rss feed support to Head section */
add_theme_support( 'automatic-feed-links' );

add_theme_support('post-thumbnails');
add_theme_support('post-tags');

/* Register main menu for Wordpress use */
register_nav_menus( 
	array(
		'primary'	=>	__( 'Primary Menu', '' ), // Register the Primary menu
		// Copy and paste the line above right here if you want to make another menu, 
		// just change the 'primary' to another name
	)
);


/* Activate sidebar for Wordpress use */
function skeleton_register_sidebars() {
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'sidebar', 					// Make an ID
		'name' => 'Sidebar',				// Name it
		'description' => 'Take it on the side...', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar, 
		// just change the values of id and name to another word/name
	));
} 

// adding sidebars to Wordpress (these are created in functions.php)
add_action( 'widgets_init', 'skeleton_register_sidebars' );

/* Enqueue Styles and Scripts */

function skeleton_scripts()  { 

	// get the theme directory style.css and link to it in the header
	wp_enqueue_style('style.css', get_stylesheet_directory_uri() . '/dist/css/style.min.css?r=5&counter=<?php echo time(); ?>');
	
	// add theme scripts
	wp_enqueue_script( 'skeleton', get_template_directory_uri() . '/dist/js/scripts.js', array(), SKELETON_VERSION, true );
  
}
add_action( 'wp_enqueue_scripts', 'skeleton_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header


function excerpt($num) {
    $limit = $num+1;
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt)."... (<a href='" .get_permalink($post->ID) ." '>Read more</a>)";
    echo $excerpt;
}
function template_chooser($template)   
{    
  global $wp_query;   
  $post_type = get_query_var('post_type');   
  if( $wp_query->is_search )   
  {
    return locate_template('search.php');  //  redirect to archive-search.php
  }   
  return $template;   
}
add_filter('template_include', 'template_chooser');