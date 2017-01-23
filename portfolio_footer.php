<br>
<br>
<h3>More information:</h3>
<ul>
	<li><strong>Contact me:</strong> By phone at (202) 643-2866, or via <a href="/contact/">online contact form</a>.</li>
	<li><strong>See my LinkedIn and GitHub profiles:</strong>
		<br>
		<a href="https://www.linkedin.com/in/stevengreenwaters" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/LinkedIn_button.png" class="profile-button" alt="View Steven Greenwaters' profile on LinkedIn"></a>
		<br>
		<a href="https://github.com/sgwdc" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/GitHub_button.png" class="profile-button" alt="View Steven Greenwaters' profile on GitHub"></a>
	</li>
</ul>
<br>
<br>
<?php
	// Show the dropdown menu (Note this standard WordPress menu gets overridden by the Max Mega Menu plugin)
	wp_nav_menu(
		array(
			'theme_location' => 'portfolio-menu'
		)
	);

	// Add extra space to ensure dropdown menu will fit
	echo '<p>&nbsp;</p>';
	echo '<p>&nbsp;</p>';
	echo '<p>&nbsp;</p>';
	echo '<p>&nbsp;</p>';
	echo '<p>&nbsp;</p>';
	echo '<p>&nbsp;</p>';
	echo '<p>&nbsp;</p>';
?>
