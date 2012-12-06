<?php get_header(); ?>
			
		<div id="content" class="container">			

			<section>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>

				<?php endwhile; endif; ?>

			</section>

		</div>

<?php get_footer(); ?>