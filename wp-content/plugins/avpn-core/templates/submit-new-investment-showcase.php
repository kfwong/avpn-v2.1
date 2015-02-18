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
				<?php wp_reset_postdata(); ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">

				<?php 
				if(is_user_logged_in()){
					acf_form(array(
						'field_groups'	=> array('13439'),
						'post_id'		=> 'new',
						'post_title'	=> false,
						'submit_value'		=> 'Submit',
						'html_before_fields'	=> '<input type="hidden" name="acf_post_type" value="investment-showcase" />',
						'updated_message'	=>	'Investment showcase submitted successfully.'
					)); 
				}else{
				?>
					<p>Sorry, only registered/logged in user can submit new investment showcase.</p>
				<?php
				}
				?>

			</div><!-- .entry-content -->
		</article><!-- #post -->
	</div><!-- #content-->
</div><!-- #primary-->

<?php get_footer(); ?>
