<?php
/* Template Name: Information Template */
get_header(); 
$page_id = get_the_ID();
?>

<main>
    <section class="breadcrumbs">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset">
                <?php yoast_breadcrumb(); ?>
            </ul>
        </div>
    </section>

    <section class="information section-offset">
            <div class="information__container container">
                <aside class="information__aside">
                    <nav class="information__navigation">
                        <?
                        $args = array(
                            'post_type' => 'page',
                            'meta_key' => '_wp_page_template',
                            'meta_value' => 'page-info.php',
                            'posts_per_page' => -1,
                        );
                        
                        $info_pages = new WP_Query($args);
                        
                        if ($info_pages->have_posts()) {
                            while ($info_pages->have_posts()) {
                                $info_pages->the_post();
                                if ($page_id == get_the_ID()){
                                    echo '<div class="information__navigation-item information__navigation-item--active">';
                                } else {
                                    echo '<div class="information__navigation-item">';
                                }
                                
                                echo '<a href="' . get_permalink() . '" class="information__navigation-link">' . get_the_title() . '</a>';
                                echo '</div>';
                            }
                        }
                        wp_reset_postdata();
                        
                        ?>
                    </nav>
                </aside>
                <div class="information__main">
                    <h1 class="information__title">
                        <?php 
                        $page_headline = get_field('headline');
                        if (isset($page_headline) && !empty($page_headline)){
                            echo $page_headline;
                        } else {
                            echo get_the_title();
                        }
                        ?>
                        </h1>
                    <div class="information__content">
                        <? the_content(); ?>
                    </div>
                </div>
            </div>
        </section>

        <? get_template_part('elements/element-instagram'); ?>
</main>

<? get_footer(); ?>