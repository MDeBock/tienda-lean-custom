<?php

/**
 * 1. RECURSOS Y BOOTSTRAP
 */
function lean_enqueue_scripts() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css');
    wp_enqueue_style('lean-style', get_stylesheet_uri());
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'lean_enqueue_scripts');

/**
 * 2. CONFIGURACIÓN Y SIDEBAR
 */
function lean_setup() {
    add_theme_support('woocommerce');
    add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
    
    register_sidebar( array(
        'name'          => 'Filtros de Tienda',
        'id'            => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s mb-4">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widgettitle fw-bold border-bottom pb-2 mb-3">',
        'after_title'   => '</h5>',
    ) );
}
add_action('after_setup_theme', 'lean_setup');

/**
 * 3. DESACTIVACIÓN TOTAL DE BLOQUES (Widgets Clásicos)
 */
add_filter( 'use_widget_block_editor', '__return_false' );
add_action( 'sidebar_admin_setup', function() {
    remove_theme_support( 'widgets-block-editor' );
}, 100 );

/**
 * 4. LÓGICA DE NEGOCIO Y CHECKOUT
 */
add_filter( 'woocommerce_checkout_fields' , 'lean_customize_checkout_fields' );
function lean_customize_checkout_fields( $fields ) {
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    return $fields;
}

/**
 * 5. LÓGICA DE INVENTARIO (Blindaje de Stock)
 */
add_action('admin_head', 'lean_custom_admin_styles');
function lean_custom_admin_styles() {
    echo '<style>
        ._manage_stock_field { display: none !important; }
        ._stock_status_field { display: none !important; }
        ._sku_field { display: none !important; }
        ._global_unique_id_field { display: none !important; }
        .stock_fields { display: block !important; }
    </style>';
}

add_action('woocommerce_admin_process_product_object', 'lean_force_manage_stock_and_quantity');
function lean_force_manage_stock_and_quantity( $product ) {
    $product->set_manage_stock( true );
    if ( isset( $_POST['_stock'] ) ) {
        $product->set_stock_quantity( wc_stock_amount( $_POST['_stock'] ) );
    }
    if ( isset( $_POST['_low_stock_amount'] ) ) {
        $product->set_low_stock_amount( wc_stock_amount( $_POST['_low_stock_amount'] ) );
    }
}

/**
 * 6. FORMULARIO SIMPLE DE CARGA (Taxonomías Personalizadas)
 */
add_action( 'init', 'lean_crear_formulario_producto', 0 );
function lean_crear_formulario_producto() {
    register_taxonomy( 'tipo_producto', 'product', array(
        'labels' => array( 'name' => 'Tipos de Producto', 'singular_name' => 'Tipo de Producto', 'add_new_item' => 'Añadir nuevo Tipo' ),
        'hierarchical' => true,
        'show_admin_column' => true,
    ));

    register_taxonomy( 'presentacion', 'product', array(
        'labels' => array( 'name' => 'Presentaciones', 'singular_name' => 'Presentación', 'add_new_item' => 'Añadir nueva Presentación' ),
        'hierarchical' => true,
        'show_admin_column' => true,
    ));
}

/**
 * 7. INTERCEPTOR DE PLANTILLAS PARA FILTROS
 */
add_filter( 'template_include', 'lean_forzar_plantilla_filtros', 99 );
function lean_forzar_plantilla_filtros( $template ) {
    if ( is_tax( array( 'product_cat', 'product_tag', 'marca', 'tipo_producto', 'presentacion' ) ) ) {
        $mi_plantilla = locate_template( array( 'index.php' ) );
        if ( ! empty( $mi_plantilla ) ) {
            return $mi_plantilla;
        }
    }
    return $template;
}

/**
 * 8. REPARACIÓN DEL ENRUTAMIENTO (Redirecciones)
 * Obliga a WooCommerce a usar nuestro front-page.php como catálogo principal.
 */
add_filter( 'woocommerce_return_to_shop_redirect', 'lean_custom_shop_url' );
add_filter( 'woocommerce_get_shop_page_permalink', 'lean_custom_shop_url' );
add_filter( 'woocommerce_breadcrumb_home_url', 'lean_custom_shop_url' );
function lean_custom_shop_url() {
    return home_url('/'); // Lo manda a la raíz donde está nuestra grilla
}

/**
 * 9. CONTADOR DE CARRITO AJAX (Fragments)
 * Actualiza el carrito en tiempo real contando PRODUCTOS DISTINTOS (no unidades).
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'lean_cart_count_fragments', 10, 1 );
function lean_cart_count_fragments( $fragments ) {
    // Cuenta la cantidad de elementos (líneas) en el array del carrito
    $count = WC()->cart ? count( WC()->cart->get_cart() ) : 0;
    
    // Este span reemplaza al viejo cuando el AJAX entra en acción
    $fragments['span.lean-cart-count'] = '<span class="lean-cart-count badge bg-danger rounded-pill ms-2">' . $count . '</span>';
    
    return $fragments;
}