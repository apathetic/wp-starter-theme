<?php 
/**
* @author stresslimit
* 
* Description: this file registers the custom content types and custom fields
*
*/


// Custom Content Types
// ------------------------------------------------
if (function_exists('sld_register_post_type')) {

	// projects
	sld_register_post_type( 'project', array( 'supports' => array('title', 'editor', 'thumbnail'), 'rewrite' => array( 'slug' => 'project' ), 'custom_icon' => 'star' ) );
	sld_register_taxonomy( 'project_type', array( 'project' ), 'Project Type' );

	// artists
	sld_register_post_type( 'artist', array( 'rewrite' => array( 'slug' => 'artist' ), 'custom_icon' => 'users' ) );

	// viiiideos
	sld_register_post_type( 'video', array( 'rewrite' => array( 'slug' => 'video' ), 'custom_icon' => 'rectangles' ) );
	// sld_register_taxonomy( 'mytaxonomy', array( 'mytype' ) );

}



// Content Connections
// ------------------------------------------------
function enmasse_connection_types() {
	// Make sure the Posts 2 Posts plugin is active.
	if ( !function_exists( 'p2p_register_connection_type' ) )
		return;

	p2p_register_connection_type( array(
		'name' => 'artists_to_projects',
		'from' => 'artist',
		'to' => 'project',
		'from_query_vars' => array(
			'posts_per_page' => -1,
		),
		'to_query_vars' => array(
			'posts_per_page' => -1,
		)
	) );

	p2p_register_connection_type( array(
		'name' => 'videos_to_projects',
		'from' => 'video',
		'to' => 'project',
		// 'admin_box' => 'from',
		'from_query_vars' => array(
			'posts_per_page' => -1,
		),
		'to_query_vars' => array(
			'posts_per_page' => -1,
		)
	) );
}
add_action( 'wp_loaded', 'enmasse_connection_types' );



// Custom Fields
// ------------------------------------------------
if (function_exists('x_add_metadata_group')) { // let's not get ourselves locked out of the site

	add_action( 'admin_init', 'sld_custom_fields');
	function sld_custom_fields() {
/*
		// projects
		x_add_metadata_group( 'related',			array('project'),	array('label' => 'Connected to this Project', 'priority' => 'high') );
		x_add_metadata_field( 'project_artists',	array('project'),	array('group' => 'related', 'label' => 'Artists', 'field_type' => 'text' ) );
		x_add_metadata_field( 'project_videos',		array('project'),	array('group' => 'related', 'label' => 'Videos', 'field_type' => 'text' ) );

		// video
		x_add_metadata_field( 'video_id',			array('video'),		array('group' => '', 'label' => 'Video ID', 'field_type' => 'text' ) );
*/

		// artist
		x_add_metadata_group( 'related',			array('artist'),	array('label' => 'Other Info', 'priority' => 'high') );
		x_add_metadata_field( 'artist_links',		array('artist'),	array('group' => 'related', 'label' => 'Links', 'field_type' => 'text', 'description' => 'A website URL like this: http://www.website.com/', 'multiple' => true));

	}

}

