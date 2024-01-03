<?php
/* Template Name: About Template */
$dostizheniya = get_field('dostizheniya');
$content = get_field('content');
$slide = get_field('slide');
$content2 = get_field('content2');
$gallery = get_field('gallery');
?>
<?php get_header(); ?>
<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset">
                <?php yoast_breadcrumb(); ?>
            </ul>
        </div>
    </section>

    <section class="history section-offset">
        <div class="history__container container">
            <h1 class="history__title page-title"><?php the_title(); ?></h1>
            <div class="history__wrapper">
                <div class="history__left">
                    <?= get_the_post_thumbnail(get_the_ID(), 'full') ?>
                </div>
                <div class="history__right">
                    <? the_content(); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="numbers section-offset">
        <div class="numbers__container container">
            <div class="numbers__left">
                <ul class="numbers__list list-reset">
                    <?
                    foreach ($dostizheniya['kolichestvo'] as $el) {
                        echo '<li class="numbers__item">
                        <div class="numbers__item-title">' . $el['numbers'] . '</div>
                        <div class="numbers__item-desc">' . $el['text'] . '</div>
                    </li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="numbers__right">
                <?= wp_get_attachment_image($dostizheniya['photo'], 'full') ?>
            </div>
        </div>
    </section>

    <section class="choice section-offset">
        <div class="choice__container container">
            <div class="choice__content">
                <?= $content; ?>
            </div>
        </div>
    </section>

    <section class="company section-offset">
        <div class="company__slider swiper">
            <div class="company__slider-wrapper swiper-wrapper">
                <?
                foreach ($slide as $el) {
                    echo '<div class="company__slider-item company-slide swiper-slide">' . wp_get_attachment_image($el, 'full') . '</div>';
                }
                ?>
            </div>
            <div class="company__slider-nav-btn company__slider-nav-btn--prev slider-nav-btn slider-nav-btn--prev">
                <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.08395 3.64645C0.888685 3.84171 0.888685 4.15829 1.08395 4.35355L4.26593 7.53553C4.46119 7.73079 4.77777 7.73079 4.97303 7.53553C5.1683 7.34027 5.1683 7.02369 4.97303 6.82843L2.14461 4L4.97303 1.17157C5.1683 0.976309 5.1683 0.659727 4.97303 0.464465C4.77777 0.269203 4.46119 0.269203 4.26593 0.464465L1.08395 3.64645ZM19.4375 3.5L1.4375 3.5L1.4375 4.5L19.4375 4.5L19.4375 3.5Z" fill="#1D1D1B" />
                </svg>
            </div>
            <div class="company__slider-nav-btn company__slider-nav-btn--next slider-nav-btn slider-nav-btn--next">
                <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.9161 4.35355C19.1113 4.15829 19.1113 3.84171 18.9161 3.64645L15.7341 0.464466C15.5388 0.269204 15.2222 0.269204 15.027 0.464466C14.8317 0.659728 14.8317 0.976311 15.027 1.17157L17.8554 4L15.027 6.82843C14.8317 7.02369 14.8317 7.34027 15.027 7.53553C15.2222 7.7308 15.5388 7.7308 15.7341 7.53553L18.9161 4.35355ZM0.5625 4.5H18.5625V3.5H0.5625V4.5Z" fill="#1D1D1B" />
                </svg>
            </div>
        </div>
    </section>

    <section class="choice section-offset">
        <div class="choice__container container">
            <div class="choice__content">
                <?= $content2; ?>
            </div>
        </div>
    </section>

    <section class="team section-offset">
        <div class="team__container container">
            <h2 class="team__title"></h2>
            <div class="team__grid">
            <?
                foreach ($gallery as $el) {
                    echo '<div class="team__grid-item">' . wp_get_attachment_image($el, 'full') . '</div>';
                }
                ?>

            </div>
        </div>
    </section>

    <? get_template_part('elements/element-instagram'); ?>
</main>


<?php get_footer(); ?>