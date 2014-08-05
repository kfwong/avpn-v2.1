<?php

/*
Template Name: Investment Showcase
*/

?>

<?php get_header(); ?>

<div id="primary" class="site-content">
    <div id="content" role="main">
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
	</div><!-- #content-->
</div><!-- #primary-->

<?php get_footer(); ?>