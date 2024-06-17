<?php
$class = $block['className'] ?? 'pt-5';
?>
<section class="faqs <?=$class?>">
    <div class="container-xl">
        <?php
        if (get_field('title') ?? null) {
            ?>
        <h2><?=get_field('title')?></h2>
        <?php
        }
echo '<div itemscope="" itemtype="https://schema.org/FAQPage" id="accordion">';
$counter = 0;
$show = 'show';
$collapsed = '';
while (have_rows('faqs')) {
    the_row();
    $border = $counter == 0 ? 'border-top' : '';
    echo '<div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="py-4 border-bottom ' . $border . '">';
    echo '  <div class="question h4 ' . $collapsed . '" itemprop="name" data-bs-toggle="collapse" id="heading_' . $counter . '" data-bs-target="#collapse_' . $counter . '" aria-expanded="true" aria-controls="collapse_' . $counter . '">' . get_sub_field('question') . '</div>';
    echo '  <div class="answer collapse ' . $show . '" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" id="collapse_' . $counter . '" aria-labelledby="heading_' . $counter . '" data-bs-parent="#accordion"><div class="pt-3" itemprop="text">' . apply_filters('the_content', get_sub_field('answer')) . '</div></div>';
    echo '</div>';
    $counter++;
    $show = '';
    $collapsed = 'collapsed';
}
echo '</div>';
?>
    </div>
</section>