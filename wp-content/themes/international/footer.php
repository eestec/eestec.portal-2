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
                    <div class="row">
                        <div class="span3">
                        </div>
                        <div class="span9">
                        <?php get_sidebar( 'main' ); ?>
                        </div>
                    </div>
		</footer><!-- #colophon -->
	</div><!-- #page -->
	<?php wp_footer(); ?>
</body>
</html>