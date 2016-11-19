<?php
/*
Template Name: Portfolio Section

This the template is used for pages under the "Portfolio" page that display a portfolio section
*/

global $post;
$section_slug = $post -> post_name;
$section_name = $post -> post_title;
// NOTE: The slug for the page must exactly match the slug for the Essential Grid category
$custom_category_slug = $section_slug;

/********************************************************************************/
/* GET ALL CUSTOM POSTS FOR THE CUSTOM CATEGORY WITH THE SAME SLUG AS THIS		*/
/* SECTION																		*/
/********************************************************************************/
// Essential Grid custom category taxonomy
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
			'terms' => $custom_category_slug
		)
	),
	// Only return the post ID's
	'fields' => 'ids'
);
// Get custom post ID's for the current custom category
$query_result = new WP_Query( $args );
$custom_category_post_ids = $query_result -> posts;
// If no posts are found for this category (which should hopefully never happen)
if (!count($custom_category_post_ids)) {
	// Send an HTTP status code 404, tell the user, and abort the script
	header("HTTP/1.0 404 Not Found");
	echo "Project category not found";
	exit;
}

/********************************************************************************/
/* GET POST ID'S FOR ALL THE OTHER PORTFOLIO SECTIONS (CHILD PAGES OF THE PAGE	*/
/* WITH THE SLUG "PORTFOLIO")													*/
/********************************************************************************/
$portfolio_page_id = get_page_by_path('portfolio') -> ID;
$projects_page_id = get_page_by_path('portfolio/projects') -> ID;
$current_section_page_id = $post -> ID;
$args = array(
	'post_type'        => 'page',
	'post_parent'      => $portfolio_page_id,
	'exclude'          => array($projects_page_id, $current_section_page_id),
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_status'      => 'publish',
	'posts_per_page'   => -1,
	// Only return the post ID's
	'fields' => 'ids'
);
$other_sections_ids = get_posts( $args );

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
// Display the name of the current section
echo '<h2>Project category: ' . $section_name . '</h2>';
// Display the thumbnail image for the current project section
echo '<div>' . get_the_post_thumbnail(null, 'thumbnail') . '</div>';

/********************************************************************************/
/* DISPLAY CUSTOM POSTS IN THE CUSTOM CATEGORY ASSOCIATED WITH THE CURRENT		*/
/* PORTFOLIO SECTION															*/
/********************************************************************************/
echo '<h4>Projects in this category:</h4>';
// Convert the list of custom posts to a comma separated string
$custom_category_post_ids_csv = implode(',', $custom_category_post_ids);
// Insert the "Essential Grid" plugin, and pass in the list of posts to display
echo do_shortcode('[ess_grid alias="portfolio" posts="' . $custom_category_post_ids_csv . '"]');
/********************************************************************************/
/* END: DISPLAY CUSTOM POSTS IN THE CUSTOM CATEGORY ASSOCIATED WITH THE CURRENT	*/
/* PORTFOLIO SECTION															*/
/********************************************************************************/
?>

<br>
<?php
/********************************************************************************/
/* DISPLAY OTHER PORTFOLIO SECTIONS												*/
/********************************************************************************/
?>
<h4>Other project categories:</h4>
<?php
// Convert the list of custom posts to a comma separated string
$other_sections_ids_csv = implode(',', $other_sections_ids);
// Insert the "Essential Grid" plugin, and pass in the list of posts to display
echo do_shortcode('[ess_grid alias="portfolio2" posts="' . $other_sections_ids_csv . '"]');
/********************************************************************************/
/* END: DISPLAY OTHER PORTFOLIO SECTIONS										*/
/********************************************************************************/
?>

<br>
<p><a href="/portfolio/">Return to all projects</a></p>
<p><a href="/">Home</a></p>
<p>&nbsp;</p>

<?php get_footer(); ?>
