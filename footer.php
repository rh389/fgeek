<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "body-content-wrapper" div and all content after.
 *
 * @package WordPress
 * @subpackage fGeek
 * @author tishonator
 * @since fGeek 1.0.0
 *
 */
?>
			<a href="#" class="scrollup"></a>

			<footer id="footer-main">

				<div id="footer-content-wrapper">

					<div class="clear">
					</div>

					<div id="copyright">

						<p>
						 <?php fgeek_show_copyright_text(); ?> <a href="<?php echo esc_url( 'https://tishonator.com/product/fgeek' ); ?>" title="<?php esc_attr_e( 'fgeek Theme', 'fgeek' ); ?>">
							<?php _e('fGeek Theme', 'fgeek'); ?></a> <?php esc_attr_e( 'powered by', 'fgeek' ); ?> <a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>" title="<?php esc_attr_e( 'WordPress', 'fgeek' ); ?>">
							<?php _e('WordPress', 'fgeek'); ?></a>
						</p>
						
					</div><!-- #copyright -->

				</div><!-- #footer-content-wrapper -->

			</footer><!-- #footer-main -->

		</div><!-- #body-content-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html>