<?php
/**
 * Functions
 */

/******************************************************************************
 * Included Functions
 ******************************************************************************/

// Constants
define('IMAGE_ASSETS', get_stylesheet_directory_uri() . '/assets/images/');
define('IMAGE_PLACEHOLDER', IMAGE_ASSETS . 'placeholder.jpg');
define('ST_GOOGLE_MAPS_API', 'AIzaSyDquspgHVzjRyN1MKR7Y9FtBZd5ATJETEU');

// Helpers function
require_once get_stylesheet_directory() . '/inc/helpers.php';

add_action('init', function () {
    // Register ACF Gravity Forms field
    if (class_exists('ACF')) {
        require_once get_stylesheet_directory() . '/inc/class-acf-field-gravity-v5.php';
    }

    // ACF Gutenberg blocks
    include_once get_stylesheet_directory() . '/inc/gutenberg.php';
}, 9);

/**
 * Prevent Fatal error on site if ACF not installed/activated
 */
function include_acf_placeholder()
{
    include_once get_stylesheet_directory() . '/inc/acf-placeholder.php';
}

add_action('wp', 'include_acf_placeholder', PHP_INT_MAX);

// Install Recommended plugins
require_once get_stylesheet_directory() . '/inc/recommended-plugins.php';
// Walker modification
require_once get_stylesheet_directory() . '/inc/class-starter-navigation.php';
// Home slider function
include_once get_stylesheet_directory() . '/inc/home-slider.php';
// Dynamic admin. Add Custom columns to posts list view
include_once get_stylesheet_directory() . '/inc/class-dynamic-admin.php';
// SVG Support
include_once get_stylesheet_directory() . '/inc/svg-support.php';
// Lazy Load for Images, iframes, videos
include_once get_stylesheet_directory() . '/inc/class-lazyload.php';
// Extend WP Search with Custom fields
include_once get_stylesheet_directory() . '/inc/custom-fields-search.php';
// WooCommerce functionality
if (function_exists('WC')) {
    include_once get_stylesheet_directory() . '/inc/woo-custom.php';
}
// Include all additional shortcodes
//include_once get_stylesheet_directory() . '/inc/shortcodes.php';

// Disable Comments on the site completely
include_once get_stylesheet_directory() . '/inc/disable-comments.php';

/******************************************************************************
 * Global Functions
 ******************************************************************************/

/**
 * WP 5.2 wp_body_open backward compatibility
 */
if (!function_exists('wp_body_open')) {
    function wp_body_open()
    {
        do_action('wp_body_open');
    }
}

// By adding theme support, we declare that this theme does not use a
// hard-coded <title> tag in the document head, and expect WordPress to
// provide it for us.
add_theme_support('title-tag');

//  Add widget support shortcodes
add_filter('widget_text', 'do_shortcode');

// Support for Featured Images
add_theme_support('post-thumbnails');

// Custom Background
add_theme_support('custom-background', array('default-color' => 'fff'));

// Custom Logo
add_theme_support('custom-logo', array(
    'height' => '150',
    'flex-height' => true,
    'flex-width' => true,
));

function show_custom_logo($size = 'medium')
{
    if ($custom_logo_id = get_theme_mod('custom_logo')) {
        $logo_image = wp_get_attachment_image($custom_logo_id, $size, false, array(
            'class' => 'custom-logo skip-lazy',
            'itemprop' => 'siteLogo',
            'alt' => get_bloginfo('name'),
        ));
    } else {
        $logo_url = get_stylesheet_directory_uri() . '/assets/images/custom-logo.png';
        $w = 200;
        $h = 160;
        $logo_image = '<img src="' . $logo_url . '" width="' . $w . '" height="' . $h . '" class="custom-logo" itemprop="siteLogo" alt="' . get_bloginfo('name') . '">';
    }

    $html = sprintf('<a href="%1$s" class="custom-logo-link" rel="home" title="%2$s" itemscope>%3$s</a>', esc_url(home_url('/')), get_bloginfo('name'), $logo_image);
    echo apply_filters('get_custom_logo', $html);
}

// Add HTML5 elements
add_theme_support('html5', array(
    'comment-list',
    'search-form',
    'comment-form',
    'gallery',
    'caption',
    'script',
    'style',
));

// Add RSS Links generation
add_theme_support('automatic-feed-links');
// Hide comments feed link
add_filter('feed_links_show_comments_feed', '__return_false');

// Add excerpt to pages
add_post_type_support('page', 'excerpt');

// Register Navigation Menu
register_nav_menus(array(
    'header-menu' => 'Header Menu',
    'footer-menu' => 'Footer Menu',
    'sub-header-menu' => 'Sub Header Menu',
    'mobile-menu' => 'Mobile Menu'
));

/**
 * Create pagination
 *
 * @param WP_Query $query
 * @param bool $echo
 * @param null|string $base
 * @param array $args
 *
 * @return string|void
 */
