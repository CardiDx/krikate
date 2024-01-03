<?php
// function customize_variation_price_display($variation_data, $product, $variation) {
//     $start_date = strtotime('2023-11-24 20:00:00'); // 24 ноября 20:00
//     $end_date = strtotime('2023-11-26 23:59:59'); // 26 ноября 23:59
//     $current_time = current_time('timestamp');
//     if ($current_time < $start_date || $current_time > $end_date) {
//         $variation_data['display_price'] = $variation_data['display_regular_price'];
//     }
//     return $variation_data;
// }
// add_filter('woocommerce_available_variation', 'customize_variation_price_display', 10, 3);

function send_admin_new_order_email( $order_id ) {
    $order = wc_get_order( $order_id );
    $mailer = WC()->mailer();
    $email  = $mailer->emails['WC_Email_New_Order'];
    $admin_email = get_option( 'admin_email' );
    $email->trigger( $order_id, $order );
    $mailer->send( $admin_email, $email->get_subject(), $email->get_content(), $email->get_headers(), $email->get_attachments() );
}
add_action( 'woocommerce_order_status_processing', 'send_admin_new_order_email', 10, 1 );

require get_template_directory() . '/include/site_include.php';
require get_template_directory() . '/include/product_functions.php';
require get_template_directory() . '/include/woocommerce-checkout-functions.php';

// Отключаем комментарии
add_action('init', function () {
    // Отключаем поддержку комментариев для записей
    remove_post_type_support('post', 'comments');
    // Отключаем поддержку комментариев для страниц
    remove_post_type_support('page', 'comments');
    // Запрещаем комментарии в админке
    update_option('comments_per_page', 0);
    // Удаляем ссылки на комментарии
    add_filter('get_comments_link', '__return_false');
    // Отключаем RSS-ленты комментариев
    add_filter('feed_links_comments_feed', '__return_false');
    // Удаляем пункт меню Комментарии в админке
    add_action('admin_menu', function () {
        remove_menu_page('edit-comments.php');
    });
    // Удаляем ссылку на комментарии в админ-баре
    add_action('wp_before_admin_bar_render', function () {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
    });
});

function register_sidebar_menu()
{
    $current_domain = $_SERVER['HTTP_HOST'];
    register_nav_menu('sitebar-menu', __('Sidebar Menu', $current_domain ));
}

add_action('after_setup_theme', 'register_sidebar_menu');


function the_excerpt_max_charlength($charlength, $product_excerpt)
{
    if (mb_strlen($product_excerpt) > $charlength) {
        $subex = mb_substr($product_excerpt, 0, $charlength - 5);
        $exwords = explode(' ', $subex);
        $excut = - (mb_strlen($exwords[count($exwords) - 1]));
        if ($excut < 0) {
            echo mb_substr($subex, 0, $excut);
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $product_excerpt;
    }
}

add_filter('get_the_archive_title', function ($title) {
    return preg_replace('~^[^:]+: ~', '', $title);
});


if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

add_filter('upload_mimes', 'upload_allow_types');
function upload_allow_types($mimes)
{
    $mimes['ico']  = 'image/vnd.microsoft.icon';
    $mimes['svg']  = 'image/svg+xml';
    $mimes['csv'] = 'text/csv';
    return $mimes;
}

add_action('after_setup_theme', 'krikate_setup');
function krikate_setup()
{
    load_theme_textdomain('krikate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'krikate')));
}
add_action('admin_notices', 'krikate_notice');
function krikate_notice()
{
    $user_id = get_current_user_id();
    $admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param = (count($_GET)) ? '&' : '?';
    if (!get_user_meta($user_id, 'krikate_notice_dismissed_8') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p><a href="' . esc_url($admin_url), esc_html($param) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__('Ⓧ', 'krikate') . '</big></a>' . wp_kses_post(__('<big><strong>📝 Thank you for using krikate!</strong></big>', 'krikate')) . '</a></p></div>';
}
add_action('admin_init', 'krikate_notice_dismissed');
function krikate_notice_dismissed()
{
    $user_id = get_current_user_id();
    if (isset($_GET['dismiss']))
        add_user_meta($user_id, 'krikate_notice_dismissed_8', 'true', true);
}
add_action('wp_enqueue_scripts', 'krikate_enqueue');
function krikate_enqueue()
{
    wp_enqueue_style('krikate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
}
add_action('wp_footer', 'krikate_footer');
function krikate_footer()
{
?>
    <script>
        jQuery(document).ready(function($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
                $("html").addClass("mobile");
            }
            if (deviceAgent.match(/(Android)/)) {
                $("html").addClass("android");
                $("html").addClass("mobile");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            } else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
        });
    </script>
<?php
}
add_filter('document_title_separator', 'krikate_document_title_separator');
function krikate_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}
add_filter('the_title', 'krikate_title');
function krikate_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}
function krikate_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}
add_filter('nav_menu_link_attributes', 'krikate_schema_url', 10);
function krikate_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}
if (!function_exists('krikate_wp_body_open')) {
    function krikate_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'krikate_skip_link', 5);
function krikate_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'krikate') . '</a>';
}
add_filter('the_content_more_link', 'krikate_read_more_link');
function krikate_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'krikate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('excerpt_more', 'krikate_excerpt_read_more_link');
function krikate_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'krikate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
// add_filter('intermediate_image_sizes_advanced', 'krikate_image_insert_override');
// function krikate_image_insert_override($sizes)
// {
//     unset($sizes['medium_large']);
//     unset($sizes['1536x1536']);
//     unset($sizes['2048x2048']);
//     return $sizes;
// }
add_action('widgets_init', 'krikate_widgets_init');
function krikate_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'krikate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('wp_head', 'krikate_pingback_header');
function krikate_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('comment_form_before', 'krikate_enqueue_comment_reply_script');
function krikate_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function krikate_custom_pings($comment)
{
?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
<?php
}
add_filter('get_comments_number', 'krikate_comment_count', 0);
function krikate_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}
