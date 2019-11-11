<?php
	/* From when online portfolio was integrated with LivingStreets.com
	// If the user manually accessed /portfolio/projects/ (which must be published for the project pages to be child pages of it)
	if (substr($_SERVER['REQUEST_URI'], 0, 20) == "/portfolio/projects/") {
		// Redirect to the portfolio homepage
		header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/portfolio/');
		exit;
	}
	*/
	// If the user accessed my online portfolio from when it was integrated with LivingStreets.com
	if (substr($_SERVER['REQUEST_URI'], 0, 10) == "/portfolio") {
		// Redirect to the portfolio homepage
		header("Location: http://sgwportfolio.com");
		exit;
	}
?>

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
