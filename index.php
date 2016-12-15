<?php get_header(); ?>

<?php
	$post_status = get_post_status();
	if ($post_status != "publish") {
		echo '<h1 class="admin-notice">This Page Will Not Be Displayed Publicly Because Post Status = ' . $post_status . '</h1>';
	}

	// Start the Loop
	while ( have_posts() ) : the_post();
		// Display page content
		the_content();
	endwhile;
?>

<p>&nbsp;</p>

<?php get_footer(); ?>
