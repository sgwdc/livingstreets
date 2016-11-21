<?php
/*
Template Name: Portfolio Section

This the template is used for pages under the "Portfolio" page that display a portfolio section.
*/

global $post;
// Get the name of the page
$page_name = $post -> post_title;

// NOTE: The slug for the page must exactly match the slug for the category
$page_slug = $post -> post_name;
$category_slug = $page_slug;

// Get all pages with for the current category
$args = array(
	'post_type'        => 'page',
	'category_name' => $category_slug,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_status'      => 'publish',
	'posts_per_page'   => -1,
	// Only return the page ID's
	'fields' => 'ids'
);
$project_page_ids_array = get_posts( $args );

// If no pages are found for this category (which should hopefully never happen)
if (!count($project_page_ids_array)) {
	// Redirect to the portfolio homepage
	header("Location: " . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/portfolio/');
	exit;
}

/********************************************************************************/
/* GET PAGE ID'S FOR ALL THE OTHER PORTFOLIO SECTIONS (CHILD PAGES OF THE PAGE	*/
/* WITH THE SLUG "PORTFOLIO")													*/
/********************************************************************************/
$portfolio_page_id = get_page_by_path('portfolio') -> ID;
$projects_page_id = get_page_by_path('portfolio/projects') -> ID;
$current_page_id = $post -> ID;
$args = array(
	'post_type'        => 'page',
	'post_parent'      => $portfolio_page_id,
	'exclude'          => array($projects_page_id, $current_page_id),
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_status'      => 'publish',
	'posts_per_page'   => -1,
	// Only return the page ID's
	'fields' => 'ids'
);
$other_page_ids_array = get_posts( $args );

get_header();

/* Not sure whether we'll use this or not
// Display page content
while ( have_posts() ) : the_post();
the_content();
endwhile;
*/
$post_status = get_post_status();
if ($post_status != "publish") {
	echo '<h1 class="admin-notice">This Page Will Not Be Displayed Publicly Because Post Status = ' . $post_status . '</h1>';
}
?>

<h4><a href="/portfolio/">Portfolio of Steven Greenwaters</a></h4>
<?php
// Display the name of the current portfolio section
echo '<h2>Project category: ' . $page_name;

// Link to the "Edit" page if the user has access
edit_post_link(
	sprintf(
		__( 'Edit category page' ),
		get_the_title()
	),
	'<span class="edit-link"> &nbsp;&nbsp; [ ',
	' ]</span>'
);
echo '</h2>';
// Display the thumbnail image for the current portfolio section
echo '<div>' . get_the_post_thumbnail(null, 'thumbnail') . '</div>';

/********************************************************************************/
/* DISPLAY PAGES IN THE CATEGORY ASSOCIATED WITH THE CURRENT PORTFOLIO SECTION	*/
/********************************************************************************/
echo '<h4><br>Projects in this category:</h4>';
// Convert the list of pages to a comma separated string
$project_page_ids_csv = implode(',', $project_page_ids_array);
// Insert the "Essential Grid" plugin, and pass in the list of pages to display
echo do_shortcode('[ess_grid alias="portfolio" posts="' . $project_page_ids_csv . '"]');
/********************************************************************************/
/* END: DISPLAY PAGES IN THE CATEGORY ASSOCIATED WITH THE CURRENT PORTFOLIO 	*/
/* SECTION																		*/
/********************************************************************************/
?>

<br>
<?php
/********************************************************************************/
/* DISPLAY OTHER PORTFOLIO SECTIONS												*/
/********************************************************************************/
?>
<h4><br>Other project categories:</h4>
<?php
// Convert the list of pages to a comma separated string
$other_page_ids_csv = implode(',', $other_page_ids_array);
// Insert the "Essential Grid" plugin, and pass in the list of pages to display
echo do_shortcode('[ess_grid alias="portfolio_small" posts="' . $other_page_ids_csv . '"]');
/********************************************************************************/
/* END: DISPLAY OTHER PORTFOLIO SECTIONS										*/
/********************************************************************************/
?>

<br>
<p><a href="/portfolio/">Return to all projects</a></p>
<p><a href="/">Home</a></p>
<p>&nbsp;</p>

<?php get_footer(); ?>
