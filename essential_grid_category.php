<?php
/*
Template Name: Essential Grid Category

This the template is used for the page that displays portfolio categories
*/

// Get the category "id" from the query string
$category_slug = $_GET['id'];

// Essential Grid custom category taxonomy
$post_type = 'essential_grid';
$taxonomy = 'essential_grid_category';
$field = 'slug';

/********************************************************************************/
/* GET ALL CUSTOM POSTS FOR THE CURRENT CUSTOM CATEGORY							*/
/********************************************************************************/
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
$post_ids = $query_result -> posts;
// If no posts are found for this category (which should never happen)
if (!count($post_ids)) {
	// Send an HTTP status code 404, tell the user, and abort the script
	header("HTTP/1.0 404 Not Found");
	echo "Project category not found";
	exit;
}

/********************************************************************************/
/* GET ALL THE CUSTOM CATEGORIES (To display the thumbnail image for the		*/
/* current category, and show an Essential Grid for all the other categories)	*/
/* NOTE: The slugs for the Essential Grid custom categories must exactly match	*/
/* the slugs for the associated Essential Grid custom posts 					*/
/********************************************************************************/
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

// Iterate through the posts for Essential Grid categories
$category_post_ids = array();
for ($i=0; $i < count($category_posts); $i++) {
	// If this is a category other than the one currently being displayed
	if ($category_posts[$i] -> post_name != $category_slug) {
		// Save the post ID for the OTHER category for later
		array_push($category_post_ids, $category_posts[$i] -> ID);
	} else {
		// Save the post ID for the CURRENT category for later
		$current_category_post_id = $category_posts[$i] -> ID;
	}
}

get_header();

/* Not sure whether we'll use this or not
// Display page content
while ( have_posts() ) : the_post();
the_content();
endwhile;
*/
?>

<h4><a href="/portfolio/">Portfolio of Steven Greenwaters</a></h4>
<?php
// Display the name of the current category
$category_name = get_term_by($field, $category_slug, $taxonomy) -> name;
echo '<h2>Project category: ' . $category_name . '</h2>';
// Display the thumbnail for the current project category
echo '<div>' . get_the_post_thumbnail($current_category_post_id, 'thumbnail') . '</div>';

/********************************************************************************/
/* DISPLAY PROJECTS IN THE CURRENT CATEGORY										*/
/********************************************************************************/
echo '<h4>Projects in this category:</h4>';
// Convert the list of custom posts to a comma separated string
$essential_grid_posts_csv = implode(',', $post_ids);
// Insert the "Essential Grid" plugin, and pass in the list of posts to display
echo do_shortcode('[ess_grid alias="portfolio" posts="' . $essential_grid_posts_csv . '"]');
/********************************************************************************/
/* END: DISPLAY PROJECTS IN THE CURRENT CATEGORY								*/
/********************************************************************************/
?>

<br>
<?php
/********************************************************************************/
/* DISPLAY OTHER PROJECT CATEGORIES												*/
/********************************************************************************/
?>
<h4>Other project categories:</h4>
<?php
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
