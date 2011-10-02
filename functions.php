<?php
/*
 * --------------------------------------------------------------------------------------------------------------------------------
 * THEME OPTIONS FRAMEWORK
 * 
 * Made based on Devin Price's Option Framework Theme
 * http://wptheming.com/options-framework-theme/
 *
*/
if ( !function_exists( 'optionsframework_init' ) ) {
    if ( STYLESHEETPATH == TEMPLATEPATH ) {
            define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
            define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
    } else {
            define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');
            define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('stylesheet_directory') . '/admin/');
    }
    
    require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Quote section using post format
 * 
 */
add_theme_support( 'post-formats', array( 'quote' ) );
function tp_random_quote(){
    global $post;
    $args = array(
		  'posts_per_page' => 1,
		  'post_type' => 'post',
		  'orderby' => 'rand',
		  'tax_query' => array(
		    array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => 'post-format-quote'
		    )
		  )
		  );
    $the_query = new WP_Query($args);
    while ( $the_query->have_posts() ) : $the_query->the_post();
    ?>

    <div id="random-quote">
	<div id="quote-wrap">
	    <?php the_content(); ?>					
	</div>
    </div>


    <?php
    endwhile;
    wp_reset_postdata();
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Hook the stylesheets & scripts to wp_head
 * 
 */
add_action('wp_head', 'tp_stylesheets_scripts', 5);
function tp_stylesheets_scripts(){
    // Register scripts & stylesheets
    wp_register_style('ess-main', get_bloginfo('stylesheet_directory') . '/css/main.css', array(), false, 'screen');
    wp_enqueue_style('ess-main');
		
    // Adding scripts into wp_head()
    wp_deregister_script('jquery');
    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js', array(), false, false);
    wp_enqueue_script('jquery');
}





/*
 * ------------------------------------------------------------------------------------------------------------------------ 
 * Hooking custom javascript
 *
 */
add_action('wp_head', 'tp_javascripts', 10);
function tp_javascripts(){
    ?>
    <script type="text/javascript">
	//<![CDATA[
        jQuery(document).ready(function($){
            $("#nav li").hover(function(){$(this).addClass("hover").children("ul").slideToggle();}, function(){$(this).removeClass("hover").children("ul").slideToggle();});
            
            $('#more-content-nav a').click(function(){
                $('#more-content-nav a').toggle();
                $('#nav-bar').slideToggle();
                return false;
            });
            
	    <?php if (is_single()) :?>
	    $('#subscription-channel li').hover(function(){$(this).fadeTo('medium', 1);}, function(){$(this).fadeTo('slow', 0.5);});
	    
            /* Set similar height */
            function setEqualHeight(columns){
                var tallestcolumn = 0;
                columns.each(function(){
                    currentHeight = $(this).height();
                    if(currentHeight > tallestcolumn){
		    tallestcolumn  = currentHeight + 8;
                    }
		});
		columns.height(tallestcolumn);
            }
            setEqualHeight($('.meta-item'));
            <?php endif; ?>
            
        });
	//]]>
    </script>
    <?php
    echo of_get_option('tp_custom_js', '');

}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Custom Favicon
 * 
 */
add_action('wp_head', 'tp_favicon', 5);
function tp_favicon(){
    if (of_get_option('tp_favicon', '') != ''){
	?>
	<link rel="icon" href="<?php echo of_get_option('tp_favicon', ''); ?>" type="image/x-icon" />
	<?php
    }
}




/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Custom Color Scheme
 * 
 */
add_action('wp_head', 'tp_color_scheme', 5);
function tp_color_scheme(){
?>
<style type="text/css">
/* Main Backgrounds */
#head,
#nav .hover a:hover     {background:<?php echo of_get_option('tp_main_background', '#555'); ?>;}

/* Links */
a			{color:<?php echo of_get_option('tp_link_color', '#000000'); ?>; text-decoration:none;}

/* Hovered State */
a:hover                 {color:<?php echo of_get_option('tp_link_hover', '#960000'); ?>;}

/* Header */
#head,
#sitename a             {color:<?php echo of_get_option('tp_header_color', '#FFFFFF'); ?>;}
#sitename a:hover       {color:<?php echo of_get_option('tp_header_hover', '#AFAFAF'); ?>;}
</style>
<?php
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Custom Typography
 * 
 */
add_action('wp_head', 'tp_typography', 5); 
function tp_typography(){
    if (of_get_option('tp_heading_typography', 'Georgia') != 'Georgia'){
	$printed_typography = str_replace("+", " ", of_get_option('tp_heading_typography', 'Georgia'));
	?>
<link href='http://fonts.googleapis.com/css?family=<?php echo of_get_option('tp_heading_typography', 'Georgia')?>' rel='stylesheet' type='text/css'>
<style type="text/css">
body #sitename,
body #sitename a,
body .title,
body .title a,
body .content h1,
body .content h2,
body .content h3,
body .content h4,
body .content h5,
body .content h6,
body .section-title,
body .widget-title,
body .comment-title,
body #reply-title,
body #credit {font-family:'<?php echo $printed_typography; ?>'; font-style:normal; font-weight:normal; text-transform:none !important;}
body #sitename,
body #sitename a {font-size:45px;}
body .section-title,
body .widget-title {font-size:18px !important;}

</style>	
	<?php
    }
}



/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Formatting site's heading for the sake of SEO - only one h1 per page
 * 
 */
function tp_sitename(){
    if (is_home()){
        echo '<h1 id="sitename">'. get_bloginfo("name") .'</h1>';
    } else {
        echo '<h2 id="sitename"><a href="'. get_bloginfo("url") .'">'. get_bloginfo("name") .'</a></h2>';
    }
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Create "home" option on WordPress Custom Menu page
 * 
 */
function custom_page_menu_args( $args ) {
$args['show_home'] = true;
return $args;
}
add_filter( 'wp_page_menu_args', 'custom_page_menu_args' );





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Registering Custom Menus
 *
 */
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'main_nav' => 'Main Navigation'
		)
	);
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Register Sidebars
 *
 */
