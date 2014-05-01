<?php
/**
 * The template for displaying introductory homepage
 */
get_header(); ?>
	<div class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php //while ( have_posts() ) : the_post(); ?>

				<article id="homepage" >
					<header class="entry-header">
                                            
                                            <div class="row">
                                            <div class="col-md-2 pull-left">
                                            <br>Like our idea?
                                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                            <input type="hidden" name="cmd" value="_donations">
                                            <input type="hidden" name="business" value="treasurer@eestec.net">
                                            <input type="hidden" name="lc" value="US">
                                            <input type="hidden" name="item_name" value="EESTEC international">
                                            <input type="hidden" name="item_number" value="Website">
                                            <input type="hidden" name="no_note" value="0">
                                            <input type="hidden" name="currency_code" value="EUR">
                                            <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
                                            
                                                <input type="button" class="btn btn-red" name="submit" value="Donate">
                                            
                                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                            </form>

                                            </div>
                                            <div class="col-md-3 pull-right">
                                                <?php eemail_bootstrap_show(); ?>
                                            </div>
                                        </header><!-- .entry-header -->
					               <div class="row" id="frontpage-slider-theme">
                                        <!-- buttons on the left side of the news slider -->
                                        <div class="col-md-2">
                                            Are you a:
                                            <div class="visitor_type_buttons">
                                            <?php
                                            $button_change_flag=0;
                                            $the_query = new WP_Query( array( 'post_type' => 'page', 'post__in' => array( 3952,3957 ) ) );  //student or company page
                                            while ($the_query->have_posts()):
                                            $the_query->the_post();
                                            $button_change_flag++;
                                            ?>  
                                            <br><br><a class="<?php echo get_the_id();?>" href="<?php the_permalink();?>" title="<?php the_title()?>" value="<?php the_title();?>">
                                            <?php 
                                                if($button_change_flag==1){echo"<img class='visitor_type_icon' src='".get_template_directory_uri()."/images/CompanyIcon.png'>";}
                                                if($button_change_flag==2){echo"<img class='visitor_type_icon' src='".get_template_directory_uri()."/images/Student_btn_icon.png'>";} 
                                            ?>
                                            </a>
                                            <?php endwhile; ?> 
                                            </div>
                                        </div>
                                        <!-- The begining of the carousel of the news and mages -->
                                        <div class="col-md-10" id="slider">
                                            <div id="myCarousel" class="carousel slide">
                                            <div class="carousel-inner">
                                                <?php
                                                $the_query = new WP_Query('post_type=post&posts_per_page=6&category_name=homepage');
                                                $flag = 1;
                                                while ($the_query->have_posts()):
                                                $the_query->the_post();
                                                
                                                //<!-- the first "item" of while loop is "active" -->
                                                if($flag == 1) {
                                                    echo '<div class="item active">';
                                                     $flag=0;
                                                    }
                                                else{ echo '<div class="item">';};
                                                     ?> 
                                                            <?php echo the_post_thumbnail('home-slider');?>
                                                            <div class="carousel-caption">
                                                                <div class="news_title">
                                                                        <a class="post <?php echo get_the_id();?>" href="<?php the_permalink();?>" style="color:white; font-size:25px;" title="<?php the_title()?>"><?php the_title();?></a>
                                                                        <div class="date_slider"><?php the_date(); ?></div>
                                                                </div>
                                                                <div class="line_separator"></div>
                                                                <div class="displayed_news_text"> 
                                                                <p><?php echo the_excerpt('More >>');?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php endwhile; ?>
                                            
                                            </div>
                                            <!-- Buttons for swiping left & right -->
                                            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                                            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
                                            </div>
                                    </div>

                                        <!-- speed for the slider is edited here 4000 for 4s -->
                                        <script>
                                          $(document).ready(function(){
                                            $('.carousel').carousel({
                                              interval: 50000
                                            });
                                          });
                                        </script>
					</div>
                                        
                                        <div class="partners">    
                                        Our partners:    
                                        <div class="row">
                                            
                                             <?php 
                                             echo get_post_field('post_content', 4031);  //temporary hack for displaying the sponsors. HTML code writen on the "Home" page.                                             
                                             ?>
                                        </div>
                                        </div>
                                        <!-- .entry-content -->
				</article><!-- #post -->
			<?php //endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>