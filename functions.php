<?php
// Enable "Featured Images" for pages and posts
add_theme_support('post-thumbnails');

// Add ability to assign categories to pages (for portfolio)
function add_taxonomies_to_pages() {
	// register_taxonomy_for_object_type( 'post_tag', 'page' );
	register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'add_taxonomies_to_pages' );
?>
