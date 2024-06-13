<?php
$class = $block['className'] ?? 'py-5';
$bg = get_field('grey_bg') ? 'bg-grey-500' : '';
$style = (get_field('compact')[0] ?? null) === 'Yes' ? 'solutions_nav__compact' : '';

?>
<section
    class="solutions_nav <?=$bg?> <?=$class?> <?=$style?>">
    <div class="container-xl">
        <a class="solutions_nav__card" href="/for-businesses/set-up-support">
            <img src="/wp-content/themes/abbiss/img/icon-supplementary-hr-services.svg">
            <div>Set up &amp;<br>Support</div>
        </a>
        <a class="solutions_nav__card" href="/for-businesses/operational-support">
            <img src="/wp-content/themes/abbiss/img/icon-cogs.svg">
            <div>Operational<br>Support</div>
        </a>
        <a class="solutions_nav__card" href="/for-businesses/managing-change">
            <img src="/wp-content/themes/abbiss/img/icon-steps.svg">
            <div>Managing<br>Change</div>
        </a>
        <a class="solutions_nav__card" href="/for-businesses/global-mobility">
            <img src="/wp-content/themes/abbiss/img/icon-global-mobility.svg">
            <div>Global<br>Mobility</div>
        </a>
        <a class="solutions_nav__card" href="/for-businesses/business-sales">
            <img src="/wp-content/themes/abbiss/img/icon-building.svg">
            <div>Business<br>Sales</div>
        </a>
        <a class="solutions_nav__card" href="/for-businesses/disputes">
            <img src="/wp-content/themes/abbiss/img/icon-disputes.svg">
            <div>Dispute<br>Resolution</div>
        </a>
    </div>
</section>