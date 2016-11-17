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

<?php get_header(); ?>

	<?php
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

			echo '<h3><a href="/portfolio/">Portfolio of Steven Greenwaters</a> &nbsp;&raquo;&nbsp; ';
			// If we know the name of the referring category page, display and link to it
			if (isset($selected_category_slug)) {
				// Link to this category
				$category_url = '/portfolio/category/?id=' . $selected_category_slug;
				echo '<a href="' . $category_url . '">' . $custom_categories_ass[$selected_category_slug] . '</a>';
			// Otherwise display the word "Project"
			} else {
				echo 'Project';
			}
			// Separator
			echo ' &nbsp;&raquo;&nbsp; ';
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
			echo '</h3>';
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
				// If we know which category the user selected
				if (isset($selected_category_slug)) {
					echo '<h5>Also in categories: ';
				} else {
					echo '<h5>In categories: ';
				}

				$i = 0;
				// Iterate through each category that contains this project post
				foreach ($custom_categories_ass as $category_slug => $category_name) {
					// If we don't know which category was selected, or if this is a category other than the one selected
					if (!isset($selected_category_slug) || $selected_category_slug != $category_slug) {
						// If this is not the first category displayed, add a divider
						if ($i != 0) {
							echo ' &nbsp;|&nbsp; ';
						}
						$category_url = '/portfolio/category/?id=' . $category_slug;
						$category_name = $custom_categories_ass[$category_slug];
						echo '<a href="' . $category_url . '">' . $category_name . '</a>';
					}
					// Increment the index
					$i++;
				}
				echo '</h5>';
				?>

				<?php
				/* Not sure whether we'll use this or not
					the_excerpt();
				*/
				?>

				<!-- Display the post content -->
				<div class="entry-content">
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
	?>

	<p><a href="/portfolio/">Portfolio Homepage</a></p>
	<p><a href="/portfolio/">Home</a></p>

	<p>&nbsp;</p>

<?php get_footer(); ?>
