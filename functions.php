<?php
// Enable "Featured Images" for pages and posts
add_theme_support('post-thumbnails');

// Add ability to assign categories to pages (for portfolio)
function add_taxonomies_to_pages() {
	// register_taxonomy_for_object_type( 'post_tag', 'page' );
	register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'add_taxonomies_to_pages' );

// Remove stupid emoji icons
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove unnecessary WordPress admin menu items
function remove_menus() {
	// Posts
	remove_menu_page( 'edit.php' );
	// Comments
	remove_menu_page( 'edit-comments.php' );
	// Essential Grid
	remove_menu_page( 'edit.php?post_type=essential_grid' );
}
add_action( 'admin_menu', 'remove_menus' );
?>
