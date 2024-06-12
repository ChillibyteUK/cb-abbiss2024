<section class="image_icon_cta">
    <?=wp_get_attachment_image(get_field('background'), 'full', false, array('class' => 'image_icon_cta__bg'))?>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 col-lg-4 image_icon_cta__inner">
                <?php
                if (get_field('icon') ?? null) {
                    ?>
                <img src="<?=get_field('icon')?>"
                    alt="" class="mb-4 d-none d-md-block">
                <?php
                }
    if (get_field('title') ?? null) {
        ?>
                <h2 class="h3">
                    <?=get_field('title')?>
                </h2>
                <?php
    }
    ?>
                <div class="mb-4">
                    <?=get_field('content')?>
                </div>
                <?php
    if (get_field('cta') ?? null) {
        $l = get_field('cta');
        ?>
                <a href="<?=$l['url']?>"
                    target="<?=$l['target']?>"
                    class="button button-white button-sm"><?=$l['title']?></a>
                <?php
    }
    ?>
            </div>
        </div>
    </div>
</section>