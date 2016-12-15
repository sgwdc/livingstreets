<?php get_header(); ?>

	<?php /* This entire block will be expanded into the margin so it runs across the entire screen */ ?>
	<div id="fotoliacontainer">
		<div class="divider">&nbsp;</div>
		<?php /* This will be used to clip the Fotolia image at 200px */ ?>
		<div id="fotoliainnercontainer">
			<?php /* The Fotolia image will be at least 200px, and full width */ ?>
			<img id="fotolia" src="<?php echo get_template_directory_uri(); ?>/images/Fotolia_48180217_XL_v4.jpg">
		</div>
		<div class="divider">&nbsp;</div>
	</div>
	
	<div class="clearfix">
		<div style="float:left;"><p><?php echo get_bloginfo('description'); ?></p></div>
		<div style="float:right;"><p><a href="/contact/">Contact</a></p></div>
	</div>

<?php get_footer(); ?>
