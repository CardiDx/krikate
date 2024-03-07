<? get_header(); ?>

<?
global $product;

if($product->slug == 'podarochnaja-karta') {
    // Товар подарочной карты
    include('gift-card-product.php');
    // include('single-product-variation.php');
} elseif ($product->is_type('simple')) {
    // Товар является обычным (простым)
    // include('single-product-simple.php');

} elseif ($product->is_type('variable')) {
    // Товар является вариативным
    include('single-product-variation.php');
} elseif ($product->is_type('grouped')) {
    // Товар является групповым
} elseif ($product->is_type('external')) {
    // Товар является внешним
}

?>


<? get_footer(); ?>