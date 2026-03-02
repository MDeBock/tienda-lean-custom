<?php get_header(); ?>

    <style>
        /* UI DEL CARRITO - MANTENEMOS TUS ESTILOS */
        .custom-cart-ui .stock { font-size: 0.9rem; color: #6c757d; font-weight: 600; margin-bottom: 8px; }
        .custom-cart-ui form.cart { display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
        .custom-cart-ui .quantity {
            display: flex; align-items: center; border: 2px solid #0d6efd; 
            border-radius: 6px; background: #fff; height: 45px; overflow: hidden; margin: 0;
        }
        .custom-cart-ui .quantity input.qty {
            width: 45px; border: none; text-align: center; font-weight: bold; 
            font-size: 1.1rem; color: #212529; -moz-appearance: textfield; padding: 0;
        }
        .custom-cart-ui .quantity input.qty::-webkit-outer-spin-button, 
        .custom-cart-ui .quantity input.qty::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .qty-btn {
            background: transparent; border: none; color: #0d6efd; font-size: 1.4rem; 
            padding: 0 15px; cursor: pointer; transition: 0.2s; height: 100%; display: flex; align-items: center; justify-content: center;
        }
        .qty-btn:hover { background: #e9ecef; }
        .custom-cart-ui .single_add_to_cart_button {
            background-color: #212529; color: #fff; border: none; padding: 0 24px; 
            height: 45px; border-radius: 6px; font-weight: bold; transition: 0.3s ease; 
            text-transform: uppercase; font-size: 0.9rem; margin: 0; white-space: nowrap;
        }
        .custom-cart-ui .single_add_to_cart_button:hover { background-color: #495057; transform: translateY(-2px); }
    </style>

    <main class="container mb-5">
        <?php while ( have_posts() ) : the_post(); global $product; ?>
            
            <div class="row bg-white p-4 p-md-5 rounded shadow-sm">
                
                <div class="col-md-6 mb-4 mb-md-0 text-center">
                    <div class="border rounded p-3" style="background-color: #f8f9fa;">
                        <?php echo $product->get_image('woocommerce_single', array('class' => 'img-fluid object-fit-contain', 'style' => 'max-height: 400px;')); ?>
                    </div>
                </div>

                <div class="col-md-6 d-flex flex-column justify-content-center ps-md-5">
                    
                    <div class="small text-muted mb-2">
                        <a href="<?php echo esc_url( home_url('/') ); ?>" class="text-decoration-none text-muted">Inicio</a> / 
                        <?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?>
                    </div>

                    <h1 class="fw-bold text-dark mb-3"><?php the_title(); ?></h1>
                    <p class="display-5 fw-bold text-success mb-4"><?php echo $product->get_price_html(); ?></p>
                    
                    <div class="text-muted mb-4 lead"><?php the_excerpt(); ?></div>

                    <ul class="list-unstyled mb-4 pb-4 border-bottom">
                        <?php if ( $marcas = wc_get_product_terms( $product->get_id(), 'marca', array('fields' => 'names') ) ) : ?>
                            <li><strong>Marca:</strong> <?php echo implode(', ', $marcas); ?></li>
                        <?php endif; ?>
                        <?php if ( $presentacion = wc_get_product_terms( $product->get_id(), 'presentacion', array('fields' => 'names') ) ) : ?>
                            <li><strong>Presentación:</strong> <?php echo implode(', ', $presentacion); ?></li>
                        <?php endif; ?>
                    </ul>

                    <div class="mt-auto custom-cart-ui">
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    </div>

                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 bg-white p-4 p-md-5 rounded shadow-sm">
                    <h4 class="fw-bold border-bottom pb-3 mb-4">Descripción Detallada</h4>
                    <div class="text-muted"><?php the_content(); ?></div>
                </div>
            </div>

        <?php endwhile; ?>
    </main>

    <?php wp_footer(); ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyDivs = document.querySelectorAll('.custom-cart-ui .quantity');
        
        qtyDivs.forEach(div => {
            const input = div.querySelector('input.qty');
            if(!input) return;

            const btnMinus = document.createElement('button');
            btnMinus.type = 'button'; btnMinus.className = 'qty-btn'; btnMinus.innerText = '-';
            
            const btnPlus = document.createElement('button');
            btnPlus.type = 'button'; btnPlus.className = 'qty-btn'; btnPlus.innerText = '+';
            
            div.insertBefore(btnMinus, input);
            div.appendChild(btnPlus);

            btnMinus.addEventListener('click', () => {
                let val = parseFloat(input.value) || 0;
                let min = parseFloat(input.min) || 1;
                if (val > min) { input.value = val - 1; }
            });

            btnPlus.addEventListener('click', () => {
                let val = parseFloat(input.value) || 0;
                let max = parseFloat(input.max) || Infinity;
                if (val < max) { input.value = val + 1; }
            });
        });
    });
    </script>
</body>
</html>