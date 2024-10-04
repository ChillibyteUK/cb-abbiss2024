<?php
$class = $block['className'] ?? 'pb-5';
$l = get_field('link') ?? null;
if (is_array($l) && isset($l['url'])) {
    $link =  $l['url'];
    $target = $l['target'];
    $warn = '';
}
else {
    $link = null;
    $target = null;
    echo '<!-- NO CTA LINK -->';
    $warn = 'border border-danger';
}
$bg = get_field('background') ?: 'grey-500';
$text = $bg != '' ? 'text-white' : '';
$text = $bg == 'grey-500' ? '' : $text;
?>
<section class="colour_cta <?=$class?>">
    <div class="container-xl <?=$warn?>">
        <a href="<?=$link?>"
            target="<?=$target?>"
            class="colour_cta__card bg-<?=$bg?> <?=$text?>">
            <div class="overlay"></div>
            <div class="colour_cta__inner">
                <h2>
                    <?=get_field('title')?>
                </h2>
                <div><?=get_field('content')?>
                </div>
            </div>
        </a>
    </div>
</section>