	<?php
		// Copied from header.php for consistency
		if (substr($_SERVER['REQUEST_URI'], 0, 10) == "/portfolio") $isPortfolio = true;
		else $isPortfolio = false;
		// If this page is within the portfolio section, show the WordPress menu
		if ($isPortfolio) {
			wp_nav_menu(
				array(
					'theme_location' => 'portfolio-menu'
				)
			);
		}

		// Display the WordPress Toolbar and create a hook for plugins to reference JavaScript files
		wp_footer();
	?>
</body>
</html>
