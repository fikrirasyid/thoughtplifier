	<?php
	/* If the post is password protected */
	if ( post_password_required() ) : ?>
		<h4 class="comment-title">
			<?php _e('This post is password protected. Please enter the password to view comments', 'essential'); ?>
		</h4>
	<?php return; endif; ?>
	
	
	<?php
	/* If the post has comments, show these things */
	if ( have_comments() ) : ?>
		<h4 class="comment-title">
			<?php comments_number('No Response Yet', 'One Response for This Thought', '% Responses for This Thought'); ?>
		</h4>		
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-nav">
				<div class="comment-prev">
					<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'essential' ) ); ?>
				</div>
				<div class="comment-next">
					<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'essential' ) ); ?>
				</div>
			</div><!-- .comment-nav -->
		<?php endif; ?>
		
		<ol id="comment-list">
			<?php wp_list_comments(array('callback' => 'essential_comment')); ?>
		</ol>	

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-nav">
				<div class="comment-prev">
					<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'essential' ) ); ?>
				</div>
				<div class="comment-next">
					<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'essential' ) ); ?>
				</div>
			</div><!-- .comment-nav -->
		<?php endif; ?>

	<?php
	/* If the comment section is closed, show this message instead */
	elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<h4 class="comment-title">
			<?php _e('Comment is closed', 'essential'); ?>
		</h4>
	<?php endif; ?>
	
	<?php comment_form(); ?>