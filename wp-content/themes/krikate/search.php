<?php get_header(); ?>
<?
if (isset($_GET['s']) && !empty($_GET['s'])) {
    $search_title = $_GET['s'];
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        's' => $search_title,
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);
    $total_posts = $query->found_posts;
}
?>
<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset">
                <?php yoast_breadcrumb(); ?>
            </ul>
    </section>
    <section class="catalog section-offset">
        <div class="catalog__container container">
            <? if (isset($_GET['s']) && !empty($_GET['s'])) : ?>
                <h1 class="catalog__title">Результаты поиска «<?= $search_title ?>»</h1>
                <div class="catalog__desc page-title">Результатов найдено: <?= $total_posts ?></div>
                <div class="catalog__body">
                    <?
                    
                    if ($query->have_posts()) {
                        echo '<ul class="catalog__list list-reset">';
                        while ($query->have_posts()) {
                            $query->the_post();
                            wc_get_template_part('content', 'product');
                        }
                        echo '</ul>';
                    } else {
                        echo '<div class="post-no-found">Товаров не найдено</div>';
                    }
                    ?>
                </div>
            <? else :?>
                <h1 class="catalog__title">Поиск не возможен: пустой запрос</h1>  
            <?php endif; ?>  
        </div>
    </section>
</main>

<?php get_footer(); ?>