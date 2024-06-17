<?php
/*
Template Name: Sidebar Page
*/

// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
?>
<main id="main">
    <?php
    $content = get_the_content();
$blocks = parse_blocks($content);

foreach ($blocks as $block) {
    if ($block['blockName'] == 'acf/cb-hero') {
        echo wp_kses_post(render_block($block));
    }
}
?>
    <div class="container-xl">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar_menu">
                    <?php
            $menu_id = get_field('sidebar_menu');
$menu = wp_get_nav_menu_object($menu_id);
if ($menu_id) {
    ?>
                    <div class="h3"><?=$menu->name?></div>
                    <?php
    wp_nav_menu(array('menu' => $menu_id));
}
?>
                </div>
            </div>
            <div class=" col-md-9">
                <?php
        foreach ($blocks as $block) {
            if (isset($block['attrs']['data']['breakout']) && !empty($block['attrs']['data']['breakout'])) {
                continue;
            }
            if ($block['blockName'] != 'acf/cb-hero') {
                echo apply_filters('the_content', render_block($block));
            }
        }
?>
            </div>
        </div>
        <?php
        foreach ($blocks as $block) {
            if (isset($block['attrs']['data']['breakout']) && $block['attrs']['data']['breakout'][0] === 'Yes') {
                echo render_block($block);
            }
        }
?>
    </div>
</main>
<?php
get_footer();
?>