<div class="container">
    <?php implementComp("dashboard\aside.php"); ?>
    <?php implementComp("error_toast.php") ?>
    <div class="dashboard-content">
        <div class="dashboard-fit">
            <div class="dashboard-title">
                <h3>Agregar Vehiculo</h3>
            </div>


            <form action="" class="f_addvehicle">
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
                    <option value="c_coupe">Coupe</option>
                    <option value="c_sedan">Sedan</option>
                    <option value="c_hatchback">Hatchback</option>
                    <option value="c_cabrio">Cabrio</option>
                    <option value="c_pickup">Pick-up</option>
                </select>

                <label>Frenos ABS</label>
                <select id="sel_abs" name="FrenosABS">
                    <option value="" selected>-Seleccione-</option>
                    <option value="abs_si">Si</option>
                    <option value="abs_no">No</option>
                </select>

                <label>Airbag</label>
                <select id="sel_airbag" name="Airbag">
                    <option value="" selected>-Seleccione-</option>
                    <option value="airbag_si">Si</option>
                    <option value="airbag_no">No</option>
                </select>

                <label>Tipo de traccion:</label>
                <select id="traccion" name="tipo_traccion">
                    <option value="" selected>-Seleccione-</option>
                    <option value="t_integral">Integral</option>
                    <option value="t_trasera">Trasera</option>
                    <option value="t_delantera">Delantera</option>
                </select>

                <label>Tipo de direccion:</label>
                <select id="direccion" name="tipo_direccion">
                    <option value="" selected>-Seleccione-</option>
                    <option value="t_manual">Manual</option>
                    <option value="t_hidraulica">Hidraulica</option>
                    <option value="t_electrica">Electrica</option>
                </select>

                <label>Control de estabilidad</label>
                <select id="sel_estabilidad" name="estabilidad">
                    <option value="" selected>-Seleccione-</option>
                    <option value="est_si">Si</option>
                    <option value="est_no">No</option>
                </select>

                <label>Numero de puertas</label>
                <select id="num_puertas" name="puertas">
                    <option value="" selected>-Seleccione-</option>
                    <option value="dos">2</option>
                    <option value="tres">3</option>
                    <option value="cuatro">4</option>
                    <option value="cinco">5</option>
                </select>

                <input type="text" name="tipo_combustible" placeholder="Tipo de combustible">

                <input type="text" name="precio" placeholder="Precio del vehiculo">
                <input type="text" name="velocidad_max" placeholder="Velocidad maxima">
                <input type="text" name="zero_to_houndred" placeholder="De 0 a 100 km/h">
                <input type="text" name="pais" placeholder="Pais">
                <input type="text" name="peso" placeholder="Peso del vehiculo">
                <input type="text" name="kilometros" placeholder="Kilometraje del vehiculo">
                <input type="text" name="caballos_fuerza" placeholder="Caballos de fuerza">
                <input type="submit" value="Registrar">
            </form>
        </div>
        <?php implementComp("footer.php", ["class" => "dashboard-footer"]);
        ?>
    </div>
</div>

</div>
<!-- Falta: descripcion, titulo_imagen y imagen -->