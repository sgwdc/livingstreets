<?php
// Set a version number to ensure any obsolete CSS and JS files are not cached
$version = 1;

$RelativeToRoot = "";
include $RelativeToRoot . 'visitor_tracker.php';

// If this IS a portfolio page
if (substr($_SERVER['REQUEST_URI'], 0, 10) == "/portfolio") {
	$isPortfolio = true;
	// Save whether this is the top-level portfolio page
	if ($_SERVER['REQUEST_URI'] == "/portfolio/") $isHomepage = true;
	else $isHomepage = false;
// Otherwise it's NOT a portfolio page
} else {
	$isPortfolio = false;
	// Save whether this is the top-level page
	if ($_SERVER['REQUEST_URI'] == "/") $isHomepage = true;
	else $isHomepage = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php
	// If this is NOT the front page, include the page title in the HTML title
	if (!is_front_page()) {
		wp_title('&raquo;', true, 'right');
	}
	// Add the blog name to the HTML title
	bloginfo('name');
	?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/livingstreets.css?ver=' . $version; ?>">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
	<?php
		/* Hook for plugins to insert code here (Avoids need to move WordPress Toolbar to the bottom of the browser window) */
		wp_head();
	?>
	<script>
		// Fire when jQuery has finished loading
		jQuery( document ).ready(function() {
			<?php
			// If this is the homepage, disable the mouse pointer for the "Living Streets Consulting" header
			if ($isHomepage) {
			?>
				jQuery( "div#living-streets-header h1" ).css('cursor', 'default');
			<?php
			// If this is any other page, use jQuery to give "Living Streets Consulting" and the company logo a consistent border on hover, click and normal
			} else {
			?>
				// Define events for company name and logo
				jQuery( "div#living-streets-header" )
					.on('mouseenter mouseup', function() {
						jQuery( this ).find( 'img' ).css("border-color", "#88cbfa");
					})
					.on('mouseleave', function() {
						jQuery( this ).find( 'img' ).css("border-color", "#fff");
					})
					.on('mousedown', function() {
						jQuery( this ).find( 'img' ).css("border-color", "#f00");
					})
			<?php
			}
			?>
		});
	</script>
</head>
<body bgcolor="#005799" <?php body_class(); ?>>
	<?php
		// Google Analytics tracking
		include_once("analyticstracking.php");
		// If this is a page within the portfolio, but not the homepage, link to the portfolio homepage
		if ($isPortfolio && !$isHomepage) {
			echo '<a href="/portfolio/">';
		// Otherwise if this is not a page within the portfolio, and not the homepage, link to the homepage
		} else if (!$isPortfolio && !$isHomepage) {
			echo '<a href="/">';
		}
	?>
	<div id="living-streets-header" class="clearfix">
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/images/livingstreets_logo_100px.png" width="100" height="100">
		</div>
		<?php
			// If this is page is within the portfolio, display the photo
			if ($isPortfolio) {
		?>
			<div id="photo">
				<img src="<?php bloginfo('template_directory'); ?>/images/654A1000-22_Wedding_Mask_135px.png" width="135" height="135">
			</div>
		<?php
			}
		?>
		<div>
			<?php
				// If this is page is within the portfolio, display that in the header
				if ($isPortfolio) {
					echo '<h1 id="portfolio">Portfolio of Steven Greenwaters</h1>';
				// Otherwise display company logo
				} else {
					echo '<h1 id="company">' . get_bloginfo('name') . '</h1>';
				}
			?>
		</div>
	</div>
	<?php
		if (!$isHomepage) echo '</a>';
	?>
