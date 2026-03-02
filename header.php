<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    
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
                    <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-outline-light btn-sm fw-bold px-3">Ir al Carrito</a>
                <?php endif; ?>
            </div>

        </div>
    </nav>