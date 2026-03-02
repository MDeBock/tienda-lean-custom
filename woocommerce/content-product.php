<?php
/**
 * PLANTILLA MAESTRA DE TARJETA DE PRODUCTO
 * Obliga a WooCommerce a usar nuestro diseño Bootstrap en todas partes.
 */
defined( 'ABSPATH' ) || exit;

global $product;

// Si el producto no existe o está oculto, no hace nada
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>

<li <?php wc_product_class( 'list-unstyled', $product ); ?>>
    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="bg-white text-center p-3" style="height: 220px;">
            <a href="<?php the_permalink(); ?>">
                <?php echo $product->get_image('woocommerce_thumbnail', array('class' => 'img-fluid h-100 object-fit-contain')); ?>
            </a>
        </div>
        <div class="card-body d-flex flex-column bg-white border-top">
            <h6 class="card-title fw-bold text-dark text-truncate mb-1"><?php the_title(); ?></h6>
            <p class="h5 fw-bold text-success mb-3">
                <?php echo $product->get_price_html(); ?>
            </p>
            <div class="mt-auto">
                <a href="<?php the_permalink(); ?>" class="btn btn-primary w-100 fw-bold">Ver Detalles</a>
            </div>
        </div>
    </div>
</li>