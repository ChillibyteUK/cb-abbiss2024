<?php
$class = $block['className'] ?? 'py-5';
?>
<section class="two_col_lined <?=$class?>">
    <div class="container-xl two_col_lined__grid">
        <?php
        while (have_rows('content')) {
            the_row();
            ?>
        <div class="two_col_lined__card">
            <h2 class="h4">
                <?=get_sub_field('title')?>
            </h2>
            <div><?=get_sub_field('content')?>
            </div>
        </div>
        <?php
        }
?>
    </div>
</section>