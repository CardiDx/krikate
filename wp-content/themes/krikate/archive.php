<?php get_header(); ?>




<!-- 
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php get_template_part('entry'); ?>
<?php endwhile;
endif; ?>
<?php get_template_part('nav', 'below'); ?> -->

<?php if ('' != get_the_archive_description()) {
    echo esc_html(get_the_archive_description());
} ?>
<?php get_footer(); ?>