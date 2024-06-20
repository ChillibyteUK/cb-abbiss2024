<?php
/**
 * The template for displaying all single posts
 *
 * @package cb-abbiss
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$icon = '';
$bg = '';
$type = '';
if ('post' == get_post_type()) {
    $icon = 'icon-news.svg';
    $bg = 'bg-beige-400';
    $type = 'news';
} elseif ('insights' == get_post_type()) {
    $icon = 'icon-insights.svg';
    $bg = 'bg-blue-400';
    $type = 'insights';
} elseif ('case_studies' == get_post_type()) {
    $icon = 'icon-globe-dark.svg';
    $bg = 'case-bg';
    $type = 'case-study';
} else {
    $icon = 'icon-news.svg';
    $bg = 'bg-beige-400';
    $type = 'news';
}


while (have_posts()) {
    the_post();
    $corridor = has_term('corridor', 'section') ? '/corridor' : '';
    ?>
<main>
    <article>
        <section class="single-hero mb-4 <?=$bg?>">
            <div class="container-xl pb-4">
                <div class="row">
                    <div class="d-none d-lg-block col-lg-4 col-xl-3 p-4 my-auto">
                        <img src="<?=get_stylesheet_directory_uri()?>/img/<?=$icon?>"
                            class="single-hero__icon">
                    </div>
                    <div class="col-lg-8 col-xl-9 my-auto">
                        <h1 class="h2"><?=get_the_title()?></h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="breadcrumbs mb-4">
            <div class="container-xl">
                <?php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb();
        }
    ?>
            </div>
        </section>
        <div class="container-xl">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar_menu">
                        <?php
                        if (check_corridor_cookie() == 'Corridor') {
                            $menu_id = 'Corridor Knowledge Hub';
                            ?>
                        <img src="<?=get_stylesheet_directory_uri()?>/img/icon-corridor-full.svg"
                            class="w-75 mb-4" alt="CORRIDOR">
                        <div class="h3">Knowledge Hub</div>
                        <?php
                        } else {
                            $menu_id = 'Knowledge Hub';
                            ?>
                        <div class="h3">Knowledge Hub</div>
                        <?php
                        }
    $menu = wp_get_nav_menu_object($menu_id);

    wp_nav_menu(array('menu' => $menu, 'walker' => new Custom_Walker_Nav_Menu() ));
    ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="border-top mt-4 py-4">
                        <?=get_the_date()?> |
                        <?=get_the_author_meta('first_name')?>
                        <?=get_the_author_meta('last_name')?>
                    </div>
                    <article <?php post_class(); ?>
                        id="post-<?php the_ID(); ?>">
                        <?php
        if (get_the_post_thumbnail($post->ID, 'large')) {
            echo '<div class="mb-4">';
            echo get_the_post_thumbnail($post->ID, 'large');
            echo '</div>';
        }
    ?>
                        <div class="entry-content">
                            <?php the_content(); ?>
                            <?php
        if (get_field('faq_page')) {
            echo '<div itemscope="" itemtype="https://schema.org/FAQPage">';
            while (have_rows('faq_page')) {
                the_row();
                echo '<div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question">';
                echo '  <h2 class="h2" itemprop="name">' . get_sub_field('question') . '</h2>';
                echo '  <div itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><div itemprop="text">' . apply_filters('the_content', get_sub_field('answer')) . '</div></div>';
                echo '</div>';
            }
            echo '</div>';
        }
    ?>
                        </div><!-- .entry-content -->
                        <div class="entry-header border-top mb-4 pt-4" style="font-size: 1rem;">
                            <?php the_field("post_disclaimer", "option"); ?>
                        </div>
                        <div class="entry-header border-top mb-4">
                            <div class="entry-meta py-4">
                                <?php
        $terms = get_the_category(get_the_ID());
    if ($terms) {
        echo '<span class="categories">';
        $prefix = '';
        foreach ($terms as $term) {
            $term_link = get_term_link($term);
            if (is_wp_error($term_link)) {
                continue;
            }
            echo $prefix . '<a href="' . $term_link . '">' . $term->name . '</a>';
            $prefix = ', ';
        }
        echo '</span>';
    }
    ?>
                            </div>
                        </div>
                        <h3 class="pb-2">The author</h3>
                        <div class="single_people__summary mb-5">
                            <?php
                            $user_id = get_the_author_meta('ID');
    $author_name = get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');
    $author_image = get_field('photo', 'user_' . $user_id);
    echo '<img src="' . esc_url($author_image['url']) . '" class="single_people__image" alt="' . $author_name . '">';
    ?>
                            <div class="single_people__name">
                                <div class="h4 mb-1">
                                    <?=$author_name?>
                                </div>
                                <?=get_field('job_title', 'user_'.$user_id)?>
                            </div>
                            <div class="single_people__links">
                                <?php
                    $contact = get_field('contact_details');
    if (get_the_author_meta('linkedin', $user_id) != '') {

        ?>
                                <a href="<?=get_the_author_meta('linkedin', $user_id)?>"
                                    target="_blank"><span class="fa-stack fa-2x"><i
                                            class="fa fa-circle fa-stack-2x text-white"></i><i
                                            class="fa-brands fa-linkedin-in fa-stack-1x"></i></span></a>
                                <?php
    }
    if (get_the_author_meta('twitter', $user_id) != '') {
        ?>
                                <a href="https://twitter.com/<?=get_the_author_meta('twitter', $user_id)?>"
                                    target="_blank"><span class="fa-stack fa-2x"><i
                                            class="fa fa-circle fa-stack-2x text-white"></i><i
                                            class="fa-brands fa-x-twitter fa-stack-1x"></i></span></a>
                                <?php
    }
    if (get_the_author_meta('user_email') != '') {
        ?>
                                <a
                                    href="mailto:<?=get_the_author_meta('user_email', $user_id)?>"><span
                                        class="fa-stack fa-2x"><i class="fa fa-circle fa-stack-2x text-white"></i><i
                                            class="fa-regular fa-envelope-open fa-stack-1x"></i></span></a>
                                <?php
    }
    ?>
                            </div>
                            <div class="single_people__specialisms">
                                <?php
                        if (have_rows('specialisms', 'user_' . $user_id)) {
                            ?>
                                <ul class="single_people__list">
                                    <?php
                            while (have_rows('specialisms', 'user_' . $user_id)) {
                                the_row(); ?>
                                    <li><?=get_sub_field('specialism')?>
                                    </li>
                                    <?php
                            }
                        }
    ?>
                            </div>
                            <div class="single_people__contact">
                                <?php
                                if (get_field('direct_dial_phone', 'user_'.$user_id)) {
                                    ?>
                                <div><span>D:</span>
                                    <a
                                        href="tel:<?=parse_phone(get_field('direct_dial_phone', 'user_'.$user_id))?>"><?=get_field('direct_dial_phone', 'user_'.$user_id)?></a>
                                </div>
                                <?php
                                }
    if (get_field('switchboard', 'user_'.$user_id)) {
        ?>
                                <div><span>T:</span>
                                    <a
                                        href="tel:<?=parse_phone(get_field('switchboard', 'user_'.$user_id))?>"><?=get_field('switchboard', 'user_'.$user_id)?></a>
                                </div>
                                <?php
    }
    if (get_field('fax_number', 'user_'.$user_id)) {
        ?>
                                <div><span>F:</span>
                                    <?=get_field('fax_number', 'user_'.$user_id)?>
                                </div>
                                <?php
    }
    ?>
                            </div>
                        </div>
                    </article>
                    <section class="border-top py-4 also_by">

                        <h2 class="h3 pb-2">Also by
                            <?=$author_name?>
                        </h2>
                        <div class="row">
                            <?php
            $authors_posts = get_posts(array(  'post_type' => array('post','insights'), 'author' => $user_id, 'post__not_in' => array( $post->ID ), 'posts_per_page' => 3 ));
    foreach ($authors_posts as $authors_post) {
        if ($authors_post->post_type == 'post') {
            $icon = 'icon-news.svg';
            $bg = 'bg-beige-400';
            $post_type = 'news';
        }
        if ($authors_post->post_type == 'insights') {
            $icon = 'icon-insights.svg';
            $bg = 'bg-blue-400';
            $post_type = 'insights';
        } ?>
                            <div class="col-xl-4">
                                <a class="<?=$bg?> also_by__card"
                                    href="<?=get_the_permalink($authors_post->ID)?>">
                                    <div class="overlay"></div>
                                    <div class="also_by__icon">
                                        <img src="<?=get_stylesheet_directory_uri()?>/img/<?=$icon?>"
                                            alt="">
                                    </div>
                                    <div class="also_by__date">
                                        <?=get_the_date('', $authors_post)?>
                                    </div>
                                    <h3 class="also_by__content">
                                        <?=$authors_post->post_title?>
                                    </h3>
                                </a>
                            </div>
                            <?php
    }
    ?>
                        </div>
                    </section>
                    <?php
                            get_template_part('page-templates/blocks/cb_subscribe_cta');
    ?>
    </article>
</main>
<?php } // end of the loop.?>
<?php get_footer();
?>