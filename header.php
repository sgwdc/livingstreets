<?php
// Set a version number to ensure any obsolete CSS and JS files are not cached
$version = 5;

$RelativeToRoot = "";
include $RelativeToRoot . 'visitor_tracker.php';
// Save whether this is the top-level page
if ($_SERVER['REQUEST_URI'] == "/") $isHomepage = true;
else $isHomepage = false;
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
			// Disable the mouse pointer for the "Living Streets Consulting" header
			jQuery( "div#living-streets-header h1" ).css('cursor', 'default');
		});
	</script>
</head>
<body bgcolor="#005799" <?php body_class(); ?>>
	<?php
		// Google Analytics tracking
		include_once("analyticstracking.php");
		if (!$isHomepage) {
			echo '<a href="/" title="Homepage">';
		}
	?>
	<div id="living-streets-header" class="clearfix">
		<div id="logo">
			<img src="<?php bloginfo('template_directory'); ?>/images/DCMetroDiagram_Simplified_WhiteOutline_cropped_166x133.png" width="166" height="133">
		</div>
		<div>
			<?php
				echo '<h1 id="company">' . get_bloginfo('name') . '</h1>';
			?>
		</div>
	</div>
	<?php
		// If this page is not the homepage, close the link
		if (!$isHomepage) echo '</a>';
	?>
