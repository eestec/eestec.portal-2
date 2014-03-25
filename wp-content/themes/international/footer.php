<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage International
 * @since International 1.0
 */
?>

		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'main' ); ?>
                    
                    <!--
			<div class="site-info">
				<?php do_action( 'international_credits' ); ?>
			</div><!-- .site-info -->
                   
		</footer><!-- #colophon -->
	</div><!-- #page -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="<?php get_template_directory() ?>/js/bootstrap.js"></script>
	<?php wp_footer(); ?>
</body>
</html>