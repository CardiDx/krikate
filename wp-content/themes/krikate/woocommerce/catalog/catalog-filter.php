<?
$current_category = get_queried_object();

if (isset($_GET['sort']) && !empty($_GET['sort']) && $_GET['sort'] !== 'popularity') {
    $filter_sort = $_GET['sort'];
} else {
    $filter_sort = NULL;
}

if (isset($current_category->term_id)) {
    $current_category_id = $current_category->term_id;
} else {
    $current_category_id = 0;
}

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $filter_category = explode(',', $_GET['category']);
    if (count($filter_category) === 1 && $filter_category[0] == $current_category_id){
        $filter_category = NULL;
    }
} else {
    $filter_category = NULL;
}

$price_range = get_min_max_product_price();
if (isset($_GET['price']) && !empty($_GET['price']) && count(explode(',', $_GET['price'])) === 2) {
    $filter_price = explode(',', $_GET['price']);
    if ($price_range['min_price'] == $filter_price[0] && $price_range['max_price'] == $filter_price[1]){
        $filter_price = NULL;
    }
} else {
    $filter_price = NULL;
}



?>

<? if($filter_sort !== NULL || $filter_category !== NULL || $filter_price !== NULL) :?>
<div class="catalog__filter-list">
    <?
    if ($filter_sort !== NULL) {
        echo '<button class="catalog__filter-item btn-reset"" data-filter-type="sort" data-sort="' . $filter_sort . '"><svg width="10" height="10" viewBox="0 0 10 10"><use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#remove"></use></svg>';
        switch ($filter_sort) {
            case 'newest':
                echo 'Новинки';
                break;
            case 'price_desc':
                echo 'По убыванию цены';
                break;
            case 'price_asc':
                echo 'По возрастанию цены';
                break;
        }
        echo '</button>';
    }

    if ($filter_category !== NULL) {
        foreach ($filter_category as $category_id) {
            $filter_taxonomy = get_term_by('id', $category_id, 'product_cat');
            echo '<button class="catalog__filter-item btn-reset"" data-filter-type="category" data-category-id="' . $filter_taxonomy->term_id . '"><svg width="10" height="10" viewBox="0 0 10 10"><use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#remove"></use></svg>';
            echo $filter_taxonomy->name;
            echo '</button>';
        }
    }

    if ($filter_price !== NULL) {
        echo '<button class="catalog__filter-item btn-reset"" data-filter-type="price""><svg width="10" height="10" viewBox="0 0 10 10"><use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#remove"></use></svg>';
        echo $filter_price[0] . ' BYN - ' . $filter_price[1] . ' BYN';
        echo '</button>';
    }

    ?>

</div>
<? endif; ?>

