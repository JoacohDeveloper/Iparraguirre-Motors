<header>
    <div class="header__top">
        <?php
        if (str_contains($url, "/results")) {
        ?>
            <div class="aside_header__logo">

                <a href="/tienda" class="logo">
                    <img src="/build/src/images/LOGO2.png" alt="Logo Iparraguirre Motors">
                </a>

            </div>
        <?php
        }
        ?>
        <a href="<?php echo str_contains($url, "/tienda") ? "/tienda" : "/" ?>" class="logo">
            <img src="/build/src/images/LOGO2.png" alt="Logo Iparraguirre Motors">
        </a>

        <div class="contenedor__header__buscador">
            <?php include "buscadorProductos.php"; ?>
            <?php include "navegacion.php"; ?>
        </div>
    </div>
    <div class="category">

        <div class="list__category">

            <div class="list-category__title">
                <p>Por Categoria</p>
                <img src="/build/src/images/chevronDown.svg" alt="desplegar categorias">
            </div>
        </div>

    </div>
</header>
</div>