function starter_pagination($query = '', $base = null, $echo = true, $args = [])
{
    if (empty($query)) {
        global $wp_query;
        $query = $wp_query;
    }

    $big = 999999999;
    $pagi_args = array(
        'base' => $base ?: str_replace($big, '%#%', esc_url(explode('?', get_pagenum_link($big), 2)[0])),
        'format' => 'page/%#%',
        'prev_next' => true,
        'prev_text' => '<span class="pagination-arrow fas fa-angle-left"></span>',
        'next_text' => '<span class="pagination-arrow fas fa-angle-right"></span>',
        'current' => max(1, $query->query_vars['paged']),
        'total' => $query->max_num_pages,
        'type' => 'array',
    );

    $args = !empty($_GET) ? array_merge($args, $_GET) : $args;
    if ($args) {
        foreach ($args as $key => $val) {
            $pagi_args['add_args'][$key] = $val;
        }
    }
    $links = paginate_links($pagi_args);
    $pagination = '';

    if ($links) {
        // Add empty prev link
        if ($pagi_args['current'] == 1) {
            array_unshift($links, str_replace('pagination-arrow', 'pagination-arrow disabled', $pagi_args['prev_text']));
        }

        // Add empty next link
        if ($pagi_args['current'] !== 1 && $pagi_args['current'] == $pagi_args['total']) {
            $links[] = str_replace('pagination-arrow', 'pagination-arrow disabled', $pagi_args['next_text']);
        }

        // Pagination container can be replaced with custom.
        // Pagination styles are placed in /scss/inc/_wp-core.scss:136
        $pagination = "<ul class='page-numbers'>\n\t<li>";
        $pagination .= implode("</li>\n\t<li>", $links);
        $pagination .= "</li>\n</ul>\n";

        //		$pagination = str_replace( 'page-numbers', 'pagination', $r );
    }

    if ($echo) {
        echo $pagination;
    } else {
        return $pagination;
    }
}

// Register Sidebars
function starter_widgets_init()
{
    /* Sidebar Right */
    register_sidebar(array(
        'id' => 'starter_sidebar_right',
        'name' => __('Sidebar Right'),
        'description' => __('This sidebar is located on the right-hand side of each page.'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="widget__title">',
        'after_title' => '</h5>',
    ));
    register_sidebar(array(
        'id' => 'footer_links',
        'name' => __('Footer Links'),
        'before_title' => '<h6 class="widget__title">',
        'after_title' => '</h6>',
    ));
    register_sidebar(array(
        'id' => 'footer_products',
        'name' => __('Footer Products'),
        'before_title' => '<h6 class="widget__title">',
        'after_title' => '</h6>',
    ));
    register_sidebar(array(
        'id' => 'copyright_menu',
        'name' => __('Copyright Menu'),
    ));

}

add_action('widgets_init', 'starter_widgets_init');

// Remove #more anchor from posts
function remove_more_jump_link($link)
{
    $offset = strpos($link, '#more-');
    if ($offset) {
        $end = strpos($link, '"', $offset);
    }
    if (!empty($end)) {
        $link = substr_replace($link, '', $offset, $end - $offset);
    }

    return $link;
}

add_filter('the_content_more_link', 'remove_more_jump_link');

// Remove more tag <span> anchor
function remove_more_anchor($content)
{
    return str_replace('<p><span id="more-' . get_the_ID() . '"></span></p>', '', $content);
}

add_filter('the_content', 'remove_more_anchor');


/******************************************************************************************************************************
 * Enqueue Scripts and Styles for Front-End
 *******************************************************************************************************************************/

//Remove jQuery Migrate
function starter_remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}

add_action('wp_default_scripts', 'starter_remove_jquery_migrate');

