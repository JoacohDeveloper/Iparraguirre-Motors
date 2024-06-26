<div class="container">
    <?php implementComp("dashboard\aside.php"); ?>
    <?php implementComp("error_toast.php") ?>
    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                
            </div>
            
            <h3>Agregar Vehiculo</h3>

<<<<<<< HEAD

            <div class="errores">
                <?php
                // if (isset($errores)) {
                //     foreach ($errores as $key => $value) {
                //         echo "<div class='error'>$value</div>";
                //     }
                // } 
                ?>
            </div>

            <form action="/dashboard/agregar-vehiculo" method="POST" id="f_addvehicle">
=======
            <form class="f_addvehicle">
            <div class="grid">
>>>>>>> origin/add-vehicle
                <input type="text" name="nombre" placeholder="Nombre">
                <textarea name="descripcion" placeholder="Descripcion"></textarea>
                <input type="text" name="modelo" placeholder="Modelo">
                <input type="text" name="fabricante" placeholder="Fabricante">
                <input type="text" name="year" placeholder="Año de fabricacion">
                <input type="text" name="color" placeholder="Color del vehiculo">
                <input type="text" name="matricula" placeholder="Matricula">

                <label>Tipo de transmision:</label>
                <select id="transmision" name="tipo_transmision">
                    <option value="" selected>-Seleccione-</option>
                    <option value="t_manual">Manual</option>
                    <option value="t_automatica">Automatica</option>
                    <option value="t_doble">Secuencial</option>
                </select>

                <label>Tipo de carroceria:</label>
                <select id="carroceria" name="tipo_carroceria">
                    <option value="" selected>-Seleccione-</option>
                    <option value="Coupe">Coupe</option>
                    <option value="Sedan">Sedan</option>
                    <option value="Hatchback">Hatchback</option>
                    <option value="Cabrio">Cabrio</option>
                    <option value="Pick-up">Pick-up</option>
                </select>

                <label>Frenos ABS</label>
                <select id="sel_abs" name="frenos_abs">
                    <option value="" selected>-Seleccione-</option>
                    <option value="abs_si">Si</option>
                    <option value="abs_no">No</option>
                </select>

                <label>Airbag</label>
                <select id="sel_airbag" name="airbag">
                    <option value="" selected>-Seleccione-</option>
                    <option value="airbag_si">Si</option>
                    <option value="airbag_no">No</option>
                </select>
            </div>
            <div class="grid">
                <label>Tipo de traccion:</label>
                <select id="traccion" name="traccion">
                    <option value="" selected>-Seleccione-</option>
                    <option value="t_integral">Integral</option>
                    <option value="t_trasera">Trasera</option>
                    <option value="t_delantera">Delantera</option>
                </select>

                <label>Tipo de direccion:</label>
                <select id="direccion" name="direccion">
                    <option value="" selected>-Seleccione-</option>
                    <option value="t_manual">Manual</option>
                    <option value="t_hidraulica">Hidraulica</option>
                    <option value="t_electrica">Electrica</option>
                </select>

                <label>Control de estabilidad</label>
                <select id="sel_estabilidad" name="control_estabilidad">
                    <option value="" selected>-Seleccione-</option>
                    <option value="est_si">Si</option>
                    <option value="est_no">No</option>
                </select>

                <label>Numero de puertas</label>
                <select id="num_puertas" name="puertas">
                    <option value="" selected>-Seleccione-</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>

                <input type="text" name="tipo_combustible" placeholder="Tipo de combustible">
                <input type="text" name="precio" placeholder="Precio del vehiculo">
                <input type="text" name="velocidad_max" placeholder="Velocidad maxima">
                <input type="text" name="zero_to_houndred" placeholder="De 0 a 100 km/h">
                <input type="text" name="pais" placeholder="Pais">
                <input type="text" name="peso" placeholder="Peso del vehiculo">
                <input type="text" name="kilometros" placeholder="Kilometraje del vehiculo">
                <input type="text" name="caballos_fuerza" placeholder="Caballos de fuerza">
            </div>
                <input id="submit" type="submit" value="Registrar">
            </form>
        </div>
        <?php implementComp("footer.php", ["class" => "dashboard-footer"]);
        ?>
    </div>
</div>

</div>
<!-- Falta: descripcion, titulo_imagen y imagen -->