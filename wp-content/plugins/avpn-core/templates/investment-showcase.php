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
				<?php wp_reset_postdata(); ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">
				<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

				<?php endwhile; // end of the loop. ?>

				<table class="pretty-datatable">
					<thead>
			            <tr>
					<th>Showcase Image</th>
			                <th>Showcase Name</th>
			                <th>Organisation Type</th>
			                <th>Stage of Development</th>
			                <th>Country</th>
			                <th>Sector</th>
					<th>Funders</th>
			            </tr>
			        </thead>
			        <tbody>			        
						<?php $loop = new WP_Query( array( 'post_type' => 'investment-showcase', 'posts_per_page' => -1, 'post_status' => 'publish' ) ); ?>

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

							<tr>
								<td class="valignmiddle"><?php the_post_thumbnail( array(64,64) ); ?>
								<td>
								<?php the_title( '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' ); ?>
								</td>
								<td><?php the_field('type_of_organisation'); ?></td>
								<td><?php the_field('stage_of_development'); ?></td>
								<td><?php the_field('country'); ?></td>
								<td><?php the_field('social_sector'); ?></td>
								<td class="valignmiddle">
									<?php
										$post_object = get_field('organisation_name');

										if( $post_object ): 

											// override $post
											$post = $post_object;
											setup_postdata( $post ); 
									?>
									<span style="display:none;"><?php the_title(); ?></span><a href="<?php echo get_permalink();?>"><?php has_post_thumbnail()? the_post_thumbnail( 'organisation_logo_fw_vh') : the_title(); ?></a>
									<?php
											wp_reset_postdata(); // IMPORTANT 
										endif;
									?>
								</td>
							</tr>
					
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</article><!-- #post -->
	</div><!-- #content-->
</div><!-- #primary-->

<?php get_footer(); ?>