<?php get_header(); ?>

    <style>
        /* ESTILOS MAESTROS PARA PÁGINAS (CARRITO / CHECKOUT) */
        .woocommerce .woocommerce-cart-form { background: #fff; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); margin-bottom: 2rem; }
        .woocommerce table.shop_table { border: none; border-collapse: separate; border-spacing: 0; width: 100%; }
        .woocommerce table.shop_table th { background-color: #f8f9fa; border: none; padding: 1rem; text-transform: uppercase; font-size: 0.85rem; color: #6c757d; }
        .woocommerce table.shop_table td { border-top: 1px solid #dee2e6; padding: 1.5rem 1rem; vertical-align: middle; }
        .woocommerce table.shop_table .product-thumbnail img { width: 80px !important; height: auto !important; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        
        /* REORDENAR COLUMNAS CARRITO */
        .woocommerce-cart-form__contents thead tr, .woocommerce-cart-form__contents tbody tr { display: flex !important; flex-wrap: wrap !important; align-items: center !important; }
        .woocommerce-cart-form__contents thead th, .woocommerce-cart-form__contents tbody td { flex: 1 1 0 !important; min-width: 100px !important; }
        .woocommerce-cart-form__contents thead th.product-thumbnail, .woocommerce-cart-form__contents tbody td.product-thumbnail { order: 1 !important; max-width: 100px !important;}
        .woocommerce-cart-form__contents thead th.product-name, .woocommerce-cart-form__contents tbody td.product-name { order: 2 !important;}
        .woocommerce-cart-form__contents thead th.product-price, .woocommerce-cart-form__contents tbody td.product-price { order: 3 !important;}
        .woocommerce-cart-form__contents thead th.product-quantity, .woocommerce-cart-form__contents tbody td.product-quantity { order: 4 !important;}
        .woocommerce-cart-form__contents thead th.product-subtotal, .woocommerce-cart-form__contents tbody td.product-subtotal { order: 5 !important;}
        .woocommerce-cart-form__contents thead th.product-remove, .woocommerce-cart-form__contents tbody td.product-remove { order: 99 !important; text-align: right !important; padding-right: 1.5rem !important; }

        /* TACHO DE BASURA CARRITO */
        .woocommerce table.shop_table a.remove { background: transparent !important; color: transparent !important; font-size: 0 !important; border: none !important; text-decoration: none !important; width: 32px !important; height: 32px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; }
        .woocommerce table.shop_table a.remove::before { content: "\F5DE" !important; font-family: "bootstrap-icons" !important; color: #dc3545 !important; font-size: 1.5rem !important; line-height: 1; display: block !important; transition: 0.2s !important; }
        .woocommerce table.shop_table a.remove:hover::before { color: #bb2d3b !important; transform: scale(1.1); }
        
        /* UI DEL SELECTOR DE CANTIDAD CARRITO */
        .woocommerce table.shop_table .quantity { display: flex !important; align-items: center !important; justify-content: center !important; border: 2px solid #0d6efd !important; border-radius: 6px !important; background: #fff !important; height: 40px !important; width: 120px !important; overflow: hidden !important; padding: 0 !important; margin: 0 auto !important; }
        .woocommerce table.shop_table .quantity .qty-btn { background: transparent !important; border: none !important; color: #0d6efd !important; font-size: 1.4rem !important; padding: 0 10px !important; cursor: pointer !important; height: 100% !important; display: flex !important; align-items: center !important; justify-content: center !important; }
        .woocommerce table.shop_table .quantity .qty-btn:hover { background: #e9ecef !important; }
        .woocommerce table.shop_table .quantity input.qty { width: 40px !important; border: none !important; text-align: center !important; font-weight: bold !important; font-size: 1.1rem !important; color: #212529 !important; padding: 0 !important; height: 100% !important; margin: 0 !important; -moz-appearance: textfield; }
        .woocommerce table.shop_table .quantity input.qty::-webkit-outer-spin-button, .woocommerce table.shop_table .quantity input.qty::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

        /* Totales, botones y alertas generales */
        .woocommerce .cart-collaterals .cart_totals { background: #fff; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); width: 100% !important; }
        .woocommerce button.button { background-color: #212529 !important; color: #fff !important; border-radius: 6px; padding: 0.75rem 1.5rem; font-weight: bold; transition: 0.3s; border: none; }
        .woocommerce button.button:hover { background-color: #495057 !important; transform: translateY(-2px); }
        .woocommerce-message, .woocommerce-error, .woocommerce-info { background-color: #d1e7dd; color: #0f5132; border: none; border-radius: 6px; padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: center; font-weight: bold; text-align: center; }
        .woocommerce-message::before { content: none; } 
        .woocommerce-message a.button.wc-forward { display: none !important; } 
        p.return-to-shop { text-align: center; margin-top: 2rem; margin-bottom: 3rem; }
        .return-to-shop a.button { display: inline-block !important; background-color: #0d6efd !important; color: #fff !important; padding: 0.75rem 2rem !important; border-radius: 6px !important; text-decoration: none !important; font-weight: bold !important; font-size: 1.1rem !important; }

        /* =================================================== */
        /* FIX DEFINITIVO: CHECKOUT Y FORMULARIOS */
        /* =================================================== */
        
        /* 1. Destruir los flotados antiguos de WooCommerce */
        .woocommerce-checkout #customer_details .col-1,
        .woocommerce-checkout #customer_details .col-2 {
            width: 100% !important; float: none !important; margin-bottom: 1rem !important;
        }

        /* 2. CSS Grid para dividir la pantalla solo en monitores grandes */
        @media (min-width: 992px) {
            .woocommerce-checkout form.checkout {
                display: grid !important;
                grid-template-columns: 55% 40% !important; /* Formulario ancho, resumen más angosto */
                gap: 5%;
                align-items: start;
            }
            .woocommerce-checkout #customer_details { grid-column: 1; grid-row: 1 / span 2; }
            .woocommerce-checkout #order_review_heading { grid-column: 2; grid-row: 1; margin-top: 0 !important; }
            .woocommerce-checkout #order_review { grid-column: 2; grid-row: 2; }
        }

        /* 3. Estilizar todos los Inputs y Selects */
        .woocommerce-checkout .form-row { margin-bottom: 1.5rem !important; }
        .woocommerce-checkout .form-row label { font-weight: 600 !important; margin-bottom: 0.5rem !important; display: block !important; color: #212529 !important; }
        .woocommerce-checkout .form-row input,
        .woocommerce-checkout .form-row select,
        .woocommerce-checkout .form-row textarea { 
            width: 100% !important; padding: 0.8rem !important; border: 2px solid #ced4da !important; 
            border-radius: 6px !important; background-color: #f8f9fa !important; color: #212529 !important;
            box-shadow: none !important; transition: 0.2s !important;
        }
        .woocommerce-checkout .form-row input:focus,
        .woocommerce-checkout .form-row select:focus,
        .woocommerce-checkout .form-row textarea:focus { 
            border-color: #0d6efd !important; background-color: #fff !important; outline: 0 !important; 
        }

        /* 4. Caja del Resumen del Pedido */
        .woocommerce-checkout #order_review { 
            background: #fff !important; padding: 2rem !important; 
            border-radius: 8px !important; border: 2px solid #dee2e6 !important; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
        }
        
        /* 5. EL BOTÓN REALIZAR PEDIDO (Forzado contra AJAX) */
        .woocommerce-checkout #payment #place_order {
            background-color: #0d6efd !important; color: #fff !important; width: 100% !important;
            padding: 1.2rem !important; border-radius: 6px !important; font-weight: bold !important;
            font-size: 1.2rem !important; text-transform: uppercase !important; border: none !important;
            transition: 0.3s !important; margin-top: 1.5rem !important; display: block !important;
        }
        .woocommerce-checkout #payment #place_order:hover { background-color: #0b5ed7 !important; transform: translateY(-2px); }
        
        /* Ajuste visual a los métodos de pago */
        .woocommerce-checkout #payment ul.payment_methods { background: transparent !important; border: none !important; padding: 0 !important; margin-bottom: 1.5rem !important; }
        .woocommerce-checkout #payment div.payment_box { background-color: #e9ecef !important; color: #495057 !important; border-radius: 6px !important; font-size: 0.9rem !important; }
        .woocommerce-checkout #payment div.payment_box::before { border-bottom-color: #e9ecef !important; }

    </style>

    <main class="container py-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-11">
                <?php while ( have_posts() ) : the_post(); ?>
                    <h2 class="fw-bold text-dark mb-4 border-bottom pb-3"><?php the_title(); ?></h2>
                    <div class="page-content">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

<?php wp_footer(); ?>

<script>
function initCustomCartQuantity() {
    const cartQtyInputs = document.querySelectorAll('.woocommerce-cart-form__contents .quantity input.qty');
    cartQtyInputs.forEach(input => {
        const qtyContainer = input.closest('.quantity');
        if (qtyContainer.querySelector('.qty-btn')) return;
        
        const btnMinus = document.createElement('button');
        btnMinus.type = 'button'; btnMinus.className = 'qty-btn'; btnMinus.innerText = '-';
        
        const btnPlus = document.createElement('button');
        btnPlus.type = 'button'; btnPlus.className = 'qty-btn'; btnPlus.innerText = '+';
        
        qtyContainer.insertBefore(btnMinus, input);
        qtyContainer.appendChild(btnPlus);

        btnMinus.addEventListener('click', () => {
            let val = parseFloat(input.value) || 0;
            let min = parseFloat(input.min) || 1;
            if (val > min) {
                input.value = val - 1;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });

        btnPlus.addEventListener('click', () => {
            let val = parseFloat(input.value) || 0;
            let max = parseFloat(input.max) || Infinity;
            if (val < max) {
                input.value = val + 1;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initCustomCartQuantity();
    let timeout;
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('qty')) {
            const updateCartButton = document.querySelector('button[name="update_cart"]');
            if (updateCartButton) { updateCartButton.removeAttribute('disabled'); }
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                if (updateCartButton) { updateCartButton.click(); }
            }, 500);
        }
    });
});

if (typeof jQuery !== 'undefined') {
    jQuery(document.body).on('updated_wc_div', function() {
        initCustomCartQuantity();
    });
}
</script>

</body>
</html>