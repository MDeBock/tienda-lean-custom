<?php get_header(); ?>

    <main class="container-fluid px-lg-5 py-4">
        <div class="row">
            
            <aside class="col-lg-3 pe-lg-5 mb-4">
                <form action="<?php echo esc_url( home_url('/') ); ?>" method="GET" class="bg-white p-4 rounded shadow-sm sticky-top" style="top: 80px;">
                    <h5 class="fw-bold mb-4 border-bottom pb-2">Filtros Avanzados</h5>
                    
                    <?php
                    // Memoria del buscador: Si buscaste una palabra, la mantiene oculta mientras filtrás
                    if ( isset($_GET['busqueda']) && !empty($_GET['busqueda']) ) : ?>
                        <input type="hidden" name="busqueda" value="<?php echo esc_attr($_GET['busqueda']); ?>">
                    <?php endif; ?>

                    <?php
                    // Taxonomías
                    $filtros_activos = array(
                        'product_cat'   => 'Categorías',
                        'marca'         => 'Marcas',
                        'tipo_producto' => 'Tipo de Producto',
                        'presentacion'  => 'Presentación'
                    );

                    foreach ( $filtros_activos as $slug => $titulo ) {
                        $terminos = get_terms( array( 'taxonomy' => $slug, 'hide_empty' => true ) );

                        if ( ! empty( $terminos ) && ! is_wp_error( $terminos ) ) {
                            echo '<div class="mb-4">';
                            echo '<p class="fw-bold small mb-2 text-uppercase text-dark">' . esc_html( $titulo ) . '</p>';
                            
                            foreach ( $terminos as $term ) {
                                $checked = ( isset($_GET['f_'.$slug]) && in_array($term->slug, $_GET['f_'.$slug]) ) ? 'checked' : '';
                                ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input shadow-none cursor-pointer" type="checkbox" name="f_<?php echo esc_attr($slug); ?>[]" value="<?php echo esc_attr($term->slug); ?>" id="term_<?php echo esc_attr($term->term_id); ?>" <?php echo $checked; ?>>
                                    <label class="form-check-label small text-muted w-100 cursor-pointer" for="term_<?php echo esc_attr($term->term_id); ?>">
                                        <?php echo esc_html( $term->name ); ?> 
                                        <span class="badge bg-light text-dark float-end"><?php echo $term->count; ?></span>
                                    </label>
                                </div>
                                <?php
                            }
                            echo '</div>';
                        }
                    }
                    ?>

                    <?php
                    // 1. Consultamos a la Base de Datos el precio más bajo y el más alto de los productos publicados
                    global $wpdb;
                    $precios = $wpdb->get_row( "
                        SELECT MIN(meta_value + 0) as min_price, MAX(meta_value + 0) as max_price
                        FROM {$wpdb->postmeta} pm
                        INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                        WHERE pm.meta_key = '_price'
                        AND p.post_type = 'product'
                        AND p.post_status = 'publish'
                        AND pm.meta_value != ''
                    " );
                    
                    // 2. Si hay productos, extraemos los valores, sino por defecto 0 y 1000
                    $min_price = $precios->min_price ? floor( $precios->min_price ) : 0;
                    $max_price = $precios->max_price ? ceil( $precios->max_price ) : 1000;
                    
                    // 3. Valor actual que el usuario movió (o el máximo por defecto)
                    $current_max = ( isset($_GET['max_price']) && is_numeric($_GET['max_price']) ) ? esc_attr($_GET['max_price']) : $max_price;
                    ?>
                    
                    <div class="mb-4">
                        <p class="fw-bold small mb-2 text-uppercase text-dark">
                            Precio Máximo: $<span id="priceVal"><?php echo $current_max; ?></span>
                        </p>
                        <input type="range" class="form-range cursor-pointer" name="max_price" id="customRange" 
                               min="<?php echo $min_price; ?>" 
                               max="<?php echo $max_price; ?>" 
                               step="10" 
                               value="<?php echo $current_max; ?>" 
                               oninput="document.getElementById('priceVal').innerText = this.value">
                        <div class="d-flex justify-content-between small text-muted mt-1 fw-bold">
                            <span>$<?php echo $min_price; ?></span>
                            <span>$<?php echo $max_price; ?></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 fw-bold mb-2">Aplicar Filtros</button>
                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn btn-outline-secondary w-100 btn-sm">Limpiar todo</a>
                </form>
            </aside>

            <section class="col-lg-9">
                <?php
                if ( isset($_GET['busqueda']) && !empty($_GET['busqueda']) ) {
                    echo '<h4 class="mb-4 fw-bold">Resultados para: "<span class="text-primary">' . esc_html($_GET['busqueda']) . '</span>"</h4>';
                }
                ?>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    <?php
                    $args = array(
                        'post_type'      => 'product',
                        'posts_per_page' => 24,
                        'tax_query'      => array( 'relation' => 'AND' )
                    );

                    if ( isset($_GET['busqueda']) && !empty($_GET['busqueda']) ) {
                        $args['s'] = sanitize_text_field( $_GET['busqueda'] );
                    }

                    foreach ( $filtros_activos as $slug => $titulo ) {
                        if ( isset($_GET['f_'.$slug]) && is_array($_GET['f_'.$slug]) ) {
                            $args['tax_query'][] = array(
                                'taxonomy' => $slug,
                                'field'    => 'slug',
                                'terms'    => array_map( 'sanitize_text_field', $_GET['f_'.$slug] ),
                                'operator' => 'IN'
                            );
                        }
                    }

                    if ( isset($_GET['max_price']) && is_numeric($_GET['max_price']) ) {
                        $args['meta_query'] = array(
                            array(
                                'key'     => '_price',
                                'value'   => array( 0, (int) $_GET['max_price'] ),
                                'type'    => 'NUMERIC',
                                'compare' => 'BETWEEN'
                            )
                        );
                    }

                    $loop = new WP_Query( $args );

                    if ( $loop->have_posts() ) :
                        while ( $loop->have_posts() ) : $loop->the_post();
                            global $product;
                            ?>
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                    <div class="bg-white text-center p-3" style="height: 220px;">
                                        <?php echo $product->get_image('woocommerce_thumbnail', array('class' => 'img-fluid h-100 object-fit-contain')); ?>
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
                            </div>
                            <?php
                        endwhile;
                    else:
                        echo '<div class="col-12"><h4 class="text-muted text-center py-5">No se encontraron productos.</h4></div>';
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        </div>
    </main>

<?php wp_footer(); ?>
</body>
</html>