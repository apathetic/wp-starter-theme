<?php
include_once('inc/general.php');			// set-up wordpress in a way that I like. Hide this and that, change a few things around
include_once('inc/types.php');				// define additional content types: videos, recipes, photos (articles are just "posts", renamed)
include_once('inc/helpers.php');			// various helper functions live here
include_once('inc/widgets.php');			// set-up / define widgets n' things
include_once('inc/ajax.php');				// infinite page thing, carousel loading


add_action( 'init', 'bitchin_engage' );
function bitchin_engage() {

add_image_size( 'thumbnail-widget', 128, 90, true );

// update_option('thumbnail_size_w', 132);
// update_option('thumbnail_size_h', 110);
// 
// update_option('medium_size_w', 300);
// update_option('medium_size_h', 9999);

// update_option('large_size_w', 610);
// update_option('large_size_h', 9999);



	if ( is_admin() ) include_once('inc/featured.php');			// adds checkboxes 
	if ( ! is_admin() ) {

		wp_deregister_script( 'l10n' );
		wp_deregister_script( 'jquery');
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js', false, '1.8.1');
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'masonry', get_bloginfo('template_url').'/js/jquery.masonry.min.js', 'jquery' );
		wp_enqueue_script( 'bitchin', get_bloginfo('template_url').'/js/bitchin.min.js', 'jquery' );
		wp_localize_script( 'bitchin', 'bitchin', array( 'ajax' => admin_url( 'admin-ajax.php' )));  

		wp_enqueue_style( 'style', get_bloginfo('stylesheet_url') );

	}

}





/* Flush cache when post is saved */
function clearCache($post_ID)  {
	// if (function_exists('w3tc_pgcache_flush')) {
	// 	w3tc_pgcache_flush();
	// } 
	if (function_exists('w3tc_pgcache_flush_post')) {
		w3tc_pgcache_flush_post($post_ID);
	}
	return $post_ID;
}
add_action('wp_insert_post_data', 'clearCache');




/*
flush_pgcache()  //page cache
flush_dbcache()  // database cache
flush_minify()  // minify cache
flush_all() //all caches


// and you just need to call it like this:

 $w3_plugin_totalcache->flush_all();
*/





?>