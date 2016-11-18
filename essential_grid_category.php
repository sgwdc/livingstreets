<?php
/*
Template Name: Essential Grid Category

This is the template used to display portfolio project categories.
*/

// Get the category "id" from the query string
$category_slug = $_GET['id'];

$post_type = 'essential_grid';
$taxonomy = 'essential_grid_category';
$field = 'slug';

// Define arguments for WP_Query() 
$args = array(
	// Custom post type for the Essential Grid plugin
	'post_type' => $post_type,
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
// Get custom post ID's for the current custom category
$query_result = new WP_Query( $args );
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

/* Not sure whether we'll use this or not
// Display page content
while ( have_posts() ) : the_post();
the_content();
endwhile;
*/

// Get the name of the category
$category_name = get_term_by($field, $category_slug, $taxonomy) -> name;
echo '<h4><a href="/portfolio/">Portfolio of Steven Greenwaters</a></h4>';

echo '<h2>Project category: ' . $category_name . '</h2>';

/********************************************************************************/
/* DISPLAY PROJECTS IN THE CURRENT CATEGORY										*/
/********************************************************************************/
echo '<h4>Please select a project:</h4>';

// Convert the list of custom posts to a comma separated string
$essential_grid_posts_csv = implode(',', $post_ids);
// Insert the "Essential Grid" plugin, and pass in the list of posts to display
echo do_shortcode('[ess_grid alias="portfolio" posts="' . $essential_grid_posts_csv . '"]');

/********************************************************************************/
/* END: DISPLAY PROJECTS IN THE CURRENT CATEGORY								*/
/********************************************************************************/

/********************************************************************************/
/* DISPLAY OTHER PROJECT CATEGORIES												*/
/********************************************************************************/
?>
<br>
<h4>Other project categories:</h4>
<?php
/* NOTE: THE SLUGS FOR THE ESSENTIAL GRID CATEGORIES MUST MATCH THE ASSOCIATED ESSENTIAL GRID CUSTOM POSTS FOR THOSE CATEGORIES */
// Define arguments for WP_Query() 
$args = array(
	// Custom post type for the Essential Grid plugin
	'post_type' => $post_type,
	// Custom taxonomy
	'tax_query' => array(
		array(
			// Custom category for custom post type
			'taxonomy' => $taxonomy,
			// Specify that the "terms" below is the slug for the requested category - NOTE: "field" can also be: term_id, name, or term_taxonomy_id (default is term_id)
			'field' => $field,
			// Specify the slug for the category - NOTE: "terms" can also be an array
			'terms' => '0-categories'
		)
	)
);
// Run the query
$query_result = new WP_Query( $args );
$category_posts = $query_result -> posts;

/* REMOVE THE CURRENT CATEGORY FROM THE LIST */
$category_post_ids = array();
// Iterate through the posts for Essential Grid categories
for ($i=0; $i < count($category_posts); $i++) {
	// If this is a category other than the one currently being displayed
	if ($category_posts[$i] -> post_name != $category_slug) {
		array_push($category_post_ids, $category_posts[$i] -> ID);
	}
}

// Convert the list of custom posts to a comma separated string
$category_post_ids_csv = implode(',', $category_post_ids);

// Insert the "Essential Grid" plugin, and pass in the list of posts to display
echo do_shortcode('[ess_grid alias="portfolio2" posts="' . $category_post_ids_csv . '"]');
/********************************************************************************/
/* END: DISPLAY OTHER PROJECT CATEGORIES										*/
/********************************************************************************/
?>

<br>
<p><a href="/portfolio/">Return to all projects</a></p>
<p><a href="/">Home</a></p>
<p>&nbsp;</p>

<?php get_footer(); ?>
