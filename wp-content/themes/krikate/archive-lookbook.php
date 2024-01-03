<?php get_header(); ?>
<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset">
                <?php yoast_breadcrumb(); ?>
            </ul>
    </section>

    <section class="lookbook section-offset">
        <div class="lookbook__container container">
            <h1 class="lookbook__title page-title">Lookbook</h1>
            <div class="lookbook__wrapper">
                <?php if (have_posts()) : ?>
                    <div class="lookbook-archive">
                        <?
                        $lookbook_index = 0;
                        ?>
                        <?php while (have_posts()) : the_post(); ?>

                            <?
                            $image = get_field('gallery')[0];
                            if ($lookbook_index == 0 || $lookbook_index == 3) {
                                echo '<div class="lookbook__wrapper-grid">';
                            }
                            ?>
                            <div class="lookbook-item">
                                <a href="<?php the_permalink(); ?>" class="lookbook-item__wrapper">
                                    <img src="<?= wp_get_attachment_image_url($image, 'full') ?>" alt="<?php the_title(); ?>">
                                    <div class="lookbook-item__title"><?php the_title(); ?></div>
                                    
                                </a>
                            </div>

                            <?
                            if ($lookbook_index == 2 || $lookbook_index == 7) {
                                echo '</div>';
                            }
                            
                            if ($lookbook_index == 7){
                                $lookbook_index = 0;
                            } else{
                                $lookbook_index++;
                            }
                            ?>

                        <?php endwhile; ?>
                    </div>
                    <div class="catalog__pagination">
                        <?php the_posts_pagination(); ?>
                    </div>
                <?php else : ?>
                    <p><?php _e('Страницы не найдены'); ?></p>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <? get_template_part('elements/element-subscription'); ?>
</main>

<?php get_footer(); ?>