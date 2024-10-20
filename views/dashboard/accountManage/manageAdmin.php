<div class="container">
    <?php implementComp("dashboard/aside.php") ?>

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Administrar empleados</h3>
            </div>
            <div class="container-divisor">
                <div class="add-container">
                    <div class="form-container">
                        <h3>Crear cuenta administrador</h3>
                        <p>Completa el siguiente formulario de registro<br>
                        para darle acceso a un nuevo empleado al dashboard</p>
                        <form id="regForm">
                        <label class="inputs_txt" id="fullname_txt">Fullname
                            <input class="inputs" type="text" name="full_name" placeholder="Nombre Completo" value="<?php echo $campos["full_name"] ?? "" ?>">
                        </label>
                        <label class="inputs_txt" id="documento_txt">Documento
                            <input class="inputs" type="text" name="username" placeholder="Cedula de identidad" value="<?php echo $campos["username"] ?? "" ?>">
                        </label>
                        <input id="boton" type="submit" value="Registrar">
                    </form>
                    </div>
                </div>

                <div class="user-container">
                    <div class="infoCant-content">
                        <p id="p_totalCant"></p>
                        <p id="p_cantMandated"></p>
                        <p id="p_cantEmployee"></p>
                    </div>
                    
                    <div class="card-container"></div>
                </div>
            </div>
        </div>
    </div>
    <?php implementComp("error_toast.php") ?>
</div>