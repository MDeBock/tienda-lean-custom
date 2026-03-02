Arquitectura y Personalización de E-Commerce (WooCommerce "Zero-Bloat")

Desarrollo y estructuración de una tienda online de alto rendimiento utilizando exclusivamente el núcleo gratuito de WooCommerce. El objetivo principal de este proyecto fue construir un sistema de comercio electrónico robusto, escalable y ágil, eliminando por completo la dependencia de plugins comerciales, constructores visuales pesados (como Elementor) y bloques prefabricados que ralentizan el servidor.

El Desafío y la Solución
El Desafío: Las tiendas online modernas suelen sufrir de “bloatware” (exceso de código y peticiones) debido a la instalación masiva de plugins de terceros para resolver lógicas de negocio básicas, sumado a la reciente imposición de bloques de Gutenberg en WooCommerce que limitan el control del DOM y perjudican la experiencia del usuario (UX).

La Solución: Se implementó una arquitectura "Zero-Bloat" basada en el Core de WooCommerce utilizando shortcodes clásicos. Todo el control estructural se recuperó mediante el uso intensivo de Action Hooks y Filters de PHP en el backend. En el frontend, se desarrolló una interfaz ligera y responsiva desde cero integrando Bootstrap 5, CSS moderno (Grid/Flexbox) y Vanilla JavaScript para manipular dinámicamente el comportamiento de la tienda sin recargar el servidor.

Stack Tecnológico
Core: WordPress, WooCommerce (Free Core)

Backend: PHP (Action Hooks, Filters), MySQL (Consultas directas a la BD)

Frontend: HTML5, CSS3 Custom, Vanilla JavaScript, Bootstrap 5 (CDN)

Enfoque: Bloat-free, Zero-Premium-Plugins, Custom DOM Manipulation

Características Principales y Lógica Implementada
Filtros Avanzados y Consultas SQL (Backend): Desarrollo de un sistema de filtrado lateral dinámico. Se incluyó un rango de precios inteligente alimentado por consultas SQL directas ($wpdb) que leen en tiempo real el valor mínimo y máximo exacto de los productos publicados, evitando rangos estáticos o irreales.

Control Total del Carrito y AJAX (Frontend): Interceptación de la recarga AJAX nativa de WooCommerce mediante Vanilla JavaScript. Se inyectaron controles de cantidad personalizados (+/-) y se rediseñó la tabla estructural del carrito utilizando CSS Flexbox para mejorar drásticamente la usabilidad móvil y de escritorio.

Optimización del Checkout (PHP & CSS Grid): Limpieza exhaustiva de campos de facturación innecesarios mediante el filtro woocommerce_checkout_fields para reducir la fricción en la compra. El diseño se reestructuró en dos columnas asimétricas mediante CSS Grid, desactivando los bloques de Gutenberg para garantizar la estabilidad del formulario frente a recargas asíncronas.

Gestión de Inventario Blindada: Implementación de funciones en el backend para forzar la activación y el guardado estricto del stock numérico de los productos, ocultando simultáneamente la interfaz compleja por defecto de WooCommerce en el panel de administración. Esto hace que la carga de productos sea "a prueba de errores" para el administrador final.

Desarrollo “Cost-Effective”: Arquitectura pensada para mantener los costos de infraestructura y licencias en $0, garantizando una tienda profesional, ultra rápida y segura utilizando exclusivamente código nativo y herramientas open-source.