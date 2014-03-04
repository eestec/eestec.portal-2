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
     </ul>
     <div class="post_content">
		<table border="1">
        <tbody>
        <tr>
        <th width="30%">Event title:</th>
        <td><?php the_title();?></td>
        </tr>
        <tr>
        <th>Organizer:</th>        
        <td>
        
        <?php $organizer=str_replace('LC ','',get_field('organizer'));?>
        <a href="#map" rel="inline-565-590" rev="0" class="pirobox_gall1 first" title="Prikaži zemljevid">        
		<?php the_field('organizer');?>
        </a>
        
        <div id="map" style="display:none;">
        <div class="piro-text">
        <h1><?php the_field('organizer');?></h1>
        <iframe width="540" height="460" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?daddr=<?php echo $organizer;?>&amp;hl=sl&amp;z=4&amp;ie=UTF8&amp;t=m&amp;output=embed">
        </iframe><br />
        <a target="_blank" href="https://maps.google.com/maps?saddr=Ljubljana&daddr=<?php echo $organizer;?>&hl=sl&z=5">Show bigger map</a>        
        </div>
        
        </td>
        </tr>
        <?php /*<tr>
        <th>Tip dogodka:</th>
        <td>      
        <?php $eventType=reset(get_the_terms(get_the_ID(),'event_type'));?>
		<a href="#event_type" rel="inline-800-280" rev="1" class="pirobox_gall1 last" title="Kaj je <?php echo $eventType->name;?>?">
		<?php echo $eventType->name;?>
        </a>        
        <div id="event_type" style="display:none;">
        <div class="piro-text">
        <h1><?php echo $eventType->name;?></h1><p><?php echo $eventType->description;?></p>
        </div>
        </div>        
        </td>
        </tr>
        <tr>*/?>
        <th>Date:</th>
        <td>
		<?php print_date(get_field('start_date'))?> - <?php print_date(get_field('end_date'))?>
        <strong>
        <?php 
		$start = new DateTime();
		$end = new DateTime();
		$start->setTimestamp(date_parse_timestamp(get_field('start_date')));		
		$end->setTimestamp(date_parse_timestamp(get_field('end_date')));
		$diff=$end->diff($start);
		echo ' ('.$diff->d.' days)';?>
        </strong>
        <?php $request=array("action"=>"TEMPLATE","text"=>get_the_title(),"dates"=>get_field('start_date')."T000000/".get_field('end_date')."T230000","details"=>$eventType->name,"location"=>str_replace('LC ','',get_field('organizer')),"sprop"=>"eestec-lj.org","trp"=>"false","sprop"=>"name:EESTEC%20LC%20Ljubljana");?>
        <a id="calendar_button" href="http://www.google.com/calendar/event?<?php echo http_build_query($request);?>" target="_blank"><img src="//www.google.com/calendar/images/ext/gc_button1.gif" border=0></a>
        <?php ?>
        </td>
        </tr>
        <tr>
        <th>Deadline:</th>
        <td>
		<?php print_date(get_field('application_deadline')) ?> - 
        <?php 
		$now = new DateTime();
		$ref = new DateTime();
		$ref->setTimestamp(date_parse_timestamp(get_field('application_deadline')));
		if($now<$ref){
			$diff = $now->diff($ref);
			echo 'Only <strong>',remaining_time($diff),'</strong> for application!';
			$prijava=true;
		}
		else{
		echo 'Application expired!';
		$prijava=false;
		}
		?>        
        </td>
        </tr>
        <?php if(get_field('no_of_participants')): ?>
        <tr>
        <th>Participants:</th>
        <td><?php the_field('no_of_participants')?></td>
        </tr>
        <?php endif;?>
        <?php if(get_field('fee')): ?>
		<tr>
        <th>Fee:</th>
        <td><?php the_field('fee')?> €</td>
        </tr>
        <?php endif;?>        
        <?php if(get_field('additional_info')): ?>
        <tr>
        <th>Additional info:</th>
        <td>
        <?php 
		$contacts=explode("(,|\n)",get_field('additional_info'));
		foreach($contacts as $contact):
		?>
        <a href="<?php if(filter_var($contact, FILTER_VALIDATE_EMAIL)){?>mailto:<?php echo $contact;?>" target="_blank" onclick="window.open('https://mail.google.com/mail/?view=cm&amp;tf=1&amp;to=<?php echo $contact;?>&amp;cc=&amp;bcc=&amp;su=&amp;body=','_blank');return false;<?php }else echo $contact;?>"><?php echo $contact;?></a></br>
        <?php endforeach;?>
        </td>
        </tr>
        <?php endif;?>
        <?php if($prijava):?>
        <tr>
        <th>Applications:</th>
        <td><?php the_application_permalink(get_the_id());?></td>
        </tr>
        <?php endif;?>
        </tbody>
        </table>
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
</article><!-- #post -->
