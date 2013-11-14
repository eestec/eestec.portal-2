<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage International
 * @since International 1.0
 */ 

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
                        
                        <?php function content($args,$argument,$preambule,$class){
		  $query = new WP_Query($args); 
		while ($query->have_posts()) : $query->the_post(); ?>
	    <div <?php post_class($class) ?> id="post-<?php the_ID(); ?> ">

        
        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?><span> - <?php the_field('organizer')?></span></a></h2>
                <?php

		$reports=get_field('event_report');
		if($reports):
			foreach( $reports as $report): ?>
        <div class="fltrt"><a class="button report" href="<?php echo get_permalink( $report->ID );?>">Participants reports</a></div>
        <?php
        	endforeach;
		endif;
		?>
<div class="entry">
           
		   <?php 
		$now = new DateTime();
		$ref = new DateTime();
		$ref->setTimestamp(date_parse_timestamp(get_field($argument)));
		$diff = $now->diff($ref);
		echo $preambule,' <strong>',remaining_time($diff),'</strong> (',print_date(get_field($argument)),')';

		?>               
        </div>
        <p class="postmetadata"> <?php edit_post_link('Edit', '', ''); ?> </p>
        <img src="http://eestec-lj.org/wp-content/themes/neutral/img/line.png"; width=400/>

       <br />
      </div>
    <?php endwhile;}?>

<?php
	 $applications=array(
	'posts_per_page' => '-1',
    'ignore_sticky_posts' => '-1',
    'post_type' => 'events',
	'meta_key' => 'application_deadline',
    'orderby' => 'meta_value',
    'order' => 'DESC',
	'meta_query'  => array(
	array(         // restrict posts based on meta values
                  'key'     => 'application_deadline',  // which meta to query
                  'value'   => date("Ymd"),  // value for comparison
                  'compare' => '>=',  // comparing based on a string, due to the date format
				  'type' => 'NUMERIC',
				  
                )) // end meta_query array
	);
	?>
    <h1 class="center">Open for application</h1>
    
	<?php content($applications,'application_deadline','Remaining time','applications');?> 
        
    <!--workshops waiting for start --> 
    <?php
		
		wp_reset_query();
		
		$ready=array(
		'posts_per_page' => '-1',
		'post_type' => 'events',
		'meta_key' => 'start_date',
		'orderby' => 'meta_value',
		'order' => 'DESC',
		'meta_query'  => array(
		array(         // restrict posts based on meta values
					  'key'     => 'start_date',  // which meta to query
					  'value'   => date("Ymd"),  // value for comparison
					  'compare' => '>',  // comparing based on a string, due to the date format
					  'type' => 'NUMERIC',
					  
					),
		array(         // restrict posts based on meta values
		  'key'     => 'application_deadline',  // which meta to query
		  'value'   => date("Ymd"),  // value for comparison
		  'compare' => '<',  // comparing based on a string, due to the date format
		  'type' => 'NUMERIC',
		  
		)
		) // end meta_query array
		);
		
		?>
        <h1 class="center">Pending</h1>
		<?php content($ready,'start_date','Remaining time till start','pending');?>
    
        <!--workshops in progress --> 
    <?php
		
		wp_reset_query();
		
		$progress=array(
		'posts_per_page' => '-1',
		'post_type' => 'events',
		'meta_key' => 'end_date',
		'orderby' => 'meta_value',
		'order' => 'DESC',
		'meta_query'  => array(
		array(         // restrict posts based on meta values
					  'key'     => 'end_date',  // which meta to query
					  'value'   => date("Ymd"),  // value for comparison
					  'compare' => '>=',  // comparing based on a string, due to the date format
					  'type' => 'NUMERIC',
					  
					),
		array(         // restrict posts based on meta values
		  'key'     => 'start_date',  // which meta to query
		  'value'   => date("Ymd"),  // value for comparison
		  'compare' => '<=',  // comparing based on a string, due to the date format
		  'type' => 'NUMERIC',
		)
		) // end meta_query array
		);
	
	  ?>
	  <h1 class="center">In progress</h1>
	  <?php content($progress,'end_date','Remaining time till end','progress');?>
    
    <!--finished workshops --> 
    <?php
		
		wp_reset_query();
		
		$finished=array(
		'posts_per_page' => '-1',
		'post_type' => 'events',
		'meta_key' => 'end_date',
		'orderby' => 'meta_value',
		'order' => 'DESC',
		'meta_query'  => array(
		array(         // restrict posts based on meta values
		  'key'     => 'end_date',  // which meta to query
		  'value'   => date("Ymd"),  // value for comparison
		  'compare' => '<',  // comparing based on a string, due to the date format
		  'type' => 'NUMERIC',
		)
		) // end meta_query array
		);
		
		?>
		<h1 class="center">Finished</h1>
		<?php content($finished,'end_date','Time from completion','finished');?>

                        
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'international' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'international' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

				<?php comments_template(); ?>
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>