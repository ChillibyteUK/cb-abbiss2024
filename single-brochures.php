<?php
/**
 * The template for displaying all single posts
 *
 * @package cb-abbiss
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$icon = 'icon-insights.svg';
$bg = 'bg-beige-400';


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
                    <article <?php post_class(); ?>
                        id="post-<?php the_ID(); ?>">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                        <?php
                        $pdf = get_field('pdf_file');
                        $url = $pdf['url'];
                        $filename = $pdf['filename'];
                        ?>
                        <a class="dl_panel dl_panel--brochures" href="<?=$url?>" download>
                            <div class="overlay"></div>
                            <div class="dl_panel__image">
                                <?=wp_get_attachment_image($pdf['ID'], array(140,200), false, array('class' => 'dl_panel__thumb'))?>
                            </div>
                            <div class="dl_panel__inner">
                                <h2><?=get_the_title()?></h2>
                                <p>Download here</p>
                            </div>
                        </a>
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
                                <span type="button" data-bs-toggle="modal" data-bs-target="#modal"><span
                                        class="fa-stack fa-2x"><i class="fa fa-circle fa-stack-2x text-white"></i><i
                                            class="fa-regular fa-envelope-open fa-stack-1x"></i></span></span>
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
                    <?php
    get_template_part('page-templates/blocks/cb_subscribe_cta');
    ?>
    </article>
</main>
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="h5 modal-title" id="modalLabel">Contact
                    <?=$author_name?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?=do_shortcode('[gravityform id="8" title="false" description="false" ajax="true" field_values="email=' . get_the_author_meta('user_email') . '"]')?>
            </div>
        </div>
    </div>
</div>
<?php } // end of the loop.?>
<?php get_footer();
?>