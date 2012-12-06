<?php

// -------------------------------------
//	Enable/Disable WordPress stuff
// -------------------------------------

	// remove junk from head
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

	// add post thumbnail support + custom menu support
	add_theme_support('post-thumbnails');
	add_theme_support('nav-menus');
	
	// remove unwanted core dashboard widgets
	function rm_dashboard_widgets() {
		global $wp_meta_boxes;
		// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);		// right now [content, discussion, theme, etc]
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);			// plugins
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);	// incoming links
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);			// wordpress blog
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);			// other wordpress news
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);		// quickpress
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);		// drafts
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);	// comments
	}
	add_action('wp_dashboard_setup', 'rm_dashboard_widgets' );

	// manage backend items
	function manage_menu_items() {
		remove_menu_page('link-manager.php');
		remove_menu_page('edit-comments.php');
	}
	add_action('admin_menu', 'manage_menu_items', 99);

	function load_styles() {
		echo '<style>#login{ padding-top:64px; } #login h1 a { background:transparent url("'.get_bloginfo('template_url').'/images/logos/logo.png") 50% 50% no-repeat; height:200px; padding:0; }</style>'."\n";
	}
	add_action('login_head', 'load_styles');

	// add parent class to menu item with children
	function add_parent_class( $css_class, $page, $depth, $args ) {
		if ( ( $args['has_children'] ) ) 
			$css_class[] = 'parent';
		return $css_class;
	}
	add_filter( 'page_css_class', 'add_parent_class', 10, 4 );


// -------------------------------------
//	Misc
// -------------------------------------
	
	// add "selected" class to parent menu item when on child page
	function top_nav_classes( $current_classes, $item ) {
		global $post;

		$classes[] = ''; // notice how we make a brand-new array and don't use $current_classes
		if( is_single() || is_404() || is_home() ) return $classes;
		if (is_page() && $post->post_parent) {		// we're on a sub-page
			$parent = $post->post_parent;
			if ($parent == get_post_meta($item->ID, '_menu_item_object_id', true)) { $classes[] .= 'selected'; }
		} else {
			if($post->ID == get_post_meta($item->ID, '_menu_item_object_id', true)) { $classes[] .= 'selected'; }
		}

		return $classes;
	}
	add_filter( 'nav_menu_css_class', 'top_nav_classes', 10, 2 );


	// simple, clean - single class on body
	function clean_body_classes($classes, $class='') {
		global $post;
		if ( is_page() ){
			$slug = ($post->post_parent) ? basename(get_permalink($post->post_parent)) : basename(get_permalink());
		} else {
			$slug = (is_archive()) ? 'archive '.get_post_type($post->ID) : '';
		}

		$newclass = array($slug);
		return $newclass;
	}
	add_filter('body_class','clean_body_classes');


	// make cleaner better permalink urls
	function url_cleaner_clean($slug) {
		// remove everything except letters, numbers and -
		$pattern = '~([^a-z0-9\-])~i';
		$replacement = '';
		$slug = preg_replace($pattern, $replacement, $slug);
	
		// when more than one - , replace it with one only
		$pattern = '~\-\-+~';
		$replacement = '-';
		$slug = preg_replace($pattern, $replacement, $slug);
	
		return $slug;
	}
	// add_filter('editable_slug', 'url_cleaner_clean');


	// this is here as file_get_contents() doesn't work on (mt)
	function get_data($url){
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

?>