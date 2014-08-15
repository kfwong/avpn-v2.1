<?php


/*
Template Name: Submit New Investment Showcase
*/

?>

<?php acf_form_head(); ?>
<?php get_header(); ?>

<div id="primary" class="site-content">
    <div id="content" role="main">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">
 
				<?php acf_form(array(
					'field_groups'	=> array('13439'),
					'post_id'		=> 'new-investment-showcase',
					'post_title'	=> false,
					'submit_value'		=> 'Submit',
					'updated_message'	=>	'Investment showcase submitted successfully.'
				)); ?>

			</div><!-- .entry-content -->
		</article><!-- #post -->
	</div><!-- #content-->
</div><!-- #primary-->

<?php get_footer(); ?>