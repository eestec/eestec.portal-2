<?php
/**
 * The sidebar containing the footer widget area.
 *
 * If no active widgets in this sidebar, it will be hidden completely.
 *
 * @package WordPress
 * @subpackage International
 * @since International 1.0
 */

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="secondary" class="sidebar-container" role="complementary">
		<div class="row widget-area">                 
                    <div class="col-md-7 sitemap">
                        <h3>Sitemap:</h3>
                                                <?php /* Footer sitemap */
							wp_nav_menu( array(
							  'menu' => 'sitemap',
							  'container' => false,
							  'menu_class' => 'list-unstyled',
                                                          )
							);
							?>
                    </div>                    
                     <div class="col-md-5">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
                     </div>
		</div><!-- .widget-area -->                
	</div><!-- #secondary -->
<?php endif; ?>