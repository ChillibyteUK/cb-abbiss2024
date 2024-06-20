<?php
$page = is_front_page() ? 'front-hero' : 'page-hero';
$class = $block['className'] ?? 'mb-4';
?>
<section
    class="hero <?=$page?> <?=$class?>">
    <?=wp_get_attachment_image(get_field('background'), 'full', false, array('class' => 'hero__bg', 'alt' => get_the_title()))?>
    <div class="overlay"></div>
    <div class="container-xl hero__inner">
        <?php
        if (get_field('icon') ?? null) {
            ?>
        <img src="<?=get_field('icon')?>"
            class="hero__icon" alt="<?=get_the_title()?>">
        <?php
        }
if (get_field('content') ?? null) {
    ?>
        <h1 class="hero__content">
            <?=get_field('content')?>
        </h1>
        <?php
}
?>
    </div>
</section>
<?php
if (!is_front_page()) {
    ?>
<section class="breadcrumbs mb-4">
    <div class="container-xl">
        <?php
        if (function_exists('yoast_breadcrumb')) {
            // yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            yoast_breadcrumb();
        }
    ?>
    </div>
</section>
<?php
}
?>