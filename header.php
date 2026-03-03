<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    
    <style>
        /* ESTILOS GLOBALES PARA NOTIFICACIONES DE WOOCOMMERCE */
        .woocommerce-message, .woocommerce-error, .woocommerce-info { 
            background-color: #d1e7dd; color: #0f5132; border: none; border-radius: 6px; 
            padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; 
            justify-content: center; font-weight: bold; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .woocommerce-message::before { content: none; } 
        .woocommerce-message a.button.wc-forward { display: none !important; }
    </style>

    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-light'); ?>>

    <nav class="navbar navbar-dark bg-dark mb-4 shadow sticky-top">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3 gap-md-0">
            
            <a class="navbar-brand fw-bold text-uppercase col-12 col-md-3 text-center text-md-start m-0" href="<?php echo esc_url( home_url('/') ); ?>">
                Tienda Lean Custom
            </a>

            <form action="<?php echo esc_url( home_url('/') ); ?>" method="GET" class="d-flex col-12 col-md-5">
                <input type="search" name="busqueda" class="form-control border-0 rounded-start shadow-none" placeholder="Buscar productos..." value="<?php echo isset($_GET['busqueda']) ? esc_attr($_GET['busqueda']) : ''; ?>" required>
                <button class="btn btn-primary rounded-end px-3" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <div class="col-12 col-md-3 text-center text-md-end">
                <?php if ( function_exists('is_cart') && is_cart() ) : ?>
                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn btn-outline-light btn-sm fw-bold px-3">Inicio</a>
                <?php else : ?>
                    <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-outline-light btn-sm fw-bold px-3 d-inline-flex align-items-center">
                        Ir al Carrito
                        <span class="lean-cart-count badge bg-danger rounded-pill ms-2">
                            <?php echo WC()->cart ? count( WC()->cart->get_cart() ) : 0; ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <?php 
                if ( function_exists( 'wc_print_notices' ) ) {
                    wc_print_notices(); 
                }
                ?>
            </div>
        </div>
    </div>