<div class="container">
    <?php include str_replace("\dashboard\\vehicles", "", __DIR__) .  "\componentes\dashboard\aside.php"; ?>

    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Agregar Vehiculo</h3>
            </div>


            <div class="errores">
                <?php
                if (isset($errores)) {
                    foreach ($errores as $key => $value) {
                        echo "<div class='error'>$value</div>";
                    }
                } ?>
            </div>

            <form action="/dashboard/agregar-vehiculo" method="POST" id="f_addvehicle">
                <input type="text" name="nombre" placeholder="Nombre">
                <textarea name="descripcion" placeholder="Descripcion"></textarea>
                <input type="text" name="modelo" placeholder="Modelo">
                <input type="text" name="fabricante" placeholder="Fabricante">
                <input type="text" name="año" placeholder="Año de fabricacion">
                <input type="text" name="color" placeholder="Color del vehiculo">
                <input type="text" name="matricula" placeholder="Matricula">
                <input type="text" name="numero_motor" placeholder="Numero serial del motor">
                <label>Tipo de transmision:</label>
                <select id="transmision" name="tipo_transmision">
                    <option value="none_selected" selected>-Seleccione-</option>
                    <option value="t_manual">Manual</option>
                    <option value="t_automatica">Automatica</option>
                    <option value="t_doble">Doble embreague</option>
                </select>
                <label>Tipo de carroceria:</label>
                <select id="carroceria" name="tipo_carroceria">
                    <option value="none_selected" selected></option>
                    <option value="c_coupe">Coupe</option>
                    <option value="c_sedan">Sedan</option>
                    <option value="c_hatchpack">Iparraguirre</option>
                    <option value="c_cabrio">Cabrio</option>
                </select>
                <label>Frenos ABS</label>
                <select id="sel_abs" name="FrenosABS">
                    <option value="none_selected" selected>-Seleccione-</option>
                    <option value="abs_si">Si</option>
                    <option value="abs_no">No</option>
                </select>
                <label>Airbag</label>
                <select id="sel_airbag" name="Airbag">
                    <option value="none_selected" selected>-Seleccione-</option>
                    <option value="airbag_si">Si</option>
                    <option value="airbag_no">No</option>
                </select>
                <input type="text" name="traccion" placeholder="Tipo de traccion">
                <input type="text" name="tipo_vidrio" placeholder="Tipo de vidrio">
                <input type="text" name="Direccion" placeholder="Tipo de direccion">
                <label>Control de estabilidad</label>
                <select id="sel_estabilidad" name="estabilidad">
                    <option value="none_selected" selected>-Seleccione-</option>
                    <option value="est_si">Si</option>
                    <option value="est_no">No</option>
                </select>
                <input type="text" name="puertas" placeholder="Numero de puertas">
                <input type="text" name="volumen_combustible" placeholder="Volumen del combustible">
                <input type="text" name="tipo_combustible" placeholder="Tipo de combustible">
                <input type="text" name="voltaje" placeholder="Voltaje del vehiculo">
                <label>Fecha de vencimiento del seguro</label>
                <input type="date" name="seguro">
                <input type="text" name="tipo_vehiculo" placeholder="Tipo del vehiculo">
                <input type="text" name="precio" placeholder="Precio del vehiculo">
                <input type="text" name="velocidad_max" placeholder="Velocidad maxima">
                <input type="text" name="zero_to_houndred" placeholder="De 0 a 100 km/h">
                <input type="text" name="pais" placeholder="Pais">
                <input type="text" name="stock" placeholder="Stock disponible">
                <input type="text" name="poliza_seguro" placeholder="Poliza de seguro">
                <input type="text" name="peso" placeholder="Peso del vehiculo">
                <input type="text" name="kilometros" placeholder="Kilometraje del vehiculo">
                <input type="text" name="caballos_fuerza" placeholder="Caballos de fuerza">
                <input type="submit" value="Registrar">
            </form>
        </div>
        <?php include str_replace("\dashboard\\vehicles", "", __DIR__) .  "\componentes\\footer.php";

        footer("dashboard-footer");
        ?>
    </div>
</div>

</div>
<!-- Falta: descripcion, titulo_imagen y imagen -->