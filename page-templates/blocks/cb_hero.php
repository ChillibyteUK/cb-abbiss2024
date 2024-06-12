<?php
$class = is_front_page() ? 'front-hero' : 'page-hero';
?>
<section class="hero <?=$class?>">
    <?=wp_get_attachment_image(get_field('background'), 'full', false, array('class' => 'hero__bg'))?>
    <div class="container-xl hero__inner">
        <img src="<?=get_field('icon')?>"
            class="hero__icon">
        <div class="hero__content">
            <?=get_field('content')?>
        </div>
    </div>
</section>