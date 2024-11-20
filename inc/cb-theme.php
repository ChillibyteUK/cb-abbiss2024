<?php
defined('ABSPATH') || exit;

// require_once get_theme_file_path('inc/class-bs-collapse-navwalker.php');

require_once CB_THEME_DIR . '/inc/cb-utility.php';
require_once CB_THEME_DIR . '/inc/cb-blocks.php';
require_once CB_THEME_DIR . '/inc/cb-news.php';
// require_once CB_THEME_DIR . '/inc/cb-careers.php';



if (function_exists('acf_add_options_page')) {
    acf_add_options_page(
        array(
            'page_title'     => 'Site-Wide Settings',
            'menu_title'    => 'Site-Wide Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
        )
    );
}

function widgets_init()
{

    register_nav_menus(array(
        'primary_nav_fb' => __('Primary Nav (For Business)', 'cb-abbiss2024'),
        'primary_nav_co' => __('Primary Nav (Corridor)', 'cb-abbiss2024'),
        'footer_menu_fb' => __('Footer (For Business)', 'cb-abbiss2024'),
        'footer_menu_co' => __('Footer (Corridor)', 'cb-abbiss2024'),
    ));

    unregister_sidebar('hero');
    unregister_sidebar('herocanvas');
    unregister_sidebar('statichero');
    unregister_sidebar('left-sidebar');
    unregister_sidebar('right-sidebar');
    unregister_sidebar('footerfull');
    unregister_nav_menu('primary');

    add_theme_support('disable-custom-colors');
    add_theme_support(
        'editor-color-palette',
        array(
            array(
                'name' => 'Grey 500',
                'slug' => 'grey-500',
                'color' => '#eeeeee'
            ),
            array(
                'name' => 'Blue 500',
                'slug' => 'blue-500',
                'color' => '#64a6c3'
            ),
            array(
                'name' => 'Green 600',
                'slug' => 'green-600',
                'color' => '#8db993'
            ),
            array(
                'name' => 'Beige 600',
                'slug' => 'beige-600',
                'color' => '#d5a762'
            )
        )
    );
}
add_action('widgets_init', 'widgets_init', 11);


remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');


//Custom Dashboard Widget
add_action('wp_dashboard_setup', 'register_cb_dashboard_widget');
function register_cb_dashboard_widget()
{
    wp_add_dashboard_widget(
        'cb_dashboard_widget',
        'Chillibyte',
        'cb_dashboard_widget_display'
    );
}

function cb_dashboard_widget_display()
{
?>
    <div style="display: flex; align-items: center; justify-content: space-around;">
        <img style="width: 50%;"
            src="<?= get_stylesheet_directory_uri() . '/img/cb-full.jpg'; ?>">
        <a class="button button-primary" target="_blank" rel="noopener nofollow noreferrer"
            href="mailto:hello@www.chillibyte.co.uk/">Contact</a>
    </div>
    <div>
        <p><strong>Thanks for choosing Chillibyte!</strong></p>
        <hr>
        <p>Got a problem with your site, or want to make some changes & need us to take a look for you?</p>
        <p>Use the link above to get in touch and we'll get back to you ASAP.</p>
    </div>
<?php
}


function cb_theme_enqueue()
{
    $the_theme = wp_get_theme();
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js', array(), null, true);
    wp_enqueue_style('swiper-style', "https://unpkg.com/swiper/swiper-bundle.min.css", array());
    wp_enqueue_script('swiper', "https://unpkg.com/swiper/swiper-bundle.min.js", array(), null, true);
}
add_action('wp_enqueue_scripts', 'cb_theme_enqueue');


// Remove comment-reply.min.js from footer
function remove_comment_reply_header_hook()
{
    wp_deregister_script('comment-reply');
}
add_action('init', 'remove_comment_reply_header_hook');

add_action('admin_menu', 'remove_comments_menu');
function remove_comments_menu()
{
    remove_menu_page('edit-comments.php');
}

