<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage International
 * @since International 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <?php if(!is_single()):?>
        <header class="entry-meta row">
                <h2 class="entry-title col-md-10">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
        
		<div class="entry-date col-md-2">
                    <?php international_entry_date();?>
		</div>
            
	</header>

        

	<?php if ( !is_search() ) : // Only display Content for Search ?>
        
	<div class="entry-summary row">
            <div class="excerpt col-md-8">
                <?php the_excerpt(); ?>
            </div>
		
            <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail col-md-4">
			<?php the_post_thumbnail(array('316','205'), array('class'=> "img-responsive",)); ?>
		</div>
		<?php endif; ?>
	</div><!-- .entry-summary -->
        
	<?php else : ?>
	<div class="entry-content">
		<?php the_content('...'); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'international' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
        

	<footer class="entry-meta row">
            <div class="categories col-md-10">
            Categories:
            <?php 	
            $categories_list = get_the_category_list(', ');
                if ( $categories_list ) {
                        echo '<span class="categories-links">' . $categories_list . '</span>';
                } ?>
            </div>
            <div class="more col-md-2">
                <a href="<?php the_permalink()?>"> More >></a>             
            </div>
            
		<?php if ( comments_open() && ! is_single() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'international' ) . '</span>', __( 'One comment so far', 'international' ), __( 'View all % comments', 'international' ) ); ?>
			</div><!-- .comments-link -->
		<?php endif; // comments_open() ?>

	</footer>
        
    <?php else:?>
    
      <header class="entry-header">                
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>

		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php endif; // is_single() ?>

		<div class="entry-meta">
			<?php international_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'international' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'international' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'international' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
        

	<footer class="entry-meta">
		<?php if ( comments_open() && ! is_single() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'international' ) . '</span>', __( 'One comment so far', 'international' ), __( 'View all % comments', 'international' ) ); ?>
			</div><!-- .comments-link -->
		<?php endif; // comments_open() ?>

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
           <?php endif;?>
</article><!-- #post -->
