<?php
// Define the redirects from old to new addresses
$redirects_array = array(
	array('/portfolio/interactive-maps/', '/portfolio/interactive-mapping/'),
	array('/portfolio/javascript-jquery/', '/portfolio/front-end/'),
	array('/portfolio/php-sql/', '/portfolio/back-end/')
);

$request_uri = $_SERVER['REQUEST_URI'];

// Workaround for Adobe Acrobat mysteriously converting a simple "-" (dash) into "%E2%80%90"
if (strpos($request_uri, '%E2%80%90')) {
	$corrected_uri = preg_replace('/(.*)%E2%80%90(.*)/', '$1-$2', $request_uri);
	header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $corrected_uri);
	exit;
}

// Iterate through all the redirects
for ($one_redirect=0; $one_redirect < count($redirects_array); $one_redirect++) {
	// If this redirect matches the current page that generated a 404 error (use substr() since we don't know if trailing slash will be present)
	if (substr($redirects_array[$one_redirect][0], 0, strlen($request_uri)) == $request_uri) {
		// Redirect user to the new URL
		header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $redirects_array[$one_redirect][1]);
		exit;
	}
}

// Workaround for Adobe Acrobat mysteriously converting a simple "-" (dash) into "%E2%80%90" (Use substr() since we don't know if there will be a trailing slash)
if (substr($request_uri, 0, 33) == "/portfolio/gis%E2%80%90geospatial") {
	// Redirect to the correct URL
	header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/portfolio/gis-geospatial/');
	exit;

// If the user was trying to access a page within my online portfolio
} else if (substr($request_uri, 0, 10) == "/portfolio") {
	// Redirect to the portfolio homepage
	header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/portfolio/');
	exit;
}
?>

<?php get_header(); ?>

	<br>

	<p>Page not found</p>

	<br>

	<p><a href="/">Homepage</a></p>

	<p>&nbsp;</p>

<?php get_footer(); ?>
