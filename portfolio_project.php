<?php
/*
Template Name: Portfolio Project

This template is used for pages under the /portfolio/projects/ page, which display a portfolio project
*/

// Get the categories that this page _IS_ in
global $post;
$args = array(
	'fields' => 'all'
);
$current_categories_array = wp_get_post_categories( $post->ID, $args );

// Get the category IDs that this page _IS_ in
$args = array(
	'fields' => 'ids'
);
$current_categories_ids_array = wp_get_post_categories( $post->ID, $args );

// Get the page slugs for all the categories that this page is _NOT_ in
$args = array(
	'exclude' => $current_categories_ids_array,
	'fields' => 'id=>slug'
);
$other_categories_array = get_categories( $args );

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
	'order' => 'DESC',
	'post_status' => 'publish',
	'posts_per_page' => -1
);
$category_pages_array = get_posts( $args );
/********************************************************************************/
/* GET THE PAGE ID'S FOR ONLY THE "OTHER" PORTFOLIO SECTIONS					*/
/********************************************************************************/
// Create an array to hold the page ID's for the "other" category pages
$other_category_page_ids_array = array();
// Iterate over all the category pages
for ($oneCategoryPage=0; $oneCategoryPage < count($category_pages_array); $oneCategoryPage++) {
	$post_name = $category_pages_array[$oneCategoryPage] -> post_name;
	// If this category page correlates (has the same slug) as one of the "other" categories
	if (in_array($post_name, $other_categories_array)) {
		// Save the page ID for later
		$ID = $category_pages_array[$oneCategoryPage] -> ID;
		array_push($other_category_page_ids_array, $ID);
	}
}

// Get all the page ID's in the same categories as this page
$args = array(
	'category__in' => $current_categories_ids_array,
	'orderby' => 'date',
	'order' => 'DESC',
	'post__not_in' => array($post -> ID),
	'post_type' => 'page',
	'post_status' => 'publish',
	'fields' => 'ids'
);
$other_pages = new WP_Query( $args );
$other_page_ids_array = $other_pages -> posts;

get_header();

$post_status = get_post_status();
if ($post_status != "publish") {
	echo '<h1 class="admin-notice">This Page Will Not Be Displayed Publicly Because Post Status = ' . $post_status . '</h1>';
}

// Breadcrumbs
echo '<h5 class="breadcrumbs"><a href="/portfolio/">Portfolio Homepage</a> &nbsp; &gt; &nbsp; ';
showCategories($current_categories_array);
echo '</h5>';

echo '<div id="body-content">';

// Start the loop
while ( have_posts() ) : the_post();
	echo '<h2 class="project-title">Project: ';
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
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		// If the project has a description, display it
		$the_content = get_the_content();
		if (strlen($the_content) > 0) {
		?>
			<?php /* Display the page content */ ?>
			<div class="entry-content">
				<p class="description"><strong>Description:</strong></p>
				<?php
				// Don't use get_the_content() to display the project description because it doesn't pass through the "the_content" filter
				the_content();
				?>
			</div>
		<?php
		}
		?>
	</article>

<?php
// End of the loop
endwhile;

echo '</div>';

// Display other pages in the same category/categories
?>
<br>
<h4>Additional projects in the same categor<?php
	if (count($current_categories_array) > 1) {
		echo 'ies';
	} else {
		echo 'y';
	}
?>: &nbsp;<span class="non-bold">(
<?php
showCategories($current_categories_array);
echo ' )</span></h4>';

// Convert the list of pages to a comma separated string
$other_page_ids_csv = implode(',', $other_page_ids_array);
// Insert the "Essential Grid" plugin, and pass in the list of pages to display
echo do_shortcode('[ess_grid alias="portfolio_small" posts="' . $other_page_ids_csv . '"]');
?>

<?php
// Display categories this page is _NOT_ in
?>

<br>
<h4>Other categories:</h4>
<?php
// Convert the list of pages to a comma separated string
$other_category_page_ids_csv = implode(',', $other_category_page_ids_array);
// Insert the "Essential Grid" plugin, and pass in the list of pages to display
echo do_shortcode('[ess_grid alias="portfolio" posts="' . $other_category_page_ids_csv . '"]');
?>
<br>

<?php
	include('portfolio_footer.php');
?>

<br>

<p><a href="/portfolio/">Go back to portfolio homepage</a></p>

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
		echo '>' . $category_name . '</a>';
		$num_displayed++;
	}
}
?>
