<?php
/**
 *  Rename posts to news
 */
// Function to change "posts" to "news" in the admin side menu
function change_post_menu_label()
{
    global $menu;
    global $submenu;
    $menu[5][0] = 'News Articles';
    $submenu['edit.php'][5][0] = 'News Articles';
    $submenu['edit.php'][10][0] = 'Add News Article';
    $submenu['edit.php'][16][0] = 'Tags';
    echo '';
}
add_action('admin_menu', 'change_post_menu_label');
// Function to change post object labels to "news"
function change_post_object_label()
{
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News Articles';
    $labels->singular_name = 'News Article';
    $labels->add_new = 'Add News Article';
    $labels->add_new_item = 'Add News Article';
    $labels->edit_item = 'Edit News Article';
    $labels->new_item = 'News Article';
    $labels->view_item = 'View News Article';
    $labels->search_items = 'Search News Articles';
    $labels->not_found = 'No News Articles found';
    $labels->not_found_in_trash = 'No News Articles found in Trash';
}
add_action('init', 'change_post_object_label');

function replace_admin_menu_icons_css()
{
    ?>
<style>
    #adminmenu #menu-posts .dashicons-admin-post:before {
        content: '';
        background-image: url('/wp-content/themes/cb-abbiss2024/img/icon-news.png');
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.8;
    }

    #adminmenu #menu-posts .wp-menu-open .dashicons-admin-post:before {
        opacity: 1;
    }
</style>
<?php
}

add_action('admin_head', 'replace_admin_menu_icons_css');

function oldest_post()
{
    global $wpdb;
    $oldest_post = $wpdb->get_row("SELECT post_date FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date ASC");
    $post_year = preg_replace('/-.*$/', '', $oldest_post->post_date);
    return $post_year;
}

function oldest_insight()
{
    global $wpdb;
    $oldest_post = $wpdb->get_row("SELECT post_date FROM {$wpdb->posts} WHERE post_type = 'insights' AND post_status = 'publish' ORDER BY post_date ASC");
    $post_year = preg_replace('/-.*$/', '', $oldest_post->post_date);
    return $post_year;
}

function option_months($curr='')
{
    $months = array(
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );

    ob_start();
    $curr_mon = date('m');

    foreach ($months as $m => $mon) {
        $selected = '';
        if ($curr != '') {
            if ($m == $curr_mon) {
                $selected = 'selected';
            }
        }
        echo '<option value="' . $m . '" ' . $selected . '>' . $mon . '</option>';
    }

    $ob_str = ob_get_contents();
    ob_end_clean();
    return $ob_str;
}

function get_all_authors()
{
    global $wpdb;

    foreach ($wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql('post') . " GROUP BY post_author") as $row) {
        $author = get_userdata($row->post_author);
        $authors[$row->post_author]['id'] = $author->ID;
        $authors[$row->post_author]['name'] = $author->display_name;
        $authors[$row->post_author]['post_count'] = $row->count;
        $authors[$row->post_author]['posts_url'] = get_author_posts_url($author->ID, $author->user_nicename);
    }

    return $authors;
}

add_action('wp_ajax_newsfilter', 'filter_function'); // wp_ajax_{ACTION HERE}
add_action('wp_ajax_nopriv_newsfilter', 'filter_function');

function filter_function()
{

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // die();
    $post_type = $_POST['post_type'];
    // echo "<strong>TYPE: " . $post_type . "</strong>";
    $post_name = ($post_type == 'post') ? 'news' : $post_type;
    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'orderby' => 'date', // we will sort posts by date
        'order'	=> 'DESC', // ASC or DESC
        'posts_per_page' => -1,
    );

    $instring = array();
 
    // for taxonomies / categories
    if (isset($_POST['categoryfilter']) && $_POST['categoryfilter'] != '') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $_POST['categoryfilter']
            )
        );
        $instring[] = 'categorised as <strong>' . get_cat_name($_POST['categoryfilter']) . '</strong>';
    }

    if (isset($_POST['authorfilter']) && $_POST['authorfilter'] != '') {
        $args['author'] = $_POST['authorfilter'];
        $instring[] = 'by <strong>' . get_the_author_meta('display_name', $_POST['authorfilter']) . '</strong>';
    }
    
    if (isset($_POST['keyword']) && $_POST['keyword'] !== '') {
        $args['s'] = $_POST['keyword'];
        $instring[] = 'containing <em>' . $_POST['keyword'] . '</em>';
    }

    $args['date_query'] = array(
            array(
            'after'     => array(
                'year'  => $_POST['datefromyear'],
                'month' => $_POST['datefrommonth']
            ),
            'before'    => array(
                'year'  => $_POST['datetoyear'],
                'month' => $_POST['datetomonth']
            ),
            'inclusive' => true,
        ),
    );
    $instring[] = 'published between ' . $_POST['datefrommonth'] . '/' . $_POST['datefromyear'] . ' and ' . $_POST['datetomonth'] . '/' . $_POST['datetoyear'];

    // echo '<pre>';
    // print_r($args);
    // echo '</pre>';

    $query = new WP_Query($args);
 
 
    $details = implode(', ', $instring);
    echo '<div class="small py-4">' . $query->found_posts . ' of ' . wp_count_posts($post_type)->publish . ' posts ' . $details . '</div>';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
<a class="post__card" href="<?=get_the_permalink()?>">
    <div class="post__type">
        <div class="post__icon bg-beige-400">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-news.svg"
                alt="">
        </div>
    </div>
    <div class="post__detail">
        <div class="small">
            <?=get_the_date()?>
        </div>
        <div class="font-weight-bold py-2">
            <?=get_the_title()?>
        </div>
        <div>
            <?=wp_trim_words(get_the_content(), 30)?>
        </div>
    </div>
</a>
<?php
        }
        wp_reset_postdata();
    } else {
        echo 'No posts found';
    }
 
    die();
}

add_action('wp_ajax_catfilter', 'catfilter_function'); // wp_ajax_{ACTION HERE}
add_action('wp_ajax_nopriv_catfilter', 'catfilter_function');
function catfilter_function()
{
 
    $args = array(
        'post_status' => 'publish',
        'orderby' => 'date', // we will sort posts by date
        'order'	=> 'DESC', // ASC or DESC
        'posts_per_page' => -1,
    );
 
    // for taxonomies / categories
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $_POST['catid']
        )
    );

    $query = new WP_Query($args);
 
    if ($query->have_posts()) {
        echo '<div class="small py-4">' . $query->found_posts . ' of ' . wp_count_posts()->publish . ' posts in ' . get_cat_name($_POST['catid']) . '</div>';
        while ($query->have_posts()) {
            $query->the_post(); ?>
<a class="post__card" href="<?=get_the_permalink()?>">
    <div class="post__type">
        <div class="post__icon bg-beige-400">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-news.svg"
                alt="">
        </div>
    </div>
    <div class="post__detail">
        <div class="small">
            <?=get_the_date()?>
        </div>
        <div class="font-weight-bold py-2">
            <?=get_the_title()?>
        </div>
        <div>
            <?=wp_trim_words(get_the_content(), 30)?>
        </div>
    </div>
</a><?php
        }
        wp_reset_postdata();
    } else {
        echo 'No posts found';
    }


    die();
}
?>