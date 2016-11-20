<?php
// If the user was trying to access a page within my online portfolio
if (substr($_SERVER['REQUEST_URI'], 0, 10) == "/portfolio") {
	// Redirect to the portfolio homepage
	header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/portfolio/');
	exit;
}
?>

<?php get_header(); ?>

	Page not found

	<p><a href="/">Home</a></p>

	<p>&nbsp;</p>

<?php get_footer(); ?>
