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
                $post_tag[] = get_queried_object()->term_id;
                post_listing(NULL, $post_tag, NULL, NULL);
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
            <form id="tag-search-form">
                <div><label for="key-search" class="form-label">Поиск по слову:</label>
                    <div class="input-search-conteiner">
                        <input type="search" name="key-search" id="#search-input" placeholder="Введите ключевое слово" value="<? if (isset($_GET['search'])) {
                                                                                                                                    echo $_GET['search'];
                                                                                                                                } ?>">
                        <i class="las la-search"></i>
                    </div>
                </div>


                <div class="category">
                    <label for="category[]" class="form-label">Поиск по категориям:</label>
                    <?php
                    // Получаем все теги и выводим их в виде чекбоксов
                    $category = get_categories();
                    foreach ($category as $cat) {
                        $cat_id = $cat->term_id;
                        $checked = '';
                        if (isset($_GET['category'])) { // проверяем наличие параметра "post_tag" в URL
                            $post_category = explode(',', $_GET['category']); // разбиваем строку на массив
                            if (in_array($cat_id, $post_category)) { // проверяем, есть ли текущий тег в массиве тегов
                                $checked = 'checked';
                            }
                        }
                        echo '<label><input type="checkbox" name="category[]" value="' . $cat_id . '" ' . $checked . '> <span>' . $cat->name . '</span></label>';
                    }
                    ?>
                </div>

                <input type="hidden" name="action" value="ajax_filter">
                <input type="hidden" name="tag-id" value="<?= get_queried_object_id(); ?>">
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