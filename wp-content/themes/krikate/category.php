<?php
get_header();
// echo esc_url(get_pagenum_link());
?>


<div class="select-container margin-container category-page">
    <div class="category-content">
        <div id="ajax_loading" style="display:none;">
            <?php get_template_part('elements/loading-proc');  ?>
        </div>
        <div class="post-listing">
            <?php //get_template_part('elements/post-listing'); 
            ?>
            <?
            get_template_part('elements/post-listing');
            if ($_GET['itfilter'] == 1) {
                $category = explode(",", $_GET['category']);
                $post_tag = explode(",", $_GET['post_tag']);
                $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
                post_listing($category, $post_tag, $search, array('page_url', $_SERVER['REQUEST_URI']));
            } else {
                $category[] = get_queried_object()->term_id;
                post_listing($category, NULL, NULL, NULL);
            }
            ?>
        </div>

        <div class="category-text" itemprop="description">
            <?php if ('' != get_the_archive_description()) : ?>
                <?= get_the_archive_description() ?>
            <? endif; ?>
        </div>

    </div>
    <aside class="sitebar">
        <div class="open-filter-btn"><i class="las la-filter"></i> <span>Открыть фильтр</span></div>
        <div class="category-filter-form">
            <form id="search-form">
                <div>
                    <label for="key-search" class="form-label">Поиск по слову:</label>
                    <div class="input-search-conteiner">
                        <input type="search" name="key-search" id="#search-input" placeholder="Введите ключевое слово" value="<? if (isset($_GET['search'])) {
                                                                                                                                    echo $_GET['search'];
                                                                                                                                } ?>">
                        <i class="las la-search"></i>
                    </div>
                </div>
                <div class="tags">
                    <label for="tag[]" class="form-label">Поиск по тегам:</label>
                    <?php
                    // Получаем все теги и выводим их в виде чекбоксов
                    $tags = get_tags();
                    foreach ($tags as $tag) {
                        $tag_id = $tag->term_id;
                        $checked = '';
                        if (isset($_GET['post_tag'])) { // проверяем наличие параметра "post_tag" в URL
                            $post_tags = explode(',', $_GET['post_tag']); // разбиваем строку на массив
                            if (in_array($tag_id, $post_tags)) { // проверяем, есть ли текущий тег в массиве тегов
                                $checked = 'checked';
                            }
                        }
                        echo '<label><input type="checkbox" name="tag[]" value="' . $tag_id . '" ' . $checked . '> <span>' . $tag->name . '</span></label>';
                    }
                    ?>
                </div>

                <input type="hidden" name="action" value="ajax_filter">
                <input type="hidden" name="category-id" value="<?= get_queried_object_id(); ?>">
                <?php wp_nonce_field('my_ajax_check_nonce', 'nonce'); ?>
                <div class="action-btn">
                    <button type="submit" class="btn-type-1">Найти</button>
                    <button class="clear-filter">Очистить фильтр</button>
                </div>
            </form>
        </div>
</div>
</aside>
</div>

<?php get_footer(); ?>