add_filter('theme_page_templates', 'child_theme_remove_page_template');
function child_theme_remove_page_template($page_templates)
{
    // unset($page_templates['page-templates/blank.php'],$page_templates['page-templates/empty.php'], $page_templates['page-templates/fullwidthpage.php'], $page_templates['page-templates/left-sidebarpage.php'], $page_templates['page-templates/right-sidebarpage.php'], $page_templates['page-templates/both-sidebarspage.php']);
    unset($page_templates['page-templates/blank.php'], $page_templates['page-templates/empty.php'], $page_templates['page-templates/left-sidebarpage.php'], $page_templates['page-templates/right-sidebarpage.php'], $page_templates['page-templates/both-sidebarspage.php']);
    return $page_templates;
}
add_action('after_setup_theme', 'remove_understrap_post_formats', 11);
function remove_understrap_post_formats()
{
    remove_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));
}


add_filter('wpseo_breadcrumb_links', 'override_yoast_breadcrumb_trail');

function override_yoast_breadcrumb_trail($links)
{
    global $post;

    if (is_singular('people')) {
        $breadcrumb[] = array(
            'url' => '/about-us/',
            'text' => 'About Us',
        );
        $breadcrumb[] = array(
            'url' => '/about-us/our-people/',
            'text' => 'Our Senior People',
        );
        array_splice($links, 1, -2, $breadcrumb);
    }
    if (is_singular('careers')) {
        $breadcrumb[] = array(
            'url' => '/join-us/',
            'text' => 'Join Us',
        );
        $breadcrumb[] = array(
            'url' => '/join-us/join-abbiss-cadres/',
            'text' => 'Join Abbiss Cadres',
        );
        $breadcrumb[] = array(
            'url' => '/join-us/join-abbiss-cadres/careers/',
            'text' => 'Current Vacancies',
        );
        array_splice($links, 1, -2, $breadcrumb);
    }



    if (check_corridor_cookie() == 'Corridor') {
        if (is_singular('post')) {
            $breadcrumb[] = array(
                'url' => '/corridor/',
                'text' => 'CORRIDOR',
            );
            $breadcrumb[] = array(
                'url' => '/corridor/knowledge/',
                'text' => 'Knowledge Hub',
            );
            array_splice($links, 1, -2, $breadcrumb);
            foreach ($links as &$link) {
                if ($link['text'] == 'News') {
                    $link['url'] = '/corridor/knowledge/news/';
                }
            }
        }
        if (is_singular('insights')) {
            $breadcrumb[] = array(
                'url' => '/corridor/',
                'text' => 'CORRIDOR',
            );
            $breadcrumb[] = array(
                'url' => '/corridor/knowledge/',
                'text' => 'Knowledge Hub',
            );
            array_splice($links, 1, -2, $breadcrumb);
            foreach ($links as &$link) {
                if ($link['text'] == 'Insights') {
                    $link['url'] = '/corridor/knowledge/insights/';
                }
            }
        }
        if (is_singular('briefing_notes')) {
            $breadcrumb[] = array(
                'url' => '/corridor/',
                'text' => 'CORRIDOR',
            );
            $breadcrumb[] = array(
                'url' => '/corridor/knowledge/',
                'text' => 'Knowledge Hub',
            );
            $breadcrumb[] = array(
                'url' => '/corridor/knowledge/briefing-notes/',
                'text' => 'Briefing Notes',
            );
            array_splice($links, 1, -2, $breadcrumb);
        }
        if (is_singular('brochures')) {
            $breadcrumb[] = array(
                'url' => '/corridor/',
                'text' => 'CORRIDOR',
            );
            $breadcrumb[] = array(
                'url' => '/corridor/knowledge/',
                'text' => 'Knowledge Hub',
            );
            $breadcrumb[] = array(
                'url' => '/corridor/knowledge/brochures/',
                'text' => 'Brochures',
            );
            array_splice($links, 1, -2, $breadcrumb);
        }
    } else {
        if (is_singular('insights')) {
            $breadcrumb[] = array(
                'url' => '/knowledge/',
                'text' => 'Knowledge Hub',
            );
            $breadcrumb[] = array(
                'url' => '/knowledge/insights/',
                'text' => 'Insights',
            );
            array_splice($links, 1, -2, $breadcrumb);
        }
        if (is_singular('briefing_notes')) {
            $breadcrumb[] = array(
                'url' => '/knowledge/',
                'text' => 'Knowledge Hub',
            );
            $breadcrumb[] = array(
                'url' => '/knowledge/briefing-notes/',
                'text' => 'Briefing Notes',
            );
            array_splice($links, 1, -2, $breadcrumb);
        }
        if (is_singular('brochures')) {
            $breadcrumb[] = array(
                'url' => '/knowledge/',
                'text' => 'Knowledge Hub',
            );
            $breadcrumb[] = array(
                'url' => '/knowledge/brochures/',
                'text' => 'Brochures',
            );
            array_splice($links, 1, -2, $breadcrumb);
        }
    }

    return $links;
}

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $post;
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // Ensure News item doesn't get the current_page_parent class
        if (is_singular('insights') || is_singular('briefing_notes') || is_singular('brochures')) {
            if (trailingslashit($item->url) === trailingslashit(home_url('/knowledge/news/'))) {
                $classes = array_diff($classes, ['current_page_parent']);
            } else {
                $current_url = get_permalink($post->ID);
                $item_url = trailingslashit($item->url);

                // Check if the current post URL starts with the item's URL
                if (strpos(trailingslashit($current_url), $item_url) === 0) {
                    $classes[] = 'current_page_parent';
                }
            }
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Session cookie stuff
function set_corridor_cookie()
{
    if (is_page()) { // only run on pages
        if (strpos($_SERVER['REQUEST_URI'], 'corridor') !== false) {
            setcookie('corridor_flag', 'true', time() + 3600, "/"); // Set for 1 hour
        } else {
            setcookie('corridor_flag', 'false', time() + 3600, "/"); // Set for 1 hour
        }
    }
}

add_action('wp', 'set_corridor_cookie');

function check_corridor_cookie()
{
    if (is_single()) { // Check if the current page is a single post
        if (isset($_COOKIE['corridor_flag']) && $_COOKIE['corridor_flag'] == 'true') {
            // Logic to present different navigation
            return 'Corridor';
        } else {
            // Default navigation
            return 'Default';
        }
    }
}

// Insights Authors
// Add the author column to the list table
function add_insights_author_column($columns)
{
    $columns['author'] = __('Author');
    return $columns;
}
add_filter('manage_insights_posts_columns', 'add_insights_author_column');

// Display the author name in the column
function display_insights_author_column($column, $post_id)
{
    if ($column === 'author') {
        $author_id = get_post_field('post_author', $post_id);
        $author = get_the_author_meta('display_name', $author_id);
        echo esc_html($author);
    }
}
add_action('manage_insights_posts_custom_column', 'display_insights_author_column', 10, 2);

// Make the author column sortable
function make_insights_author_column_sortable($columns)
{
    $columns['author'] = 'author';
    return $columns;
}
add_filter('manage_edit-insights_sortable_columns', 'make_insights_author_column_sortable');

// Modify the query to sort by author
function sort_insights_by_author($query)
{
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'author') {
        $query->set('orderby', 'author');
    }
}
add_action('pre_get_posts', 'sort_insights_by_author');

