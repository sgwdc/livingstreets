<?php
// Workaround for Adobe Acrobat mysteriously converting a simple "-" (dash) into "%E2%80%90" (Use substr() since we don't know if there will be a trailing slash)
if (substr($_SERVER['REQUEST_URI'], 0, 33) == "/portfolio/gis%E2%80%90geospatial") {
	// Redirect to the correct URL
	header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/portfolio/gis-geospatial/');
	exit;

// If the user was trying to access a page within my online portfolio
} else if (substr($_SERVER['REQUEST_URI'], 0, 10) == "/portfolio") {
	// Redirect to the portfolio homepage
	header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/portfolio/');
	exit;
}
?>

<?php get_header(); ?>

	Page not found

	<p><a href="/">Homepage</a></p>

	<p>&nbsp;</p>

<?php get_footer(); ?>
