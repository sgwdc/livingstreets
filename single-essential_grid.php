<?php
// This file is automatically loaded when an individual project is displayed
// e.g. http://livingstreets.com/essential_grid/modeling-pedestrian-behavior-space-syntax/

// Essential Grid custom category taxonomy
$post_type = 'essential_grid';
$taxonomy = 'essential_grid_category';
$field = 'slug';

/********************************************************************************/
/* GET ALL THE CUSTOM CATEGORIES THAT THIS CUSTOM POST IS IN					*/
/********************************************************************************/
global $post;
// Get the list of custom categories that this project post is in
$custom_categories_array = wp_get_object_terms( $post->ID, $taxonomy);
// Create an associative array of the categories for easy access later
$custom_categories_ass = array();
for ($i = 0; $i < count($custom_categories_array); $i++) {
	$category_slug = $custom_categories_array[$i] -> slug;
	$category_name = $custom_categories_array[$i] -> name;
	$custom_categories_ass[$category_slug] = $category_name;
}
// Create an array of slugs for all the custom categories this custom post is in
$category_slugs = array();
foreach ($custom_categories_ass as $category_slug => $category_name) {
	array_push($category_slugs, $category_slug);
}

/********************************************************************************/
/* GET ALL THE CUSTOM POSTS IN THE SAME CUSTOM CATEGORIES AS THIS CUSTOM POST	*/
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
			'terms' => $category_slugs
		)
	),
	// Only return the post ID's
	'fields' => 'ids'
);
// Get custom post ID's for the current custom category
$query_result = new WP_Query( $args );
$post_ids = $query_result -> posts;
// Remove the current custom post from the array of all custom posts in the same custom categories as the current post
for ($i=0; $i < count($post_ids); $i++) {
	// If this is a custom post other than the one currently being displayed
	if ($post_ids[$i] == $post -> ID) {
		unset($post_ids[$i]);
	}
}

get_header();

// Start the loop
while ( have_posts() ) : the_post();
	echo '<h4><a href="/portfolio/">Portfolio of Steven Greenwaters</a></h4>';

	echo '<h2 class="project-title">';
	// Display the project title
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
	showCategories();
	echo '</h5>';
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		/* Not sure whether we'll use this or not
			the_excerpt();
		*/
		?>

		<!-- Display the post content -->
		<div class="entry-content">
			<br>
			<p class="description"><strong>Description:</strong></p>
			<?php
				the_content();
			?>
		</div>

		<!-- Display the project's Featured Image -->
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	</article><!-- #post-## -->

<?php
// End of the loop
endwhile;

/********************************************************************************/
/* DISPLAY OTHER CUSTOM POSTS IN THE SAME CUSTOM CATEGORY						*/
/********************************************************************************/
?>
<br>

<h4>Other projects in the same categor<?php
	if (count($custom_categories_ass) > 1) {
		echo 'ies';
	} else {
		echo 'y';
	}
?>: &nbsp;
<?php
showCategories();
echo '</h4>';

// Convert the list of custom posts to a comma separated string
$essential_grid_posts_csv = implode(',', $post_ids);
// Insert the "Essential Grid" plugin, and pass in the list of posts to display
echo do_shortcode('[ess_grid alias="portfolio2" posts="' . $essential_grid_posts_csv . '"]');
?>
<br>
<p><a href="/portfolio/">Return to all projects</a></p>
<p><a href="/">Home</a></p>

<p>&nbsp;</p>

<?php get_footer(); ?>

<?php
function showCategories() {
	global $custom_categories_ass;
	// Iterate through each custom category that contains this custom post
	$i = 0;
	foreach ($custom_categories_ass as $category_slug => $category_name) {
		// If this is not the first category displayed, add a divider
		if ($i != 0) {
			echo ' &nbsp;|&nbsp; ';
		}
		$category_url = '/portfolio/category/?id=' . $category_slug;
		$category_name = $custom_categories_ass[$category_slug];
		echo '<a href="' . $category_url . '"';
		echo ' style="font-weight:normal;"';
		echo '>' . $category_name . '</a>';
		// Increment the index
		$i++;
	}
}
?>
