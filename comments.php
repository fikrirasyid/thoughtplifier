	<?php
	/* If the post is password protected */
	if ( post_password_required() ) : ?>
		<h4 class="comment-title">
			<?php _e('This post is password protected. Please enter the password to view comments', 'thoughtplifier'); ?>
		</h4>
	<?php return; endif; ?>
	
	
	<?php
	/* If the post has comments, show these things */
	if ( have_comments() ) : ?>
		<h4 class="comment-title">
			<?php comments_number('No Response Yet', 'One Response for This Thought', '% Responses for This Thought'); ?>
		</h4>		
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-nav clearfix">
				<div class="comment-prev">
					<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'thoughtplifier' ) ); ?>
				</div>
				<div class="comment-next">
					<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'thoughtplifier' ) ); ?>
				</div>
			</div><!-- .comment-nav -->
		<?php endif; ?>
		
		<ol id="comment-list" class="clearfix">
			<?php wp_list_comments(array('callback' => 'tp_comment')); ?>
		</ol>	

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-nav clearfix bottom">
				<div class="comment-prev">
					<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'thoughtplifier' ) ); ?>
				</div>
				<div class="comment-next">
					<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'thoughtplifier' ) ); ?>
				</div>
			</div><!-- .comment-nav -->
		<?php endif; ?>

	<?php
	/* If there's no comment yet, show this message instead */
	elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<h4 class="section-title">
			<?php _e('No Response Yet', 'thoughtplifier'); ?>
		</h4>
		<p id="noresponse-message"><?php _e('There is no response for this thought.', 'thoughtplifier'); ?></p>
	<?php
		endif;
		if (!comments_open()) : /* Show this message is the comment is already closed*/
	?>
		<div id="comment-closed-message">
			<h4 class="section-title">The comment is closed</h4>
			<p><?php echo of_get_option('tp_closed_comment_message', 'Sorry but we have decided to close the comment section for this post.'); ?></p>
		</div>
	<?php
		endif;
		comment_form(); ?>