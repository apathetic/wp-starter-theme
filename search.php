<?php get_header(); ?>

		<div id="main" class="search clearfix">
			<h1>Search Results</h1>
			<?php 
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						// $type = $post->post_type;
						get_template_part('block', 'work'); 
					endwhile;
				else : 
			?>
					<h3>Nothing found for: <?php echo get_search_query(); ?></h3>
			<?php 
				endif; 
			?>

		</section>

<?php get_footer(); ?>