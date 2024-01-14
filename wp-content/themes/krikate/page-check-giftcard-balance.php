<?php get_header(); ?>
<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset breadcrumbs__gift-balance">
                <?php yoast_breadcrumb(); ?>
            </ul>
        </div>
    </section>

    <section class="shops section-offset">
        <div class="shops__container container">
            <h1 class="gift-balance__title page-title "><?php the_title(); ?></h1>
            <!-- вывод баланса сертифката через плагин -->
            <?php echo do_shortcode( "[pw_gift_cards_balance]" ); ?>

        </div>
    </section>

    <? get_template_part('elements/element-instagram'); ?>
</main>


<?php get_footer(); ?>