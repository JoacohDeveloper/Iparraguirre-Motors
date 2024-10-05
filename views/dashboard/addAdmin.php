<div class="container">
    <?php implementComp("dashboard/aside.php") ?>

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
            <h3>Agregar administrador</h3>
            </div>

            <div class="dashboard-info">
                <p>Completa el siguiente formulario de registro<br>
                para darle acceso a un nuevo empleado al dashboard</p>
            </div>

            <form id="regForm">
                <div>
                    <label class="inputs_txt" id="fullname_txt">Fullname</label>
                    <input class="inputs" type="text" name="full_name" placeholder="Nombre Completo" value="<?php echo $campos["full_name"] ?? "" ?>">
                    <div class="input-underline"></div>
                </div>
                <div>
                    <label class="inputs_txt" id="documento_txt">Documento</label>
                    <input class="inputs" type="text" name="username" placeholder="Cedula de identidad" value="<?php echo $campos["username"] ?? "" ?>">
                    <div class="input-underline"></div>
                </div>
                <input id="boton" type="submit" value="Registrar">
            </form>

        </div>
    </div>
    <?php implementComp("error_toast.php") ?>
</div>