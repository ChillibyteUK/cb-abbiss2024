<?php
$class = $block['className'] ?? 'pb-5';

$linkLeft = get_field('link_left');
$bgLeft = get_field('bg_left');

$linkRight = get_field('link_right');
$bgRight = get_field('bg_right');
?>
<section class="double_colour_cta <?=$class?>">
    <div class="container-xl double_colour_cta__grid">
        <a href="<?=$linkLeft['url']?>" class="double_colour_cta__card bg-<?=$bgLeft?>">
            <div class="overlay"></div>
            <h3 class="h4"><?=get_field('title_left')?></h3>
            <p><?=get_field('content_left')?></p>
            <div class="button button-black button-sm"><?=$linkLeft['title']?></div>
        </a>
        <a href="<?=$linkRight['url']?>" class="double_colour_cta__card bg-<?=$bgRight?>">
            <div class="overlay"></div>
            <h3 class="h4"><?=get_field('title_right')?></h3>
            <p><?=get_field('content_right')?></p>
            <div class="button button-black button-sm"><?=$linkRight['title']?></div>
        </a>
    </div>
</section>