<?php
/*
Template Name: Portfolio Homepage

This template is used for the portfolio homepage, /portfolio/
*/


// Get all the page ID's for all projects
$args = array(
//	'category__in'         => $current_categories_ids_array,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post__not_in'          => array($post -> ID),
	'post_type'        => 'page',
	'post_status'      => 'publish',
	'fields' => 'ids'
);
$all_pages = new WP_Query( $args );
$all_page_ids_array = $all_pages -> posts;
?>

<?php get_header(); ?>

<?php
?>

<!-- Create a DIV exactly as wide as the content -->
<!--
<div style="display: inline-block; margin:0 auto; border:1px #f00 solid;">
-->

<h2>Portfolio of Steven Greenwaters</h2>
<h4>Please select a category:</h4>

<?php
// Insert the "Essential Grid" plugin, and pass in the list of pages to display
echo do_shortcode('[ess_grid alias="portfolio"]');
?>

<h4><br>Or select a specific project:</h4>
<?php
// Convert the list of pages to a comma separated string
$all_page_ids_csv = implode(',', $all_page_ids_array);
// Insert the "Essential Grid" plugin, and pass in the list of pages to display
echo do_shortcode('[ess_grid alias="portfolio_small" posts="' . $all_page_ids_csv . '"]');
?>

<p>&nbsp;</p>

<?php
	include('portfolio_footer.php');
?>

<?php get_footer(); ?>
