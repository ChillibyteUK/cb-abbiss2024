<?php
$colour = get_field('colour') ?: 'white';
$class = $block['className'] ?? 'py-5';

$orderText = get_field('order') == 'text image' ? 'order-2 order-md-1' : 'order-2 order-md-2';
$orderImage = get_field('order') == 'text image' ? 'order-1 order-md-2' : 'order-1 order-md-1';

if (isset($block['anchor'])) {
    echo '<a id="' . esc_attr($block['anchor']) . '" class="anchor"></a>';
}

?>
<section class="focus_panel <?=$class?>">
    <div class="container-xl p-5 bg-<?=$colour?>">
        <div class="row gy-4">
            <div
                class="col-md-6 <?=$orderText?> d-flex flex-column justify-content-center align-items-start">
                <?php
                if (get_field('icon') ?? null) {
                    ?>
                <img src="<?=get_field('icon')?>"
                    alt="" class="mb-4 focus_panel__icon">
                <?php
                }
?>
                <h2 class="h3">
                    <?=get_field('title')?>
                </h2>
                <div class="fs-600 mb-4">
                    <?=get_field('content')?>
                </div>
                <?php
                if (get_field('cta') ?? null) {
                    $l = get_field('cta');
                    ?>
                <a href="<?=$l['url']?>"
                    target="<?=$l['target']?>"
                    class="button button-black button-sm"><?=$l['title']?></a>
                <?php
                }
?>
            </div>
            <div
                class="col-md-6 <?=$orderImage?> d-flex justify-content-center align-items-center">
                <img src="<?=wp_get_attachment_image_url(get_field('image'), 'large')?>"
                    alt="">
            </div>
        </div>
    </div>
</section>