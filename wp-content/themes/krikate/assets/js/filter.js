// JavaScript для обработки выбора фильтров и формирования URL-запроса
document.addEventListener('DOMContentLoaded', function() {
    const filters = document.querySelector('.filter');
    const catalogFilters = document.querySelector('.catalog__filter-list');

    const categoryButtons = document.querySelectorAll('.filter-section__category-item');
    // selectCategories();

    if (filters) {
        // Сброс всех фильтров
        const resetButton = document.querySelector('.filter__reset');
        resetButton.addEventListener('click', function() {
            const currentUrl = window.location.href.split('?')[0];
            window.location.href = currentUrl;
        });

        filters.querySelectorAll('.filter-section__selected').forEach(function(item) {
            item.addEventListener('click', function() {
                removeFilterParam(item);

                event.stopPropagation();
                item.remove();
                selectCategories();
            });
        });

        if (catalogFilters) {
            catalogFilters.querySelectorAll('.catalog__filter-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    removeFilterParam(item);

                    event.stopPropagation();
                    item.remove();
                    selectCategories();

                    var filterCategoryInput = document.querySelector('input[name="filter-category"]');
                    var filterSortInput = document.querySelector('input[name="sort"]:checked');
                    var filterPriceInput = document.querySelector('input#rangeMin').value + ',' + document.querySelector('input#rangeMax').value;

                    const selectedFilters = {
                        category: filterCategoryInput.value,
                        sort: filterSortInput.value,
                        price: filterPriceInput,
                    };

                    const queryParams = new URLSearchParams(selectedFilters);
                    const currentUrl = window.location.href.split('?')[0];
                    const newUrl = `${currentUrl}?${queryParams.toString()}`;

                    window.location.href = newUrl;
                });
            });
        }


        function removeFilterParam(item) {
            if (item.getAttribute('data-filter-type') == 'sort') {
                filters.querySelector('input[name="sort"][value="popularity"]').checked = true;
            } else if (item.getAttribute('data-filter-type') == 'price') {
                filters.querySelector('input#rangeMin').value = filters.querySelector('input#rangeMin').getAttribute('min');
                filters.querySelector('#thumbMin').style.left = 0;
                filters.querySelector('input#rangeMax').value = filters.querySelector('input#rangeMax').getAttribute('max');
                filters.querySelector('#thumbMax').style.left = 100 + '%';
                filters.querySelector('#line').style.left = 0;
                filters.querySelector('#line').style.right = 0;
                filters.querySelector('.filter-range__values>#min>span').textContent = filters.querySelector('input#rangeMin').value;
                filters.querySelector('.filter-range__values>#max>span').textContent = filters.querySelector('input#rangeMax').value;
            } else if (item.getAttribute('data-filter-type') == 'category') {
                let category_id = item.getAttribute('data-category-id');
                filters.querySelector('.filter-section__category-item[data-category-id="' + category_id + '"]').classList.remove('filter-section__category-item--active');
            }
        }

        const filterApply = filters.querySelector('.filter__apply');
        filters.addEventListener('change', function() {
            selectCategories();
        });


        function filterChange() {

            var filterCategoryInput = document.querySelector('input[name="filter-category"]');
            var selectedCategoryIds = filterCategoryInput.value.split(',').map(id => id.trim());

            var filterSortInput = document.querySelector('input[name="sort"]:checked');

            var filterPriceInput = document.querySelector('input#rangeMin').value + ',' + document.querySelector('input#rangeMax').value;

            const selectedFilters = {
                category: filterCategoryInput.value,
                sort: filterSortInput.value,
                price: filterPriceInput,
            };

            filterApply.disabled = true;

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'get_filtered_product_count',
                    category: selectedFilters.category,
                    sort: selectedFilters.sort,
                    price: selectedFilters.price,
                },
                success: function(response) {
                    if (response) {
                        if (response.count > 0) {
                            filterApply.textContent = 'Показать товары (' + response.count + ')';
                            filterApply.disabled = false;
                        } else {
                            filterApply.textContent = 'Товаров не найдено';
                        }

                    }
                },
                error: function(error) {
                    console.error('Ошибка AJAX:', error);
                }
            });

            const queryParams = new URLSearchParams(selectedFilters);
            const currentUrl = window.location.href.split('?')[0];
            const newUrl = `${currentUrl}?${queryParams.toString()}`;

            filterApply.addEventListener('click', function() {
                window.location.href = newUrl;
            });
        }




    }

    function selectCategories() {
        const activeCategoryButtons = document.querySelectorAll('.filter-section__category-item--active');
        const selectedCategoryIds = [];
        activeCategoryButtons.forEach(activeButton => {
            const categoryId = activeButton.getAttribute('data-category-id');
            selectedCategoryIds.push(categoryId);
        });
        const filterCategoryInput = document.querySelector('input[name="filter-category"]');
        filterCategoryInput.value = selectedCategoryIds.join(',');
        filterChange();
    }

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            selectCategories();
            filterChange();
        });
    });

});