function starter_scripts_and_styles()
{
    if (!is_admin()) {

      //  wp_deregister_style('gform_theme_ie11');

        // Load Stylesheets
        wp_enqueue_style('foundation', get_template_directory_uri() . '/assets/css/foundation.css', null, filemtime(get_stylesheet_directory() . '/assets/css/foundation.css'));
        wp_enqueue_style('select2', get_template_directory_uri() . '/assets/css/select2.min.css', null, '4.1.0');
        wp_enqueue_style('custom', get_template_directory_uri() . '/assets/css/custom.css', null, filemtime(get_stylesheet_directory() . '/assets/css/custom.css'));
        wp_enqueue_style('style', get_template_directory_uri() . '/style.css', null, filemtime(get_stylesheet_directory() . '/style.css'));
        wp_enqueue_style('custom-scrollbar-style', get_template_directory_uri() . '/assets/js/plugins/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.min.css');

        // Load JavaScripts
        wp_deregister_script('jquery-migrate');
        wp_enqueue_script('jquery');

       // wp_enqueue_script('foundation.min', get_template_directory_uri() . '/assets/js/foundation.min.js', null, '6.8.1', true);
       // wp_add_inline_script('foundation.min', 'jQuery(document).foundation();');

        //plugins
        //wp_enqueue_script('slick', get_template_directory_uri() . '/assets/js/plugins/slick.min.js', null, '1.8.1', true);
        //wp_enqueue_script('lazyload', get_template_directory_uri() . '/assets/js/plugins/lazyload.min.js', null, '17.8.2', true);
        //wp_enqueue_script('select2', get_template_directory_uri() . '/assets/js/plugins/select2.full.min.js', null, '4.1.0', true);
        //wp_enqueue_script('fancybox.v3', get_template_directory_uri() . '/assets/js/plugins/jquery.fancybox.v3.js', null, '3.5.7', true);
        //wp_enqueue_script('custom-scrollbar', get_template_directory_uri() . '/assets/js/plugins/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.concat.min.js', null, '3.5.7', true);
        //		wp_enqueue_script( 'fancybox.v4', get_template_directory_uri() . '/assets/js/plugins/fancybox.v4.js', null, '4.0.27', true );
        //		wp_enqueue_script( 'jarallax', get_template_directory_uri() . '/assets/js/plugins/jarallax.min.js', null, '2.14.0', true );

        // !!! DO NOT Use MatchHeight unless it's the only option to align blocks! Use Flex-box styles instead !!!
        //		wp_enqueue_script( 'matchHeight', get_template_directory_uri() . '/assets/js/plugins/jquery.matchHeight-min.js', null, '0.7.2', true );

        //custom javascript
       // wp_enqueue_script('global', get_template_directory_uri() . '/assets/js/global.js', ['jquery'], filemtime(get_stylesheet_directory() . '/assets/js/global.js'), true); /* This should go first */
        // Additional PHP data that will be accessible in JS files
        $localize_args = [
            'url' => admin_url('admin-ajax.php'),
        ];
        wp_localize_script('global', 'ajax', $localize_args);

    }
}

add_action('wp_enqueue_scripts', 'starter_scripts_and_styles');

add_action('wp_head', function() {
    remove_action('wp_head', 'wp_custom_css_cb', 101);
}, 1);


function my_dequeue_recaptcha() {
    if ( is_admin() ) return;

    if ( ! is_page('contact') ) {
        wp_dequeue_script('google-recaptcha');
    }
}
add_action('wp_enqueue_scripts', 'my_dequeue_recaptcha', 999);

add_filter('acf/load_field/type=google_map', function ($field) {
    $google_map_api = 'https://maps.googleapis.com/maps/api/js';
    $api_args = array(
        'key' => get_theme_mod('google_maps_api') ?: ST_GOOGLE_MAPS_API,
        'language' => 'en',
        'v' => '3.exp',
    );
    wp_enqueue_script('google.maps.api', add_query_arg($api_args, $google_map_api), null, null, true);

    return $field;
});

/******************************************************************************
 * Additional Functions
 *******************************************************************************/

// Specify image sizes that need to be optimized
function specify_sizes_to_optimize($sizes)
{
    if (empty($sizes) || $sizes == 'thumbnail,medium') {
        $sizes = 'thumbnail,medium,medium_large,large,large_high,full_hd,1536x1536,2048x2048';
    }

    return $sizes;
}

add_filter('wbcr/factory/populate_option_allowed_sizes_thumbnail', 'specify_sizes_to_optimize');

// Disable Robin Image optimizer backup
function disabled_image_bckp_by_default()
{
    return !empty(get_option('wbcr_io_backup_origin_images')) ? get_option('wbcr_io_backup_origin_images') : 0;
}

add_filter('wbcr/factory/populate_option_backup_origin_images', 'disabled_image_bckp_by_default');

function disabled_image_bckp_on_init()
{
    update_option('wbcr_io_backup_origin_images', 0);
}

add_action('wbcr/factory/plugin_activated', 'disabled_image_bckp_on_init');

// Disable Robin Image resize image
function disabled_image_resize_by_default()
{
    return !empty(get_option('wbcr_io_resize_larger')) ? get_option('wbcr_io_resize_larger') : 0;
}

add_filter('wbcr/factory/populate_option_resize_larger', 'disabled_image_resize_by_default');

// Enable revisions for all custom post types
add_filter('cptui_user_supports_params', function () {
    return array('revisions');
});

/**
 * Limit number of revisions for all post types
 *
 * @return int
 */
function limit_revisions_number()
{
    return 10;
}

add_filter('wp_revisions_to_keep', 'limit_revisions_number');

// Add ability ro reply to comments
add_filter('wpseo_remove_reply_to_com', '__return_false');

/**
 * Loop Vimeo videos inserted via wp_oembed_get
 *
 * @param $provider
 * @param $url
 * @param $args
 *
 * @return mixed|string
 */
function starter_loop_vimeo_videos($provider, $url, $args)
{
    if (strpos($provider, 'vimeo') !== false && !empty($args['location'])) {
        $video_args = [
            'background' => 1,
        ];
        $provider = add_query_arg($video_args, $provider);
    }

    return $provider;
}

add_filter('oembed_fetch_url', 'starter_loop_vimeo_videos', 10, 3);