// Make the author column sortable
function make_post_author_column_sortable($columns)
{
    $columns['author'] = 'author';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'make_post_author_column_sortable');

// Modify the query to sort by author
function sort_posts_by_author($query)
{
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'author') {
        $query->set('orderby', 'author');
    }
}
add_action('pre_get_posts', 'sort_posts_by_author');

// AC Contact Us
add_filter('gform_field_validation_9_3', 'custom_email_domain_validation', 10, 4);
// Corridor Contact Form
add_filter('gform_field_validation_10_3', 'custom_email_domain_validation', 10, 4);
// Newsletter Form (CTA)
add_filter('gform_field_validation_12_1', 'custom_email_domain_validation', 10, 4);
// Newsletter Form (Footer)
add_filter('gform_field_validation_4_1', 'custom_email_domain_validation', 10, 4);

function custom_email_domain_validation($result, $value, $form, $field)
{
    // domains to reject
    $rejected_domains = array('gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'icloud.com', 'aol.com', 'protonmail.com', 'zoho.com', 'btinternet.com', 'virginmedia.com', 'sky.com', 'talktalk.net', 'blueyonder.co.uk', 'ntlworld.com', 'gmx.co.uk', 'me.com', 'plus.com', 'hotmail.co.uk', 'live.co.uk', 'wanadoo.co.uk');

    $email_parts = explode('@', $value);
    $submitted_domain = array_pop($email_parts);
    // Check if the domain is in the list of rejected domains
    if (in_array(strtolower($submitted_domain), $rejected_domains)) {
        $result['is_valid'] = false;
        $result['message'] = 'Email addresses from ' . $submitted_domain . ' are not allowed. Please use a different email address.';
    }
    return $result;
}
?>