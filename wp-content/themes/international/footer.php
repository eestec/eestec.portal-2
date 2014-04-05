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
                    <div class="container">
                        <div class="row">
                        
                        <div class="col-md-5 hidden-sm">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/footer_map.png" />
                        </div>
                        <div class="col-md-7">
                        <?php get_sidebar( 'main' ); ?>
                        </div>

                        </div>
                        
                        
                    </div>                   
                <div class="credits">
                    <div class="container">
                        <b>Copyright &copy;:</b> EESTEC International   <b>Credits:</b> EESTEC IT & Design team 2014
                    </div>
                </div>
		</footer><!-- #colophon -->
	</div><!-- #page -->
	<?php wp_footer(); ?>
</body>
</html>