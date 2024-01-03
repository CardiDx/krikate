<?php
/* Template Name: Contacts Template */
get_header(); ?>
<?
$shops = get_field('shops');
?>
<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset">
                <?php yoast_breadcrumb(); ?>
            </ul>
        </div>
    </section>

    <section class="shops section-offset">
        <div class="shops__container container">
            <h1 class="shops__title page-title"><?php the_title(); ?></h1>
            <? if (isset($shops) && !empty($shops)) : ?>
                <ul class="shops__list list-reset">
                    <? foreach ($shops as $shop) : ?>
                        <li class="shops__list-item shop-item">
                            <div class="shop-item__cover">
                                <?= wp_get_attachment_image($shop['image'], 'full') ?>
                                <?= wp_get_attachment_image($shop['image_2'], 'full') ?>
                            </div>
                            <div class="shop-item__body">
                                <?= $shop['text'] ?>
                            </div>
                            <div class="shop-item__links">
                                <a href="<?= $shop['link_google'] ?>" class="shop-item__links-item">Смотреть на Google картах</a>
                                <a href="<?= $shop['link_yandex'] ?>" class="shop-item__links-item">Смотреть на Yandex картах</a>
                            </div>
                        </li>
                    <? endforeach; ?>
                </ul>
            <? endif; ?>
        </div>
    </section>

    <? get_template_part('elements/element-contacts'); ?>
    <? get_template_part('elements/element-instagram'); ?>
</main>



<?php get_footer(); ?>