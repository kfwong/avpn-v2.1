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

				<table class="pretty-datatable">
					<thead>
			            <tr>
			                <th>Showcase Name</th>
			                <th>Organisation Type</th>
			                <th>Stage of Development</th>
			                <th>Country</th>
			                <th>Sector</th>
			            </tr>
			        </thead>
			        <tbody>			        
						<?php $loop = new WP_Query( array( 'post_type' => 'investment-showcase', 'posts_per_page' => 10, 'post_status' => 'publish' ) ); ?>

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

							<tr>
								<td><?php the_title( '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' ); ?></td>
								<td><?php the_field('type_of_organisation'); ?></td>
								<td><?php the_field('stage_of_developmen'); ?></td>
								<td><?php the_field('country'); ?></td>
								<td><?php the_field('social_sector'); ?></td>
							</tr>
					
						<?php endwhile; ?>
					</tbody>
				</table>
				
				<?php the_content(); ?>

			</div>
		</article><!-- #post -->
	</div><!-- #content-->
</div><!-- #primary-->

<?php get_footer(); ?>