// Enable control over YouTube iframe through API + add unique ID
function add_youtube_iframe_args($html, $url, $args)
{
    /* Modify video parameters. */
    if (strstr($html, 'youtube.com/embed/') && !empty($args['location'])) {
        preg_match_all('|embed/(.*)\?|', $html, $matches);
        $html = str_replace('?feature=oembed', '?feature=oembed&enablejsapi=1&autoplay=1&mute=1&controls=0&loop=1&showinfo=0&rel=0&playlist=' . $matches[1][0], $html);
        $html = str_replace('<iframe', '<iframe rel="0" enablejsapi="1" id=slide-' . get_the_ID(), $html);
    }

    return $html;
}

add_filter('oembed_result', 'add_youtube_iframe_args', 10, 3);

/**
 * Remove author archive pages
 */
function remove_author_archive_page()
{
    global $wp_query;

    if (is_author()) {
        $wp_query->set_404();
        status_header(404);
        // Redirect to homepage
        // wp_redirect(get_option('home'));
    }
}

add_action('template_redirect', 'remove_author_archive_page');

/**
 * Remove users endpoint from REST API
 *
 * @param $endpoints
 *
 * @return mixed
 */
function starter_disable_rest_users_endpoint($endpoints)
{
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }

    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }

    return $endpoints;
}

add_filter('rest_endpoints', 'starter_disable_rest_users_endpoint');

/**
 * Remove comments feed links
 */
add_filter('post_comments_feed_link', '__return_null');

// Stick Admin Bar To The Top
if (!is_admin()) {
    add_theme_support('admin-bar', array('callback' => '__return_false'));

    function stick_admin_bar()
    {
        echo "
			<style>
			@media only screen and (min-width: 1025px) {
				body.admin-bar {margin-top:32px !important}
			}
			@media only screen and (max-width: 1024px) {
				#wpadminbar {display: none;}
			}
			</style>
			";
    }

    add_action('wp_head', 'stick_admin_bar');
}

// Customize Login Screen
function wordpress_login_styling()
{
    if ($custom_logo_id = get_theme_mod('custom_logo')) {
        $custom_logo_img = wp_get_attachment_image_src($custom_logo_id, 'medium');
        $custom_logo_src = $custom_logo_img[0];
    } else {
        $custom_logo_src = 'wp-admin/images/wordpress-logo.svg?ver=20131107';
    }

    $bg_image = get_background_image();

    ?>
    <style type="text/css">
        .login #login h1 a {
            background-image: url('<?php echo $custom_logo_src; ?>');
            background-size: contain;
            background-position: 50% 50%;
            width: auto;
            height: 120px;
            max-width: 320px;
        }

        body.login {
            background-color: #f1f1f1;
            background-repeat: repeat;
            background-position: center center;
        <?php echo $bg_image ? "background-image: url('{$bg_image}') !important;" : ''; ?>
        }
    </style>
<?php }

add_action('login_enqueue_scripts', 'wordpress_login_styling');

function admin_logo_custom_url()
{
    $site_url = get_bloginfo('url');

    return ($site_url);
}

add_filter('login_headerurl', 'admin_logo_custom_url');

/**
 * Display GravityForms fields label if it set to Hidden
 */

function display_gf_fields_label()
{
    echo '<style>.hidden_label label.gfield_label{visibility:visible;line-height:inherit;}.theme-overlay .theme-version{display: none;}</style>';
}

add_action('admin_head', 'display_gf_fields_label');

// ACF Pro Options Page

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
    ));

}

// Set Google Map API key

function set_custom_google_api_key()
{
    acf_update_setting('google_api_key', get_theme_mod('google_maps_api') ?: ST_GOOGLE_MAPS_API);
}

add_action('acf/init', 'set_custom_google_api_key');

// Disable Emoji

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
add_filter('tiny_mce_plugins', 'disable_wp_emojis_in_tinymce');

function disable_wp_emojis_in_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

// Wrap any iframe and emved tag into div for responsive view

function iframe_wrapper($content)
{
    // match any iframes
    $pattern = '~<iframe.*?<\/iframe>|<embed.*?<\/embed>~';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        // Check if it is a video player iframe
        preg_match('~src="(.*?)"~', $match, $iframe_src);
        if (is_embed_video($iframe_src[1])) {
            // wrap matched iframe with div
            $wrappedframe = '<span class="responsive-embed widescreen">' . $match . '</span>';
            //replace original iframe with new in content
            $content = str_replace($match, $wrappedframe, $content);
        }
    }

    return $content;
}

add_filter('the_content', 'iframe_wrapper');
add_filter('acf_the_content', 'iframe_wrapper');


// Dynamic Admin
if (is_admin()) {
    // $dynamic_admin = new DynamicAdmin();
    //	$dynamic_admin->addField( 'page', 'template', 'Page Template', 'template_detail_field_for_page' );

    // $dynamic_admin->run();
}

// Custom outline color
add_action('wp_head', 'custom_outline_color');

function custom_outline_color()
{
    $outline_color = get_theme_mod('outline_color');
    if ($outline_color) {
        echo "<style>a,input,button,textarea,select{outline-color: {$outline_color}}</style>";
    }
}

