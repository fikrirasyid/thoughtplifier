<?php
// If no post found, use this markup
if (!have_posts()) : ?>

    <div class="post">
        <h1 class="post-title"><?php _e("Oh snap. Houston, looks like we've lost.", 'essential'); ?></h1>
        <div class="the-content">
            <h2><?php _e("The page you try to access is not exist. You can go back to <a href='" . get_bloginfo('url') . "'>the homepage</a> or search something else:", 'essential'); ?></h2>
            <p>
                <form method="get" id="searchform" action="<?php echo get_option('home'); ?>">
                    <input type="text" value="<?php _e("Type keywords and hit enter", "essential"); ?>" name="s" id="s-404" onfocus="if (this.value == '<?php _e("Type keywords and hit enter", "essential"); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e("Type keywords and hit enter", "essential"); ?>';}" />
                    <input type="hidden" id="searchsubmit" value="<?php _e("Search", 'essential'); ?>" />
                </form>
            </p>
        </div>
    </div>

<?php endif;
while ( have_posts() ) : the_post(); ?>

    <?php if (is_single()) : // single post loop ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1 class="title">
                <?php the_title(); ?>
            </h1>
            <p class="author">
                <?php _e('Written by ', 'essential'); the_author_link(); ?>
            </p>
            <div class="content">
                <?php the_content(); ?>
            </div><!-- .content -->
            
            <div id="author-box">
                <?php ess_author_box(); ?>
            </div><!-- .author-box -->
            
            <div class="meta clearfix">
                <div class="meta-item tags">
                    <h4 class="section-title"><?php _e('Tags', 'essential'); ?></h4>
                    <?php the_tags('<ul><li>', '</li><li>', '</li></ul>'); ?>
                </div>
                <div class="meta-item categories">
                    <h4 class="section-title"><?php _e('Categories', 'essential'); ?></h4>
                    <?php the_category(); ?>
                </div>
                <div class="meta-item info">
                    <h4 class="section-title"><?php _e('Post Info', 'essential'); ?></h4>
                    <?php ess_post_date(); ?>                    
                </div>
            </div><!-- .meta -->
            
            <div id="related-posts" class="clearfix">
                <?php ess_related_posts(5); ?>
            </div><!-- #related-posts -->
            
            <div id="comment-wrap" class="clearfix">
                <?php comments_template( '', true ); ?>
            </div><!-- #comment-wrap -->
            
        </div><!-- #post -->
        
    <?php elseif(is_page()) :?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1 class="title">
                <?php the_title(); ?>
            </h1>
            <p class="author">
                <?php _e('Written by ', 'essential'); the_author_link(); ?>
            </p>
            <div class="content">
                <?php the_content(); ?>
            </div><!-- .content -->
            
            <div id="comment-wrap" class="clearfix">
                <?php comments_template( '', true ); ?>
            </div><!-- #comment-wrap -->
            
        </div><!-- #post -->
    <?php else : // else's loop: search, archive, home, etc ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2 class="title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <p class="author">
                <?php _e('Written by ', 'essential'); the_author_link(); _e(' at ', 'essential'); ess_post_date(); ?>
            </p>
            <?php
                if ( has_post_thumbnail()) {
                            the_post_thumbnail("main-image");
                }
            ?>
            <div class="content">
                <p><?php echo ess_excerpt(40); ?>. <a href="<?php the_permalink(); ?>" class="read-more"><?php _e('read more &rarr;', 'essential'); ?></a></p>
            </div><!-- .content -->

        </div><!-- #post -->


    <?php endif; ?>

<?php endwhile; ?>