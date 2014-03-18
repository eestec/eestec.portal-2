<?php
/**
 * The template for displaying introductory homepage
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php //while ( have_posts() ) : the_post(); ?>

				<article id="homepage" >
					<header class="entry-header">
                                            <?php wp_loginout(); ?>
                                            
                                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                            <input type="hidden" name="cmd" value="_donations">
                                            <input type="hidden" name="business" value="treasurer@eestec.net">
                                            <input type="hidden" name="lc" value="US">
                                            <input type="hidden" name="item_name" value="EESTEC international">
                                            <input type="hidden" name="item_number" value="Website">
                                            <input type="hidden" name="no_note" value="0">
                                            <input type="hidden" name="currency_code" value="EUR">
                                            <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
                                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"  name="submit" alt="PayPal - The safer, easier way to pay online!">
                                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                            </form>

					
                                        </header><!-- .entry-header -->

					<div class="entry-content">
                                        
                                        <div class="visitor_type">
                                        <?php
                                        $the_query = new WP_Query( array( 'post_type' => 'page', 'post__in' => array( 3952,3957 ) ) );  //student or company page
                                        while ($the_query->have_posts()):
                                        $the_query->the_post();
                                        ?>  
                                            <a class="<?php echo get_the_id();?>" href="<?php the_permalink();?>" title="<?php the_title()?>"><?php the_title();?></a>
                                        <?php endwhile; ?> 
                                        </div>
                                            
                                        <div class="news">
                                        <?php
                                        $the_query = new WP_Query('post_type=post&posts_per_page=4');
                                        while ($the_query->have_posts()):
                                        $the_query->the_post();
                                        ?>  
                                            <a class="<?php echo get_the_id();?>" href="<?php the_permalink();?>" title="<?php the_title()?>"><?php the_title();?></a>
                                        <?php endwhile; ?>                                  
                                        </div>
                                                                                    
					</div>
                                        
                                        <!-- .entry-content -->

				</article><!-- #post -->
			<?php //endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>