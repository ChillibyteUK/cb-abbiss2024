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
                SIDEBAR
            </div>
            <div class="col-md-9">
                <?php
        foreach ($blocks as $block) {
            if ($block['blockName'] != 'acf/cb-hero') {
                echo render_block($block);
            }
        }
?>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
?>