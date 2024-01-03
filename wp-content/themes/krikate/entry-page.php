<a class="post-preview" href="<?= the_permalink() ?>">
    <div class="post-img">
        <?
        $post_img = get_the_post_thumbnail();
        if ($post_img == '') {
            $post_img = wp_get_attachment_image(get_field("field_6439b497ffb81", "option"));
        }
        echo $post_img;
        ?>
    </div>
    <div class="post-title"><? the_title_attribute() ?></div>
</a>