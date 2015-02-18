<?php


/*
Template Name: Apply for Memberships
*/

?>

<?php acf_form_head(); ?>
<?php get_header(); ?>

<div id="primary" class="site-content">
    <div id="content" role="main">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php wp_reset_postdata(); ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">
				<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

				<?php acf_form(array(
					'field_groups'	=> array('13468','23502'),
					'post_id'		=> 'new',
					'post_title'	=> false,
					'submit_value'		=> 'Submit',
					'html_before_fields'	=> '<input type="hidden" name="acf_post_type" value="organisation" />',
					'updated_message'	=>	'Membership application submitted successfully.',
					'return'	=>	home_url('/membership/apply-for-membership/registration-confirmation/')
				)); ?>
				
				<?php endwhile; // end of the loop. ?>

			</div><!-- .entry-content -->
		</article><!-- #post -->
	</div><!-- #content-->
</div><!-- #primary-->

<?php get_footer(); ?>
