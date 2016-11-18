<?php
// This file is automatically loaded when an individual project post is displayed

// Get all the categories this project post is in
$taxonomy = 'essential_grid_category';
global $post;
// Get the list of custom categories that this project post is in
$custom_categories_array = wp_get_object_terms( $post->ID, $taxonomy);

// Create an associative array of the categories for easy access
$custom_categories_ass = array();
for ($i = 0; $i < count($custom_categories_array); $i++) {
	$category_slug = $custom_categories_array[$i] -> slug;
	$category_name = $custom_categories_array[$i] -> name;
	$custom_categories_ass[$category_slug] = $category_name;
}
?>

<?php
get_header();

// Start the loop
while ( have_posts() ) : the_post();
	// Get the referring URL, if it exists
	$referring_url = $_SERVER['HTTP_REFERER'];
	// If the referring URL is a strong (instead of NULL)
	if (gettype($referring_url) == "string") {
		// Get only the part after "?id="
		preg_match("/^.+?\\?id=(.+)$/is" , $referring_url, $match);
		$selected_category_slug = $match[1];
	}

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
			<p><strong>Description:</strong></p>
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
/* DISPLAY OTHER PROJECTS IN THE SAME CATEGORY										*/
/********************************************************************************/
echo '<br>';
echo '<h4>Other projects the same categories: ';
showCategories();
echo '</h4>';

$category_slugs = array();
foreach ($custom_categories_ass as $category_slug => $category_name) {
	array_push($category_slugs, $category_slug);
}

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
			'terms' => $category_slugs
			//'terms' => 'gis'
		)
	),
	// Only return the post ID's
	'fields' => 'ids'
);
// Get custom post ID's for the current custom category
$query_result = new WP_Query( $args );

// Pull out just the custom post ID's
$post_ids = $query_result -> posts;

/* REMOVE THE CURRENT PROJECT POST FROM THE LIST OF PROJECTS IN THE SAME CATEGORIES */
$project_post_ids = array();
// Iterate through the posts for Essential Grid categories
for ($i=0; $i < count($post_ids); $i++) {
	// If this is a category other than the one currently being displayed
	if ($post_ids[$i] != $post -> ID) {
		array_push($project_post_ids, $post_ids[$i]);
	}
}

// Convert the list of custom posts to a comma separated string
$essential_grid_posts_csv = implode(',', $project_post_ids);
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
	// Iterate through each category that contains this project post
	$i = 0;
	foreach ($custom_categories_ass as $category_slug => $category_name) {
		// If this is not the first category displayed, add a divider
		if ($i != 0) {
			echo ' &nbsp;|&nbsp; ';
		}
		$category_url = '/portfolio/category/?id=' . $category_slug;
		$category_name = $custom_categories_ass[$category_slug];
		echo '<a href="' . $category_url . '"';
		/* Unfortunately this is probably confusing to users
		// If we don't know which category was selected, or if this is a category other than the one selected
		if (!isset($selected_category_slug) || $selected_category_slug != $category_slug) {
			// Disable bold
			echo ' style="font-weight:normal;"';
		}
		*/
		echo ' style="font-weight:normal;"';
		echo '>' . $category_name . '</a>';
		// Increment the index
		$i++;
	}
}
?>
