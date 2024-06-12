<?php
$colour = get_field('colour') ?: 'white';
$class = $block['className'] ?? 'py-5';

switch (get_field('split')) {
    case 4060:
        $colText = 'col-md-4';
        $colImage = 'col-md-8';
        break;
    case 6040:
        $colText = 'col-md-8';
        $colImage = 'col-md-4';
        break;
    case 7030:
        $colText = 'col-md-9';
        $colImage = 'col-md-3';
        break;
    default:
        $colText = 'col-md-6';
        $colImage = 'col-md-6';
}

$orderText = get_field('order') == 'text image' ? 'order-2 order-md-1' : 'order-2 order-md-2';
$orderImage = get_field('order') == 'text image' ? 'order-1 order-md-2' : 'order-1 order-md-1';

if (isset($block['anchor'])) {
    echo '<a id="' . esc_attr($block['anchor']) . '" class="anchor"></a>';
}

?>
<section
    class="text_image bg-<?=$colour?> <?=$class?>">
    <div class="container-xl">
        <div class="row g-5">
            <div
                class="<?=$colText?> <?=$orderText?> d-flex flex-column justify-content-center">
                <h2>
                    <?=get_field('title')?>
                </h2>
                <div class="fs-600">
                    <?=get_field('content')?>
                </div>
            </div>
            <div
                class="<?=$colImage?> <?=$orderImage?> d-flex justify-content-center align-items-center">
                <img src="<?=wp_get_attachment_image_url(get_field('image'), 'large')?>"
                    alt="">
            </div>
        </div>
    </div>
</section>