<div class="container">
    <h1>Agregar vehiculo</h1>
    <form action="/tienda/index" method="POST" id="f_addvehicle" style="display:flex; flex-direction: column; max-width: 15rem; gap: 0.4rem;">
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="text" name="modelo" placeholder="Modelo">
        <input type="text" name="fabricante" placeholder="Fabricante">
        <input type="text" name="año" placeholder="Año de fabricacion">
        <input type="text" name="color" placeholder="Color del vehiculo">
        <input type="text" name="matricula" placeholder="Matricula">
        <input type="text" name="numero_motor" placeholder="Numero serial del motor">
        <label>Tipo de transmision:</label>
        <select id="transmision" name="Tipo_transmision">
            <option value="transmision_null"></option>
            <option value="t_manual">Manual</option>
            <option value="t_automatica">Automatica</option>
            <option value="t_doble">Doble embreague</option>
        </select>
        <input type="text" name="tipo_carroceria" placeholder="Tipo de carroceria">
        <label>Frenos ABS</label>
        <select id="sel_abs" name="FrenosABS">
            <option value="abs_null"></option>
            <option value="abs_si">Si</option>
            <option value="abs_no">No</option>
        </select>
        <label>Airbag</label>
        <select id="sel_airbag" name="Airbag">
            <option value="airbag_null"></option>
            <option value="airbag_si">Si</option>
            <option value="airbag_no">No</option>
        </select>
        <input type="text" name="traccion" placeholder="Tipo de traccion">
        <input type="text" name="tipo_vidrio" placeholder="Tipo de vidrio">
        <input type="text" name="Direccion" placeholder="Tipo de direccion">
        <label>Control de estabilidad</label>
        <select id="sel_estabilidad" name="estabilidad">
            <option value="est_null"></option>
            <option value="est_si">Si</option>
            <option value="est_no">No</option>
        </select>
        <input type="text" name="puertas" placeholder="Numero de puertas">
        <input type="text" name="volumen_combustible" placeholder="Volumen del combustible">
        <input type="text" name="tipo_combustible" placeholder="Tipo de combustible">
        <input type="text" name="base_combustible" placeholder="Base del combustible">
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

<!-- Falta: descripcion, titulo_imagen y imagen -->