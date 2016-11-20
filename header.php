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
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/livingstreets.css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
	<!-- Hook for plugins to insert code here (Avoids need to move WordPress Toolbar to the bottom of the browser window) -->
	<?php wp_head(); ?>
	<?php
		if ($_SERVER['REQUEST_URI'] == "/") $isHomepage = true; else $isHomepage = false;
		if (!$isHomepage) {
		?>
		<script>
			// Fire when jQuery has finished loading
			jQuery( document ).ready(function() {
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
			});
		</script>
	<?php
		}
	?>
</head>
<body bgcolor="#0067b5" <?php body_class(); ?>>
	<?php
		if (!$isHomepage) echo '<a href="/">';
	?>
	<div id="living-streets-header" class="clearfix">
		<div>
			<img src="<?php bloginfo('template_directory'); ?>/images/livingstreets_logo_100px.png">
		</div>
		<div>
			<h1><?php echo get_bloginfo('name'); ?></h1>
		</div>
	</div>
	<?php
		if (!$isHomepage) echo '</a>';
	?>
