<?php
/**
 * Site Front Page
 *
 * This is a traditional static HTML site model with a fixed front page and
 * content placed in Pages, rarely if ever using posts, categories, or tags. 
 *
 * @subpackage fGeek
 * @author tishonator
 * @since fGeek 1.0.1
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

 get_header(); ?>

 <div class="clear">
</div><!-- .clear -->

<div id="main-content-wrapper">

	<?php fgeek_display_slider(); ?>

	<div class="clear">
	</div>

	<div id="main-content">

	<?php if ( have_posts() ) : 

				// starts the loop
				while ( have_posts() ) :

					the_post();

					/*
					 * Include the post format-specific template for the content.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;

				the_posts_pagination( array(
                        'prev_next' => '',
                    ) );

		  else :

				// if no content is loaded, show the 'no found' template
				get_template_part( 'content', 'none' );
			
		  endif; ?>

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>