// Register Google Maps API key settings in customizer

function register_google_maps_settings($wp_customize)
{
    $wp_customize->add_section('google_maps', array(
        'title' => __('Google Maps', 'default'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('google_maps_api', array(
        'default' => ST_GOOGLE_MAPS_API,
    ));
    $wp_customize->add_control('google_maps_api', array(
        'label' => __('Google Maps API key', 'default'),
        'section' => 'google_maps',
        'settings' => 'google_maps_api',
        'type' => 'text',
    ));

    $wp_customize->add_setting('outline_color', array());
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'outline_color', array(
        'label' => __('Outline color', 'default'),
        'section' => 'colors',
        'settings' => 'outline_color',
    )));
}

add_action('customize_register', 'register_google_maps_settings');

/**
 * Prevent Heartbeat API fire too often. Default is 5 sec, increase it to 60 sec.
 */
add_filter('heartbeat_settings', function ($settings) {
    $settings['interval'] = 60;

    return $settings;
});

/**
 * Copyright field functionality
 *
 * @param array $field ACF Field settings
 *
 * @return array
 */

function populate_copyright_instructions($field)
{
    $field['instructions'] = 'Input <code>@year</code> to replace static year with dynamic, so it will always shows current year.';

    return $field;
}

add_action('acf/load_field/name=copyright', 'populate_copyright_instructions');

if (!is_admin()) {
    // Replace @year with current year
    add_filter('acf/load_value/name=copyright', function ($value) {
        return str_replace('@year', date('Y'), $value);
    });
}

/**
 * Apply lazyload to whole page content
 */

function lazyload()
{
    ob_start('lazyloadBuffer');
}

add_action('template_redirect', 'lazyload');

/**
 * @param string $html HTML content.
 *
 * @return string
 */
function lazyloadBuffer($html)
{
    $lazy = new CreateLazyImg;
    $buffer = $lazy->ignoreScripts($html);
    $buffer = $lazy->ignoreNoscripts($buffer);

    $html = $lazy->lazyloadImages($html, $buffer);
    $html = $lazy->lazyloadPictures($html, $buffer);
    $html = $lazy->lazyloadVideos($html, $buffer);
    $html = $lazy->lazyloadBackgroundImages($html, $buffer);
    $html = $lazy->lazyloadIframes($html, $buffer);

    return $html;
}

// Disable default WP lazyload
add_filter('wp_lazy_loading_enabled', '__return_false');

/**
 * Remove 'current_page_parent' class from blog page item on any other post type archives
 *
 * @param array $classes list of classes
 * @param WP_Post $item menu item object
 *
 * @return array list of classes
 */

function remove_blog_page_classes($classes, $item)
{
    if ((is_post_type_archive() || !is_singular('post')) && $item->type == 'post_type' && $item->object_id == get_option('page_for_posts')) {
        $classes = array_diff($classes, array('current_page_parent'));
    }

    return $classes;
}

add_filter('nav_menu_css_class', 'remove_blog_page_classes', 10, 2);


/**
 * Custom styles in TinyMCE
 *
 * @param array $buttons
 *
 * @return array
 */

function custom_style_selector($buttons)
{
    array_unshift($buttons, 'styleselect');

    return $buttons;
}

add_filter('mce_buttons_2', 'custom_style_selector');

function starter_update_default_tinymce_settings($init_array)
{
    // Define the style_formats array
    $style_formats = array(
        array(
            'title' => 'Heading 1',
            'classes' => 'h1',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 2',
            'classes' => 'h2',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 3',
            'classes' => 'h3',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 4',
            'classes' => 'h4',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 5',
            'classes' => 'h5',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Heading 6',
            'classes' => 'h6',
            'selector' => 'h1,h2,h3,h4,h5,h6,p,li',
            'wrapper' => false,
        ),
        array(
            'title' => 'Button',
            'classes' => 'button',
            'selector' => 'a',
            'wrapper' => false,
        ),
        array(
            'title' => 'Small text',
            'inline' => 'small',
        ),
        array(
            'title' => 'Two columns',
            'classes' => 'two-columns',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,ul',
        ),
        array(
            'title' => 'Three columns',
            'classes' => 'three-columns',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,ul',
        ),
        array(
            'title' => 'Margin 0',
            'classes' => 'm-0',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,ul,ol',
            'wrapper' => false,
        ),
        array(
            'title' => 'Margin 30px',
            'classes' => 'm-30 ',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,ul,ol',
            'wrapper' => false,
        ),
        array(
            'title' => 'Margin 46px',
            'classes' => 'm-46 ',
            'selector' => 'p,h1,h2,h3,h4,h5,h6,ul,ol',
            'wrapper' => false,
        ),
        array(
            'title' => 'Checked List Style',
            'classes' => 'styled-list',
            'selector' => 'ul,ol',
            'wrapper' => false,
        ),
    );
    $init_array['style_formats'] = json_encode($style_formats);

    // Define Editor styles css version. Preventing hard caching
    $time = filemtime(get_stylesheet_directory() . '/editor-style.css');
    // Add the timestamp
    $init_array['cache_suffix'] = 'v=' . $time;

    // Add custom color to TinyMCE editor text color selector
    $default_colours = '"000000", "Black","993300", "Burnt orange","333300", "Dark olive","003300", "Dark green","003366", "Dark azure","000080", "Navy Blue","333399", "Indigo","333333", "Very dark gray","800000", "Maroon","FF6600", "Orange","808000", "Olive","008000", "Green","008080", "Teal","0000FF", "Blue","666699", "Grayish blue","808080", "Gray","FF0000", "Red","FF9900", "Amber","99CC00", "Yellow green","339966", "Sea green","33CCCC", "Turquoise","3366FF", "Royal blue","800080", "Purple","999999", "Medium gray","FF00FF", "Magenta","FFCC00", "Gold","FFFF00", "Yellow","00FF00", "Lime","00FFFF", "Aqua","00CCFF", "Sky blue","993366", "Brown","C0C0C0", "Silver","FF99CC", "Pink","FFCC99", "Peach","FFFF99", "Light yellow","CCFFCC", "Pale green","CCFFFF", "Pale cyan","99CCFF", "Light sky blue","CC99FF", "Plum","FFFFFF", "White"';

    $custom_colours = '';

    foreach (get_theme_colors() as $color) {
        $custom_colours .= '"' . str_replace('#', '', $color['color']) . '","' . $color['name'] . '",';
    }

    $init_array['textcolor_map'] = '[' . $default_colours . ',' . $custom_colours . ']';
    $init_array['textcolor_rows'] = 6; // expand colour grid to 6 rows

    return $init_array;
}

add_filter('tiny_mce_before_init', 'starter_update_default_tinymce_settings');

// Include styles for TinyMCE editor
add_editor_style();

/**
 * Populate ACF color picker swatches with custom colors
 *
 * @return void
 */
function starter_custom_color_picker_colors()
{
    $site_colors = get_theme_colors();
    $colors = wp_list_pluck($site_colors ?? [], 'color');
    if ($colors) {
        $colors_num = count($colors);
        $default_colors = ['#000', '#fff', '#d33', '#d93', '#ee2', '#81d742', '#1e73be', '#8224e3'];
        array_splice($default_colors, 0, $colors_num, $colors);
        $colors_string = json_encode($default_colors);
        wp_add_inline_script('acf-input', "acf.add_filter('color_picker_args', function( args ){args.palettes={$colors_string}; return args; });");
    }

    wp_add_inline_style('acf-input', "body .iris-picker .iris-palette{box-shadow:inset 0 0 2px rgba(0,0,0,.4)}");
}

add_action('acf/input/admin_enqueue_scripts', 'starter_custom_color_picker_colors');

// Move Yoast Meta Box to bottom

function yoasttobottom()
{
    return 'low';
}

add_filter('wpseo_metabox_prio', 'yoasttobottom');

/**
 * Gravity forms custom functions
 */

/**
 * Enable GF Honeypot for all forms
 *
 * @param $form
 * @param $is_new
 */

function enable_honeypot_on_new_form_creation($form, $is_new)
{
    if ($is_new) {
        $form['enableHoneypot'] = true;
        $form['is_active'] = 1;
        GFAPI::update_form($form);
    }
}

add_action('gform_after_save_form', 'enable_honeypot_on_new_form_creation', 10, 2);

/**
 * Disable date field autocomplete popup
 *
 * @param string $input field HTML markup
 * @param object $field GForm field object
 *
 * @return string
 */

function gform_remove_date_autocomplete($input, $field)
{
    if (is_admin()) {
        return $input;
    }
    if ($field->type == 'date') {
        $input = str_replace('<input', '<input autocomplete="off" ', $input);
    }

    return $input;
}

add_filter('gform_field_content', 'gform_remove_date_autocomplete', 11, 2);

// Prevent page jumping on form submit
add_filter('gform_confirmation_anchor', '__return_false');

// Show Gravity Form field label appearance dropdown
add_filter('gform_enable_field_label_visibility_settings', '__return_true');

// Replace standard form input with button
function form_submit_button($button, $form)
{
    if ($form['button']['type'] == 'image' && !empty($form['button']['imageUrl'])) {
        return $button;
    }

    preg_match("~value=(?:\"|')(.*?)(?:\"|')~", $button, $matches);

    return str_replace(array('input', '/>'), array('button', '>'), $button) . "{$matches[1]}</button>";
}

add_filter("gform_submit_button", "form_submit_button", 10, 2);
add_filter("gform_next_button", "form_submit_button", 10, 2);
add_filter("gform_previous_button", "form_submit_button", 10, 2);

// Add ADA support on Gravity form error message
function form_submit_error_ada_notice($msg)
{
    return str_replace("class=", "role='alert' class=", $msg);
}

add_filter('gform_validation_message', 'form_submit_error_ada_notice');

// Add ADA support on Gravity form success message
function form_submit_success_ada_notice($msg)
{
    return str_replace("id='gform_confirmation_message", "role='alert' id='gform_confirmation_message", $msg);
}

add_filter('gform_confirmation', 'form_submit_success_ada_notice');

// Prevent loading Gravity forms styles
//add_filter( 'gform_disable_css', '__return_true' );

// Overwrite default gravity forms theme slug
/*add_filter( 'gform_form_theme_slug', function () {
	return 'gravity-theme';
} );*/

// Preselect gravity form legacy theme in Gutenberg block
/*add_action( 'enqueue_block_editor_assets', function () {
	wp_add_inline_script( 'gform_gravityforms_admin', 'wp.hooks.addFilter("blocks.registerBlockType","gravityforms/form",(t,r)=>"gravityforms/form"===r?Object.assign({},t,{attributes:Object.assign({},t.attributes,{theme:{type:"string",default:"gravity-theme"}})}):t);' );
} );*/

/**
 * Remove US phone format from Gravity forms phone field
 *
 * @param array $options List of phone options
 *
 * @return array
 */
function starter_gf_limit_phone_formats( $options ) {
	if ( ! empty( $options['standard'] ) && ! empty( $options['international'] ) ) {
		$options['standard'] = $options['international'];
		unset( $options['international'] );
	}

	return $options;
}

//add_filter( 'gform_phone_formats', 'starter_gf_limit_phone_formats' );

/**
 * Update Gravity forms title column with instruction
 *
 * @param array $columns List of columns
 *
 * @return array
 */
function starter_update_forms_title_column($columns)
{
    if (!empty($columns['title'])) {
        $columns['title'] = $columns['title'] . ' ' . __('(Use ACF text to output form title, instead of Form title)', 'starter');
    }

    return $columns;
}

add_filter('gform_form_list_columns', 'starter_update_forms_title_column');

/**
 * Allow script and iframe html tags within ACF WYSIWYG editor field
 */

add_filter('acf/the_field/allow_unsafe_html', '__return_true');

/*********************** PUT YOU FUNCTIONS BELOW ********************************/

add_image_size('full_hd', 1920, 0, array('center', 'center'));
add_image_size('large_high', 1024, 0, false);
// add_image_size( 'name', width, height, array('center','center'));

/**
 * Replace WordPress email Sender name
 *
 * @return string
 */
function replace_email_sender_name()
{
    return get_bloginfo();
}

add_filter('wp_mail_from_name', 'replace_email_sender_name');

/**
 * Add WooCommerce support
 */
function theme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
    // add_theme_support( 'wc-product-gallery-zoom' );
    // add_theme_support( 'wc-product-gallery-lightbox' );
    // add_theme_support( 'wc-product-gallery-slider' );
}

