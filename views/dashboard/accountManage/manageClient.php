<div class="container">
    <?php implementComp("dashboard/aside.php") ?>

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Administrar clientes</h3>
            </div>
            <div class="container-divisor">
                <div class="interactions-container">
                    <div class="interactions-message">
                        <p id="interactions-welcomeText">Selecciona un cliente para ver su informacion de cuenta</p>
                    </div>
            
                    <div class="interactions-cardContainer">
                        <!-- Aqui van las cartas que contienen todas las interacciones del cliente -->
                    </div>
                </div>

                <div class="user-container">
                    <div class="infoCant-content">
                        <p id="p_totalCant"></p>
                    </div>
                    
                    <div class="card-container">
                        <!-- Aqui van las cartas que contienen toda la informacion del cliente -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php implementComp("error_toast.php") ?>
</div>