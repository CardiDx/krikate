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
    <div class="post-info">
        <div class="post-title"><? the_title_attribute() ?></div>
        <div class="post-excerpt">
            <?
            $post_excerpt = get_the_excerpt();
            $charlength = 140;
            the_excerpt_max_charlength($charlength, $post_excerpt);
            ?>
        </div>
        <?
        $tags = get_the_tags();
        if ($tags) : ?>
            <div class="post-tags">
                <?
                foreach ($tags as $val) {
                    echo '<span>' . $val->name . '</span>';
                }
                ?>
            </div>
        <? endif; ?>
    </div>
</a>