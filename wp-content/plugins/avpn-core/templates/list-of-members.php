<?php


/*
Template Name: Apply for Memberships
*/

?>

<?php get_header(); ?>

<div id="primary" class="site-content">
    <div id="content" role="main">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php wp_reset_query(); ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">
				<div id="chartdiv"></div>
				<table class="pretty-datatable">
					<thead>
			            <tr>
					<th>Organisation</th>
			                <th>Countries of Operation</th>
			                <th>Social Sector</th>
			                <th>Type of Services Provided</th>
			            </tr>
			        </thead>
			        <tbody>			        
						<?php $loop = new WP_Query( array( 'post_type' => 'organisation', 'posts_per_page' => -1 ) ); ?>

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

							<tr>
								<td class="valignmiddle"><span style="display:none;"><?php the_title(); ?></span><a href="<?php echo get_permalink();?>"><?php has_post_thumbnail()? the_post_thumbnail( 'organisation_logo_fw_vh') : the_title(); ?></a></td>
								<td><?php the_field('which_are_the_main_countries_that_your_company_operate_in'); ?></td>
								<td><?php the_field('which_social_sectors_do_you_support'); ?></td>
								<td><?php the_field('what_types_of_services_do_you_provide'); ?></td>
							</tr>
					
						<?php endwhile; ?>
						<?php wp_reset_query(); ?>
					</tbody>
				</table>
				<?php the_content(); ?>

			</div>
		</article><!-- #post -->
	</div><!-- #content-->
</div><!-- #primary-->

<?php get_footer(); ?>
