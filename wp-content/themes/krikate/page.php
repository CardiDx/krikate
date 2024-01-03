<?php get_header(); ?>
<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset">
                <?php yoast_breadcrumb(); ?>
            </ul>
        </div>
    </section>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <section class="shops section-offset">
                <div class="shops__container container">
                    <h1 class="information__title"><?= get_the_title(); ?></h1>
                    <div class="information__content simple-page">
                        <? the_content(); ?>
                    </div>
                </div>
            </section>

    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>