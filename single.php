<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @subpackage fGeek
 * @author tishonator
 * @since fGeek 1.0.0
 *
 */

 get_header(); ?>

<div id="main-content-wrapper">
	<div id="main-content">
	<?php if (have_posts()) :

			while (have_posts()) :
			
				the_post();
				
				/*
				 * includes a post format-specific template for single content
				 */
				get_template_part( 'content', get_post_format() );
				
				// if comments are open or there's at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fgeek' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );

					the_post_navigation( array(

                        'prev_text' => __( 'Previous Post: %title', 'fgeek' ),
                        'next_text' => __( 'Next Post: %title', 'fgeek' ),
                    ) );
				
				endwhile;
	?>
	<?php else :

				// if no content is loaded, show the 'no found' template
				get_template_part( 'content', 'none' );

		  endif; ?>

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>