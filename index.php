<?php get_header(); ?>
			
		<div id="content">			
			<div id="main">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>">
												
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
																		
							<?php the_content(); ?>
						
					</article>
					
					<?php comments_template(); ?>
					
				<?php endwhile; else : ?>
					
				<?php endif; ?>

			</div>
		</div>

<?php get_footer(); ?>