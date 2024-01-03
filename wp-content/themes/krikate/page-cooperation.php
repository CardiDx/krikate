<?php
/* Template Name: Cooperation Template */
?>
<?php get_header(); ?>
<?
$opisaniye = get_field('opisaniye');
?>
<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset">
                <?php yoast_breadcrumb(); ?>
            </ul>
        </div>
    </section>
    <section class="cooperation section-offset">
        <div class="cooperation__container container">
            <h1 class="cooperation__title page-title"><?php the_title(); ?></h1>
            <? if (isset($opisaniye) && !empty($opisaniye)) : ?>
                <div class="cooperation__wrapper">
                    <div class="cooperation__left">
                        <?= wp_get_attachment_image($opisaniye[0]['image'], 'full') ?>
                    </div>
                    <div class="cooperation__right">
                        <?= $opisaniye[0]['content'] ?>
                    </div>
                </div>
                <? if (isset($opisaniye[1]) && !empty($opisaniye[1])) : ?>
        </div>
    </section>

    <section class="cooperation cooperation--revert section-offset">
        <div class="cooperation__container container">
            <div class="cooperation__wrapper">
                <div class="cooperation__left">
                    <?= wp_get_attachment_image($opisaniye[1]['image'], 'full') ?>
                </div>
                <div class="cooperation__right">
                    <?= $opisaniye[1]['content'] ?>
                </div>
            </div>
        <? endif; ?>
    <? endif; ?>
        </div>
    </section>



    <? get_template_part('elements/element-contacts'); ?>

    <? get_template_part('elements/element-instagram'); ?>
</main>
<? get_footer(); ?>