register_sidebar( array(
    'name' => __( 'Navigation Bar', 'thoughtplifier' ),
    'id' => 'nav-bar-area',
    'description' => __( 'The navigation bar widget area', 'thoughtplifier' ),
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );

register_sidebar( array(
    'name' => __( 'Footer Bar', 'thoughtplifier' ),
    'id' => 'footer-area',
    'description' => __( 'The footer widget area', 'thoughtplifier' ),
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) );





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Adding Post Thumbnail Support
 *
 */
add_theme_support('post-thumbnails');
add_image_size( 'main-image', 480, 360, true);





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Post Date & Meta
 *
 */
function tp_post_date(){
	echo '<span class="post-date">';
	the_time('F jS, Y');
	echo '</span>';
}

function tp_post_meta(){
	echo "<span>";
	echo "By: " . get_the_author_link();
	echo "</span><span>" . __('Posted in: ', 'thoughtplifier');
	the_category(', ');
	echo "</span>";
}




/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Custom Controllable Excerpt
 *
 */
function tp_excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt);
	} else {
		$excerpt = implode(" ",$excerpt);
	}	
	
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Subscribe & Connect Box
 * 
*/
function tp_subscribe_box(){
    ?>
            <div id="subscribe-box" class="clearfix">
                <h4 class="section-title">Connect &amp; Subscribe</h4>
                <p class="description">Keep in touch and get my latest content trough:</p>
                <ul id="subscription-channel">
                    <li><a href="http://twitter.com/<?php echo of_get_option('twitter_username', 'fikrirasyid'); ?>" id="twitter" title="Follow @<?php echo of_get_option('twitter_username', 'fikrirasyid'); ?> on Twitter">Twitter</a></li>
                    <li><a href="<?php echo of_get_option('facebook_url', 'http://facebook.com/fikri.rasyid.book'); ?>" id="facebook" title="Subscribe &amp; be friend on Facebook">Facebook</a></li>
                    <li><a href="<?php echo of_get_option('rssfeed_url', get_bloginfo('url') . "/?feed=rss"); ?>" id="rss" title="Subscribe to our RSS Feed">RSS Feed</a></li>
                    <li>
                        <span id="email-subs">Email</span>
                        <span class="description">
                            <form id="feedburner-form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo of_get_option('feedburner_id', 'FikriRasyid'); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
                                <input type="text" id="feedburner-email" name="email" value='Type your email &amp; hit enter' onfocus="if (this.value == 'Type your email &amp; hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Type your email &amp; hit enter';}" />
                                <input type="hidden" value="<?php echo of_get_option('feedburner_id', 'FikriRasyid'); ?>" name="uri"/>
                                <input type="hidden" name="loc" value="en_US"/>
                            </form>
                            Get latest post on your inbox.
                        </span>
                    </li>
                </ul>
            </div><!-- #subscribe-box -->    
    <?php
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Author Box
 *
 */
function tp_author_box(){		
	// Get the author email -> for Gravatar
	$author_email = get_the_author_meta('user_email');
		
	// Get the author description
	$author_description = get_the_author_meta('description');
		
	echo '
	    <h4 class="section-title">' . __('About The Author', 'thoughtplifier') . '</h4>
            ' . get_avatar($author_email, 50, '') . '
            <p>' . get_the_author_link() . ' - ' . $author_description . '</p>
	';
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Related Posts
 *
 */
function tp_related_posts($showposts){
    global $post;
    
    // Get current post category -> Make query based on it
    $categories = get_the_category($post->ID);
    if ($categories) {
        $category_ids = array();
        foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
        
        $args=array(
            'category__in' => $category_ids,
            'post__not_in' => array($post->ID),
            'showposts'=>$showposts, // Number of related posts that will be shown.
            'ignore_sticky_posts'=>1
    );
            
    // The custom query + browser output					
    $my_query = new wp_query($args);
    if( $my_query->have_posts() ) {
        ?>
        <h4 class="section-title"><?php _e('Related Posts', 'thoughtplifier'); ?></h4>
        <ol>
            <?php        
                while ($my_query->have_posts()) {
                $my_query->the_post();
            ?>                    
            <li><a href="<?php the_permalink(); ?>" title="view <?php the_title(); ?>"><?php the_title(); ?></a></li>
            <?php } ?>            
        </ol>
        <?php
        }
    }
            
    // Reset query
    wp_reset_query();
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Comments & Ping Listings
 *
 */
add_filter('get_comments_number', 'tp_comment_count', 0);
function tp_comment_count( $count ) {
	global $id;
	$comments_by_type = &separate_comments(get_comments('post_id=' . $id));
	return count($comments_by_type['comment']);
}

function tp_list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li id="comment-<?php comment_ID(); ?>">
		<?php comment_author_link(); ?>
		<span><?php comment_date('d m y'); ?></span>
	<?php
}

function tp_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">	
		<div id="div-comment-<?php comment_ID() ?>" class="comment-wrap">
			<div class="comment-wrap-inside">
				<div class="comment-avatar">
					<?php echo get_avatar($comment, 50, ''); ?>
				</div>
				<div class="comment-content">
					<p class="comment-author"><strong><?php comment_author_link(); ?></strong></p>
                                        <p class="comment-date"><?php printf( get_comment_time('d F Y')) ?><?php edit_comment_link(__('| Edit', 'thoughtplifier'),'  ','') ?></p>
					<?php if ($comment->comment_approved == '0') : ?>
					<p><em><?php _e('Your comment will appear after being approved by admin.', 'thoughtplifier') ?></em> </p>
					<?php endif; ?>
					<div class="content">
                                            <?php comment_text() ?>
                                        </div>
					<?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply', 'thoughtplifier'), 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			</div>
		</div><!-- .comment-wrap -->
	<?php
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Page Navigation
 * 
 * Based on Boutros AbiChedid
 * http://bacsoftwareconsulting.com/blog/index.php/web-programming/add-custom-wordpress-pagination-without-plugin/
 *
*/

/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */
function round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}
 
/* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */
function pagenavi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $pagenavi_options = array();
    $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['next_text'] = '&raquo;';
    $pagenavi_options['prev_text'] = '&laquo;';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; //continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;
 
    //If NOT a single Post is being displayed
    /*http://codex.wordpress.org/Function_Reference/is_single)*/
    if (!is_single()) {
        $request = $wp_query->request;
        //intval Ñ Get the integer value of a variable
        /*http://php.net/manual/en/function.intval.php*/
        $posts_per_page = intval(get_query_var('posts_per_page'));
        //Retrieve variable in the WP_Query class.
        /*http://codex.wordpress.org/Function_Reference/get_query_var*/
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
 
        //empty Ñ Determine whether a variable is empty
        /*http://php.net/manual/en/function.empty.php*/
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
 
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        //ceil Ñ Round fractions up (http://us2.php.net/manual/en/function.ceil.php)
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
 
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        //round_num() custom function - Rounds To The Nearest Value.
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
 
        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
            /*http://php.net/manual/en/function.str-replace.php */
            /*number_format_i18n(): Converts integer number to format based on locale (wp-includes/functions.php*/
            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
            echo $before.'<div class="pagenavi">'."\n";
 
            if(!empty($pages_text)) {
                echo '<span class="pages">'.$pages_text.'</span> <div class="the-navi">';
            }
            //Displays a link to the previous post which exists in chronological order from the current post.
            /*http://codex.wordpress.org/Function_Reference/previous_post_link*/
 
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                //esc_url(): Encodes < > & " ' (less than, greater than, ampersand, double quote, single quote).
                /*http://codex.wordpress.org/Data_Validation*/
                //get_pagenum_link():(wp-includes/link-template.php)-Retrieve get links for page numbers.
                echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">&laquo First</a>';
            }

            previous_posts_link($pagenavi_options['prev_text']);

 
            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
 
            for($i = $start_page; $i  <= $end_page; $i++) {
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<span class="current">'.$current_page_text.'</span>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }

            next_posts_link($pagenavi_options['next_text'], $max_page);
 
            if ($end_page < $max_page) {
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">Last &raquo;</a>';
            }
 
            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
            echo '</div></div>'.$after."\n";
        }
    }
}





/*
 * ------------------------------------------------------------------------------------------------------------------------
 * Allow <script> tag to be embedded in theme option's textarea
 * 
*/
add_action('admin_init','optionscheck_change_santiziation', 100);

function optionscheck_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'tp_sanitize_textarea' );
}
 
function tp_sanitize_textarea($input) {
    global $allowedposttags;
      $custom_allowedtags["script"] = array();
 
      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
      $output = wp_kses( $input, $custom_allowedtags);
    return $output;
}