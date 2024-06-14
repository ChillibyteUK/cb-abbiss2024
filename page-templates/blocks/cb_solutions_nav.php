<?php
$class = $block['className'] ?? 'py-5';
$bg = get_field('grey_bg') ? 'bg-grey-500' : '';
$style = (get_field('compact')[0] ?? null) === 'Yes' ? 'solutions_nav__compact' : '';

$link = wp_make_link_relative(get_permalink());
?>
<section
    class="solutions_nav <?=$bg?> <?=$class?> <?=$style?>">
    <div class="container-xl">
        <?php
        $active = $link == '/for-businesses/set-up-support/' ? 'active' : '';
?>
        <a class="solutions_nav__card <?=$active?>"
            href="/for-businesses/set-up-support/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-supplementary-hr-services.svg"
                alt="Set Up & Support">
            <div>Set up &amp;<br>Support</div>
        </a>
        <?php
$active = $link == '/for-businesses/operational-support/' ? 'active' : '';
?>
        <a class="solutions_nav__card <?=$active?>"
            href="/for-businesses/operational-support/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-cogs.svg"
                alt="Operational Support">
            <div>Operational<br>Support</div>
        </a>
        <?php
$active = $link == '/for-businesses/managing-change/' ? 'active' : '';
?>
        <a class="solutions_nav__card <?=$active?>"
            href="/for-businesses/managing-change/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-steps.svg"
                alt="Managing Change">
            <div>Managing<br>Change</div>
        </a>
        <?php
$active = $link == '/for-businesses/global-mobility/' ? 'active' : '';
?>
        <a class="solutions_nav__card <?=$active?>"
            href="/for-businesses/global-mobility/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-global-mobility.svg"
                alt="Global Mobility">
            <div>Global<br>Mobility</div>
        </a>
        <?php
$active = $link == '/for-businesses/business-sales/' ? 'active' : '';
?>
        <a class="solutions_nav__card <?=$active?>"
            href="/for-businesses/business-sales/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-building.svg"
                alt="Business Sales">
            <div>Business<br>Sales</div>
        </a>
        <?php
$active = $link == '/for-businesses/disputes/' ? 'active' : '';
?>
        <a class="solutions_nav__card <?=$active?>"
            href="/for-businesses/disputes/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-disputes.svg"
                alt="Dispute Resolution">
            <div>Dispute<br>Resolution</div>
        </a>
    </div>
</section>