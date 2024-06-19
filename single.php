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
            $menu_id = 'Knowledge Hub';
    $menu = wp_get_nav_menu_object($menu_id);

    if ($menu_id) {
        if ($menu->name === 'CORRIDOR') {
            ?>
                        <img src="<?=get_stylesheet_directory_uri()?>/img/icon-corridor-full.svg"
                            class="w-75 mb-4" alt="CORRIDOR">
                        <?php
        } else {
            ?>
                        <div class="h3"><?=$menu->name?></div>
                        <?php
        }
        wp_nav_menu(array('menu' => $menu));
    }
    ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <?php
        // if ($corridor != '') {
        //     echo post_navigation($type, 'corridor');
        // } else {
        //     echo post_navigation($type);
        // }
    ?>
                    <div class="border-top py-4">
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
                            </div><!-- .entry-meta -->
                        </div><!-- .entry-header -->
                        <div class="entry-footer border-top py-4">
                            <h3 class="h3 pb-2">The author</h3>
                            <div class="container">
                                <div class="row <?=$bg?> p-4">
                                    <div class="col-lg-2 mx-auto">
                                        <?php
                                        $user_id = get_the_author_meta('ID');
    $author_image = get_field('photo', 'user_'.$user_id);
    echo '<img src="' . esc_url($author_image['url']) . '" class="rounded-circle img-fluid"/>'; ?>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="h100 pb-2 border-bottom border-secondary">
                                                    <?=get_the_author_meta('first_name')?>
                                                    <?=get_the_author_meta('last_name')?>
                                                    <br />
                                                    <?=get_field('job_title', 'user_'.$user_id)?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div
                                                    class="text-right pb-2 author-icons h-100 border-bottom border-secondary">
                                                    <?php
                            if (get_the_author_meta('linkedin')) {
                                ?>
                                                    <a href="<?=get_the_author_meta('linkedin')?>"
                                                        target="_blank"><span class="fa-stack fa-2x"><i
                                                                class="fa fa-circle fa-stack-2x text-white"></i><i
                                                                class="fa fa-linkedin fa-stack-1x text-primary"></i></span></a>
                                                    <?php
                            }
    if (get_the_author_meta('twitter')) {
        ?>
                                                    <a href="https://twitter.com/<?=get_the_author_meta('twitter')?>"
                                                        target="_blank"><span class="fa-stack fa-2x"><i
                                                                class="fa fa-circle fa-stack-2x text-white"></i><i
                                                                class="fa fa-twitter fa-stack-1x text-primary"></i></span></a>
                                                    <?php
    }
    ?>
                                                    <a
                                                        href="mailto:<?=get_the_author_meta('user_email')?>"><span
                                                            class="fa-stack fa-2x"><i
                                                                class="fa fa-circle fa-stack-2x text-white"></i><i
                                                                class="fa fa-envelope-open-o fa-stack-1x text-primary"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <?php
                        if (have_rows('specialisms', 'user_'.$user_id)) {
                            while (have_rows('specialisms', 'user_'.$user_id)) {
                                the_row(); ?>
                                                <div class="border-bottom border-secondary py-2">
                                                    <?=get_sub_field('specialism')?>
                                                </div><?php
                            }
                        } ?>
                                            </div>
                                            <div class="col-lg-6 py-2">
                                                D:
                                                <?=get_field('direct_dial_phone', 'user_'.$user_id)?><br />
                                                T:
                                                <?=get_field('switchboard', 'user_'.$user_id)?><br />
                                                F:
                                                <?=get_field('fax_number', 'user_'.$user_id)?><br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .entry-footer -->
                    </article><!-- #post-## -->
                    <section class="border-top py-4">

                        <h3 class="h3 pb-2">Also by the author</h3>
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
                                <div
                                    class="<?=$bg?> mb-4 preview-container">
                                    <div class="row preview-title-container">
                                        <div class="col-6">
                                            <?=$post_type == 'post' ? 'N' : 'I'?>
                                        </div>
                                        <div class="col-6 text-right font-small">
                                            <?=get_the_date('', $authors_post)?>
                                        </div>
                                    </div>
                                    <div class="row preview-content-container">
                                        <div class="font-weight-bold font-large">
                                            <?=$authors_post->post_title?>
                                        </div>
                                    </div>
                                    <div class="preview-overlay-link">
                                        <a
                                            href="<?=get_the_permalink($authors_post->ID)?>"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- TODO: AUTHOR ARCHIVE a href="<?=get_author_posts_url($user_id)?>">VIEW
                        ALL</a-->
                        <?php
    }
    ?>
                    </section>
                    <div class="py-4">
                        <?php /* post_navigation($type) */ ?>
                    </div>
                    <?php
                            get_template_part('page-templates/blocks/cb_subscribe_cta');
    ?>
</main><!-- #main -->
</div><!-- .col main -->
</div><!-- .row -->
</div><!-- .container -->
</div><!-- #single-wrapper -->
</article>
</main>
<?php } // end of the loop.?>
<?php get_footer();
?>