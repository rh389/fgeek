<?php
/**
 * The template used for displaying page content
 *
 * @subpackage fGeek
 * @author tishonator
 * @since fGeek 1.0.0
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<h1 class="entry-title"><?php the_title(); ?></h1>
	
	<div class="page-content">
		<?php
			// Display Thumbnails if thumbnail is set for the post
			if ( has_post_thumbnail() ) :

				the_post_thumbnail();

			endif;

			the_content( __( 'Read More...', 'fgeek') );
		?>
	</div><!-- .page-content -->

	<div class="page-after-content">
		
		<?php if ( ! post_password_required() ) : ?>

			<?php if ('open' == $post->comment_status) : ?>

				<span class="comments-icon">
					<?php comments_popup_link(__( 'No Comments', 'fgeek' ), __( '1 Comment', 'fgeek' ), __( '% Comments', 'fgeek' ), '', __( 'Comments are closed.', 'fgeek' )); ?>
				</span>

			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'fgeek' ), '<span class="edit-icon">', '</span>' ); ?>
		<?php endif; ?>

	</div><!-- .page-after-content -->
</article><!-- #post-## -->

