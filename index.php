<?php get_header(); ?>

<!-- Create a DIV exactly as wide as the content -->
<!--
<div style="display: inline-block; margin:0 auto; border:1px #f00 solid;">
-->

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; ?>

<!-- Moved to individual pages so it can be center or left aligned (moved back since home.php is the only page where it's left aligned)
<p><a href="/">Home</a></p>
-->

<p><a href="/">Home</a></p>

<p>&nbsp;</p>

<?php get_footer(); ?>
