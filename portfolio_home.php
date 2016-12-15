<?php
/*
Template Name: Portfolio Homepage

This template is used for the portfolio homepage, /portfolio/
*/
// Get all the page ID's for all projects
$args = array(
	'orderby' => 'date',
	'order' => 'DESC',
	'post__not_in' => array($post -> ID),
	'post_type' => 'page',
	'post_status' => 'publish',
	'fields' => 'ids'
);
$all_pages = new WP_Query( $args );
$all_page_ids_array = $all_pages -> posts;

/********************************************************************************/
/* GET THE PAGES FOR _ALL_ THE PORTFOLIO SECTIONS (CHILD PAGES OF THE PAGE WITH	*/
/* THE SLUG "PORTFOLIO")														*/
/********************************************************************************/
$portfolio_page_id = get_page_by_path('portfolio') -> ID;
$projects_page_id = get_page_by_path('portfolio/projects') -> ID;
$args = array(
	'post_type' => 'page',
	'post_parent' => $portfolio_page_id,
	'exclude' => $projects_page_id,
	'orderby' => 'date',
	'order' => 'ASC',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'fields' => 'ids'
);
$category_page_ids_array = get_posts( $args );
?>

<?php get_header(); ?>

<h2>Portfolio of Steven Greenwaters</h2>
<h4>Please select a category:</h4>

<?php
	// Convert the list of pages to a comma separated string
	$category_page_ids_csv = implode(',', $category_page_ids_array);
	// Insert the "Essential Grid" plugin, and pass in the list of pages to display
	echo do_shortcode('[ess_grid alias="portfolio" posts="' . $category_page_ids_csv . '"]');
?>

<div class="section-divider"></div>
<h4>Or select a specific project:</h4>
<?php
	// Convert the list of pages to a comma separated string
	$all_page_ids_csv = implode(',', $all_page_ids_array);
	// Insert the "Essential Grid" plugin, and pass in the list of pages to display
	echo do_shortcode('[ess_grid alias="portfolio_small" posts="' . $all_page_ids_csv . '"]');
?>

<?php
	include('portfolio_footer.php');
?>

<?php get_footer(); ?>