add_action('after_setup_theme', 'theme_add_woocommerce_support');

/**
 * Add the wp-editor back into WordPress after it was removed in 4.2.2.
 *
 * @param Object $post
 *
 * @return void
 */
function starter_show_editor_on_posts_page($post)
{
    if (isset($post) && $post->ID != get_option('page_for_posts')) {
        return;
    }

    // Remove Notice "You are currently editing the page that shows your latest posts."
    remove_action('edit_form_after_title', '_wp_posts_page_notice');

    // Add content editor to the posts page
    add_post_type_support('page', 'editor');
}

//add_action( 'edit_form_after_title', 'starter_show_editor_on_posts_page', 1 );

/**
 * Theme main colors.
 *
 * @return array
 */
function get_theme_colors()
{
    // Default colors fallback.
    // TODO Fill $palette array with main design colors to be able use in Gutenberg editor
    $palette = [
        ["name" => "Black", "slug" => "black", "color" => "#000000"],
        ["name" => "White", "slug" => "white", "color" => "#ffffff"],
        ["name" => "Blue", "slug" => "blue", "color" => "#2d22b4"],
    ];

    return $palette;
}

/*******************************************************************************/

// Gutenberg should be used by default!!!
// TODO comment acf_gutenberg support if Classic Editor is required  
//add_theme_support( 'acf_gutenberg' );

