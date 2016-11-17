<?php
/*
Template Name: Essential Grid Category

This is the template used to display portfolio project categories.
*/

// Get the category "id" from the query string
$category_slug = $_GET['id'];
$field = 'slug';
$taxonomy = 'essential_grid_category';

// Define arguments for WP_Query() 
$args = array(
	// Custom post type for the Essential Grid plugin
	'post_type' => 'essential_grid',
	// Custom taxonomy
	'tax_query' => array(
		array(
			// Custom category for custom post type
			'taxonomy' => $taxonomy,
			// Specify that the "terms" below is the slug for the requested category - NOTE: "field" can also be: term_id, name, or term_taxonomy_id (default is term_id)
			'field' => $field,
			// Specify the slug for the category - NOTE: "terms" can also be an array
			'terms' => $category_slug
		)
	),
	// Only return the post ID's
	'fields' => 'ids'
);
// Run the query
$query_result = new WP_Query( $args );
/* dev
echo '<pre>';
print_r($query_result);
echo '<pre>';
*/

// Pull out just the custom post ID's
$post_ids = $query_result -> posts;

// If no posts are found for this category (which should never happen)
if (!count($post_ids)) {
	// Send an HTTP status code 404, tell the user, and abort the script
	header("HTTP/1.0 404 Not Found");
	echo "Project category not found";
	exit;
}

get_header();
?>
	<h2><img src="<?php bloginfo('template_directory'); ?>/images/livingstreets_logo_30px.png" align="absmiddle"> Living Streets Consulting</h2>

	<?php
		// Display page content
		while ( have_posts() ) : the_post();
		the_content();
		endwhile;

		// Get the name of the category
		$category_name = get_term_by($field, $category_slug, $taxonomy) -> name;
		echo '<h1>Projects: ' . $category_name . '</h1>';
		// Convert the list of custom posts to a comma separated string
		$essential_grid_posts_csv = implode(',', $post_ids);
		// Insert the "Essential Grid" plugin, and pass in the list of posts to display
		echo do_shortcode('[ess_grid alias="portfolio" posts="' . $essential_grid_posts_csv . '"]');
	?>

	<h3>Other project categories:</h3>
	<p>Insert here</p>

	<p><a href="/">Home</a></p>
	<p>&nbsp;</p>

<?php get_footer(); ?>