<div class="filter">
    <div class="filter__wrapper">
        <div class="filter__top">
            <button class="filter__back btn-reset">
                <svg width="12" height="13" viewBox="0 0 12 13">
                    <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#backarrow"></use>
                </svg>
                Фильтры и сортировка
            </button>
            <button class="filter__reset btn-reset">Сбросить</button>
        </div>
        <div class="filter__body">
            <div class="filter__section filter-section">
                <div class="filter-section__top">
                    <div class="filter-section__title">Выбранные фильтры</div>
                </div>
                <div class="filter-section__wrapper">
                    <?
                    if ($filter_sort !== NULL) {
                        echo '<button class="filter-active filter-section__selected btn-reset" data-filter-type="sort" data-sort="' . $filter_sort . '"><svg width="10" height="10" viewBox="0 0 10 10"><use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#remove"></use></svg>';
                        switch ($filter_sort) {
                            case 'newest':
                                echo 'Новинки';
                                break;
                            case 'price_desc':
                                echo 'По убыванию цены';
                                break;
                            case 'price_asc':
                                echo 'По возрастанию цены';
                                break;
                        }
                        echo '</button>';
                    }

                    if ($filter_category !== NULL) {
                        foreach ($filter_category as $category_id) {
                            $filter_taxonomy = get_term_by('id', $category_id, 'product_cat');
                            echo '<button class="filter-active filter-section__selected btn-reset" data-filter-type="category" data-category-id="' . $filter_taxonomy->term_id . '"><svg width="10" height="10" viewBox="0 0 10 10"><use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#remove"></use></svg>';
                            echo $filter_taxonomy->name;
                            echo '</button>';
                        }
                    }

                    if ($filter_price !== NULL) {
                        echo '<button class="filter-active filter-section__selected btn-reset" data-filter-type="price""><svg width="10" height="10" viewBox="0 0 10 10"><use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#remove"></use></svg>';
                        echo $filter_price[0] . ' BYN - ' . $filter_price[1] . ' BYN';
                        echo '</button>';
                    }

                    ?>
                </div>
            </div>
            <div class="filter__section filter-section">
                <div class="filter-section__top">
                    <div class="filter-section__title">Сортировать по</div>
                    <button class="filter-section__arrow filter-section__arrow--down btn-reset">
                        <svg width="12" height="13" viewBox="0 0 12 13">
                            <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#downarrow"></use>
                        </svg>
                    </button>
                </div>
                <div class="filter-section__body filter-section__body--open" data-filter-type="sort">
                    <label class="c-radio">
                        <?
                        if ($filter_sort == NULL) {
                            echo '<input type="radio" name="sort" checked value="popularity">';
                        } else {
                            echo '<input type="radio" name="sort" value="popularity">';
                        }
                        ?>
                        <div class="c-radio__body">
                            <div class="c-radio__box"></div>
                            <div class="c-radio__label">По популярности</div>
                        </div>
                    </label>
                    <label class="c-radio">
                        <?
                        if ($filter_sort !== NULL && $filter_sort == 'newest') {
                            echo '<input type="radio" name="sort" checked value="newest">';
                        } else {
                            echo '<input type="radio" name="sort" value="newest">';
                        }
                        ?>
                        <div class="c-radio__body">
                            <div class="c-radio__box"></div>
                            <div class="c-radio__label">Новинки</div>
                        </div>
                    </label>
                    <label class="c-radio">
                        <?
                        if ($filter_sort !== NULL && $filter_sort == 'price_desc') {
                            echo '<input type="radio" name="sort" checked value="price_desc">';
                        } else {
                            echo '<input type="radio" name="sort" value="price_desc">';
                        }
                        ?>
                        <div class="c-radio__body">
                            <div class="c-radio__box"></div>
                            <div class="c-radio__label">По убыванию цены</div>
                        </div>
                    </label>
                    <label class="c-radio">
                        <?
                        if ($filter_sort !== NULL && $filter_sort == 'price_asc') {
                            echo '<input type="radio" name="sort" checked value="price_asc">';
                        } else {
                            echo '<input type="radio" name="sort" value="price_asc">';
                        }
                        ?>
                        <div class="c-radio__body">
                            <div class="c-radio__box"></div>
                            <div class="c-radio__label">По возрастанию цены</div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="filter__section filter-section">
                <div class="filter-section__top">
                    <div class="filter-section__title">Категории</div>
                    <button class="filter-section__arrow filter-section__arrow--down btn-reset">
                        <svg width="12" height="13" viewBox="0 0 12 13">
                            <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#downarrow"></use>
                        </svg>
                    </button>
                </div>
                <div class="filter-section__body filter-section__body--open" data-filter-type="category">
                    <?
                    if ($filter_category == NULL) {
                        echo '<input type="hidden" name="filter-category" value="' . $current_category_id . '">';
                    } else {
                        echo '<input type="hidden" name="filter-category" value="' . $_GET['category'] . '">';
                    }
                    ?>


                    <?php
                    $parent_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'parent' => 0,
                    ));

                    foreach ($parent_categories as $parent_category) :
                    ?>
                        <?
                        $active_category = '';
                        if ($filter_category !== NULL) {
                            if (in_array($parent_category->term_id, $filter_category)) {
                                $active_category = ' filter-section__category-item--active';
                            }
                        } elseif ($current_category_id !== 0) {
                            if ($parent_category->term_id == $current_category_id) {
                                $active_category = ' filter-section__category-item--active';
                            }
                        }

                        ?>
                        <div class="filter-section__category">
                            <button class="filter-section__category-item btn-reset<?= $active_category; ?>" data-category-id="<?= $parent_category->term_id; ?>">
                                <?php echo esc_html($parent_category->name); ?>
                                <span>(<?php echo esc_html($parent_category->count); ?>)</span>
                            </button>

                            <?php
                            $child_categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'parent' => $parent_category->term_id,
                            ));

                            foreach ($child_categories as $child_category) :
                            ?>
                                <?
                                $active_category = '';
                                if ($filter_category !== NULL) {
                                    if (in_array($child_category->term_id, $filter_category)) {
                                        $active_category = ' filter-section__category-item--active';
                                    }
                                } elseif ($current_category_id !== 0) {
                                    if ($child_category->term_id == $current_category_id) {
                                        $active_category = ' filter-section__category-item--active';
                                    }
                                }
                                ?>
                                <button class="filter-section__category-item filter-section__category-item--sub btn-reset<?= $active_category; ?>" data-category-id="<?= $child_category->term_id; ?>">
                                    <?php echo esc_html($child_category->name); ?>
                                    <span>(<?php echo esc_html($child_category->count); ?>)</span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>


                </div>
            </div>

            <div class="filter__section filter-section">
                <div class="filter-section__top">
                    <div class="filter-section__title">Цена</div>
                    <button class="filter-section__arrow filter-section__arrow--down btn-reset">
                        <svg width="12" height="13" viewBox="0 0 12 13">
                            <use xlink:href="/wp-content/themes/krikate/assets/styles/svg-sprite.svg#downarrow"></use>
                        </svg>
                    </button>
                </div>
                <div class="filter-section__body filter-section__body--open">
                    <?
                    
                    if ($filter_price !== NULL) {
                        $filter_price = explode(',', $_GET['price']);
                        $min_price = $filter_price[0];
                        $max_price = $filter_price[1];
                    } else {
                        $min_price = $price_range['min_price'];
                        $max_price = $price_range['max_price'];
                    }
                    ?>
                    <div class="filter-range">
                        <div class="filter-range__values">
                            <div id="min">от <span><?= $price_range['min_price']; ?></span> byn</div>
                            <div id="max">до <span><?= $price_range['max_price']; ?></span> byn</div>
                        </div>
                        <div class="filter-range__wrapper">
                            <div class="filter-range__slide">
                                <div class="filter-range__line" id="line" style="left: 0%; right: 0%;"></div>
                                <span class="filter-range__thumb" id="thumbMin" style="left: 0%;"></span>
                                <span class="filter-range__thumb" id="thumbMax" style="left: 100%;"></span>
                            </div>


                            <input id="rangeMin" type="range" max="<?= $price_range['max_price']; ?>" min="<?= $price_range['min_price']; ?>" step="5" value="<?= $min_price; ?>">
                            <input id="rangeMax" type="range" max="<?= $price_range['max_price']; ?>" min="<?= $price_range['min_price']; ?>" step="1" value="<?= $max_price; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter__bottom">

            <button class="filter__apply btn-reset primary-button" disabled>Выберите фильтры</button>
        </div>
    </div>
</div>