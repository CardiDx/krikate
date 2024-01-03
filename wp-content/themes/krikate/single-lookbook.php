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
            <h1 class="lookbook__title page-title"><?php the_title(); ?></h1>
            <div class="lookbook__wrapper">
                <?
                $image_index = 0;
                $gallery = get_field('gallery');

                foreach ($gallery as $image) {
                    if ($image_index == 0 || $image_index == 3) {
                        echo '<div class="lookbook__wrapper-grid">';
                    }

                    echo '<div class="lookbook-item"> <div class="lookbook-item__wrapper">';
                    echo wp_get_attachment_image($image, 'full');
                    echo '</div> </div>';

                    if ($image_index == 2 || $image_index == 7) {
                        echo '</div>';
                    }

                    if ($image_index == 7) {
                        $image_index = 0;
                    } else {
                        $image_index++;
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <section class="more-lookbooks section-offset">
        <div class="more-lookbooks__container container">
            <h2 class="more-lookbooks__title">Другие lookbooks</h2>
            <div class="more-lookbooks__slider swiper">
                <div class="more-lookbooks__slider-wrapper swiper-wrapper">
                    <?
                    $current_lookbook_id = get_the_ID();
                    $args = array(
                        'post_type' => 'lookbook',
                        'posts_per_page' => 10, // Максимальное количество записей
                        'orderby' => 'rand',
                        'post__not_in' => array($current_lookbook_id), // Исключаем текущую страницу
                    );
                    
                    $random_lookbooks = new WP_Query($args);
                    
                    if ($random_lookbooks->have_posts()) {                    
                        while ($random_lookbooks->have_posts()) {
                            $random_lookbooks->the_post();
                            echo '<div class="lookbook-item swiper-slide"><a href="' . get_permalink() . '" class="lookbook-item__wrapper">';
                            echo '<img src="' . wp_get_attachment_image_url(get_field('gallery')[0], 'full') . '" alt="'. get_the_title() .'">';
                            echo '<div class="lookbook-item__title">'. get_the_title() .'</div>';
                            echo '</a></div>';
                        }
                    }

                    wp_reset_postdata();                    
                    ?>
                    
                </div>
                <div class="more-lookbooks__slider-nav-btn more-lookbooks__slider-nav-btn--prev slider-nav-btn slider-nav-btn--prev">
                    <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.08395 3.64645C0.888685 3.84171 0.888685 4.15829 1.08395 4.35355L4.26593 7.53553C4.46119 7.73079 4.77777 7.73079 4.97303 7.53553C5.1683 7.34027 5.1683 7.02369 4.97303 6.82843L2.14461 4L4.97303 1.17157C5.1683 0.976309 5.1683 0.659727 4.97303 0.464465C4.77777 0.269203 4.46119 0.269203 4.26593 0.464465L1.08395 3.64645ZM19.4375 3.5L1.4375 3.5L1.4375 4.5L19.4375 4.5L19.4375 3.5Z" fill="#1D1D1B" />
                    </svg>
                </div>
                <div class="more-lookbooks__slider-nav-btn more-lookbooks__slider-nav-btn--next slider-nav-btn slider-nav-btn--next">
                    <svg width="20" height="8" viewBox="0 0 20 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.9161 4.35355C19.1113 4.15829 19.1113 3.84171 18.9161 3.64645L15.7341 0.464466C15.5388 0.269204 15.2222 0.269204 15.027 0.464466C14.8317 0.659728 14.8317 0.976311 15.027 1.17157L17.8554 4L15.027 6.82843C14.8317 7.02369 14.8317 7.34027 15.027 7.53553C15.2222 7.7308 15.5388 7.7308 15.7341 7.53553L18.9161 4.35355ZM0.5625 4.5H18.5625V3.5H0.5625V4.5Z" fill="#1D1D1B" />
                    </svg>
                </div>
            </div>
        </div>
    </section>



    <? get_template_part('elements/element-subscription'); ?>
</main>

<?php get_footer(); ?>