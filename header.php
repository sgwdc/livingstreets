<?php
$RelativeToRoot = "";
include $RelativeToRoot . 'visitor_tracker.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Living Streets Consulting</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/livingstreets.css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<!-- Hook for plugins to insert code here (Avoids need to move WordPress Toolbar to the bottom of the browser window) -->
	<?php wp_head(); ?>
</head>
<body bgcolor="#0067b5" <?php body_class(); ?>>
