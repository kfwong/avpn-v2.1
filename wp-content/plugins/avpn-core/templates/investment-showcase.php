<?php

/*
Template Name: Investment Showcase
*/

?>

<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="entry-content">
		<form>
			<label>Name</label>
			<input type="text" />
		</form>
	</div><!-- .entry-content -->
</article><!-- #post -->

<?php get_footer(); ?>