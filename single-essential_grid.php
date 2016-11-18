<?php
// This file is automatically loaded when an individual project post is displayed

// Get all the categories this project post is in
$taxonomy = 'essential_grid_category';
global $post;
// Run the query
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

// If we know the name of the referring category page, display and link to it
if (isset($selected_category_slug)) {
	// Link to this category
	$category_url = '/portfolio/category/?id=' . $selected_category_slug;
	echo '<p><a href="' . $category_url . '">Return to all ' . $custom_categories_ass[$selected_category_slug] . ' projects</a></p>';
}
?>

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
