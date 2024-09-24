<?php
$class = $block['className'] ?? 'py-5';
?>
<section class="download_cards <?=$class?>">
    <div class="container-xl">
        <div class="download_cards__grid">
            <?php
        while (have_rows('cards')) {
            the_row();
            $url = wp_get_attachment_url(get_sub_field('file'));
            ?>
            <a class="download_cards__card" href="<?=$url?>">
                <div class="download_cards__title">
                    <?=get_sub_field('card_title')?>
                </div>
                <div class="download_cards__image">
                    <div class="overlay"></div>
                    <?=wp_get_attachment_image(get_sub_field('file'), 'thumbnail', false, array('alt' => 'document thumbnail'))?>
                </div>
                <div class="download_cards__content">
                    <?=get_sub_field('content')?>
                </div>
                <div class="download_cards__link">
                    <?=get_sub_field('link_title')?>
                </div>
            </a>
            <?php
        }
?>
        </div>
    </div>
</section>