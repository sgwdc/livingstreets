<?php
/*
Template Name: Portfolio Homepage

This template is used for the portfolio homepage, /portfolio/
*/

// Get page ID's for the pages /portfolio/ and /portfolio/projects/
$portfolio_page_id = get_page_by_path('portfolio') -> ID;
$projects_page_id = get_page_by_path('portfolio/projects') -> ID;

// Get the page ID's for the portfolio sections (child pages of /portfolio/)
$args = array(
	'post_type' => 'page',
	'post_status' => 'publish',
	'post_parent' => $portfolio_page_id,
	// Omit the special-purpose /portfolio/projects/ placeholder page
	'exclude' => $projects_page_id,
	'orderby' => 'date',
	'order' => 'ASC',
	'posts_per_page' => -1,
	'fields' => 'ids'
);
$category_page_ids_array = get_posts( $args );

// Get the page ID's for _ALL_ individual projects (child pages of /portfolio/projects/)
$args = array(
	'post_type' => 'page',
	'post_status' => 'publish',
	'post_parent' => $projects_page_id,
	'orderby' => 'date',
	'order' => 'DESC',
	'posts_per_page' => -1,
	'fields' => 'ids'
);
$all_page_ids_array = get_posts( $args );
?>

<?php get_header(); ?>

<h2 class="page-title">Categories:</h2>

<?php
	// Convert the list of pages to a comma separated string
	$category_page_ids_csv = implode(',', $category_page_ids_array);
	// Insert the "Essential Grid" plugin, and pass in the list of pages to display
	echo do_shortcode('[ess_grid alias="portfolio" posts="' . $category_page_ids_csv . '"]');
?>

<div class="thick-section-divider"></div>
<h3>Individual Projects:</h3>
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
