<?php
/*
* author Joaquín Álvarez
* created on 29-07-2024-00h-30m
* github: https://github.com/JoacohDeveloper
*/
?>


<div class="container">
    <?php implementComp("dashboard/aside.php") ?>

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Products</h3>
            </div>

            <div class="contenedor-buscador">
                <div class="contenido-buscador">
                    <label for="id_product-search__input">Buscar</label>
                    <?php implementComp("dashboard/buscadorProductos.php") ?>
                </div>
            </div>

        </div>

        <div class="products-managment">
            <div class="card-container"></div>
        </div>
    </div>

    <?php implementComp("error_toast.php") ?>
</div>