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
						<?php
							
							/*
														
							$post = array(
							  'ID'             => [ <post id> ] //Are you updating an existing post?
							  'menu_order'     => [ <order> ] //If new post is a page, it sets the order in which it should appear in the tabs.
							  'comment_status' => [ 'closed' | 'open' ] // 'closed' means no comments.
							  'ping_status'    => [ 'closed' | 'open' ] // 'closed' means pingbacks or trackbacks turned off
							  'pinged'         => [ ? ] //?
							  'post_author'    => [ <user ID> ] //The user ID number of the author.
							  'post_category'  => [ array(<category id>, <...>) ] //post_category no longer exists, try wp_set_post_terms() for setting a post's categories
							  'post_content'   => [ <the text of the post> ] //The full text of the post.
							  'post_date'      => [ Y-m-d H:i:s ] //The time post was made.
							  'post_date_gmt'  => [ Y-m-d H:i:s ] //The time post was made, in GMT.
							  'post_excerpt'   => [ <an excerpt> ] //For all your post excerpt needs.
							  'post_name'      => [ <the name> ] // The name (slug) for your post
							  'post_parent'    => [ <post ID> ] //Sets the parent of the new post.
							  'post_password'  => [ ? ] //password for post?
							  'post_status'    => [ 'draft' | 'publish' | 'pending'| 'future' | 'private' | 'custom_registered_status' ] //Set the status of the new post.
							  'post_title'     => [ <the title> ] //The title of your post.
							  'post_type'      => [ 'post' | 'page' | 'link' | 'nav_menu_item' | 'custom_post_type' ] //You may want to insert a regular post, page, link, a menu item or some custom post type
							  'tags_input'     => [ '<tag>, <tag>, <...>' ] //For tags.
							  'to_ping'        => [ ? ] //?
							  'tax_input'      => [ array( 'taxonomy_name' => array( 'term', 'term2', 'term3' ) ) ] // support for custom taxonomies. 
							);*/  

							// The Query
							$the_query = new WP_Query('post_type=events&posts_per_page=-1');
							
							// The Loop
							if ( $the_query->have_posts() ) {
								while ( $the_query->have_posts() ) {
									$the_query->the_post();
									echo '<a href="'.get_edit_post_link($id).'"><li>' . get_the_title() ;
									$lc = get_post_meta(get_the_id(),'organizer', 'true' );
									echo'-'.$lc.'</li></a>';
									$lc=get_page_by_title($lc, 'OBJECT','lcs');
									//print_r($lc);
									echo $lc->ID;
									add_post_meta(get_the_id(),'lc',$lc->ID,true);
								}
							}
											
						 ?>
						
						
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