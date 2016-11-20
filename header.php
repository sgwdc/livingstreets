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
</head>
<body bgcolor="#0067b5" <?php body_class(); ?>>

	<h1 class="living-streets-header"><a href="/"><img src="<?php bloginfo('template_directory'); ?>/images/livingstreets_logo_100px.png"> <?php echo get_bloginfo('name'); ?></a></h1>
