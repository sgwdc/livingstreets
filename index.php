<?php get_header(); ?>

<?php
$post_status = get_post_status();
if ($post_status != "publish") {
	echo '<h1 class="admin-notice">This Page Will Not Be Displayed Publicly Because Post Status = ' . $post_status . '</h1>';
}
?>

<!-- Create a DIV exactly as wide as the content -->
<!--
<div style="display: inline-block; margin:0 auto; border:1px #f00 solid;">
-->

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; ?>

<p>&nbsp;</p>

<?php get_footer(); ?>
