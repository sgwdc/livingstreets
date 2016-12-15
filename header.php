<?php
$RelativeToRoot = "";
include $RelativeToRoot . 'visitor_tracker.php';
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
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/livingstreets.css">
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
			if ($_SERVER['REQUEST_URI'] == "/") $isHomepage = true; else $isHomepage = false;
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

		if (!$isHomepage) echo '<a href="/">';
	?>
	<div id="living-streets-header" class="clearfix">
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/images/livingstreets_logo_100px.png" width="100" height="100">
		</div>
		<div>
			<h1>
			<?php
				// If this is page is within the portfolio, display that in the header
				if (substr($_SERVER['REQUEST_URI'], 0, 10) == "/portfolio") {
					echo 'Portfolio of Steven Greenwaters';
				// Otherwise display company logo
				} else {
					echo get_bloginfo('name');
				}
			?>
		</div>
	</div>
	<?php
		if (!$isHomepage) echo '</a>';
	?>
