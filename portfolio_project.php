<?php
/*
Template Name: Portfolio Project

This template is used for pages under the /portfolio/projects/ page, which display a portfolio project
*/

// Get the categories that this page _IS_ in
global $post;
$args = array(
	'fields' => 'all',
);
$current_categories_array = wp_get_post_categories( $post->ID, $args);

// Get the category IDs that this page _IS_ in
$args = array(
	'fields' => 'ids',
);
$current_categories_ids_array = wp_get_post_categories( $post->ID, $args);

// Get all the categories that this page is _NOT_ in
$args = array(
	'exclude' => $current_categories_ids_array,
);
$other_categories_array = get_categories( $args);

// Get all the page ID's in the same categories as this page
$args = array(
	'category__in'         => $current_categories_ids_array,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post__not_in'          => array($post -> ID),
	'post_type'        => 'page',
	'post_status'      => 'publish',
	'fields' => 'ids'
);
$other_pages = new WP_Query( $args );
$other_page_ids_array = $other_pages -> posts;

get_header();

$post_status = get_post_status();
if ($post_status != "publish") {
	echo '<h1 class="admin-notice">This Page Will Not Be Displayed Publicly Because Post Status = ' . $post_status . '</h1>';
}
?>

<h4><a href="/portfolio/">Portfolio of Steven Greenwaters</a></h4>
<?php
// Start the loop
while ( have_posts() ) : the_post();

	echo '<h2 class="project-title">';
	// Display the page title
	echo get_the_title();
	// Link to the "Edit" page if the user has access
	edit_post_link(
		sprintf(
			__( 'Edit project' ),
			get_the_title()
		),
		'<span class="edit-link"> &nbsp;&nbsp; [ ',
		' ]</span>'
	);
	echo '</h2>';

	echo '<h5 class="categories">Categories: &nbsp;';
	showCategories($current_categories_array);
	echo '</h5>';
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		/* Not sure whether we'll use this or not
			the_excerpt();
		*/
		?>

		<!-- Display the page content -->
		<div class="entry-content">
			<br>
			<p class="description"><strong>Description:</strong></p>
			<?php
				the_content();
			?>
		</div>

		<!-- Display the page's Featured Image -->
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	</article><!-- #post-## -->

<?php
// End of the loop
endwhile;

// Display other pages in the same category/categories
?>
<br>
<h4>Other projects in the same categor<?php
	if (count($current_categories_array) > 1) {
		echo 'ies';
	} else {
		echo 'y';
	}
?>: &nbsp;
<?php
showCategories($current_categories_array);
echo '</h4>';

// Convert the list of pages to a comma separated string
$other_page_ids_csv = implode(',', $other_page_ids_array);
// Insert the "Essential Grid" plugin, and pass in the list of pages to display
echo do_shortcode('[ess_grid alias="portfolio_small" posts="' . $other_page_ids_csv . '"]');
?>

<?php
// Display categories this page is _NOT_ in
?>
<br>
<h4>Other categories: &nbsp; <?php showCategories($other_categories_array); ?></h4>

<br>
<p><a href="/portfolio/">Return to all projects</a></p>
<p><a href="/">Home</a></p>

<p>&nbsp;</p>

<?php get_footer(); ?>

<?php
// Used to show categories the current page IS in, and categories the page is NOT in
function showCategories($categories_array) {
	// Iterate through each category
	$num_displayed = 0;
	foreach ($categories_array as $i => $category_object) {
		// If this is not the first category displayed, add a divider
		if ($num_displayed != 0) {
			echo ' &nbsp;|&nbsp; ';
		}
		$category_url = '/portfolio/' . $category_object -> slug;
		$category_name = $category_object -> name;
		echo '<a href="' . $category_url . '"';
		echo ' style="font-weight:normal;"';
		echo '>' . $category_name . '</a>';
		$num_displayed++;
	}
}
?>