// TODO uncomment acf_flexible support ONLY if Flexible Content is required by client
//add_theme_support( 'acf_flexible' );

function custom_breadcrumbs()
{
    $separator = '/';
    $home = 'Home';
    echo '<nav class="breadcrumbs">';
    if (!is_front_page()) {
        echo '<a href="' . home_url() . '">' . $home  . '</a>' ;
        if (is_page()) {
            global $post;
            if ($post->post_parent) {
                $ancestors = array_reverse(get_post_ancestors($post->ID));
                foreach ($ancestors as $ancestor) {
                    echo ' <a href="' . get_permalink($ancestor) . '">' . $separator.' ' . get_the_title($ancestor) . '</a>';
                }
            }
            echo '<span >' . $separator . ' ' . get_the_title() . '</span>';
        }
    }
    echo '</nav>';
}

add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);

function my_wp_nav_menu_objects($items, $args)
{


    foreach ($items as &$item) {


        $icon = get_field('button_icon', $item);


        if ($icon) {

            $item->title = wp_get_attachment_image($icon["id"], 'full') . $item->title;

        }

    }


    return $items;

}


function enqueue_intl_tel_input_scripts()
{
    wp_enqueue_style('intl-tel-input-css', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css');

    wp_enqueue_script('intl-tel-input-js', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js', array('jquery'), null, true);

}

add_action('wp_enqueue_scripts', 'enqueue_intl_tel_input_scripts');


add_action('wp_ajax_filter_events', 'filter_events_callback');
add_action('wp_ajax_nopriv_filter_events', 'filter_events_callback');

function filter_events_callback()
{
    $blogTopics = $_POST['blogTopics'];
    $blogTools = $_POST['blogTools'];
    $searchBlog = $_POST['searchBlog'];
    $ammountOfPosts = $_POST['ammountOfPosts'];
    //pagination code
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $args = array(
        'post_type' => 'post',
        'order' => 'DESK',
        'orderby' => 'date',
  		'post_status' => 'publish',
        'posts_per_page' => $ammountOfPosts,
        'paged' => $paged,
        's' => $searchBlog
    );

    $tax_query = array('relation' => 'AND');
    if (!empty($blogTopics)) {
        $tax_query[] = array(
            'taxonomy' => 'blog-topics',
            'field' => 'slug',
            'terms' => $blogTopics,
        );
    }
    if (!empty($blogTools)) {
        $tax_query[] = array(
            'taxonomy' => 'guide-and-tools',
            'field' => 'slug',
            'terms' => $blogTools,
        );
    }
    if (!empty($tax_query) && count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }


    $query = new WP_Query($args);

    ?>
    <?php
    if ($query->have_posts()):?>
        <?php
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <article class="blog__item">
                <div class="blog__content">
                    <div class="blog__date"><?php the_date(); ?></div>
                    <a href="<?php the_permalink() ?>"><h5><?php the_title() ?></h5></a>
                    <div class="blog__text">
                        <?php echo wp_trim_words(get_the_content(), 27, ''); ?>
                    </div>
                    <div class="blog__taxonomy">
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'blog-topics');
                        if ($terms && !is_wp_error($terms)) :
                            foreach ($terms as $term) {
                                echo '<div class="blog__term">' . esc_html($term->name) . '</div>';
                            }
                        endif;
                        ?>
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'guide-and-tools');
                        if ($terms && !is_wp_error($terms)) :
                            foreach ($terms as $term) {
                                echo '<div class="blog__term">' . esc_html($term->name) . '</div>';
                            }
                        endif;
                        ?>
                        <?php if ($read = get_field('min_read')): ?>
                            <div class="blog__read"><?php echo $read ?> min read</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="blog__thumbnail">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large') ?>
                    <?php else: ?>
                        <img src="<?php echo IMAGE_ASSETS . 'placeholder.jpg' ?>" alt="">
                    <?php endif; ?>
                </div>
            </article>
            <?php
        }
        ?>
    <?php
    endif;

    $posts_html = ob_get_clean();


    $pagination_html = '';
    $total_pages = $query->max_num_pages;
    if ($total_pages > 1) {
        $current_page = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
        $pagination_html .= '<ul>';
        if ($current_page > 1) {
            $pagination_html .= '<li><a href="#" class="pagination-prev" data-page="' . ($current_page - 1) . '"><i class="fa-solid fa-arrow-left"></i></a></li>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            $pagination_html .= '<li><a href="#" data-page="' . $i . '">' . $i . '</a></li>';
        }

        if ($current_page < $total_pages) {
            $pagination_html .= '<li><a href="#" class="pagination-next" data-page="' . ($current_page + 1) . '"><i class="fa-solid fa-arrow-right"></i></a></li>';
        }

        $pagination_html .= '</ul>';
    }

    wp_send_json([
        'posts' => $posts_html,
        'pagination' => $pagination_html,
    ]);


    wp_die();
}

add_filter('wpseo_breadcrumb_separator', function () {
    return '>';
});
add_filter('wpseo_breadcrumb_links', function ($links) {
    $last_item = array_pop($links);
    $last_item['text'] = 'You are here';
    $links[] = $last_item;

    return $links;
});

add_filter( 'script_loader_tag', 'defer_recaptcha_loader', 10, 3 );
function defer_recaptcha_loader( $tag, $handle, $src ) {

    if ( is_admin() ) {
        return $tag;
    }

    if ( strpos( $src, 'google.com/recaptcha/api.js' ) === false ) {
        return $tag;
    }

    if ( strpos( $tag, 'defer' ) === false ) {
        $tag = str_replace( '<script ', '<script defer ', $tag );
    }

    return $tag;
}

add_filter('wpseo_breadcrumb_single_link_info', function($link_info) {
    if ( isset($link_info['text']) && $link_info['text'] === 'You are here' ) {
        $link_info['text'] = get_the_title();
    }
    return $link_info;
});
